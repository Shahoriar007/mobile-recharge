<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Provider extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'length',
        'prefix',
        'category',
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
    public function products(){
        return $this->hasMany(Product::class, 'provider_id');
     }

     public function offers(){
        return $this->hasMany(Offer::class, 'provider_id');
     }

}
