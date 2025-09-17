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
                                Amount <br>Deposit
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Pay<br> mode
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Date
                            </div>
                        </th>


                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <x-approve-all
                                id="approveAllStatus"
                                class="select-transaction-status"
                                approvedValue="1"
                                pendingValue="0" />
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
                        <td class="py-5 px-6">
                            <a href="{{ $pending_transaction->members ? route('member.show', $pending_transaction->members->id) : '#' }}"
                                class="text-primary underline hover:text-primary/80">
                                {{ optional($pending_transaction->members)->member_info_first_name . ' ' . optional($pending_transaction->members)->member_info_last_name ?? '' }}
                            </a>
                        </td>
                        <td class="py-5 px-6">{{ $pending_transaction->account_type  ?? '' }}</td>
                        <td class="py-5 px-6">
                            <a href="{{ $pending_transaction->id ? route('accounts.show', base64_encode($pending_transaction->id)) : '#' }}"
                                class="text-primary underline hover:text-primary/80">
                                {{ $pending_transaction->account_no ?? 'N/A' }}
                            </a>
                        </td>
                        <td class="py-5 px-6">{{ $pending_transaction->amount_deposit ?? '' }}</td>
                        <td class="py-5 px-6">{{ $pending_transaction->payment_mode  ?? '' }}</td>
                        <td class="py-5 px-6">{{ $pending_transaction->open_date  ?? '' }}</td>
                        <form method="POST" action="{{ route('transactions.updateAccountStatus', $pending_transaction->id) }}">
                            @csrf
                            <td class="py-5 px-6">
                                <input type="hidden" name="account_id" value="{{ $pending_transaction->id }}">
                                <select name="transaction_status" class="form-control width-100 select-transaction-status">
                                    <option value="1" {{ old('transaction_status', $pending_transaction->transaction_status) == 1 ? 'selected' : '' }}>Approve</option>
                                    <option value="2" {{ old('transaction_status', $pending_transaction->transaction_status) == 2 ? 'selected' : '' }}>Not Approve</option>
                                    <option value="0" {{ old('transaction_status', $pending_transaction->transaction_status) == '0' || 
                                    old('transaction_status', $pending_transaction->transaction_status) === null ? 'selected' : '' }}>Pending</option>
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
<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const approveAllCheckbox = document.getElementById('selectAllStatus');
        const allSelects = document.querySelectorAll('.select-transaction-status');

        approveAllCheckbox.addEventListener('change', function() {
            allSelects.forEach(select => {
                if (approveAllCheckbox.checked) {
                    select.value = '1';
                } else {
                    select.value = 'pending';
                }
            });
        });
    });
</script> -->