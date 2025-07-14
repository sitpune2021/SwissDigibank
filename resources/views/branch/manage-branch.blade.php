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
        <div class="flex items-center gap-2">
            <h1 class="text-xl font-semibold">Branches</h1>
            <a href="{{ route('create.branch') }}"
                class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white hover:bg-green-700">
                <i class="las la-plus text-lg"></i>
            </a>

            <!-- <ol class="breadcrumb flex text-sm text-gray-600 mt-1 space-x-1">
                <li><a href="{{ url('/dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
                <li><a href="{{ url('/manage-branch') }}" class="text-blue-600 hover:underline">Branches</a></li>
                <li class="text-gray-500">Branches</li>
            </ol> -->

        </div>

        <!-- <a href="{{ route('create.branch') }}" class="btn-primary">
            <i class="las la-plus-circle text-base md:text-lg"></i>
            Add Branch
        </a> -->
    </div>

    <!-- Latest Transactions -->
    <div class="box col-span-12 lg:col-span-6">
        <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
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
                <!-- <form
                    class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                    <input type="text" name="search" id="transaction-search" placeholder="Search"
                        class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                    <button type="sumbit"
                        class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                        <i class="las la-search text-lg"></i>
                    </button>
                </form> -->

                <form method="GET" action="{{ route('manage.branch') }}"
                    class="relative flex items-center gap-2 bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-full px-4 py-1 min-w-[200px] xl:max-w-[319px]">

                    <input type="text" name="search" id="transaction-search"
                        placeholder="Search"
                        value="{{ request('search') }}"
                        class="bg-transparent border-none text-sm text-gray-800 dark:text-white focus:outline-none w-full placeholder:text-gray-400" />

                    <button type="submit"
                        class="w-7 h-7 bg-primary hover:bg-primary/90 text-white rounded-full flex items-center justify-center transition duration-200">
                        <i class="las la-search text-lg"></i>
                    </button>

                    @if(request('search'))
                    <a href="{{ route('manage.branch') }}"
                        class="w-7 h-7 bg-grey-500 hover:bg-grey-900 text-dark rounded-full flex items-center justify-center transition duration-200"
                        title="Clear Search">
                        <i class="las la-times text-lg"></i>
                    </a>
                    @endif
                </form>
            </div>
        </div>
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
                                Branch Name
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px]" data-sortable="false">Branch Code</th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                City
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                State
                            </div>
                        </th>
                        <th class="text-start !py-5 cursor-pointer">
                            <div class="flex items-center gap-1">
                                Opening Date
                            </div>
                        </th>
                        <th class="text-start !py-5 cursor-pointer">
                            <div class="flex items-center gap-1">
                                Members
                            </div>
                        </th>
                        <th class="text-center !py-5" data-sortable="false">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $s=0;
                    @endphp
                    @foreach($branches as $branch)
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="py-5 px-6">{{$s=$s+1}}</td>
                        <td class="py-5 px-6">
                            <div>
                                <p class="font-medium mb-1">{{ $branch->branch_name }}</p>
                            </div>
                        </td>
                        <td class="py-5 px-6">{{ $branch->branch_code }}</td>
                        <td class="py-5 px-6">{{ $branch->city }}</td>
                        <td class="py-5 px-6">{{ $branch->stateData->name }}</td>
                        <td class="py-5 px-6">
                            {{ $branch->open_date }}
                        </td>
                        <td class="py-5 px-6">0</td>
                        <td class="py-5 px-6">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('branch.view', $branch->id) }}" class="border-green-500 text-green-500 hover:bg-green-500 hover:text-white rounded-full transition duration-150"><i class="las la-eye"></i></a>
                                <a href="{{ route('branch.edit', $branch->id) }}" class="border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white rounded-full transition duration-150"><i class="las la-edit"></i></a>
                                <!-- <form action="{{ route('branch.delete', $branch->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="border-red-500 text-red-500 hover:bg-red-500 hover:text-white rounded-full transition duration-150" onclick="return confirm('Are you sure?')"><i class="las la-trash-alt"></i></button>
                                </form> -->
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($branches->lastPage() > 1)
        <div class="flex col-span-12 gap-4 sm:justify-between justify-center items-center flex-wrap">
            <ul class="flex gap-2 md:gap-3 flex-wrap md:font-semibold items-center">

                {{-- Previous Page Link --}}
                @if ($branches->onFirstPage())
                <li>
                    <button
                        class="border md:w-10 md:h-10 w-8 h-8 flex items-center justify-center rounded-full text-gray-400 border-gray-300"
                        disabled>
                        <i class="las la-angle-left text-lg"></i>
                    </button>
                </li>
                @else
                <li>
                    <a href="{{ $branches->previousPageUrl() }}"
                        class="hover:bg-primary text-primary rtl:rotate-180 hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                        <i class="las la-angle-left text-lg"></i>
                    </a>
                </li>
                @endif

                {{-- Page Number Links --}}
                @for ($i = 1; $i <= $branches->lastPage(); $i++)
                    @if ($i == $branches->currentPage())
                    <li>
                        <button
                            class="hover:bg-primary text-n0 bg-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                            {{ $i }}
                        </button>
                    </li>
                    @else
                    <li>
                        <a href="{{ $branches->url($i) }}"
                            class="hover:bg-primary text-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                            {{ $i }}
                        </a>
                    </li>
                    @endif
                    @endfor

                    {{-- Next Page Link --}}
                    @if ($branches->hasMorePages())
                    <li>
                        <a href="{{ $branches->nextPageUrl() }}"
                            class="hover:bg-primary text-primary hover:text-n0 rtl:rotate-180 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                            <i class="las la-angle-right text-lg"></i>
                        </a>
                    </li>
                    @else
                    <li>
                        <button
                            class="border md:w-10 md:h-10 w-8 h-8 flex items-center justify-center rounded-full text-gray-400 border-gray-300"
                            disabled>
                            <i class="las la-angle-right text-lg"></i>
                        </button>
                    </li>
                    @endif

            </ul>
        </div>
        @endif
    </div>
</div>
@endsection
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#branchTable').DataTable({
            pageLength: 10, // default
            lengthMenu: [10, 25, 50, 100]
        });
    });
</script>
<script>
    document.getElementById('transaction-search').addEventListener('input', function() {
        if (this.value === '') {
            this.form.submit();
        }
    });
</script>