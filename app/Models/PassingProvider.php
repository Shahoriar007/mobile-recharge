<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassingProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'terminal_id',
        'provider_response_id',
        'format',
        'status'
    ];


}
