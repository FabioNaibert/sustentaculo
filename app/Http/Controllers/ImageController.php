<?php

namespace App\Http\Controllers;

use App\Http\Services\ImageService;
use App\Http\Services\ResourceService;
use App\Models\Chapter;
use App\Models\Image;
use App\Models\Player;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ImageController extends Controller
{
    private ImageService $imageService;
    private ResourceService $resourceService;

    public function __construct(ImageService $imageService, ResourceService $resourceService)
    {
        $this->imageService = $imageService;
        $this->resourceService = $resourceService;
    }


    public function addImage(Request $request)
    {
        $chapterId = $request->input('chapter_id');
        $name = $request->input('name');
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $chapter = Chapter::findOrFail($chapterId);

        $imageId = $this->imageService->addImage($request->image, $chapter->history_id, $name);

        $chapter->images()->attach($imageId);

        return $this->resourceService->getResources($chapterId);
    }


    public function removeImage(Request $request)
    {
        $imageId = $request->input('image_id');
        $chapterId = $this->imageService->removeImage($imageId);

        return $this->resourceService->getResources($chapterId);
    }


    public function getImagesPlayer()
    {
        return Inertia::render('GameResources');
    }


    public function shareImage(Request $request)
    {
        $listShare = $request->input('list_share');
        $imageId = $request->input('image_id');

        $image = Image::findOrFail($imageId);
        $image->players()->sync($listShare);

        return $this->resourceService->getResources($image->chapters->first()->id);

        // event socketi
    }
}
