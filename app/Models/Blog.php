<?php

namespace App\Models;

use App\Models\User;
use App\Traits\CreatedBy;
use App\Traits\DeletedBy;
use App\Traits\UpdatedBy;
use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;
    use CreatedBy;
    use UpdatedBy;
    use DeletedBy;

    protected $fillable = [
        'title',
        'read_time',
        'feature_picture',
        'slug',
        'slug_url',
        'description',
        'blog_category_id',
        'author_id',
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

    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
}
