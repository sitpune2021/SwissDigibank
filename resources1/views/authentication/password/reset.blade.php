@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10">
    <h2 class="text-lg font-bold">Reset Password</h2>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="email" name="email" value="{{ $email ?? old('email') }}" class="border p-2 w-full mt-4" required>
        <input type="password" name="password" placeholder="New password" class="border p-2 w-full mt-4" required>
        <input type="password" name="password_confirmation" placeholder="Confirm new password" class="border p-2 w-full mt-4" required>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 mt-4">Reset Password</button>
    </form>
</div>
@endsection
