@extends('layout.main')
@section('page-title', '')

@section('content')
<div class="box p-6">
    <h3 class="text-xl font-bold mb-4">Role Details</h3>

    <p><strong>Role:</strong> {{ $rolePermission->role->name }}</p>
    <p><strong>Position:</strong> {{ $rolePermission->role_position }}</p>
    <p><strong>Type:</strong> {{ $rolePermission->permission_type }}</p>
    <p><strong>Status:</strong> {{ $rolePermission->active }}</p>

    <h4 class="mt-4 font-semibold">Permissions:</h4>
    <ul class="list-disc ml-6">
        @foreach($rolePermission->permissions as $permission)
            <li>{{ $permission }}</li>
        @endforeach
    </ul>
</div>
@endsection