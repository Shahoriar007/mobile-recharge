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

    public function apiShow($slug)
    {
        try {
            $data = $this->repository->apiShow($slug);

            if ($data->index_status == 1) {
                $indexStatus = "index";
            } else {
                $indexStatus = "no-index";
            }


            $frontendUrl = env('FRONTEND_URL');

            $fixedLink = [];
            $fixedLink[] = [
                'key' => 'canonical',
                'value' => $frontendUrl . '/blog/' . $slug,
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
                    'title' => $data->meta_title ? str_replace("%currentyear%", date("Y"), $data->meta_title ) : null,
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

        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>
            <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        ';


        $sitemap .= '
        <url>
        <loc>'.$frontendUrl.'/</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/software</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/software/erp</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/software/ecommerce</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/software/project-management</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/software/crm</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/software/hr-management</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/software/accounting-finance</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/software/payroll-management</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/software/mobile-app</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/web-development</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/web-development/website-development</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/web-development/ecommerce-website-development</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/web-development/website-speed-optimization</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/web-development/website-maintenance</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/digital-marketing/seo</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/digital-marketing/seo/seo-services</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/digital-marketing/seo/ecommerce-seo</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/digital-marketing/seo/local-seo</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/digital-marketing/seo/guest-post</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/digital-marketing/seo/seo-audit</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/digital-marketing/seo/google-business-profile-optimization</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/digital-marketing/seo/app-store-optimization</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/digital-marketing</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/digital-marketing/media-buying</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/digital-marketing/social-media-management</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/digital-marketing/online-reputation-management</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/digital-marketing/media-buying/facebook-ads-management</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/digital-marketing/media-buying/google-ads-management</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/digital-marketing/media-buying/youtube-ads-management</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/digital-marketing/media-buying/linkedIn-ads-management</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/creative-content</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/creative-content/content-writing</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/creative-content/video-production</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/creative-content/social-media-content-creation</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/creative-design</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/creative-design/ui-ux-design</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/creative-design/graphic-design</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/services/creative-design/motion-graphic</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/industries</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/industries/software</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/industries/education</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/industries/finance</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/industries/ecommerce</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/industries/banking</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/industries/real-state</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/industries/legal</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/industries/travel</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/case-studies</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/blog</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.5</priority>
    </url>

    <url>
        <loc>'.$frontendUrl.'/about-us</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/media</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/career</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/life-at-viserx</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/contact-us</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/privacy-policy/</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/testimonials/</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/refund-policy/</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/cookie-policy/</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/life-seo-in-bangladesh</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>'.$frontendUrl.'/seo-service-in-dubai</loc>
        <lastmod>2024-04-07</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.5</priority>
    </url>
        ';

        foreach ($blogs as $blog) {
            $sitemap .= '
            <url>
                <loc>'.$blog->slug.'</loc>
                <lastmod>'.$blog->updated_at.'</lastmod>
                <changefreq>monthly</changefreq>
                <priority>0.7</priority>
            </url>
            ';
        };
        $sitemap .= '</urlset>';

        return $sitemap;
    }

}
