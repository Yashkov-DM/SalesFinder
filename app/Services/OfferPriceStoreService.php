<?php

namespace App\Services;

use App\Models\Condition;
use App\Models\Expression;
use App\Models\GroupCalculatePrice;
use App\Models\Stock;
use App\Models\Store;

class OfferPriceStoreService
{
    public function __construct(GroupCalculatePrice $groupCalculate, Store $store)
    {
        $this->groupCalculate = $groupCalculate;
        $this->store = $store;
    }

    public function makeOfferedPrice(): string
    {
        $condition = Condition::query()->find($this->groupCalculate->conditionId);
        $conditionValueFirst = $this->groupCalculate->conditionValueFirst;
        $conditionValueSecond = $this->groupCalculate?->conditionValueSecond;

        $conditionRule = $this->conditionParse($condition, $conditionValueFirst, $conditionValueSecond);

        $expression = Expression::query()->find($this->groupCalculate->expressionId);
        $expressionValue = $this->groupCalculate->expressionValue;

        $stockList = Stock::query()->where('storeId', $this->store->id)->get(['id'])->pluck('id');

        $count = 0;
        foreach ($stockList as $stockId) {
            $count++;
            $stock = Stock::query()->find($stockId);

            if($this->conditionResult($conditionRule, $stock)) {
                $result = $this->expressionResult($expression, $expressionValue, $stock);

                Stock::query()->where('id', $stock->id)->update([
                    key($result) => $result[key($result)],
                    'groupCalcPriseId' => $this->groupCalculate->id
                ]);
            } else {
                Stock::query()->where('id', $stock->id)->update([
                    'offerPrice' => null,
                    'groupCalcPriseId' => $this->groupCalculate->id
                ]);
            }
        }

        $this->groupCalculate->query()->where('id', $this->groupCalculate->id)->update([
            'quantityProduct' => $count,
            'lastStartTime' => new \DateTimeImmutable()
        ]);

        return '';
    }

    private function conditionParse(Condition $condition, int $valueFirst, int $valueSecond=null): array
    {
        $regexp = "/([XA])([<>=])([AX])([<>=])?([B])?/";
        $match = [];
        $conditionRule = [];

        if(preg_match($regexp, $condition->template, $match)) {
            array_shift($match);

            array_map(function ($item) use (&$conditionRule, $condition, $valueFirst, $valueSecond) {
                match($item) {
                    'X' => $conditionRule['field'] = $condition->field,
                    'A' => $conditionRule['valueFirst'] = $valueFirst,
                    'B' => $conditionRule['valueSecond'] = $valueSecond,
                    '<', '>', '=' => $conditionRule['operator'] = $item,
                };
            }, $match);
        }

        return $conditionRule;
    }

    private function expressionResult(Expression $expression, int $expressionValue, Stock $stock): array
    {
        $stock = $stock->toArray();

        $result = match($expression->template) {
            'X + (X * A)/100' => $stock[$expression['field']] + ($stock[$expression['field']] * $expressionValue)/100,
            'X - (X * A)/100' => $stock[$expression['field']] - ($stock[$expression['field']] * $expressionValue)/100,
        };

        return ['offerPrice' => $result];
    }

    private function conditionResult(array $expression, Stock $stock): bool
    {
        $stock = $stock->toArray();

        if(isset($expression['valueSecond'])) {
            $result = match($expression['operator']) {
                '<' => $stock[$expression['field']] > $expression['valueFirst'] && $stock[$expression['field']] < $expression['valueSecond'],
            };
        } else {

            $result = match($expression['operator']) {
                '<' => $stock[$expression['field']] < $expression['valueFirst'],
                '>' => $stock[$expression['field']] > $expression['valueFirst'],
                '=' => $stock[$expression['field']] === $expression['valueFirst']
            };
        }

        return $result;

    }
}
