<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;

use App\Models\Category;
use App\Models\CategoryHasPost;
use App\Models\Comment;

class BlogController extends Controller
{
    public function index()
    {
        return view('blog.main', [
            'title' => 'My first blog for laravel',
            'posts' => Post::with('categories')->paginate(4)
        ]);
    }

    public function getPostsByCategory($category)
    {
        $category_id = Category::where('name', $category)->first()->id;

        $post_ids = CategoryHasPost::where('category_id', $category_id)
            ->get()
            ->map(function ($item) {
                return $item->post_id;
            })
            ->toArray();

        return view('blog.main', [
            'title' => 'Posts from Category ' . $category,
            'posts' => Post::whereIn('id', $post_ids)->with('categories')->paginate(4)
        ]);
    }

    public function getPost($id)
    {
        //dd(intval($id));
        $post = Post::where('id', intval($id))
            ->with('categories')
            ->first();

        //  dd($post);

        // $post['count_comments'] = 0;
        $post['comments'] = Comment::where('post_id', $id)->get();
    //    dd($post['comments']);
        $post['count_comments'] = $post['comments']->count();
        return view('blog.post', [
            'title' => $post->title,
            'post' => $post,
        ]);
    }

    public function addComment(Request $request, $id)
    {
        // dd($id);
       //  dd($request->input());
        return  Comment::create([
            'post_id' => $id,
            'comment' => $request->input("comment")
        ]);
    }
}
