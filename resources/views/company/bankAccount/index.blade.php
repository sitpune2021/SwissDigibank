@extends('layout.main')
@section('page-title', 'Bank Accounts')

@section('action-button')
    <a class="btn-primary" href="{{ route('bank-account.create') }}" style="background: linear-gradient(90deg, #e1d315, #e30f0f) !important; color: black;">
        ADD BANK
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

        <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
            <x-alert />
        </div>

        <div class="overflow-x-auto pb-4 lg:pb-6">

            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">

                <thead class="bg-gray-100 dark:bg-bg3 sticky top-0" style="background-color: bisque;">
                    <tr class="text-gray-700 dark:text-gray-200 text-sm font-semibold uppercase tracking-wider">

                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex uppercase items-center gap-1">
                                BANK NAME
                            </div>
                        </th>

                        <th class="text-start text-center !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex uppercase items-center gap-1 text-center">
                                ACCOUNTING LEDGER
                            </div>
                        </th>

                        <th class="text-start text-center !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex uppercase items-center gap-1 text-center">
                                A/c No.
                            </div>
                        </th>

                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex uppercase items-start gap-1">
                                OPEN DATE
                            </div>
                        </th>

                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex uppercase px-5 items-center gap-1">
                                STATUS
                            </div>
                        </th>

                        <th class="text-center uppercase !py-5" data-sortable="false">
                            ACTION
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($bankAcc as $item)
                        <tr class="table-row dark:even:bg-bg3 border-b hover:bg-gray-50 dark:hover:bg-bg3"
                            style="animation-delay: {{ $loop->index * 0.05 }}s">

                            <td class="py-4 px-6">

                                <div class="flex items-center gap-3">

                                <div class="w-9 h-9 flex items-center justify-center bg-primary/10 rounded-lg">
                                <i class="las la-university text-primary"></i>
                                </div>

                                <div>
                                <p class="font-semibold">
                                {{ $item->bank->name ?? 'N/A' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                Bank Account
                                </p>
                                </div>

                                </div>

                            </td>

                            <td class="py-4 px-6">

                                <div class="flex items-center gap-2 text-gray-700">

                                <!-- <i class="las la-book text-primary"></i> -->

                                <span class="font-medium">
                                {{ $item->bank->name ?? '' }}
                                </span>

                                </div>

                            </td>

                            <td class="py-4 px-6">

                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium">
                                {{ $item->account_no }}
                                </span>

                            </td>

                            <td class="py-3  text-start">
                               <span class="px-6">
                                 {{ \Carbon\Carbon::parse($item->account_open_date)->format('d-m-Y') }}
                               </span>
                            </td>

                            <td class="py-4 px-6 text-center">

                                @if ($item->account_active)

                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                Active
                                </span>

                                @else

                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                Inactive
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

        <div class="mt-4">
            <x-pagination :paginator="$bankAcc"/>
        </div>

    </div>
@endsection
