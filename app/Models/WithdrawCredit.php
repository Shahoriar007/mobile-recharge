<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawCredit extends Model
{
    use HasFactory;
    protected $fillable = [
        'method_id',
        'package_id',
        'charge',
        'commission'
    ];
}
