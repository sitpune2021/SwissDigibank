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

            <i class="las la-chart-line text-white text-xl sm:text-2xl leading-none"></i>

        </div>

        <!-- TITLE -->
        <div class="min-w-0">

            <h2 class="text-lg sm:text-xl lg:text-2xl
                font-extrabold uppercase tracking-wide
                text-gray-800 leading-tight truncate">

               MIS Accounts

            </h2>

            <p class="text-[11px] sm:text-sm text-gray-500 font-medium mt-1">

                Manage MIS accounts, maturity schedules & investment records seamlessly.

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
    @if($isSuperAdmin || in_array('misaccount.create', $permissions))
        <a href="{{ route('misaccount.create') }}"
            class="inline-flex items-center gap-2
            px-4 sm:px-5 py-2.5
            rounded-xl text-xs sm:text-sm font-bold uppercase
            shadow-lg transition-all duration-300 hover:scale-105"
            style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">

            <span>Add MIS ACCOUNT</span>
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

                    <!-- MIS NO -->
                    <th class="text-start px-4 sm:px-6 py-4 min-w-[140px]">

                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">

                            <i class="las la-file-alt text-primary text-base"></i>

                            <span>MIS No</span>

                        </div>

                    </th>

                    <!-- CUSTOMER -->
                    <th class="text-start px-4 sm:px-6 py-4 min-w-[190px]">

                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">

                            <i class="las la-user-alt text-success text-base"></i>

                            <span>Customer Name</span>

                        </div>

                    </th>

                    <!-- BRANCH -->
                    <th class="text-start px-4 sm:px-6 py-4 min-w-[150px]">

                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">

                            <i class="las la-building text-warning text-base"></i>

                            <span>Branch</span>

                        </div>

                    </th>

                    <!-- SCHEME -->
                    <th class="text-start px-4 sm:px-6 py-4 min-w-[160px]">

                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">

                            <i class="las la-layer-group text-info text-base"></i>

                            <span>Scheme</span>

                        </div>

                    </th>

                    <!-- PRINCIPAL -->
                    <th class="text-start px-4 sm:px-6 py-4 min-w-[180px]">

                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">

                            <i class="las la-wallet text-primary text-base"></i>

                            <span>Principal Amt.</span>

                        </div>

                    </th>

                    <!-- OPEN DATE -->
                    <th class="text-start px-4 sm:px-6 py-4 min-w-[160px]">

                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">

                            <i class="las la-calendar text-danger text-base"></i>

                            <span>Open Date</span>

                        </div>

                    </th>

                    <!-- INTEREST PAYOUT -->
                    <th class="text-start px-4 sm:px-6 py-4 min-w-[170px]">

                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">

                            <i class="las la-money-bill-wave text-success text-base"></i>

                            <span>Int. Payout</span>

                        </div>

                    </th>

                    <!-- MATURITY -->
                    <th class="text-start px-4 sm:px-6 py-4 min-w-[180px]">

                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">

                            <i class="las la-hourglass-half text-warning text-base"></i>

                            <span>Maturity Date</span>

                        </div>

                    </th>

                    <!-- STATUS -->
                    <th class="text-start px-4 sm:px-6 py-4 min-w-[130px]">

                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">

                            <i class="las la-check-circle text-success text-base"></i>

                            <span>Status</span>

                        </div>

                    </th>

                    <!-- ACTION -->
                    <th class="text-center px-4 sm:px-6 py-4 min-w-[120px]" data-sortable="false">

                        <div class="flex items-center justify-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">

                            <i class="las la-cog text-gray-600 text-base"></i>

                            <span>Action</span>

                        </div>

                    </th>

                </tr>

            </thead>

            <tbody>
                @foreach ($misaccounts as $mis)
                <tr class="table-row border-b border-gray-100"
                    style="animation-delay:{{ $loop->index * 0.05 }}s">

                    <!-- SR NO -->
                    <td class="px-6 py-5 text-center font-semibold text-gray-700">

                        {{ $loop->iteration }}

                    </td>
                    
                    <td class="text-start !py-5 px-6 min-w-[100px]">
                        <a href="{{ $mis?->id ? route('misaccount.show', $mis->id) : '#' }}" class="text-primary underline hover:text-primary/80">
                            {{ $mis->mis_account_no }}
                        </a>
                    </td>

                    <td class="px-4 py-3">
                        <a href="{{ $mis?->member_id ? route('member.show', $mis->member_id) : '#' }}"
                            class="flex items-center gap-3 group">

                            <!-- Text -->
                            <div class="flex flex-col leading-tight">

                                <!-- Name -->
                                <span class="font-semibold text-primary group-hover:text-green-600 transition">
                                    {{ $mis->member->full_name ?? '-' }}
                                </span>

                                <!-- Member No -->
                                <span class="text-xs text-gray-400">
                                    Customer No : {{ $mis->member->member_no 
                                        ?? ($mis->member_id 
                                            ? str_pad($mis->member_id, 6, '0', STR_PAD_LEFT) 
                                            : '-') }}
                                </span>

                            </div>

                        </a>
                    </td>                      
                    <td class="px-6 py-3">{{ $mis->branch->branch_name ?? '-' }}</td>
                    <td class="px-6 py-3">{{ $mis->fdscheme->scheme_name }}</td>
                    <td class="text-start !py-5 px-6 min-w-[100px]">{{ number_format($mis->mis_amount, 2) }}</td>
                    <td class="text-start !py-5 px-6 min-w-[100px]">{{ \Carbon\Carbon::parse($mis->open_date)->format('d-m-Y') }}</td>
                    <td class="text-start !py-5 px-6 min-w-[100px]">{{ strtoupper($mis->interest_payout_type) }}</td>
                    <td class="text-start !py-5 px-6 min-w-[100px]">{{ \Carbon\Carbon::parse($mis->maturity_date)->format('d-m-Y') }}</td>
                    <td class="text-start !py-5 px-6 min-w-[100px]">
                        @if ($mis->status == 0)
                        <span class="block w-28 rounded-[30px] border border-n30 bg-warning/20 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            Pending
                        </span>
                        @elseif ($mis->status == 1)
                        <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            Approved
                        </span>
                        @elseif ($mis->status == 2)
                        <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-error text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            Rejected
                        </span>
                        @elseif ($mis->status == 3)
                        <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-error text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            Foreclosed
                        </span>
                        @endif
                    </td>
                    <!-- ACTION -->
                    <td class="px-5 py-4 text-center align-middle"
                        data-label="Actions">

                        <div class="flex items-center justify-center gap-2 action-group">

                            <!-- VIEW -->
                            @if($isSuperAdmin || in_array('misaccount.show', $permissions))
                            <a href="{{ route('misaccount.show', $mis->id) }}"
                                class="action-btn action-view">

                                <i class="las la-eye"></i>
                                <span>VIEW</span>

                            </a>
                            @endif

                            <!-- EDIT -->
                            @if(($isSuperAdmin || in_array('misaccount.edit', $permissions)) && $mis->status == 0)
                            <a href="{{ route('misaccount.edit', $mis->id) }}"
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