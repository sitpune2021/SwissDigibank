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
</style>

@section('content')
    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-xl block  uppercase  font-bold">
                Locker - 2222
            </h3>
        </div>
        <div class="">
            <a href="" class="btn-primary rounded-10 py-2 uppercase">
                Assign
            </a>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

            <div class=" col-span-2 box md:col-span-1 ">
                <div class="mb-3 flex justify-end">
                    <a href="" class="btn-primary rounded-10 p-2">
                        <i class="las la-pencil-alt"></i>
                    </a>
                </div>
                <table class="w-full  divide-y divide-gray-200 rounded-lg ">
                    <tbody class="divide-y divide-gray-100">
                        <tr class="border-b">
                            <td class="font-semibold uppercase text-lg text-gray-700 px-4 py-2 w-1/3">Locker No</td>
                            <td class="px-4 py-2 text-gray-600">2222</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold uppercase text-lg text-gray-700 px-4 py-2">Locker Name</td>
                            <td class="px-4 py-2 text-gray-600">Aaaa</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold uppercase text-lg text-gray-700 px-4 py-2">Locker Charge</td>
                            <td class="px-4 py-2 text-gray-600">222.0</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold uppercase text-lg text-gray-700 px-4 py-2">Assigned</td>
                            <td class="px-4 py-2">
                                <div class="flex items-center gap-1">
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                        Yes
                                    </span>
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                        No
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class=" col-span-2 box md:col-span-1 ">
                <div class="bg-secondary/5 rounded-10  px-5 py-3">
                    <h3 class="text-lg font-semibold tracking-wide">LOCKER HISTORY</h3>
                </div>
                <div class="bg-white dark:bg-gray-900">
                    <div class="overflow-x-auto whitespace-nowrap">
                        <table class="w-full whitespace-nowrap divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-800">
                                <tr class="border-b">
                                    <th
                                        class="px-4 py-2 text-start text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase">
                                        Member Name</th>
                                    <th
                                        class="px-4 py-2 text-start text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase">
                                        S/Ac. No</th>
                                    <th
                                        class="px-4 py-2 text-start text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase">
                                        Assigned On</th>
                                    <th
                                        class="px-4 py-2 text-start text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase">
                                        Release Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <td class="px-4 py-3 text-sm text-primary">
                                        <a href=""  class="">
                                            DEMO-04287 - kuldeeeeeeep
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">—</td>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">04-11-2025</td>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">04-11-2025</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

@endsection