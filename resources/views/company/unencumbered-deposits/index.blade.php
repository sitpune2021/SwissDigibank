@extends('layout.main')

@section('page-title', 'Unencumbered Deposits')

@section('action-button')
    <a class="btn-primary" href="{{ route('unencumbered-deposits.create') }}">
        ADD
    </a>
@endsection

@section('content')
    <div class="box col-span-12 lg:col-span-6">

        <x-searchbox />

        <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6"
            style="flex-direction: row-reverse;">
            <x-alert />
        </div>

        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center uppercase gap-1">
                                BANK NAME
                            </div>
                        </th>

                        <th class="text-start  !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center uppercase gap-1 text-center">
                                FD No.
                            </div>
                        </th>

                        <th class="text-start  uppercase !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 text-center">
                                AMOUNT
                            </div>
                        </th>

                        <th class="text-start !py-5 uppercase px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                OPEN DATE
                            </div>
                        </th>

                        <th class="text-start !py-5 uppercase px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                MATURITY DATE
                            </div>
                        </th>

                        <th class="text-start !py-5 uppercase px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                INTEREST RATE (%)
                            </div>
                        </th>

                        <th class="text-start uppercase !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                FROM DEPOSIT MONEY
                            </div>
                        </th>

                    

                        <th class="text-center uppercase !py-5" data-sortable="false">
                            ACTION
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($deposite as $item)
                        <tr class="border-b dark:border-bg3">

                            {{-- BANK NAME --}}
                            <td class="py-3 px-6">
                                {{ $item->bank->name ?? 'N/A' }}
                            </td>

                            {{-- FD NO --}}
                            <td class="py-3 px-6 ">
                                {{ $item->fd_no }}
                            </td>

                            {{-- AMOUNT --}}
                            <td class="py-3 px-6 text-center">
                                 {{ number_format($item->fd_amount, 2) }}
                            </td>

                            {{-- OPEN DATE --}}
                            <td class="py-3 px-6">
                               <span class="px-1"> {{ \Carbon\Carbon::parse($item->open_date)->format('d-m-Y') }}</span>
                            </td>

                            {{-- MATURITY DATE --}}
                            <td class="py-3 px-6">
                               <span class="px-1"> {{ \Carbon\Carbon::parse($item->maturity_date)->format('d-m-Y') }}</span>
                            </td>

                            {{-- INTEREST RATE --}}
                            <td class="py-3 px-6">
                                <span class="px-1">
                                    {{ $item->annual_interest_rate }}
                                 </span>
                            </td>

                            {{-- FROM DEPOSIT MONEY --}}
                            <td class="py-3 px-6">
                                @if ($item->fd_from_deposit_money)
                                    <span
                                        class="block w-28  rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3">
                                        Yes
                                    </span>
                                @else
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3">
                                        No
                                    </span>
                                @endif
                            </td>

                    

                            {{-- ACTION --}}
                            <td class="py-2 px-6">
                                <div class="flex justify-center">
                                    @include('partials._vertical-options', [
                                        'id' => $item->id,
                                        'viewRoute' => 'unencumbered-deposits.show',
                                        'editRoute' => 'unencumbered-deposits.edit',
                                    ])
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        <x-pagination :paginator="$deposite" />

    </div>
@endsection
