@extends('layout.main')
@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-start gap-4 lg:mb-8">
        <!-- <div class="flex items-center gap-2"> -->

        <a class=" btn-primary  font-semibold py-2 px-4 rounded-10 uppercase text-sm" href="{{route('deposit.create',base64_encode($account->id))}}">
            Deposit Money
        </a>
        <a class="btn-secondary  font-semibold py-2 px-4 rounded-10 uppercase text-sm" href="{{route('withdraw.create',base64_encode($account->id))}}">
            Withdraw Money
        </a>
        <a class="btn-warning  font-semibold py-2 px-4 rounded-10 uppercase text-sm" href="">
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
                        "T.DATE",
                        "PAY MODE",
                        "REMARKS",
                        "STATUS",
                        "DEBIT",
                        "CREDIT",
                        "BALANCE",
                        "ACCOUNTED",
                        "ACTION"
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
                    <tr class=border-b dark:even:bg-bg3">
                        {{-- Transaction date --}}
                        <td class="text-start py-5 px-6">
                            {{ $Transaction->date ? \Carbon\Carbon::parse($Transaction->date)->format('d-m-Y') : '-' }}
                        </td>

                        {{-- Payment mode --}}
                        <td class="text-start py-5 px-6 capitalize">
                            {{ $Transaction->source_type === 'TRANSACTION' ? ($Transaction->payment_mode ?? '-') : 'System' }}
                        </td>

                        {{-- Remarks --}}
                        <td class="text-start py-5 px-6">{{ $Transaction->remarks ?? '-' }}</td>

                        {{-- Status --}}
                        <td class="text-start py-5 px-6">{{ $Transaction->status ?? '-' }}</td>

                        {{-- Debit --}}
                        <td class="text-start py-5 px-6">
                         
                            {{ $Transaction->source_type === 'TRANSACTION' && ($Transaction->transaction_type ?? '') === 'debit' ? $Transaction->amount : '-' }}
                        </td>

                        {{-- Credit --}}

                        <td class="text-start py-5 px-6">
                            {{ $Transaction->source_type === 'TRANSACTION' && ($Transaction->transaction_type ?? '') === 'credit' ? $Transaction->amount : '-' }}
                        </td>

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
        <a class=" btn-warning text-sm rounded-10 py-2  px-2" href="{{route('export.transaction',$account->id)}}">
            <i class="las la-download" aria-hidden="true"></i> &nbsp; DOWNLOAD CSV
        </a>
    </div>
</div>
@endsection