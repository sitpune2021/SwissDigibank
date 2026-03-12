@extends('layout.main')
@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <!-- <div class="flex items-center gap-2"> -->
            <h4 class="h2">APPROVALS - SAVING/ FD/ MIS/ RD/ DD</h4>
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
                                    A/C NO
                                </div>
                            </th>
                            <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    AMOUNT <br>DEPOSIT
                                </div>
                            </th>
                            <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    PAY<br> MODE
                                </div>
                            </th>
                            <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    DATE
                                </div>
                            </th>


                            <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                                <x-approve-all id="approveAllStatus" class="select-transaction-status" approvedValue="1"
                                    pendingValue="0" />
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
                            <td colspan="9"></td>
                            <td class="py-3 px-6 text-center">
                                <button type="button" id="doneAllBtn" onclick="submitAllAccounts()"
                                    style="display:none;background-color:green;"
                                    class="text-white font-semibold py-2 px-4 rounded shadow-sm transition duration-200 cursor-pointer">
                                    Done For All
                                </button>
                            </td>
                        </tr>

                        @foreach ($pending_transactions as $pending_transaction)
                            <tr class="even:bg-secondary/5 dark:even:bg-bg3">

                                <td class="py-5 px-6">{{ $pending_transaction->branch->branch_name ?? '' }}</td>

                                <td class="py-5 px-6">
                                    {{ $pending_transaction->members?->member_no ?? '-' }}
                                    - {{ $pending_transaction->members->member_info_first_name ?? '' }}
                                </td>

                                <td class="py-5 px-6">{{ $pending_transaction->account_type ?? '' }}</td>

                                <td class="py-5 px-6">{{ $pending_transaction->account_no ?? 'N/A' }}</td>

                                <td class="py-5 px-6">{{ $pending_transaction->amount_deposit ?? '' }}</td>

                                <td class="py-5 px-6">{{ $pending_transaction->payment_mode ?? '' }}</td>

                                <td class="py-5 px-6">
                                    {{ $pending_transaction->open_date ? \Carbon\Carbon::parse($pending_transaction->open_date)->format('d-m-Y') : '' }}
                                </td>

                                <td class="py-5 px-6">

                                    <select name="transaction_status"
                                        class="form-control width-100 select-transaction-status">

                                        <option value="1">Approve</option>
                                        <option value="2">Not Approve</option>
                                        <option value="pending" selected>Pending</option>

                                    </select>

                                </td>

                                <td class="py-5 px-6">
                                    <textarea name="remarks" placeholder="Enter Remarks"></textarea>
                                </td>

                                <td class="py-5 px-6">

                                    <form method="POST"
                                        action="{{ route('transactions.updateAccountStatus', $pending_transaction->id) }}"
                                        class="accountForm">

                                        @csrf

                                        <input type="hidden" name="source_table"
                                            value="{{ $pending_transaction->source_table }}">

                                        <input type="hidden" name="account_id" value="{{ $pending_transaction->id }}">

                                        <input type="hidden" name="transaction_status" class="hidden_status">

                                        <input type="hidden" name="remarks" class="hidden_remarks">

                                        <input type="submit" value="Done" onclick="return confirm('Are you sure?')"
                                            class="text-white font-semibold py-2 px-4 rounded"
                                            style="background-color:green;">

                                    </form>

                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>
        <x-pagination :paginator="$pending_transactions" />
    </div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const approveAll = document.getElementById('approveAllStatus');
        const selects = document.querySelectorAll('.select-transaction-status');
        const doneBtn = document.getElementById('doneAllBtn');

        approveAll.addEventListener('change', function() {

            selects.forEach(function(select) {

                if (approveAll.checked) {
                    select.value = "1"; // approve
                } else {
                    select.value = "pending";
                }

            });

            if (approveAll.checked) {
                doneBtn.style.display = "inline-block";
            } else {
                doneBtn.style.display = "none";
            }

        });

    });
</script>
<script>
    function submitAllAccounts() {

        var rows = document.querySelectorAll('#transactionTable1 tbody tr');

        rows.forEach(function(row) {

            var select = row.querySelector('.select-transaction-status');
            var remarks = row.querySelector('textarea');
            var form = row.querySelector('.accountForm');

            if (select && select.value !== "pending" && form) {

                var formData = new FormData(form);

                formData.set('transaction_status', select.value);
                formData.set('remarks', remarks.value);

                fetch(form.action, {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: formData
                });

            }

        });

        // reload after submitting all
        setTimeout(function() {
            location.reload();
        }, 800);
    }
</script>
