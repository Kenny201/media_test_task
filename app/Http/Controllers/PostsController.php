<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\Comments;
    use App\Models\Posts;
    use DB;
    use Illuminate\Routing\Controller as BaseController;
    use Illuminate\Support\Facades\Http;
    use Illuminate\Database\QueryException;
    class PostsController extends BaseController
    {
        public function index()
        {
            $get_posts = Http::get('http://jsonplaceholder.typicode.com/posts')->json();
            $get_comments = Http::get('http://jsonplaceholder.typicode.com/comments')->json();
            $arr_posts_limit = collect($get_posts)->take(20);
            $arr_comments_limit = collect($get_comments)->take(20);
            try {
                DB::transaction(function () use ($arr_posts_limit , $arr_comments_limit){
                    $arr_posts_limit->each(function ($post) {
                        Posts::create($post);
                    });
                    $arr_comments_limit->each(function ($comment) {
                        Comments::create($comment);
                    });
                });
                return redirect('/');
            } catch (QueryException $e) {
                    $error = 'Статьи уже добавлены';
                    return view('load', compact('error'));
            }
       }
    }
