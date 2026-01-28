@extends('layout.main')


@section('content')
@php
use Illuminate\Support\Facades\Storage;
@endphp
<div class="grid grid-cols-2 md:grid-cols-3 gap-6   md-4">
    {{-- NOTICE BOARD ** --}}
    <div class="col-span-2 md:col-span-1  dark:bg-bg3 rounded-2xl ">

        <div class="w-full mb-3 col-span-1 p-4 sm:col-span-3 xxxl:col-span-1 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
            <a href="{{ route('notice-boards.index') }}">
                <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                    <span class="font-medium"> NOTICE BOARD <span class="text-error"> ** </span> </span><span
                        aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="cursor-pointer tabler-icon tabler-icon-dots">
                            <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                            <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                            <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        </svg></span>
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
                        </span> </span><span aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="18"
                            height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="cursor-pointer tabler-icon tabler-icon-dots">
                            <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                            <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                            <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        </svg></span>
                </div>
                <div class="flex items-center gap-4 xl:gap-6">
                    {{-- <div
                        class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                        <i class="text-3xl las xl:text-5xl la-clipboard"></i>

                    </div> --}}
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
                                    {{-- <img src="{{ asset($dashboardData['logo']->image_path) }}" alt="Logo"
                                        class="rounded-10" width="100"> --}}
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
                                    {{-- <img src="{{ asset($dashboardData['letterhead']->image_path) }}" alt="Letterhead"
                                        class="rounded-10" width="60" style="height: 60px !important;"> --}}
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

    <div class="col-span-12 p-4 sm:col-span-3 xxxl:col-span-3 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
        <a href="{{ route('branch.index') }}">
            <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                <span class="font-medium"> BRANCHES</span><span aria-expanded="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="cursor-pointer tabler-icon tabler-icon-dots">
                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></span>
            </div>
            <div class="flex items-center gap-4 xl:gap-6">
                <div
                    class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                    <i class="text-3xl las xl:text-5xl la-home"></i>
                </div>
                <div>
                    <h4 class="mb-2 h4 xxl:mb-4">{{ $dashboardData['branchesCount'] }}</h4>
                </div>
            </div>
        </a>
    </div>

    <!-- MEMBER -->
    <div class="col-span-12 p-4 sm:col-span-3 xxxl:col-span-3 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
        <a href="{{ route('member.index') }}">
            <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                <span class="font-medium">CUSTOMERS </span><span aria-expanded="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="cursor-pointer tabler-icon tabler-icon-dots">
                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></span>
            </div>
            <div class="flex items-center gap-4 xl:gap-6">
                <div
                    class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                    <i class="text-3xl las xl:text-5xl la-user"></i>
                </div>
                <div>
                    <h4 class="mb-2 h4 xxl:mb-4">{{ $dashboardData['membersCount'] }}</h4><span
                        class="flex items-center gap-1 whitespace-nowrap text-primary"></span>
                </div>
            </div>
        </a>
    </div>
    <!-- GROUPS -->
    <div class="col-span-12 p-4 sm:col-span-3 xxxl:col-span-3 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
        <a href="#">
            <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                <span class="font-medium">GROUPS</span><span aria-expanded="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="cursor-pointer tabler-icon tabler-icon-dots">
                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></span>
            </div>
            <div class="flex items-center gap-4 xl:gap-6">
                <div
                    class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                    <i class="text-3xl las xl:text-5xl la-users"></i>
                </div>
                <div>
                    <h4 class="mb-2 h4 xxl:mb-4">0</h4><span
                        class="flex items-center gap-1 whitespace-nowrap text-primary"></span>
                </div>
            </div>
        </a>
    </div>
    <!-- PROMOTERS -->
    <div class="col-span-12 p-4 sm:col-span-3 xxxl:col-span-3 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
        <a href="{{ route('promotor.index') }}">
            <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                <span class="font-medium">PROMOTERS</span><span aria-expanded="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="cursor-pointer tabler-icon tabler-icon-dots">
                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></span>
            </div>
            <div class="flex items-center gap-4 xl:gap-6">
                <div
                    class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                    <i class="text-3xl las xl:text-5xl la-business-time"></i>
                </div>
                <div>
                    <h4 class="mb-2 h4 xxl:mb-4">{{ $dashboardData['promotorCount'] }}</h4><span
                        class="flex items-center gap-1 whitespace-nowrap text-primary"></span>
                </div>
            </div>
        </a>
    </div>
    <!-- SAVING ACCOUNTS -->
    <div class="col-span-12 p-4 sm:col-span-3 xxxl:col-span-3 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
        <a href="{{ route('accounts.index') }}">
            <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                <span class="font-medium"> SAVING ACCOUNTS</span><span aria-expanded="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="cursor-pointer tabler-icon tabler-icon-dots">
                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></span>
            </div>
            <div class="flex items-center gap-4 xl:gap-6">
                <div
                    class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                    <i class="text-3xl las xl:text-5xl la-piggy-bank"></i>
                </div>
                <div>
                    <h4 class="mb-2 h4 xxl:mb-4">{{ $dashboardData['savingAccounts'] }}</h4><span
                        class="flex items-center gap-1 whitespace-nowrap text-primary"></span>
                </div>
            </div>
        </a>
    </div>
    <!-- CURRENT ACCOUNTS -->
    <div class="col-span-12 p-4 sm:col-span-3 xxxl:col-span-3 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
        <a href="{{ route('accounts.index') }}">
            <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                <span class="font-medium"> CURRENT ACCOUNTS</span><span aria-expanded="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="cursor-pointer tabler-icon tabler-icon-dots">
                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></span>
            </div>
            <div class="flex items-center gap-4 xl:gap-6">
                <div
                    class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                    <i class="text-3xl las xl:text-5xl la-credit-card"></i>
                </div>
                <div>
                    <h4 class="mb-2 h4 xxl:mb-4">{{ $dashboardData['currentAccounts'] }}</h4><span
                        class="flex items-center gap-1 whitespace-nowrap text-primary"></span>
                </div>
            </div>
        </a>
    </div>
    <!-- FD ACCOUNTS -->
    <div class="col-span-12 p-4 sm:col-span-3 xxxl:col-span-3 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
        <a href="{{ route('fd-mis-schemes.fd_index') }}">
            <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                <span class="font-medium"> FD ACCOUNTS </span><span aria-expanded="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="cursor-pointer tabler-icon tabler-icon-dots">
                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></span>
            </div>
            <div class="flex items-center gap-4 xl:gap-6">
                <div
                    class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                    <i class="text-3xl las xl:text-5xl la-piggy-bank"></i>
                </div>
                <div>
                    <h4 class="mb-2 h4 xxl:mb-4">{{ $dashboardData['fdCount'] }}</h4><span
                        class="flex items-center gap-1 whitespace-nowrap text-primary"></span>
                </div>
            </div>
        </a>
    </div>
    <!-- MIS ACCOUNTS -->
    <div class="col-span-12 p-4 sm:col-span-3 xxxl:col-span-3 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
        <a href="{{ route('misaccount.index') }}">
            <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                <span class="font-medium"> MIS ACCOUNTS </span><span aria-expanded="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="cursor-pointer tabler-icon tabler-icon-dots">
                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></span>
            </div>
            <div class="flex items-center gap-4 xl:gap-6">
                <div
                    class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                    <i class="text-3xl las xl:text-5xl la-coins"></i>
                </div>
                <div>
                    <h4 class="mb-2 h4 xxl:mb-4">{{ $dashboardData['misCount'] }}</h4><span
                        class="flex items-center gap-1 whitespace-nowrap text-primary"></span>
                </div>
            </div>
        </a>
    </div>
    <!-- DDS ACCOUNTS -->
    <div class="col-span-12 p-4 sm:col-span-3 xxxl:col-span-3 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
        <a href="{{ route('dds-accounts.index') }}">
            <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                <span class="font-medium"> DDS ACCOUNTS </span><span aria-expanded="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="cursor-pointer tabler-icon tabler-icon-dots">
                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></span>
            </div>
            <div class="flex items-center gap-4 xl:gap-6">
                <div
                    class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                    <i class="text-3xl las xl:text-5xl la-coins"></i>
                </div>
                <div>
                    <h4 class="mb-2 h4 xxl:mb-4">{{ $dashboardData['ddsCount'] }}</h4><span
                        class="flex items-center gap-1 whitespace-nowrap text-primary"></span>
                </div>
            </div>
        </a>
    </div>
       <!-- MDS /RD ACCOUNTS -->
    <div class="col-span-12 p-4 sm:col-span-3 xxxl:col-span-3 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
        <a href="{{ route('mds-rd-accounts.rd-account-index') }}">
            <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                <span class="font-medium"> MDS/RD ACCOUNTS </span><span aria-expanded="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="cursor-pointer tabler-icon tabler-icon-dots">
                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></span>
            </div>
            <div class="flex items-center gap-4 xl:gap-6">
                <div
                    class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                    <i class="text-3xl las xl:text-5xl la-coins"></i>
                </div>
                <div>
                    <h4 class="mb-2 h4 xxl:mb-4">{{ $dashboardData['mdsRdCount'] }}</h4><span
                        class="flex items-center gap-1 whitespace-nowrap text-primary"></span>
                </div>
            </div>
        </a>
    </div>

    <!-- Gold Loan  -->
    <div class="col-span-12 p-4 sm:col-span-3 xxxl:col-span-3 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
        <a href="{{ route('gold-loan.account.index') }}">
            <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                <span class="font-medium">GOLD LOAN</span><span aria-expanded="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="cursor-pointer tabler-icon tabler-icon-dots">
                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></span>
            </div>
            <div class="flex items-center gap-4 xl:gap-6">
                <div
                    class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                    <i class="text-3xl las xl:text-5xl la-coins"></i>
                </div>

                <div>
                    <h4 class="mb-2 h4 xxl:mb-4">{{ $dashboardData['goldloan'] }}</h4>
                </div>
            </div>
        </a>
    </div>

    <!-- MORTGAGE LOAN  -->
    <div class="col-span-12 p-4 sm:col-span-3 xxxl:col-span-3 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
        <a href="{{ route('mortgage.account.index') }}">
            <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                <span class="font-medium">MORTGAGE LOAN</span><span aria-expanded="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="cursor-pointer tabler-icon tabler-icon-dots">
                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></span>
            </div>
            <div class="flex items-center gap-4 xl:gap-6">
                <div
                    class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                    <i class="text-3xl las xl:text-5xl la-file-invoice-dollar"></i>
                </div>

                <div>
                    <h4 class="mb-2 h4 xxl:mb-4">{{ $dashboardData['mortgageloan'] }}</h4>
                </div>
            </div>
        </a>
    </div>

    <!-- LOAN AGAINST DEPOSITE  -->
    <div class="col-span-12 p-4 sm:col-span-3 xxxl:col-span-3 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
        <a href="{{ route('loanagainst.account.index') }}">
            <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                <span class="font-medium">LOAN AGAINST DEPOSITE</span><span aria-expanded="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="cursor-pointer tabler-icon tabler-icon-dots">
                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></span>
            </div>
            <div class="flex items-center gap-4 xl:gap-6">
                <div
                    class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                    <i class="text-3xl las xl:text-5xl la-file-invoice-dollar"></i>
                </div>
                <div>
                    <h4 class="mb-2 h4 xxl:mb-4">{{ $dashboardData['loanagainst'] }}</h4>
                </div>
            </div>
        </a>
    </div>

    <!-- BUSINESS LOAN  -->
    <div class="col-span-12 p-4 sm:col-span-3 xxxl:col-span-3 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
        <a href="{{ route('bussiness.account.index') }}">
            <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                <span class="font-medium">BUSINESS LOAN</span><span aria-expanded="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="cursor-pointer tabler-icon tabler-icon-dots">
                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></span>
            </div>
            <div class="flex items-center gap-4 xl:gap-6">
                <div
                    class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                    <i class="text-3xl las xl:text-5xl la-briefcase"></i>
                </div>
                <div>
                    <h4 class="mb-2 h4 xxl:mb-4">{{ $dashboardData['businessloan'] }}</h4>
                </div>
            </div>
        </a>
    </div>

    <!-- CC / OD LIMIT LOAN  -->
    <div class="col-span-12 p-4 sm:col-span-3 xxxl:col-span-3 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
        <a href="{{ route('cc_od.account.index') }}">
            <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                <span class="font-medium">CC / OD LIMIT LOAN</span><span aria-expanded="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="cursor-pointer tabler-icon tabler-icon-dots">
                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></span>
            </div>
            <div class="flex items-center gap-4 xl:gap-6">
                <div
                    class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                    <i class="text-3xl las xl:text-5xl la-sync"></i>
                </div>
                <div>
                    <h4 class="mb-2 h4 xxl:mb-4">{{ $dashboardData['ccodloan'] }}</h4>
                </div>
            </div>
        </a>
    </div>

    <!-- DAILY WEEKLY LOAN  -->
    <div class="col-span-12 p-4 sm:col-span-3 xxxl:col-span-3 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
        <a href="{{ route('daily_weekly.account.index') }}">
            <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                <span class="font-medium">DAILY WEEKLY LOAN</span><span aria-expanded="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="cursor-pointer tabler-icon tabler-icon-dots">
                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></span>
            </div>
            <div class="flex items-center gap-4 xl:gap-6">
                <div
                    class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                    <i class="text-3xl las xl:text-5xl la-calendar"></i>
                </div>
                <div>
                    <h4 class="mb-2 h4 xxl:mb-4">{{ $dashboardData['dailyweeklyloan'] }}</h4>
                </div>
            </div>
        </a>
    </div>

    <!-- PERSONAL LOAN  -->
    <div class="col-span-12 p-4 sm:col-span-3 xxxl:col-span-3 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
        <a href="{{ route('personal.account.index') }}">
            <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                <span class="font-medium">PERSONAL LOAN</span><span aria-expanded="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="cursor-pointer tabler-icon tabler-icon-dots">
                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></span>
            </div>
            <div class="flex items-center gap-4 xl:gap-6">
                <div
                    class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                    <i class="text-3xl las xl:text-5xl la-user"></i>
                </div>
                <div>
                    <h4 class="mb-2 h4 xxl:mb-4">{{ $dashboardData['personalloan'] }}</h4>
                </div>
            </div>
        </a>
    </div>

    <!-- VEHICAL LOAN  -->
    <div class="col-span-12 p-4 sm:col-span-3 xxxl:col-span-3 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
        <a href="{{ route('vehical.account.index') }}">
            <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                <span class="font-medium">VEHICAL LOAN</span><span aria-expanded="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="cursor-pointer tabler-icon tabler-icon-dots">
                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></span>
            </div>
            <div class="flex items-center gap-4 xl:gap-6">
                <div
                    class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                    <i class="text-3xl las xl:text-5xl la-car"></i>
                </div>
                <div>
                    <h4 class="mb-2 h4 xxl:mb-4">{{ $dashboardData['vehicalloan'] }}</h4>
                </div>
            </div>
        </a>
    </div>
 <div class="col-span-12 p-4 sm:col-span-3 xxxl:col-span-3 box bg-n0 dark:bg-bg4 4xl:px-8 4xl:py-6">
        <a href="{{ route('mis_index') }}">
            <div class="flex items-center justify-between pb-4 mb-4 lg:mb-6 lg:pb-6 bb-dashed">
                <span class="font-medium uppercase">MIS Report</span><span aria-expanded="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="cursor-pointer tabler-icon tabler-icon-dots">
                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></span>
            </div>
            <div class="flex items-center gap-4 xl:gap-6">
                <div
                    class="w-14 xl:w-[72px] h-14 xl:h-[72px] flex items-center justify-center bg-primary/5 text-primary border border-n30 dark:border-n500 rounded-xl">
                  <i class="las la-chart-line"></i>

                </div>
                <div>
                    {{-- <h4 class="mb-2 h4 xxl:mb-4">{{ $dashboardData['vehicalloan'] }}</h4> --}}
                </div>
            </div>
        </a>
    </div>
   


</div>
    <div class="grid grid-cols-12 gap-4 xxl:gap-6 mt-5">

        
    
    <div class="box col-span-12 bg-n0 dark:bg-bg4 min-[650px]:col-span-6 xxxl:col-span-3">
        <div class="flex items-center justify-between pb-4 mb-4 bb-dashed lg:mb-6 lg:pb-6">
            <span class="font-medium">PAYMENT TO COLLECT</span>
            @include('partials._horizontal-options')
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
    </div>

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

    <!-- Statistics -->
    
    <div class="box col-span-12 bg-n0 dark:bg-bg4 min-[650px]:col-span-6 xxxl:col-span-3">
        <div class="flex items-center justify-between pb-4 mb-4 bb-dashed lg:mb-6 lg:pb-6">
            <span class="font-medium">TOTAL SPENDING</span>
            @include('partials._horizontal-options')

        </div>
        <div class="flex items-center justify-between">
            <div>
                <h4 class="mb-4 h4">&#8377; 00</h4>
                <span class="flex items-center gap-1 whitespace-nowrap text-primary">
                    <i class="text-lg las la-arrow-up"></i> 35.7 AVG
                </span>
            </div>
            <div
                class="-my-3 shrink-0 ltr:translate-x-3 xl:ltr:translate-x-7 xxxl:ltr:translate-x-2 4xl:ltr:translate-x-9 rtl:-translate-x-3 xl:rtl:-translate-x-7 xxxl:rtl:-translate-x-2 4xl:rtl:-translate-x-9">
                <div class="progress-chart"></div>
            </div>
        </div>
    </div>
    <div class="box col-span-12 bg-n0 dark:bg-bg4 min-[650px]:col-span-6 xxxl:col-span-3">
        <div class="flex items-center justify-between pb-4 mb-4 bb-dashed lg:mb-6 lg:pb-6">
            <span class="font-medium">SPENDING GOAL</span>
            @include('partials._horizontal-options')

        </div>
        <div class="flex items-center justify-between">
            <div>
                <h4 class="mb-4 h4">&#8377; 00</h4>
                <span class="flex items-center gap-1 whitespace-nowrap text-primary">
                    <i class="text-lg las la-arrow-up"></i> 35.7 AVG
                </span>
            </div>
            <div
                class="-my-3 shrink-0 ltr:translate-x-3 xl:ltr:translate-x-7 xxxl:ltr:translate-x-2 4xl:ltr:translate-x-9 rtl:-translate-x-3 xl:rtl:-translate-x-7 xxxl:rtl:-translate-x-2 4xl:rtl:-translate-x-9">
                <div class="progress-chart"></div>
            </div>
        </div>
    </div>
    <div class="box col-span-12 bg-n0 dark:bg-bg4 min-[650px]:col-span-6 xxxl:col-span-3">
        <div class="flex items-center justify-between pb-4 mb-4 bb-dashed lg:mb-6 lg:pb-6">
            <span class="font-medium">TOTAL TRANSACTIONS</span>
            @include('partials._horizontal-options')

        </div>
        <div class="flex items-center justify-between">
            <div>
                <h4 class="mb-4 h4">&#8377; 00</h4>
                <span class="flex items-center gap-1 whitespace-nowrap text-primary">
                    <i class="text-lg las la-arrow-up"></i> 35.7 AVG
                </span>
            </div>
            <div
                class="-my-3 shrink-0 ltr:translate-x-3 xl:ltr:translate-x-7 xxxl:ltr:translate-x-2 4xl:ltr:translate-x-9 rtl:-translate-x-3 xl:rtl:-translate-x-7 xxxl:rtl:-translate-x-2 4xl:rtl:-translate-x-9">
                <div class="progress-chart"></div>
            </div>
        </div>
    </div>
    <!-- Assetchart -->
    <!-- <div class="col-span-12 overflow-x-hidden box">
                        <div class="flex flex-wrap items-center justify-between gap-3 pb-4 mb-4 bb-dashed">
                            <h4 class="h4">Your Assets</h4>
                            <div class="border rounded-lg border-n30 bg-primary/5 dark:border-n500">
                                <button id="one_month"
                                    class="px-4 py-2 text-xs font-medium asset-btn first:rounded-s-lg last:rounded-e-lg">
                                    1M
                                </button>
                                <button id="six_months"
                                    class="px-4 py-2 text-xs font-medium asset-btn first:rounded-s-lg last:rounded-e-lg">
                                    6M
                                </button>
                                <button id="one_year"
                                    class="px-4 py-2 text-xs font-medium asset-btn active first:rounded-s-lg last:rounded-e-lg">
                                    1Y
                                </button>
                                <button id="ytd"
                                    class="px-4 py-2 text-xs font-medium asset-btn first:rounded-s-lg last:rounded-e-lg">
                                    YTD
                                </button>
                                <button id="all"
                                    class="px-4 py-2 text-xs font-medium asset-btn first:rounded-s-lg last:rounded-e-lg">
                                    all
                                </button>
                            </div>
                        </div>
                        <div id="asset-chart"></div>
                    </div> -->
    <!-- Latest Transactions -->
    <div class="col-span-12 box lg:col-span-6">
        <div class="flex flex-wrap items-center justify-between gap-4 pb-4 mb-4 bb-dashed lg:mb-6 lg:pb-6">
            <h4 class="h4">LATEST TRANSACTION</h4>
            @include('partials._horizontal-options')

        </div>
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="flex min-w-[300px] cursor-pointer items-center gap-1 px-6 py-5 text-start">
                            Title
                        </th>
                        <th class="min-w-[120px] cursor-pointer px-6 py-5 text-start">
                            <div class="flex items-center gap-1">Medium</div>
                        </th>
                        <th class="min-w-[120px] cursor-pointer px-6 py-5 text-start">
                            <div class="flex items-center gap-1">Amount</div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Transactions Data -->
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="px-6 py-2">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/visa.png') }}" width="32" height="32"
                                    class="rounded-full" alt="payment medium icon" />
                                <div>
                                    <p class="mb-1 font-medium">Hooli INV-79820</p>
                                    <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-2">Paypal</td>
                        <td class="px-6 py-2">&#8377;1,121,212</td>
                    </tr>





                    <!-- Add more rows for the remaining data items -->
                </tbody>
            </table>
        </div>
        <a class="inline-flex items-center gap-1 mt-6 font-semibold group text-primary" href="#">
            See More
            <i class="duration-300 las la-arrow-right group-hover:pl-2"></i>
        </a>
    </div>
    <!-- Transaction account -->
    <div class="col-span-12 box lg:col-span-6">
        <div class="flex flex-wrap items-center justify-between gap-4 pb-4 mb-4 bb-dashed lg:mb-6 lg:pb-6">
            <h4 class="h4">TRANSACTION ACCOUNT</h4>
            @include('partials._horizontal-options')

        </div>
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="min-w-[280px] cursor-pointer px-6 py-5 text-start">
                            <div class="flex items-center gap-1">Title</div>
                        </th>
                        <th class="w-[20%] cursor-pointer px-6 py-5 text-start">
                            <div class="flex items-center gap-1">Amount</div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Transactions Data -->
                    <tr key="John Snow - Metal" class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="px-6 py-2">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/card-sm-1.png') }}" width="60" height="40"
                                    class="rounded" alt="payment medium icon" />
                                <div>
                                    <p class="mb-1 font-medium">John Snow - Metal</p>
                                    <span class="text-xs">**4291 - Exp: 12/26</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-2">
                            <div>
                                <p class="font-medium">&#8377;95,200.00</p>
                                <span class="text-xs">Account Balance</span>
                            </div>
                        </td>
                    </tr>
                    <tr key="John Snow - Virtual" class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="px-6 py-2">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/card-sm-2.png') }}" width="60" height="40"
                                    class="rounded" alt="payment medium icon" />
                                <div>
                                    <p class="mb-1 font-medium">John Snow - Virtual</p>
                                    <span class="text-xs">**4291 - Exp: 12/26</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-2">
                            <div>
                                <p class="font-medium">&#8377;54,448.54</p>
                                <span class="text-xs">Account Balance</span>
                            </div>
                        </td>
                    </tr>
                    <tr key="Ben Abramov - Metal" class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="px-6 py-2">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/card-sm-3.png') }}" width="60" height="40"
                                    class="rounded" alt="payment medium icon" />
                                <div>
                                    <p class="mb-1 font-medium">Ben Abramov - Metal</p>
                                    <span class="text-xs">**4291 - Exp: 12/26</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-2">
                            <div>
                                <p class="font-medium">&#8377;74,215.32</p>
                                <span class="text-xs">Account Balance</span>
                            </div>
                        </td>
                    </tr>
                    <tr key="John Cina - Virtual" class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="px-6 py-2">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/card-sm-8.png') }}" width="60" height="40"
                                    class="rounded" alt="payment medium icon" />
                                <div>
                                    <p class="mb-1 font-medium">John Cina - Virtual</p>
                                    <span class="text-xs">**4291 - Exp: 12/26</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-2">
                            <div>
                                <p class="font-medium">د.ك &#8377;67,511.21</p>
                                <span class="text-xs">Account Balance</span>
                            </div>
                        </td>
                    </tr>
                    <tr key="Kane Methew - Metal" class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="px-6 py-2">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/card-sm-4.png') }}" width="60" height="40"
                                    class="rounded" alt="payment medium icon" />
                                <div>
                                    <p class="mb-1 font-medium">Kane Methew - Metal</p>
                                    <span class="text-xs">**4291 - Exp: 12/26</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-2">
                            <div>
                                <p class="font-medium">&#8377;36,122,54</p>
                                <span class="text-xs">Account Balance</span>
                            </div>
                        </td>
                    </tr>
                    <tr key="Jane Alam - Virtual" class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="px-6 py-2">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/card-sm-5.png') }}" width="60" height="40"
                                    class="rounded" alt="payment medium icon" />
                                <div>
                                    <p class="mb-1 font-medium">Jane Alam - Virtual</p>
                                    <span class="text-xs">**4291 - Exp: 12/26</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-2">
                            <div>
                                <p class="font-medium">&#8377;75,121,36</p>
                                <span class="text-xs">Account Balance</span>
                            </div>
                        </td>
                    </tr>
                    <tr key="Jabed Miah - Metal" class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="px-6 py-2">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/card-sm-6.png') }}" width="60" height="40"
                                    class="rounded" alt="payment medium icon" />
                                <div>
                                    <p class="mb-1 font-medium">Jabed Miah - Metal</p>
                                    <span class="text-xs">**4291 - Exp: 12/26</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-2">
                            <div>
                                <p class="font-medium">&#8377;88,125.00</p>
                                <span class="text-xs">Account Balance</span>
                            </div>
                        </td>
                    </tr>
                    <tr key="Bablu Sheikh - Virtual" class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="px-6 py-2">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/card-sm-7.png') }}" width="60" height="40"
                                    class="rounded" alt="payment medium icon" />
                                <div>
                                    <p class="mb-1 font-medium">Bablu Sheikh - Virtual</p>
                                    <span class="text-xs">**4291 - Exp: 12/26</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-2">
                            <div>
                                <p class="font-medium">&#8377;96,214.03</p>
                                <span class="text-xs">Account Balance</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <a class="inline-flex items-center gap-1 mt-6 font-semibold group text-primary" href="#">
            See More
            <i class="duration-300 las la-arrow-right group-hover:pl-2"></i>
        </a>
    </div>
</div>
@endsection