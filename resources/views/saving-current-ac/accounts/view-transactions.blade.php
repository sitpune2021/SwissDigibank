@extends('layout.main')
@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-start gap-4 lg:mb-8">
        <!-- <div class="flex items-center gap-2"> -->

        <a class="btn btn-primary bg-green-600 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded" href="">
            Deposit Money
        </a>
        <a class="btn-secondary bg-blue-600 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded" href="">
            Withdraw Money
        </a>
        <a class="btn btn-warning bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded" href="">
            Regenerate Balance In Ledger
        </a>
        <!-- </div> -->
    </div>

    <!-- Latest Transactions -->
    <div class="box col-span-12 lg:col-span-6">
        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead class="custom-thead">
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        @php
                        $headers = [
                        "T.Date",
                        "Pay Mode",
                        "Remarks",
                        "Status",
                        "Debit",
                        "Credit",
                        "Balance",
                        "Accounted",
                        "Action"
                        ];
                        @endphp
                        @foreach ($headers as $index => $header)
                        <th class="{{ $header === 'Action' ? 'text-center' : 'text-start' }} py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                {{ $header }}
                            </div>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($Transactions as $index => $Transaction)
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        {{-- Transaction date (transaction_date) --}}
                        <td class="text-start py-5 px-6">{{ $Transaction->accounts->transaction_date ?? '-' }}</td>

                        {{-- payment_mode --}}
                        <td class="text-start py-5 px-6">{{ $Transaction->accounts->payment_mode ?? '-' }}</td>

                        {{-- Remarks --}}
                        <td class="text-start py-5 px-6">-</td>

                        {{-- Status --}}
                        <td class="text-start py-5 px-6">
                            Approved
                        </td>

                        {{--Debit--}}
                        <td class="text-start py-5 px-6">-</td>

                        {{-- Credit --}}
                        <td class="text-start py-5 px-6">{{ $Transaction->account->amount_deposit ?? '-' }}</td>

                        {{-- Balance --}}
                        <td class="text-start py-5 px-6">-</td>

                        {{-- Accounted --}}
                        <td class="text-start py-5 px-6">
                            <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                Yes
                            </span>
                        </td>
                        {{-- Action --}}
                        <td class="text-center py-5 px-6">
                            <div class="flex justify-center">
                                @include('partials._vertical-options', [
                                'id' => base64_encode($Transaction->id),
                                'viewRoute' => 'transaction.show',
                                'printRoute' => 'transaction.print',
                                'deleteRoute' => 'transaction.destroy'
                                ])
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <a class="btn btn-warning inline-flex items-center bg-yellow-700 text-white text-sm py-1 px-3 rounded" href="{{route('export.transaction')}}">
            <i class="fa fa-download" aria-hidden="true"></i> &nbsp; DOWNLOAD CSV
        </a>
    </div>
</div>
@endsection