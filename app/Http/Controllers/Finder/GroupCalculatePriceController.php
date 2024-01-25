<?php

namespace App\Http\Controllers\Finder;

use App\Http\Controllers\Controller;
use App\Models\GroupCalculatePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Response;

class GroupCalculatePriceController extends Controller
{
   public function index(Request $request): JsonResponse
   {
       $validated = Validator::make($request->all(), [
           'perPage' => ['required', 'integer'],
           'page' => ['required', 'integer']
       ]);

       if(!$validated->fails()) {
           $groupList = GroupCalculatePrice::query()->paginate($validated->getData()['perPage'], page: $validated->getData()['page']);
       } else {
           return response()->json(['messages' => $validated->errors()->getMessages()]);
       }

       return response()->json($groupList->toJson(JSON_UNESCAPED_UNICODE));
   }

    public function store(Request $request): JsonResponse
    {
       $validated = Validator::make($request->all(), [
           'name' => ['required', 'string', 'max:50'],
           'conditionId' => ['required', 'integer', 'exists:conditions,id'],
           'conditionValueSecond' => ['integer'],
           'conditionValueFirst' => ['required', 'integer'],
           'expressionId' => ['required', 'integer', 'exists:expressions,id'],
           'expressionValue' => ['required', 'integer'],
           'resultFieldName' => ['required', 'string', 'max:50']
       ]);

       if(!$validated->fails()) {
           $stockList = GroupCalculatePrice::query()->create($validated->getData());
       } else {
           return response()->json(['messages' => $validated->errors()->getMessages()]);
       }

        return response()->json($stockList);
    }

    public function update(Request $request, $groupId): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'name' => ['required', 'max:50'],
            'conditionValueSecond' => ['integer'],
            'conditionValueFirst' => ['required', 'integer'],
            'expressionValue' => ['required', 'integer']
        ]);

        $groupCalculate = GroupCalculatePrice::query()->find($groupId);

        if(!$validated->fails() && $groupCalculate) {
            $stockList = $groupCalculate->query()->update($validated->getData());
        } else {
            return response()->json(['messages' => $validated->errors()->getMessages()]);
        }

        return response()->json($stockList);
    }

    public function destroy($groupId): JsonResponse
    {
        $result = GroupCalculatePrice::query()->where('id', $groupId)->delete();

        if ($result === -1) {
            response()->json(['messages' => 'error']);
        }

        return response()->json([
            'http_code' => Response::HTTP_OK,
            'message' => $groupId,
        ]);
    }
}
