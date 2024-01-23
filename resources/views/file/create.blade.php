@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create User</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('file.store') }}" enctype="multipart/form-data">
                        @csrf


                        <label for="name">File:</label>
                        <input type="file" name="file" id="file" required>




                        <button type="submit" class="create_user_button">Upload File</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection