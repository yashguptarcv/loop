<?php

namespace Modules\Core\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Catalog\Models\Category;

class CategoryController extends Controller
{
    public function children($parentId)
    {
        $categories = Category::where('parent_id', $parentId)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json($categories);
    }
}
