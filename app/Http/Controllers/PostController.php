<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index() {

        $posts = Post::latest('published_at')->filter(request(['search','category','author']))->paginate(6)->withQueryString();

        return view('posts.index', [
            'posts' => $posts,
        ]);

    }

    public function show (Post $post) {

        return view('posts.show', ['post' => $post]);
    
    }
}
