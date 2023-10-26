<?php

namespace App\Http\Services;

use App\Models\Image;

class ImageService
{
    public function addImage($image, $historyId, $name = 'IMAGE_WEAPON')
    {
        $imageName = time().'.'.$image->extension();

        $newImageRegister = Image::create([
            'name' => $name,
            'content' => ''
        ]);

        $folder = '/images'.'/'.$historyId.'/';
        $url = storage_path('app'.$folder);

        $newImageRegister->content = $folder . $imageName;
        $newImageRegister->save();

        $image->move($url, $imageName);

        return $newImageRegister->id;
    }


    public function removeImage($imageId)
    {
        $image = Image::findOrFail($imageId);
        $chapter = $image->chapters()->first();

        $url = storage_path('app') . $image->content;
        unlink($url);
        $image->delete();

        return $chapter->id;
    }
}
