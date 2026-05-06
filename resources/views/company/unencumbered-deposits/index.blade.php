@extends('layout.main')
@section('page-title', 'Unencumbered Deposits')

@section('action-button')
    <a class="btn-primary" href="{{ route('unencumbered-deposits.create') }}" style="background: linear-gradient(90deg, #e1d315, #e30f0f) !important; color: black;">
        ADD DEPOSIT
    </a>
@endsection

<style>

@keyframes fadeRow{
0%{
opacity:0;
transform:translateY(10px);
}
100%{
opacity:1;
transform:translateY(0);
}
}

.table-row{
animation:fadeRow .4s ease forwards;
}

/* hover animation */

.table-row:hover{
transform:scale(1.01);
box-shadow:0 4px 12px rgba(0,0,0,0.08);
transition:all .25s ease;
}

</style>

@section('content')

    <div class="box col-span-12 lg:col-span-6">

        <x-searchbox />

        <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6"
            style="flex-direction: row-reverse;">
            <x-alert />
        </div>

        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                
                <thead class="bg-gray-100 dark:bg-bg3 sticky top-0" style="background-color: bisque;">
                    <tr class="text-gray-700 dark:text-gray-200 text-sm font-semibold uppercase tracking-wider">

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
                        <tr class="table-row dark:even:bg-bg3 border-b hover:bg-gray-50 dark:hover:bg-bg3"
                            style="animation-delay: {{ $loop->index * 0.05 }}s">

                            {{-- BANK NAME --}}
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">

                                    <div class="w-9 h-9 flex items-center justify-center bg-blue-100 rounded-full">
                                        <i class="las la-university text-blue-600"></i>
                                    </div>

                                    <span class="font-semibold text-gray-800">
                                        {{ $item->bank->name ?? 'N/A' }}
                                    </span>

                                </div>
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

        <div class="mt-4">
            <x-pagination :paginator="$deposite"/>
        </div>

    </div>
@endsection
