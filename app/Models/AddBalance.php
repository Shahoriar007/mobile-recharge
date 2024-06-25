<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddBalance extends Model
{
    use HasFactory;
    protected $fillable = [
        'gateway_id',
        'package_id',
        'charge',
        'commission'
    ];
}
