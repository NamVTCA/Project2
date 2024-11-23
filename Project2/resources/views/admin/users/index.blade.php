@extends('layouts.dashboard')

@section('content')
<div class="users-container">
    <div class="header">
        <h1>Users Management</h1>
        <a href="{{ route('users.create') }}" class="btn-add">Add New User</a>
    </div>

    <div class="tabs">
        <button class="tab-btn active" data-tab="teachers">Teachers</button>
        <button class="tab-btn" data-tab="parents">Parents</button>
    </div>

    <div class="tab-content active" id="teachers">
        <div class="users-grid">
            @foreach($teachers as $teacher)
                <div class="user-card">
                    <div class="user-image">
                        @if($teacher->img)
                            <img src="{{ asset('storage/' . $teacher->img) }}" alt="Profile">
                        @else
                            <div class="default-avatar">
                                {{ strtoupper(substr($teacher->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="user-info">
                        <h3>{{ $teacher->name }}</h3>
                        <p class="email">{{ $teacher->email }}</p>
                        <p class="phone">{{ $teacher->phone }}</p>
                    </div>
                    <div class="user-actions">
                        <a href="{{ route('users.show', $teacher->id) }}" class="btn-view">View</a>
                        <a href="{{ route('users.edit', $teacher->id) }}" class="btn-edit">Edit</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="tab-content" id="parents">
        <div class="users-grid">
            @foreach($parents as $parent)
                <div class="user-card">
                    <div class="user-image">
                        @if($parent->img)
                            <img src="{{ asset('storage/' . $parent->img) }}" alt="Profile">
                        @else
                            <div class="default-avatar">
                                {{ strtoupper(substr($parent->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="user-info">
                        <h3>{{ $parent->name }}</h3>
                        <p class="email">{{ $parent->email }}</p>
                        <p class="phone">{{ $parent->phone }}</p>
                    </div>
                    <div class="user-actions">
                        <a href="{{ route('users.show', $parent->id) }}" class="btn-view">View</a>
                        <a href="{{ route('users.edit', $parent->id) }}" class="btn-edit">Edit</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
.users-container {
    padding: 20px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.btn-add {
    background: #007bff;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
}

.tabs {
    margin-bottom: 20px;
}

.tab-btn {
    padding: 10px 20px;
    border: none;
    background: none;
    cursor: pointer;
    font-size: 16px;
    color: #666;
}

.tab-btn.active {
    color: #007bff;
    border-bottom: 2px solid #007bff;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

.users-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.user-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.user-image {
    width: 80px;
    height: 80px;
    margin-bottom: 15px;
}

.user-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.default-avatar {
    width: 100%;
    height: 100%;
    background: #007bff;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    border-radius: 50%;
}

.user-info h3 {
    margin: 0 0 5px 0;
    color: #333;
}

.user-info p {
    margin: 0;
    color: #666;
    font-size: 14px;
}

.user-actions {
    margin-top: 15px;
    display: flex;
    gap: 10px;
}

.btn-view, .btn-edit {
    padding: 5px 15px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 14px;
}

.btn-view {
    background: #e3f2fd;
    color: #1976d2;
}

.btn-edit {
    background: #f3e5f5;
    color: #7b1fa2;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));

            tab.classList.add('active');
            document.getElementById(tab.dataset.tab).classList.add('active');
        });
    });
});
</script>
@endsection