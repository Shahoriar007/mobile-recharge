<?php

namespace App\Http\Controllers\Blog;

use App\Transformers\BlogTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Blog\BlogRepository;
use App\Http\Requests\Blog\StoreBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Models\Blog;
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
        $category = $request['category'];
        $data = $this->repository->apiIndex($category);


        return response()->json($data);
    }

    function slugify($str) {
    // Remove leading and trailing whitespace
    $str = trim($str);

    // Convert to lowercase
    $str = strtolower($str);

    // Replace non-alphanumeric characters (except spaces and hyphens) with a single space
    $str = preg_replace('/[^a-z0-9 -]/', '', $str);

    // Replace consecutive spaces or hyphens with a single hyphen
    $str = preg_replace('/\s+/', '-', $str);
    $str = preg_replace('/-+/', '-', $str);

    // Trim any leading or trailing hyphens
    $str = trim($str, '-');

    return $str;
}

    public function apiShow($category, $slug )
    {
        try {
            $category = str_replace('-', ' ', $category);
            $category = ucwords($category);
            $data = $this->repository->apiShow($category, $slug);

            if (empty($data))
            {
                return null;
            }

            if ($data->index_status == 1) {
                $indexStatus = "index";
            } else {
                $indexStatus = "no-index";
            }


            $frontendUrl = env('FRONTEND_URL');

            $fixedLink = [];
            $fixedLink[] = [
                'key' => 'canonical',
                'value' => $frontendUrl . '/blog/' . $this->slugify($data->blogCategories[0]->name) . '/' .  $slug,
            ];

            foreach ($data->postLinks as $link) {
                $fixedLink[] = [
                    'key' => $link->key,
                    'value' => $link->value,
                ];
            }

            $fixedScript = [];
            $fixedScript[] = [
                'type' => "application/ld+json",
                'script' => json_encode([
                    "@context" => "https://schema.org",
                    "@type" => "BlogPosting",
                    "mainEntityOfPage" => [
                        "@type" => "WebPage",
                        "@id" => $frontendUrl . '/blog/' . $slug
                    ],
                    "headline" => $data->title,
                    "description" => $data->meta_description,
                    "image" => (!empty($data->featured_image) ? asset($data->featured_image) : null),
                    "author" => [
                        "@type" => "Person",
                        "name" => $data->authors->name,
                        "url" => null,
                    ],
                    "publisher" => [
                        "@type" => "Organization",
                        "name" => "VISER X",
                    ],
                    "datePublished" => $data->published_at,
                    "dateModified" => $data->updated_at,
                ])
            ];


            foreach ($data->postScripts as $script) {
                $fixedScript[] = [
                    'type' => $script->type,
                    'script' => $script->script,
                ];
            }

            return response()->json([

                'seo' => [
                    'title' => $data->meta_title ? str_replace("%currentyear%", date("Y"), $data->meta_title) : null,
                    'description' => $data->meta_description ?? null,
                    'robots' => $indexStatus,
                    'openGraph' => [
                        'type' => "website",
                        'locale' => "en_IE",
                        'url' => $frontendUrl . '/blog/' . $slug,
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
            return null;
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

    public function apiSiteMap()
    {
        $frontendUrl = env('FRONTEND_URL');

        $blogs = Blog::get();

        $data = [
            [
                'loc' => $frontendUrl . '/',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.9'
            ],
            [
                'loc' => $frontendUrl . '/services',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => $frontendUrl . '/services/software',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ],
            [
                'loc' => $frontendUrl . '/services/software/erp',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.5'
            ],
            [
                'loc' => $frontendUrl . '/services/software/ecommerce',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.5'
            ],
            [
                'loc' => $frontendUrl . '/services/software/project-management',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.5'
            ],
            [
                'loc' => $frontendUrl . '/services/software/crm',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.5'
            ],
            [
                'loc' => $frontendUrl . '/services/software/hr-management',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.5'
            ],
            [
                'loc' => $frontendUrl . '/services/software/accounting-finance',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.5'
            ],
            [
                'loc' => $frontendUrl . '/services/software/payroll-management',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.5'
            ],
            [
                'loc' => $frontendUrl . '/services/software/mobile-app',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.5'
            ],
            [
                'loc' => $frontendUrl . '/services/web-development',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => $frontendUrl . '/services/web-development/website-development',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/web-development/ecommerce-website-development',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/web-development/website-speed-optimization',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/web-development/website-maintenance',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/digital-marketing/seo',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => $frontendUrl . '/services/digital-marketing/seo/seo-services',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/digital-marketing/seo/ecommerce-seo',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/digital-marketing/seo/local-seo',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/digital-marketing/seo/guest-post',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/digital-marketing/seo/seo-audit',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/digital-marketing/seo/google-business-profile-optimization',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/digital-marketing/seo/app-store-optimization',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/digital-marketing',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => $frontendUrl . '/services/digital-marketing/media-buying',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/digital-marketing/social-media-management',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/digital-marketing/online-reputation-management',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/digital-marketing/media-buying/facebook-ads-management',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/digital-marketing/media-buying/google-ads-management',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/digital-marketing/media-buying/youtube-ads-management',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/digital-marketing/media-buying/linkedIn-ads-management',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/creative-content',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/creative-content/content-writing',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/creative-content/video-production',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/creative-content/social-media-content-creation',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/creative-design',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/creative-design/ui-ux-design',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/creative-design/graphic-design',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/services/creative-design/motion-graphic',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/industries',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/industries/software',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/industries/education',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/industries/finance',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/industries/ecommerce',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/industries/banking',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/industries/real-state',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/industries/legal',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/industries/travel',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $frontendUrl . '/blog',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.9'
            ],
            [
                'loc' => $frontendUrl . '/about',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.9'
            ],
            [
                'loc' => $frontendUrl . '/media',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.9'
            ],
            [
                'loc' => $frontendUrl . '/career',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.9'
            ],
            [
                'loc' => $frontendUrl . '/life-at-viserx',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.9'
            ],
            [
                'loc' => $frontendUrl . '/contact-us',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.9'
            ],
            [
                'loc' => $frontendUrl . '/privacy-policy',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.9'
            ],
            [
                'loc' => $frontendUrl . '/testimonials',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.9'
            ],
            [
                'loc' => $frontendUrl . '/refund-policy',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.9'
            ],
            [
                'loc' => $frontendUrl . '/cookie-policy',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.9'
            ],
            [
                'loc' => $frontendUrl . '/seo-service-company-in-bangladesh',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.9'
            ],
            [
                'loc' => $frontendUrl . '/seo-services-in-dubai',
                'lastmod' => '2024-04-07',
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
        ];

        foreach ($blogs as $blog) {

            $category = strtolower($blog->blogCategories[0]->name);
            $category = str_replace(' ', '-', $category);
            $category = preg_replace('/[^a-z0-9\-]/', '', $category);
            $category = preg_replace('/-+/', '-', $category);
            $category = trim($category, '-');


            $data[] = [
                'loc' => $frontendUrl . '/blog/' . $category . '/' . $blog->slug,
                'lastmod' => $blog->updated_at,
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ];
        };

        return response()->json($data);
    }
}
