<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $posts = Post::with('images')->latest()->paginate(9);
        $gretest_posts_views = Post::orderBy('num_of_views' , 'desc')->take(3)-> get();
        $oldest_news = Post::oldest()->take(3)-> get();
        $greatest_posts_comment = Post::withCount('comments')->orderBy('comments_count' , 'desc')->take(3)-> get();

        $categories = Category::all();
       $categories_with_posts = $categories->map(function($category){
            $category->posts = $category->posts()->limit(4)->get();
            return $category;
        });

        return view('frontend.index', compact('posts', 'gretest_posts_views','oldest_news','greatest_posts_comment','categories_with_posts'));
    }
}
