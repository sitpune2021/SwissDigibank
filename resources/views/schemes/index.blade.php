@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3 px-2 lg:mb-5">
        <h4 class="text-lg uppercase">SCHEMES</h4>
        <a class="btn-primary text-sm" href="{{ route('schemes.create') }}">
            ADD
        </a>
    </div>

    <div class="box col-span-12 lg:col-span-6">
        <x-searchbox />
        <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
            <x-alert />
        </div>
        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full overflow-x-auto whitespace-nowrap select-all-table" id="transactionTable1">
                <thead class="custom-thead uppercase " style="background-color: bisque;">
                    <tr class="bg-secondary/5 dark:bg-bg3">                   
                        <th class="text-start !py-2 px-3">SCHEME NAME</th>
                        <th class="text-start !py-2 px-3">Min Opening Amount</th>
                        <th class="text-start !py-2 px-3">Monthly Min Balance</th>
                        <th class="text-start !py-2 px-3">LOCK IN AMT.</th>
                        <th class="text-start !py-2 px-3">Interest Rate (%)</th>
                        <th class="text-start !py-2 px-3">Interest Payout</th>
                        <th class="text-start !py-2 px-3">ACTIVE</th>
                        <th class="text-center !py-5">ACTION</th>
                <tbody>
                    @foreach ($schemes as $scheme)
                    <tr class="border-b dark:even:bg-bg3">
                        <td class="px-3 py-4">
                            <a href="{{ $scheme?->id ? route('schemes.show', $scheme->id) : '#' }}"
                                class="flex items-center gap-3 hover:bg-gray-50 p-2 rounded-lg transition">

                                <!-- Icon -->
                                <div class="w-9 h-9 flex items-center justify-center 
                                            bg-blue-100 rounded-lg">
                                    <i class="las la-layer-group text-blue-600"></i>
                                </div>

                                <!-- Code + Name -->
                                <div class="leading-tight">                                 

                                    <!-- Scheme Name -->
                                    <p class="font-semibold text-primary">
                                        {{ $scheme->scheme_name }}
                                    </p>

                                     <!-- Scheme Code -->
                                    <p class="text-xs text-gray-400">
                                        Scheme Code : {{ $scheme->scheme_code }}
                                    </p>

                                </div>

                            </a>
                        </td>
                        <td class="py-5 px-3">{{ number_format($scheme->min_opening_balance, 2) }}</td>
                        <td class="py-5 px-3">{{ number_format($scheme->min_monthly_avg_balance, 2) }}</td>
                        <td class="py-5 px-4">{{ number_format($scheme->lock_in_amount, 2) }}</td>
                        <td class="py-5 px-4">{{ $scheme->annual_int_rate }}</td>
                        <td class="py-5 px-4">{{ $scheme->interest_pay_cycle }}</td>
                        <!-- <td class="py-5 px-6">{{ $scheme->active }}</td> -->
                        <td class="py-5 px-3">
                            @if($scheme->active == 1)
                            <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                Yes
                            </span>
                            @else
                            <span
                                class="block w-28 rounded-[30px] border border-n30 bg-error/10 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                No
                            </span>
                            @endif
                        </td>
                        <td class="py-2 px-6">
                            <div class="flex justify-center">
                                @include('partials._vertical-options', [
                                'id' => $scheme->id,
                                'viewRoute' => 'schemes.show',
                                'editRoute' => 'schemes.edit'
                                ])
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <x-pagination :paginator="$schemes" />
</div>
@endsection