<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'price',
        'cashback',
        'provider_id',
        'type',
    ];

    public function provider(){
        return $this->belongsTo(Provider::class, 'provider_id');
    }
}
