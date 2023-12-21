<?php

namespace App\Models;

use App\Traits\CreatedBy;
use App\Traits\DeletedBy;
use App\Traits\UpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class BlogCategory extends Model
{
    use HasFactory;
    use CreatedBy;
    use UpdatedBy;
    use DeletedBy;

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
