<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index()
    {
        $folder = 'Files_test';

        // List all files in the 'Files_test' folder
        $files = Storage::disk('s3')->files($folder);

        // Retrieve the URLs for each file
        $urls = [];
        foreach ($files as $file) {
            $urls[] = Storage::disk('s3')->url($file);
        }


        $users = User::all();

        return view('home', ['urls' => $urls, 'users' => $users]);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed',
            // Add more validation rules as needed
        ]);
        if ($request->hasFile('profile_picture')) {
            $originalFilename = $request->file('profile_picture')->getClientOriginalName();

            // Store the file in the "Users_Pictures" directory with the original filename
            $path = $request->file('profile_picture')->storeAs('Users_Pictures', $originalFilename);

            // Save only the filename (without any directory structure) to the database
            $validatedData['profile_picture'] = $originalFilename;
        }


        // Hash the password before storing it
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Create the new user
        User::create($validatedData);

        $folder = 'Files_test';

        // List all files in the 'Files_test' folder
        $files = Storage::disk('s3')->files($folder);

        // Retrieve the URLs for each file
        $urls = [];
        foreach ($files as $file) {
            $urls[] = Storage::disk('s3')->url($file);
        }


        $users = User::all();

        return view('home', ['urls' => $urls, 'users' => $users]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // Make sure to exclude the current user from the uniqueness check
        ]);

        // Find the user and update the data
        $user = User::find($id);
        $user->update($validatedData);

        // Fetch the updated list of users
        $folder = 'Files_test';

        // List all files in the 'Files_test' folder
        $files = Storage::disk('s3')->files($folder);

        // Retrieve the URLs for each file
        $urls = [];
        foreach ($files as $file) {
            $urls[] = Storage::disk('s3')->url($file);
        }


        $users = User::all();

        return view('home', ['urls' => $urls, 'users' => $users]);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->inactive = now();
            $user->save();
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

        return view('home', ['urls' => $urls, 'users' => $users]);
    }

    public function activate($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->inactive = null;
            $user->save();
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

        return view('home', ['urls' => $urls, 'users' => $users]);
    }
}
