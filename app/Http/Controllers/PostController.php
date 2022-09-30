<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {

        $posts = Post::latest('published_at')->filter(request(['search','category','author']))->get();

        return view('posts.index', [
            'posts' => $posts,
        ]);

    }

    public function show (Post $post) {

        return view('posts.show', ['post' => $post]);
    
    }
}
