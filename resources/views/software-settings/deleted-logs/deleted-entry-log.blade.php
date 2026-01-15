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

    .custom-thead {
        background-color: #e6f4ea;
        color: #14532d;
    }

    .custom-thead th {
        font-weight: 600;
        border-bottom: 1px solid #ccc;
    }

    @media (prefers-color-scheme: dark) {
        .custom-thead {
            background-color: #14532d;
            color: #d1fae5;
        }
    }

    .bg-greens {
        background-color: #14532d;
    }

    .backdrop {
        backdrop-filter: blur(1px);
        -webkit-backdrop-filter: blur(1px);
        background-color: rgba(0, 0, 0, 0.1);


    }
</style>

@section('content')
<div class="main-inner">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
        <h3 class=" flex text-lg  uppercase font-semibold">
            DELETE LOGS
        </h3>

    </div>
    @if(session('success'))
    <div class="">
        <div class="w-44 mb-5 flex justify-end">
            <x-alert />
        </div>
        {{-- {{ session('success') }} --}}
    </div>
    @endif

    <div class="col-span-12 box lg:col-span-12">
        <div class="text-end">
            <a href="#" class="btn-error uppercase text-sm rounded-10 px-2">
                Download xls
            </a>
        </div>
        <div class="pb-4 mt-4 overflow-x-auto lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer ">
                            <div class="flex items-center gap-1 uppercase">
                                DELETED BY
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                ITEM TYPE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                ITEM ID
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                ITEM INFO
                            </div>
                        </th>

                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                DELETED ON
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                ACTION
                            </div>
                        </th>
                    </tr>
                </thead>


                <tbody>
                    <tr class="border-b ">
                        <td class="px-6 py-4">
                           RM RM (static)
                        </td>
                        <td class="px-6 py-4">
                           DepositLoanTransaction  (static)
                        </td>
                         <td class="px-6 py-4">
                          2147   (static)
                        </td>
                        <td class="px-6 py-4"> 
                              (static)
                        </td>
                         <td class="px-6 py-4"> 
                            10-10-2025  (static)
                        </td>
                        
                          <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex justify-center">
                                <div class="relative">
                                    <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                    <ul class="horiz-option popover-content">
                                        
                                        <li>
                                            <a href="{{ route('software-settings.deleted-logs.deleted-entry-log-view') }}"
                                                class="single-option uppercase">view</a>
                                        </li>

                                    </ul>
                                    {{-- @include('partials._vertical-options', [
                                    /* 'id' =>base64_encode($director->id),
                                    'viewRoute' => 'director.show',
                                    'editRoute' => 'director.edit'*/
                                    ]) --}}
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>


            </table>

        </div>


    </div>
</div>


@endsection