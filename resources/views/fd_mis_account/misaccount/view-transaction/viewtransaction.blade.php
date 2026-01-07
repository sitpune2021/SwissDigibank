@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-lg uppercase font-semibold">MIS Transactions - {{ $misaccount->mis_account_no }}</h1>
        </div>
    </div>

    <div class="box pb-4 overflow-x-auto bg-white lg:pb-6 rounded-lg shadow">
        <table class="w-full table-fixed border border-n30 whitespace-nowrap rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-secondary/5 dark:bg-bg3  font-semibold">
                    <th class="px-6 py-3 uppercase text-center w-28">T. Date</th>
                    <th class="px-6 py-3 uppercase text-center w-32">Pay Mode</th>
                    <th class="px-6 py-3 uppercase text-center w-40">Remarks</th>
                    <th class="px-6 py-3 uppercase text-center w-32">Status</th>
                    <th class="px-6 py-3 uppercase text-center w-28">Debit</th>
                    <th class="px-6 py-3 uppercase text-center w-28">Credit</th>
                    <th class="px-6 py-3 uppercase text-center w-32">Balance</th>
                    <th class="px-6 py-3 uppercase text-center w-28">Accounted</th>
                    <th class="px-6 py-3 uppercase text-center w-28">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($transactions as $txn)
                <tr class="border-b text-sm">
                    <td class="px-6 py-4 text-center">
                        {{ $txn->transaction_date ? \Carbon\Carbon::parse($txn->transaction_date)->format('d-m-Y') : '—' }}
                    </td>
                    <td class="px-6 py-4 text-center">{{ $txn->	pay_mode ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-center">{{ $txn->remark ?? '—' }}</td>
                    <td class="px-6 py-4 text-center">{{ ucfirst($txn->approve_status ?? 'Pending') }}</td>
                    <td class="px-6 py-4 text-center">
                        ₹{{ $txn->transaction_type === 'debit' ? number_format($txn->amount, 2) : '-' }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        ₹{{ $txn->transaction_type === 'credit' ? number_format($txn->amount, 2) : '-' }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        ₹{{ number_format($txn->balance, 2) }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if(($txn->accounted ?? 'no') === 'yes')
                          <span
                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">Yes</span>
                        @else
                        <span
                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">No</span>
                        @endif
                    </td>
                    <td class="px-6 py-2 text-center">
                         {{-- Actions go here --}}
                        @include('partials._vertical-options', [
                        'id' => $txn->id,
                        'viewRoute'     => 'mis.transaction.view',
                        'printRoute'    => 'mis.print.receipt',
                        'deleteRoute'   => null,
                        ])

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-6 mt-5 text-center text-gray-500">No transactions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
