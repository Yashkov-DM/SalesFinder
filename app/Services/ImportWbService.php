<?php

namespace App\Services;

use App\Models\Stock;
use App\Services\Contracts\ImportServiceInterface;
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ImportWbService implements ImportServiceInterface
{
    private const URI = 'https://statistics-api.wildberries.ru/api/v1/supplier/stocks?dateFrom=';
//    private const API_TOKEN = "eyJhbGciOiJFUzI1NiIsImtpZCI6IjIwMjMxMDI1djEiLCJ0eXAiOiJKV1QifQ.eyJlbnQiOjEsImV4cCI6MTcxNTcxNzkzMCwiaWQiOiI5NjhhN2U2Yi02NzczLTQzNWUtOGQyOS02YWExYTg3NTM0NzEiLCJpaWQiOjEyNzExNzAwLCJvaWQiOjg4OTI5NCwicyI6MTAwLCJzaWQiOiI3MGI4NTM3OC1iYzNjLTRlMDctOWRjMC1mNzIwYTIyNjIxNjQiLCJ1aWQiOjEyNzExNzAwfQ.NjSR5K7kLvifk0qMQMSW_qCnWf-cpdtLNsVN1mHbmITcRX9YN1s34wkHI-O-m7QLt_PMpdt_NaNE4yKnw9-UBA";
    private const API_TOKEN = "eyJhbGciOiJFUzI1NiIsImtpZCI6IjIwMjMxMjI1djEiLCJ0eXAiOiJKV1QifQ.eyJlbnQiOjEsImV4cCI6MTcyMTI1MjYzMCwiaWQiOiJkYmI4ZjE5YS1lMDg2LTQ3MzMtOTE0Ny1mYWU2NmM1OTM1NTgiLCJpaWQiOjE4NDA0MzIxLCJvaWQiOjc2MjUzLCJzIjozMiwic2lkIjoiZjYwMDVkNTYtZjAyMC01MmVhLTk0NjUtNWRiYTExZjEyYmE3IiwidCI6ZmFsc2UsInVpZCI6MTg0MDQzMjF9.0hSdZ7939Wbv6Tu6UuDYvkLZUxsqKf8r9-ctP_UYvFm3YnyrSsQm4goAQk1SD3pOzT86N_F8jvF4ioe-UB9rfQ";

    public function handle(string $dateFrom)
    {
        $importList = $this->import($dateFrom);

        $data = [];
        $count = 0;
        foreach ($importList as $importRow) {
            if ( Stock::query()
                ->where('nmId', $importRow->nmId)
                ->where('warehouseName', $importRow->warehouseName)
                ->whereDate('created_at', (new DateTimeImmutable())->format('Y-m-d'))
                ->exists()) continue;

            $count++;
            $data[] = $this->parse($importRow);

            if ($count >= 10) {
                DB::table('stocks')->insert($data);

                $count = 0;
                $data = [];
            }
        }

        if($data) {
            DB::table('stocks')->insert($data);
        }
    }

    private function parse($importRow): array
    {
        $preData['nmId'] = $importRow->nmId;
        $preData['supplierArticle'] = $importRow->supplierArticle;
        $preData['warehouseName'] = $importRow->warehouseName;
        $preData['category'] = $importRow->category;
        $preData['subject'] = $importRow->subject;
        $preData['quantityFull'] = $importRow->quantityFull;
        $preData['Price'] = $importRow->Price;
        $preData['Discount'] = $importRow->Discount;
        $preData['created_at'] = now();
        $preData['updated_at'] = now();

        return $preData;
    }

    private function import(string $dateFrom): iterable
    {
        $response = Http::withHeaders([
            'Authorization' => self::API_TOKEN
        ])->get(self::URI . $dateFrom);

        $dataList = json_decode($response);

        foreach ($dataList as $data) {
            yield $data;
        }
    }

}
