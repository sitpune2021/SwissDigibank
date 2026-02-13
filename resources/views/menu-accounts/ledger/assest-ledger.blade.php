@extends('layout.main')

@section('content')

<div class="p-4 space-y-6">

    {{-- Breadcrumb --}}
    <div class="uppercase text-lg font-semibold mb-3">
        <a href="{{ route('ledger.index') }}" class="">Asset Ledger</a>
        - {{ $ledger->display_name }}
    </div>

    {{-- Ledger Table --}}
    <div class="box mt-5">

    <div class="w-full  overflow-x-auto rounded-10 shadow bg-white dark:bg-bg3">

                        <table class="w-full whitespace-nowrap text-sm text-left">

                            {{-- HEADER --}}
                            <thead class="bg-gray-100 dark:bg-bg2 sticky top-0 z-10">
                                <tr class="text-sm bg-secondary/5 uppercase tracking-wider text-gray-600 dark:text-gray-300">

                    <th class="px-5 py-3 text-start">CODE</th>
                    <th class="px-5 py-3 text-start">GROUP</th>
                    <th class="px-5 py-3 text-start">NAME</th>
                    <th class="px-5 py-3 text-start">SYSTEM NAME</th>
                    <th class="px-5 py-3 text-start">TYPE</th>
                    <th class="px-5 py-3 text-start">VENDOR</th>
                    <th class="px-5 py-3 text-start">IS SYSTEM</th>
                    <th class="px-5 py-3 text-start">SHOW IN DB</th>
                    <th class="px-5 py-3 text-start">RISK (%)</th>
                    <th class="px-5 py-3 text-start">TOTAL T.</th>
                    <th class="px-5 py-3 text-start">LAST T.	</th>
                    <th class="px-5 py-3 text-start">T. DEBITS</th>
                    <th class="px-5 py-3 text-start">T. CREDITS</th>
                    <th class="px-5 py-3 text-start">( T. DEBITS - T. CREDITS )</th>
                    <th class="px-5 py-3 text-start">CLOSING BALANCE</th>
                </tr>
            </thead>

            <tbody>

                <tr class="border-b hover:bg-gray-50">

                    <td class="px-5 py-3 text-sm">
                        {{ $ledger->code }}
                    </td>

                    <td class="px-5 py-3 ">
                        <span class="px-1 text-sm">
                            {{ $ledger->group->display_name ?? '-' }}
                        </span>
                    </td>

                    <td class="px-5 py-3 text-sm">
                        {{ $ledger->display_name }}
                    </td>

                    <td class="px-5 py-3 text-sm">
                        {{ $ledger->system_name }}
                    </td>

                    <td class="px-5 py-3 text-sm">
                        {{ $ledger->type }}
                    </td>

                    <td class="px-5 py-3 text-sm">
                        -
                    </td>

                    <td class="px-5 py-3 text-sm">
                        -
                    </td>

                    <td class="px-5 py-3 text-sm">
                        -
                    </td>

                    <td class="px-5 py-3 text-sm">
                        %
                    </td>

                    {{-- TOTAL T --}}
                    <td class="px-5 py-3 text-sm ">
                        <span class="px-2">
                            {{ $totalTransactions }}
                        </span>
                    </td>

                    <td class="px-5 py-3 text-sm">
                        {{ $lastTransactionDate ? \Carbon\Carbon::parse($lastTransactionDate)->format('d/m/Y H:i:s') : '-' }}
                    </td>

                    {{-- T DEBITS --}}
                    <td class="px-5 py-3 text-sm text-primary">
                       <span class="">
                         ₹ {{ number_format($totalDebit, 2) }}
                       </span>
                    </td>

                    {{-- T CREDITS --}}
                    <td class="px-5 py-3 text-sm text-error">
                        ₹ {{ number_format($totalCredit, 2) }}
                    </td>

                    {{-- DIFF --}}
                    <td class="px-5 py-3 text-sm">
                        ₹ {{ number_format($difference, 2) }}
                    </td>

                    {{-- CLOSING BALANCE --}}
                    <td class="px-5 py-3 text-sm text-primary">
                        ₹ {{ number_format($closingBalance, 2) }}
                    </td>

                </tr>

            </tbody>

        </table>

    </div>
    </div>

</div>

@endsection
