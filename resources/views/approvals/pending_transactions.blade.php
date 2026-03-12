@extends('layout.main')
@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <!-- <div class="flex items-center gap-2"> -->
            <h4 class="h2">APPROVALS - TRANSACTIONS</h4>
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

                        <tr>
                            <td colspan="14"></td>
                            <td class="py-3 px-6 text-center">

                                <button type="button" id="doneAllBtn" onclick="submitAllAccounts()"
                                    style="display:none;background-color:green;"
                                    class="text-white font-semibold py-2 px-4 rounded shadow-sm transition duration-200 cursor-pointer">

                                    Done For All

                                </button>

                            </td>
                        </tr>
                        @forelse ($pending_transactions as $pending_transaction)
                            <tr class="even:bg-secondary/5 dark:even:bg-bg3 transaction-row"
                                data-action="{{ route('pending-transaction.update', $pending_transaction->id) }}"
                                data-source="{{ $pending_transaction->source_table ?? 'transaction' }}"
                                data-payment-mode="{{ strtolower($pending_transaction->payment_mode ?? '') }}"
                                data-id="{{ $pending_transaction->id }}">

                                {{-- ✅ Branch Name --}}
                                <td class="py-5 px-6">{{ $pending_transaction->branch_name ?? '' }}</td>

                                {{-- Empty Column --}}
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
                                        <select name="bank_account_id_{{ $pending_transaction->id }}"
                                            class="form-control select-bank-account row-bank-account" required>
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
                                        <input type="text" class="form-control bg-white width-100 row-cheque-date"
                                            value="{{ $pending_transaction->cheque_date ?? '' }}" readonly="readonly">
                                    @else
                                        <span class="text-gray-400 italic"></span>
                                    @endif
                                </td>

                                {{-- ✅ Payment Status --}}
                                <td class="py-2 px-6">
                                    <select class="form-control width-60 select-payment-status row-payment-status">
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                        <option value="cheque_bounce">Cheque Bounce</option>
                                    </select>
                                </td>

                                {{-- ✅ Transaction Status --}}
                                <td class="py-5 px-6">
                                    <select class="form-control width-100 select-transaction-status row-transaction-status">
                                        <option value="approved"
                                            {{ ($pending_transaction->approve_status ?? '') === 'approved' ? 'selected' : '' }}>
                                            Approve
                                        </option>
                                        <option value="disapproved"
                                            {{ ($pending_transaction->approve_status ?? '') === 'disapproved' ? 'selected' : '' }}>
                                            Not Approve
                                        </option>
                                        <option value="pending"
                                            {{ ($pending_transaction->approve_status ?? '') === 'pending' || empty($pending_transaction->approve_status) ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                    </select>
                                </td>

                                {{-- ✅ Remarks --}}
                                <td class="py-2 px-6">
                                    <textarea class="row-remarks" placeholder="Enter Remarks"></textarea>
                                </td>

                                {{-- ✅ Submit (single row) --}}
                                <td class="py-2 px-6">
                                    <button type="button" onclick="submitSingleRow(this)"
                                        class="text-white font-semibold py-2 px-4 rounded shadow-sm transition duration-200 cursor-pointer"
                                        style="background-color:green;">
                                        Done
                                    </button>
                                </td>
                            </tr>
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
{{-- Hidden reusable form for all submissions --}}
<form id="sharedForm" method="POST" style="display:none;">
    @csrf
    @method('PUT')
    <input type="hidden" name="source_table" id="sf_source_table">
    <input type="hidden" name="transaction_status" id="sf_transaction_status">
    <input type="hidden" name="payment_status" id="sf_payment_status">
    <input type="hidden" name="remarks" id="sf_remarks">
    <input type="hidden" name="bank_account_id" id="sf_bank_account_id">
    <input type="hidden" name="cheque_clearing_date" id="sf_cheque_clearing_date">
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const approveAll = document.getElementById('approveAllStatus');
        const selects = document.querySelectorAll('.select-transaction-status');
        const doneBtn = document.getElementById('doneAllBtn');

        approveAll.addEventListener('change', function() {
            selects.forEach(function(select) {
                select.value = approveAll.checked ? "approved" : "pending";
            });
            doneBtn.style.display = approveAll.checked ? "inline-block" : "none";
        });
    });

    // ✅ Single row Done button
    function submitSingleRow(btn) {
        if (!confirm('Are you sure?')) return;

        const row = btn.closest('tr');
        submitRowData(row);

        setTimeout(() => location.reload(), 1000);
    }

    // ✅ Bulk Done For All button
    function submitAllAccounts() {
        if (!confirm('Are you sure you want to approve all?')) return;

        const rows = document.querySelectorAll('.transaction-row');
        let promises = [];

        rows.forEach(function(row) {
            const statusSelect = row.querySelector('.row-transaction-status');
            if (statusSelect && statusSelect.value !== 'pending') {
                promises.push(submitRowData(row));
            }
        });

        Promise.all(promises).then(() => location.reload())
            .catch(() => location.reload());
    }

    // ✅ Core function — reads row data and fires fetch
    function submitRowData(row) {
        const action = row.dataset.action;
        const source = row.dataset.source;
        const paymentMode = row.dataset.paymentMode;

        const status = row.querySelector('.row-transaction-status')?.value ?? 'pending';
        const remarks = row.querySelector('.row-remarks')?.value ?? '';
        const payStatus = row.querySelector('.row-payment-status')?.value ?? 'yes';
        const bankAccount = row.querySelector('.row-bank-account')?.value ?? '';
        const chequeDate = row.querySelector('.row-cheque-date')?.value ?? '';

        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('_method', 'PUT');
        formData.append('source_table', source);
        formData.append('transaction_status', status);
        formData.append('payment_status', payStatus);
        formData.append('remarks', remarks);

        if (paymentMode === 'online') {
            formData.append('bank_account_id', bankAccount);
        }
        if (paymentMode === 'cheque') {
            formData.append('cheque_clearing_date', chequeDate);
        }

        return fetch(action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        });
    }
</script>
