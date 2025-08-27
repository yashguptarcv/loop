<?php

namespace Modules\Shop\Http\Controllers;

use Exception;
use Google\Service\ServiceControl\Auth;
use Illuminate\Http\Request;
use Modules\Shop\Models\Page;
use Illuminate\Routing\Controller;
use Modules\Catalog\DataView\ProductGrid;

class HomeController extends Controller
{
    public function index(Request $request, $slug = null)
    {
        // Home page - handle root slug
        try {
            if ($slug === null || $slug === '') {
                $page = Page::active()->where('slug', '/')->first();

                // If no home page exists, create a default one or show 404
                if (!$page) {
                    abort(404, 'Home page not found.');
                }
            } else {
                $page = Page::active()->where('slug', $slug)->firstOrFail();
            }
        } catch(Exception $e) {
            abort(404, 'Home page not found.');
        }

        // Ensure the view exists, fallback to a default view if needed
        $viewName = $page->view ?? 'shop::shop.page';

        // Check if view exists, fallback to default if not
        if (!view()->exists($viewName)) {
            $viewName = 'shop::shop.index'; // fallback view
        }

        // Pass SEO meta to view
        return view($viewName, [
            'page' => $page,
            'meta' => [
                'title' => $page->meta_title ?? $page->title ?? config('app.name'),
                'description' => $page->meta_description ?? '',
                'keywords' => $page->meta_keywords ?? '',
                'og_image' => $page->meta_og_image ?? asset('images/default-og.jpg'),
            ]
        ]);
    }
}
