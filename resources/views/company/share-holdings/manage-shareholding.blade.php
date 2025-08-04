@extends('layout.main')

@section('page-title', 'Promoters Share Holding Details')
@section('action-button')
<a class="btn-primary" href="{{ route('shareholding.create') }}">
    <i class=" md:text-lg"></i>
    Add
</a>
@endsection
@section('content')
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
            <form action="{{ route('shareholding.index') }}"
                class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                <input type="text" name="search" id="transaction-search" placeholder="Search"
                    value="{{ request('search') }}"
                    class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                <button
                    class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                    <i class="las la-search text-lg"></i>
                </button>
                @if (request('search'))
                <a href="{{ route('shareholding.index') }}"
                    class="w-7 h-7 bg-grey-500 hover:bg-grey-900 text-dark rounded-full flex items-center justify-center transition duration-200"
                    title="Clear Search">
                    <i class="las la-times text-lg"></i>
                </a>
                @endif
            </form>
        </div>
    </div>
    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>
    <div class="overflow-x-auto pb-4 lg:pb-6">
        <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
            <thead class="custom-thead">
                <tr class="bg-secondary/5 dark:bg-bg3">
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
                    <th class="text-center !py-5" data-sortable="false">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($share_holdings as $index => $share)
                <tr>
                    <td class="px-6 py-4">{{ $share->promotor->first_name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $share->first_share }}</td>
                    <td class="px-6 py-4">{{ $share->share_no }}</td>
                    <td class="px-6 py-4">{{ $share->total_share_held ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $share->nominal_value ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $share->total_share_value ?? '-' }}</td>
                    <!-- <td class="px-6 py-4">{{ \Carbon\Carbon::parse($share->allotment_date)->format('d-m-Y') }}</td> -->
                    <td class="py-2 px-6">
                        <div class="flex justify-center">
                            @include('partials._vertical-options', [
                            'id' => base64_encode($share->id),
                            'viewRoute' => 'shareholding.show',
                            'editRoute' => 'shareholding.edit',
                            ])
                        </div>
                    </td>
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
@endsection

@push('script')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#transactionTable1').DataTable({
            pageLength: 10,
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
@endpush