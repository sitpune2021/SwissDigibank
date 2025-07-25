@extends('layout.main')
@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <!-- <h2 class="h2">Manage Director</h2> -->
        <h2 class="h2">Director</h2>
        <a class="btn-primary" href="{{ route('director.create') }}">
            <i class="las la-plus-circle text-base md:text-lg"></i>
            Add
        </a>
    </div>
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
            {{-- <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <!-- <h2 class="h2">Manage Promotors</h2> -->
            <div>
                <h1 class="text-xl font-semibold">Manage Director</h1>
                <ol class="breadcrumb flex text-sm text-gray-600 mt-1 space-x-1">
                    <li><a href="{{ url('/dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
            <li><a href="{{ url('/manage-director') }}" class="text-blue-600 hover:underline">Director</a></li>
            <li class="text-gray-500">Manage Director</li>
            </ol>
        </div>
        <!-- <a href="{{ route('director.create') }}" class="btn-primary">
            <i class="las la-plus-circle text-base md:text-lg"></i>
            Add Director
        </a> -->
    </div> --}}

    <!-- Latest Transactions -->
    <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
        <form method="GET" action="{{ route('director.index') }}"
            class="relative flex items-center gap-2 bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xl:max-w-[319px]">
            <input type="text" id="transaction-search" name="search" placeholder="Search"
                value="{{ request('search') }}"
                class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
            <button type="submit"
                class="w-7 h-7 bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                <i class="las la-search text-lg"></i>
            </button>
            @if (request('search'))
            <a href="{{ route('director.index') }}"
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
        <thead>
            <tr class="bg-secondary/5 dark:bg-bg3">
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">
                        Sr No
                    </div>
                </th>
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">
                        Designation
                    </div>
                </th>
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">
                        Member No
                    </div>
                </th>
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">
                        Name
                    </div>
                </th>
                <th class="text-start !py-5 min-w-[100px]" data-sortable="false">Gender</th>
                <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">
                        DIN
                    </div>
                </th>
                <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                    <div class="flex items-center gap-1">
                        Appointment Date
                    </div>
                </th>
                </th>
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">
                        Resignation Date
                    </div>
                </th>
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">
                        Authorized Signatory
                    </div>
                </th>
                </th>
                <th class="text-center !py-5" data-sortable="false">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($directors as $index => $director)
            <tr>
                <td class="px-6 py-4">{{ $index + 1 }}</td> <!-- Sr No -->
                <td class="px-6 py-4">{{ $director->designation ?? 'N/A' }}</td>
                <td class="px-6 py-4">{{ $director->member->id ?? 'N/A' }}</td>
                <td class="px-6 py-4">{{ $director->member->member_info_first_name ?? 'N/A' }}</td>
                <td class="px-6 py-4">{{ $director->member->member_info_gender ?? 'N/A' }}</td>
                <td class="px-6 py-4">{{ $director->din_no }}</td>
                <td class="px-6 py-4">{{ $director->appointment_date?->format('d-m-Y') ?? 'N/A' }}</td>
                <td class="px-6 py-4">{{ $director->resignation_date?->format('d-m-Y') ?? 'N/A' }}</td>
                <!-- <td class="px-6 py-4">{{ $director->authorized_signatory ? 'Yes' : 'No' }}</td> -->
                <td class="py-2">
                    @if($director->authorized_signatory == 'Yes')
                    <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                        Yes
                    </span>
                    @else
                    <span
                        class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16">
                        {{$director->authorized_signatory}}
                    </span>
                    @endif
                </td>
                <td class="py-2 px-6">
                    <div class="flex justify-center">
                        @include('partials._vertical-options', [
                        'id' =>base64_encode($director->id),
                        'viewRoute' => 'director.show',
                        'editRoute' => 'director.edit'
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