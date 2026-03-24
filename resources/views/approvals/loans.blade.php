@extends('layout.main')
@section('content')
    <style>
        .custom-thead { background-color: #e6f4ea; color: #14532d; }
        .custom-thead th { font-weight: 600; border-bottom: 1px solid #ccc; }
        @media (prefers-color-scheme: dark) {
            .custom-thead { background-color: #14532d; color: #d1fae5; }
        }
        .bg-greens { background-color: #14532d; }

        /* ✅ Sticky DONE column — correct background for odd/even rows */
        #loanTable thead th.sticky-action {
            background-color: #f0fdf4;
        }
        #loanTable tbody tr td.sticky-action {
            background-color: #ffffff;
        }
        #loanTable tbody tr:nth-child(even) td.sticky-action {
            background-color: #f9fafb;
        }
        @media (prefers-color-scheme: dark) {
            #loanTable thead th.sticky-action { background-color: #14532d; }
            #loanTable tbody tr td.sticky-action { background-color: #1e293b; }
            #loanTable tbody tr:nth-child(even) td.sticky-action { background-color: #0f172a; }
        }
    </style>

    <div class="main-inner">

        <h3>APPROVALS - LOAN APPLICATIONS</h3>

        <div class="col-span-12 box lg:col-span-12">
            <div class="flex justify-end mb-5">
                <a href="{{ route('approvals_history') }}" class="btn-primary uppercase rounded-10">
                    approvals history
                </a>
            </div>

            <div class="pb-4 overflow-x-auto lg:pb-6">
                <table class="w-full whitespace-nowrap select-all-table" id="loanTable">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px]">BRANCH</th>
                            <th class="text-start !py-5 px-6 min-w-[100px]">CUSTOMER</th>
                            <th class="text-start !py-5 px-6 min-w-[100px]">A/C TYPE</th>
                            <th class="text-start !py-5 px-6 min-w-[130px]">APPLICATION NO.</th>
                            <th class="text-start !py-5 px-6 min-w-[100px]">AMT. REQUESTED</th>
                            <th class="text-start !py-5 px-6 min-w-[100px]">CALCULATED APPROVAL</th>
                            <th class="text-start !py-5 px-6 min-w-[100px]">APPROVED AMT.</th>

                            <th class="text-start !py-5 px-6 min-w-[100px]">
                                <label class="flex items-center gap-2 cursor-pointer font-semibold whitespace-nowrap">
                                    <input type="checkbox" id="approveAllLoans" class="w-4 h-4">
                                    STATUS
                                </label>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px]">REMARKS</th>

                            {{-- Sticky right column --}}
                            <th class="">
                                <span id="loanActionsHeader" class="font-semibold">ACTIONS</span>
                                <button type="button" id="loanDoneAllBtn" onclick="submitAllLoans()"
                                    style="display:none; background-color:green;"
                                    class="text-white font-semibold py-2 px-4 rounded shadow-sm cursor-pointer">
                                    Done For All
                                </button>
                            </th>
                        </tr>
                    </thead>

                    <tbody id="loanTableBody">
                        @forelse ($applications as $application)
                            <tr class="border-b dark:border-bg3 loan-row"
                                data-action="{{ route('loans.update-status', $application->id) }}"
                                data-model-type="{{ $application->model_type }}">

                                <td class="text-start !py-5 px-6">
                                    {{ $application->branch->branch_name ?? 'N/A' }}
                                </td>

                                <td class="text-start !py-5 px-6">
                                    <a href="{{ url('members/member/' . $application->member_id) }}"
                                        class="text-blue-600 hover:underline">
                                        {{ $application->member->member_info_first_name ?? 'N/A' }} -
                                        {{ str_pad($application->member_id, 6, '0', STR_PAD_LEFT) }}
                                    </a>
                                </td>

                                <td class="text-start !py-5 px-6">
                                    <a href="{{ route($routeMap[$application->model_type], $application->id) }}"
                                        class="
                                        @if ($application->model_type === 'loan') text-blue-600
                                        @elseif($application->model_type === 'mortgage') text-green-600
                                        @elseif($application->model_type === 'loan_against') text-orange-600
                                        @elseif($application->model_type === 'business_loan') text-purple-600
                                        @elseif($application->model_type === 'cc_od') text-yellow-600
                                        @else text-green-600 @endif
                                        hover:underline cursor-pointer">
                                        {{ $types[$application->model_type] ?? 'Unknown' }}
                                    </a>
                                </td>

                                <td class="text-start !py-5 px-6">
                                    <a href="{{ route($routeMap[$application->model_type], $application->id) }}"
                                        class="text-blue-600 hover:underline">
                                        {{ $application->id }}
                                    </a>
                                </td>

                                <td class="text-start !py-5 px-6">
                                    @if ($application->model_type == 'daily_weekly') {{ $application->loan_amount }}
                                    @elseif($application->model_type == 'mortgage') {{ $application->net_loan_amount }}
                                    @elseif($application->model_type == 'fixed') {{ $application->loan_amount }}
                                    @else {{ $application->max_loan_amount }}
                                    @endif
                                </td>

                                <td class="text-start !py-5 px-6">
                                    @if ($application->model_type == 'daily_weekly') {{ $application->loan_amount }}
                                    @elseif($application->model_type == 'personal') {{ $application->approved_loan_amount }}
                                    @elseif($application->model_type == 'fixed') {{ $application->total_recovered_amount }}
                                    @else {{ $application->maximum_approvable_amount }}
                                    @endif
                                </td>

                                <td class="text-start !py-5 px-6">
                                    @if ($application->model_type == 'daily_weekly')
                                        <input type="number" value="{{ $application->loan_amount }}"
                                            class="py-2 rounded-10 px-3 row-approved-amt">
                                    @elseif($application->model_type == 'fixed')
                                        <input type="number" value="{{ $application->total_recovered_amount }}"
                                            class="py-2 rounded-10 px-3 row-approved-amt">
                                    @else
                                        <input type="number" value="{{ $application->approved_loan_amount }}" readonly
                                            class="border py-2 bg-secondary/5 rounded-10 px-3 row-approved-amt">
                                    @endif
                                </td>

                                <td class="py-2 px-6">
                                    <select class="border rounded px-2 py-1 row-status-select">
                                        <option value="">-- Select --</option>
                                        <option value="1" {{ $application->status == 1 ? 'selected' : '' }}>Approve</option>
                                        <option value="0" {{ $application->status == 0 ? 'selected' : '' }}>Not Approve</option>
                                    </select>
                                </td>

                                <td class="text-start !py-5 px-6">
                                    <textarea class="border py-1 bg-secondary/5 rounded-10 px-3 row-remarks form-control"
                                        placeholder="Enter Remarks" rows="2"></textarea>
                                </td>

                                {{-- ✅ DONE button — NO display:none, always visible, sticky right --}}
                                <td class="text-center !py-5 px-6 sticky right-0 sticky-action"
                                    style="box-shadow: -4px 0 6px rgba(0,0,0,0.06);">
                                    <button type="button" onclick="submitSingleLoanRow(this)"
                                        class="text-white font-semibold py-2 px-4 rounded"
                                        style="background-color:green;">
                                        DONE
                                    </button>
                                </td>

                            </tr>
                        @empty
                            <tr id="loanEmptyRow">
                                <td colspan="10" class="text-center py-4 text-gray-500">No pending loan applications found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const approveAll    = document.getElementById('approveAllLoans');
        const doneBtn       = document.getElementById('loanDoneAllBtn');
        const actionsHeader = document.getElementById('loanActionsHeader');

        approveAll.addEventListener('change', function () {
            document.querySelectorAll('.row-status-select').forEach(function (s) {
                s.value = approveAll.checked ? '1' : '';
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
            if (document.querySelectorAll('.loan-row').length === 0) {
                document.getElementById('loanTableBody').innerHTML =
                    '<tr><td colspan="10" class="text-center py-4 text-gray-500">No pending loan applications found.</td></tr>';
            }
        }, 300);
    }

    function submitSingleLoanRow(btn) {
        const row    = btn.closest('tr');
        const select = row.querySelector('.row-status-select');

        if (!select || select.value === '') {
            alert('Please select Approve or Not Approve first.');
            return;
        }

        if (!confirm('Are you sure?')) return;

        btn.disabled              = true;
        btn.textContent           = 'Saving...';
        btn.style.backgroundColor = '#999';
        row.style.opacity         = '0.5';

        submitLoanRowData(row)
            .then(function (response) {
                if (response.ok || response.redirected) {
                    removeRow(row);
                } else {
                    btn.disabled              = false;
                    btn.textContent           = 'DONE';
                    btn.style.backgroundColor = 'green';
                    row.style.opacity         = '1';
                    alert('Something went wrong. Please try again.');
                }
            })
            .catch(function () {
                btn.disabled              = false;
                btn.textContent           = 'DONE';
                btn.style.backgroundColor = 'green';
                row.style.opacity         = '1';
                alert('Request failed. Please check your connection.');
            });
    }

    function submitAllLoans() {
        const rows   = document.querySelectorAll('.loan-row');
        let toSubmit = [];

        rows.forEach(function (row) {
            const select = row.querySelector('.row-status-select');
            if (select && select.value !== '') toSubmit.push(row);
        });

        if (toSubmit.length === 0) {
            alert('No rows selected. Please select Approve or Not Approve for at least one row.');
            return;
        }

        if (!confirm('Submit all ' + toSubmit.length + ' selected row(s)?')) return;

        const doneAllBtn       = document.getElementById('loanDoneAllBtn');
        doneAllBtn.disabled    = true;
        doneAllBtn.textContent = 'Processing...';

        toSubmit.forEach(function (row) {
            row.style.opacity = '0.4';
            const btn = row.querySelector('button');
            if (btn) { btn.disabled = true; btn.textContent = 'Saving...'; btn.style.backgroundColor = '#999'; }
        });

        Promise.allSettled(
            toSubmit.map(function (row) {
                return submitLoanRowData(row).then(function (response) {
                    return { response, row };
                });
            })
        ).then(function (results) {
            results.forEach(function (result) {
                if (result.status === 'fulfilled' &&
                    (result.value.response.ok || result.value.response.redirected)) {
                    removeRow(result.value.row);
                } else {
                    const row = result.status === 'fulfilled' ? result.value.row : null;
                    if (row) {
                        row.style.opacity = '1';
                        const btn = row.querySelector('button');
                        if (btn) { btn.disabled = false; btn.textContent = 'DONE'; btn.style.backgroundColor = 'green'; }
                    }
                }
            });
            doneAllBtn.disabled    = false;
            doneAllBtn.textContent = 'Done For All';
        });
    }

    function submitLoanRowData(row) {
        const formData = new FormData();
        formData.append('_token',     document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('model_type', row.dataset.modelType);
        formData.append('status',     row.querySelector('.row-status-select')?.value ?? '');
        formData.append('remarks',    row.querySelector('.row-remarks')?.value       ?? '');

        return fetch(row.dataset.action, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
            body: formData
        });
    }
</script>