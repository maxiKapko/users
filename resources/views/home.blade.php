@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">


                    <div class="table_users">
                        <table class="users">
                            <tr class="head">
                                <th class="header_table head-table">Nombre</th>
                                <th class="header_table head-table">E-mail</th>
                                <th class="header_table head-table">Created at</th>
                                <th class="header_table head-table">Updated at</th>
                                <th class="header_table head-table">Inactive date</th>
                                <th class="header_table head-table">Actions</th>
                            </tr>
                            @foreach($users as $indexUser => $user)
                            <tr>
                                <td class="data_table">{{$user->name}}</td>
                                <th class="header_table">{{$user->email}}</th>
                                <th class="header_table">{{$user->created_at->format('Y-m-d')}}</th>
                                <th class="header_table">{{$user->updated_at->format('Y-m-d')}}</th>
                                <th class="header_table">
                                    @if ($user->inactive)
                                    {{ $user->inactive->format('Y-m-d') }}
                                    @else
                                    ---
                                    @endif
                                </th>
                                <th class="header_table users_actions">
                                    <a href="{{ route('edit.user',$user->id) }} " class="edit_user">
                                        <button class="edit_user_button">Edit User</button>
                                    </a>
                                    @if($user->inactive)
                                    <form method="POST" action="{{ route('activate.user', ['id' => $user->id]) }}">
                                        @csrf
                                        <button type="submit" class="activate-user_button">Activate User</button>
                                    </form>
                                    @endif
                                    <form method="POST" action="{{ route('delete.user', ['id' => $user->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="delete-user_button">Delete User</button>
                                    </form>

                                </th>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="button_create_user">
                        <a href="{{ route('create.user') }}" class="create_user">
                            <button class="create_user_button">Create User</button>
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table_files">
                        <div class="title">Files</div>
                    </div>
                    <div class="button_create_user">
                        <div class="files">
                            @foreach ($urls as $url)
                            <a href="{{ $url }}" target="_blank">{{ $url }}</a><br>
                            @endforeach
                        </div>

                    </div>
                        <div class="agregar_file"><a href="{{ route('create.file') }}" class="create_user">
                            <button class="create_user_button">Upload File</button>
                        </a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection