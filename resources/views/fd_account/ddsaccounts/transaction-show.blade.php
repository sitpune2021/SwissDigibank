@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <div class="w-full  overflow-hidden">
                <h3 class="mb-5">
                    <h4 class="mb-4">TRANSACTION - {{ $transaction->id }}</h4>
                </h3>

                <div class="box dark:bg-bg3 border mb-4 border-gray-200  shadow-md rounded-lg  overflow-x-auto p-4">
                    <div class="flex  justify-end gap-3 mb-3">
                        <a class="btn-primary p-1"
                            href="{{ url('/print-documents/transaction-receipt/' . $transaction->dds_account_id . '/' . $transaction->id) }}">
                            <i class="las la-print"></i>
                        </a>
                        <a class=" btn-error p-1" title="Delete" data-confirm="Are you sure to delete transaction?"
                            rel="nofollow" data-method="delete"
                            href="{{ route('dds-accounts.transactions.destroy', [$ddsAccount->id, $transaction->id]) }}">
                            <i class="las la-trash"></i>
                        </a>
                    </div>

                    <table class="w-full whitespace-nowrap text-sm text-left ">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr>
                                <td class="font-semibold px-4 py-2 w-1/3 uppercase">Customer</td>
                                <td class="px-4 py-2 ">

                                    <a href=" {{ route('member.show', $ddsAccount->member->id) }}"
                                        class="text-primary hover:underline ">
                                        {{ $ddsAccount->member->id }} -
                                        {{ $ddsAccount->member->member_info_first_name }}
                                        {{ $ddsAccount->member->member_info_last_name }}
                                    </a>
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">RD/DD No.</td>
                                <td class="px-4 py-2"> {{ $ddsAccount->id }} </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Reference ID</td>
                                <td class="px-4 py-2">{{ $transaction->id }} </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Transaction Date</td>
                                <td class="px-4 py-2">
                                    {{ $transaction->transaction_date
                                        ? \Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y')
                                        : '-' }}
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Transaction Type</td>
                                <td class="px-4 py-2 capitalized">
                                    {{ ucfirst($transaction->type ?? '-') }}
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Amount</td>
                                <td class="px-4 py-2">
                                    {{ $transaction->type === 'debit' ? '-' : '' }}{{ number_format($transaction->amount, 2) }}
                                </td>
                            </tr>

                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase ">Transaction Status</td>
                                <td class="px-4 py-2">
                                    <span class="  {{ $transaction->status === 'approved' ? '' : '' }} ">
                                        {{ ucfirst($transaction->status ?? 'Pending') }}
                                    </span>

                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Payment Mode</td>
                                <td class="px-4 py-2">
                                    {{ ucfirst($transaction->pay_mode ?? '-') }}
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Remarks</td>
                                <td class="px-4 py-2"> {{ $transaction->remarks ?? '-' }}

                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Tranx Receipt</td>
                                <td class="px-4 py-2"> {{ $transaction->tranx_receipt ?? '-' }} </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Is Accounted</td>
                                <td class="px-4 py-2">
                                    @if ($transaction->is_accounted)
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">Yes</span>
                                    @else
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">No</span>
                                    @endif
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Created At</td>
                                <td class="px-4 py-2">
                                    {{ $transaction->created_at?->format('d-m-Y') ?? '-' }}
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Updated At</td>
                                <td class="px-4 py-2">
                                    {{ $transaction->updated_at?->format('d-m-Y') ?? '-' }}
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Branch</td>
                                <td class="px-4 py-2">
                                    {{ $transaction->ddsAccount->branch->branch_name ?? '-' }}
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Entry Created By</td>
                                <td class="px-4 py-2">
                                    {{ $transaction->created_by->name ?? '-' }}
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Entry Collected By</td>
                                <td class="px-4 py-2">
                                    {{ $transaction->collected_by->name ?? '-' }}
                                </td>
                            </tr>

                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Entry Approved By</td>
                                <td class="px-4 py-2">
                                    {{ $transaction->approved_by->name ?? '-' }}
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Approval Date</td>
                                <td class="px-4 py-2">
                                    {{ $transaction->approval_date ? \Carbon\Carbon::parse($transaction->approval_date)->format('d-m-Y') : '-' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            {{-- Do not Remove the Div --}}
            <div class="w-full">
                {{-- Do not Remove the Div --}}
            </div>
        </div>
    @endsection
