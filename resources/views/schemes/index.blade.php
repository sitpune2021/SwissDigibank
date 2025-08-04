@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3 lg:mb-5">
        <h4 class="h2">Schemes</h4>
        <a class="btn-primary" href="{{ route('schemes.create') }}">
            <i class="text-base md:text-lg"></i>
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
                        <th class="text-start !py-2 px-3">Code</th>
                        <th class="text-start !py-2 px-3">Scheme Name</th>
                        <th class="text-start !py-2 px-3">Min. Amt. To Open A/c</th>
                        <th class="text-start !py-2 px-3">Min. Balance/Month</th>
                        <th class="text-start !py-2 px-3">Lock In Amt.</th>
                        <th class="text-start !py-2 px-3">Interest Rate (%)</th>
                        <th class="text-start !py-2 px-3">Interest Payout</th>
                        <th class="text-start !py-2 px-3">Active</th>
                        <th class="text-center !py-5">Action</th>
                <tbody>
                    @foreach ($schemes as $scheme)
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="py-5 px-6">{{ $scheme->scheme_code }}</td>
                        <td class="py-5 px-6">{{ $scheme->scheme_name }}</td>
                        <td class="py-5 px-6">{{ $scheme->min_opening_balance, 2 }}</td>
                        <td class="py-5 px-6">{{ $scheme->min_monthly_avg_balance, 2 }}</td>
                        <td class="py-5 px-6">{{ $scheme->lock_in_amount, 2 }}</td>
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