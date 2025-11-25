@extends('layout.main')
@section('content')

<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center uppercase justify-between gap-4 lg:mb-8">
        <h4 class="h3">MIS ACCOUNTS</h4>
        <a class="btn-primary flex items-center gap-2 uppercase" href="{{route('misaccount.create')}}">
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
                                CUSTOMER NO
                            </div>
                        </th>

                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                CUSTOMER NAME
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
                            <a href="{{ $mis?->id ? route('misaccount.show', $mis->id) : '#' }}" class="text-primary underline hover:text-primary/80">
                                {{ $mis->id }}
                            </a>
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">
                            <a href="{{ $mis?->member_id ? route('member.show', $mis->member_id) : '#' }}" class="text-primary underline hover:text-primary/80">
                                {{ $mis->member->member_no 
    ?? ($mis->member_id ? str_pad($mis->member_id, 6, '0', STR_PAD_LEFT) : '-') }}
                            </a>
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">{{ $mis->member->full_name  ?? '-' }}</td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">{{ $mis->minor->first_name ?? '-' }}</td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">{{ $mis->branches->branch_id ?? '-' }}</td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">-</td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">{{ number_format($mis->mis_amount, 2) }}</td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">{{ \Carbon\Carbon::parse($mis->open_date)->format('d-m-Y') }}</td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">{{ strtoupper($mis->interest_payout_type) }}</td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">{{ \Carbon\Carbon::parse($mis->maturity_date)->format('d-m-Y') }}</td>
                        <td class="text-start !py-5 px-6 min-w-[100px]">
                            @if ($mis->status == 0)
                            <span class="block w-28 rounded-[30px] border border-n30 bg-warning/20 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                Pending
                            </span>
                            @elseif ($mis->status == 1)
                            <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                Approved
                            </span>
                            @elseif ($mis->status == 2)
                            <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-error text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                Rejected
                            </span>
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