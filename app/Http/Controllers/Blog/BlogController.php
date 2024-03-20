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
use App\Models\Blog;

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

    public function createBlogView()
    {
        $breadcrumbs = [
            ['link' => "/blog", 'name' => "Blog"], ['name' => "Create"]
        ];

        $blogCategoryData = $this->repository->blogCategory();
        $authorData = $this->repository->author();

        return view('blog.blog.create-blog', compact('breadcrumbs', 'blogCategoryData', 'authorData'));
    }

    public function updateContentView($id)
    {
        $breadcrumbs = [
            ['link' => "/blog", 'name' => "Blog"], ['name' => "Update Content"]
        ];

        $contentData = $this->repository->updateContentView($id);

        return view('blog.blog.update-content', compact('breadcrumbs', 'contentData'));
    }



    public function storeBlog(StoreBlogRequest $request)
    {
        $validated = $request->validated();
        $data = $this->repository->storeBlog($validated, $request);

        $blogId = $data['id'];

        if ($data) {
            return redirect('/blog/update/' . $blogId);

        } else {
            return redirect()->route('blog')->with('error', 'Blog failed created.');
        }
    }

    public function createContentView(Request $id)
    {

        $breadcrumbs = [
            ['link' => "/blog", 'name' => "Blog"], ['name' => "Update"]
        ];

        return view('blog.blog.create-content');
    }

    public function storeContent(Request $request)
    {
        $data = $this->repository->storeContent($request);

        if ($data) {
            return redirect('/blog/seo/' . $data);

        } else {
            return redirect()->route('blog')->with('error', 'Blog failed created.');
        }
    }

    public function createSeoView($id)
    {
        $breadcrumbs = [
            ['link' => "/blog", 'name' => "Blog"], ['name' => "SEO"]
        ];

        return view('blog.blog.create-seo', compact('breadcrumbs'));

    }

    public function storeSeo(Request $request)
    {
        $data = $this->repository->storeSeo($request);

        if ($data) {
            return redirect()->route('blog')->with('success', 'Blog successfully created.');
        } else {
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

    public function update(UpdateBlogRequest $request)
    {
        $validated = $request->validated();

        $blog_id = $validated['blog_id'];

        $data = $this->repository->update($validated,  $request);

        if ($data) {
            return redirect('/blog/content/update/' . $data);
        } else {
            return redirect()->route('blog')->with('error', 'Blog failed updated.');
        }
    }

    public function updateContent(Request $request)
    {
        $data = $this->repository->updateContent($request);

        if ($data) {
            return redirect('/blog/seo/update/' . $data);
        } else {
            return redirect()->route('blog')->with('error', 'Blog failed updated.');
        }
    }

    public function updateSeoView($id)
    {
        $breadcrumbs = [
            ['link' => "/blog", 'name' => "Blog"], ['name' => "SEO"]
        ];

        $data = $this->repository->updateSeoView($id);

        $postLinkData = $this->repository->postLink($id);
        $postScriptData = $this->repository->postScript($id);

        return view('blog.blog.update-seo', compact('data', 'breadcrumbs', 'postLinkData', 'postScriptData'));
    }

    public function updateSeo(Request $request)
    {
        $data = $this->repository->updateSeo($request);

        if ($data) {
            return redirect()->route('blog')->with('success', 'Blog successfully updated.');
        } else {
            return redirect()->route('blog')->with('error', 'Blog failed updated.');
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->blog_id;

        $data = $this->repository->destroy($id);

        if ($data) {
            return redirect()->route('blog')->with('success', 'Blog successfully deleted.');
        } else {
            return redirect()->route('blog')->with('error', 'Blog failed deleted.');
        }
    }

    public function apiIndex(Request $request)
    {
        $data = $request->all();
        $data = $this->repository->apiIndex($request);

        return response()->json($data);
    }

    public function apiShow($slug)
    {
        $data = $this->repository->apiShow($slug);

        return response()->json($data);
    }



}
