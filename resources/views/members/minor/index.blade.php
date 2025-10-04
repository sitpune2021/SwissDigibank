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
                <thead>
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
                                CUSTOMER
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                FATHER NAME
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

                        <td class="px-6 py-4">{{ $minor->member->branch->branch_name ?? 'N/A' }}</td>

                        <td class="px-6 py-4">{{ $minor->first_name ?? 'N/A' }}</td>

                        <td class="px-6 py-4">
                            @if ($minor->member)
                            <a href="{{ $minor->member?->id ? route('member.show', $minor->member->id) : '#' }}"
                                class="text-primary hover:underline">
                                {{ $minor->member->member_no 
                                ?? ($minor->member->id ? str_pad($minor->member->id, 6, '0', STR_PAD_LEFT) : 'N/A') }}
                                -
                                {{ $minor->member->member_info_first_name ?? 'N/A' }}
                            </a>
                            @else
                            N/A
                            @endif
                        </td>

                        <td class="px-6 py-4">{{ $minor->father_name ?? 'N/A' }}</td>

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