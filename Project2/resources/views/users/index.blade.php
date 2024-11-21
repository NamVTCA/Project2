<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h2>Quản lý người dùng</h2>
        
        <div class="mb-3">
            <a href="{{ route('users.create') }}" class="btn btn-primary">Thêm người dùng mới</a>
            
            <div class="btn-group ml-2">
                <a href="{{ route('users.index', ['role' => 1]) }}" 
                class="btn btn-{{ $role == 1 ? 'secondary' : 'outline-secondary' }}">Teachers</a>
                <a href="{{ route('users.index', ['role' => 2]) }}" 
                class="btn btn-{{ $role == 2 ? 'secondary' : 'outline-secondary' }}">Parents</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->status }}</td>
                    <td>
                        <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-sm">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection
  
</body>
</html>