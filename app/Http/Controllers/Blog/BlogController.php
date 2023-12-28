<?php

namespace App\Http\Controllers\Blog;

use League\Fractal\Manager;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use App\Http\Controllers\Controller;
use App\Transformers\BlogTransformer;
use League\Fractal\Resource\Collection;
use Illuminate\Support\Facades\Response;
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
            ['link' => "/blog", 'name' => "Blog"], ['name' => "Index"]
        ];

        $data = $this->repository->index();

        return view('blog.blog.index', compact('data', 'breadcrumbs'));
    }

    public function create()
    {
        $breadcrumbs = [
            ['link' => "/blog", 'name' => "Blog"], ['name' => "Create"]
        ];

        $blogCategoryData = $this->repository->blogCategory();
        $authorData = $this->repository->author();

        return view('blog.blog.create', compact('breadcrumbs', 'blogCategoryData', 'authorData'));
    }

    public function store(StoreBlogRequest $request)
    {
        $validated = $request->validated();

        $data = $this->repository->store($validated, $request);

        if($data){
            return redirect()->route('blog')->with('success', 'Blog successfully created.');
        }else{
            return redirect()->route('blog')->with('error', 'Blog failed created.');
        }

    }

    public function view($id)
    {
        $breadcrumbs = [
            ['link' => "/blog", 'name' => "Blog"], ['name' => "View"]
        ];

        $data = $this->repository->view($id);

        return view('blog.blog.view', compact('data', 'breadcrumbs'));
    }

    public function edit($id)
    {
        $breadcrumbs = [
            ['link' => "/blog", 'name' => "Blog"], ['name' => "Edit"]
        ];

        $data = $this->repository->edit($id);
        $blogCategoryData = $this->repository->blogCategory();
        $authorData = $this->repository->author();

        return view('blog.blog.edit', compact('data', 'breadcrumbs', 'blogCategoryData', 'authorData'));
    }

    public function update(UpdateBlogRequest $request, $id)
    {
        $validated = $request->validated();

        $data = $this->repository->update($validated, $id, $request);

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

    public function apiIndex(Request $request)
    {
        $data = $this->repository->apiIndex();

        if (!$data) {
            return response()->json([
                'data' => []
            ], 301);
        }

        $manager = new Manager();
        $resource = new Collection($data, new BlogTransformer());

        $transformedData = $manager->createData($resource)->toArray();

        return response()->json([
            'data' => $transformedData
        ], 301);

    }

    public function apiShow(Request $request, $id)
    {
        $data = $this->repository->apiShow($id);

        if (!$data) {
            return response()->json([
                'data' => []
            ]);
        }

        $manager = new Manager();
        $resource = new Item($data, new BlogTransformer());

        $transformedData = $manager->createData($resource)->toArray();

        return response()->json([
            'data' => $transformedData
        ]);
    }
}
