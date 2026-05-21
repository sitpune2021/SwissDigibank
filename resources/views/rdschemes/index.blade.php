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

            <i class="las la-coins text-white text-xl sm:text-2xl leading-none"></i>

        </div>

        <!-- TITLE -->
        <div class="min-w-0">

            <h2 class="text-lg sm:text-xl lg:text-2xl
                font-extrabold uppercase tracking-wide
                text-gray-800 leading-tight truncate">

               RD & DD Schemes

            </h2>

            <p class="text-[11px] sm:text-sm text-gray-500 font-medium mt-1">

                Manage RD / DD schemes, monthly investments records efficiently.

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
    @if($isSuperAdmin || in_array('rdschemes.create', $permissions))
        <a href="{{ route('rdschemes.create') }}"
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

        <table class="w-full" id="transactionTable1">

            <thead class="bg-gradient-to-r from-blue-50 to-cyan-50 border-b border-gray-200">

                <tr class="text-gray-700">

                    <!-- SR NO -->
                    <th class="px-3 sm:px-5 py-4 text-center min-w-[90px]">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-hashtag text-sm sm:text-base text-black"></i>
                            </div>

                            <span class="text-black whitespace-nowrap">SR NO</span>

                        </div>

                    </th>

                    <!-- SCHEME CODE -->
                    <th class="px-4 sm:px-6 py-4 text-start min-w-[160px]">

                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">

                            <i class="las la-barcode text-primary text-base"></i>

                            <span>Scheme Code</span>

                        </div>

                    </th>

                    <!-- SCHEME NAME -->
                    <th class="px-4 sm:px-6 py-4 text-start min-w-[190px]">

                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">

                            <i class="las la-layer-group text-info text-base"></i>

                            <span>Scheme Name</span>

                        </div>

                    </th>

                    <!-- MIN AMOUNT -->
                    <th class="px-4 sm:px-6 py-4 text-start min-w-[170px]">

                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">

                            <i class="las la-wallet text-success text-base"></i>

                            <span>Min. Amount</span>

                        </div>

                    </th>

                    <!-- TENURE -->
                    <th class="px-4 sm:px-6 py-4 text-start min-w-[140px]">

                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">

                            <i class="las la-calendar-alt text-warning text-base"></i>

                            <span>Tenure</span>

                        </div>

                    </th>

                    <!-- DEPOSIT FREQUENCY -->
                    <th class="px-4 sm:px-6 py-4 text-start min-w-[180px]">

                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">

                            <i class="las la-sync-alt text-primary text-base"></i>

                            <span>Deposit Freq.</span>

                        </div>

                    </th>

                    <!-- INTEREST RATE -->
                    <th class="px-4 sm:px-6 py-4 text-start min-w-[170px]">

                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">

                            <i class="las la-percentage text-danger text-base"></i>

                            <span>Int. Rate (%)</span>

                        </div>

                    </th>

                    <!-- COMPOUNDING -->
                    <th class="px-4 sm:px-6 py-4 text-start min-w-[170px]">

                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">

                            <i class="las la-chart-line text-info text-base"></i>

                            <span>Compounding</span>

                        </div>

                    </th>

                    <!-- ACTIVE -->
                    <th class="px-4 sm:px-6 py-4 text-start min-w-[120px]">

                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">

                            <i class="las la-check-circle text-success text-base"></i>

                            <span>Active</span>

                        </div>

                    </th>

                    <!-- ACTION -->
                    <th class="px-4 sm:px-6 py-4 text-center min-w-[120px]">

                        <div class="flex items-center justify-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">

                            <i class="las la-cog text-gray-600 text-base"></i>

                            <span>Action</span>

                        </div>

                    </th>

                </tr>

            </thead>
            <tbody>
                @foreach($schemes as $scheme)
                <tr class="table-row border-b border-gray-100"
                    style="animation-delay:{{ $loop->index * 0.05 }}s">

                    <!-- SR NO -->
                    <td class="px-6 py-5 text-center font-semibold text-gray-700">

                        {{ $loop->iteration }}

                    </td>

                    <td class="px-6 py-4 text-start  uppercase">
                        <a href="{{route('rdschemes.show', $scheme->id)}}" class="text-primary underline hover:text-primary/80">
                            {{ $scheme->scheme_code }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-start ">{{ $scheme->scheme_name }}</td>
                    <td class="px-6 py-4 text-start ">{{ $scheme->min_rd_dd_amount }}</td>
                    <td class="px-6 py-4 text-start ">{{ $scheme->tenure_of_rd_dd_value }} {{ $scheme->tenure_of_rd_dd_type }}</td>
                    <td class="px-6 py-4 text-start ">{{ ucfirst($scheme->rd_dd_frequency) }}</td>
                    <td class="px-6 py-4 text-start ">{{ $scheme->anuual_interest_rate }}%</td>
                    <td class="px-6 py-4 text-start ">{{ ucfirst($scheme->interest_compounding_interval) }}</td>
                    <td class="px-6 py-4 text-start  text-center">
                        @if($scheme->active === 'yes')
                        <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            Yes
                        </span>
                        @else
                        <span class="block w-28 rounded-[30px] border border-n30 bg-warning/20 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            No
                        </span>
                        @endif
                    </td>
                    <!-- ACTION -->
                    <td class="px-5 py-4 text-center align-middle"
                        data-label="Actions">

                        <div class="flex items-center justify-center gap-2 action-group">

                            <!-- VIEW -->
                            @if($isSuperAdmin || in_array('rdschemes.show', $permissions))
                            <a href="{{ route('rdschemes.show', $scheme->id) }}"
                                class="action-btn action-view">

                                <i class="las la-eye"></i>
                                <span>VIEW</span>

                            </a>
                            @endif

                            <!-- EDIT -->
                            @if($isSuperAdmin || in_array('rdschemes.edit', $permissions))
                            <a href="{{ route('rdschemes.edit', $scheme->id) }}"
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