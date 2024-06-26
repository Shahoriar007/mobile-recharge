<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'package_id',
        'commission',
        'charge'
    ];
    public function package(){
        return $this->belongsTo(Package::class, 'package_id');

    }

}