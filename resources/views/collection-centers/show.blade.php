@extends('layout.main')

@section('content')

    <style>
        input[type="checkbox"] {
            width: 28px;
            height: 28px;
            accent-color: green;
            /* For modern browsers */
        }

        /* Fallback for browsers without accent-color support */
        input[type="checkbox"]:checked {
            background-color: green;
            border: none;
        }

        input[type="radio"] {
            width: 24px;
            height: 24px;
            accent-color: green;
            /* Modern browser support */
        }
    </style>

    <div class="main-inner">

        <div class=" flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col  gap-2">
                <div class="flex items-center gap-3">
                    <h1 class="text-lg font-semibold uppercase">
                        Collection Center - {{ $center->center_no ?? '-' }}
                    </h1>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-2 md:grid-cols-3 gap-6   md-4">
            <div class="col-span-2 md:col-span-1  dark:bg-bg3 rounded-2xl ">
                <div class="box">
                    <div class="text-end">
                        {{-- @php
                        $encodedId = base64_encode($notice_board->id);
                        @endphp --}}
                        <a href="{{ route('collection-centers.edit', base64_encode($center->id)) }}"
                            class="btn-primary p-1"><i class="las la-pencil-alt"></i></a>
                    </div>
                    <div class="whitespace-nowrap overflow-x-auto">
                        <table class="w-full text-lg rounded-md">

                            <tr class="text-start border-b border-gray-200">
                                <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Branch</th>
                                <td class="px-3 py-2">{{ $center->branch->branch_name ?? '-' }}</td>
                            </tr>

                            <tr class="text-start border-b border-gray-200">
                                <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Center No</th>
                                <td class="px-3 py-2">{{ $center->center_no }}</td>
                            </tr>

                            <tr class="text-start border-b border-gray-200">
                                <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Center Name</th>
                                <td class="px-3 py-2">{{ $center->center_name }}</td>
                            </tr>

                            <tr class="text-start border-b border-gray-200">
                                <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Head Name</th>
                                <td class="px-3 py-2">
                                    {{ $center->centerHeadMember->member_info_first_name ?? $center->centerHeadEmployee->name ?? '-' }}
                                </td>
                            </tr>

                            <tr class="text-start border-b border-gray-200">
                                <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Cashier Name</th>
                                <td class="px-3 py-2">
                                    {{ $center->centerCashierMember->member_info_first_name ?? $center->centerCashierEmployee->name ?? '-' }}
                                </td>
                            </tr>

                            <tr class="text-start border-b border-gray-200">
                                <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Collection Day</th>
                                <td class="px-3 py-2">{{ $center->collection_day ?? '-' }}</td>
                            </tr>

                            <tr class="text-start border-b border-gray-200">
                                <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Collection Time</th>
                                <td class="px-3 py-2">{{ $center->collection_time ?? '-' }}</td>
                            </tr>

                            <tr class="text-start border-b border-gray-200">
                                <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Address</th>
                                <td class="px-3 py-2">{{ $center->address ?? '-' }}</td>
                            </tr>

                            <tr class="text-start border-b border-gray-200">
                                <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">GPS Lat/ Log</th>
                                <td class="px-3 py-2">
                                    {{ $center->latitude ?? '-' }} / {{ $center->longitude ?? '-' }} -
                                    <a href="#" class="text-secondary">GO TO MAP</a>
                                </td>
                            </tr>

                            <tr class="text-start border-b border-gray-200">
                                <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Active</th>
                                <td class="px-3 py-2">
                                    <div class="flex items-center gap-1">
                                        @if($center->is_active)
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">Yes</span>
                                        @else
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">No</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                        </table>

                    </div>
                </div>
            </div>

        </div>
        <div class="box mt-5 w-full">
            <div class="pb-4 overflow-x-auto lg:pb-6">
                <table class="w-full whitespace-nowrap select-all-table" id="">

                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    GROUP NAME
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    OPEN DATE
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    STATUS
                                </div>
                            </th>

                        </tr>
                    </thead>

                    <tbody>
                        @forelse($center->groups as $group)
                            <tr class="border-b">
                                <td class="text-left !py-5 px-6">
                                    <a href="#" class="text-primary">{{ $group->group_name }}</a>
                                </td>
                                <td class="text-left !py-5 px-6">
                                    {{ \Carbon\Carbon::parse($group->open_date)->format('d-m-Y') }}
                                </td>
                                <td class="text-left !py-5 px-6">
                                    <div class="flex items-center gap-1">
                                        @if($group->is_active)
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary">Active</span>
                                        @else
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error">Inactive</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5">No groups assigned to this collection center.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    </div>






@endsection