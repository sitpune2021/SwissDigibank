@extends('layout.main')

@section('content')

<div class="p-4 space-y-6">

    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-500">
        <a href="{{ route('ledger.index') }}" class="text-indigo-600 hover:underline">Asset Ledger</a>
        - {{ $ledger->display_name }}
    </div>

    {{-- Ledger Table --}}
    <div class="bg-white shadow rounded-2xl overflow-x-auto">

        <table class="min-w-full text-sm whitespace-nowrap">

            <thead class="bg-gray-100 uppercase text-xs text-gray-600">
                <tr>
                    <th class="px-5 py-3 text-left">CODE</th>
                    <th class="px-5 py-3 text-left">GROUP</th>
                    <th class="px-5 py-3 text-left">NAME</th>
                    <th class="px-5 py-3 text-left">SYSTEM NAME</th>
                    <th class="px-5 py-3 text-left">TYPE</th>
                    <th class="px-5 py-3 text-left">VENDOR</th>
                    <th class="px-5 py-3 text-left">IS SYSTEM</th>
                    <th class="px-5 py-3 text-left">SHOW IN DB</th>
                    <th class="px-5 py-3 text-left">RISK (%)</th>
                    <th class="px-5 py-3 text-left">TOTAL T.</th>
                    <th class="px-5 py-3 text-left">LAST T.	</th>
                    <th class="px-5 py-3 text-left">T. DEBITS</th>
                    <th class="px-5 py-3 text-left">T. CREDITS</th>
                    <th class="px-5 py-3 text-left">( T. DEBITS - T. CREDITS )</th>
                    <th class="px-5 py-3 text-right">CLOSING BALANCE</th>
                </tr>
            </thead>

            <tbody>

                <tr class="border-t hover:bg-gray-50">

                    <td class="px-5 py-3 font-semibold">
                        {{ $ledger->code }}
                    </td>

                    <td class="px-5 py-3">
                        {{ $ledger->group->display_name ?? '-' }}
                    </td>

                    <td class="px-5 py-3 font-medium text-indigo-600">
                        {{ $ledger->display_name }}
                    </td>

                    <td class="px-5 py-3">
                        {{ $ledger->system_name }}
                    </td>

                    <td class="px-5 py-3">
                        {{ $ledger->type }}
                    </td>

                    <td class="px-5 py-3">
                        -
                    </td>

                    <td class="px-5 py-3">
                        -
                    </td>

                    <td class="px-5 py-3">
                        -
                    </td>

                    <td class="px-5 py-3">
                        %
                    </td>

                    {{-- TOTAL T --}}
                    <td class="px-5 py-3 text-center font-bold text-blue-600">
                        {{ $totalTransactions }}
                    </td>

                    <td class="px-5 py-3 text-center font-medium text-gray-700">
                        {{ $lastTransactionDate ? \Carbon\Carbon::parse($lastTransactionDate)->format('d/m/Y H:i:s') : '-' }}
                    </td>

                    {{-- T DEBITS --}}
                    <td class="px-5 py-3 text-right font-semibold text-green-600">
                        ₹ {{ number_format($totalDebit, 2) }}
                    </td>

                    {{-- T CREDITS --}}
                    <td class="px-5 py-3 text-right font-semibold text-red-600">
                        ₹ {{ number_format($totalCredit, 2) }}
                    </td>

                    {{-- DIFF --}}
                    <td class="px-5 py-3 text-right font-bold text-purple-600">
                        ₹ {{ number_format($difference, 2) }}
                    </td>

                    {{-- CLOSING BALANCE --}}
                    <td class="px-5 py-3 text-right font-bold text-green-600">
                        ₹ {{ number_format($closingBalance, 2) }}
                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection
