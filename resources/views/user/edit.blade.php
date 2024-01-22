@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create User</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('update.user',$user->id) }}">
                        @csrf


                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" value="{{$user->name}}" required>

                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" value="{{$user->email}}" required>


                        <button type="submit">Update User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection