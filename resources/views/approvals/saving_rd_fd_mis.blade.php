@extends('layout.main')
@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <!-- <div class="flex items-center gap-2"> -->
        <h3 class="h2">APPROVALS - SAVING/ FD/ MIS/ RD/ DD</h3>
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
                                MEMBER
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
                            <x-approve-all
                                id="approveAllStatus"
                                class="select-transaction-status"
                                approvedValue="1"
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

                    @foreach ($pending_transactions as $pending_transaction)
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="py-5 px-6">{{ $pending_transaction->branch->branch_name ?? '' }}</td>

                        <td class="py-5 px-6">{{ $pending_transaction->members->member_info_first_name." ".$pending_transaction->members->member_info_last_name  ?? '' }}</td>
                        <td class="py-5 px-6">{{ $pending_transaction->account_type  ?? '' }}</td>
                        <td class="py-5 px-6">
                            @php
                         
                            $url = '#';
                            if ($pending_transaction->account_type === 'FD') {
                            $url = route('fd-mis-schemes.fd_show',$pending_transaction->id);
                            } elseif ($pending_transaction->account_type === 'Saving') {
                            $url = route('accounts.show', base64_encode($pending_transaction->account_id));
                            }
                            @endphp

                            <a href="{{ $url }}" class="text-primary underline hover:text-primary/80">
                                {{ $pending_transaction->account_no ?? 'N/A' }}
                            </a>
                        </td>
                        <td class="py-5 px-6">{{ $pending_transaction->amount_deposit ?? '' }}</td>
                        <td class="py-5 px-6">{{ $pending_transaction->payment_mode  ?? '' }}</td>
                        <td class="py-5 px-6">
                            {{ $pending_transaction->open_date ? \Carbon\Carbon::parse($pending_transaction->open_date)->format('d-m-Y') : '' }}
                        </td>
                        <form method="POST" action="{{ route('transactions.updateAccountStatus', $pending_transaction->id) }}">
                            @csrf
                            <td class="py-5 px-6">
                                <input type="hidden" name="source_table" value="{{ $pending_transaction->source_table }}">
                                <input type="hidden" name="account_id" value="{{ $pending_transaction->id }}">

                                <select name="transaction_status" class="form-control width-100 select-transaction-status">
                                    <option value="1" {{ old('transaction_status') == 'approved' ? 'selected' : '' }}>Approve</option>
                                    <option value="2" {{ old('transaction_status') == 'disapproved' ? 'selected' : '' }}>Not Approve</option>
                                    <option value="pending" selected>Pending</option>
                                </select>
                            </td>
                            <td class="py-5 px-6">
                                <textarea name="remarks" placeholder="Enter Remarks"></textarea>
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