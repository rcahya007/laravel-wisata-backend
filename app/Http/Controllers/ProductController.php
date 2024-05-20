<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::when($request->keyword, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('description', 'like', '%' . $request->keyword . '%');
        })->orderBy('id', 'desc')->paginate(10);
        return view('pages.products.index', [
            'type_menu' => 'products',
            'products' => $products
        ]);
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('pages.products.create', [
            'type_menu' => 'products',
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated =  $request->validate([
            'category_id' => ['required',],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string',],
            'price' => ['required', 'numeric'],
            'image' => ['nullable', 'mimes:jpeg,png,jpg,webp', 'max:2048', 'image'],
            'criteria' => 'required|string',
            'favorite' => 'required|boolean',
            'status' => 'required|string',
            'stock' => 'required|numeric',
        ]);

        if ($request->image === null) {
            $filename = null;
        } else {
            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/products', $filename);
        }

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'image' => $filename,
            'criteria' => $validated['criteria'],
            'favorite' => $validated['favorite'],
            'status' => $validated['status'],
            'stock' => $validated['stock'],
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('pages.products.edit', [
            'type_menu' => 'products',
            'product' => $product,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => ['required',],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string',],
            'price' => ['required', 'numeric'],
            'image' => ['nullable', 'mimes:jpeg,png,jpg,webp', 'max:2048', 'image'],
            'criteria' => 'required|string',
            'favorite' => 'required|boolean',
            'status' => 'required|string',
            'stock' => 'required|numeric',
        ]);

        if ($request->image !== null && $product->image !== null) {
            if (Storage::exists('public/products/' . $product->image)) {
                Storage::delete('public/products/' . $product->image);
            }
            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/products', $filename);
        } else if ($request->image !== null) {
            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/products', $filename);
        } else {
            $filename = $product->image;
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image' => $filename,
            'status' => $request->status,
            'criteria' => $request->criteria,
            'favorite' => $request->favorite == 1 ? true : false,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        if (Storage::exists('public/products/' . $product->image)) {
            Storage::delete('public/products/' . $product->image);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
