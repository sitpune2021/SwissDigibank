@extends('layout.main')
@section('page-title', 'FD Account Schemes')
@section('action-button')
<a class="btn-primary" href="{{ route('fd-mis-schemes.create') }}">
    <i class=" md:text-lg"></i>
    Add
</a>
@endsection
@section('content')
<div class="box col-span-12 lg:col-span-12">
    <x-searchbox />
    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>
    <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Code
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Scheme Name
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Min.<br>Fd Amt
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Tenure
                            </div>
                        </th>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Interest<br>Payout
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Effective<br>Date
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                A. Interest<br>Rate (%)
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Is<br>Chart Type
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Sweep In
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Active
                            </div>
                        </th>
                        <th class="text-center !py-5" data-sortable="false">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fdSchemes as $fdScheme)
                    <tr>
                        <td class="py-5 px-6">{{ $fdScheme->scheme_code?? 'N/A' }}</td>
                        <td class="py-5 px-6">{{ $fdScheme->scheme_name?? 'N/A' }}</td>
                        <td class="py-5 px-6">{{ $fdScheme->min_amount?? 'N/A' }}</td>

                        <td class="py-5 px-6">
                            @forelse($fdScheme->fdslabs as $slab)
                            @php
                            $days = $slab->day_to ?? 0;
                            if ($days >= 365) {
                            $period = floor($days / 365) . ' Year';
                            } elseif ($days >= 30) {
                            $period = floor($days / 30) . ' Months';
                            } else {
                            $period = $days . ' Days';
                            }
                            @endphp
                            {{ $period }} <br>
                            @empty
                            <span class="text-gray-400">No Slabs</span>
                            @endforelse
                        </td>

                        <td class="py-5 px-6 break-words">
                            @forelse($fdScheme->fdslabs as $slab)
                            {{ $slab->payout_type }} <br>
                            @empty
                            <span class="text-gray-400">N/A</span>
                            @endforelse
                        </td>
                        <td class="py-5 px-6">{{ $fdScheme->effective_date 
                             ? \Carbon\Carbon::parse($fdScheme->effective_date)->format('d-m-Y') 
                            : 'N/A' }}</td>

                        <td class="py-5 px-6">
                            @forelse($fdScheme->fdslabs as $slab)
                            {{ $slab->interest_rate ?? 0 }}% <br>
                            @empty
                            <span class="text-gray-400">N/A</span>
                            @endforelse
                        </td>
                        <td class="py-5 px-6">
                            @if($fdScheme->is_active == 1)
                            <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 
                             py-2 text-center text-xs text-primary dark:border-n500 
                             dark:bg-bg3 xxl:w-16">Yes</span>
                            @else
                            <span class="block w-28 rounded-[30px] border border-n30 bg-warning/10 
                             py-2 text-center text-xs text-warning dark:border-n500 
                             dark:bg-bg3 xxl:w-16">No</span>
                            @endif
                        </td>
                        <td class="py-5 px-6">
                            @if($fdScheme->is_active == 1)
                            <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">Yes</span>
                            @else
                            <span class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16">No</span>
                            @endif
                        </td>
                        <td class="py-5 px-6">
                            @if($fdScheme->is_active == 1)
                            <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">Yes</span>
                            @else
                            <span class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16">No</span>
                            @endif
                        </td>
                        <td class="py-2 px-6">
                            <div class="flex justify-center">
                                @include('partials._vertical-options', [
                                'id' => $fdScheme->id,
                                'viewRoute' => 'fd-mis-schemes.show',
                                'editRoute' => 'fd-mis-schemes.edit',
                                ])
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection