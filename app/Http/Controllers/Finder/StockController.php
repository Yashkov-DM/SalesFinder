<?php

namespace App\Http\Controllers\Finder;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class StockController extends Controller
{
   public function index(Request $request): JsonResponse
   {
       $validated = Validator::make($request->all(), [
           'perPage' => ['required', 'integer'],
           'page' => ['required', 'integer']
       ]);

       if(!$validated->fails()) {
           $stockList = Stock::query()->paginate($validated->getData()['perPage'], page: $validated->getData()['page']);
       } else {
           return response()->json(['messages' => $validated->errors()->getMessages()]);
       }

       return response()->json($stockList->toJson(JSON_UNESCAPED_UNICODE));
   }
}
