<?php

namespace App\Services;

use App\Services\Contracts\ImportServiceInterface;

class ImportOzoneService implements ImportServiceInterface
{
    public function handle(string $dateFrom)
    {
        dd('ImportOzoneService');

        return '';
    }
}
