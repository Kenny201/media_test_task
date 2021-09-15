<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use ErrorException;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function index()
    {
        $posts_id = rand(1, 4);
        $posts = Posts::join('comments', 'posts.id', '=', 'comments.postId')
            ->where('posts.id', '=', $posts_id)
            ->select('posts.title', 'posts.body as p_body',  'comments.name as c_name', 'comments.email as c_email', 'comments.body as c_body', )
            ->get();
        if ($posts->count() === 0 ) {
            $error = 'Перейдите по маршруту /load для загрузки статей';
            return view('welcome', compact('error'));
        }
        return view('welcome', compact('posts'));
    }
}
