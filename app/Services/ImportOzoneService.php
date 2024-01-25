<?php

namespace App\Services;

use App\Services\Contracts\ImportServiceInterface;
use App\Models\Store;

class ImportOzoneService implements ImportServiceInterface
{
    public function handle(string $dateFrom, Store $store)
    {
        dd('ImportOzoneService');

        return '';
    }
}
