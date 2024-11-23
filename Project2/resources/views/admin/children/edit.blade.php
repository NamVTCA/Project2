@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Edit Child Information</h4>
                    <a href="{{ route('children.show', $child->id) }}" class="btn btn-secondary">Back</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('children.update', $child->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="text-center mb-4">
                            <img src="{{ $child->img ? asset('storage/'.$child->img) : asset('images/default-avatar.png') }}" 
                                 alt="Current Profile Picture"
                                 id="preview-image"
                                 class="rounded-circle mb-3"
                                 style="width: 150px; height: 150px; object-fit: cover;">
                            
                            <div class="mb-3">
                                <input type="file" class="form-control" name="img" id="img" accept="image/*">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fullname" class="form-label">Full Name</label>
                                <input type="text" class="form-control @error('fullname') is-invalid @enderror" 
                                       id="fullname" name="fullname" value="{{ old('fullname', $child->fullname) }}">
                                @error('fullname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="birthyear" class="form-label">Birth Year</label>
                                <input type="date" class="form-control @error('birthyear') is-invalid @enderror" 
                                       id="birthyear" name="birthyear" value="{{ old('birthyear', $child->birthyear) }}">
                                @error('birthyear')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                    <option value="1" {{ $child->gender == 1 ? 'selected' : '' }}>Male</option>
                                    <option value="2" {{ $child->gender == 2 ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="userId" class="form-label">Parent</label>
                                <select class="form-select @error('userId') is-invalid @enderror" id="userId" name="userId">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" 
                                                {{ $child->userId == $user->id ? 'selected' : '' }}>
                                            {{ $user->fullname }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('userId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                    <option value="active" {{ $child->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $child->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('img').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
        }
        reader.readAsDataURL(this.files[0]);
    });
</script>
@endpush
@endsection