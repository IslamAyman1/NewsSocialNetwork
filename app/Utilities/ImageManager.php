<?php

namespace App\Utilities;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageManager{
    public static function uploadImages($request , $post){
        if($request->hasFile('images')){
            foreach ($request->images as $image){
                $fileName = Str::uuid() . time() . $image->getClientOriginalExtension();
                $path = $image->storeAs('uploads/posts', $fileName ,['disk' =>'uploads']);
                $post->images()->create([
                    'path' => $path
                ]);
            }
        }
    }
    public static function deleteImages($post){
        if($post->images->count() > 0){
            foreach ($post->images as $image){
                if(File::exists(public_path($image->path))){
                    File::delete(public_path($image->path));
                }
            }
            $post->delete();
            return redirect()->back()->with('success', 'Your post has been deleted');
        }
    }
}
?>
