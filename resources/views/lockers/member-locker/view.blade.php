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

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6  lg:mb-8">
            <h3 class=" flex text-lg   uppercase  font-bold">
               Member Locker - {{ $locker->locker_no }}
            </h3>
        </div>

        <div class="">
            @if($locker->assigned != 1)
            <a href="{{ route('lockers.locker-list.assign-locker', $locker->id) }}" class="btn-primary rounded-10 py-2 text-sm uppercase">
                Assign
            </a>
            @endif
        </div>

        <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

            <div class=" col-span-2 box md:col-span-1">

                <div class="mb-3 flex justify-end">
                    @if($locker->assigned != 1)
                    <a href="{{ route('lockers.locker-list.edit', $locker->id) }}" class="btn-primary  p-2">
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
                        @if($member)
                            <tr class="border-b">
                                <td class="font-semibold uppercase text-lg text-gray-700 px-4 py-2">Member Name</td>
                                <td class="px-4 py-2 text-gray-600">{{ $member->member_info_first_name }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase text-lg text-gray-700 px-4 py-2">Assigned Date</td>
                                <td class="px-4 py-2 text-gray-600">{{ \Carbon\Carbon::parse($member->assign_date)->format('d-m-Y') }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase text-lg text-gray-700 px-4 py-2">Release Date</td>
                                <td class="px-4 py-2 text-gray-600">{{ \Carbon\Carbon::parse( $member->release_date ?: '—' )->format('d-m-Y') }}</td>
                            </tr>
                        @endif
                        <tr class="border-b">
                            <td class="font-semibold uppercase text-lg text-gray-700 px-4 py-2">Assigned</td>
                            <td class="text-start py-2 px-4">
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
            
        </div>

@endsection