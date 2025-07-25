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
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3 lg:mb-5">
            <h3 class="h3">Share Holdings</h3>
            <a class="btn btn-warning btn-sm" title="UN-ALLOTTED SHARE LIST" onclick="block_ui()"
                href="{{ route('shares-holdings.create') }}">
                UN ALLOTTED / DUPLICATE SHARE LIST
            </a>
            <a class="btn btn-warning btn-sm" title="UN-ALLOTTED SHARE LIST" onclick="block_ui()"
                href="/share-holdings/unallotted">
                UN ALLOTTED / DUPLICATE SHARE LIST
            </a>
            <a class="btn-primary" href="{{ route('shares-holdings.create') }}">
                <i class=" text-base md:text-lg"></i>
                Add
            </a>
        </div>

        <!-- Latest Transactions -->
        <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
            <form method="GET" action="{{ route('shares-holdings.index') }}"
                class="relative flex items-center gap-2 bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xl:max-w-[319px]">
                <input type="text" id="transaction-search" name="search" placeholder="Search"
                    value="{{ request('search') }}"
                    class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                <button type="submit"
                    class="w-7 h-7 bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                    <i class="las la-search text-lg"></i>
                </button>
                @if (request('search'))
                    <a href="{{ route('shares-holdings.index') }}"
                        class="w-7 h-7 bg-grey-500 hover:bg-grey-900 text-dark rounded-full flex items-center justify-center transition duration-200"
                        title="Clear Search">
                        <i class="las la-times text-lg"></i>
                    </a>
                @endif
            </form>
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
