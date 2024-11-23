@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Child Profile</h4>
                    <a href="{{ route('children.index') }}" class="btn btn-secondary">Back</a>
                </div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ $child->img ? asset('storage/'.$child->img) : asset('images/default-avatar.png') }}" 
                             alt="Profile Picture"
                             class="rounded-circle"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>Personal Information</h5>
                            <table class="table">
                                <tr>
                                    <th>Full Name:</th>
                                    <td>{{ $child->fullname }}</td>
                                </tr>
                                <tr>
                                    <th>Birth Year:</th>
                                    <td>{{ $child->birthyear }}</td>
                                </tr>
                                <tr>
                                    <th>Gender:</th>
                                    <td>{{ $child->gender == 1 ? 'Male' : 'Female' }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>{{ $child->status }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Class Information</h5>
                            <table class="table">
                                <tr>
                                    <th>Class:</th>
                                    <td>{{ $child->childClass->class->name ?? 'Not Assigned' }}</td>
                                </tr>
                                <tr>
                                    <th>Parent Name:</th>
                                    <td>{{ $child->user->fullname }}</td>
                                </tr>
                                <tr>
                                    <th>Parent Contact:</th>
                                    <td>{{ $child->user->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Join Date:</th>
                                    <td>{{ $child->createDate->format('d/m/Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('children.edit', $child->id) }}" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection