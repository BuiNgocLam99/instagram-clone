<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AllPostsConnection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($post) {
            return [
                'id' => $post->id,
                'text' => $post->text,
                'file' => $post->file,
                'created_at' => $post->created_at->format(' M D Y'),
                'comments' => $post->comment->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'text'=> $comment->text,
                        'user' => [
                            'id' => $comment->user->id,
                            'name' => $comment->user->name,
                            'file' => $comment->user->file,
                        ],
                    ];
                }),
                'likes' =>  $post->like->map(function($like) {
                    return [
                        'id' => $like->id,
                        'user_id' => $like->user_id,
                        'post_id' => $like->post_id,
                    ];
                }),
                'user' => [
                    'id'=> $post->user->id,
                    'name' => $post->user->name,
                    'file' => $post->user->file,
                ],
            ];
        });
    }
}
