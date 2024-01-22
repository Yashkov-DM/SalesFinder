<?php

namespace App\Services\Contracts;

interface ImportServiceInterface
{
    public function handle(string $dateFrom);
}
