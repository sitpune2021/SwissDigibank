@extends('layout.main')
@section('page-title', 'FD Account Schemes')
@section('action-button')
<a class="btn-primary" href="{{ route('fd-mis-schemes.fd_create') }}">
    <i class=" md:text-lg"></i>
    Add
</a>
@endsection
@section('content')

<div class="box col-span-12 lg:col-span-12">
    <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
        <x-alert />
        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Associate
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Group
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Fd. No
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Member No
                            </div>
                        </th>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Member Name
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Minor
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Branch
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Scheme
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Principal<br>Amt
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Open<br>Date
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Int.<br>Payout
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Maturity<br>Date
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Status
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Active
                            </div>
                        </th>
                        <th class="text-center !py-5" data-sortable="false">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($accounts as $account)

                    <tr>
                        <td class="px-6 py-3">{{ $account->member->associate ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $account->member->group ?? '-' }}</td>
                        <td class="px-6 py-3">
                            <a href="{{route('fd-mis-schemes.fd_show',$account->id)}}" style="color:blue;">{{ "FD-".$account->id }}</a>
                        </td>
                        <td class="px-6 py-3">{{ $account->member->id ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $account->member->member_info_first_name ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $account->minor_id ? 'Yes' : 'No' }}</td>
                        <td class="px-6 py-3">{{ $account->branch->branch_name ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $account->account_type??'-' }}</td>
                        <td class="px-6 py-3">{{ number_format($account->fd_amount, 2) }}</td>
                        <td class="px-6 py-3">{{ $account->open_date??'-' }}</td>
                        <td class="px-6 py-3">{{ $account->interest_payout_type??'-' }}</td>
                        <td class="px-6 py-3">{{ $account->maturity_date ?? '-' }}</td>
                        <td class="px-6 py-3"></td>
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