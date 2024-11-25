@extends('layouts.dashboard')

@section('content')
<div>
    <h2>Create New Child</h2>

    @if($errors->any())
        <div style="color: red; margin: 10px 0;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('children.store') }}" method="POST" enctype="multipart/form-data" id="childForm">
        @csrf
        <div style="margin-bottom: 15px;">
            <label>Name:</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
            <span class="error-message"></span>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Birth Date:</label>
            <input type="date" name="birthDate" value="{{ old('birthDate') }}" required>
            <span class="error-message"></span>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Gender:</label>
            <select name="gender" required>
                <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>Male</option>
                <option value="2" {{ old('gender') == 2 ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Parent:</label>
            <select name="user_id" required>
                @php
                    $parents = App\Models\User::where('role', 2)->get();
                @endphp
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" {{ old('user_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Status:</label>
            <select name="status" required>
                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Image:</label>
            <input type="file" name="img" accept="image/jpeg,image/png,image/jpg">
        </div>

        <button type="submit">Create Child</button>
    </form>
</div>
@endsection