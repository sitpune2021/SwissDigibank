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

            <i class="las la-layer-group text-white text-xl sm:text-2xl leading-none"></i>

        </div>

        <!-- TITLE -->
        <div class="min-w-0">

            <h2 class="text-lg sm:text-xl lg:text-2xl
                font-extrabold uppercase tracking-wide
                text-gray-800 leading-tight truncate">

                Scheme Management

            </h2>

            <p class="text-[11px] sm:text-sm text-gray-500 font-medium mt-1">

                Create, manage and monitor all scheme configurations.

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
@if($isSuperAdmin || in_array('schemes.create', $permissions))
<a href="{{ route('schemes.create') }}"
    class="inline-flex items-center gap-2
    px-4 sm:px-5 py-2.5
    rounded-xl text-xs sm:text-sm font-bold uppercase
    shadow-lg transition-all duration-300 hover:scale-105"
    style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">

    <span>Add Scheme</span>
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

            <thead class="bg-gradient-to-r from-orange-50 via-white to-orange-50 border-b border-gray-200 sticky top-0 z-10">

                <tr class="text-[10px] sm:text-xs lg:text-sm font-extrabold uppercase tracking-wider text-slate-700">

                    <!-- SR NO -->
                    <th class="px-3 sm:px-5 py-4 text-center min-w-[90px]">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-hashtag text-sm sm:text-base text-black"></i>
                            </div>

                            <span class="text-black whitespace-nowrap">SR NO</span>

                        </div>

                    </th>

                    <!-- SCHEME NAME -->
                    <th class="text-start py-3 px-3 whitespace-nowrap">
                        <div class="flex items-center gap-2 min-w-max">
                            <div class="w-7 h-7 rounded-xl bg-orange-100 flex items-center justify-center shrink-0">
                                <i class="las la-layer-group text-orange-600 text-base"></i>
                            </div>
                            <span>Scheme Name</span>
                        </div>
                    </th>

                    <!-- OPENING AMOUNT -->
                    <th class="text-start py-3 px-3 whitespace-nowrap">
                        <div class="flex items-center gap-2 min-w-max">
                            <div class="w-7 h-7 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                                <i class="las la-wallet text-emerald-600 text-base"></i>
                            </div>
                            <span>Min Opening Amount</span>
                        </div>
                    </th>

                    <!-- MONTHLY BALANCE -->
                    <th class="text-start py-3 px-3 whitespace-nowrap">
                        <div class="flex items-center gap-2 min-w-max">
                            <div class="w-7 h-7 rounded-xl bg-sky-100 flex items-center justify-center shrink-0">
                                <i class="las la-coins text-sky-600 text-base"></i>
                            </div>
                            <span>Monthly Min Balance</span>
                        </div>
                    </th>

                    <!-- LOCK AMOUNT -->
                    <th class="text-start py-3 px-3 whitespace-nowrap">
                        <div class="flex items-center gap-2 min-w-max">
                            <div class="w-7 h-7 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                                <i class="las la-lock text-red-600 text-base"></i>
                            </div>
                            <span>Lock In Amt.</span>
                        </div>
                    </th>

                    <!-- INTEREST RATE -->
                    <th class="text-start py-3 px-3 whitespace-nowrap">
                        <div class="flex items-center gap-2 min-w-max">
                            <div class="w-7 h-7 rounded-xl bg-violet-100 flex items-center justify-center shrink-0">
                                <i class="las la-percentage text-violet-600 text-base"></i>
                            </div>
                            <span>Interest Rate</span>
                        </div>
                    </th>

                    <!-- INTEREST PAYOUT -->
                    <th class="text-start py-3 px-3 whitespace-nowrap">
                        <div class="flex items-center gap-2 min-w-max">
                            <div class="w-7 h-7 rounded-xl bg-cyan-100 flex items-center justify-center shrink-0">
                                <i class="las la-hand-holding-usd text-cyan-600 text-base"></i>
                            </div>
                            <span>Interest Payout</span>
                        </div>
                    </th>

                    <!-- ACTIVE -->
                    <th class="text-start py-3 px-3 whitespace-nowrap">
                        <div class="flex items-center gap-2 min-w-max">
                            <div class="w-7 h-7 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                                <i class="las la-check-circle text-green-600 text-base"></i>
                            </div>
                            <span>Active</span>
                        </div>
                    </th>

                    <!-- ACTION -->
                    <th class="text-center py-3 px-3 whitespace-nowrap">
                        <div class="flex items-center justify-center gap-2 min-w-max">
                            <div class="w-7 h-7 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                                <i class="las la-cog text-gray-700 text-base"></i>
                            </div>
                            <span>Action</span>
                        </div>
                    </th>

                </tr>

            </thead>

            <tbody>
                @foreach ($schemes as $scheme)
                <tr class="table-row dark:even:bg-bg3 border-b hover:bg-gray-50 dark:hover:bg-bg3"
                    style="animation-delay: {{ $loop->index * 0.05 }}s">
                    
                    <!-- SR NO -->
                    <td class="px-6 py-5 text-center font-semibold text-gray-700">

                        {{ $loop->iteration }}

                    </td>
                    <td class="px-3 py-4">
                        <a href="{{ $scheme?->id ? route('schemes.show', $scheme->id) : '#' }}"
                            class="flex items-center gap-3 hover:bg-gray-50 p-2 rounded-lg transition">

                            <!-- Code + Name -->
                            <div class="leading-tight">                                 

                                <!-- Scheme Name -->
                                <p class="font-semibold text-primary">
                                    {{ $scheme->scheme_name }}
                                </p>

                                    <!-- Scheme Code -->
                                <p class="text-xs text-gray-400">
                                    Scheme Code : {{ $scheme->scheme_code }}
                                </p>

                            </div>

                        </a>
                    </td>
                    <td class="py-5 px-3">{{ number_format($scheme->min_opening_balance, 2) }}</td>
                    <td class="py-5 px-3">{{ number_format($scheme->min_monthly_avg_balance, 2) }}</td>
                    <td class="py-5 px-4">{{ number_format($scheme->lock_in_amount, 2) }}</td>
                    <td class="py-5 px-4">{{ $scheme->annual_int_rate }}</td>
                    <td class="py-5 px-4">{{ $scheme->interest_pay_cycle }}</td>
                    <!-- <td class="py-5 px-6">{{ $scheme->active }}</td> -->
                    <td class="py-5 px-3">
                        @if($scheme->active == 1)
                        <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                            Yes
                        </span>
                        @else
                        <span
                            class="block w-28 rounded-[30px] border border-n30 bg-error/10 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                            No
                        </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">

                        <div class="flex items-center justify-center gap-2 whitespace-nowrap">

                            <!-- VIEW -->
                            @if($isSuperAdmin || in_array('schemes.show', $permissions))
                            <a href="{{ route('schemes.show', $scheme->id) }}"
                                class="action-btn action-view">

                                <i class="las la-eye text-sm"></i>

                                <span>View</span>

                            </a>
                            @endif

                            <!-- EDIT -->
                            @if($isSuperAdmin || in_array('schemes.edit', $permissions))
                            <a href="{{ route('schemes.edit', $scheme->id) }}"
                                class="action-btn action-edit">

                                <i class="las la-edit text-sm"></i>

                                <span>Edit</span>

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
        <x-pagination :paginator="$schemes"/>
    </div>

</div>

@endsection