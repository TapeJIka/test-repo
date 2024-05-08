<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VideoResource;
use App\Models\Video;
use App\Models\WatchedVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $user = auth('sanctum')->user();
//        if (!isset($user)) {
//            $userCategories = app(CategoryController::class)->userMostFrequentCategories();
//            $video = Video::all();
//            if (request()->page) {
//                return VideoResource::collection($video->where('category_id', $userCategories)->paginate(request()->pagination ?? 10));
//            }
//            return VideoResource::collection(Video::all());
//        }
        if (request()->page) {
            return VideoResource::collection(Video::paginate(request()->pagination ?? 10));
        }
        return VideoResource::collection(Video::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'author_id' => '',
            'file' => 'required',
            'category_id' => 'array',
        ]);
        $video = $validated['file'];
        $validated['file'] = $video->hashName();
        $validated['author_id'] = auth()->user()->id;
        $video->store('video');
        $video = Video::create($validated);
        $video->category()->sync($validated['category_id']);

        return new VideoResource($video);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $video = Video::find($id);
        $user = auth('sanctum')->user();
        if (!isset($user)) {
            WatchedVideo::create(['video_id' => $id]);
            return new VideoResource($video);
        }

        $user->videos()->sync($video);
        return new VideoResource($video);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $video = Video::find($id);
        $video->update($request->validate([
            'title' => 'required',
            'description' => 'required',
        ]));

        return new VideoResource($video);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $video = Video::find($id);
        if ($video->author->id != auth()->user()->id) {
            return response()->json([
                'data' => 'You are not allowed to delete this video'
            ],404);
        }
        $video->file = Storage::disk('local')->delete('video/'.$video->file);
        $video->delete();

        return new VideoResource($video);
    }

    public function getVideo(Video $video)
    {
        $video->file = Storage::disk('local')->path('video/'.$video->file);
        return response()->file($video->file);
    }
}
