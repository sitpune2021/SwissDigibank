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

            <i class="las la-university text-white text-xl sm:text-2xl leading-none"></i>

        </div>

        <!-- TITLE -->
        <div class="min-w-0">

            <h2 class="text-lg sm:text-xl lg:text-2xl
                font-extrabold uppercase tracking-wide
                text-gray-800 leading-tight truncate">

               Fixed Deposit Accounts

            </h2>

            <p class="text-[11px] sm:text-sm text-gray-500 font-medium mt-1">

                Manage FD accounts, maturity details, interest payouts records seamlessly.

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
    @if($isSuperAdmin || in_array('fd-mis-schemes.fd_create', $permissions))
        <a href="{{ route('fd-mis-schemes.fd_create') }}"
            class="inline-flex items-center gap-2
            px-4 sm:px-5 py-2.5
            rounded-xl text-xs sm:text-sm font-bold uppercase
            shadow-lg transition-all duration-300 hover:scale-105"
            style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">

            <span>Add FD ACCOUNT</span>
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

                    <!-- FD NO -->
                    <th class="text-start px-4 sm:px-6 py-4 min-w-[130px]">
                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">
                            <i class="las la-file-invoice-dollar text-primary text-base"></i>
                            <span>FD No</span>
                        </div>
                    </th>

                    <!-- CUSTOMER -->
                    <th class="text-start px-4 sm:px-6 py-4 min-w-[180px]">
                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">
                            <i class="las la-user text-success text-base"></i>
                            <span>Customer Name</span>
                        </div>
                    </th>

                    <!-- BRANCH -->
                    <th class="text-start px-4 sm:px-6 py-4 min-w-[150px]">
                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">
                            <i class="las la-code-branch text-warning text-base"></i>
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
                            <span>Principal Amount</span>
                        </div>
                    </th>

                    <!-- OPEN DATE -->
                    <th class="text-start px-4 sm:px-6 py-4 min-w-[160px]">
                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">
                            <i class="las la-calendar-plus text-danger text-base"></i>
                            <span>Open Date</span>
                        </div>
                    </th>

                    <!-- INTEREST PAYOUT -->
                    <th class="text-start px-4 sm:px-6 py-4 min-w-[170px]">
                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">
                            <i class="las la-money-check-alt text-success text-base"></i>
                            <span>Int. Payout</span>
                        </div>
                    </th>

                    <!-- MATURITY -->
                    <th class="text-start px-4 sm:px-6 py-4 min-w-[180px]">
                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">
                            <i class="las la-hourglass-end text-warning text-base"></i>
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
                            <i class="las la-cogs text-gray-600 text-base"></i>
                            <span>Action</span>
                        </div>
                    </th>

                </tr>
            </thead>
            
            <tbody>
                @foreach($accounts as $account)
                <tr class="table-row border-b border-gray-100"
                    style="animation-delay:{{ $loop->index * 0.05 }}s">

                    <!-- SR NO -->
                    <td class="px-6 py-5 text-center font-semibold text-gray-700">

                        {{ $loop->iteration }}

                    </td>
                    
                    <td class="px-6 py-3">
                        <a href="{{route('fd-mis-schemes.fd_show',$account->id)}}" style="color:green;">{{ $account->fd_no }}</a>
                    </td>

                    <td class="px-4 py-3">
                        <a href="#" class="flex items-center gap-3 group">

                            <!-- Text Content -->
                            <div class="flex flex-col leading-tight">

                                <!-- Name (Top) -->
                                <span class="font-semibold text-primary group-hover:text-green-600 transition">
                                    {{ $account->member->member_info_first_name ?? '-' }}
                                </span>

                                <!-- Member No (Bottom) -->
                                <span class="text-xs text-gray-400">
                                    Customer No : {{ $account->member->member_no 
                                        ?? ($account->member->id 
                                            ? str_pad($account->member->id, 6, '0', STR_PAD_LEFT) 
                                            : '-') }}
                                </span>

                            </div>

                        </a>
                    </td>
                    <td class="px-6 py-3">{{ $account->branch->branch_name ?? '-' }}</td>
                    <td class="px-6 py-3">{{ $account->fdscheme->scheme_name }}</td>
                    <td class="px-6 py-3">{{ number_format($account->fd_amount, 2) }}</td>
                    <td class="px-6 py-3">{{ \Carbon\Carbon::parse($account->open_date)->format('d-m-Y') ?? '-' }}</td>
                    <td class="px-6 py-3">{{ $account->interest_payout_type??'-' }}</td>
                    <td class="px-6 py-3">
                        {{ \Carbon\Carbon::parse($account->maturity_date)->format('d-m-Y') ?? '-' }}
                    </td>
                    <td class="px-6 py-3">
                        @if ($account->status == 0)
                        <span class="block w-28 rounded-[30px] border border-n30 bg-warning/20 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            Pending
                        </span>
                        @elseif ($account->status == 1)
                        <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            Approved
                        </span>
                        @elseif ($account->status == 2)
                        <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-error text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            Rejected
                        </span>
                        @elseif ($account->status == 3)
                        <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-error text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            Fore Closed
                        </span>
                        @endif
                    </td>
                    <!-- ACTION -->
                    <td class="px-5 py-4 text-center align-middle"
                        data-label="Actions">

                        <div class="flex items-center justify-center gap-2 action-group">

                            <!-- VIEW -->
                            @if($isSuperAdmin || in_array('fd-mis-schemes.fd_show', $permissions))
                            <a href="{{ route('fd-mis-schemes.fd_show', $account->id) }}"
                                class="action-btn action-view">

                                <i class="las la-eye"></i>
                                <span>VIEW</span>

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
        <x-pagination :paginator="$accounts"/>
    </div>

</div>

@endsection