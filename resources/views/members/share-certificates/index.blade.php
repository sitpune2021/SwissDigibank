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
        <h4 class="h2">Manage Share Certificate</h4>
        <a class="btn-primary" href="{{ route('share-certificates.create') }}">
            <i class=" text-base md:text-lg"></i>
            Add
        </a>
    </div>
        <!-- Latest Transactions -->
        <div class="box col-span-12 lg:col-span-6">
            <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                <!-- <h4 class="h4">Share Certificate</h4> -->
                <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                    <form
                        class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                        <input type="text" id="transaction-search" placeholder="Search"
                            class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                        <button
                            class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                            <i class="las la-search text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="overflow-x-auto pb-4 lg:pb-6">
                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Branch
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[150px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Member
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[150px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Share Range
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[150px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Certificate No.
                                </div>                              
                            </th>
                            <th class="text-center !py-5" data-sortable="false">Action</th>
                        </tr>
                    </thead>
                     @foreach ($certificates as $index => $certificate)
                            <tr class="border-b dark:border-bg3">
                                <td class="px-6 py-4">{{ $certificate->member->branch->branch_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $certificate->member ?? 'N/A' }}</td> 
                                <td class="px-6 py-4"> {{ $certificate->member->member_info_first_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $certificate->father_name ?? 'N/A' }}</td> 
                                <td class="py-2 px-6">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options', [
                                            'id' => $minor->id,
                                            'viewRoute' => 'minor.show',
                                            'editRoute' => 'minor.edit',
                                        ])
                                    </div>
                                </td>
                                
                            </tr>
                        @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection