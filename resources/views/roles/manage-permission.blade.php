@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-2">
            <h1 class="text-xl font-semibold">Permisions /Roles</h1>
            <a href="{{ route('roles.create') }}"
                class="inline-flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary hover:bg-green-700">
                <i class="text-lg las la-plus"></i>
            </a>
        </div>
    </div>

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
                    class="relative flex items-center gap-2 bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-full px-4 py-1 min-w-[200px] xl:max-w-[319px]">

                    <input type="text" name="search" id="transaction-search"
                        placeholder="Search"
                        value="{{ request('search') }}"
                        class="w-full text-sm text-gray-800 bg-transparent border-none dark:text-white focus:outline-none placeholder:text-gray-400" />

                    <button type="submit"
                        class="flex items-center justify-center text-white transition duration-200 rounded-full w-7 h-7 bg-primary hover:bg-primary/90">
                        <i class="text-lg las la-search"></i>
                    </button>

                    @if(request('search'))
                    <a href="{{ route('branch.index') }}"
                        class="flex items-center justify-center transition duration-200 rounded-full w-7 h-7 bg-grey-500 hover:bg-grey-900 text-dark"
                        title="Clear Search">
                        <i class="text-lg las la-times"></i>
                    </a>
                    @endif
                </form>
            </div>
        </div>
        <div class="pb-4 overflow-x-auto lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead class="custom-thead">
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Sr No
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Branch Name
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px]" data-sortable="false">Branch Code</th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                City
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[130px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                State
                            </div>
                        </th>
                        <th class="text-start !py-5 cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Opening Date
                            </div>
                        </th>
                        <th class="text-start !py-5 cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Members
                            </div>
                        </th>
                        <th class="text-center justify-center !py-5" data-sortable="false">Action</th>
                    </tr>
                </thead>

            </table>
        </div>

    </div>
</div>
@endsection
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#branchTable').DataTable({
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
