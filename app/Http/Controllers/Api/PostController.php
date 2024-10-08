<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Posts;

class PostController extends Controller
{
    public function index()
    {
        $posts = Posts::with('category')->get();
        return response()->json($posts);
    }

    public function show($id)
    {
        $post = Posts::with('category')->findOrFail($id);
        return response()->json($post);
    }

    public function search(Request $request)
    {
        $query = $request->query('q');

        $posts = Posts::where('title', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->orWhereHas('category', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->get();


        return response()->json($posts);
    }
}
