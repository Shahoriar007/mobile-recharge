<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceBonus extends Model
{
    use HasFactory;
    protected $fillable = [
        'balance_id',
        'package_id',
        'charge',
        'commission'
    ];
    public function package(){
        return $this->belongsTo(Package::class);

    }
}
