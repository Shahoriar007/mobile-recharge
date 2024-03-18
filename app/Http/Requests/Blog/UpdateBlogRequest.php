<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
{
     /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [


            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'slug_url' => ['nullable', 'string', 'max:225'],
            'read_time' => ['nullable', 'string', 'max:255'],
            'author_id' => ['nullable', 'exists:users,id'],
            'published_at' => ['nullable', 'date'],

            'index_status' => ['nullable', 'in:index,not_index'],
            'canonical_url' => ['nullable', 'url'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_url' => ['nullable', 'url'],
            'meta_publish_date' => ['nullable', 'date'],
            'schema_markup' => ['nullable', 'string'],
            'custom_code' => ['nullable', 'string'],


        ];
    }
}
