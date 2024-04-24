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
    public function apiIndex(Request $request)
    {
        info($request->all());
        $category = $request['category'];
        $data = $this->repository->apiIndex($category);


        return response()->json($data);
    }

    public function apiShow($slug)
    {
        try {
            $data = $this->repository->apiShow($slug);

            if ($data->index_status == 1) {
                $indexStatus = "index";
            } else {
                $indexStatus = "no-index";
            }


            $websiteUrl = env('APP_URL');

            $fixedLink = [];
            // $fixedLink[] = [
            //     'key' => 'canonical',
            //     'value' => $websiteUrl . '/blog/' . $slug,
            // ];

            foreach ($data->postLinks as $link) {
                $fixedLink[] = [
                    'key' => $link->key,
                    'value' => $link->value,
                ];
            }




            $fixedScript = [];
            $fixedScript[] = [
                'type' => "application/ld+json",
                'script' => [
                    "@context"=> "https://schema.org",
                    "@type"=> "BlogPosting",
                    "mainEntityOfPage"=> [
                      "@type"=> "WebPage",
                      "@id"=> $websiteUrl.'/blog/'.$slug
                    ],
                    "headline"=> $data->title,
                    "description"=> $data->meta_description,
                    "image"=> (!empty($data->featured_image) ? asset($data->featured_image) : null),
                    "author"=> [
                      "@type"=> "Person",
                      "name"=> $data->authors->name,
                      "url"=> null,
                    ],
                    "publisher"=> [
                      "@type"=> "Organization",
                      "name"=> "VISER X",
                      "logo"=> [
                        "@type"=> "ImageObject",
                        "url"=> "https://viserx.com/wp-content/uploads/2021/10/VISER-X-New.png"
                      ]
                    ],
                    "datePublished"=> $data->published_at,
                    "dateModified"=> $data->updated_at,
            ],
            ];

            foreach ( $data->postScripts as $script) {
                $fixedScript[]= [
                    'type' => $script->type,
                    'script' => $script->script,
                ];
            }

            return response()->json([

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
                            'url' => !empty($data->featured_image) ? asset($data->featured_image) : null,
                            'width' => 800,
                            'height' => 600,
                            'alt' => "Blog Post",
                        ],
                    ],
                    'links' => $fixedLink,
                    'scripts' => $fixedScript,

                ],
                'blog' => [
                    'title' => $data->title ?? null,
                    'author' => $data->authors->name ?? null,
                    'published_at' => $data->published_at ?? null,
                    'featured_image_url' => !empty($data->featured_image) ? asset($data->featured_image) : null,
                    'categories' => $data->blogCategories->map(function ($category) {
                        return [
                            'id' => $category->id,
                            'title' => $category->name,
                        ];
                    })->toArray(),
                    'contents' => $data->contents->map(function ($content) {
                        return [
                            'id' => $content->id,
                            'title' => $content->title,
                            'description' => $content->description,
                        ];
                    })->toArray(),
                ],


            ], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Blog not found'
                ],
                404
            );
        }
    }

    public function apiAllBlogSlugs()
    {
        $data = $this->repository->apiAllBlogSlugs();

        return response()->json($data);
    }

    //subscription

    public function subscription(Request $request)
    {
        info($request->all());
    }
}
