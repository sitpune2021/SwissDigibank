@extends('layout.main')

@section('page-title', 'Bank Accounts')

@section('action-button')
    <a class="btn-primary" href="{{ route('bank-account.create') }}">
        ADD
    </a>
@endsection

@section('content')
    <div class="box col-span-12 lg:col-span-6">

        <x-searchbox />

        <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
            <x-alert />
        </div>

        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                BANK NAME
                            </div>
                        </th>

                        <th class="text-start text-center !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 text-center">
                                ACCOUNTING LEDGER
                            </div>
                        </th>

                        <th class="text-start text-center !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 text-center">
                                A/c No.
                            </div>
                        </th>

                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                OPEN DATE
                            </div>
                        </th>

                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                ACTIVE
                            </div>
                        </th>

                        <th class="text-center !py-5" data-sortable="false">
                            ACTION
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($bankAcc as $item)
                        <tr class="border-b dark:border-bg3">

                            <td class="py-3 px-6">
                                {{ $item->bank->name ?? 'N/A' }}
                            </td>

                            <td class="py-3 px-6 text-center">
                                {{ $item->bank->name ?? '' }}
                            </td>

                            <td class="py-3 px-6 text-center">
                                {{ $item->account_no }}
                            </td>


                            <td class="py-3 px-6">
                                {{ \Carbon\Carbon::parse($item->account_open_date)->format('d-m-Y') }}
                            </td>

                            <td class="py-3 px-6">
                                @if ($item->account_active)
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3">
                                        Yes
                                    </span>
                                @else
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3">
                                        No
                                    </span>
                                @endif
                            </td>



                            <td class="py-2 px-6">
                                <div class="flex justify-center">
                                    @include('partials._vertical-options', [
                                        'id' => $item->id,
                                        'viewRoute' => 'bank-account.show',
                                        'editRoute' => 'bank-account.edit',
                                    ])
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        <x-pagination :paginator="$bankAcc" />

    </div>
@endsection
