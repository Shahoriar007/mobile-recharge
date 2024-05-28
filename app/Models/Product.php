<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'min_amount',
        'max_amount',
        'provider',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

     public function provider(){
        return $this->belongsTo(Provider::class, 'provider_id');
     }
}
