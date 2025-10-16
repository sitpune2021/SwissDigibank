@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3 lg:mb-5">
        <h4 class="h2">SCHEMES</h4>
        <a class="btn-primary" href="{{ route('schemes.create') }}">
            Add
        </a>
    </div>

    <div class="box col-span-12 lg:col-span-6">
        <x-searchbox />
        <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
            <x-alert />
        </div>
        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead class="custom-thead">
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-2 px-3">CODE</th>
                        <th class="text-start !py-2 px-3">SCHEME NAME</th>
                        <th class="text-start !py-2 px-3">MIN. AMT.<br>TO OPEN A/C</th>
                        <th class="text-start !py-2 px-3">MIN.<br> BALANCE/<br>MONTH</th>
                        <th class="text-start !py-2 px-3">LOCK IN AMT.</th>
                        <th class="text-start !py-2 px-3">INTEREST <br>RATE (%)</th>
                        <th class="text-start !py-2 px-3">INTEREST <br>PAYOUT</th>
                        <th class="text-start !py-2 px-3">ACTIVE</th>
                        <th class="text-center !py-5">ACTION</th>
                <tbody>
                    @foreach ($schemes as $scheme)
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="py-5 px-6">
                            <a href="{{ $scheme?->id ? route('schemes.show', $scheme->id) : '#' }}" class="text-primary hover:underline">
                                {{ $scheme->scheme_code }}
                            </a>
                        </td>
                        <td class="py-5 px-6">{{ $scheme->scheme_name }}</td>
                        <td class="py-5 px-6">{{ number_format($scheme->min_opening_balance, 2) }}</td>
                        <td class="py-5 px-6">{{ number_format($scheme->min_monthly_avg_balance, 2) }}</td>
                        <td class="py-5 px-6">{{ number_format($scheme->lock_in_amount, 2) }}</td>
                        <td class="py-5 px-6">{{ $scheme->annual_int_rate }}</td>
                        <td class="py-5 px-6">{{ $scheme->interest_pay_cycle }}</td>
                        <!-- <td class="py-5 px-6">{{ $scheme->active }}</td> -->
                        <td class="py-5 px-6">
                            @if($scheme->active == 1)
                            <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                Yes
                            </span>
                            @else
                            <span
                                class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16">
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