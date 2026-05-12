@extends('layout.main')

@section('content')
@php
use Illuminate\Support\Facades\Storage;
@endphp

<style>
    .neo-card{
    background: linear-gradient(145deg, #ffffff, #f1f5f9);
    border-radius: 18px;
    box-shadow: 
        8px 8px 18px rgba(0,0,0,0.08),
        -8px -8px 18px rgba(255,255,255,0.9);
    transition: all 0.3s ease;
    border: 1px solid rgba(255,255,255,0.4);
}

.dark .neo-card{
    background: #0F172A;
    box-shadow: 
        6px 6px 14px rgba(0,0,0,0.6),
        -6px -6px 14px rgba(255,255,255,0.05);
}

.neo-card:hover{
    transform: translateY(-4px) scale(1.01);
    box-shadow: 
        10px 10px 25px rgba(0,0,0,0.12),
        -6px -6px 20px rgba(255,255,255,0.8);
}
</style>

<div class="mb-6 flex items-center justify-between  px-6 py-4">

    <div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-white tracking-wide">
            Welcome, {{ auth()->user()->name }}
        </h2>
        <p class="text-sm text-gray-500">Dashboard Overview</p>
    </div>

    <div class="text-right">
        <p class="text-sm text-gray-500">Today</p>
        <h3 class="font-semibold text-gray-800 dark:text-white">
            {{ date('d M Y') }}
        </h3>
    </div>

</div>


<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 p-4">

    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 md-4">
        
        {{-- NOTICE BOARD ** --}}
        <div class="col-span-2 md:col-span-1  dark:bg-bg3 rounded-2xl ">

            <div class="w-full mb-3 col-span-1 p-4 sm:col-span-3 xxxl:col-span-1 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
                <a href="{{ route('notice-boards.index') }}">
                    <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                        <span class="font-medium"> NOTICE BOARD <span class="text-error"> ** </span>
                    </div>
                    <div class="flex items-center gap-4 xl:gap-6">
                        <div
                            class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                            <i class="text-3xl las xl:text-5xl la-clipboard"></i>

                        </div>
                        <div>
                            <h4 class="mb-2 h4 xxl:mb-4">
                                <marquee direction="up" scrollamount="2" height="50px" onmouseover="this.stop();"
                                    onmouseout="this.start();">
                                    <ul class="animate-marquee space-y-2">
                                        @forelse($dashboardData['notices'] as $notice)
                                        <li class="text-sm xl:text-base uppercase mb-4">
                                            {{ $notice->notice_title }} &nbsp;&nbsp; {{
                                            \Carbon\Carbon::parse($notice->start_date)->format('d-m-Y') }}

                                        </li>
                                        @empty
                                        <li class="text-sm xl:text-base text-gray-500">No notices found</li>
                                        @endforelse
                                    </ul>
                                </marquee>
                            </h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        {{-- Upload logo and letter head --}}
        @auth
        @if(auth()->user()->isSuperAdmin())
        <div class="col-span-2 md:col-span-1  dark:bg-bg3 rounded-2xl ">

            <div class="w-full mb-3 col-span-1 p-4 sm:col-span-3 xxxl:col-span-1 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
                <a href="{{ route('pdf-images.index') }}">
                    <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                        <span class="font-medium uppercase"> Upload logo and letter head <span class="text-error"> **
                            </span>                                            
                    </div>
                    <div class="flex items-center gap-4 xl:gap-6">
                    
                        <div>
                            <div class="dashboard-header flex gap-5">
                                @if($dashboardData['logo'])
                                <div class="flex flex-row items-center bg-secondary/5 rounded-10 gap-3 border p-1">
                                    <h4 class="uppercase text-lg text-primary ">logo</h4>
                                    <div class="logo">
                                        <img src="{{ Storage::url($dashboardData['logo']->image_path) }}"
                                        alt="Logo"
                                        class="rounded-10"
                                        width="100">
                                    </div>
                                </div>
                                @endif

                                @if($dashboardData['letterhead'])
                                <div class="flex flex-row items-center bg-secondary/5 rounded-10 gap-3 border p-1">
                                    <h4 class="uppercase text-lg text-primary ">Letter head</h4>
                                    <div class="letterhead">
                                        <img src="{{ Storage::url($dashboardData['letterhead']->image_path) }}"
                                            alt="Letterhead"
                                            class="rounded-10"
                                            width="60"
                                            style="height: 60px !important;">
                                    </div>
                                </div>
                                @endif
                            </div>

                        </div>

                    </div>
                </a>
            </div>

        </div>
        @endif
        @endauth

    </div>


    <div class="grid grid-cols-12 gap-4 xxl:gap-6">

        <!-- BRANCHES -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-4">
        <a href="{{ route('branch.index') }}">

        <div class="bg-white dark:bg-bg4 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-5 border border-gray-100 hover:border-green-400">

            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-semibold text-gray-500 uppercase">Branches</span>
            </div>

            <div class="flex items-center gap-4">

                <div class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl shadow-md"> 
                    <i class="text-3xl las xl:text-5xl la-home"></i> 
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $dashboardData['branchesCount'] }}</h2>
                    <p class="text-xs text-gray-500">Total Branches</p>
                </div>

            </div>

        </div>
        </a>
        </div>

        <!-- CUSTOMERS -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-4">
        <a href="{{ route('member.index') }}">

        <div class="bg-white dark:bg-bg4 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-5 border border-gray-100 hover:border-green-400">

        <div class="flex items-center justify-between mb-4">
        <span class="text-sm font-semibold text-gray-500 uppercase">Customers</span>
        </div>

        <div class="flex items-center gap-4">

        <div class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl shadow-md"> <i class="text-3xl las xl:text-5xl la-user"></i> </div>

        <div>
        <h2 class="text-2xl font-bold text-gray-800">{{ $dashboardData['membersCount'] }}</h2>
        <p class="text-xs text-gray-500">Total Customers</p>
        </div>

        </div>
        </div>
        </a>
        </div>

        <!-- GROUPS -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-4">
        <a href="#">

        <div class="bg-white dark:bg-bg4 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-5 border border-gray-100 hover:border-purple-400">

        <div class="flex items-center justify-between mb-4">
        <span class="text-sm font-semibold text-gray-500 uppercase">Groups</span>
        </div>

        <div class="flex items-center gap-4">

        <div class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl shadow-md"> <i class="text-3xl las xl:text-5xl la-users"></i> </div>

        <div>
        <h2 class="text-2xl font-bold text-gray-800">0</h2>
        <p class="text-xs text-gray-500">Total Groups</p>
        </div>

        </div>
        </div>
        </a>
        </div>


        <!-- PROMOTERS -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-3">
        <a href="{{ route('promotor.index') }}">

        <div class="bg-white dark:bg-bg4 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-5 border border-gray-100 hover:border-indigo-400">

        <div class="flex items-center justify-between mb-4">
        <span class="text-sm font-semibold text-gray-500 uppercase">Promoters</span>
        </div>

        <div class="flex items-center gap-4">

        <div class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl shadow-lg"> <i class="text-3xl las xl:text-5xl la-business-time"></i> </div>

        <div>
        <h2 class="text-2xl font-bold text-gray-800">{{ $dashboardData['promotorCount'] }}</h2>
        <p class="text-xs text-gray-500">Total Promoters</p>
        </div>

        </div>
        </div>

        </a>
        </div>

        <!-- SAVING ACCOUNTS -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-3">
        <a href="{{ route('accounts.index') }}">

        <div class="bg-white dark:bg-bg4 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-5 border border-gray-100 hover:border-green-400">

        <div class="flex items-center justify-between mb-4">
        <span class="text-sm font-semibold text-gray-500 uppercase">Saving Accounts</span>
        </div>

        <div class="flex items-center gap-4">

        <div class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl shadow-lg"> <i class="text-3xl las xl:text-5xl la-piggy-bank"></i> </div>

        <div>
        <h2 class="text-2xl font-bold text-gray-800">{{ $dashboardData['savingAccounts'] }}</h2>
        <p class="text-xs text-gray-500">Total Saving Accounts</p>
        </div>

        </div>
        </div>

        </a>
        </div>

        <!-- CURRENT ACCOUNTS -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-3">
        <a href="{{ route('accounts.index') }}">

        <div class="bg-white dark:bg-bg4 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-5 border border-gray-100 hover:border-blue-400">

        <div class="flex items-center justify-between mb-4">
        <span class="text-sm font-semibold text-gray-500 uppercase">Current Accounts</span>
        </div>

        <div class="flex items-center gap-4">

        <div class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl shadow-lg"> <i class="text-3xl las xl:text-5xl la-credit-card"></i> </div>

        <div>
        <h2 class="text-2xl font-bold text-gray-800">{{ $dashboardData['currentAccounts'] }}</h2>
        <p class="text-xs text-gray-500">Total Current Accounts</p>
        </div>

        </div>
        </div>

        </a>
        </div>

        <!-- FD ACCOUNTS -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-3">
        <a href="{{ route('fd-mis-schemes.fd_index') }}">

        <div class="bg-white dark:bg-bg4 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-5 border border-gray-100 hover:border-purple-400">

        <div class="flex items-center justify-between mb-4">
        <span class="text-sm font-semibold text-gray-500 uppercase">FD Accounts</span>
        </div>

        <div class="flex items-center gap-4">

        <div class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl shadow-lg">
        <i class="text-3xl las xl:text-5xl la-university"></i>
        </div>

        <div>
        <h2 class="text-2xl font-bold text-gray-800">{{ $dashboardData['fdCount'] }}</h2>
        <p class="text-xs text-gray-500">Total FD Accounts</p>
        </div>

        </div>
        </div>

        </a>
        </div>


        <!-- MIS ACCOUNTS -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-4">
        <a href="{{ route('misaccount.index') }}">

        <div class="bg-white dark:bg-bg4 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-5 border border-gray-100 hover:border-orange-400">

        <div class="flex items-center justify-between mb-4">
        <span class="text-sm font-semibold text-gray-500 uppercase">MIS Accounts</span>
        </div>

        <div class="flex items-center gap-4">

        <div class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl shadow-lg">
        <i class="text-3xl las xl:text-5xl la-wallet"></i>
        </div>

        <div>
        <h2 class="text-2xl font-bold text-gray-800">{{ $dashboardData['misCount'] }}</h2>
        <p class="text-xs text-gray-500">Total MIS Accounts</p>
        </div>

        </div>
        </div>

        </a>
        </div>

        <!-- DDS ACCOUNTS -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-4">
        <a href="{{ route('dds-accounts.index') }}">

        <div class="bg-white dark:bg-bg4 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-5 border border-gray-100 hover:border-cyan-400">

        <div class="flex items-center justify-between mb-4">
        <span class="text-sm font-semibold text-gray-500 uppercase">DDS Accounts</span>
        </div>

        <div class="flex items-center gap-4">

        <div class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl shadow-lg">
        <i class="text-3xl las xl:text-5xl la-calendar-alt"></i>
        </div>

        <div>
        <h2 class="text-2xl font-bold text-gray-800">{{ $dashboardData['ddsCount'] }}</h2>
        <p class="text-xs text-gray-500">Total DDS Accounts</p>
        </div>

        </div>
        </div>

        </a>
        </div>

        <!-- MDS /RD ACCOUNTS -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-4">
        <a href="{{ route('mds-rd-accounts.rd-account-index') }}">

        <div class="bg-white dark:bg-bg4 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-5 border border-gray-100 hover:border-pink-400">

        <div class="flex items-center justify-between mb-4">
        <span class="text-sm font-semibold text-gray-500 uppercase">MDS / RD Accounts</span>
        </div>

        <div class="flex items-center gap-4">

        <div class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl shadow-lg">
        <i class="text-3xl las xl:text-5xl la-coins"></i>
        </div>

        <div>
        <h2 class="text-2xl font-bold text-gray-800">{{ $dashboardData['mdsRdCount'] }}</h2>
        <p class="text-xs text-gray-500">Total MDS / RD Accounts</p>
        </div>

        </div>
        </div>

        </a>
        </div>


        <!-- Gold Loan  -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-3">
        <a href="{{ route('gold-loan.account.index') }}">

        <div class="bg-white dark:bg-bg4 rounded-2xl shadow-md hover:shadow-xl transition duration-300 p-5 border border-gray-100 hover:border-yellow-400">

        <div class="flex items-center justify-between mb-4">
        <span class="text-sm font-semibold text-gray-500 uppercase">
        Gold Loan
        </span>
        </div>

        <div class="flex items-center gap-4">

        <div class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl shadow-lg">
        <i class="text-3xl las xl:text-5xl la-gem"></i>
        </div>

        <div>
        <h2 class="text-2xl font-bold text-gray-800">
        {{ $dashboardData['goldloan'] }}
        </h2>

        <p class="text-xs text-gray-500">Total Gold Loans</p>
        </div>

        </div>
        </div>
        </a>
        </div>

        <!-- MORTGAGE LOAN  -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-3">
        <a href="{{ route('mortgage.account.index') }}">

        <div class="bg-white dark:bg-bg4 rounded-2xl shadow-md hover:shadow-xl transition duration-300 p-5 border border-gray-100 hover:border-blue-400">

        <div class="flex items-center justify-between mb-4">
        <span class="text-sm font-semibold text-gray-500 uppercase">
        Mortgage Loan
        </span>
        </div>

        <div class="flex items-center gap-4">

        <div class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl shadow-lg">
        <i class="text-3xl las xl:text-5xl la-home"></i>
        </div>

        <div>
        <h2 class="text-2xl font-bold text-gray-800">
        {{ $dashboardData['mortgageloan'] }}
        </h2>

        <p class="text-xs text-gray-500">Total Mortgage Loans</p>
        </div>

        </div>
        </div>
        </a>
        </div>

        <!-- LOAN AGAINST DEPOSITE  -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-3">
        <a href="{{ route('loanagainst.account.index') }}">

        <div class="bg-white dark:bg-bg4 rounded-2xl shadow-md hover:shadow-xl transition duration-300 p-5 border border-gray-100 hover:border-green-400">

        <div class="flex items-center justify-between mb-4">
        <span class="text-sm font-semibold text-gray-500 uppercase">
        Loan Against Deposit
        </span>
        </div>

        <div class="flex items-center gap-4">

        <div class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl shadow-lg">
        <i class="text-3xl las xl:text-5xl la-hand-holding-usd"></i>
        </div>

        <div>
        <h2 class="text-2xl font-bold text-gray-800">
        {{ $dashboardData['loanagainst'] }}
        </h2>

        <p class="text-xs text-gray-500">Deposit Loans</p>
        </div>

        </div>
        </div>
        </a>
        </div>

        <!-- BUSINESS LOAN  -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-3">
        <a href="{{ route('bussiness.account.index') }}">

        <div class="bg-white dark:bg-bg4 rounded-2xl shadow-md hover:shadow-xl transition duration-300 p-5 border border-gray-100 hover:border-purple-400">

        <div class="flex items-center justify-between mb-4">
        <span class="text-sm font-semibold text-gray-500 uppercase">
        Business Loan
        </span>
        </div>

        <div class="flex items-center gap-4">

        <div
                        class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl shadow-lg">
                        <i class="text-3xl las xl:text-5xl la-briefcase"></i>
                    </div>

        <div>
        <h2 class="text-2xl font-bold text-gray-800">
        {{ $dashboardData['businessloan'] }}
        </h2>

        <p class="text-xs text-gray-500">Total Business Loans</p>
        </div>

        </div>
        </div>
        </a>
        </div>


        <!-- CC / OD LIMIT LOAN -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-3">
        <a href="{{ route('cc_od.account.index') }}">

        <div class="bg-white dark:bg-bg4 rounded-2xl shadow-md hover:shadow-xl transition duration-300 p-5 border border-gray-100">

        <div class="flex items-center justify-between mb-4">
        <span class="text-sm font-semibold text-gray-500 uppercase">CC / OD Limit Loan</span>
        </div>

        <div class="flex items-center gap-4">

        <div class="w-14 h-14 flex items-center justify-center bg-primary/5 text-primary border border-n30 rounded-xl shadow-lg">
        <i class="text-3xl las la-sync"></i>
        </div>

        <div>
        <h2 class="text-2xl font-bold text-gray-800">
        {{ $dashboardData['ccodloan'] }}
        </h2>
        <p class="text-xs text-gray-500">Total CC / OD Loans</p>
        </div>

        </div>
        </div>
        </a>
        </div>

        <!-- DAILY WEEKLY LOAN -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-3">
        <a href="{{ route('daily_weekly.account.index') }}">

        <div class="bg-white dark:bg-bg4 rounded-2xl shadow-md hover:shadow-xl transition duration-300 p-5 border border-gray-100">

        <div class="flex items-center justify-between mb-4">
        <span class="text-sm font-semibold text-gray-500 uppercase">Daily Weekly Loan</span>
        </div>

        <div class="flex items-center gap-4">

        <div class="w-14 h-14 flex items-center justify-center bg-primary/5 text-primary border border-n30 rounded-xl shadow-lg">
        <i class="text-3xl las la-calendar"></i>
        </div>

        <div>
        <h2 class="text-2xl font-bold text-gray-800">
        {{ $dashboardData['dailyweeklyloan'] }}
        </h2>
        <p class="text-xs text-gray-500">Daily / Weekly Loans</p>
        </div>

        </div>
        </div>
        </a>
        </div>

        <!-- PERSONAL LOAN -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-3">
        <a href="{{ route('personal.account.index') }}">

        <div class="bg-white dark:bg-bg4 rounded-2xl shadow-md hover:shadow-xl transition duration-300 p-5 border border-gray-100">

        <div class="flex items-center justify-between mb-4">
        <span class="text-sm font-semibold text-gray-500 uppercase">Personal Loan</span>
        </div>

        <div class="flex items-center gap-4">

        <div class="w-14 h-14 flex items-center justify-center bg-primary/5 text-primary border border-n30 rounded-xl shadow-lg">
        <i class="text-3xl las la-user"></i>
        </div>

        <div>
        <h2 class="text-2xl font-bold text-gray-800">
        {{ $dashboardData['personalloan'] }}
        </h2>
        <p class="text-xs text-gray-500">Total Personal Loans</p>
        </div>

        </div>
        </div>
        </a>
        </div>

        <!-- VEHICLE LOAN -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-3">
        <a href="{{ route('vehical.account.index') }}">

        <div class="bg-white dark:bg-bg4 rounded-2xl shadow-md hover:shadow-xl transition duration-300 p-5 border border-gray-100">

        <div class="flex items-center justify-between mb-4">
        <span class="text-sm font-semibold text-gray-500 uppercase">Vehicle Loan</span>
        </div>

        <div class="flex items-center gap-4">

        <div class="w-14 h-14 flex items-center justify-center bg-primary/5 text-primary border border-n30 rounded-xl shadow-lg">
        <i class="text-3xl las la-car"></i>
        </div>

        <div>
        <h2 class="text-2xl font-bold text-gray-800">
        {{ $dashboardData['vehicalloan'] }}
        </h2>
        <p class="text-xs text-gray-500">Total Vehicle Loans</p>
        </div>

        </div>
        </div>
        </a>
        </div>


        <!-- Fixed LOAN  -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-4">
        <a href="{{ route('personal.account.index') }}">

        <div class="bg-white dark:bg-bg4 rounded-2xl shadow-md hover:shadow-xl transition duration-300 p-5 border border-gray-100 hover:border-blue-400">

        <div class="flex items-center justify-between mb-4">
        <span class="text-sm font-semibold text-gray-500 uppercase">
        Fixed Loan
        </span>
        </div>

        <div class="flex items-center gap-4">

        <div class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl shadow-lg">
        <i class="text-3xl las xl:text-5xl la-university"></i>
        </div>

        <div>
        <h2 class="text-2xl font-bold text-gray-800">
        0
        </h2>

        <p class="text-xs text-gray-500">Total Personal Loans</p>
        </div>

        </div>
        </div>
        </a>
        </div>

        <!-- Consumer durable loan LOAN  -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-4">
       
        </div>

        <!-- Agricultural LOAN  -->
        <div class="neo-card p-5 col-span-12 sm:col-span-6 lg:col-span-4">
      
        </div>

    </div>

    <div class="grid grid-cols-12 gap-4 xxl:gap-6 mt-5">
        
        <style>
            .progress-chart1 {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                background: conic-gradient(#28a745 var(--value), #e5e7eb 0);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 18px;
                font-weight: bold;
                color: #111;
            }

            .progress-chart1::after {
                content: attr(data-percent) "%";
            }
        </style>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                    document.querySelectorAll('.progress-chart1').forEach(function (chart) {
                        let percent = chart.dataset.percent ?? 0;
                        chart.style.setProperty('--value', percent * 3.6 + 'deg');
                    });
                });
        </script>

        <div class="neo-card p-5 box col-span-12 bg-n0 dark:bg-bg4 min-[650px]:col-span-6 xxxl:col-span-3">
            <a href="{{ route('payments-to-collect.index') }}">
            <div class="flex items-center justify-between pb-4 mb-4 bb-dashed lg:mb-6 lg:pb-6">
                <span class="font-medium">PAYMENT TO COLLECT</span>
                <i class="las la-wallet text-xl text-green-600"></i>
                <!-- @include('partials._horizontal-options') -->
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="mb-4 h4">&#8377; {{ number_format($dashboardData['totalEmiDueAmount'], 2) }}</h4>
                    <span class="flex items-center gap-1 whitespace-nowrap text-primary">
                        <!-- <i class="text-lg las la-arrow-up"></i> -->
                    </span>
                </div>
                <div class="progress-chart1" data-percent="{{ $dashboardData['duePercent'] }}"></div>
            </div>
            </a>
        </div>


        <div class=" neo-card p-5 box col-span-12 bg-n0 dark:bg-bg4 min-[650px]:col-span-6 xxxl:col-span-3">
            <div class="flex items-center justify-between pb-4 mb-4 bb-dashed lg:mb-6 lg:pb-6">
                <span class="font-medium">PAYMENT TO RELEASE</span>
                <!-- @include('partials._horizontal-options') -->
                 <i class="las la-paper-plane text-lg text-primary"></i>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="mb-4 h4">&#8377; 00</h4>
                </div>
                <!-- <div
                    class="-my-3 shrink-0 ltr:translate-x-3 xl:ltr:translate-x-7 xxxl:ltr:translate-x-2 4xl:ltr:translate-x-9 rtl:-translate-x-3 xl:rtl:-translate-x-7 xxxl:rtl:-translate-x-2 4xl:rtl:-translate-x-9">
                    <div class="progress-chart"></div>
                </div> -->
                <div class="progress-chart1" data-percent="0"></div>
            </div>
        </div>

    </div>

</div>


@endsection