@extends('layout.main')
@extends('layout.tablestyle')

@php
    $permissions = auth()->user()->rolePermission->permissions ?? [];
    $isSuperAdmin = auth()->user()->role_id == 1;
@endphp

@section('action-button')
    @if($isSuperAdmin || in_array('roles.create', $permissions))
        <a href="{{ route('roles.create') }}"
            class="px-4 py-2 rounded-xl text-sm font-semibold shadow-md transition-all duration-200
            hover:scale-105"
            style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">
            ALLOW PERMISSION
        </a>
    @endif
@endsection

@section('page-title')

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

    <!-- LEFT SIDE -->
    <div class="flex items-center gap-3 min-w-0">

        <!-- ICON -->
        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl
            flex items-center justify-center shrink-0 shadow-lg"
            style="
                background: linear-gradient(135deg,#2563eb,#06b6d4,#0ea5e9);
                min-width:44px;
                min-height:44px;
            ">

            <i class="las la-user-shield text-white text-xl sm:text-2xl leading-none"></i>

        </div>

        <!-- TITLE -->
        <div class="min-w-0">

            <h2 class="text-lg sm:text-xl lg:text-2xl
                font-extrabold uppercase tracking-wide
                text-gray-800 leading-tight truncate">

                Permissions / Roles

            </h2>

            <p class="text-[11px] sm:text-sm text-gray-500 font-medium mt-1">

                Manage roles, permissions & operations

            </p>

        </div>

    </div>

    <!-- RIGHT BADGE -->
    <div class="hidden md:flex items-center gap-2
        px-4 py-2 rounded-xl
        bg-gradient-to-r from-slate-100 to-slate-50
        border border-slate-200 shadow-sm">

        <span class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></span>

        <span class="text-xs font-bold uppercase tracking-wider text-slate-600">

            Banking Panel

        </span>

    </div>

</div>

@endsection

@section('content')

<div class="box col-span-12 lg:col-span-6 bank-page-animate">

    <div class="mb-3">
        <x-searchbox />
    </div>

    <!-- TABLE -->
    <div class="table-wrapper w-full overflow-x-auto rounded-2xl border border-gray-200 bg-white shadow-sm table-premium">

        <table
            class="w-full min-w-max whitespace-nowrap select-all-table border-separate border-spacing-y-2"
            id="transactionTable1">

            <thead class="bg-gradient-to-r from-orange-50 via-white to-orange-50 border-b border-gray-200 sticky top-0 z-10">

                <tr class="text-[11px] sm:text-xs lg:text-sm font-bold uppercase tracking-wider text-gray-700">

                    <!-- SR NO -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[100px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                                <i class="las la-hashtag text-blue-600 text-sm"></i>
                            </div>

                            <span>SR NO</span>

                        </div>

                    </th>

                    <!-- ROLE NAME -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[220px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-cyan-100 flex items-center justify-center shrink-0">
                                <i class="las la-user-shield text-cyan-600 text-sm"></i>
                            </div>

                            <span>ROLE NAME</span>

                        </div>

                    </th>

                    <!-- ACTIVE -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[150px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-green-100 flex items-center justify-center shrink-0">
                                <i class="las la-toggle-on text-green-600 text-sm"></i>
                            </div>

                            <span>STATUS</span>

                        </div>

                    </th>

                    <!-- ACTION -->
                    <th class="text-center py-4 px-3 sm:px-5 min-w-[180px] whitespace-nowrap">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-cogs text-gray-700 text-sm"></i>
                            </div>

                            <span>ACTIONS</span>

                        </div>

                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($roles as $key => $role)

                <tr
                    class="table-row bg-white dark:bg-bg3 border border-gray-100 dark:border-gray-700"
                    style="animation-delay: {{ $loop->index * 0.05 }}s">

                    <!-- SR -->
                    <td class="px-4 py-4">

                        <div class="font-semibold text-gray-700">

                            {{ $key + 1 }}

                        </div>

                    </td>

                    <!-- ROLE -->
                    <td class="px-4 py-4">

                        <div class="flex items-center gap-3">

                            <div>

                                <div class="font-bold text-gray-800">

                                    {{ $role->role->name ?? '-' }}

                                </div>

                                <div class="text-xs text-gray-500">

                                    Role Permission

                                </div>

                            </div>

                        </div>

                    </td>

                    <!-- ACTIVE -->
                    <td class="px-4 py-4">

                        @if($role->active == 'Yes')

                            <span
                                class="inline-flex items-center justify-center
                                px-4 py-2 rounded-full
                                bg-green-100 text-green-700
                                text-xs font-bold">

                                Active

                            </span>

                        @else

                            <span
                                class="inline-flex items-center justify-center
                                px-4 py-2 rounded-full
                                bg-red-100 text-red-700
                                text-xs font-bold">

                                Inactive

                            </span>

                        @endif

                    </td>

                    <!-- ACTION -->
                    <td class="px-4 py-4">

                        <div class="flex flex-wrap items-center justify-center gap-2">

                            @if($isSuperAdmin || in_array('roles.show', $permissions))

                            <a href="{{ route('roles.show', $role->id) }}"
                                class="action-btn action-view">

                                <i class="las la-eye text-sm"></i>

                                <span>View</span>

                            </a>

                            @endif

                            @if($isSuperAdmin || in_array('roles.edit', $permissions))

                            <a href="{{ route('roles.edit', $role->id) }}"
                                class="action-btn action-edit">

                                <i class="las la-edit text-sm"></i>

                                <span>Edit</span>

                            </a>

                            @endif

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="7" class="text-center py-10 text-gray-500 font-medium">

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