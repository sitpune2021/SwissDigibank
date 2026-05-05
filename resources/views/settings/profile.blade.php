@extends('layout.main')


@section('content')


<style>
    body {
        background: #f3f4f6;
        font-family: Arial, Helvetica, sans-serif;
    }
    .container {
        max-width: 1100px;
        margin: 60px auto;
        background: #fff;
        padding: 50px;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }
    .header {
        text-align: center;
        margin-bottom: 50px;
    }
    .header h1 {
        color: #06b6d4;
        font-size: 48px;
        margin-bottom: 10px;
    }
    .header p {
        color: #666;
        font-size: 18px;
    }
    .grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 40px;
    }
    .section-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 15px;
    }
    .details p {
        margin-bottom: 12px;
        color: #444;
    }
    .details span {
        font-weight: bold;
    }
    .social-icons a {
        margin-right: 12px;
        color: #444;
        text-decoration: none;
        font-size: 18px;
    }
    .about p {
        color: #555;
        line-height: 1.6;
    }
    .credit {
        font-size: 12px;
        color: #aaa;
        margin-top: 15px;
    }
    .btn {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 28px;
        background: #111;
        color: #fff;
        border-radius: 30px;
        text-decoration: none;
        transition: 0.3s;
    }
    .btn:hover {
        background: #333;
    }
    .profile-card {
        /* background: #16f95a; */
        color: #fff;
        padding: 40px 25px;
        border-radius: 10px;
        text-align: center;
        position: relative;
    }
    .profile-img {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        border: 5px solid #fff;
        
        object-fit: cover;
        margin-top: -100px;
        margin-bottom: 15px;
        margin-left: auto;
        margin-right: auto;
    }
    .profile-card h3 {
        font-size: 20px;
        font-weight: bold;
        letter-spacing: 1px;
        margin: 10px 0;
    }
    .profile-card p {
        font-size: 14px;
        line-height: 1.6;
        margin-top: 10px;
    }
    .profile-social a {
        color: #fff;
        margin: 0 10px;
        font-size: 18px;
        text-decoration: none;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .grid {
            grid-template-columns: 1fr;
        }
        .profile-img {
        margin-top: 0;
        margin-left: auto;
        margin-right: auto;
    }
    }
    
    .breadcrumb {
        list-style: none;
        display: flex;
        padding: 0;
        margin-bottom: 1rem;
        font-size: 14px;
    }

    .breadcrumb li+li::before {
        content: "/";
        padding: 0 8px;
        color: #888;
    }

    .breadcrumb li a {
        text-decoration: none;
        color: #007bff;
    }

    .breadcrumb li.active {
        color: #555;
    }

    .custom-thead {
        background-color: #e6f4ea;
        color: #14532d;
    }

    .custom-thead th {
        font-weight: 600;
        border-bottom: 1px solid #ccc;
    }

    @media (prefers-color-scheme: dark) {
        .custom-thead {
            background-color: #14532d;
            color: #d1fae5;
        }
    }

    .bg-greens {
        background-color: #14532d;
    }

    .backdrop {
        backdrop-filter: blur(1px);
        -webkit-backdrop-filter: blur(1px);
        background-color: rgba(0, 0, 0, 0.1);


    }

</style>

<div class="main-inner">
    
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
        <h3 class=" flex text-xl  uppercase font-semibold">
           My Account
        </h3>
    </div>

    <div class="">
        <div class="w-44 mb-5 flex justify-end">
            <x-alert />
        </div>
    </div>

    <div class=" box">

        <div class="grid">

            <div class="profile-card bg-primary text-center">

                <img src="{{ $user?->profilePhoto?->filename
                    ? asset('storage/profile_photos/' . $user->profilePhoto->filename)
                    : asset('assets/images/user-big-4.png') }}"
                    class="profile-img bg-secondary/5"
                    alt="Profile">

                <form id="photoForm"
                    action="{{ route('settings.profile-photo.update') }}"
                    method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Hidden File Input -->
                    <input type="file" name="photo" id="photoInput" hidden
                        accept="image/*"
                        onchange="validateImage(this)">
                </form>

                <!-- Button that triggers file picker -->
                <button type="button"
                        onclick="document.getElementById('photoInput').click();"
                        class="btn-secondary cursor-pointer rounded-10 mt-5">
                    <i class="las la-upload"></i> UPDATE IMAGE
                </button>

                @error('photo')
                    <p class="text-error text-sm mt-2">{{ $message }}</p>
                @enderror

            </div>

            <!-- Details -->
            <div class="details flex flex-col gap-2">

                <div class="section-title uppercase">
                    {{ optional($user)->fname }} {{ optional($user)->lname }}
                </div>
                <div class="flex  items-center justify-start gap-3 ">
                    <p class="">
                        <i class="las la-envelope "></i>
                    </p>
                    <p>{{ $user?->email ?? 'No email available' }}</p>
                </div>
                <div class="flex items-center justify-start gap-3 ">
                    <p class="">
                        <i class="las la-users"></i>
                    </p>
                    <p>{{ $user?->name ?? 'Guest User' }}</p>
                </div>
                <div class="flex  items-center justify-start gap-3 ">
                    <p class="">
                        <i class="las la-building"></i>
                    </p>
                <p class=" " >All (static)</p>
                </div>
                <div class="flex items-center justify-start gap-3 ">
                    <p class="">
                    <i class="las la-signal"></i>
                    </p>
                    <p>{{ $user?->user_active ? 'Active' : 'Inactive' }}</p>
                </div>
                
                <div class="">       
                    <a href="{{ route('settings.profile-change-password') }}" class="btn-outline rounded-10 uppercase text-sm cursor-pointer">
                    <i class="las la-sync"></i>   
                        Change Password
                    </a>
                </div>

            </div>
                
        </div>

    </div>

    <script>
        function validateImage(input) {
            const file = input.files[0];

            if (!file) return;

            // ❌ size check (2MB limit)
            if (file.size > 2 * 1024 * 1024) {
                alert("Image must be less than 2MB");
                input.value = "";
                return;
            }

            // ✅ submit only if valid
            document.getElementById('photoForm').submit();
        }
    </script>


@endsection