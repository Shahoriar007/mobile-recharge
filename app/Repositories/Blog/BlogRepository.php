<?php

namespace App\Repositories\Blog;

use App\Models\Blog;
use App\Models\User;
use App\Models\Author;
use App\Models\Content;
use App\Models\PostLink;
use App\Models\PostScript;
use Illuminate\Support\Str;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BlogRepository
{

    private Blog $model;
    private BlogCategory $blogCategory;
    private Author $author;
    private Content $content;
    private PostLink $postLink;
    private PostScript $postScript;

    public function __construct(Blog $model, BlogCategory $blogCategory, Author $author, Content $content, PostLink $postLink, PostScript $postScript)
    {
        $this->model = $model;
        $this->blogCategory = $blogCategory;
        $this->author = $author;
        $this->content = $content;
        $this->postLink = $postLink;
        $this->postScript = $postScript;
    }


    /**
     * @return array
     */

    public function index()
    {

        try {
            $data = $this->model->latest('created_at')->paginate(10);
            return $data;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function blogCategory()
    {

        try {
            $blogCategory = $this->blogCategory->all();
            return $blogCategory;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function author()
    {

        try {
            $authors = $this->author->all();
            return $authors;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    /**
     * @param $validated
     * @return bool
     */

    public function storeBlog(array $validated, $request)
    {
        try {
            $newBlog = null;

            DB::transaction(function () use ($validated, $request, &$newBlog) {
                if ($request->hasFile('feature_picture')) {
                    $image = $request->file('feature_picture');
                    $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                    Storage::putFileAs('public/blogs/images', $image, $filename);
                    $validated['featured_image'] = 'storage/blogs/images/' . $filename;
                }

                $validated['index_status'] = $validated == 'on' ? 1 : 2;

                $this->model->create($validated);

                //category sync
                $blog = $this->model->latest('created_at')->first();
                $newBlog = $blog;
                $blog->blogCategories()->sync($validated['blog_category']);
            });


            return $newBlog;
        } catch (\Exception $e) {
            info($e->getMessage());
            error_log($e->getMessage());
            return false;
        }
    }

    public function storeContent($request)
    {
        try {

            $contentTitles = $request->input('contentTitle');
            $descriptions = $request->input('description');
            $blogId = $request->input('blog_id');

            foreach ($contentTitles as $key => $title) {

                Content::create([
                    'title' => $title,
                    'description' => $descriptions[$key],
                    'blog_id' => $blogId
                ]);
            }

            return $blogId;

        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function blogUpdate($id)
    {

        try {
            $data = $this->findById($id);
            return $data;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function storeSeo($request)
    {
        try {

            DB::transaction(function () use ($request) {

                $blog = $this->findById($request->input('blog_id'));

                $blog->update([
                    'index_status' => $request->input('index_status') == 'on' ? 1 : 2,
                    'meta_title' => $request->input('meta_title'),
                    'meta_description' => $request->input('meta_description')
                ]);

                $postKeys = $request->input('post_key');
                $postValues = $request->input('post_value');


                foreach ($postKeys as $index => $postKey) {
                    $this->postLink->create([
                        'key' => $postKey,
                        'value' => $postValues[$index],
                        'blog_id' => $request->input('blog_id')
                    ]);

                }

                $type = $request->input('type');
                $script = $request->input('script');

                foreach ($type as $items => $type) {
                    $this->postScript->create([
                        'type' => $type,
                        'script' => $script[$items],
                        'blog_id' => $request->input('blog_id')
                    ]);
                }
            });

            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function updateContentUpdate($request)
    {
        try {
            $data = $this->model->latest('created_at')->first();
            $data->update($request->all());
            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * @param $id
     * @return bool
     */

    public function destroy($id): bool
    {

        try {
            $data = $this->findById($id);
            $data->delete();
            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * @param $id
     * @return mixed
     */

    public function findById($id)
    {

        try {
            $data = $this->model->findOrFail($id);
            return $data;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function view($id)
    {

        try {
            $data = $this->findById($id);
            return $data;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }


    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {

        try {
            $data = $this->findById($id);
            return $data;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    /**
     * @param $validated
     * @return bool
     */

    public function update($validated, $id, $request): bool
    {
        try {
            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['title'], '-');
            }

            if (empty($validated['author_id'])) {
                $validated['author_id'] = auth()->user()->id;
            }

            $data = $this->findById($id);

            if ($request->hasFile('feature_picture')) {

                $image = $request->file('feature_picture');
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                Storage::putFileAs('public/blogs/images', $image, $filename);
                $validated['feature_picture'] = 'storage/blogs/images/' . $filename;
            }

            $data->update($validated);

            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            info($e);
            return false;
        }
    }


    /**
     * @param $validated
     * @return bool
     */

    public function apiIndex($request)
    {
        try {
            $blogs = $this->model->latest('created_at')->with('blogCategory')->paginate(6);
            $categories = $this->blogCategory->all();
            $data = [
                'blogs' => $blogs,
                'categories' => $categories
            ];
            return $data;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function apiShow($slug)
    {
        try {
            $data = $this->model->where('slug', $slug)->with('blogCategory')->first();
            return $data;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }
}
