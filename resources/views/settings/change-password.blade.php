@extends('layout.main')

@section('content')

<style>
    input[type="checkbox"] {
        width: 28px;
        height: 28px;
        accent-color: green;
        /* For modern browsers */
    }

    /* Fallback for browsers without accent-color support */
    input[type="checkbox"]:checked {
        background-color: green;
        border: none;
    }

    input[type="radio"] {
        width: 24px;
        height: 24px;
        accent-color: green;
        /* Modern browser support */
    }
</style>

<div class="main-inner">

    <div class=" flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col  gap-2">
            <div class="flex items-center gap-3">
                <h1 class="text-lg font-semibold uppercase">
                    Change Password
                </h1>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-2 md:grid-cols-3 gap-6  min-h-screen md-4">
        <div class="col-span-2 md:col-span-1  dark:bg-bg3 rounded-2xl ">

            <div class="box">

                <form action="{{ route('settings.profile-update-password') }}" method="POST" >
                    @csrf
                    <div class="mb-4">
                        <label for="old_password" class="block font-medium mb-2">Current Password <span
                                class="text-red-500">*</span></label>
                        <input type="password" id="" name="old_password"
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                            placeholder="Enter Current Password">
                    </div>
                    @error('old_password')
                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div class="mb-4 text-primary">
                        (we need your current password to confirm your changes)
                    </div>

                    <div class="mb-4">
                        <label for="new_password" class="block font-medium mb-2">New Password <span
                                class="text-red-500">*</span></label>
                        <input type="password" id="" name="new_password"
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                            placeholder="Enter New Password">
                    </div>
                    @error('new_password')
                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div class="mb-4">
                        <label for="new_password_confirmation" class="block font-medium mb-2">
                            Password Confirmation
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="" name="new_password_confirmation"
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                            placeholder="Confirm New Password">
                    </div>
                    @error('new_password_confirmation')
                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <div class="flex justify-center mt-8 gap-4 pt-6">
                        <button type="submit" class="btn-primary uppercase">
                            Change
                        </button>
                        <a href="{{ route('settings.profile') }}" class="btn-outline uppercase">Back</a>
                    </div>

                </form>

            </div>

        </div>
    </div>

</div>

@endsection