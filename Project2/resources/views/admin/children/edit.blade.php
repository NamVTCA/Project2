@extends('layouts.dashboard')

@section('content')
<div>
    <h2>Edit Child Information</h2>

    @if($errors->any())
        <div style="color: red; margin: 10px 0;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('children.update', $child->id) }}" method="POST" enctype="multipart/form-data" id="childForm">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label>Name:</label>
            <input type="text" name="name" value="{{ old('name', $child->name) }}" required>
            <span class="error-message"></span>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Birth Date:</label>
            <input type="date" name="birthDate" value="{{ old('birthDate', $child->birthDate) }}" required>
            <span class="error-message"></span>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Gender:</label>
            <select name="gender" required>
                <option value="1" {{ old('gender', $child->gender) == 1 ? 'selected' : '' }}>Male</option>
                <option value="2" {{ old('gender', $child->gender) == 2 ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Parent:</label>
            <select name="user_id" required>
                @php
                    $parents = App\Models\User::where('role', 2)->get();
                @endphp
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" {{ old('user_id', $child->user_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Status:</label>
            <select name="status" required>
                <option value="1" {{ old('status', $child->status) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status', $child->status) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Image:</label>
            @if($child->img)
                <div style="margin: 10px 0;">
                    <img src="{{ asset('storage/' . $child->img) }}" alt="Current Image" style="max-width: 200px;">
                </div>
            @endif
            <input type="file" name="img" accept="image/jpeg,image/png,image/jpg">
            <small style="color: #666;">Leave empty if not changing the image</small>
        </div>

        <button type="submit">Update Child</button>
    </form>
</div>
@endsection