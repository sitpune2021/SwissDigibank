@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-2xl font-semibold">Rd - {{ $rdAccount->id }}</h1>
            <p class="text-gray-500">
                <a href="#" class="text-gray-500">Recurring Deposits</a> >
                <a href="{{ route('rd-accounts.show', $rdAccount->id) }}" class="text-gray-500">
                    {{ $rdAccount->id }}
                </a>
                <a href="#" class="text-gray-500">Transactions</a>
            </p>
        </div>
    </div>

    <div class="box     pb-4 overflow-x-auto bg-white lg:pb-6">
        <table class="w-full table-fixed border border-n30 rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-secondary/5 dark:bg-bg3 text-sm font-semibold">
                    <th class="px-6 py-3 text-center">T.DATE</th>
                    <th class="px-6 py-3 text-center">PAY MODE</th>
                    <th class="px-6 py-3 text-center">REMARKS</th>
                    <th class="px-6 py-3 text-center w-40">STATUS</th>
                    <th class="px-6 py-3 text-center">DEBIT</th>
                    <th class="px-6 py-3 text-center">CREDIT</th>
                    <th class="px-6 py-3 text-center">BALANCE</th>
                    <th class="px-6 py-3 text-center">ACCOUNTED</th>
                    <th class="px-6 py-3 text-center">ACTIONS</th>
                </tr>
            </thead>

            <tbody>
                @forelse($rdAccounts as $account)
                <tr class="border-t">
                    <td class="px-6 py-4 text-center">{{ $account->t_date ?\Carbon\Carbon::parse($account->t_date)->format('d-m-Y') : '—'  }}</td>
                    <td class="px-6 py-4 text-center">{{ $account->payment_mode ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-center">—</td>
                    <td class="px-6 py-4 text-center">{{ $account->approve_status ?? '' }}</td>
                    <td class="px-6 py-4 text-center">{{ $account->transaction_type === 'debit' ? number_format($account->amount, 2) : '' }}</td>
                    <td class="px-6 py-4 text-center"> {{ $account->transaction_type === 'credit' ? number_format($account->amount, 2) : '' }}</td>
                    <td class="px-6 py-4 text-center">{{ $account->balance ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-center">
                        @php
                        $accounted = $account->accounted ?? 'no';
                        @endphp
                        @if($accounted === 'yes')
                        <span class="px-3 py-1 text-xs font-semibold text-white bg-green-500 rounded-full">
                            Yes
                        </span>
                        @else
                        <span class="px-3 py-1 text-xs font-semibold text-white bg-red-500 rounded-full">
                            No
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-2">
                        {{-- Actions go here --}}
                        @include('partials._vertical-options', [    
                        'id' => $account->id,
                        'viewRoute' => 'view.transactionSummary',
                        'deleteRoute' => null,
                        ])
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-6 text-center text-gray-500">No transactions found.</td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>


</div>
@endsection