<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    
    public function index()
    {
        $categories = Categories::all(); 
        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }
}
