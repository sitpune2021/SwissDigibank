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
</style>

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <h1 class="text-xl font-semibold">MIS Accounts</h1>
        <a class="btn-primary flex items-center gap-2" href="{{route('misaccount.create')}}">
            Add
        </a>
    </div>

    <div class="col-span-12 box lg:col-span-12">
        <x-searchbox />
        <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
            <x-alert />
        </div>
        <div class="pb-4 overflow-x-auto lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                ASSOCIATE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                GROUP
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                MIS NO
                            </div>
                        </th>


                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                MEMBER NO
                            </div>
                        </th>

                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                MEMBER NAME
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                MINOR
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                BRANCH
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                SCHEME
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                PRINCIPAL AMT.
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                OPEN DATE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                INT. PAYOUT
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                MATURITY DATE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                STATUS
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                ACTIONS
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($misaccounts as $mis)
                    <tr class="border-b dark:border-bg3">
                        <td class="text-start !py-5 px-6 min-w-[100px]">-</td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">-</td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">
                            <a href="{{'misaccount.show', $mis->id }}" class="text-primary underline hover:text-primary/80">
                                {{ $mis->id }}
                            </a>
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">
                            <a href="{{route('member.show',$mis->member_id)}}" class="text-primary underline hover:text-primary/80">
                                {{'DEMO-'. $mis->member_id ?? '-' }}
                            </a>
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">{{ $mis->member->full_name  ?? '-' }}</td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">{{ $mis->minor->first_name ?? '-' }}</td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">{{ $mis->branch->branch_id ?? '-' }}</td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">-</td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">{{ number_format($mis->mis_amount, 2) }}</td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">{{ \Carbon\Carbon::parse($mis->open_date)->format('d/m/Y') }}</td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">{{ strtoupper($mis->interest_payout_type) }}</td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">{{ \Carbon\Carbon::parse($mis->transaction_date)->addYears($mis->tenure_year)->format('d/m/Y') }}</td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">
                            @if ($mis->status == 0)
                            Pending
                            @elseif ($mis->status == 1)
                            Approve
                            @elseif ($mis->status == 2)
                            Not Approve
                            @endif
                        </td>
                        <td class="px-6 py-2">
                            <div class="flex justify-center">
                                <div class="flex justify-center">
                                    @include('partials._vertical-options', [
                                    'id' => $mis->id,
                                    'viewRoute' => 'misaccount.show',
                                    'editRoute' => $mis->status == 0 ? 'misaccount.edit' : null
                                    ])
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection