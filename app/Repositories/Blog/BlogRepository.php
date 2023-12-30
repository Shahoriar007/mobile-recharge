<?php

namespace App\Repositories\Blog;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Storage;

class BlogRepository
{

    private Blog $model;
    private BlogCategory $blogCategory;
    private User $author;

    public function __construct(Blog $model, BlogCategory $blogCategory, User $author)
    {
        $this->model = $model;
        $this->blogCategory = $blogCategory;
        $this->author = $author;
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

    public function store(array $validated, $request): bool
    {
        try {
            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['title'], '-');
            }

            if (empty($validated['author_id'])) {
                $validated['author_id'] = auth()->user()->id;
            }

            if ($request->hasFile('feature_picture')) {
                $image = $request->file('feature_picture');

                $filename = uniqid() . '.' . $image->getClientOriginalExtension();

                Storage::putFileAs('public/blogs/images', $image, $filename);

                $validated['feature_picture'] = 'storage/blogs/images/' . $filename;
            }

            $this->model->create($validated);

            return true;
        } catch (\Exception $e) {
            info($e->getMessage());
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

    public function apiIndex()
    {

        try {
            $data = $this->model->latest('created_at')->get();
            return $data;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function apiShow($id)
    {

        try {
            $data = $this->findById($id);
            return $data;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }
}
