@extends('layout.main')
@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <!-- <div class="flex items-center gap-2"> -->
        <h2 class="h2">Approvals - Saving/ FD/ MIS/ RD/ DD</h2>
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
                                A/C No
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Amount Deposit
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Pay mode
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Date
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
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="py-5 px-6">{{ $pending_transaction->branch->branch_name ?? '' }}</td>
                        <td class="py-5 px-6">{{ $pending_transaction->members->member_info_first_name." ".$pending_transaction->members->member_info_last_name  ?? '' }}</td>
                        <td class="py-5 px-6">{{ $pending_transaction->account_type  ?? '' }}</td>
                        <td class="py-5 px-6">{{ $pending_transaction->account_no  ?? '' }}</td>
                        <td class="py-5 px-6">{{ $pending_transaction->amount_deposit ?? '' }}</td>
                        <td class="py-5 px-6">{{ $pending_transaction->payment_mode  ?? '' }}</td>
                        <td class="py-5 px-6">{{ $pending_transaction->open_date  ?? '' }}</td>
                        <form method="POST" action="{{ route('transactions.updateAccountStatus', $pending_transaction->id) }}">
                            @csrf
                            <td class="py-5 px-6">
                                <input type="hidden" name="account_id" value="{{ $pending_transaction->id }}">
                                <select name="transaction_status" class="form-control width-100 select-transaction-status">
                                    <option value="1" {{ old('transaction_status') == 'approved' ? 'selected' : '' }}>Approve</option>
                                    <option value="2" {{ old('transaction_status') == 'disapproved' ? 'selected' : '' }}>Not Approve</option>
                                    <option value="pending" selected>Pending</option>
                                </select>
                            </td>
                            <td class="py-5 px-6">
                                <textarea name="remarks" placeholder="Enter Remarks">{{ old('remarks') }}</textarea>
                            </td>
                            <td class="py-5 px-6">
                                <input type="submit" value="Done"
                                    onclick="return confirm('Are you sure?')"
                                    class="text-white font-semibold py-2 px-4 rounded shadow-sm transition duration-200 cursor-pointer"
                                    style="background-color:green;">
                            </td>
                        </form>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
    <x-pagination :paginator="$pending_transactions" />
</div>
@endsection