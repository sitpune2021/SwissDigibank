@extends('layout.main')

@section('content')

<style>

    body{
        background:#f3f6fb;
    }

    input[type="checkbox"],
    input[type="radio"]{
        accent-color:#16a34a;
    }

    .glass-card{
        background:rgba(255,255,255,0.88);
        backdrop-filter:blur(10px);
    }

    .custom-input{
        width:100%;
        height:56px;
        border:1px solid #dbe3ee;
        background:#f8fafc;
    }

    .radio-card{
        background:#fff;
        border:1px solid #e5e7eb;
        border-radius:18px;
        min-height:56px;
    }

    .menu-scroll::-webkit-scrollbar{
        height:5px;
    }

    .menu-scroll::-webkit-scrollbar-thumb{
        background:#d1d5db;
        border-radius:20px;
    }

    .menu-tab.active-tab{
        background:#2563eb !important;
        color:#fff !important;
        border-color:#2563eb !important;
    }

</style>

<div class="w-full px-2 md:px-4 py-5">

    <div class="glass-card rounded-[28px] shadow-xl border border-white/50 p-4 md:p-8">

        {{-- HEADER --}}
        <div class="mb-8">

            <h2 class="text-2xl md:text-4xl font-bold text-gray-800">
                View Role / Permission
            </h2>

            <p class="text-gray-500 mt-2 text-sm md:text-base">
                Role access & permission details
            </p>

        </div>

        {{-- FORM AREA --}}
        <div class="bg-gradient-to-br from-blue-50 via-white to-indigo-50
                    rounded-[28px] p-4 md:p-7 border border-blue-100 shadow-inner">

            {{-- FIRST ROW --}}
            <div class="grid grid-cols-12 gap-6">

                {{-- ROLE --}}
                <div class="col-span-12 md:col-span-6">

                    <label class="font-semibold text-gray-700 mb-2 block">
                        Role Name
                    </label>

                    <select disabled
                        class="custom-input rounded-2xl px-4">

                        @foreach($roles as $role)

                            <option value="{{ $role->id }}"
                                {{ $rolePermission->role_id == $role->id ? 'selected' : '' }}>

                                {{ $role->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- ROLE POSITION --}}
                <div class="col-span-12 md:col-span-6">

                    <label class="font-semibold text-gray-700 mb-2 block">
                        Role Position
                    </label>

                    <input type="text"
                        readonly
                        value="{{ $rolePermission->role_position }}"
                        class="custom-input rounded-2xl px-4">

                </div>

            </div>

            <div class="h-6"></div>

            {{-- SECOND ROW --}}
            <div class="grid grid-cols-12 gap-6">

                {{-- PERMISSION TYPE --}}
                <div class="col-span-12 md:col-span-6">

                    <label class="font-semibold text-gray-700 mb-2 block">
                        Permission Type
                    </label>

                    <div class="radio-card flex flex-wrap items-center gap-6 px-5 py-4 shadow-sm">

                        <label class="flex items-center gap-2">

                            <input type="radio"
                                disabled
                                {{ $rolePermission->permission_type == 'admin' ? 'checked' : '' }}>

                            Admin

                        </label>

                        <label class="flex items-center gap-2">

                            <input type="radio"
                                disabled
                                {{ $rolePermission->permission_type == 'agent' ? 'checked' : '' }}>

                            Agent

                        </label>

                        <label class="flex items-center gap-2">

                            <input type="radio"
                                disabled
                                {{ $rolePermission->permission_type == 'both' ? 'checked' : '' }}>

                            Both

                        </label>

                    </div>

                </div>

                {{-- ACTIVE --}}
                <div class="col-span-12 md:col-span-6">

                    <label class="font-semibold text-gray-700 mb-2 block">
                        Active Status
                    </label>

                    <div class="radio-card flex items-center gap-6 px-5 py-4 shadow-sm">

                        <label class="flex items-center gap-2">

                            <input type="radio"
                                disabled
                                {{ $rolePermission->active == 'Yes' ? 'checked' : '' }}>

                            Yes

                        </label>

                        <label class="flex items-center gap-2">

                            <input type="radio"
                                disabled
                                {{ $rolePermission->active == 'No' ? 'checked' : '' }}>

                            No

                        </label>

                    </div>

                </div>

            </div>

        </div>

        {{-- MENU TABS --}}
        <div class="mt-10">

            <div class="menu-scroll flex gap-3 overflow-x-auto pb-3">

                @foreach($menuItems as $menu)

                    <button
                        type="button"
                        class="menu-tab shrink-0 px-6 py-3 rounded-2xl
                               bg-white border border-gray-200
                               font-semibold text-gray-700"
                        data-target="{{ $menu['id'] }}">

                        {{ $menu['title'] }}

                    </button>

                @endforeach

            </div>

        </div>

        {{-- TAB CONTENT --}}
        <div class="mt-6 space-y-6">

            {{-- DASHBOARD --}}
            <div id="dashboardSection" class="permission-section hidden">

                @include('roles.checkboxes.dashboard')

            </div>

            {{-- COMPANY --}}
            <div id="companySection" class="permission-section hidden">

                @include('roles.checkboxes.company')

            </div>

            {{-- USER --}}
            <div id="userSection" class="permission-section hidden">

                @include('roles.checkboxes.user')

            </div>

            {{-- COLLECTION CENTER --}}
            <div id="collectionCenter" class="permission-section hidden">

                @include('roles.checkboxes.collection-center')

            </div>

            {{-- CUSTOMER --}}
            <div id="customer" class="permission-section hidden overflow-auto">

                @include('roles.checkboxes.member-management')

            </div>

        </div><br>

        {{-- BACK BUTTON --}}
        <div class="mt-10 pt-6 border-t border-gray-200">

            <a href="{{ route('roles.index') }}"
                class="inline-flex items-center justify-center
                    min-w-[220px]
                    px-8 py-4
                    rounded-2xl
                    text-black font-bold text-base md:text-lg
                    shadow-lg hover:shadow-2xl
                    transition-all duration-300 hover:scale-[1.02]"
                style="background:linear-gradient(90deg,#e1d315,#e30f0f);">

                BACK

            </a>

        </div>

    </div>

</div>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const tabs = document.querySelectorAll(".menu-tab");

    const sections = document.querySelectorAll(".permission-section");

    tabs.forEach(tab => {

        tab.addEventListener("click", function () {

            const target = this.dataset.target;

            sections.forEach(section => {

                section.classList.add("hidden");

            });

            document.getElementById(target)
                .classList.remove("hidden");

            tabs.forEach(btn => {

                btn.classList.remove("active-tab");

            });

            this.classList.add("active-tab");

        });

    });

    // DEFAULT TAB
    if (tabs.length > 0) {

        tabs[0].click();

    }

});

</script>

@endsection