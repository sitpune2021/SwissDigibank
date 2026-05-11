@extends('layout.main')

@section('content')

<style>
    body{
        background: #f3f6fb;
    }

    input[type="checkbox"],
    input[type="radio"]{
        accent-color: #16a34a;
    }

    button{
        overflow: visible !important;
        white-space: nowrap;
    }

    .menu-scroll::-webkit-scrollbar{
        height: 5px;
    }

    .menu-scroll::-webkit-scrollbar-thumb{
        background: #d1d5db;
        border-radius: 20px;
    }

    .glass-card{
        background: rgba(255,255,255,0.88);
        backdrop-filter: blur(10px);
    }

    .custom-input{
        width: 100%;
        background: #f8fafc;
        border: 1px solid #dbe3ee;
        transition: .3s;
        height: 56px;
    }

    .custom-input:focus{
        background: white;
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37,99,235,0.08);
        outline: none;
    }

    .radio-card{
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        min-height: 56px;
    }

    .menu-tab.active-tab{
    background: #2563eb !important;
    color: white !important;
    border-color: #2563eb !important;
}
</style>

<div class="w-full px-2 md:px-4 py-5">

    {{-- MAIN CARD --}}
    <div class="glass-card rounded-[28px] shadow-xl border border-white/50 p-4 md:p-8">

        {{-- HEADER --}}
        <div class="mb-8">

            <h2 class="text-2xl md:text-4xl font-bold text-gray-800">
                Add Role / Permission
            </h2>

            <p class="text-gray-500 mt-2 text-sm md:text-base">
                Manage role access & permission settings
            </p>

        </div>

        <form action="{{ route('role_permission.store') }}" method="POST">
            @csrf

            {{-- FORM AREA --}}
            <div class="bg-gradient-to-br from-blue-50 via-white to-indigo-50
                        rounded-[28px] p-4 md:p-7 border border-blue-100 shadow-inner">

                {{-- FIRST ROW --}}
                <div class="grid grid-cols-12 gap-6">

                    {{-- ROLE NAME --}}
                    <div class="col-span-12 md:col-span-6">

                        <label class="font-semibold text-gray-700 mb-2 flex items-center gap-1">
                            Role Name
                            <span class="text-red-500 text-lg">*</span>
                        </label>

                        <select
                            name="role_id"
                            class="custom-input rounded-2xl px-4
                            @error('role_id') border-red-500 bg-red-50 @enderror">

                            <option value="">
                                Select Role
                            </option>

                            @foreach($roles as $role)

                                <option value="{{ $role->id }}"
                                    {{ old('role_id') == $role->id ? 'selected' : '' }}>

                                    {{ $role->name }}

                                </option>

                            @endforeach

                        </select>

                        {{-- VALIDATION MESSAGE --}}
                        @error('role_id')

                            <div class="mt-2 flex items-center gap-2
                                        bg-red-50 border border-red-200
                                        text-red-600 px-4 py-3 rounded-xl
                                        text-sm font-medium">

                                <span class="text-lg">⚠</span>

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    {{-- ROLE POSITION --}}
                    <div class="col-span-12 md:col-span-6">

                        <label class="font-semibold text-gray-700 mb-2 block">
                            Role Position
                        </label>

                        <input type="text"
                            name="role_position"
                            placeholder="Enter Role Position"
                            class="custom-input rounded-2xl px-4">

                    </div>

                </div>

                {{-- SPACE --}}
                <div class="h-6"></div>

                {{-- SECOND ROW --}}
                <div class="grid grid-cols-12 gap-6 mt-6">

                    {{-- PERMISSION TYPE --}}
                    <div class="col-span-12 md:col-span-6">

                        <label class="font-semibold text-gray-700 mb-2 block">
                            Permission Type
                        </label>

                        <div class="radio-card flex flex-wrap items-center gap-6 px-5 py-4 shadow-sm">

                            <label class="flex items-center gap-2 font-medium text-gray-700">
                                <input type="radio" name="permission_type" value="admin">
                                Admin
                            </label>

                            <label class="flex items-center gap-2 font-medium text-gray-700">
                                <input type="radio" name="permission_type" value="agent">
                                Agent
                            </label>

                            <label class="flex items-center gap-2 font-medium text-gray-700">
                                <input type="radio" name="permission_type" value="both" checked>
                                Both
                            </label>

                        </div>

                    </div>

                    {{-- ACTIVE STATUS --}}
                    <div class="col-span-12 md:col-span-6">

                        <label class="font-semibold text-gray-700 mb-2 block">
                            Active Status
                        </label>

                        <div class="radio-card flex items-center gap-6 px-5 py-4 shadow-sm">

                            <label class="flex items-center gap-2 font-medium text-gray-700">
                                <input type="radio" name="active" value="Yes" checked>
                                Yes
                            </label>

                            <label class="flex items-center gap-2 font-medium text-gray-700">
                                <input type="radio" name="active" value="No">
                                No
                            </label>

                        </div>

                    </div>

                </div>

            </div><br>

            {{-- MENU TABS --}}
            <div class="mt-10">

                <div class="menu-scroll flex gap-3 overflow-x-auto pb-3">

                    @foreach($menuItems as $menu)

                        <button
                            type="button"
                            class="menu-tab shrink-0 px-6 py-3 rounded-2xl
                                   bg-white border border-gray-200
                                   font-semibold text-gray-700
                                   hover:bg-primary hover:text-white
                                   transition-all duration-300"
                            data-target="{{ $menu['id'] }}">

                            {{ $menu['title'] }}

                        </button>

                    @endforeach

                </div>

            </div>

            {{-- TAB CONTENT --}}
            <div class="mt-6 space-y-6">

                {{-- DASHBOARD --}}
                <div id="dashboardSection"
                    class="permission-section hidden">

                    @include('roles.checkboxes.dashboard')

                </div>

                {{-- COMPANY --}}
                <div id="companySection"
                    class="permission-section hidden">

                    @include('roles.checkboxes.company')

                </div>

                {{-- USER --}}
                <div id="userSection"
                    class="permission-section hidden">

                    @include('roles.checkboxes.user')

                </div>

                {{-- COLLECTION CENTER --}}
                <div id="collectionCenter"
                    class="permission-section hidden">

                    @include('roles.checkboxes.collection-center')

                </div>

               <div id="customer"
                    class="permission-section hidden overflow-auto">

                    @include('roles.checkboxes.member-management')

                </div>

            </div><br>

            {{-- BUTTONS --}}
            <div class="mt-10 pt-6 border-t border-gray-200">

                <div class="flex flex-wrap items-center gap-4">

                    {{-- SAVE --}}
                    <button type="submit"
                        class="inline-flex items-center justify-center
                            min-w-[220px]
                            text-black font-bold text-base md:text-lg
                            px-8 py-4
                            rounded-2xl
                            shadow-lg hover:shadow-2xl
                            transition-all duration-300
                            hover:scale-[1.02]"
                        style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">

                        Save Permission

                    </button>

                    {{-- CANCEL --}}
                    <button type="reset"
                        class="inline-flex items-center justify-center
                            min-w-[180px]
                            bg-white hover:bg-gray-100
                            border border-gray-300
                            text-gray-700 font-bold text-base md:text-lg
                            px-8 py-4
                            rounded-2xl
                            shadow-md hover:shadow-lg
                            transition-all duration-300">

                        Cancel

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<script>

document.addEventListener("DOMContentLoaded", function () {

    // =====================================
    // TAB SWITCHING
    // =====================================

    const tabs = document.querySelectorAll(".menu-tab");

    const sections = document.querySelectorAll(".permission-section");

    tabs.forEach(tab => {

        tab.addEventListener("click", function () {

            const target = this.dataset.target;

            // HIDE ALL
            sections.forEach(section => {

                section.classList.add("hidden");

            });

            // SHOW ACTIVE
            document.getElementById(target)
                .classList.remove("hidden");

            // REMOVE ACTIVE STYLE
            tabs.forEach(btn => {

                btn.classList.remove("active-tab");

            });

            // ACTIVE STYLE
            this.classList.add("active-tab");

        });

    });

    // DEFAULT TAB
    if (tabs.length > 0) {

        tabs[0].click();

    }

    // =====================================
    // CHECK ALL FUNCTION
    // =====================================

    document.querySelectorAll(".payload-section").forEach(section => {

        const checkAll = section.querySelector(".check-all");

        const items = section.querySelectorAll(".item-checkbox");

        if (!checkAll) return;

        // CHECK ALL
        checkAll.addEventListener("change", function () {

            items.forEach(item => {

                item.checked = this.checked;

            });

        });

        // SINGLE CHECKBOX
        items.forEach(item => {

            item.addEventListener("change", function () {

                const allChecked =
                    Array.from(items).every(i => i.checked);

                checkAll.checked = allChecked;

            });

        });

    });

});

</script>

@endsection