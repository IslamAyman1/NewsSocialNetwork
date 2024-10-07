<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show($slug){
        $main_post = Post::with(['comments' => function($query){
                $query->latest()->limit(3);
        }])
        ->where('slug', $slug)
        ->first();
        $category = $main_post->category;
        $posts_belongs_to_category = $category
            ->posts()
            ->select('slug','id','title')
            ->limit(5)
            ->get();

        $main_post->increment('num_of_views');
        return view('frontend.showPost',compact('main_post','posts_belongs_to_category'));
    }
    public function getAllPosts($slug){
         $post = Post::whereSlug($slug)->first();
         $comments = $post->comments()->with('user')->get();
         return response()->json($comments);
    }
    public function saveComment(Request $request){
        $request->validate([
            'user_id' => ['required' ,'exists:users,id'],
            'comment' => ['required' , 'string' ,'max:200']
        ]);
        $comment = Comment::create([
            'user_id' => $request->user_id,
            'comment' => $request->comment,
            'post_id' => $request->post_id,
            'ip_address' => request()->ip()
        ]);
        $comment->load('user')->get();
        if(!$comment){
            return response()->json([
                'data' => 'operation failed'
            ]);
        }
        return response()->json([
            'msg' => 'Comment added successfully',
            'comment' => $comment  ,
            'status' => 201
        ]);

    }
}

