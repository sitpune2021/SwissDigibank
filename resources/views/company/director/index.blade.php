@extends('layout.main')
@extends('layout.tablestyle')

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

            <i class="las la-user-tie text-white text-xl sm:text-2xl leading-none"></i>

        </div>

        <!-- TITLE -->
        <div class="min-w-0">

            <h2 class="text-lg sm:text-xl lg:text-2xl
                font-extrabold uppercase tracking-wide
                text-gray-800 leading-tight truncate">

                Directors Management

            </h2>

            <p class="text-[11px] sm:text-sm text-gray-500 font-medium mt-1">

                Manage directors, appointments & signatory details

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

@php
    $permissions = auth()->user()->rolePermission->permissions ?? [];
    $isSuperAdmin = auth()->user()->role_id == 1;
@endphp

@section('action-button')
@if($isSuperAdmin || in_array('director.create', $permissions))
<a href="{{ route('director.create') }}"
    class="inline-flex items-center gap-2
    px-4 sm:px-5 py-2.5
    rounded-xl text-xs sm:text-sm font-bold uppercase
    shadow-lg transition-all duration-300 hover:scale-105"
    style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">

    <span>Add Director</span>

</a>
@endif
@endsection

@section('content')

<div class="box col-span-12 lg:col-span-6 bank-page-animate">

    <x-searchbox />
    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>

    <div class="overflow-x-auto pb-4 lg:pb-6 table-premium">

        <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">

            <thead class="bg-gradient-to-r from-orange-50 via-white to-orange-50 border-b border-gray-200 sticky top-0 z-10">

                <tr class="text-[11px] sm:text-xs lg:text-sm font-bold uppercase tracking-wider text-gray-700">

                    <!-- SR NO -->
                    <th class="px-3 sm:px-5 py-4 text-center min-w-[90px]">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-hashtag text-sm sm:text-base text-black"></i>
                            </div>

                            <span class="text-black whitespace-nowrap">SR NO</span>

                        </div>

                    </th>

                    <!-- CUSTOMER NAME -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[220px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                                <i class="las la-user text-blue-600 text-sm"></i>
                            </div>

                            <span>Customer Name</span>

                        </div>

                    </th>

                    <!-- NAME -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[200px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-cyan-100 flex items-center justify-center shrink-0">
                                <i class="las la-user-tie text-cyan-600 text-sm"></i>
                            </div>

                            <span>DIRECTOR NAME</span>

                        </div>

                    </th>

                    <!-- DIN -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[140px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-yellow-100 flex items-center justify-center shrink-0">
                                <i class="las la-id-card text-yellow-600 text-sm"></i>
                            </div>

                            <span>DIN</span>

                        </div>

                    </th>

                    <!-- APPOINTMENT DATE -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[210px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-green-100 flex items-center justify-center shrink-0">
                                <i class="las la-calendar-plus text-green-600 text-sm"></i>
                            </div>

                            <span>Appointment Date</span>

                        </div>

                    </th>

                    <!-- RESIGNATION DATE -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[210px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-red-100 flex items-center justify-center shrink-0">
                                <i class="las la-calendar-times text-red-600 text-sm"></i>
                            </div>

                            <span>Resignation Date</span>

                        </div>

                    </th>

                    <!-- AUTHORIZED SIGNATORY -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[220px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-indigo-100 flex items-center justify-center shrink-0">
                                <i class="las la-signature text-indigo-600 text-sm"></i>
                            </div>

                            <span>Authorized Signatory</span>

                        </div>

                    </th>

                    <!-- ACTION -->
                    <th class="text-center py-4 px-3 sm:px-5 min-w-[150px] whitespace-nowrap">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-cogs text-gray-700 text-sm"></i>
                            </div>

                            <span>Action</span>

                        </div>

                    </th>

                </tr>

            </thead>

            <tbody>
                @forelse ($directors as $index => $director)
                <tr class="table-row dark:even:bg-bg3 border-b hover:bg-gray-50 dark:hover:bg-bg3"
                    style="animation-delay: {{ $loop->index * 0.05 }}s">
                    
                    <!-- SR NO -->
                    <td class="px-6 py-5 text-center font-semibold text-gray-700">

                        {{ $loop->iteration }}

                    </td>
                    <td class="px-4 py-3">
                        @if ($director->member)
                        <div class="flex items-center gap-2">

                            <div>
                                <a href="{{ route('member.show', $director->member->id) }}"
                                class="text-green-600 font-medium hover:underline">
                                    {{ $director->member->member_info_first_name }} {{ $director->member->member_info_last_name }}
                                </a>
                            </div>

                        </div>
                        @else
                        N/A
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ $director?->id ? route('director.show', base64_encode($director->id)) : '#' }}" class="text-primary  hover:underline">
                            {{ $director?->director_name ?? '' }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-1">
                             {{ $director?->din_no??'' }}
                        </span>
                       
                    </td>
                    <td class="px-6 py-4">
                    <span class="px-2">
                        {{ $director->appointment_date?->format('d-m-Y') ?? 'N/A' }}
                    </span>
                    </td>
                    <td class="px-6 py-4">
                       <span class="px-2">
                         {{ $director->resignation_date?->format('d-m-Y') ?? 'N/A' }}
                       </span>
                    </td>
                    <td class="py-2 px-6">
                        @if ($director->authorized_signatory == 'Yes')
                        <span
                            class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                            Yes
                        </span>
                        @else
                        <span
                            class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16">
                            {{ $director->authorized_signatory }}
                        </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">

                        <div class="flex items-center justify-center gap-2 whitespace-nowrap">

                            <!-- VIEW -->
                            @if($isSuperAdmin || in_array('director.show', $permissions))
                            <a href="{{ route('director.show', base64_encode($director->id)) }}"
                                class="action-btn action-view">

                                <i class="las la-eye text-sm"></i>

                                <span>View</span>

                            </a>
                            @endif

                            <!-- EDIT -->
                            @if($isSuperAdmin || in_array('director.edit', $permissions))
                            <a href="{{ route('director.edit', base64_encode($director->id)) }}"
                                class="action-btn action-edit">

                                <i class="las la-edit text-sm"></i>

                                <span>Edit</span>

                            </a>
                            @endif

                        </div>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-4 text-gray-500">No record found.</td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    <div class="mt-4">
        <x-pagination :paginator="$directors"/>
    </div>

</div>
@endsection