<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{
    public function store(Request $request) {
        // $request->validate([
        //     'content' => 'required|string'
        // ]);

        $blog_id = $request->get('blog_id');

        Comment::create([
            'content' => $request->get('content'),
            'blog_id' => $blog_id,
            'user_id' => $request->get('user_id')
        ]);

        return Redirect::route("blog", $blog_id);
    }

    public function update() {
        // 
    }

    public function delete(Request $request, Comment $comment) {
        // delete comment
        $blog_id = $comment->blog_id;

        $comment->delete();

        return Redirect::route("blog", $blog_id);
    }
}
