@extends('layout.main')
@section('page-title', 'FD ACCOUNT')
@section('action-button')
<a class="btn-primary uppercase text-sm" href="{{ route('fd-mis-schemes.fd_create') }}">
    <i class=" md:text-lg text-sm uppercase"></i>
    Add
</a>
@endsection
@section('content')

<div class="box col-span-12 lg:col-span-12">
    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>
    <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
        <div class="overflow-x-auto  whitespace-nowrap  pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap overflow-x-auto select-all-table" id="transactionTable1">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                Associate
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                Group
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                Fd. No
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                Customer No
                            </div>
                        </th>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                Customer Name
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                Minor
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                Branch
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                Scheme
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                Principal<br>Amt
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                Open<br>Date
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                Int.<br>Payout
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                Maturity<br>Date
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                Status
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                Active
                            </div>
                        </th>
                        <th class="text-center !py-5 uppercase" data-sortable="false">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($accounts as $account)
                    <tr class="border-b">
                        <td class="px-6 py-3">{{ $account->member->associate ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $account->member->group ?? '-' }}</td>
                        <td class="px-6 py-3">
                            <a href="{{route('fd-mis-schemes.fd_show',$account->id)}}" style="color:green;">{{ $account->fd_no }}</a>
                        </td>
                        <td class="px-6 py-3">
                            <a href="#" style="color:green;">
                                {{ $account->member->member_no 
            ?? ($account->member->id ? str_pad($account->member->id, 6, '0', STR_PAD_LEFT) : '-') }}
                            </a>
                        </td>
                        <td class="px-6 py-3">{{ $account->member->member_info_first_name ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $account->minor_id ? 'Yes' : 'No' }}</td>
                        <td class="px-6 py-3">{{ $account->branch->branch_name ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $account->account_type??'-' }}</td>
                        <td class="px-6 py-3">{{ number_format($account->fd_amount, 2) }}</td>
                        <td class="px-6 py-3">{{ \Carbon\Carbon::parse($account->open_date)->format('d-m-Y') ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $account->interest_payout_type??'-' }}</td>
                        <td class="px-6 py-3">
                            {{ \Carbon\Carbon::parse($account->maturity_date)->format('d-m-Y') ?? '-' }}
                        </td>
                        <td class="px-6 py-3">
                            @if ($account->status == 0)
                            <span class="block w-28 rounded-[30px] border border-n30 bg-warning/20 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                Pending
                            </span>
                            @elseif ($account->status == 1)
                            <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                Approved
                            </span>
                            @elseif ($account->status == 2)
                            <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-error text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                Rejected
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            <span class="text-green-600">Active</span>
                        </td>
                        <td class="py-2 px-6">
                            <div class="flex justify-center">
                                @include('partials._vertical-options', [
                                'id' => $account->id,
                                'viewRoute' => 'fd-mis-schemes.fd_show',
                                ])
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
    <x-pagination :paginator="$accounts" />
</div>
@endsection