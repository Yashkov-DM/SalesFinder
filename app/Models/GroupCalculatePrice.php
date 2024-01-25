<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupCalculatePrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'conditionId',
        'conditionValueFirst',
        'conditionValueSecond',
        'expressionId',
        'expressionValue',
        'quantityProduct',
        'active',
        'lastStartTime',
        'resultFieldName'
    ];
}
