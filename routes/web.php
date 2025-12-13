<?php

use App\Models\Song;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/download-song/{song}', function (Song $song) {
    $disk = Storage::disk('public');
    $filePath = $song->file_path;

    if (!$disk->exists($filePath)) {
        abort(404);
    }

    // This returns a download response with the file content and filename
    return response()->download($disk->path($filePath), basename($filePath));
})->name('songs.download');

Route::get('/', function () {
    return view('welcome');
});

