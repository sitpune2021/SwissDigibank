@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-center gap-2">
            <h1 class="text-xl font-semibold">Permissions</h1>
            <a href="{{ route('roles.create') }}"
               class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white hover:bg-green-700">
                <i class="las la-plus text-lg"></i>
            </a>
        </div>
    </div>

    <div class="box col-span-12 lg:col-span-6">
        <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
            <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2 mb-4">
                <label for="perPage" class="text-sm">Show</label>
                <select name="perPage" id="perPage" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span class="text-sm">entries</span>
            </form>

            <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                <form method="GET" action="{{ url()->current() }}" class="relative flex items-center gap-2 bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-full px-4 py-1 min-w-[200px] xl:max-w-[319px]">
                    <input
                        type="text"
                        name="search"
                        id="transaction-search"
                        placeholder="Search"
                        value="{{ request('search') }}"
                        class="bg-transparent border-none text-sm text-gray-800 dark:text-white focus:outline-none w-full placeholder:text-gray-400"
                    />
                    <button type="submit" class="w-7 h-7 bg-primary hover:bg-primary/90 text-white rounded-full flex items-center justify-center transition duration-200">
                        <i class="las la-search text-lg"></i>
                    </button>

                    @if(request('search'))
                    <a href="{{ url()->current() }}" class="w-7 h-7 bg-grey-500 hover:bg-grey-900 text-dark rounded-full flex items-center justify-center transition duration-200" title="Clear Search">
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
                            <div class="flex items-center gap-1">Sr No</div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">Role Name</div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">Position</div>
                        </th>
                        <th class="text-start !py-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">Active</div>
                        </th>
                        <th class="text-start !py-5 cursor-pointer">
                            <div class="flex items-center gap-1">Users</div>
                        </th>
                        <th class="text-start !py-5 cursor-pointer">
                            <div class="flex items-center gap-1">Associates</div>
                        </th>
                        <th class="text-center !py-5" data-sortable="false">Actions</th>
                    </tr>
                </thead>
                {{-- Table body should be rendered here with roles data --}}
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#transactionTable1').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            searching: false // Disable default DataTable search as you have your own search form
        });
    });

    document.getElementById('transaction-search').addEventListener('input', function() {
        if (this.value === '') {
            this.form.submit();
        }
    });
</script>
@endsection
