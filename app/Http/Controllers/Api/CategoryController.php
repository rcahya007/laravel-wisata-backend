<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        return response()->json([
            'status' => 'success',
            'categories' => $categories
        ], 200);
    }
}
