<?php

namespace App\Repositories\BlogCategories;

use App\Models\BlogCategory;

class BlogCategoryRepository
{

    private BlogCategory $model;

    public function __construct(BlogCategory $model)
    {
        $this->model = $model;
    }

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

    public function store($validated): bool
    {

        try {
            $this->model->create($validated);
            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function destroy($id)
    {
        info($id);

        try {
            $data = $this->findById($id);
            $data->delete();
            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

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
}
