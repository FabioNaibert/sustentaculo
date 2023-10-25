<?php

namespace App\Http\Services;

use App\Models\Image;

class ImageService
{
    public function addImage($image, $historyId)
    {
        $imageName = time().'.'.$image->extension();

        $newImageRegister = Image::create([
            'name' => 'IMAGE_WEAPON',
            'content' => ''
        ]);

        $folder = '/images'.'/'.$historyId.'/';
        $url = storage_path('app'.$folder);

        $newImageRegister->content = $folder . $imageName;
        $newImageRegister->save();

        $image->move($url, $imageName);

        return $newImageRegister->id;
    }


    public function removeImage($imageId, $historyId)
    {
        $image = Image::findOrFail($imageId);

        $url = storage_path('app') . $image->content;
        unlink($url);

        $image->delete();

        return ;
    }
}
