<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the products
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('sort_order', 'asc')->get();
        return view('backend.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.products.create');
    }

    /**
     * Store a newly created product in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'sub_title' => 'nullable|max:255',
            'category' => 'nullable|max:100',
            'description' => 'nullable',
            'sort_order' => 'nullable|integer',
            'featured' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = new Product();
        $product->title = $validated['title'];
        $product->sub_title = $validated['sub_title'] ?? null;
        $product->category = $validated['category'] ?? null;
        $product->description = $validated['description'] ?? null;
        $product->sort_order = $validated['sort_order'] ?? 0;
        $product->featured = $request->has('featured') ? 1 : 0;

        if ($request->hasFile('image')) {
            // dd($request->image);
            $imagePath = 'images/products';
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path($imagePath), $imageName);
            $product->image = $imagePath . '/' . $imageName;
        }

        $product->save();
        
        // Log the product creation activity
        ActivityLogService::logCreated($product, "تم إنشاء منتج جديد: {$product->title}");

        return redirect()->route('products.index')->with('success', 'تم إنشاء المنتج بنجاح');
    }

    /**
     * Display the specified product
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('backend.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('backend.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'sub_title' => 'nullable|max:255',
            'category' => 'nullable|max:100',
            'description' => 'nullable',
            'sort_order' => 'nullable|integer',
            'featured' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Save old attributes for logging
        $oldAttributes = $product->toArray();
        
        $product->title = $validated['title'];
        $product->sub_title = $validated['sub_title'] ?? null;
        $product->category = $validated['category'] ?? null;
        $product->description = $validated['description'] ?? null;
        $product->sort_order = $validated['sort_order'] ?? 0;
        $product->featured = $request->has('featured') ? 1 : 0;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $imagePath = 'images/products';
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path($imagePath), $imageName);
            $product->image = $imagePath . '/' . $imageName;
        }

        $product->save();
        
        // Log the product update activity
        ActivityLogService::logUpdated($product, $oldAttributes, "تم تحديث منتج: {$product->title}");

        return redirect()->route('products.index')->with('success', 'تم تحديث المنتج بنجاح');
    }

    /**
     * Remove the specified product from storage
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // Store product data for logging before deletion
        $productData = $product->toArray();
        $productTitle = $product->title;
        
        // Delete product image if exists
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();
        
        // Log the product deletion activity
        ActivityLogService::logDeleted(new Product($productData), "تم حذف منتج: {$productTitle}");

        return redirect()->route('products.index')->with('success', 'تم حذف المنتج بنجاح');
    }
}
