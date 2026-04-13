@extends('layout.main')
@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h4 class="h2">APPROVALS - TRANSACTIONS</h4>
        </div>
        <div class="col-span-12 box lg:col-span-6">
            <x-searchbox />
            <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
                <x-alert />
            </div>
            <div class="pb-4 overflow-x-auto lg:pb-6">
                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead class="custom-thead">
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px]">BRANCH</th>
                            <th class="text-start !py-5 px-6 min-w-[100px]">ASSOCIATE</th>
                            <th class="text-start !py-5 min-w-[100px]">CUSTOMER</th>
                            <th class="text-start !py-5 min-w-[100px]">A/C TYPE</th>
                            <th class="text-start !py-5 min-w-[100px]">A/C NO.</th>
                            <th class="text-start !py-5 min-w-[100px]">TRANS.</th>
                            <th class="text-start !py-5 min-w-[100px]">DATE</th>
                            <th class="text-start !py-5 min-w-[100px]">AMOUNT</th>
                            <th class="text-start !py-5 min-w-[100px]">PAY.<br>MODE</th>
                            <th class="text-start !py-5 min-w-[100px]">BANK<br>A/C</th>
                            <th class="text-start !py-5 min-w-[100px]">CHQ<br>CLEARING<br>DATE</th>
                            <th class="text-start !py-5 min-w-[100px]">PAYMENT<br>REV/REL</th>
                            <th class="text-start !py-5 min-w-[100px]">
                                {{-- ✅ Checkbox LEFT of STATUS text --}}
                                <label class="flex items-center gap-2 cursor-pointer font-semibold whitespace-nowrap">
                                    <input type="checkbox" id="approveAllStatus" class="w-4 h-4">
                                    STATUS
                                </label>
                            </th>
                            <th class="text-start !py-5 min-w-[100px]">REMARKS</th>
                            <th class="text-center !py-5 min-w-[120px]">
                                <span id="actionsHeader">ACTIONS</span>
                                <button type="button" id="doneAllBtn" onclick="submitAllAccounts()"
                                    style="display:none; background-color:green;"
                                    class="text-white font-semibold py-2 px-4 rounded shadow-sm transition duration-200 cursor-pointer">
                                    Done For All
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="transactionTableBody">
                        @forelse ($pending_transactions as $pending_transaction)
                            <tr class="even:bg-secondary/5 dark:even:bg-bg3 transaction-row"
                                data-action="{{ route('pending-transaction.update', $pending_transaction->id) }}"
                                data-source="{{ $pending_transaction->source_table ?? 'transaction' }}"
                                data-payment-mode="{{ strtolower($pending_transaction->payment_mode ?? '') }}"
                                data-id="{{ $pending_transaction->id }}">

                                {{-- Branch --}}
                                <td class="py-5 px-6">{{ $pending_transaction->branch_name ?? '' }}</td>

                                {{-- Associate (empty) --}}
                                <td class="py-5 px-6"></td>

                                {{-- Customer --}}
                                <td class="py-5 px-6">
                                    <a href="{{ $pending_transaction->member_id ? route('member.show', $pending_transaction->member_id) : '#' }}"
                                        class="text-primary underline hover:text-primary/80">
                                        {{ str_pad($pending_transaction->member_id ?? 0, 6, '0', STR_PAD_LEFT) }}
                                    </a>
                                </td>

                                {{-- A/C Type --}}
                                <td class="py-5 px-6">{{ $pending_transaction->transaction_type ?? '' }}</td>

                                {{-- A/C No --}}
                                <td class="py-5 px-6">
                                    <!-- <a href="{{ $pending_transaction->account_no ? route('accounts.show', base64_encode($pending_transaction->account_no)) : '#' }}"
                                        class="text-primary underline hover:text-primary/80">
                                        {{ $pending_transaction->account_no ?? '' }}
                                    </a> -->
                                     
                                        {{ $pending_transaction->account_no ?? '' }}
                                   
                                </td>

                                {{-- View Transaction --}}
                                <td class="py-5 px-6">
                                    <a href="{{ route('transaction.show', base64_encode($pending_transaction->id)) }}"
                                        class="text-primary underline hover:text-primary/80">View</a>
                                </td>

                                {{-- Date --}}
                                <td class="py-5 px-6">
                                    {{ $pending_transaction->created_at ? \Carbon\Carbon::parse($pending_transaction->created_at)->format('d-m-Y') : '' }}
                                </td>

                                {{-- Amount --}}
                                <td class="py-5 px-6">{{ $pending_transaction->amount ?? '' }}</td>

                                {{-- Payment Mode --}}
                                <td class="py-5 px-6">{{ $pending_transaction->payment_mode ?? '' }}</td>

                                {{-- Bank A/C (online only) --}}
                                <td class="py-5 px-6">
                                    @if (strtolower($pending_transaction->payment_mode ?? '') == 'online')
                                        <select class="form-control select-bank-account row-bank-account" required>
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

                                {{-- Cheque Date (cheque only) --}}
                                <td class="py-2 px-6">
                                    @if (strtolower($pending_transaction->payment_mode ?? '') == 'cheque')
                                        <input type="text" class="form-control bg-white width-100 row-cheque-date"
                                            value="{{ $pending_transaction->cheque_date ?? '' }}" readonly>
                                    @else
                                        <span class="text-gray-400 italic"></span>
                                    @endif
                                </td>

                                {{-- Payment Rev/Rel --}}
                                <td class="py-2 px-6">
                                    <select class="form-control width-60 row-payment-status">
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                        <option value="cheque_bounce">Cheque Bounce</option>
                                    </select>
                                </td>

                                {{-- Transaction Status --}}
                                <td class="py-5 px-6">
                                    <select class="form-control width-100 select-transaction-status row-transaction-status">
                                        <option value="pending"
                                            {{ ($pending_transaction->approve_status ?? '') === 'pending' || empty($pending_transaction->approve_status) ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="approved"
                                            {{ ($pending_transaction->approve_status ?? '') === 'approved' ? 'selected' : '' }}>
                                            Approve
                                        </option>
                                        <option value="disapproved"
                                            {{ ($pending_transaction->approve_status ?? '') === 'disapproved' ? 'selected' : '' }}>
                                            Not Approve
                                        </option>
                                    </select>
                                </td>

                                {{-- Remarks --}}
                                <td class="py-2 px-6">
                                    <textarea class="row-remarks form-control" rows="2"
                                        placeholder="Enter Remarks"></textarea>
                                </td>

                                {{-- Done button --}}
                                <td class="py-2 px-6 text-center">
                                    <button type="button" onclick="submitSingleRow(this)"
                                        class="text-white font-semibold py-2 px-4 rounded shadow-sm transition duration-200 cursor-pointer"
                                        style="background-color:green;">
                                        Done
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr id="emptyRow">
                                <td colspan="15" class="text-center py-4 text-gray-500">No record found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <x-pagination :paginator="$pending_transactions" />
    </div>
@endsection

<script>
    // ✅ Approve All checkbox — sets all selects + shows Done For All button
    document.addEventListener("DOMContentLoaded", function () {

        const approveAll    = document.getElementById('approveAllStatus');
        const doneBtn       = document.getElementById('doneAllBtn');
        const actionsHeader = document.getElementById('actionsHeader');

        approveAll.addEventListener('change', function () {
            const selects = document.querySelectorAll('.row-transaction-status');
            selects.forEach(function (select) {
                select.value = approveAll.checked ? 'approved' : 'pending';
            });
            if (approveAll.checked) {
                doneBtn.style.display       = 'inline-block';
                actionsHeader.style.display = 'none';
            } else {
                doneBtn.style.display       = 'none';
                actionsHeader.style.display = 'inline';
            }
        });

    });

    // ✅ Remove row from DOM instantly with smooth animation
    function removeRow(row) {
        row.style.transition = 'opacity 0.3s ease, height 0.3s ease';
        row.style.opacity    = '0';
        row.style.overflow   = 'hidden';
        row.style.height     = row.offsetHeight + 'px';

        requestAnimationFrame(function () {
            row.style.height  = '0';
            row.style.padding = '0';
        });

        setTimeout(function () {
            row.remove();
            // If no rows left — show empty message
            const remaining = document.querySelectorAll('.transaction-row').length;
            if (remaining === 0) {
                const tbody = document.getElementById('transactionTableBody');
                tbody.innerHTML = '<tr><td colspan="15" class="text-center py-4 text-gray-500">No record found.</td></tr>';
            }
        }, 300);
    }

    // ✅ Single row Done — instant remove on success, NO reload
    function submitSingleRow(btn) {

        const row          = btn.closest('tr');
        const statusSelect = row.querySelector('.row-transaction-status');

        if (!statusSelect || statusSelect.value === 'pending') {
            alert('Please select Approve or Not Approve before submitting.');
            return;
        }

        if (!confirm('Are you sure?')) return;

        // Disable immediately to prevent double-click
        btn.disabled              = true;
        btn.textContent           = 'Saving...';
        btn.style.backgroundColor = '#999';
        row.style.opacity         = '0.5';

        submitRowData(row)
            .then(function (response) {
                if (response.ok) {
                    // ✅ Remove row instantly — no reload
                    removeRow(row);
                } else {
                    btn.disabled              = false;
                    btn.textContent           = 'Done';
                    btn.style.backgroundColor = 'green';
                    row.style.opacity         = '1';
                    alert('Something went wrong. Please try again.');
                }
            })
            .catch(function () {
                btn.disabled              = false;
                btn.textContent           = 'Done';
                btn.style.backgroundColor = 'green';
                row.style.opacity         = '1';
                alert('Request failed. Please check your connection.');
            });
    }

    // ✅ Bulk Done For All — each row removes as soon as its own request succeeds
    function submitAllAccounts() {

        const rows   = document.querySelectorAll('.transaction-row');
        let toSubmit = [];

        rows.forEach(function (row) {
            const statusSelect = row.querySelector('.row-transaction-status');
            if (statusSelect && statusSelect.value !== 'pending') {
                toSubmit.push(row);
            }
        });

        if (toSubmit.length === 0) {
            alert('No rows selected. Please select Approve or Not Approve for at least one row.');
            return;
        }

        if (!confirm('Are you sure you want to submit all ' + toSubmit.length + ' selected row(s)?')) return;

        // Disable bulk button + show loading on all rows
        const doneAllBtn       = document.getElementById('doneAllBtn');
        doneAllBtn.disabled    = true;
        doneAllBtn.textContent = 'Processing...';

        toSubmit.forEach(function (row) {
            row.style.opacity = '0.4';
            const btn = row.querySelector('button');
            if (btn) {
                btn.disabled              = true;
                btn.textContent           = 'Saving...';
                btn.style.backgroundColor = '#999';
            }
        });

        // ✅ Promise.allSettled — partial failures don't block successful rows
        Promise.allSettled(
            toSubmit.map(function (row) {
                return submitRowData(row).then(function (response) {
                    return { response, row };
                });
            })
        ).then(function (results) {

            results.forEach(function (result) {
                if (result.status === 'fulfilled' && result.value.response.ok) {
                    // ✅ Remove successful rows instantly
                    removeRow(result.value.row);
                } else {
                    // Restore failed rows so user can retry
                    const row = result.status === 'fulfilled' ? result.value.row : null;
                    if (row) {
                        row.style.opacity = '1';
                        const btn = row.querySelector('button');
                        if (btn) {
                            btn.disabled              = false;
                            btn.textContent           = 'Done';
                            btn.style.backgroundColor = 'green';
                        }
                    }
                }
            });

            doneAllBtn.disabled    = false;
            doneAllBtn.textContent = 'Done For All';
        });
    }

    // ✅ Core fetch — sends all fields controller expects
    function submitRowData(row) {

        const action      = row.dataset.action;
        const source      = row.dataset.source;
        const paymentMode = row.dataset.paymentMode;

        const status      = row.querySelector('.row-transaction-status')?.value  ?? 'pending';
        const remarks     = row.querySelector('.row-remarks')?.value             ?? '';
        const payStatus   = row.querySelector('.row-payment-status')?.value      ?? 'yes';
        const bankAccount = row.querySelector('.row-bank-account')?.value        ?? '';
        const chequeDate  = row.querySelector('.row-cheque-date')?.value         ?? '';

        const formData = new FormData();
        formData.append('_token',              document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('_method',             'PUT');
        formData.append('source_table',        source);
        formData.append('transaction_status',  status);
        formData.append('payment_status',      payStatus);
        formData.append('remarks',             remarks);

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