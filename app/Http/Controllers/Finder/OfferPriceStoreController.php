<?php

namespace App\Http\Controllers\Finder;

use App\Http\Controllers\Controller;
use App\Models\GroupCalculatePrice;
use App\Models\Store;
use App\Services\OfferPriceStoreService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class OfferPriceStoreController extends Controller
{
    public function __invoke(Request $request, $storeId, $groupId): JsonResponse
    {
        $groupCalculate = GroupCalculatePrice::query()->find($groupId);
        $store = Store::query()->find($storeId);

        if($groupCalculate && $store) {
            $stockOffered = new OfferPriceStoreService($groupCalculate, $store);
            $stockOffered->makeOfferedPrice();
        } else {
            return response()->json(['messages' => 'errors']);
        }

        return response()->json();
    }
}
