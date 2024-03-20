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
            'slug' => ['required', 'string', 'max:255'],
            'feature_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'author_id' => ['nullable'],
            'published_at' => ['nullable', 'date'],

            //blog category id can be multiple

            'blog_category' => ['required', 'array'],
            'blog_category.*' => ['exists:blog_categories,id'],

            'blog_id' => 'required|exists:blogs,id'


        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'slug.required' => 'Slug is required',
            'blog_category_id.required' => 'Blog category is required',
        ];
    }
}
