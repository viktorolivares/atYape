<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File as FileSystem;

class FileController extends Controller
{
    public function getPreloadedImages()
    {
        $imagesPath = public_path('images/users');
        $images = FileSystem::files($imagesPath);

        $imageURLs = [];

        foreach ($images as $image) {
            $imageURLs[] = [
                'url' => asset('images/users/' . $image->getFilename()),
                'filename' => $image->getFilename(),
            ];
        }

        return response()->json($imageURLs);
    }
}
