<?php

namespace App\Services\Contracts;

use App\Models\Store;

interface ImportServiceInterface
{
    public function handle(string $dateFrom, Store $store);
}
