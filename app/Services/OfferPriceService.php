<?php

namespace App\Services;

use App\Models\Stock;

class OfferPriceService
{
    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }

    public function getStaticRule()
    {
        if ((int) $this->stock->quantityFull <= 5) {
            $this->stock->Price += $this->stock->Price * 0.5;
        }

        return $this;
    }

    public function getAnotherRule()
    {
        $this->stock->Price = $this->stock->Price / 100;

        return $this;
    }
}
