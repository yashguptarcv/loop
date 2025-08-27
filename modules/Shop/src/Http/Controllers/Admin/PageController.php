<?php

namespace Modules\Shop\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\Shop\Models\Page;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Modules\Shop\DataView\PageGrid;
use Illuminate\Support\Facades\Validator;
use Modules\Filemanager\Services\FileService;

class PageController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function index(Request $request)
    {
        $lists = fn_datagrid(PageGrid::class)->process();
        return view('shop::website.page.index', compact('lists'));
    }

    public function create()
    {
        return view('shop::website.page.form');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:pages,slug',
                'regex:/^[a-z0-9\-_\/]+$/'
            ],
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:1000',
            'meta_og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'view' => 'required|string|max:255',
            'content' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ]);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->except(['meta_og_image']);

            // Handle file upload for meta_og_image
            if ($request->hasFile('meta_og_image')) {
                $file = $request->file('meta_og_image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('pages/og-images', $filename, 'public');
                $data['meta_og_image'] = 'storage/' . $path;
            }

            $page = Page::create($data);

            // Handle image upload
            if ($request->hasFile('meta_og_image')) {
                $fileLink = $this->fileService->uploadFile(
                    $request->file('meta_og_image'),
                    'pages',
                    $page->id
                );
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Page created successfully!',
                    'redirect_url' => route('admin.pages.index'),
                    'data' => $page
                ]);
            }

            return redirect()->route('admin.pages.index')->with('success', 'Page created successfully!');
        } catch (\Throwable $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'errors' => 'Something went wrong. Please try again: ' . $e->getMessage()
                ]);
            }
            return redirect()->back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('shop::website.page.form', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('pages')->ignore($id),
                'regex:/^[a-z0-9\-_\/]+$/'
            ],
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:1000',
            'meta_og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'view' => 'required|string|max:255',
            'content' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);



        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ]);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $page = Page::findOrFail($id);
            $data = $request->except(['meta_og_image']);

            // Handle image upload
            if ($request->hasFile('meta_og_image')) {
                // Delete old image if exists
                $this->fileService->deleteFile('pages', $page->id);
                // Handle image upload
                if ($request->hasFile('meta_og_image')) {
                    $fileLink = $this->fileService->uploadFile(
                        $request->file('meta_og_image'),
                        'pages',
                        $page->id
                    );
                }
            }


            $page->update($data);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Page updated successfully!',
                    'redirect_url' => route('admin.pages.index'),
                    'data' => $page
                ]);
            }

            return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully!');
        } catch (\Throwable $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'errors' => 'Something went wrong. Please try again: ' . $e->getMessage()
                ]);
            }
            return redirect()->back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $page = Page::findOrFail($id);
            $page->delete();

            $this->fileService->deleteFile('product', $id);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Page deleted successfully!',
                    'redirect_url' => route('admin.pages.index'),
                ]);
            }

            return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully!');
        } catch (\Throwable $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'errors' => 'Something went wrong. Please try again: ' . $e->getMessage()
                ]);
            }
            return redirect()->route('admin.pages.index')->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:pages,id',
        ]);

        try {
            $deletedCount = Page::whereIn('id', $request->ids)->delete();
            return redirect()->route('admin.pages.index')->with('success', "Deleted {$deletedCount} pages successfully");
        } catch (\Throwable $e) {
            return redirect()->route('admin.pages.index')->with('error', 'Something went wrong. Please try again.');
        }
    }
}
