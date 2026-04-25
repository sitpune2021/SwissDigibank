@extends('layout.main')
@section('page-title', 'PERMISSIONS / ROLES')

@section('action-button')
<a class="btn-primary" href="{{ route('roles.create') }}">
    ADD
</a>
@endsection

@section('content')

<style>

@keyframes fadeRow{
0%{
opacity:0;
transform:translateY(10px);
}
100%{
opacity:1;
transform:translateY(0);
}
}

.table-row{
animation:fadeRow .4s ease forwards;
}

/* hover animation */

.table-row:hover{
transform:scale(1.01);
box-shadow:0 4px 12px rgba(0,0,0,0.08);
transition:all .25s ease;
}

</style>

<div class="col-span-12 box lg:col-span-6">

    <x-searchbox />
    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>

    <div class="overflow-x-auto pb-4 lg:pb-6">

        <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">

           <thead class="bg-gray-100 dark:bg-bg3 sticky top-0" style="background-color: bisque;">
                    <tr class="text-gray-700 dark:text-gray-200 text-sm font-semibold uppercase tracking-wider">

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
            <tbody>
                @forelse($roles as $key => $role)
                    <tr class="table-row dark:even:bg-bg3 border-b hover:bg-gray-50 dark:hover:bg-bg3"
                        style="animation-delay: {{ $loop->index * 0.05 }}s">

                        <td class="px-6 py-4">
                            {{ $key + 1 }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $role->role->name ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $role->role_position ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            @if($role->active == 'Yes')
                                <span class="text-green-600 font-semibold">Active</span>
                            @else
                                <span class="text-red-600 font-semibold">Inactive</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            {{ $role->role_id ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $role->permission_id ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('roles.edit', $role->id) }}" class="text-blue-600">Edit</a>
                            |
                            <a href="{{ route('roles.show', $role->id) }}" class="text-green-600">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            No Roles Found
                        </td>
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