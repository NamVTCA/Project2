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
        <h2>Create New User</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="text" name="password" class="form-control">
            </div>            

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" pattern="[A-Za-z\s]+" title="Please enter only letters and spaces" value="{{ old('name', $user->name ?? '') }}">
            </div>

            <div class="form-group">
                <label>ID Number</label>
                <input type="number" name="id_number" class="form-control" pattern="[0-9]+" title="Please enter only numbers" value="{{ old('id_number', $user->id_number ?? '') }}">
            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="{{ old('address') }}">
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control">
                    <option value="1">Teacher</option>
                    <option value="2">Parent</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <input type="number" name="status" class="form-control" value="{{ old('status') }}">
            </div>

            <div class="form-group">
                <label>Gender</label>
                <select name="gender" class="form-control">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="tel" name="phone" class="form-control" pattern="[0-9]+" title="Please enter only numbers" value="{{ old('phone', $user->phone ?? '') }}">
            </div>

            <div class="form-group">
                <label>Image</label>
                <input type="file" name="img" class="form-control-file">
            </div>

            <button type="submit" class="btn btn-primary">Create User</button>
        </form>
    </div>
    @endsection
</body>
</html>