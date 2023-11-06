<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required',
            'user_id' => 'required',
            'comment' => 'required',
        ]);

        $comment = new Comment();

        $comment->post_id = $request->input('post_id');
        $comment->user_id = $request->input('user_id');
        $comment->text = $request->input('comment');

        $comment->save();
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
    }
}
