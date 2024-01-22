<?php

namespace App\Http\Controllers\Finder;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Services\Contracts\ImportServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use JsonSerializable;
use Symfony\Component\HttpFoundation\JsonResponse;

class ImportWbController extends Controller
{
    public function __construct(
        protected ImportServiceInterface $importService,
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'dateFrom' => ['required', 'date_format:Y-m-d'],
            'perPage' => ['required', 'integer'],
            'page' => ['required', 'integer']
        ]);

        if(!$validated->fails()) {
            $this->importService->handle($validated->getData()['dateFrom']);
        } else {
            return response()->json(['messages' => $validated->errors()->getMessages()]);
        }

        $stockList = Stock::query()->paginate($validated->getData()['perPage'], page: $validated->getData()['page']);

        return response()->json($stockList->toJson(JSON_UNESCAPED_UNICODE));
    }
}
