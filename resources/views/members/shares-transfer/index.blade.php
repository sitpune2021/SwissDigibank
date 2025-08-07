@extends('layout.main')
<style>
    .breadcrumb {
        list-style: none;
        display: flex;
        padding: 0;
        margin-bottom: 1rem;
        font-size: 14px;
    }

    .breadcrumb li+li::before {
        content: "/";
        padding: 0 8px;
        color: #888;
    }

    .breadcrumb li a {
        text-decoration: none;
        color: #007bff;
    }

    .breadcrumb li.active {
        color: #555;
    }
</style>
@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <!-- <h2 class="h2">Manage share-holdings</h2> -->
        <h1 class="text-xl font-semibold">Share holdings</h1>
        <a class="btn-primary" href="{{ route('shareholding.transfer.form') }}">
            <i class="las la-plus-circle text-base md:text-lg"></i>
            Add
        </a>
    </div>

    {{-- <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <!-- <h2 class="h2">Manage Promotors</h2> -->
            <div>
                <h1 class="text-xl font-semibold">Manage Director</h1>
                <ol class="breadcrumb flex text-sm text-gray-600 mt-1 space-x-1">
                    <li><a href="{{ url('/dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
    <li><a href="{{ url('/manage-director') }}" class="text-blue-600 hover:underline">Director</a></li>
    <li class="text-gray-500">Manage Director</li>
    </ol>
</div>
<a href="{{ route('director.create') }}" class="btn-primary">
    <i class="las la-plus-circle text-base md:text-lg"></i>
    Add Director
</a>
</div> --}}

<!-- Latest Transactions -->

<div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
    <x-alert />
</div>
<div class="overflow-x-auto pb-4 lg:pb-6">
    <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
        <thead>
            <tr class="bg-secondary/5 dark:bg-bg3">
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">Branch</div>
                </th>
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">Member</div>
                </th>
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">Share Range</div>
                </th>
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">Total Shares Held</div>
                </th>
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">Nominal Val.</div>
                </th>
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">Total Share Val.</div>
                </th>
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">Allotment Date</div>
                </th>
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">Transfer Date</div>
                </th>
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">Cert. No</div>
                </th>
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">Surrendered</div>
                </th>

</div>
</th>
<th class="text-center !py-5" data-sortable="false">Action</th>
</tr>
</thead>
</table>
</div>
</div>
</div>
@endsection