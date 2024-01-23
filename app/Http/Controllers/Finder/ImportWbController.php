<?php

namespace App\Http\Controllers\Finder;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Services\Contracts\ImportServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        ]);

        if(!$validated->fails()) {
            $this->importService->handle($validated->getData()['dateFrom']);
        } else {
            return response()->json(['messages' => $validated->errors()->getMessages()]);
        }

        $stockList = Stock::query()->paginate(15);

        return response()->json($stockList->toJson(JSON_UNESCAPED_UNICODE));
    }
}

