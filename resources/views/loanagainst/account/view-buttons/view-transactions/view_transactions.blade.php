@extends('layout.main')
@section('content')

<style>
    input[type="checkbox"] {
        width: 28px;
        height: 28px;
        accent-color: green;
    }

    input[type="checkbox"]:checked {
        background-color: green;
        border: none;
    }

    input[type="radio"] {
        width: 24px;
        height: 24px;
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

<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-xl font-semibold uppercase dark:text-white">LOAN AGAINST DEPOSITE -  
                <span class="text-gray-500 text-sm">Transactions</span>
            </h1>
        </div>
    </div>

    <div class="">
        <button class="btn-primary rounded-10 capitalize  dark:bg-bg3">
            Re-generate balance in ledger
        </button>
    </div>

    <!-- Filter Form -->
    <div class="w-full max-w-7xl bg-white dark:bg-bg3 mt-4 mx-auto p-4 rounded-lg shadow">
        <form class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <!-- Tranx Id + Remarks -->
            <div class="flex flex-col sm:flex-row gap-6">
                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tranx Id :</label>
                    <input type="text" placeholder="Search Tranx Id"
                        class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3" />
                </div>
                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Remarks :</label>
                    <input type="text" placeholder="Search Remarks"
                        class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3" />
                </div>
            </div>


            <!-- Dates + Amounts -->
            <div class="flex flex-col gap-5 sm:flex-row sm:flex-wrap">
                <!-- Dates Group -->
                <div class="flex flex-col sm:flex-row gap-5 w-full">
                    <div class="w-full sm:w-1/2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Transaction Date
                            From:</label>
                        <input type="text" id="date" placeholder="DD/MM/YYYY"
                            class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3" />
                    </div>
                    <div class="w-full sm:w-1/2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Transaction Date
                            To:</label>
                        <input type="text" id="date2" placeholder="DD/MM/YYYY"
                            class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3" />
                    </div>
                </div>

                <!-- Amount Group -->
                <div class="flex flex-col sm:flex-row gap-5 w-full">
                    <div class="w-full sm:w-1/2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount From
                            :</label>
                        <input type="text" placeholder="From Amount"
                            class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3" />
                    </div>
                    <div class="w-full sm:w-1/2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount To
                            :</label>
                        <input type="text" placeholder="To Amount"
                            class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3" />
                    </div>
                </div>

            </div>


            <!-- Buttons -->
            <div class="col-span-1 sm:col-span-2 md:col-span-3 flex justify-center gap-3 mt-4">
                <button type="submit" class="flex items-center gap-2  btn-primary ">
                    <i class="las la-search"></i>
                    SEARCH
                </button>
                <a href="#" class="flex items-center gap-2  btn-outline ">
                    CLEAR FORM
                </a>
            </div>

        </form>
    </div>

    <!-- Table -->
    <div class="box dark:bg-bg3 mt-5 shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-start text-gray-700 dark:">
                <thead class="bg-secondary/5 text-start text-black uppercase text-lg dark:bg-green-700">
                    <tr>
                        <th class="px-4 py-2 text-start">DATE</th>
                        <th class="px-4 py-2 text-start">PAY MODE</th>
                        <th class="px-4 py-2 text-start">REMARKS</th>
                        <th class="px-4 py-2 text-start">STATUS</th>
                        <th class="px-4 py-2 text-start">DEBIT</th>
                        <th class="px-4 py-2 text-start">CREDIT</th>
                        <th class="px-4 py-2 text-start">BALANCE</th>
                        <th class="px-4 py-2 text-start">ACCOUNTED</th>
                        <th class="px-4 py-2 text-start">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mergedData as $row)
                        <tr>
                            {{-- DATE --}}
                            <td>{{ \Carbon\Carbon::parse($row->date)->format('d/m/Y') }}</td>

                            {{-- PAY MODE --}}
                            <td>{{ $row->fee_mode ?? '-' }}</td>

                            {{-- REMARKS --}}
                            <td>{{ $row->remarks ?? '-' }}</td>

                            {{-- STATUS --}}
                            <td>{{ ucfirst($row->status) }}</td>

                            {{-- DEBIT (Other Charges only) --}}
                            <td>
                                @if($row->type === 'other_charge' || $row->type === 'foreclosure')
                                    {{ number_format($row->amount, 2) }}
                                @else
                                    -
                                @endif
                            </td>

                            {{-- CREDIT (Transactions only) --}}
                            <td>
                                @if($row->type === 'transaction')
                                    {{ number_format($row->amount_collected, 2) }}
                                @else
                                    -
                                @endif
                            </td>

                            {{-- BALANCE (Transactions only) --}}
                            <td>
                               {{ number_format($row->balance, 2) }}
                            </td>

                            {{-- ACCOUNTED --}}
                            <td>
                                <span class="block w-28 rounded-[30px] border bg-primary/20 py-2 text-xs text-primary">-</span>
                            </td>

                            {{-- ACTIONS --}}
                            <td>
                                <i class="las la-ellipsis-v"></i>
                            </td>
                        </tr>
                     @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="mt-5 py-3 px-3 sm:mt-0 text-start">
            <a class="btn btn-warning inline-flex items-center bg-yellow-700 text-white text-sm py-1 px-3 rounded" 
            href="{{route('export.transaction',$account->id)}}">
                <i class="fa fa-download" aria-hidden="true"></i> &nbsp; DOWNLOAD CSV
            </a>
        </div>
    </div>
</div>
@endsection