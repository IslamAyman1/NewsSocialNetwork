<?php

namespace App\Http\Controllers\frontend\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\postRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Utilities\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index(){
        $posts = Post::active()->with('images')->where('user_id',auth()->user()->id)->get();
//        $posts = auth()->user()->posts()->active()->with('images')->get();
        return view('frontend.dashboard.profile',compact('posts'));
    }
    public function storePost(postRequest $request){
         try{
             DB::beginTransaction();
             $request->validated();
             $request->comment_able == 'on' ? $request->merge(['comment_able' => 1]) : $request->merge(['comment_able' => 0]);
             $post = auth()->user()->posts()->create($request->except('_token','images'));
                ImageManager::uploadImages($request , $post);
             DB::commit();
             Cache::forget('read_more_posts');
             Cache::forget('latest_posts');
       }catch(\Exception $e){
             DB::rollback();
             return redirect()->back()->withErrors(['error' => $e->getMessage()]);
         }
        Session::flash('success', 'Your post has been created');

        return redirect()->back();
    }


    public function deletePost(Request $request)
    {
       $post = Post::where('slug' , $request->slug)->first();
       if(!$post){
           abort(404);
       }
       ImageManager::deleteImages($post);
    }
    public function editPost($slug){
        return $slug;
    }

    public function getComments($id){
        $comments = Comment::with('user')->where('post_id' , $id)->get();
        if(!$comments){
            return response()->json([
                'data' => null,
                'msg' => 'No Comment'
            ]);
        }
        return response()->json([
            'data' => $comments,
            'msg' => 'Contain Comments'
        ]);
    }
}
