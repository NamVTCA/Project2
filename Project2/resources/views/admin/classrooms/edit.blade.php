@extends('layouts.dashboard')

@section('content')
<div>
    <h2>Edit Class Information</h2>

    @if($errors->any())
        <div style="color: red; margin: 10px 0;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('classrooms.update', $classroom->id) }}" method="POST" id="classForm">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label>Class Name:</label>
            <input type="text" name="name" value="{{ old('name', $classroom->name) }}" required>
            <span class="error-message"></span>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Teacher:</label>
            <select name="user_id" required>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('user_id', $classroom->user_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Status:</label>
            <select name="status" required>
                <option value="1" {{ old('status', $classroom->status) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status', $classroom->status) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit">Update Class</button>
    </form>
</div>
@endsection