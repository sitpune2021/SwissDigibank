@extends('layout.main')
@section('content')
    <div class="main-inner">

        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h4 class="h2">APPROVALS - SHARE TRANSFER / ALLOCATION</h4>
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
                            <th class="text-start !py-5 px-6 min-w-[100px]">CUSTOMER</th>
                            <th class="text-start !py-5 min-w-[100px]">A/C TYPE</th>
                            <th class="text-start !py-5 min-w-[100px]">A/C NO</th>
                            <th class="text-start !py-5 min-w-[100px]">AMOUNT<br>DEPOSIT</th>
                            <th class="text-start !py-5 min-w-[100px]">PAY<br>MODE</th>
                            <th class="text-start !py-5 min-w-[100px]">DATE</th>

                            <th class="text-start !py-5 min-w-[100px]">
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

                    <tbody id="shareTableBody">

                        @forelse ($share_transfers as $pending_transaction)
                            <tr class="even:bg-secondary/5 dark:even:bg-bg3 share-row"
                                data-action="{{ route('share_transfer.approve') }}"
                                data-id="{{ $pending_transaction->id }}">

                                {{-- BRANCH --}}
                                <td class="py-5 px-6">
                                    {{ $pending_transaction->shareholdings?->promotor?->branch?->branch_name ?? 'N/A' }}
                                </td>

                                {{-- CUSTOMER --}}
                                <td class="py-5 px-6">
                                    {{ $pending_transaction->members?->member_no ?? '-' }}
                                    - {{ $pending_transaction->members?->member_info_first_name ?? 'N/A' }}
                                </td>

                                {{-- A/C TYPE --}}
                                <td class="py-5 px-6">
                                    {{ $pending_transaction->business_type ?? 'N/A' }}
                                </td>

                                {{-- A/C NO --}}
                                <td class="py-5 px-6">
                                    @if ($pending_transaction->from_share_no)
                                        {{ $pending_transaction->from_share_no }}
                                        @if ($pending_transaction->to_share_no && $pending_transaction->from_share_no != $pending_transaction->to_share_no)
                                            - {{ $pending_transaction->to_share_no }}
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </td>

                                {{-- AMOUNT --}}
                                <td class="py-5 px-6">
                                    {{ $pending_transaction->total_consideration ?? 'N/A' }}
                                </td>

                                {{-- PAY MODE --}}
                                <td class="py-5 px-6">
                                    {{-- {{ $pending_transaction->shares ?? 'N/A' }} --}}
                                </td>

                                {{-- DATE --}}
                                <td class="py-5 px-6">
                                    @if ($pending_transaction->allotment_date)
                                        {{ \Carbon\Carbon::parse($pending_transaction->allotment_date)->format('d-m-Y') }}
                                    @elseif($pending_transaction->created_at)
                                        {{ \Carbon\Carbon::parse($pending_transaction->created_at)->format('d-m-Y') }}
                                    @else
                                        N/A
                                    @endif
                                </td>

                                {{-- STATUS select --}}
                                <td class="py-5 px-6">
                                    <select class="form-control width-100 row-status-select">
                                        <option value="pending" selected>-- Pending --</option>
                                        <option value="approved">Approve</option>
                                        <option value="not approve">Not Approve</option>
                                    </select>
                                </td>

                                {{-- REMARKS --}}
                                <td class="py-5 px-6">
                                    <textarea class="row-remarks form-control" rows="2" placeholder="Enter Remarks"></textarea>
                                </td>

                                {{-- Done button --}}
                                <td class="py-5 px-6 text-center">
                                    <button type="button" onclick="submitSingleRow(this)"
                                        class="text-white font-semibold py-2 px-4 rounded" style="background-color:green;">
                                        Done
                                    </button>
                                </td>

                            </tr>
                        @empty
                            <tr id="emptyRow">
                                <td colspan="10" class="text-center py-4 text-gray-500">No pending records found.</td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        <x-pagination :paginator="$share_transfers" />

    </div>
@endsection

<script>
    // ✅ Approve All checkbox
    document.addEventListener("DOMContentLoaded", function() {

        const approveAll = document.getElementById('approveAllStatus');
        const doneBtn = document.getElementById('doneAllBtn');
        const actionsHeader = document.getElementById('actionsHeader');

        approveAll.addEventListener('change', function() {
            const selects = document.querySelectorAll('.row-status-select');
            selects.forEach(function(select) {
                select.value = approveAll.checked ? "approved" : "pending";
            });
            if (approveAll.checked) {
                doneBtn.style.display = 'inline-block';
                actionsHeader.style.display = 'none';
            } else {
                doneBtn.style.display = 'none';
                actionsHeader.style.display = 'inline';
            }
        });

    });

    // ✅ Remove row from DOM with animation (no page reload)
    function removeRow(row) {
        row.style.transition = 'opacity 0.3s ease, height 0.3s ease';
        row.style.opacity = '0';
        row.style.overflow = 'hidden';

        // Animate height collapse
        row.style.height = row.offsetHeight + 'px';
        requestAnimationFrame(function() {
            row.style.height = '0';
            row.style.padding = '0';
        });

        setTimeout(function() {
            row.remove();
            // If table is now empty, show empty message
            const remaining = document.querySelectorAll('.share-row').length;
            if (remaining === 0) {
                const tbody = document.getElementById('shareTableBody');
                tbody.innerHTML =
                    '<tr><td colspan="10" class="text-center py-4 text-gray-500">No pending records found.</td></tr>';
            }
        }, 300);
    }

    // ✅ Single row Done — removes row instantly on success, no reload
    function submitSingleRow(btn) {

        const row = btn.closest('tr');
        const statusSelect = row.querySelector('.row-status-select');

        if (!statusSelect.value || statusSelect.value === 'pending') {
            alert('Please select Approve or Not Approve before submitting.');
            return;
        }

        if (!confirm('Are you sure?')) return;

        // Disable button immediately to prevent double submit
        btn.disabled = true;
        btn.textContent = 'Saving...';
        btn.style.backgroundColor = '#999';
        row.style.opacity = '0.5';

        submitRowData(row)
            .then(function(response) {
                if (response.ok) {
                    // ✅ Remove row instantly from DOM — no reload needed
                    removeRow(row);
                } else {
                    // Restore on failure
                    btn.disabled = false;
                    btn.textContent = 'Done';
                    btn.style.backgroundColor = 'green';
                    row.style.opacity = '1';
                    alert('Something went wrong. Please try again.');
                }
            })
            .catch(function() {
                btn.disabled = false;
                btn.textContent = 'Done';
                btn.style.backgroundColor = 'green';
                row.style.opacity = '1';
                alert('Request failed. Please check your connection.');
            });
    }

    // ✅ Bulk Done For All — removes each row as its request succeeds
    function submitAllAccounts() {

        const rows = document.querySelectorAll('.share-row');
        let toSubmit = [];

        rows.forEach(function(row) {
            const statusSelect = row.querySelector('.row-status-select');
            if (statusSelect && statusSelect.value !== 'pending') {
                toSubmit.push(row);
            }
        });

        if (toSubmit.length === 0) {
            alert('No rows selected. Please select Approve or Not Approve for at least one row.');
            return;
        }

        if (!confirm('Are you sure you want to submit all ' + toSubmit.length + ' selected row(s)?')) return;

        // Disable bulk button
        const doneAllBtn = document.getElementById('doneAllBtn');
        doneAllBtn.disabled = true;
        doneAllBtn.textContent = 'Processing...';

        // Mark all rows as loading immediately
        toSubmit.forEach(function(row) {
            row.style.opacity = '0.4';
            const btn = row.querySelector('button');
            if (btn) {
                btn.disabled = true;
                btn.textContent = 'Saving...';
                btn.style.backgroundColor = '#999';
            }
        });

        // ✅ Use Promise.allSettled so partial failures don't block successful rows
        Promise.allSettled(toSubmit.map(function(row) {
                return submitRowData(row).then(function(response) {
                    return {
                        response,
                        row
                    };
                });
            }))
            .then(function(results) {

                results.forEach(function(result) {
                    if (result.status === 'fulfilled' && result.value.response.ok) {
                        // ✅ Remove successful row instantly
                        removeRow(result.value.row);
                    } else {
                        // Restore failed rows
                        const row = result.status === 'fulfilled' ?
                            result.value.row :
                            null;
                        if (row) {
                            row.style.opacity = '1';
                            const btn = row.querySelector('button');
                            if (btn) {
                                btn.disabled = false;
                                btn.textContent = 'Done';
                                btn.style.backgroundColor = 'green';
                            }
                        }
                    }
                });

                doneAllBtn.disabled = false;
                doneAllBtn.textContent = 'Done For All';
            });
    }

    // ✅ Core fetch function
    function submitRowData(row) {

        const action = row.dataset.action;
        const id = row.dataset.id;

        const status = row.querySelector('.row-status-select')?.value ?? '';
        const remarks = row.querySelector('.row-remarks')?.value ?? '';

        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('share_transfer_id', id);
        formData.append('status', status);
        formData.append('remarks', remarks);

        return fetch(action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        });
    }
</script>
