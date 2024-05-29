<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable =[
        'regi_charge',
        'regi_bonus',
        'regi_cashback',
        'trans_charge',
        'trans_bonus',
        'charge_free_trans',
        'daily_charge',
        'daily_bonus',
        'refer_plan',
        'stock_limit',
        'withdraw_limit',
        'offline_requ',
    ];
}
