@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create User</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                        @csrf


                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" required>

                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" required>


                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" required>

                        <label for="password_confirmation">Confirm Password:</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required>

                        <label for="password_confirmation">Picture:</label>
                        <input type="file" name="profile_picture" id="profile_picture" required>

                        <button type="submit">Create User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection