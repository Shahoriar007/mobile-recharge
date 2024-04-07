<?php

namespace App\Http\Controllers\Blog;

use App\Transformers\BlogTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Blog\BlogRepository;
use App\Http\Requests\Blog\StoreBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use League\Fractal\Resource\Item;
use League\Fractal\Manager;

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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiIndex()
    {
        $data = $this->repository->apiIndex();

        return response()->json($data);
    }

    public function apiShow($slug)
    {
        try {
            $data = $this->repository->apiShow($slug);

            // info($data);

            if ($data->index_status = 1)
            {
                $indexStatus = "index";
            }else{
                $indexStatus = "no-index";
            }

            $websiteUrl = "https://viserx.com";



            return response()->json([
                'blog' => [
                    'seo' => [
                        'title' => $data->meta_title ?? null,
                        'description' => $data->meta_description ?? null,
                        'robots' => $indexStatus,
                        'openGraph' => [
                            'type' => "website",
                            'locale' => "en_IE",
                            'url' => $websiteUrl,
                            'site_name' => "VISER X",
                            'image' => [
                                'url' => $websiteUrl.$data->featured_image ?? null,
                                'width' => 800,
                                'height' => 600,
                                'alt' => "Blog Post",
                            ],
                        ],
                        'links' => is_array($data->post_links) && !empty($data->post_links) ? array_map(function($link) {
                            return [
                                'key' => $link->key,
                                'value' => $link->value,
                            ];
                        }, $data->post_links) : [],
                        'scripts' => is_array($data->post_scripts) && !empty($data->post_scripts) ? array_map(function($script) {
                            return [
                                'type' => $script->type,
                                'script' => $script->script,
                                '@type' => 'Organization',
                                'name' => 'VISER X Limited',
                                'alternateName' => 'VISER X',
                                'url' => 'https://viserx.com/',
                                'logo' => 'https://viserx.com/wp-content/uploads/2021/10/VISER-X-New.png',
                            ];
                        }, $data->post_scripts) : [],
                    ],
                    'blog' => [
                        'title' => $data->title ?? null,
                        'author' => $data->authors->name ?? null,
                        'published_at' => $data->published_at ?? null,
                        'featured_image_url' => $websiteUrl.$data->featured_image ?? null,
                        'categories' => is_array($data->blog_categories) && !empty($data->blog_categories) ? array_map(function($category) {
                            return [
                                'id' => $category->id,
                                'title' => $category->name,
                            ];
                        }, $data->blog_categories) : [],
                        'contents' => is_array($data->contents) && !empty($data->contents) ? array_map(function($content) {
                            return [
                                'id' => $content->id,
                                'title' => $content->title,
                                'description' => $content->description,
                            ];
                        }, $data->contents) : [],
                    ],
                ]

            ], 200);



        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Blog not found'
                ],
                404
            );
        }


    }

    //subscription

    public function subscription(Request $request)
    {
        info($request->all());

    }



}
