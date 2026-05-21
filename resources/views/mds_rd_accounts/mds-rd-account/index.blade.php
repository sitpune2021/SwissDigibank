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

            <i class="las la-chart-pie text-white text-xl sm:text-2xl leading-none"></i>

        </div>

        <!-- TITLE -->
        <div class="min-w-0">

            <h2 class="text-lg sm:text-xl lg:text-2xl
                font-extrabold uppercase tracking-wide
                text-gray-800 leading-tight truncate">

               MDS / RD Accounts

            </h2>

            <p class="text-[11px] sm:text-sm text-gray-500 font-medium mt-1">

                Manage MDS & RD accounts, maturity schedules & investment records efficiently.

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
    @if($isSuperAdmin || in_array('mds-rd-accounts.create-rd-account', $permissions))
        <a href="{{ route('mds-rd-accounts.create-rd-account') }}"
            class="inline-flex items-center gap-2
            px-4 sm:px-5 py-2.5
            rounded-xl text-xs sm:text-sm font-bold uppercase
            shadow-lg transition-all duration-300 hover:scale-105"
            style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">

            <span>Add RD ACCOUNTS</span>
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
                    <!-- RD NO -->
                    <th class="px-4 sm:px-6 py-4 text-start min-w-[140px]">
                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">
                            <i class="las la-file-invoice text-warning text-base"></i>
                            <span>RD No</span>
                        </div>
                    </th>

                    <!-- CUSTOMER DETAILS -->
                    <th class="px-4 sm:px-6 py-4 text-start min-w-[240px]">
                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">
                            <i class="las la-user-circle text-success text-base"></i>
                            <span>Customer Details</span>
                        </div>
                    </th>

                    <!-- BRANCH -->
                    <th class="px-4 sm:px-6 py-4 text-start min-w-[150px]">
                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">
                            <i class="las la-building text-warning text-base"></i>
                            <span>Branch</span>
                        </div>
                    </th>

                    <!-- SCHEME -->
                    <th class="px-4 sm:px-6 py-4 text-start min-w-[170px]">
                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">
                            <i class="las la-coins text-info text-base"></i>
                            <span>Scheme</span>
                        </div>
                    </th>

                    <!-- AMOUNT -->
                    <th class="px-4 sm:px-6 py-4 text-start min-w-[140px]">
                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">
                            <i class="las la-wallet text-success text-base"></i>
                            <span>Amount</span>
                        </div>
                    </th>

                    <!-- TOTAL INST -->
                    <th class="px-4 sm:px-6 py-4 text-start min-w-[160px]">
                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">
                            <i class="las la-list-ol text-primary text-base"></i>
                            <span>Total Inst</span>
                        </div>
                    </th>

                    <!-- OPEN DATE -->
                    <th class="px-4 sm:px-6 py-4 text-start min-w-[160px]">
                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">
                            <i class="las la-calendar-plus text-primary text-base"></i>
                            <span>Open Date</span>
                        </div>
                    </th>

                    <!-- MATURITY DATE -->
                    <th class="px-4 sm:px-6 py-4 text-start min-w-[180px]">
                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">
                            <i class="las la-calendar-check text-success text-base"></i>
                            <span>Maturity Date</span>
                        </div>
                    </th>

                    <!-- FREQUENCY -->
                    <th class="px-4 sm:px-6 py-4 text-start min-w-[150px]">
                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">
                            <i class="las la-sync-alt text-info text-base"></i>
                            <span>Frequency</span>
                        </div>
                    </th>

                    <!-- STATUS -->
                    <th class="px-4 sm:px-6 py-4 text-start min-w-[130px]">
                        <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">
                            <i class="las la-check-circle text-success text-base"></i>
                            <span>Status</span>
                        </div>
                    </th>

                    <!-- ACTIONS -->
                    <th class="px-4 sm:px-6 py-4 text-center min-w-[130px]">
                        <div class="flex items-center justify-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wide">
                            <i class="las la-cogs text-gray-600 text-base"></i>
                            <span>Actions</span>
                        </div>
                    </th>

                </tr>

            </thead>

            <tbody>
                @forelse($rdAccounts as $account)
                <tr class="table-row border-b border-gray-100"
                    style="animation-delay:{{ $loop->index * 0.05 }}s">

                    <!-- SR NO -->
                    <td class="px-6 py-5 text-center font-semibold text-gray-700">

                        {{ $loop->iteration }}

                    </td>
                    
                    <td class="px-6 py-4 text-start">
                        <a href="{{route('rd-accounts.show',$account->id)}}" class="text-primary underline hover:text-primary/80">
                            {{ $account->rd_no ?? 'N/A' }}
                        </a>
                    </td>

                    <!-- CUSTOMER DETAILS -->
                    <td class="px-4 sm:px-6 py-4 text-start">

                        <div class="flex flex-col min-w-[220px]">

                            <!-- CUSTOMER NAME -->
                            <span class="text-gray-700 font-medium text-sm sm:text-[15px] truncate">

                                {{ optional($account->member)->full_name ?? '—' }}

                            </span>

                            <!-- CUSTOMER NUMBER -->
                            <a href="{{ route('member.show', $account->member->id) }}"
                                class="text-primary font-semibold hover:underline text-xs sm:text-sm">

                                Customer No : {{ optional($account->member)->member_no
                                    ?? (optional($account->member)->id
                                    ? str_pad($account->member->id, 6, '0', STR_PAD_LEFT)
                                    : 'N/A') }}

                            </a>                            

                        </div>

                    </td>
                    
                    <td class="px-6 py-4 text-start">
                        @php
                        $minor = $account->minor;
                        @endphp
                        {{ $minor ? trim(($minor->first_name ?? '').' '.($minor->last_name ?? '')) : 'No' }}
                    </td>

                    <td class="px-6 py-4 text-start">{{ optional($account->branch)->branch_name ?? '—' }}</td>          
                    <td class="px-6 py-4 text-start">{{ $account->scheme->scheme_name ?? '—' }}</td>
                    <td class="px-6 py-4 text-start">₹{{ number_format($account->rd_amount, 2) }}</td>                 

                    <td class="px-6 py-4 text-start">
                        {{ $account->open_date ? \Carbon\Carbon::createFromFormat('Y-m-d', $account->open_date)->format('d-m-Y') : '' }}
                    </td>
                    <td class="px-6 py-4 text-start">{{ $account->maturity_date ? \Carbon\Carbon::createFromFormat('Y-m-d', $account->maturity_date)->format('d-m-Y') : '' }}</td>
                    <td class="px-6 py-4 text-start">Monthly</td>

                    <td class="px-6 py-4 text-start">
                        @if($account->approve_status === 'Approved')
                        <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            Active
                        </span>
                        @else
                        <span class="block w-28 rounded-[30px] border border-n30 bg-warning/20 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            Pending
                        </span>
                        @endif
                    </td>
                    
                    <!-- ACTION -->
                    <td class="px-5 py-4 text-center align-middle"
                        data-label="Actions">

                        <div class="flex items-center justify-center gap-2 action-group">

                            <!-- VIEW -->
                            @if($isSuperAdmin || in_array('mds-rd-account.show', $permissions))
                            <a href="{{ route('mds-rd-account.show', $account->id) }}"
                                class="action-btn action-view">

                                <i class="las la-eye"></i>
                                <span>VIEW</span>

                            </a>
                            @endif


                        </div>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="21" class="px-6 py-6 text-start text-gray-500">No RD accounts found.</td>
                </tr>
                @endforelse
            </tbody>

        </table>

        @if ($rdAccounts->hasPages())
        <div class="flex items-center justify-center space-x-2 mt-6">
            {{-- Previous Page Link --}}
            @if ($rdAccounts->onFirstPage())
            <button class="px-3 py-1 border rounded-lg text-gray-400 bg-gray-100 cursor-not-allowed">Prev</button>
            @else
            <a href="{{ $rdAccounts->previousPageUrl() }}" class="px-3 py-1 border rounded-lg text-gray-600 hover:bg-gray-200">Prev</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($rdAccounts->getUrlRange(1, $rdAccounts->lastPage()) as $page => $url)
            @if ($page == $rdAccounts->currentPage())
            <span class="px-3 py-1 border rounded-lg bg-primary text-white">{{ $page }}</span>
            @else
            <a href="{{ $url }}" class="px-3 py-1 border rounded-lg hover:bg-gray-200">{{ $page }}</a>
            @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($rdAccounts->hasMorePages())
            <a href="{{ $rdAccounts->nextPageUrl() }}" class="px-3 py-1 border rounded-lg text-gray-600 hover:bg-gray-200">Next</a>
            @else
            <button class="px-3 py-1 border rounded-lg text-gray-400 bg-gray-100 cursor-not-allowed">Next</button>
            @endif
        </div>
        @endif

    </div>
   
</div>

@endsection