@extends('layout.main')
@section('page-title', 'MINORS')
@section('content')

<div class="main-inner">
    <div class="box col-span-12 lg:col-span-6">
        <x-searchbox />
        <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
            <x-alert />
        </div>
        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead style="background-color: bisque;">
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                BRANCH
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                MINOR NAME
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                CUSTOMER NAME
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                ENROLLMENT DATE
                            </div>
                        </th>
                        {{-- <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    STATUS
                                </div>
                            </th> --}}
                        <th class="text-center !py-5" data-sortable="false">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($minors as $index => $minor)
                    <tr class="border-b dark:border-bg3">

                        <td class="px-3 py-3">
                            <div class="flex items-center gap-2">

                                <!-- Branch Icon -->
                                <div class="w-8 h-8 flex items-center justify-center 
                                            bg-blue-100 rounded-lg">
                                    <i class="las la-building text-blue-600 text-sm"></i>
                                </div>

                                <!-- Branch Name -->
                                <span class="text-gray-700 font-medium">
                                    {{ $minor->member->branch->branch_name ?? 'N/A' }}
                                </span>

                            </div>
                        </td>

                        <td class="px-6 py-4">{{ $minor->first_name ?? 'N/A' }}</td>

                        <td class="px-6 py-4">
                            @if ($minor->member)

                            <a href="{{ $minor->member?->id ? route('member.show', $minor->member->id) : '#' }}"
                            class="flex items-center gap-3 hover:bg-gray-50 p-2 rounded-lg transition">

                                <!-- Icon -->
                                <div class="w-9 h-9 flex items-center justify-center 
                                            bg-blue-100 rounded-full">
                                    <i class="las la-user text-blue-600"></i>
                                </div>

                                <!-- ID + Name -->
                                <div class="leading-tight">
                                    
                                    <!-- Name -->
                                    <p class="font-semibold text-primary">
                                        {{ $minor->member->member_info_first_name ?? 'N/A' }}
                                    </p>
                                    <!-- Customer ID -->
                                    <p class="text-xs text-gray-400">
                                        Customer No : {{ $minor->member->member_no 
                                        ?? ($minor->member->id ? str_pad($minor->member->id, 6, '0', STR_PAD_LEFT) : 'N/A') }}
                                    </p>

                                </div>

                            </a>

                            @else
                                N/A
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            {{ $minor->enrollment_date ? \Carbon\Carbon::parse($minor->enrollment_date)->format('d-m-Y') : 'N/A' }}
                        </td>

                        <td class="py-2 px-6">
                            <div class="flex justify-center">
                                @include('partials._vertical-options', [
                                'id' => $minor->id,
                                'viewRoute' => 'minor.show',
                                'editRoute' => 'minor.edit',
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