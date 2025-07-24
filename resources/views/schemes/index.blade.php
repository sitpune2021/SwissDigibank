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
</style>

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3 lg:mb-5">
            <h4 class="h2">Schemes</h4>
            <a class="btn-primary" href="{{ route('schemes.create') }}">
                <i class=" text-base md:text-lg"></i>
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

                <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                    <form method="GET" action="{{ route('schemes.index') }}"
                        class="relative flex items-center gap-2 bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-full px-4 py-1 min-w-[200px] xl:max-w-[319px]">

                        <input type="text" name="search" placeholder="Search" value="{{ request('search') }}"
                            class="bg-transparent border-none text-sm text-gray-800 dark:text-white focus:outline-none w-full placeholder:text-gray-400" />

                        <button type="submit"
                            class="w-7 h-7 bg-primary hover:bg-primary/90 text-white rounded-full flex items-center justify-center transition duration-200">
                            <i class="las la-search text-lg"></i>
                        </button>

                        @if (request('search'))
                            <a href="{{ route('schemes.index') }}"
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
                            <th class="text-start !py-2 px-3">Sr No</th>
                            <th class="text-start !py-2 px-3">Code</th>
                            <th class="text-start !py-2 px-3">Scheme Name</th>
                            <th class="text-start !py-2 px-3">Min. Amt. To Open A/c</th>
                            <th class="text-start !py-2 px-3">Min. Balance/Month</th>
                            <th class="text-start !py-2 px-3">Lock In Amt.</th>
                            <th class="text-start !py-2 px-3">Interest Rate (%)</th>
                            <th class="text-start !py-2 px-3">Interest Payout</th>
                            <th class="text-start !py-2 px-3">Active</th>
                            <th class="text-center !py-5">Action</th>
                    {{-- <tbody>
                    @foreach ($schemes as $scheme)
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <td class="py-5 px-6">{{ ($schemes->currentPage() - 1) * $schemes->perPage() + $loop->iteration }}</td>
                            <td class="py-5 px-6">{{ $scheme->code }}</td>
                            <td class="py-5 px-6">{{ $scheme->name }}</td>
                            <td class="py-5 px-6">{{ number_format($scheme->min_open_amt, 2) }}</td>
                            <td class="py-5 px-6">{{ number_format($scheme->min_monthly_bal, 2) }}</td>
                            <td class="py-5 px-6">{{ number_format($scheme->lock_in_amt, 2) }}</td>
                            <td class="py-5 px-6">{{ $scheme->interest_rate }}%</td>
                            <td class="py-2 px-6">
                            <div class="flex justify-center">
                                @include('partials._vertical-options', [
                                'id' => $promotor->id,
                                'viewRoute' => 'promotor.view',
                                'editRoute' => 'promotor.edit'
                                ])
                            </div>
                        </td>
 
                        </tr>
                    @endforeach
                </tbody> --}}
                </table>
            </div>
        </div>
    </div>
@endsection
