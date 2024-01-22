<?php

namespace App\Http\Controllers\Finder;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Services\OfferPriceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;

class OfferPriceController extends Controller
{
    public const OFFERED_RULES = ['staticRule', 'anotherRule'];

    public function __invoke(Request $request): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'offerRuleList.*' => ['required', Rule::in(self::OFFERED_RULES)],
            'stockList' => ['required', 'exists:stocks,nmId'],
        ]);

        if(!$validated->fails()) {
            $stockList = Stock::query()->whereIn('nmId', $validated->getData()['stockList'])->get();
            $stockOfferedList = [];

            foreach ($stockList as $stock) {
                $stockOffered = new OfferPriceService($stock);
                $stockOfferedList[] = $stockOffered->getStaticRule()->getAnotherRule();
            }
        } else {
            return response()->json(['messages' => $validated->errors()->getMessages()]);
        }

        return response()->json($stockOfferedList);
    }
}
