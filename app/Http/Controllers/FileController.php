<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    public function createFile()
    {
        return view('file.create');
    }

    public function store(Request $request)
    {

        if ($request->hasFile('file')) {
            $folder = 'Files_test';
            $file = $request->file;
            $name = $file->getClientOriginalName();
            Storage::disk('s3')->put($folder . '/' . $name, file_get_contents($file));

        }
        $folder = 'Files_test';

        // List all files in the 'Files_test' folder
        $files = Storage::disk('s3')->files($folder);

        // Retrieve the URLs for each file
        $urls = [];
        foreach ($files as $file) {
            $urls[] = Storage::disk('s3')->url($file);
        }
       

        $users = User::all();

        // Redirect to a success page or another appropriate route
        return view('home', ['urls' => $urls, 'users' => $users]);
    }
}
