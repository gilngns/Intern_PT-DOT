<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::all();
        $posts = Posts::with('category')->get();
        return view('CRUD.posts', compact('categories', 'posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'max:255|string|required',
            'content' => 'max:255|string|required',
            'categories_id' => 'required|exists:categories,id'
        ]);

        Posts::create($request->all());
        return redirect()->route('posts.index')->with('success', 'Post created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Posts $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'categories_id' => 'required|integer',
            'content' => 'required|string',
        ]);

        $post->update($request->all());

        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $posts = Posts::findOrFail($id);
        $posts->delete();
        return redirect()->route('posts.index');
    }
}
