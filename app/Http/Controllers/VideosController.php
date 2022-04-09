<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Taggable;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::with('tags')->get();

        return response()->json($videos);
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
            $video              = new Video;
            $video->title       = $request->title;
            $video->description = $request->description;
            $video->user_id     = auth()->user()->id;
            $video->save();

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
                $taggable->taggable_id   = $video->id;
                $taggable->taggable_type = 'App\Models\Video';
                $taggable->tag_id        = $tag->id;
                $taggable->save();
            }
        });

        return response()->json("Ok");
    }

}
