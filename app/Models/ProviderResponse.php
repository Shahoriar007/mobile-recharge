<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderResponse extends Model
{
    use HasFactory;
    protected $fillable=[
        'code',
        'before_balance',
        'before_amount',
        'after_balance',
        'after_amount',
        'before_trans_code',
        'after_trans_code',
        'must_include',
        'feedback'
    ];
}
