<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        return Category::orderBy('id', 'DESC')->with('products')->get();
    }

    public function show($slug) {
        return Category::with('products')->where('slug', $slug)->first();
    }
}
