<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @extends('layouts.dashboard')

    @section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3>User Profile</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            @if($user->img)
                                <img src="{{ asset($user->img) }}" alt="Profile Image" class="rounded-circle" style="width: 200px; height: 200px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/default-avatar.png') }}" alt="Default Profile" class="rounded-circle" style="width: 200px; height: 200px; object-fit: cover;">
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Họ Và Tên:</strong> {{ $user->name }}</p>
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>Căn Cước Công Dân:</strong> {{ $user->id_number }}</p>
                                <p><strong>Số Điện Thoại:</strong> {{ $user->phone }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Giới Tính:</strong> {{ ucfirst($user->gender) }}</p>
                                <p><strong>Vai Trò:</strong> {{ $user->role == 1 ? 'Teacher' : 'Parent' }}</p>
                                <p><strong>Trạng Thái:</strong> {{ $user->status }}</p>
                                <p><strong>Địa Chỉ:</strong> {{ $user->address }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Edit Profile</a>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

</body>
</html>