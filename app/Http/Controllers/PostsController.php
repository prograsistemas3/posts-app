<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Taggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('tags')->get();

        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $post              = new Post;
            $post->title       = $request->title;
            $post->description = $request->description;
            $post->user_id     = auth()->user()->id;
            $post->save();

            $tags = $request->tags;
            foreach ($tags as $item) {
                $name = strtolower($item['name']);
                $tag = Tag::query()->where('name', $name)->first();
                
                if(is_null($tag)){
                    $tag = new Tag;
                    $tag->name = $name;
                    $tag->save();
                }

                $taggable                = new Taggable;
                $taggable->taggable_id   = $post->id;
                $taggable->taggable_type = 'App\Models\Post';
                $taggable->tag_id        = $tag->id;
                $taggable->save();
            }
        });

        return response()->json("Ok");
    }

}
