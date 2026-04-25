@extends('layout.main')
@section('content')
    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-lg   uppercase font-semibold">Collection Centers</h3>
            <a href="{{ route('collection-centers.create') }}" class="btn-primary uppercase">Add</a>
        </div>
        @if(session('success'))
            <div class="">
                <div class="w-44 mb-5 flex justify-end">
                    <x-alert />
                </div>
                {{-- {{ session('success') }} --}}
            </div>
        @endif
        <div class="col-span-12 box lg:col-span-12">
            <div class="pb-4 overflow-x-auto lg:pb-6">

                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">

                    <thead style="background-color: bisque;">
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    BRANCH
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    CENTER NO.
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    CENTER NAME
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    C. HEAD
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    C. CASHIER
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    GROUPS
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    ACTIVE
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    ACTIONS
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($collectionCenters as $center)
                            <tr class="border-b">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">

                                        <!-- Icon -->
                                        <div class="w-9 h-9 flex items-center justify-center 
                                                    bg-gradient-to-r from-blue-100 to-blue-200 
                                                    rounded-lg shadow-sm">
                                            <i class="las la-building text-blue-600"></i>
                                        </div>

                                        <!-- Branch Info -->
                                        <div>
                                            <p class="font-semibold text-gray-800 hover:text-blue-600 transition">
                                                {{ $center->branch->branch_name ?? '-' }}
                                            </p>

                                            <p class="text-xs text-gray-400">
                                                Branch No: {{ $center->branch->id ?? 'N/A' }}
                                            </p>
                                        </div>

                                    </div>
                                </td>
                                <td class="text-center !py-5 px-6">{{ $center->center_no }}</td>
                                <td class="text-center !py-5 px-6">{{ $center->center_name }}</td>
                                <td class="text-center !py-5 px-6">
                                    {{ $center->centerHeadMember->member_info_first_name ?? $center->centerHeadEmployee->name ?? '-' }}
                                </td>
                                <td class="text-center !py-5 px-6">
                                    {{ $center->centerCashierMember->member_info_first_name ?? $center->centerCashierEmployee->name ?? '-' }}
                                </td>
                                <td class="text-center !py-5 px-6">
                                      {{ $center->groups->count() }}  
                                </td>

                                <td class="text-center !py-5 px-6">
                                    @if($center->is_active)
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary">Yes</span>
                                    @else
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error">No</span>
                                    @endif
                                </td>
                                <td class="text-center !py-5 px-6">
                                    <div class="flex items-center gap-1">
                                        <div class="relative">
                                            <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                            <ul class="horiz-option popover-content">
                                                <li>
                                                    <a href="{{ route('collection-centers.show', base64_encode($center->id)) }}"
                                                        class="single-option uppercase">View</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('collection-centers.edit', base64_encode($center->id)) }}"
                                                        class="single-option uppercase">Edit</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>


@endsection