<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable =[
        'regi_charge',
        'regi_bonus',
        'regi_cashback',
        'trans_charge',
        'trans_bonus',
        'charge_free_trans',
        'daily_charge',
        'daily_bonus',
        'refer_plan',
        'stock_limit',
        'withdraw_limit',
        'offline_requ',
    ];

    public function productConfigs(){
        return $this->hasMany(ProductConfig::class, 'package_id');

    }
    public function addBalances(){
        return $this->hasMany(AddBalance::class, 'package_id');

    }
    public function withdrawCredits(){
        return $this->hasMany(WithdrawCredit::class, 'package_id');

    }
    public function driveCommissions(){
        return  $this->hasMany(DriveCommission::class, 'package_id');

    }
    public function balanceBonuses(){
        return $this->hasMany(BalanceBonus::class, 'package_id');

    }
}
