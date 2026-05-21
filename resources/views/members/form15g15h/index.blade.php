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

            <i class="las la-file-invoice-dollar text-white text-xl sm:text-2xl relative z-10"></i>

        </div>

        <!-- TITLE -->
        <div class="min-w-0">

            <h2 class="text-lg sm:text-xl lg:text-2xl
                font-extrabold uppercase tracking-wide
                text-gray-800 dark:text-white leading-tight break-words">

                Form 15G/ 15H Management

            </h2>

            <p class="text-[11px] sm:text-sm text-gray-500 dark:text-gray-400 font-medium mt-1">

                Tax Declaration & Compliance Panel.

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

    <div class="mb-3">
        <x-searchbox />
    </div>

    <!-- TABLE -->
    <div class="table-wrapper w-full overflow-x-auto rounded-2xl border border-gray-200 bg-white shadow-sm table-premium">     
            
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


                    <!-- FY -->
                    <th class="text-start !py-4 px-4 sm:px-6 min-w-[150px]">

                        <div class="flex items-center gap-2 text-slate-700 dark:text-white">

                            <!-- ICON -->
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center
                                bg-emerald-100 dark:bg-emerald-500/10">

                                <i class="las la-calendar-alt text-emerald-600 dark:text-emerald-400 text-lg"></i>

                            </div>

                            <!-- TEXT -->
                            <div>

                                <h6 class="text-xs sm:text-sm font-extrabold uppercase">
                                    Financial / FY
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
                @foreach ($form15g15hs as $index => $item)
                    <tr class="table-row border-b border-gray-100"
                        style="animation-delay:{{ $loop->index * 0.05 }}s">
                    
                        <!-- SR NO -->
                        <td class="px-6 py-5 text-center font-semibold text-gray-700">

                            {{ $loop->iteration }}
                        </td>  

                        <td class="py-3 px-6">
                            @if ($item->member)
                                <a href="{{ route('member.show', $item?->member?->id ?? '') }}"
                                    class="text-primary hover:underline">
                                    {{ $item->member?->member_no ?? ($item->member?->id ? str_pad($item->member->id, 6, '0', STR_PAD_LEFT) : '') }}-
                                    {{ $item->member?->member_info_first_name ?? '' }}
                                </a>
                            @else
                                <a href="{{ route('promotor.show', base64_encode($item?->promotor?->id ?? '')) }}"
                                    class="text-primary hover:underline">
                                    {{ $item->promotor?->first_name ?? '' }}
                                </a>
                            @endif
                        </td>
                        <td class="py-3 px-6">
                            {{ $item?->financial_year ?? '' }}
                        </td>

                        <!-- ACTION -->
                        <td class="text-center px-4 py-4">

                            <div class="flex items-center justify-center gap-2">

                                <!-- VIEW -->
                                @if($isSuperAdmin || in_array('form15g15h.show', $permissions))
                                <a href="{{ route('form15g15h.show', $item->id) }}"
                                    class="action-btn action-view">

                                    <i class="las la-eye"></i>
                                    <span>VIEW</span>

                                </a>
                                @endif

                                <!-- EDIT -->
                                @if($isSuperAdmin || in_array('form15g15h.edit', $permissions))

                                <a href="{{ route('form15g15h.edit', $item->id) }}"
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

    <div class="mt-5">
        <x-pagination :paginator="$form15g15hs" />
    </div>

</div>

@endsection
