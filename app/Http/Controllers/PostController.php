<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {

        $posts = Post::latest('published_at')->filter(request(['search','category']))->get();

        return view('posts', [
            'posts' => $posts,
            'categories' => Category::all(),
            'currentCategory' => Category::firstWhere('slug', request('category')), 
        ]);

    }

    public function show (Post $post) {

        return view('post', ['post' => $post]);
    
    }
}
