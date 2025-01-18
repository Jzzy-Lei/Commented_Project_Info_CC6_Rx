<?php

namespace App\Http\Controllers;
use App\Http\Controllers\ProjectController;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function destroy(Image $image)
    {
        // Delete image file
        if ($image->path) {
            Storage::disk('public')->delete($image->path);
        }

        // Delete the image record
        $image->delete();

        return back()->with('success', 'Image removed successfully.');
    }
}

