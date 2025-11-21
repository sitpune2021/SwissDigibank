@extends('layout.main')
@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <!-- <div class="flex items-center gap-2"> -->
        <h3 class="h2">APPROVALS - TRANSACTIONS</h3>
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
                                BRANCH
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                ASSOCIATE
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                CUSTOMER
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                A/C TYPE
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                A/C NO.
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                TRANS.
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                DATE
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                AMOUNT
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                PAY.<br> MODE
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                BANK <br>A/C
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                CHQ<br>CLEARING <br>DATE
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex  items-center gap-1">
                                PAYMENT<br>
                                REV/REL
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <x-approve-all id="approveAllStatus" class="select-transaction-status"
                                approvedValue="approved" pendingValue="pending" />

                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                REMARKS
                            </div>
                        </th>
                        <th class="text-center !py-5" data-sortable="false">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pending_transactions as $pending_transaction)
                    <form action="{{ route('pending-transaction.update', $pending_transaction->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="source_table"
                            value="{{ $pending_transaction->source_table ?? 'transaction' }}">
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">

                            {{-- ✅ Branch Name --}}
                            <td class="py-5 px-6">{{ $pending_transaction->branch_name ?? '' }}</td>

                            {{-- Empty Column (if you had one previously) --}}
                            <td class="py-5 px-6"></td>

                            {{-- ✅ Member Info --}}
                            <td class="py-5 px-6">
                                <a href="{{ $pending_transaction->member_id ? route('member.show', $pending_transaction->member_id) : '#' }}"
                                    class="text-primary underline hover:text-primary/80">
                                    {{ str_pad($pending_transaction->member_id ?? 0, 6, '0', STR_PAD_LEFT) }}
                                </a>
                            </td>
                            {{-- ✅ Account Type --}}
                            <td class="py-5 px-6">{{ $pending_transaction->transaction_type ?? '' }}</td>

                            {{-- ✅ Account Number --}}
                            <td class="py-5 px-6">
                                <a href="{{ $pending_transaction->account_no ? route('accounts.show', base64_encode($pending_transaction->account_no)) : '#' }}"
                                    class="text-primary underline hover:text-primary/80">
                                    {{ $pending_transaction->account_no ?? '' }}
                                </a>
                            </td>

                            {{-- ✅ View Transaction --}}
                            <td class="py-5 px-6">
                                <a href="{{ route('transaction.show', base64_encode($pending_transaction->id)) }}"
                                    class="text-primary underline hover:text-primary/80">View</a>
                            </td>

                            {{-- ✅ Transaction Date --}}
                            <td class="py-5 px-6">
                                {{ $pending_transaction->created_at ? \Carbon\Carbon::parse($pending_transaction->created_at)->format('d-m-Y') : '' }}
                            </td>

                            {{-- ✅ Amount --}}
                            <td class="py-5 px-6">{{ $pending_transaction->amount ?? '' }}</td>

                            {{-- ✅ Payment Mode --}}
                            <td class="py-5 px-6">{{ $pending_transaction->payment_mode ?? '' }}</td>

                            {{-- ✅ Bank Name (for online mode) --}}
                            <td class="py-5 px-6">
                                @if (strtolower($pending_transaction->payment_mode ?? '') == 'online')
                                <select name="bank_account_id" id="bank_account_id"
                                    class="form-control select-bank-account" required>
                                    <option value="">Select Bank</option>
                                    <option value="State Bank of India">State Bank of India</option>
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

                            {{-- ✅ Cheque Date (for cheque mode) --}}
                            <td class="py-2 px-6">
                                @if (strtolower($pending_transaction->payment_mode ?? '') == 'cheque')
                                <input type="text" name="cheque_clearing_date"
                                    value="{{ $pending_transaction->cheque_date ?? '' }}"
                                    class="form-control bg-white width-100" readonly="readonly" required="required">
                                @else
                                <span class="text-gray-400 italic"></span>
                                @endif
                            </td>

                            {{-- ✅ Payment Status --}}
                            <td class="py-2 px-6">
                                <select name="payment_status" id="payment_status-{{ $pending_transaction->id }}"
                                    class="form-control width-60 select-payment-status">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                    <option value="cheque_bounce">Cheque Bounce</option>
                                </select>
                            </td>

                            {{-- ✅ Transaction Status --}}
                            <td class="py-5 px-6">
                                <select name="transaction_status"
                                    id="transaction_status-{{ $pending_transaction->id }}"
                                    class="form-control width-100 select-transaction-status">
                                    <option value="approved"
                                        {{ old('transaction_status', $pending_transaction->approve_status) === 'approved' ? 'selected' : '' }}>
                                        Approve
                                    </option>
                                    <option value="disapproved"
                                        {{ old('transaction_status', $pending_transaction->approve_status) === 'disapproved' ? 'selected' : '' }}>
                                        Not Approve
                                    </option>
                                    <option value="pending"
                                        {{ old('transaction_status', $pending_transaction->approve_status) === 'pending' || empty($pending_transaction->approve_status) ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                </select>
                            </td>

                            {{-- ✅ Remarks --}}
                            <td class="py-2 px-6">
                                <textarea name="remarks" id="remarks-{{ $pending_transaction->id }}" placeholder="Enter Remarks"></textarea>
                            </td>

                            {{-- ✅ Submit --}}
                            <td class="py-2 px-6">
                                <input type="submit" name="commit" value="Done"
                                    onclick="return confirm('Are you sure?')"
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
    <x-pagination :paginator="$pending_transactions" />
</div>
@endsection