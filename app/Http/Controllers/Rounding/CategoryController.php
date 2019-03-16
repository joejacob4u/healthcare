<?php

namespace App\Http\Controllers\Rounding;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rounding\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function index()
    {
        $categories = Category::get();
        return view('admin.rounding.categories', ['categories' => $categories]);
    }
}
