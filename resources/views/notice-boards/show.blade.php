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
                        Notice Board -{{ $notice_board->id }}
                    </h1>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-2 md:grid-cols-3 gap-6  min-h-screen md-4">
            <div class="col-span-2 md:col-span-1  dark:bg-bg3 rounded-2xl ">

                <div class="box">
                    <div class="text-end">
                        @php
                            $encodedId = base64_encode($notice_board->id);
                        @endphp
                        <a href="{{ route('notice-boards.edit', ['notice_board' => $encodedId]) }}"
                            class="btn-primary p-1"><i class="las la-pencil-alt"></i></a>
                    </div>
                    <div class="whitespace-nowrap overflow-x-auto">
                    <table class="w-full text-lg rounded-md">

                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Branch</th>
                            <td class="px-3 py-2">
                                {{ $notice_board->branch->branch_name }}
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Title</th>
                            <td class="px-3 py-2">
                                {{ $notice_board->notice_title }}
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Body</th>
                            <td class="px-3 py-2">
                                {{ $notice_board->notice_body }}
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Image</th>
                            <td class="px-3 py-2">
                                {{-- <a href="" class="text-secondary ">View</a> --}}
                                
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">App Type</th>
                            <td class="px-3 py-2"> {{ $notice_board->app_type }}</td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Start Date</th>
                            <td class="px-3 py-2"> {{ \Carbon\Carbon::parse($notice_board->start_date)->format('d-m-Y') }}</td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">End Date</th>
                            <td class="px-3 py-2">{{ \Carbon\Carbon::parse($notice_board->end_date)->format('d-m-Y') }}</td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Created By</th>
                            <td class="px-3 py-2"> {{ $notice_board->user ? $notice_board->user->fname . ' ' . $notice_board->user->lname : 'N/A' }}</td>
                        </tr>

                    </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
    </div>






@endsection