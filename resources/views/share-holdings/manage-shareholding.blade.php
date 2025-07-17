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
        /* Light green background */
        color: #14532d;
        /* Dark green text */
    }

    .custom-thead th {
        font-weight: 600;
        border-bottom: 1px solid #ccc;
    }

    /* Optional: Dark mode */
    @media (prefers-color-scheme: dark) {
        .custom-thead {
            background-color: #14532d;
            /* dark green */
            color: #d1fae5;
            /* light text */
        }
    }
</style>
@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <!-- <h2 class="h2"> -->
        <div class="flex items-center gap-2">
            <h1 class="text-xl font-semibold">Promoters Share Holding Details</h1>
            <a href="{{ route('create.shareholding') }}"
                class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white hover:bg-green-700">
                <i class="las la-plus text-lg"></i>
            </a>
            <!-- <ol class="breadcrumb flex text-sm text-gray-600 mt-1 space-x-1">
                    <li><a href="{{ url('/dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
                    <li><a href="{{ url('/manage-promotor') }}" class="text-blue-600 hover:underline">Promoter</a></li>
                    <li class="text-gray-500">Manage Promoters</li>
                </ol> -->
        </div>
        <!-- <a href="{{ route('create.shareholding') }}" class="btn-primary">
            <i class="las la-plus-circle text-base md:text-lg"></i>
            Add Share Holding
        </a> -->
        <!-- </h2> -->
    </div>

    <!-- Latest Transactions -->
    <div class="box col-span-12 lg:col-span-6">
        <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
            <!-- <h4 class="h4">Manage Promotors</h4> -->
            <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2 mb-4">
                <label for="perPage" class="text-sm">Show</label>
                <select name="perPage" id="perPage" onchange="this.form.submit()"
                    class="border rounded px-2 py-1 text-sm">
                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span class="text-sm">entries</span>
            </form>
            <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                <form
                    class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                    <input type="text" id="transaction-search" placeholder="Search"
                        class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                    <button
                        class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                        <i class="las la-search text-lg"></i>
                    </button>
                </form>
            </div>
        </div>
        @if (session('success'))
        <div id="success-alert" style="background-color: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
            <strong>Success:</strong> {{ session('success') }}
            <span onclick="document.getElementById('success-alert').style.display='none';" style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #155724;">&times;</span>
        </div>
        @endif

        @if (session('error'))
        <div id="error-alert" style="background-color: #f8d7da; border: 1px solid #dc3545; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
            <strong>Error:</strong> {{ session('error') }}
            <span onclick="document.getElementById('error-alert').style.display='none';" style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #721c24;">&times;</span>
        </div>
        @endif
        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead class="custom-thead">
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Sr No
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Promoters
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                First Distinctive No.
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Last Distinctive No.
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Total Shares Held
                            </div>
                        </th>
                        <th class="text-start !py-5 cursor-pointer">
                            <div class="flex items-center gap-1">
                                Share Nominal Val.
                            </div>
                        </th>
                        <th class="text-start !py-5 cursor-pointer">
                            <div class="flex items-center gap-1">
                                Total Val.
                            </div>
                        </th>
                        <th class="text-start !py-5 cursor-pointer">
                            <div class="flex items-center gap-1">
                                Allotment
                            </div>
                        </th>
                        <th class="text-center !py-5" data-sortable="false">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($share_holdings as $index => $share)
                    <tr>
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">{{ $share->promoters->first_name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $share->first_share }}</td>
                        <td class="px-6 py-4">{{ $share->share_no }}</td>
                        <td class="px-6 py-4">{{ $share->total_share_held ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $share->nominal_value ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $share->total_share_value ?? '-' }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($share->allotment_date)->format('d-m-Y') }}</td>
                        <!-- <td class="px-6 py-4 text-center">
                            <a href="#" class="text-blue-600 hover:underline">View</a>
                        </td> -->
                        <td class="py-5 px-6">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('shareholding.view', $share->id) }}"
                                    class="border-green-500 text-green-500 hover:bg-green-500 hover:text-white rounded-full transition duration-150"><i
                                        class="las la-eye"></i></a>
                                <a href="{{ route('shareholding.edit', $share->id) }}"
                                    class="border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white rounded-full transition duration-150"><i
                                        class="las la-edit"></i>
                                    </a>
                            </div>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-gray-500">No shareholding records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection