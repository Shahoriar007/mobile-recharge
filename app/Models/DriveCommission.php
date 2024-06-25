<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriveCommission extends Model
{
    use HasFactory;
    protected $fillable = [
        'drive_id',
        'package_id',
        'charge',
        'commission'
    ];
}
