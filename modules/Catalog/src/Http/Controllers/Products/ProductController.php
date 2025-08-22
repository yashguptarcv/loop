<?php

namespace Modules\Catalog\Http\Controllers\Products;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Modules\Catalog\Models\Product;
use Modules\Catalog\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\Catalog\DataView\ProductGrid;
use Modules\Filemanager\Services\FileService;

class ProductController extends Controller
{
    protected $fileService;
    
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lists = fn_datagrid(ProductGrid::class)->process();
        return view('catalog::products.index', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $statuses = Product::getStatuses();
        return view('catalog::products.form', compact('categories', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:price',
            'track_stock' => 'required|string|in:Y,N',
            'stock_quantity' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->track_stock === 'Y';
                }),
                'integer',
                'min:0'
            ],
            'stock_status' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->track_stock === 'Y';
                }),
                'in:in_stock,out_of_stock,backorder'
            ],
            'sku' => 'nullable|string|unique:products,sku',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,hidden,active',
            'is_featured' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {

            $productData = $request->only([
                'name',
                'description',
                'price',
                'sale_price',
                'track_stock',
                'stock_quantity',
                'stock_status',
                'stock_notes',
                'sku',
                'status',
                'is_featured'
            ]);

            $productData['admin_id']    = auth('admin')->id();

            
            // Create the product
            $product = Product::create($productData);
            
            // Handle image upload
            if ($request->hasFile('image')) {
                    $fileLink = $this->fileService->uploadFile(
                    $request->file('image'),
                    'product',
                    $product->id
                );
            }

            // Attach categories
            $product->categories()->attach($request->input('categories'));

            // Handle tags if provided
            if (!empty($request['tags'])) {
                $tags = array_map('trim', explode(',', $request['tags']));
                $product->syncTags($tags);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully!',
                'redirect_url' => route('admin.catalog.products.index')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $statuses = Product::getStatuses();
        return view('catalog::products.form', compact('product', 'categories', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:price',
            'track_stock' => 'required|string|in:Y,N',
            'stock_quantity' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->track_stock === 'Y';
                }),
                'integer',
                'min:0'
            ],
            'stock_status' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->track_stock === 'Y';
                }),
                'in:in_stock,out_of_stock,backorder'
            ],
            'sku' => [
                'nullable',
                'string',
                Rule::unique('products', 'sku')->ignore($product->id)
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,hidden,active',
            'is_featured' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            $productData = $request->only([
                'name',
                'description',
                'price',
                'sale_price',
                'track_stock',
                'stock_quantity',
                'stock_status',
                'stock_notes',
                'sku',
                'status',
                'is_featured'
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                $this->fileService->deleteFile('product', $product->id);
                 // Handle image upload
                if ($request->hasFile('image')) {
                        $fileLink = $this->fileService->uploadFile(
                        $request->file('image'),
                        'product',
                        $product->id
                    );
                }
            }

            $productData['admin_id']    = auth('admin')->id();

            // Update the product
            $product->update($productData);

            // Sync categories
            $product->categories()->sync($request->input('categories'));

            // Handle tags if provided
            if (!empty($request['tags'])) {
                $tags = array_map('trim', explode(',', $request['tags']));
                $product->syncTags($tags);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully!',
                'redirect_url' => route('admin.catalog.products.index')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            // Delete image if exists
            $this->fileService->deleteFile('product', $product->id);

            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully!',
                'redirect_url' => route('admin.catalog.categories.index')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.' . $e->getMessage()
            ]);
        }
    }

    /**
     * Update product status
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:products,id',
            'action' => 'required|in:active,hidden,draft'
        ]);

        try {
            Product::whereIn('id', $request->ids)
                ->update(['status' => $request->action]);

            return redirect()->route('admin.catalog.products.index')
                ->with('success', 'Status updated successfully!');
        } catch (\Throwable $e) {
            return redirect()->route('admin.catalog.products.index')
                ->with('error', 'Something went wrong. Please try again.' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:products,id',
        ]);

        try {
            // Get categories with images first
            $products = Product::whereIn('id', $request->ids)->get();

            // Delete associated images
            foreach ($products as $product) {
                $this->fileService->deleteFile('product', $product->id);
            }

            // Delete categories
            Product::whereIn('id', $request->ids)->delete();

            return redirect()->route('admin.catalog.products.index')
                ->with('success', 'Products deleted successfully!');
        } catch (\Throwable $e) {
            return redirect()->route('admin.catalog.products.index')
                ->with('error', 'Something went wrong. Please try again.' . $e->getMessage());
        }
    }
}
