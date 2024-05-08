<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\VideoResource;
use App\Models\Category;
use App\Models\WatchedVideo;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return new CategoryResource(Category::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);
        $category->update($request->validated());

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        return new CategoryResource($category);
    }

    public function getMostFrequentCategories()
    {
        $watchedVideos = WatchedVideo::all();

    }

    public function userMostFrequentCategories()
    {
        $user = auth()->user();
        $watchedVideo = $user->videos;
        $categories = array();
        $keys = array();
        if ($watchedVideo) {
            foreach ($watchedVideo as $video){
                foreach ($video->category as $category) {
                    array_push($categories, $category->id);
                }
            }
            if ($categories){
                $arrayCountValues = array_count_values($categories);
                $arrayCountValuesMax = max($arrayCountValues);
                foreach ($arrayCountValues as $key=> $value) {
                    if ($value == $arrayCountValuesMax) {
                        array_push($keys, $key);
                    }
                }
                $MostFrequentCategories = CategoryResource::collection(Category::find($keys));
                return $MostFrequentCategories;
            }
        }

    }
}
