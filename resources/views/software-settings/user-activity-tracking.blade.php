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

    .backdrop {
        backdrop-filter: blur(1px);
        -webkit-backdrop-filter: blur(1px);
        background-color: rgba(0, 0, 0, 0.1);


    }
</style>

@section('content')

<div class="main-inner">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
        <h3 class=" flex text-lg  uppercase font-semibold">
           USER ACTIVITY TRACKING
        </h3>
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
        
        <div class="text-end">
            <a href="#" class="btn-error uppercase text-sm rounded-10 px-2">
                Download xls
            </a>
        </div>

        <div class="pb-4 mt-4 overflow-x-auto lg:pb-6">

            <table class="w-full whitespace-nowrap select-all-table" id="">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer ">
                            <div class="flex items-center gap-1 uppercase">
                                USER NAME
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                              ACTIVITY NAME
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                               ACTIVITY ACTION
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                             IP ADDRESS
                            </div>
                        </th>

                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                             CREATED AT
                            </div>
                        </th>
                       
                    </tr>
                </thead>

                <tbody>
                    @forelse($activities as $activity)
                    <tr class="border-b">

                        <!-- USER NAME -->
                        <td class="px-6 py-4">
                            {{ $activity->user->name ?? 'N/A' }}
                        </td>

                        <!-- ACTIVITY NAME -->
                        <td class="px-6 py-4">
                            {{ $activity->activity_name }}
                        </td>

                        <!-- ACTIVITY ACTION -->
                        <td class="px-6 py-4">
                            {{ $activity->activity_action }}
                        </td>

                        <!-- IP ADDRESS -->
                        <td class="px-6 py-4">
                            {{ $activity->ip_address }}
                        </td>

                        <!-- CREATED AT -->
                        <td class="px-6 py-4">
                            {{ $activity->created_at->format('d-m-Y H:i') }}
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-gray-500">
                            No activity found
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>


    </div>
</div>


@endsection