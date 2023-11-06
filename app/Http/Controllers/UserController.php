<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllPostsConnection;
use App\Models\Post;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);
        if ($user == null) {
            return redirect()->route('home.index');
        }

        $posts = Post::where('user_id', $id)->orderBy('created_at', 'desc')->get();

        return Inertia::render('User', [
            'user' => $user,
            'posts' => new AllPostsConnection($posts)
        ]);
    }

    public function update(Request $request)
    {
        $request->validate(['file' => 'required|mimes:png,jpg,jpeg']);
        $user = (new FileService)->updateFile(auth()->user(), $request, 'user');

        return redirect()->route('users.show', ['id' => auth()->user()->id]);
    }
}
