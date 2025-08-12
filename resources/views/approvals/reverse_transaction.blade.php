@extends('layout.main')
@section('content')
<div class="main-inner">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
        <h2 class="h2">Approvals - Reverse Transactions</h2>
    </div>

    <!-- Latest Transactions -->
    <div class="col-span-12 box lg:col-span-6">
        DATE - {{ now()->format('d/m/Y H:i') }}
        <div class="pb-4 overflow-x-auto lg:pb-6">
            <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
                <x-alert />
            </div>
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead class="custom-thead">
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Branch
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Member
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                A/C Type
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                A/C No.
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Transaction
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Tran.<br>Date
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Amt.<br>Deposited
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Payment<br>Mode
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Status
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Remarks
                            </div>
                        </th>
                        <th class="text-center justify-center !py-5" data-sortable="false">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                    <form action="{{ route('reverse-transaction.approve', base64_encode($transaction->id)) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <td class="py-5 px-6">{{ $transaction->accounts?->branches?->branch_name ?? '' }}</td>
                            <!-- <td class="py-5 px-6"></td> -->
                            <td class="py-5 px-6">
                                <a href="#" class="text-blue-600 hover:text-blue-800 underline">{{ $transaction->accounts?->members?->member_info_first_name ?? ''  }}</a>
                            </td>
                            <td class="py-5 px-6">{{ $transaction?->accounts?->account_type?? '' }}</td>
                            <td class="py-5 px-6">
                                <a href="#" class="text-blue-600 hover:text-blue-800 underline">
                                    {{ $transaction?->accounts?->account_no?? ''  }}
                                </a>
                            </td>
                            <td class="py-5 px-6">
                                <a href="" class="text-blue-600 hover:text-blue-800 underline">View</a>
                            </td>
                            <td class="py-5 px-6">
                                {{ $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->format('D M d Y') : '' }}
                            </td>
                            <td class="py-5 px-6">{{ $transaction?->accounts?->amount ?? '' }}</td>
                            <td class="py-5 px-6">{{ $transaction?->payment_mode ?? ''}}</td>
                            <td class="py-5 px-6">
                                <select name="transaction_status" id="transaction_status-1" class="form-control width-100 select-transaction-status">
                                    <option value="approved">Approve</option>
                                    <option value="disapproved">Not Approve</option>
                                    <option selected="selected" value="pending">Pending</option>
                                </select>
                            </td>
                            <td class="py-2 px-6">
                                <textarea name="remarks" id="remarks-1" placeholder="Enter Remarks"></textarea>
                            </td>

                            <td class="py-2 px-6">
                                <input
                                    type="submit"
                                    name="commit"
                                    value="Done"
                                    onclick="return confirm('Are you sure')"
                                    class="text-white font-semibold py-2 px-4 rounded shadow-sm transition duration-200 cursor-pointer"
                                    style="background-color:green;">
                            </td>
                        </tr>
                    </form>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-gray-500">No record found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <x-pagination :paginator="$transactions" />
</div>
@endsection