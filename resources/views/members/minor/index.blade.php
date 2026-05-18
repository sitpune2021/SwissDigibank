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

            <i class="las la-user-shield text-white text-xl sm:text-2xl relative z-10"></i>

        </div>

        <!-- TITLE -->
        <div class="min-w-0">

            <h2 class="text-lg sm:text-xl lg:text-2xl
                font-extrabold uppercase tracking-wide
                text-gray-800 dark:text-white leading-tight break-words">

                Minors Management

            </h2>

            <p class="text-[11px] sm:text-sm text-gray-500 dark:text-gray-400 font-medium mt-1">

                Banking & Guardian Monitoring Panel.

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

@section('content')

    <div class="box col-span-12 lg:col-span-6 bank-page-animate">

            <x-searchbox />

            <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
                <x-alert />
            </div>


            <div class="overflow-x-auto pb-4 lg:pb-6 table-premium">

                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">

                    <thead
                        class="bg-gradient-to-r from-slate-100 via-cyan-50 to-blue-50
                        dark:from-bg3 dark:via-bg4 dark:to-bg3
                        border-y border-slate-200 dark:border-white/10"
                    >
                        <tr>

                            <!-- SR NO -->
                            <th class="text-start !py-4 px-4 sm:px-6 min-w-[120px]">
                                <div class="flex items-center gap-2 text-slate-700 dark:text-white">

                                    <!-- ICON BOX -->
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center
                                        bg-indigo-100 dark:bg-indigo-500/10">

                                        <i class="las la-hashtag text-indigo-600 dark:text-indigo-400 text-lg"></i>

                                    </div>

                                    <!-- TEXT -->
                                    <div>

                                        <h6 class="text-xs sm:text-sm font-extrabold uppercase">
                                            SR No
                                        </h6>

                                    </div>

                                </div>
                            </th>

                            <!-- BRANCH -->
                            <th class="text-start !py-4 px-4 sm:px-6 min-w-[160px]">
                                <div class="flex items-center gap-2 text-slate-700 dark:text-white">

                                    <!-- ICON -->
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center
                                        bg-cyan-100 dark:bg-cyan-500/10">

                                        <i class="las la-code-branch text-cyan-600 dark:text-cyan-400 text-lg"></i>

                                    </div>

                                    <!-- TEXT -->
                                    <div>

                                        <h6 class="text-xs sm:text-sm font-extrabold uppercase">
                                            Branch
                                        </h6>

                                    </div>

                                </div>
                            </th>

                            <!-- MINOR NAME -->
                            <th class="text-start !py-4 px-4 sm:px-6 min-w-[190px]">
                                <div class="flex items-center gap-2 text-slate-700 dark:text-white">

                                    <!-- ICON -->
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center
                                        bg-blue-100 dark:bg-blue-500/10">

                                        <i class="las la-child text-blue-600 dark:text-blue-400 text-lg"></i>

                                    </div>

                                    <!-- TEXT -->
                                    <div>

                                        <h6 class="text-xs sm:text-sm font-extrabold uppercase">
                                            Minor Name
                                        </h6>

                                    </div>

                                </div>
                            </th>

                            <!-- CUSTOMER NAME -->
                            <th class="text-start !py-4 px-4 sm:px-6 min-w-[220px]">
                                <div class="flex items-center gap-2 text-slate-700 dark:text-white">

                                    <!-- ICON -->
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center
                                        bg-violet-100 dark:bg-violet-500/10">

                                        <i class="las la-user-tie text-violet-600 dark:text-violet-400 text-lg"></i>

                                    </div>

                                    <!-- TEXT -->
                                    <div>

                                        <h6 class="text-xs sm:text-sm font-extrabold uppercase">
                                            Customer Name
                                        </h6>

                                    </div>

                                </div>
                            </th>

                            <!-- ENROLLMENT DATE -->
                            <th class="text-start !py-4 px-4 sm:px-6 min-w-[190px]">
                                <div class="flex items-center gap-2 text-slate-700 dark:text-white">

                                    <!-- ICON -->
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center
                                        bg-emerald-100 dark:bg-emerald-500/10">

                                        <i class="las la-calendar-check text-emerald-600 dark:text-emerald-400 text-lg"></i>

                                    </div>

                                    <!-- TEXT -->
                                    <div>

                                        <h6 class="text-xs sm:text-sm font-extrabold uppercase">
                                            Enrollment Date
                                        </h6>

                                    </div>

                                </div>
                            </th>

                            <!-- ACTION -->
                            <th class="text-center !py-4 px-4 min-w-[130px]">
                                <div class="flex items-center justify-center gap-2 text-slate-700 dark:text-white">

                                    <!-- ICON -->
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center
                                        bg-amber-100 dark:bg-amber-500/10">

                                        <i class="las la-cogs text-amber-600 dark:text-amber-400 text-lg"></i>

                                    </div>

                                    <!-- TEXT -->
                                    <div class="text-left">
                                        <h6 class="text-xs sm:text-sm font-extrabold uppercase">
                                            Action
                                        </h6>

                                    </div>

                                </div>
                            </th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($minors as $index => $minor)
                        <tr class="table-row border-b border-gray-100"
                            style="animation-delay:{{ $loop->index * 0.05 }}s">

                            <!-- SR NO -->
                            <td class="px-6 py-5 text-center font-semibold text-gray-700">

                                {{ $loop->iteration }}
                            </td> 

                            <td class="px-3 py-3">
                                <div class="flex items-center gap-2">                             

                                    <!-- Branch Name -->
                                    <span class="text-gray-700 font-medium">
                                        {{ $minor->member->branch->branch_name ?? 'N/A' }}
                                    </span>

                                </div>
                            </td>

                            <td class="px-6 py-4">{{ $minor->first_name ?? 'N/A' }}</td>

                            <td class="px-6 py-4">
                                @if ($minor->member)

                                <a href="{{ $minor->member?->id ? route('member.show', $minor->member->id) : '#' }}"
                                class="flex items-center gap-3 hover:bg-gray-50 p-2 rounded-lg transition">

                                    <!-- ID + Name -->
                                    <div class="leading-tight">
                                        
                                        <!-- Name -->
                                        <p class="font-semibold text-primary">
                                            {{ $minor->member->member_info_first_name ?? 'N/A' }}
                                        </p>
                                        <!-- Customer ID -->
                                        <p class="text-xs text-gray-400">
                                            Customer No : {{ $minor->member->member_no 
                                            ?? ($minor->member->id ? str_pad($minor->member->id, 6, '0', STR_PAD_LEFT) : 'N/A') }}
                                        </p>

                                    </div>

                                </a>

                                @else
                                    N/A
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                {{ $minor->enrollment_date ? \Carbon\Carbon::parse($minor->enrollment_date)->format('d-m-Y') : 'N/A' }}
                            </td>

                            <!-- ACTION -->
                            <td class="text-center px-4 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    <!-- VIEW -->
                                    @if($isSuperAdmin || in_array('minor.show', $permissions))
                                    <a href="{{ route('minor.show', $minor->id) }}"
                                        class="action-btn action-view">

                                        <i class="las la-eye"></i>
                                        <span>VIEW</span>

                                    </a>
                                    @endif

                                    <!-- EDIT -->
                                    @if($isSuperAdmin || in_array('minor.edit', $permissions))
                                    <a href="{{ route('minor.edit', $minor->id) }}"
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
        
    </div>

@endsection