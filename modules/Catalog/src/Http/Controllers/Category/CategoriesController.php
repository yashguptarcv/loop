<?php

namespace Modules\Catalog\Http\Controllers\Category;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\Catalog\DataView\CategoryGrid;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $lists = fn_datagrid(CategoryGrid::class)->process();

        return view('catalog::categories.index', compact('lists'));
    }

    public function create()
    {
        return view('catalog::categories.form');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'position' => 'nullable|integer',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:5120',
            'name' => 'required|string|max:128',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'slug' => 'nullable|string|max:255',
            'status' => 'nullable|string|in_array:A,D'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            // Prepare category data
            $categoryData = $request->only([
                'parent_id',
                'name',
                'slug',
                'description',
                'position',
                'status',
                'meta_title',
                'meta_description',
                'meta_keywords'
            ]);

            // Generate slug if not provided
            if (empty($categoryData['slug'])) {
                $categoryData['slug'] = Str::slug($categoryData['name']);
            } else {
                $categoryData['slug'] = Str::slug($categoryData['slug']);
            }

            // Handle image upload
            if ($request->hasFile('image')) {
                $categoryData['image'] = $request->file('image')->store('categories/images', 'public');
            }

            // Create category
            $category = Category::create($categoryData);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully!',
                'redirect_url' => route('admin.catalog.categories.index')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function edit(Category $category){

        return view('catalog::categories.form', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'position' => 'nullable|integer',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:5120',
            'name' => 'required|string|max:128',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'slug' => 'nullable|string|max:255',
            'status' => 'nullable|string|in_array:A,D'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            $category = Category::findOrFail($id);

            // Prepare update data
            $updateData = $request->only([
                'parent_id',
                'name',
                'slug',
                'description',
                'position',
                'status',
                'meta_title',
                'meta_description',
                'meta_keywords'
            ]);

            // Handle slug
            if (empty($updateData['slug'])) {
                $updateData['slug'] = Str::slug($updateData['name']);
            } else {
                $updateData['slug'] = Str::slug($updateData['slug']);
            }

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
                $updateData['image'] = $request->file('image')->store('categories/images', 'public');
            }

            // Update category
            $category->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully!',
                'redirect_url' => route('admin.catalog.categories.index')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            // Delete associated image if exists
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully!',
                'redirect_url' => route('admin.catalog.categories.index')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function toggleStatus(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:categories,id',
            'action' => 'required|in:A,D'
        ]);

        try {
            Category::whereIn('id', $request->ids)
                ->update(['status' => $request->action]);

            return redirect()->route('admin.catalog.categories.index')
                ->with('success', 'Status updated successfully!');
        } catch (\Throwable $e) {
            return redirect()->route('admin.catalog.categories.index')
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:categories,id',
        ]);

        try {
            // Get categories with images first
            $categories = Category::whereIn('id', $request->ids)->get();

            // Delete associated images
            foreach ($categories as $category) {
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
            }

            // Delete categories
            Category::whereIn('id', $request->ids)->delete();

            return redirect()->route('admin.catalog.categories.index')
                ->with('success', 'Categories deleted successfully!');
        } catch (\Throwable $e) {
            return redirect()->route('admin.catalog.categories.index')
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function import_form()
    {
        return view('catalog::categories.import');
    }
}
