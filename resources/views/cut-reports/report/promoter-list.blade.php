@extends('layout.main')
@section('content')
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
<div class="main-inner">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
        <h3 class=" flex text-lg   uppercase font-semibold">
            Report - Promoter List
        </h3>
    </div>

    <div class="col-span-12 box lg:col-span-12">
        <div class="mb-5 flex justify-end gap-2 flex-col md:flex-row lg:flex-row">

            <a href="{{ route('reports.promoter.print') }}" target="_blank"
                class="btn-primary rounded-10 px-2 py-2 flex justify-center  text-sm uppercase">
                <i class="las la-print"></i>
                Print Cut Report
            </a>
            <a href="#" class="btn-primary rounded-10 px-2 flex justify-center py-2 text-sm uppercase">
                <i class="las la-download"></i>
                download Cut Report
            </a>
            <a href="#" class="btn-error rounded-10 px-2 flex justify-center py-2 text-sm uppercase">
                <i class="las la-download"></i>
                Download Csv
            </a>
        </div>

        <div class="pb-4 overflow-x-auto lg:pb-6">

            <table class="w-full whitespace-nowrap select-all-table" id="">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Sr. No
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Designation
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                promoter Name
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                L. P. no
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Balance
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalBalance = 0; @endphp

                    @foreach ($account as $key => $row)

                    @php
                        $balance = $row->promotor?->shareHoldings?->sum('amount') ?? 0;
                        $totalBalance += $balance;
                    @endphp

                    <tr class="border-b dark:border-bg3">
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                {{ $account->firstItem() + $key }}
                            </div>
                        </td>

                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 capitalize">
                                {{ $row->promotor?->occupation ?? '-' }}
                            </div>
                        </td>

                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                {{ $row->promotor?->first_name }} 
                                {{ $row->promotor?->middle_name }} 
                                {{ $row->promotor?->last_name }}
                            </div>
                        </td>

                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                -
                            </div>
                        </td>

                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                               {{ number_format($balance,2) }}
                            </div>
                        </td>

                    </tr>
                    @endforeach
                    <tr class="bg-gray-100 font-semibold">
                        <td colspan="2" class="px-6 py-4 text-start">
                            Total Records : {{ $account->total() }}
                        </td>

                        <td colspan="2" class="px-6 py-4 text-end">
                            Total Balance
                        </td>

                        <td class="px-6 py-4 text-start">
                            {{ number_format($totalBalance, 2) }}
                        </td>
                    </tr>
                    <tr class="bg-gray-100 font-semibold">
                        <td colspan="2" class="px-6 py-4 text-start">
                            Credit Balance : {{ number_format($totalBalance, 2) }}
                        </td>

                        <td colspan="2" class="px-6 py-4 text-center">
                            Debit Balance : {{ number_format(0, 2) }}
                        </td>

                        <td class="px-6 py-4 text-end">
                            GL Total : {{ number_format(0, 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

        <div class="mt-5">
            <x-pagination :paginator="$account" />
        </div>

    </div>


    @endsection