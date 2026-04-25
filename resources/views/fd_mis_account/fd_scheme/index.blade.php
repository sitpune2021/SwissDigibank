@extends('layout.main')
@section('page-title', 'FD ACCOUNT SCHEMES')
@section('action-button')
<a class="btn-primary" href="{{ route('fd-mis-schemes.create') }}">
    ADD
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
            <table class="w-full whitespace-nowrap overflow-x-auto  select-all-table" id="transactionTable1">
                <thead style="background-color: bisque;">
                    <tr class="bg-secondary/5 dark:bg-bg3">                     
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                SCHEME NAME
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                MIN. FD AMT
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                TENURE
                            </div>
                        </th>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                INTEREST PAYOUT
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                EFFECTIVE DATE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                A. INTEREST RATE (%)
                            </div>
                        </th>                   
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                STATUS
                            </div>
                        </th>
                        <th class="text-center !py-5 px-6 min-w-[100px]" data-sortable="false">
                            <div class="flex items-center gap-1">
                                ACTION
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fdSchemes as $fdScheme)
                    <tr class="border-b">

                        <td class="px-4 py-3">
                            <a href="{{ $fdScheme?->id ? route('fd-mis-schemes.show', $fdScheme->id) : '#' }}"
                            class="flex items-center gap-3 group">

                                <!-- Icon -->
                                <div class="w-9 h-9 flex items-center justify-center bg-blue-100 rounded-full">
                                    <i class="las la-layer-group text-blue-600 text-sm"></i>
                                </div>

                                <!-- Scheme Info -->
                                <div class="leading-tight">
                                            
                                    <!-- Scheme Name -->
                                    <p class="font-semibold text-primary group-hover:text-blue-600 transition">
                                        {{ $fdScheme->scheme_name ?? 'N/A' }}
                                    </p>

                                    <!-- Scheme Code -->
                                    <p class="text-xs text-gray-400">
                                        Scheme Code : {{ $fdScheme->scheme_code ?? 'N/A' }}
                                    </p>

                                </div>

                            </a>
                        </td>

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
                            : 'N/A' }}
                        </td>

                        <td class="py-5 px-6">
                            @forelse($fdScheme->fdslabs as $slab)
                            {{ $slab->interest_rate ?? 0 }}% <br>
                            @empty
                            <span class="text-gray-400">N/A</span>
                            @endforelse
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