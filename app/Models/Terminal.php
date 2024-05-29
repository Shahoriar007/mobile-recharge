<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'user',
        'password',
        'amount',
        'category',
        'status',
        'provider_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    public function provider(){
        return $this->belongsTo(Provider::class, 'provider_id');
     }


}
