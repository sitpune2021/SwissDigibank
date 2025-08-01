@extends('layout.main')
@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <!-- <div class="flex items-center gap-2"> -->
        <h2 class="h2">Approvals - Transactions</h2>
    </div>
    <!-- Latest Transactions -->
    <div class="col-span-12 box lg:col-span-6">
        <x-searchbox />
        <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
            <x-alert />
        </div>
        <div class="pb-4 overflow-x-auto lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead class="custom-thead">
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Branch
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Associate
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Member
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                A/C Type
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                A/C No.
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Trans.
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Date
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Amount
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Pay. Mode
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Bank A/C
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Chq Clearing Date
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex  items-center gap-1">
                                Payment
                                Rev./ Rel.
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Status
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Remarks
                            </div>
                        </th>
                        <th class="text-center !py-5" data-sortable="false">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pending_transactions as $pending_transaction)
                    <form action="{{ route('pending-transaction.update', $pending_transaction->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <td class="py-5 px-6">{{ $pending_transaction->accounts?->branch?->branch_name ?? '' }}</td>
                            <td class="py-5 px-6"></td>
                            <td class="py-5 px-6">
                                <a href="#" class="text-blue-600 hover:text-blue-800 underline">{{ $pending_transaction->accounts?->members?->member_info_first_name ?? ''  }}</a>
                            </td>
                            <td class="py-5 px-6">{{ $pending_transaction?->accounts?->account_type?? '' }}</td>
                            <td class="py-5 px-6">
                                <a href="#" class="text-blue-600 hover:text-blue-800 underline">
                                    {{ $pending_transaction?->accounts?->account_no?? ''  }}
                                </a>
                            </td>
                            <td class="py-5 px-6">
                                <a href="" class="text-blue-600 hover:text-blue-800 underline">View</a>
                            </td>
                            <td class="py-5 px-6">
                                {{ $pending_transaction->transaction_date ? \Carbon\Carbon::parse($pending_transaction->transaction_date)->format('d-m-Y') : '' }}
                            </td>
                            <td class="py-5 px-6">{{ $pending_transaction->amount ?? '' }}</td>
                            <td class="py-5 px-6">{{ $pending_transaction?->payment_mode ?? ''}}</td>
                            <td class="py-5 px-6">
                                @if(strtolower($pending_transaction->payment_mode) == 'online')
                                <select name="bank_account_id" id="bank_account_id" class="form-control select-bank-account" required>
                                    <option value="">Select Bank</option>
                                    <option value="State Bank of India">State Bank of India </option>
                                    <option value="Vijaya Bank">Vijaya Bank</option>
                                    <option value="Kotak Bank">Kotak Bank</option>
                                    <option value="Punjab National Bank">Punjab National Bank</option>
                                    <option value="Fincare Small Finance Bank">Fincare Small Finance Bank</option>
                                    <option value="Karnataka Bank Ltd">Karnataka Bank Ltd</option>
                                    <option value="Central Bank of India">Central Bank of India</option>
                                    <option value="ICICI Bank">ICICI Bank</option>
                                </select>
                                @else
                                <span class="text-gray-400 italic"></span>
                                @endif
                            </td>
                            <td class="py-2 px-6">
                                @if(strtolower($pending_transaction->payment_mode) == 'cheque')
                                <input type="text" name="cheque_clearing_date" value="{{ $pending_transaction?->cheque_date ?? ''}}" class="form-control bg-white width-100" required="required" readonly="readonly">
                                @else
                                <span class="text-gray-400 italic"></span>
                                @endif
                            </td>
                            <td class="py-2 px-6">
                                <select name="payment_status" id="payment_status-3" class="form-control width-60 select-payment-status">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                    <option value="cheque_bounce">Cheque Bounce</option>
                                </select>
                            </td>
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <x-pagination :paginator="$pending_transactions" />
</div>
@endsection