<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Models\Product;
use Modules\Catalog\Models\Category;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'Welcome to the Catalog module!'
        ]);
    }

    /**
     * Search products for Select2 dropdown
     */
    public function searchProducts(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page', 1);
        $perPage = 30;

        $query = Product::query()
            ->where('status', '!=', 'draft')
            ->select('id', 'name as text', 'description');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'items' => $paginator->items(),
            'total_count' => $paginator->total()
        ]);
    }

    /**
     * Search categories for Select2 dropdown
     */
    public function searchCategories(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page', 1);
        $perPage = 30;

        $query = Category::query()
            ->where('status', 'A')
            ->select('id', 'name as text', 'description');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'items' => $paginator->items(),
            'total_count' => $paginator->total()
        ]);
    }
}
