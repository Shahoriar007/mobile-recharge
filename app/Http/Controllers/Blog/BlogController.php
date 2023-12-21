<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Blog\BlogRepository;
use App\Http\Requests\Blog\StoreBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;

class BlogController extends Controller
{
    private BlogRepository $repository;

    public function __construct(BlogRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $breadcrumbs = [
            ['link' => "admin/blog", 'name' => "Blog"], ['name' => "Index"]
        ];

        $data = $this->repository->index();

        return view('blog.blog.index', compact('data', 'breadcrumbs'));
    }

    public function create()
    {
        $breadcrumbs = [
            ['link' => "admin/blog", 'name' => "Blog"], ['name' => "Create"]
        ];

        $blogCategoryData = $this->repository->blogCategory();
        $authorData = $this->repository->author();

        return view('blog.blog.create', compact('breadcrumbs', 'blogCategoryData', 'authorData'));
    }

    public function store(StoreBlogRequest $request)
    {
        $validated = $request->validated();

        $data = $this->repository->store($validated);

        if($data){
            return redirect()->route('blog')->with('success', 'Blog successfully created.');
        }else{
            return redirect()->route('blog')->with('error', 'Blog failed created.');
        }

    }

    public function view($id)
    {
        $breadcrumbs = [
            ['link' => "admin/blog", 'name' => "Blog"], ['name' => "View"]
        ];

        $data = $this->repository->view($id);

        return view('blog.blog.view', compact('data', 'breadcrumbs'));
    }

    public function edit($id)
    {
        $breadcrumbs = [
            ['link' => "admin/blog", 'name' => "Blog"], ['name' => "Edit"]
        ];

        $data = $this->repository->edit($id);
        $blogCategoryData = $this->repository->blogCategory();
        $authorData = $this->repository->author();

        return view('blog.blog.edit', compact('data', 'breadcrumbs', 'blogCategoryData', 'authorData'));
    }

    public function update(UpdateBlogRequest $request, $id)
    {
        $validated = $request->validated();

        $data = $this->repository->update($validated, $id);

        if($data){
            return redirect()->route('blog')->with('success', 'Blog successfully updated.');
        }else{
            return redirect()->route('blog')->with('error', 'Blog failed updated.');
        }

    }

    public function destroy(Request $request)
    {
        $id = $request->blog_id;

        $data = $this->repository->destroy($id);

        if($data){
            return redirect()->route('blog')->with('success', 'Blog successfully deleted.');
        }else{
            return redirect()->route('blog')->with('error', 'Blog failed deleted.');
        }

    }
}
