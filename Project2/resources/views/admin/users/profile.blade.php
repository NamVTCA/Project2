@extends('layouts.dashboard')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <div class="profile-image">
            @if($user->img)
                <img src="{{ asset('storage/' . $user->img) }}" alt="Profile Image">
            @else
                <div class="default-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
        </div>
        <div class="profile-basic-info">
            <h1>{{ $user->name }}</h1>
            <p class="role-badge {{ $user->role == 1 ? 'teacher' : 'parent' }}">
                {{ $user->role == 1 ? 'Giáo viên' : 'Phụ huynh' }}
            </p>
            <p class="status-badge {{ $user->status == 1 ? 'active' : 'inactive' }}">
                {{ $user->status == 1 ? 'Đang hoạt động' : 'Không hoạt động' }}
            </p>
        </div>
    </div>

    <div class="profile-content">
        <div class="info-section">
            <h2>Thông tin cá nhân</h2>
            <div class="info-grid">
                <div class="info-item">
                    <label>Email:</label>
                    <p>{{ $user->email }}</p>
                </div>
                <div class="info-item">
                    <label>Số điện thoại:</label>
                    <p>{{ $user->phone }}</p>
                </div>
                <div class="info-item">
                    <label>CMND/CCCD:</label>
                    <p>{{ $user->id_number }}</p>
                </div>
                <div class="info-item">
                    <label>Giới tính:</label>
                    <p>
                        @switch($user->gender)
                            @case('male')
                                Nam
                                @break
                            @case('female')
                                Nữ
                                @break
                            @default
                                Khác
                        @endswitch
                    </p>
                </div>
                <div class="info-item full-width">
                    <label>Địa chỉ:</label>
                    <p>{{ $user->address }}</p>
                </div>
            </div>
        </div>

        @if($user->role == 1)
            <div class="info-section">
                <h2>Thông tin giảng dạy</h2>
                <div class="classes-grid">
                    @foreach($classrooms as $classroom)
                        <div class="class-card">
                            <h3>{{ $classroom->name }}</h3>
                            <div class="class-stats">
                                <div class="stat-item">
                                    <label>Số học sinh:</label>
                                    <p>{{ $classroom->children->count() }}</p>
                                </div>
                                <div class="stat-item">
                                    <label>Trạng thái:</label>
                                    <p class="status-badge {{ $classroom->status ? 'active' : 'inactive' }}">
                                        {{ $classroom->status ? 'Đang hoạt động' : 'Không hoạt động' }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('classrooms.show', $classroom->id) }}" class="btn-view">
                                Xem chi tiết lớp học
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="info-section">
                <h2>Thông tin học sinh</h2>
                <div class="children-grid">
                    @foreach($children as $child)
                        <div class="child-card">
                            <div class="child-image">
                                @if($child->img)
                                    <img src="{{ asset('storage/' . $child->img) }}" alt="{{ $child->name }}">
                                @else
                                    <div class="default-avatar">
                                        {{ strtoupper(substr($child->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="child-info">
                                <h3>{{ $child->name }}</h3>
                                <div class="info-item">
                                    <label>Ngày sinh:</label>
                                    <p>{{ \Carbon\Carbon::parse($child->birthDate)->format('d/m/Y') }}</p>
                                </div>
                                <div class="info-item">
                                    <label>Giới tính:</label>
                                    <p>{{ $child->gender == 1 ? 'Nam' : 'Nữ' }}</p>
                                </div>
                                @if($child->classroom->first())
                                    <div class="info-item">
                                        <label>Lớp:</label>
                                        <p>{{ $child->classroom->first()->name }}</p>
                                    </div>
                                @endif
                            </div>
                            <a href="{{ route('children.show', $child->id) }}" class="btn-view">
                                Xem chi tiết
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<style>

.classes-grid, .children-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.class-card, .child-card {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.child-image {
    width: 100px;
    height: 100px;
    margin: 0 auto 15px;
}

.child-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.child-info {
    text-align: center;
}

.child-info h3 {
    margin: 0 0 15px 0;
    color: #333;
}

.class-stats {
    margin: 15px 0;
}

.btn-view {
    display: block;
    text-align: center;
    padding: 8px 15px;
    background: #007bff;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    margin-top: 15px;
    transition: background 0.3s;
}

.btn-view:hover {
    background: #0056b3;
    color: white;
    text-decoration: none;
}

@media (max-width: 768px) {
    .classes-grid, .children-grid {
        grid-template-columns: 1fr;
    }
    
    .profile-header {
        flex-direction: column;
        text-align: center;
    }
    
    .profile-image {
        margin: 0 0 20px 0;
    }
}
</style>
@endsection