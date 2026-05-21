@extends('layout.main')
@extends('layout.tablestyle')

@section('page-title')

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 w-full">

    <!-- LEFT SIDE -->
    <div class="flex items-center gap-3 min-w-0">

        <!-- PREMIUM ICON -->
        <div
            class="relative overflow-hidden
            w-11 h-11 sm:w-12 sm:h-12
            rounded-2xl flex items-center justify-center shrink-0"

            style="
                background: linear-gradient(135deg,#06b6d4,#2563eb);
                box-shadow:
                    0 10px 25px rgba(37,99,235,.30),
                    inset 0 1px 0 rgba(255,255,255,.35);
            "
        >

            <!-- SHINE -->
            <div
                class="absolute inset-0"
                style="
                    background:
                    linear-gradient(
                        135deg,
                        rgba(255,255,255,.28),
                        transparent 45%
                    );
                "
            ></div>

            <i class="las la-building text-white text-xl sm:text-2xl relative z-10"></i>

        </div>

        <!-- TITLE -->
        <div class="min-w-0">

            <h2 class="text-lg sm:text-xl lg:text-2xl
                font-extrabold uppercase tracking-wide
                text-gray-800 dark:text-white leading-tight break-words">

                Collection Centers

            </h2>

            <p class="text-[11px] sm:text-sm text-gray-500 dark:text-gray-400 font-medium mt-1">

                Manage all Collection Centers

            </p>

        </div>

    </div>

    <!-- RIGHT SIDE BADGE -->
    <div class="hidden md:flex items-center gap-2
        px-4 py-2 rounded-xl
        bg-gradient-to-r from-slate-100 to-slate-50
        border border-slate-200 shadow-sm shrink-0">

        <span class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></span>

        <span class="text-xs font-bold uppercase tracking-wider text-slate-600">

            Banking Panel

        </span>

    </div>

</div>

@endsection

@php
    $permissions = auth()->user()->rolePermission->permissions ?? [];
    $isSuperAdmin = auth()->user()->role_id == 1;
@endphp

@section('action-button')
@if($isSuperAdmin || in_array('collection-centers.create', $permissions))
<a href="{{ route('collection-centers.create') }}"
    class="inline-flex items-center gap-2
    px-4 sm:px-5 py-2.5 rounded-xl
    text-xs sm:text-sm font-bold uppercase tracking-wide
    shadow-lg hover:scale-105 transition-all duration-300"
    style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">

    <span>Add Collection</span>

</a>
@endif
@endsection

@section('content')

   <div class="box col-span-12 lg:col-span-6 bank-page-animate">

        <div class="mb-3">
            <x-searchbox />
        </div>

        <!-- TABLE -->
        <div class="table-wrapper w-full overflow-x-auto rounded-2xl border border-gray-200 bg-white shadow-sm table-premium">


            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">

                <!-- TABLE HEAD -->
                <thead class="bg-gradient-to-r from-orange-50 via-white to-orange-50 border-b border-gray-200">

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

                        <!-- BRANCH -->
                        <th class="px-4 sm:px-5 py-4 text-left">

                            <div class="flex items-center gap-2">

                                <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">

                                    <i class="las la-building text-black text-sm"></i>

                                </div>

                                <span class="text-black whitespace-nowrap">

                                    Branch

                                </span>

                            </div>

                        </th>

                        <!-- CENTER NO -->
                        <th class="px-4 sm:px-5 py-4 text-center">

                            <div class="flex items-center justify-center gap-2">

                                <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">

                                    <i class="las la-hashtag text-black text-sm"></i>

                                </div>

                                <span class="text-black">

                                    Center No

                                </span>

                            </div>

                        </th>

                        <!-- CENTER NAME -->
                        <th class="px-4 sm:px-5 py-4 text-center">

                            <div class="flex items-center justify-center gap-2">

                                <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">

                                    <i class="las la-layer-group text-black text-sm"></i>

                                </div>

                                <span class="text-black">

                                    Center Name

                                </span>

                            </div>

                        </th>

                        <!-- HEAD -->
                        <th class="px-4 sm:px-5 py-4 text-center">

                            <div class="flex items-center justify-center gap-2">

                                <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">

                                    <i class="las la-user-tie text-black text-sm"></i>

                                </div>

                                <span class="text-black">

                                    C. Head

                                </span>

                            </div>

                        </th>

                        <!-- CASHIER -->
                        <th class="px-4 sm:px-5 py-4 text-center">

                            <div class="flex items-center justify-center gap-2">

                                <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">

                                    <i class="las la-user-check text-black text-sm"></i>

                                </div>

                                <span class="text-black">

                                    Cashier

                                </span>

                            </div>

                        </th>

                        <!-- GROUP -->
                        <th class="px-4 sm:px-5 py-4 text-center">

                            <div class="flex items-center justify-center gap-2">

                                <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">

                                    <i class="las la-users text-black text-sm"></i>

                                </div>

                                <span class="text-black">

                                    Groups

                                </span>

                            </div>

                        </th>

                        <!-- STATUS -->
                        <th class="px-4 sm:px-5 py-4 text-center">

                            <div class="flex items-center justify-center gap-2">

                                <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">

                                    <i class="las la-toggle-on text-black text-sm"></i>

                                </div>

                                <span class="text-black">

                                    Status

                                </span>

                            </div>

                        </th>

                        <!-- ACTION -->
                        <th class="px-4 sm:px-5 py-4 text-center">

                            <div class="flex items-center justify-center gap-2">

                                <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">

                                    <i class="las la-cog text-black text-sm"></i>

                                </div>

                                <span class="text-black">

                                    Actions

                                </span>

                            </div>

                        </th>

                    </tr>

                </thead>

                <tbody>
                    @foreach($collectionCenters as $center)
                        <tr class="table-row border-b border-gray-100"
                            style="animation-delay:{{ $loop->index * 0.05 }}s">

                            <!-- SR NO -->
                            <td class="px-6 py-5 text-center font-semibold text-gray-700">

                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <!-- Branch Info -->
                                    <div>
                                        <p class="font-semibold text-gray-800 hover:text-blue-600 transition">
                                            {{ $center->branch->branch_name ?? '-' }}
                                        </p>

                                        <p class="text-xs text-gray-400">
                                            Branch No: {{ $center->branch->id ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center !py-5 px-6">{{ $center->center_no }}</td>
                            <td class="text-center !py-5 px-6">{{ $center->center_name }}</td>
                            <td class="text-center !py-5 px-6">
                                {{ $center->centerHeadMember->member_info_first_name ?? $center->centerHeadEmployee->name ?? '-' }}
                            </td>
                            <td class="text-center !py-5 px-6">
                                {{ $center->centerCashierMember->member_info_first_name ?? $center->centerCashierEmployee->name ?? '-' }}
                            </td>
                            <td class="text-center !py-5 px-6">
                                    {{ $center->groups->count() }}  
                            </td>
                            <td class="text-center !py-5 px-6">
                                @if($center->is_active)
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary">Yes</span>
                                @else
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error">No</span>
                                @endif
                            </td>
                            <!-- ACTION -->
                            <td class="text-center px-4 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    <!-- VIEW -->
                                    @if($isSuperAdmin || in_array('collection-centers.show', $permissions))
                                    <a href="{{ route('collection-centers.show', base64_encode($center->id)) }}"
                                        class="action-btn action-view">

                                        <i class="las la-eye"></i>
                                        <span>VIEW</span>

                                    </a>
                                    @endif

                                    <!-- EDIT -->
                                    @if($isSuperAdmin || in_array('collection-centers.edit', $permissions))
                                    <a href="{{ route('collection-centers.edit', base64_encode($center->id)) }}"
                                        class="action-btn action-edit">

                                        <i class="las la-edit"></i>
                                        <span>EDIT</span>

                                    </a>
                                    @endif

                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

        <div class="mt-4">
            <x-pagination :paginator="$collectionCenters"/>
        </div>


    </div>


@endsection