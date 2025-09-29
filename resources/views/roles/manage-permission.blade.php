@extends('layout.main')
@section('page-title', 'PERMISSIONS / ROLES')

@section('action-button')
<a class="btn-primary" href="{{ route('roles.create') }}">
    Add
</a>
@endsection

@section('content')
<div class="col-span-12 box lg:col-span-6">
    <x-searchbox />
    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>

    <div class="overflow-x-auto pb-4 lg:pb-6">
        <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
            <thead class="custom-thead">
                <tr class="bg-secondary/5 dark:bg-bg3">
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">SR NO</div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">ROLE NAME</div>
                    </th>
                    <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">POSITION</div>
                    </th>
                    <th class="text-start !py-6 min-w-[130px] cursor-pointer">
                        <div class="flex items-center gap-1">ACTIVE</div>
                    </th>
                    <th class="text-start !py-5 cursor-pointer">
                        <div class="flex items-center gap-1">USERS</div>
                    </th>
                    <th class="text-start !py-5 cursor-pointer">
                        <div class="flex items-center gap-1">ASSOCIATE</div>
                    </th>
                    <th class="text-center !py-5" data-sortable="false">ACTIONS</th>
                </tr>
            </thead>
            {{-- Table body should be rendered here with roles data --}}
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
@endpush