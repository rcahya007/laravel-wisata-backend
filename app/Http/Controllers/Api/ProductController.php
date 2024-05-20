<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $product = Product::when(
            $request->status,
            function ($query) use ($request) {
                $query->where('status', $request->status);
            }
        )->orderBy('favorite', 'desc')
            ->with('category')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $product
        ], 200);
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

        return response()->json([
            'status' => 'success',
            'data' => $product,
        ], 200);
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $product
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }

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

        return response()->json([
            'status' => 'success',
            'data' => $product
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }
        if (Storage::exists('public/products/' . $product->image)) {
            Storage::delete('public/products/' . $product->image);
        }
        $product->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully',
        ], 200);
    }
}
