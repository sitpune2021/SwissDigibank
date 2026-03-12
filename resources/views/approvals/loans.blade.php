@extends('layout.main')
@section('content')
    <style>
        .custom-thead {
            background-color: #e6f4ea;
            color: #14532d;
        }

        .custom-thead th {
            font-weight: 600;
            border-bottom: 1px solid #ccc;
        }

        @media (prefers-color-scheme: dark) {
            .custom-thead {
                background-color: #14532d;
                color: #d1fae5;
            }
        }

        .bg-greens {
            background-color: #14532d;
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
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">BRANCH</th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">CUSTOMER</th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">A/C TYPE</th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">APPLICATION NO.</th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">AMT. REQUESTED</th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">CALCULATED APPROVAL</th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">APPROVED AMT.</th>

                            {{-- ✅ STATUS column header with Approve All checkbox --}}
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-2">
                                    <label class="flex items-center gap-1 cursor-pointer font-semibold">
                                        <input type="checkbox" id="approveAllLoans" class="w-4 h-4">
                                        Approve All
                                    </label>
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">REMARKS</th>

                            {{-- ✅ Done For All button in header --}}
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <button type="button" id="loanDoneAllBtn" onclick="submitAllLoans()"
                                    style="display:none; background-color:green;"
                                    class="text-white font-semibold py-2 px-4 rounded shadow-sm transition duration-200 cursor-pointer">
                                    Done For All
                                </button>
                                <span id="loanActionsHeader" class="font-semibold">ACTIONS</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applications as $application)
                            <tr class="border-b dark:border-bg3 loan-row"
                                data-action="{{ route('loans.update-status', $application->id) }}"
                                data-model-type="{{ $application->model_type }}">

                                {{-- Branch --}}
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1 uppercase">
                                        {{ $application->branch->branch_name ?? 'N/A' }}
                                    </div>
                                </td>

                                {{-- Customer --}}
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1 Capitalize">
                                        <a href="{{ url('members/member/' . $application->member_id) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $application->member->member_info_first_name ?? 'N/A' }} -
                                            {{ str_pad($application->member_id, 6, '0', STR_PAD_LEFT) }}
                                        </a>
                                    </div>
                                </td>

                                {{-- A/C Type --}}
                                <td class="text-start !py-5 px-6 min-w-[100px]">
                                    <a href="{{ route($routeMap[$application->model_type], $application->id) }}"
                                        class="
                                        @if ($application->model_type === 'loan') text-blue-600
                                        @elseif($application->model_type === 'mortgage') text-green-600
                                        @elseif($application->model_type === 'loan_against') text-orange-600
                                        @elseif($application->model_type === 'business_loan') text-purple-600
                                        @elseif($application->model_type === 'cc_od') text-yellow-600
                                        @elseif($application->model_type === 'daily_weekly') text-green-600
                                        @elseif($application->model_type === 'personal') text-green-600
                                        @elseif($application->model_type === 'vehical') text-green-600
                                        @elseif($application->model_type === 'fixed') text-green-600 @endif
                                        hover:underline cursor-pointer">
                                        {{ $types[$application->model_type] ?? 'Unknown' }}
                                    </a>
                                </td>

                                {{-- Application No --}}
                                <td class="text-start !py-5 px-6 min-w-[100px]">
                                    <a href="{{ route($routeMap[$application->model_type], $application->id) }}"
                                        class="text-blue-600 hover:underline cursor-pointer">
                                        {{ $application->id }}
                                    </a>
                                </td>

                                {{-- Amt Requested --}}
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        @if ($application->model_type == 'daily_weekly')
                                            {{ $application->loan_amount }}
                                        @elseif($application->model_type == 'mortgage')
                                            {{ $application->net_loan_amount }}
                                        @elseif($application->model_type == 'fixed')
                                            {{ $application->loan_amount }}
                                        @else
                                            {{ $application->max_loan_amount }}
                                        @endif
                                    </div>
                                </td>

                                {{-- Calculated Approval --}}
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1 uppercase">
                                        @if ($application->model_type == 'daily_weekly')
                                            {{ $application->loan_amount }}
                                        @elseif($application->model_type == 'personal')
                                            {{ $application->approved_loan_amount }}
                                        @elseif($application->model_type == 'fixed')
                                            {{ $application->total_recovered_amount }}
                                        @else
                                            {{ $application->maximum_approvable_amount }}
                                        @endif
                                    </div>
                                </td>

                                {{-- Approved Amt --}}
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1">
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
                                    </div>
                                </td>

                                {{-- ✅ Status Select (no form wrapping tr) --}}
                                <td class="py-2 px-6">
                                    <select class="border rounded px-2 py-1 row-status-select">
                                        <option value="">Select</option>
                                        <option value="1" {{ $application->status == 1 ? 'selected' : '' }}>Approve
                                        </option>
                                        <option value="0" {{ $application->status == 0 ? 'selected' : '' }}>Not
                                            Approve</option>
                                    </select>
                                </td>

                                {{-- Remarks --}}
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        <textarea class="border py-1 bg-secondary/5 rounded-10 px-3 row-remarks" placeholder="Enter Remarks"></textarea>
                                    </div>
                                </td>

                                {{-- ✅ Done button (single row) --}}
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <button type="button" onclick="submitSingleLoanRow(this)" style="color:white"
                                        class="bg-green-600 text-white px-3 py-1 rounded ml-2">
                                        DONE
                                    </button>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Hidden CSRF token for fetch requests --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const approveAll = document.getElementById('approveAllLoans');
        const doneBtn = document.getElementById('loanDoneAllBtn');
        const actionsHeader = document.getElementById('loanActionsHeader');

        approveAll.addEventListener('change', function() {
            const selects = document.querySelectorAll('.row-status-select');

            selects.forEach(function(select) {
                select.value = approveAll.checked ? "1" : "";
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

    // ✅ Single row DONE button
    function submitSingleLoanRow(btn) {
        if (!confirm('Are you sure?')) return;

        const row = btn.closest('tr');
        const statusSelect = row.querySelector('.row-status-select');

        if (!statusSelect.value) {
            alert('Please select a status first.');
            return;
        }

        submitLoanRowData(row).then(function(response) {
            if (response.ok) {
                // Optionally highlight row as done
                row.style.opacity = '0.5';
                setTimeout(() => location.reload(), 800);
            } else {
                alert('Something went wrong. Please try again.');
            }
        }).catch(function() {
            alert('Request failed. Please try again.');
        });
    }

    // ✅ Bulk Done For All
    function submitAllLoans() {
        if (!confirm('Are you sure you want to approve all selected?')) return;

        const rows = document.querySelectorAll('.loan-row');
        let promises = [];

        rows.forEach(function(row) {
            const statusSelect = row.querySelector('.row-status-select');
            if (statusSelect && statusSelect.value !== '') {
                promises.push(submitLoanRowData(row));
            }
        });

        if (promises.length === 0) {
            alert('No rows selected for approval.');
            return;
        }

        Promise.all(promises)
            .then(() => location.reload())
            .catch(() => location.reload());
    }

    // ✅ Core fetch function for loan rows
    function submitLoanRowData(row) {
        const action = row.dataset.action;
        const modelType = row.dataset.modelType;

        const status = row.querySelector('.row-status-select')?.value ?? '';
        const remarks = row.querySelector('.row-remarks')?.value ?? '';

        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('_method', 'POST'); // updateStatus uses POST not PUT
        formData.append('model_type', modelType);
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
