@extends('layout.main')

<style>
    .breadcrumb {
        list-style: none;
        display: flex;
        padding: 0;
        margin-bottom: 1rem;
        font-size: 14px;
    }

    .breadcrumb li+li::before {
        content: "/";
        padding: 0 8px;
        color: #888;
    }

    .breadcrumb li a {
        text-decoration: none;
        color: #007bff;
    }

    .breadcrumb li.active {
        color: #555;
    }

    .custom-thead {
        background-color: #e6f4ea;
        color: #14532d;
    }

    .custom-thead th {
        font-weight: 600;
        border-bottom: 1px solid #ccc;
    }

    @media (prefers-color-scheme: dark) {
        .custom-thead {
            background-color: #14532d;
            color: #d1fae5;
        }
    }

    .bg-greens {
        background-color: #14532d;
    }
</style>

@section('content')

    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-xl block  uppercase  font-bold">
                Locker - {{ $locker->locker_no }}
            </h3>
        </div>

        <div class="">
            @if($locker->assigned != 1)
            <a href="{{ route('lockers.locker-list.assign-locker', $locker->id) }}" class="btn-primary rounded-10 py-2 uppercase">
                Assign
            </a>
            @endif
        </div>

        <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

            <div class=" col-span-2 box md:col-span-1">

                <div class="mb-3 flex justify-end">
                    @if($locker->assigned != 1)
                    <a href="{{ route('lockers.locker-list.edit', $locker->id) }}" class="btn-primary rounded-10 p-2">
                        <i class="las la-pencil-alt"></i>
                    </a>
                    @endif
                </div>

                <table class="w-full  divide-y divide-gray-200 rounded-lg">

                    <tbody class="divide-y divide-gray-100">
                        <tr class="border-b">
                            <td class="font-semibold uppercase text-lg text-gray-700 px-4 py-2 w-1/3">Locker No</td>
                            <td class="px-4 py-2 text-gray-600">{{ $locker->locker_no }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold uppercase text-lg text-gray-700 px-4 py-2">Locker Name</td>
                            <td class="px-4 py-2 text-gray-600">{{ $locker->locker_name }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold uppercase text-lg text-gray-700 px-4 py-2">Locker Charge</td>
                            <td class="px-4 py-2 text-gray-600">{{ number_format($locker->monthly_charges, 2) }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold uppercase text-lg text-gray-700 px-4 py-2">Assigned</td>
                            <td class="text-start !py-5 px-6">
                                @if($locker->assigned == 1)
                                    <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary">
                                        Yes
                                    </span>
                                @else
                                    <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error">
                                        No
                                    </span>
                                @endif
                            </td>      
                        </tr>
                    </tbody>

                </table>

            </div>


            <div class=" col-span-2 box md:col-span-1 ">
                <div class="bg-secondary/5 rounded-10  px-5 py-3">
                    <h3 class="text-lg font-semibold tracking-wide">LOCKER HISTORY</h3>
                </div>

                <div class="bg-white dark:bg-gray-900">
                    <div class="overflow-x-auto whitespace-nowrap">

                        <table class="w-full whitespace-nowrap divide-y divide-gray-200 dark:divide-gray-700">
                            
                            <thead class="bg-gray-100 dark:bg-gray-800">
                                <tr class="border-b">
                                    <th class="px-4 py-2 text-start text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase">
                                        Member Name
                                    </th>
                                    <th class="px-4 py-2 text-start text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase">
                                        S/Ac. No
                                    </th>
                                    <th class="px-4 py-2 text-start text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase">
                                        Assigned On
                                    </th>
                                    <th class="px-4 py-2 text-start text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase">
                                        Release Date
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">

                                @php
                                    $memberIds = $locker->member_id ? explode(',', $locker->member_id) : [];
                                    $assignDates = $locker->assign_date ? explode(',', $locker->assign_date) : [];
                                    $releaseDates = $locker->release_date ? explode(',', $locker->release_date) : [];
                                @endphp

                                @foreach($memberIds as $index => $mid)
                                    @php
                                        // YE LINE CHANGE KI — controller se processed object lo
                                        $member = $members[$index] ?? null;

                                        $assignDate = $assignDates[$index] ?? null;
                                        $releaseDate = $releaseDates[$index] ?? null;
                                    @endphp

                                    <tr>
                                        <td>
                                            {{ $member ? $member->member_info_first_name : 'Unknown' }}

                                        </td>

                                        {{-- Account No (ab yahan 100% show hoga) --}}
                                        <td>
                                            {{ $member->account_no ?? '—' }}
                                        </td>

                                        <td>{{ $assignDate ? \Carbon\Carbon::parse($assignDate)->format('d-m-Y') : '—' }}</td>
                                        <td>{{ $releaseDate ? \Carbon\Carbon::parse($releaseDate)->format('d-m-Y') : '—' }}</td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>
                </div>

            </div>
            
        </div>

@endsection