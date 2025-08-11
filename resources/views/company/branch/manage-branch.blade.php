@extends('layout.main')
@section('page-title', 'Branches')
@section('action-button')
<a class="btn-primary" href="{{ route('branch.create') }}">
    <i class=" md:text-lg"></i>
    Add
</a>
@endsection

@section('content')
<div class="col-span-12 box lg:col-span-6">
    <div class="flex flex-wrap items-center justify-between gap-4 pb-4 mb-4 bb-dashed lg:mb-6 lg:pb-6">
        <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2 mb-4">
            <label for="perPage" class="text-sm">Show</label>
            <select name="perPage" id="perPage" onchange="this.form.submit()"
                class="px-2 py-1 text-sm border rounded">
                <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
            </select>
            <span class="text-sm">entries</span>
        </form>
        <div class="flex flex-wrap items-center gap-4 grow sm:justify-end">
            <form method="GET" action="{{ route('branch.index') }}"
                class="relative flex items-center gap-2 bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xl:max-w-[319px]">
                <input type="text" id="transaction-search" name="search" placeholder="Search"
                    value="{{ request('search') }}"
                    class="w-full py-1 text-sm bg-transparent border-none ltr:pl-4 rtl:pr-4" />
                <button type="submit"
                    class="flex items-center justify-center rounded-full w-7 h-7 bg-primary shrink-0 lg:w-8 lg:h-8 text-n0">
                    <i class="text-lg las la-search"></i>
                </button>
                @if (request('search'))
                <a href="{{ route('branch.index') }}"
                    class="flex items-center justify-center transition duration-200 rounded-full w-7 h-7 bg-grey-500 hover:bg-grey-900 text-dark"
                    title="Clear Search">
                    <i class="text-lg las la-times"></i>
                </a>
                @endif
            </form>
        </div>
    </div>
    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>
    <div class="pb-4 overflow-x-auto lg:pb-6">
        <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
            <thead class="custom-thead">
                <tr class="bg-secondary/5 dark:bg-bg3">
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center justify-center gap-1">
                            Branch Name
                        </div>
                    </th>
                    <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                        <div class="flex items-center justify-center gap-1">
                            Branch Code
                        </div>
                    </th>
                    <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                        <div class="flex items-center justify-center gap-1">
                            City
                        </div>
                    </th>
                    <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                        <div class="flex items-center justify-center gap-1">
                            State
                        </div>
                    </th>
                    <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                        <div class="flex items-center justify-center gap-1">
                            Opening Date
                        </div>
                    </th>
                    <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                        <div class="flex items-center justify-center gap-1  text-center">
                            Members
                        </div>
                    </th>
                    <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                        <div class="   flex items-center justify-center gap-1">
                            Is Active
                        </div>
                    </th>
                    <th class="text-center justify-center !py-5" data-sortable="false">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($branches as $branch)
                <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                    <td class="px-2 py-5 text-center">
                        <div>
                            <p class="mb-1 font-medium">{{ $branch->branch_name }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">{{ $branch->branch_code }}</td>
                    <td class="px-6 py-5 text-center">{{ $branch->city }}</td>
                    <td class="px-6 py-5 text-center">{{ $branch->State?->name }}</td>
                    <td class="px-6 py-5 text-center">
                        {{ $branch->open_date->format('D M d Y') }}
                    </td>
                    <td class="px-7 py-5 text-center">{{ $branch->Member->count() }}</td>
                    <td class="px-6 py-5  text-center">
                        @if ($branch->active == 'Yes')
                        <span
                            class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            Yes
                        </span>
                        @else
                        <span
                            class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            {{ $branch->active }}
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-2  text-center">
                        <div class="flex justify-center">
                            @include('partials._vertical-options', [
                            'id' => base64_encode($branch->id),
                            'viewRoute' => 'branch.show',
                            'editRoute' => 'branch.edit',
                            ])

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-4 text-gray-500">No record found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($branches->lastPage() > 1)
    <div class="flex flex-wrap items-center justify-center col-span-12 gap-4 sm:justify-between">
        <ul class="flex flex-wrap items-center gap-2 md:gap-3 md:font-semibold">

            {{-- Previous Page Link --}}
            @if ($branches->onFirstPage())
            <li>
                <button
                    class="flex items-center justify-center w-8 h-8 text-gray-400 border border-gray-300 rounded-full md:w-10 md:h-10"
                    disabled>
                    <i class="text-lg las la-angle-left"></i>
                </button>
            </li>
            @else
            <li>
                <a href="{{ $branches->previousPageUrl() }}"
                    class="flex items-center justify-center w-8 h-8 duration-300 border rounded-full hover:bg-primary text-primary rtl:rotate-180 hover:text-n0 md:w-10 md:h-10 border-primary">
                    <i class="text-lg las la-angle-left"></i>
                </a>
            </li>
            @endif

            {{-- Page Number Links --}}
            @for ($i = 1; $i <= $branches->lastPage(); $i++)
                @if ($i == $branches->currentPage())
                <li>
                    <button
                        class="flex items-center justify-center w-8 h-8 duration-300 border rounded-full hover:bg-primary text-n0 bg-primary hover:text-n0 md:w-10 md:h-10 border-primary">
                        {{ $i }}
                    </button>
                </li>
                @else
                <li>
                    <a href="{{ $branches->url($i) }}"
                        class="flex items-center justify-center w-8 h-8 duration-300 border rounded-full hover:bg-primary text-primary hover:text-n0 md:w-10 md:h-10 border-primary">
                        {{ $i }}
                    </a>
                </li>
                @endif
                @endfor

                {{-- Next Page Link --}}
                @if ($branches->hasMorePages())
                <li>
                    <a href="{{ $branches->nextPageUrl() }}"
                        class="flex items-center justify-center w-8 h-8 duration-300 border rounded-full hover:bg-primary text-primary hover:text-n0 rtl:rotate-180 md:w-10 md:h-10 border-primary">
                        <i class="text-lg las la-angle-right"></i>
                    </a>
                </li>
                @else
                <li>
                    <button
                        class="flex items-center justify-center w-8 h-8 text-gray-400 border border-gray-300 rounded-full md:w-10 md:h-10"
                        disabled>
                        <i class="text-lg las la-angle-right"></i>
                    </button>
                </li>
                @endif

        </ul>
    </div>
    @endif
</div>
@endsection