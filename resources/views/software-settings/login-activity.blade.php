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
            LOGIN ACTIVITY
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
        {{-- <div class="text-end">
            <a href="#" class="btn-error uppercase text-sm rounded-10 px-2">
                Download xls
            </a>
        </div> --}}

        <div class="pb-4 mt-4 overflow-x-auto lg:pb-6">

            <table class="w-full whitespace-nowrap select-all-table" id="">

                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer ">
                            <div class="flex items-center gap-1 uppercase">
                                IDENTITY
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                USER
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                REFERRER
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                               FAILURE REASON
                            </div>
                        </th>

                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                IP ADDRESS
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                SUCCESS
                            </div>
                        </th>
                         <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                LOGIN TIME
                            </div>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($logs as $log)
                    <tr class="border-b">
                        
                        <!-- IDENTITY (Email) -->
                        <td class="px-6 py-4">
                            {{ $log->user->email ?? 'N/A' }}
                        </td>

                        <!-- USER NAME -->
                        <td class="px-6 py-4">
                            {{ $log->user->name ?? 'N/A' }}
                        </td>

                        <!-- REFERRER -->
                        <td class="px-6 py-4">
                            {{ request()->headers->get('referer') ?? '-' }}
                        </td>

                        <!-- FAILURE REASON -->
                        <td class="px-6 py-4">
                            {{ $log->failure_reason ?? '-' }}
                        </td>

                        <!-- IP ADDRESS -->
                        <td class="px-6 py-4">
                            {{ $log->ip_address }}
                        </td>

                        <!-- SUCCESS -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                @if($log->success)
                                    <span class="block w-20 rounded-[30px] border border-green-300 bg-green-100 py-2 text-center text-xs text-green-600">
                                        Yes
                                    </span>
                                @else
                                    <span class="block w-20 rounded-[30px] border border-red-300 bg-red-100 py-2 text-center text-xs text-red-600">
                                        No
                                    </span>
                                @endif
                            </div>
                        </td>

                        <!-- LOGIN TIME -->
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($log->login_at)->format('d-m-Y H:i') }}
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-gray-500">
                            No login activity found
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>


    </div>
</div>


@endsection