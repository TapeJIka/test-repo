<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlbumRequest;
use App\Http\Resources\AlbumResource;
use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AlbumResource::collection(Album::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlbumRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;
        $album = Album::create($validated);

        return new AlbumResource($album);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $album = Album::find($id);

        return new AlbumResource($album);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AlbumRequest $request, $id)
    {
        $album = Album::find($id);
        $album->update($request->validated());

        return new AlbumResource($album);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $album = Album::find($id);
        $album->delete();

        return new AlbumResource($album);
    }

    public function userAlbums()
    {
        return AlbumResource::collection(auth()->user()->albums);
    }

    public function addVideoToAlbum(Request $request)
    {
        $validated = $request->validate([
            'album_id' => 'required',
            'video_id' => 'required',
        ]);

        $album = Album::find($validated['album_id']);
        $album->videos()->sync($validated['video_id']);

        return new AlbumResource($album);
    }
}
