@extends('layout.main')
@extends('layout.tablestyle')

@php
    $permissions = auth()->user()->rolePermission->permissions ?? [];
    $isSuperAdmin = auth()->user()->role_id == 1;
@endphp

@section('action-button')
   @if($isSuperAdmin || in_array('branch.create', $permissions))
        <a href="{{ route('branch.create') }}"
            class="px-4 py-2 rounded-xl text-sm font-semibold shadow-md transition-all duration-200
            hover:scale-105"
            style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">
            ADD BRANCH
        </a>
    @endif
@endsection

@section('page-title')

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

    <!-- LEFT SIDE -->
    <div class="flex items-center gap-3 min-w-0">

        <!-- ICON -->
        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl
            flex items-center justify-center shrink-0 shadow-lg"
            style="
                background: linear-gradient(135deg,#2563eb,#06b6d4,#0ea5e9);
                min-width:44px;
                min-height:44px;
            ">

            <i class="las la-code-branch text-white text-xl sm:text-2xl leading-none"></i>

        </div>

        <!-- TITLE -->
        <div class="min-w-0">

            <h2 class="text-lg sm:text-xl lg:text-2xl
                font-extrabold uppercase tracking-wide
                text-gray-800 leading-tight truncate">

                Branch Management

            </h2>

            <p class="text-[11px] sm:text-sm text-gray-500 font-medium mt-1">

                Manage all branch records, status & operations

            </p>

        </div>

    </div>

    <!-- RIGHT BADGE -->
    <div class="hidden md:flex items-center gap-2
        px-4 py-2 rounded-xl
        bg-gradient-to-r from-slate-100 to-slate-50
        border border-slate-200 shadow-sm">

        <span class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></span>

        <span class="text-xs font-bold uppercase tracking-wider text-slate-600">

            Banking Panel

        </span>

    </div>

</div>

@endsection

@section('content')

<div class="box col-span-12 lg:col-span-6 bank-page-animate">

    <div class="mb-3">
        <x-searchbox />
    </div>

    <!-- TABLE -->
    <div class="table-wrapper w-full overflow-x-auto rounded-2xl border border-gray-200 bg-white shadow-sm table-premium">

        <table class="w-full min-w-[1100px] whitespace-nowrap select-all-table border-separate border-spacing-y-2"

            <thead class="bg-gradient-to-r from-orange-50 via-white to-orange-50 border-b border-gray-200 sticky top-0 z-10">

                <tr class="text-xs sm:text-sm uppercase tracking-wider font-bold">

                    <!-- SR NO -->
                    <th class="px-3 sm:px-5 py-4 text-center min-w-[90px]">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-hashtag text-sm sm:text-base text-black"></i>
                            </div>

                            <span class="text-black whitespace-nowrap">SR NO</span>

                        </div>

                    </th>

                    <th class="px-3 sm:px-5 py-4 text-left">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-building text-sm sm:text-base text-black"></i>
                            </div>
                            <span class="whitespace-nowrap text-black">Branch Name</span>
                        </div>
                    </th>

                    <th class="px-3 sm:px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-city text-sm sm:text-base text-black"></i>
                            </div>
                            <span class="text-black">City</span>
                        </div>
                    </th>

                    <th class="px-3 sm:px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-map-marked-alt text-sm sm:text-base text-black"></i>
                            </div>
                            <span class="text-black">State</span>
                        </div>
                    </th>

                    <th class="px-3 sm:px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-calendar text-sm sm:text-base text-black"></i>
                            </div>
                            <span class="whitespace-nowrap text-black">Opened On</span>
                        </div>
                    </th>

                    <th class="px-3 sm:px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-users text-sm sm:text-base text-black"></i>
                            </div>
                            <span class="text-black">Customers</span>
                        </div>
                    </th>

                    <th class="px-3 sm:px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-toggle-on text-sm sm:text-base text-black"></i>
                            </div>
                            <span class="text-black">Status</span>
                        </div>
                    </th>

                    <th class="px-3 sm:px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-cog text-sm sm:text-base text-black"></i>
                            </div>
                            <span class="text-black">Actions</span>
                        </div>
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($branches as $branch)

                <tr class="table-row border-b border-gray-100"
                    style="animation-delay:{{ $loop->index * 0.05 }}s">

                    <!-- SR NO -->
                    <td class="px-6 py-5 text-center font-semibold text-gray-700">

                        {{ $loop->iteration }}

                    </td>

                    <!-- BRANCH -->
                    <td class="px-6 py-5" data-label="Branch">

                        <div class="flex items-center gap-3">

                            <!-- <div class="w-11 h-11 rounded-xl bg-primary/10 flex items-center justify-center">
                                <i class="las la-building text-primary text-xl"></i>
                            </div> -->

                            <div>

                                <a href="{{ route('branch.show', base64_encode($branch->id)) }}"
                                    class="font-semibold text-primary hover:underline">

                                    {{ $branch->branch_name }}

                                </a>

                                <p class="text-xs text-gray-500 mt-1">
                                    Branch Code : {{ $branch->branch_code }}
                                </p>

                            </div>

                        </div>

                    </td>

                    <!-- CITY -->
                    <td class="px-6 py-5 text-center"
                        data-label="City">

                        {{ $branch->city ?? '-' }}

                    </td>

                    <!-- STATE -->
                    <td class="px-6 py-5 text-center"
                        data-label="State">

                        {{ $branch->State?->name ?? '-' }}

                    </td>

                    <!-- OPEN DATE -->
                    <td class="px-6 py-5 text-center"
                        data-label="Opened On">

                        {{ $branch->open_date ? \Carbon\Carbon::parse($branch->open_date)->format('d-m-Y') : '-' }}

                    </td>

                    <!-- MEMBERS -->
                    <td class="px-6 py-5 text-center"
                        data-label="Customers">

                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                        bg-blue-100 text-blue-700">

                            {{ $branch->Member->count() }}

                        </span>

                    </td>

                    <!-- STATUS -->
                    <td class="px-6 py-5 text-center align-middle" data-label="Status">

                        <div class="flex justify-center">

                            <label class="inline-flex items-center cursor-pointer">

                                <input type="checkbox"
                                    class="sr-only slider-toggle"
                                    data-id="{{ $branch->id }}"
                                    {{ $branch->active === 'Yes' ? 'checked' : '' }}>

                                <div class="relative">
                                    <div class="blocks"></div>
                                    <div class="dot"></div>
                                </div>

                            </label>

                        </div>

                    </td>

                    <!-- ACTIONS -->
                    <td class="px-6 py-5 text-center align-middle" data-label="Actions">

                        <div class="action-group">

                            {{-- VIEW --}}
                            @if($isSuperAdmin || in_array('branch.show', $permissions))
                            <a href="{{ route('branch.show', base64_encode($branch->id)) }}"
                                class="action-btn action-view">

                                <i class="las la-eye"></i>
                                <span>VIEW</span>

                            </a>
                            @endif

                            @if($isSuperAdmin || in_array('branch.edit', $permissions))
                            <!-- EDIT -->
                            <a href="{{ route('branch.edit', base64_encode($branch->id)) }}"
                                class="action-btn action-edit">

                                <i class="las la-edit"></i> 
                                <span>EDIT</span>                            

                            </a>
                            @endif

                            @if($isSuperAdmin || in_array('branch.delete', $permissions))
                            <!-- DELETE -->
                            <form action="{{ route('branch.destroy', base64_encode($branch->id)) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this branch?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="action-btn action-delete">

                                    <i class="las la-trash"></i>
                                    <span>DELETE</span>
                                    
                                </button>

                            </form>
                            @endif

                        </div>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="7"
                        class="py-10 text-center text-gray-500">

                        No branch records found.

                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-5">
        <x-pagination :paginator="$branches"/>
    </div>

</div>

<script>

document.addEventListener('change', function(e){

    if(!e.target.classList.contains('slider-toggle')) return;

    let checkbox = e.target;
    let id = checkbox.dataset.id;

    fetch("{{ route('branch.toggle.status') }}", {

        method:"POST",

        headers:{
            "Content-Type":"application/json",
            "X-CSRF-TOKEN":
            document.querySelector('meta[name="csrf-token"]').content
        },

        body:JSON.stringify({id:id})

    })

    .then(res => res.json())

    .then(res => {

        if(!res.success){

            checkbox.checked = !checkbox.checked;

            alert("Status update failed");

        }

    })

    .catch(() => {

        checkbox.checked = !checkbox.checked;

        alert("Server error");

    });

});

</script>

@endsection