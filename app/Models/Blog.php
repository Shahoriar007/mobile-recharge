<?php

namespace App\Models;

use App\Traits\CreatedBy;
use App\Traits\DeletedBy;
use App\Traits\UpdatedBy;
use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, CreatedBy, UpdatedBy, DeletedBy, SoftDeletes;

    protected $fillable = [
        // blog features
        'title',
        'slug',
        'featured_image',
        'author',
        'published_at',

        // seo features
        'index_status',
        'canonical_url',
        'meta_title',
        'meta_description',
        'meta_url',
        'meta_publish_date',
        'schema_markup',
        'custom_code',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // append featured_image_url attribute
    protected $appends = ['featured_image_url'];

    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image ? asset($this->featured_image) : null;
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
