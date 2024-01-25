<?php

namespace App\Services;

use App\Models\Stock;
use App\Services\Contracts\ImportServiceInterface;
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Store;

class ImportWbService implements ImportServiceInterface
{
    private const URI = 'https://statistics-api.wildberries.ru/api/v1/supplier/stocks?dateFrom=';

    public function handle(string $dateFrom, Store $store)
    {
        $importList = $this->import($dateFrom, $store);

        $data = [];
        $count = 0;
        foreach ($importList as $importRow) {
            if ( Stock::query()
                ->where('nmId', $importRow->nmId)
                ->where('warehouseName', $importRow->warehouseName)
                ->whereDate('created_at', (new DateTimeImmutable())->format('Y-m-d'))
                ->exists()) continue;

            $count++;
            $importRow->storeId = $store->id;
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
        $preData['storeId'] = $importRow->storeId;
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

    private function import(string $dateFrom, Store $store): iterable
    {
        $response = Http::withHeaders([
            'Authorization' => $store->apiToken
        ])->get(self::URI . $dateFrom);

        $dataList = json_decode($response);

        foreach ($dataList as $data) {
            yield $data;
        }
    }

}
