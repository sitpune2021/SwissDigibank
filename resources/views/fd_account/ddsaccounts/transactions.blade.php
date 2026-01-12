@extends('layout.main')

<style>
    input[type="checkbox"] {
        width: 24px !important;
        height: 24px !important;
        accent-color: green;
    }

    input[type="checkbox"]:checked {
        background-color: green;
        border: none;
    }

    input[type="radio"] {
        width: 24px !important;
        height: 24px !important;
        accent-color: green;
    }

    .tableWidth {
        width: 90%;
        margin: auto;
    }

    .bg-yellow {
        background-color: #F1BA07;
    }
</style>

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col gap-2">
                <h1 class="text-lg font-semibold dark:text-white">DD - {{ $ddsAccount->id }}</h1>
            </div>
        </div>


        <!-- Filter Form -->
        <div class="w-full max-w-7xl bg-white dark:bg-gray-900 mt-4 mx-auto p-4 rounded-lg shadow">
            <form method="GET" action="{{ route('dds-accounts.transactions', $ddsAccount->id) }}">
                {{-- class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4"> --}}
                <x-searchbox />


            </form>
            {{-- </div> --}}
            <!-- Table -->
            <div class="box dark:bg-gray-900 mt-5 shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700 dark:text-gray-200">
                        <thead class="bg-secondary/5 text-black uppercase text-lg dark:bg-green-700">
                            <tr>
                                <th class="px-4 py-3 text-start">T. DATE</th>
                                <th class="px-4 py-3 text-start">PAY MODE</th>
                                <th class="px-4 py-3 text-start">REMARKS</th>
                                <th class="px-4 py-3 text-start">STATUS</th>
                                <th class="px-4 py-3 text-start">DEBIT</th>
                                <th class="px-4 py-3 text-start">CREDIT</th>
                                <th class="px-4 py-3 text-start">BALANCE</th>
                                <th class="px-4 py-3 text-start">ACCOUNTED</th>
                                <th class="px-4 py-3 text-start">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $tran)
                                <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-800 dark:border-gray-700">
                                    <td class="px-4 py-3">
                                        {{ \Carbon\Carbon::parse($tran->transaction_date)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-4 py-3">{{ ucfirst($tran->pay_mode) }}</td>
                                    <td class="px-4 py-3">{{ $tran->remarks ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="px-2 py-1    {{ $tran->status == 'Approved' ? 'bg-green-500' : 'bg-yellow-500' }}">
                                            {{ $tran->status ?? 'Pending' }}
                                        </span>

                                    </td>

                                    <!-- Debit -->
                                    <td class="px-4 py-3 text-right">
                                        {{ $tran->type === 'debit' ? number_format($tran->amount, 2) : '' }}
                                    </td>

                                    <!-- Credit -->
                                    <td class="px-4 py-3 text-right">
                                        {{ $tran->type === 'credit' ? number_format($tran->amount, 2) : '' }}
                                    </td>

                                    <!-- Balance -->
                                    <td class="px-4 py-3 text-right">
                                        {{ number_format($tran->balance_available, 2) }}
                                    </td>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span
                                            class="px-2 py-1  font-semibold  rounded {{ $tran->accounted ? 'block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16' : 'block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16' }}">
                                            {{ $tran->accounted ? 'Yes' : 'No' }}
                                        </span>
                                    </td>

                                    <td class="py-3 px-6">
                                        <div class="flex justify-center">
                                            @if ($tran->pay_mode !== 'Saving Account' && !$tran->accounted)
                                                @include('partials._vertical-options', [
                                                    'id' => [$ddsAccount->id, $tran->id],
                                                    // 'id' => $tran->id,
                                                    // 'id' => $tran->id, // Only pass the transaction ID
                                                    'viewRoute' => 'dds-accounts.transactions.show',
                                                    'printRoute' => 'dds-accounts.transactions.printReceipt',
                                                    // 'printRoute' => 'dds-accounts.transactions.printReceipt1',
                                                    'deleteRoute' => 'dds-accounts.transactions.destroy',
                                                ])
                                            @else
                                                <span class="text-muted">No Delete Option</span>
                                            @endif
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">No transactions found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer -->
                <div class="mt-5 py-3 px-3 text-start">
                    {{-- <a class="inline-flex items-center btn-error rounded-10 text-sm px-3 py-2"
               href="{{ route('dds-accounts.transactions.export', $ddsAccount->id) }}">
                <i class="fa fa-download mr-1"></i> DOWNLOAD CSV
            </a> --}}
                </div>
            </div>
        </div>
    @endsection
