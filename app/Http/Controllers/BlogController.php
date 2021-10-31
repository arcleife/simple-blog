<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

use App\Models\Blog;
use App\Models\User;
use App\Models\Role;
use App\Models\Comment;

class BlogController extends Controller
{
    public function index() {
        $blogs_raw = blog::all();
        $blogs = [];
        foreach ($blogs_raw as $key=>$blog_raw) {
            $blogs[$key] = [
                'id' => $blog_raw->id,
                'title' => $blog_raw->title,
                'content' => $blog_raw->content,
                'date' => $blog_raw->created_at->toDayDateTimeString(),
                'categories' => $blog_raw->categories,
                'username' => User::where('id', $blog_raw->user_id)->pluck('name')[0]
            ];
        }

        return Inertia::render('Dashboard', [
            'blogs' => $blogs
        ]);
    }

    public function show(Request $request, Blog $blog) {
        $comments_raw = Comment::where('blog_id', $blog->id)->get();

        $comments = [];
        
        foreach ($comments_raw as $key=>$comment_raw) {
            $comments[$key] = [
                'id' => $comment_raw->id,
                'content' => $comment_raw->content,
                'user_id' => $comment_raw->user_id,
                'username' => User::where('id', $comment_raw->user_id)->pluck('name')[0],
                'date' => $comment_raw->created_at->toDayDateTimeString()
            ];
        }

        $blog_filtered = [
            'id' => $blog->id,
            'title' => $blog->title,
            'content' => $blog->content,
            'date' => $blog->created_at->toDayDateTimeString(),
            'categories' => $blog->categories,
            'username' => User::where('id', $blog->user_id)->pluck('name')[0],
            'user_id' => $blog->user_id
        ];

        return Inertia::render('Blog', [
            'blog' => $blog_filtered,
            'comments' => $comments
        ]);
    }

    public function create() {
        return Inertia::render('Blog.Create');
    }

    public function store(Request $request) {
        // store blog content
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $user_id = Auth::id(); 
        $created_blog_id = Blog::create([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'user_id' => $user_id
        ])->id;

        return Redirect::route("blog", $created_blog_id);
    }

    public function edit(Request $request, Blog $blog) {
        // edit blog
        \Debugbar::info($blog->toArray());

        $blog_filtered = [
            'id' => $blog->id,
            'title' => $blog->title,
            'content' => $blog->content,
            'categories' => $blog->categories,
            'username' => User::where('id', $blog->user_id)->pluck('name')[0],
            'user_id' => $blog->user_id
        ];

        return Inertia::render('Blog.Edit', [
            'blog' => $blog_filtered
        ]);
    }

    public function update(Request $request, Blog $blog) {
        // store blog update
        // \Debugbar::info($blog->toArray());
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);
        
        $blog->update($request->only('title', 'content'));

        return Redirect::route("blog", $blog->id);
    }

    public function delete(Request $request, Blog $blog) {
        // delete blog
        $blog->delete();

        return Redirect::route("dashboard");
    }
}
