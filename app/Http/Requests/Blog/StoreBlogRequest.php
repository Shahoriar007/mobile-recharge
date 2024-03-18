<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
            'slug' => ['required', 'string', 'max:255'],
            'blog_category_id' => ['required', 'exists:blog_categories,id'],
            'feature_picture' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'content' => ['required', 'string'],

            'author' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'url'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_url' => ['nullable', 'url'],
            'meta_publish_date' => ['nullable', 'date'],
            'schema_markup' => ['nullable', 'string'],
            'custom_code' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'slug.required' => 'Slug is required',
            'blog_category_id.required' => 'Blog category is required',
            'feature_picture.required' => 'Featured image is required',
            'content.required' => 'Content is required',
        ];
    }
}
