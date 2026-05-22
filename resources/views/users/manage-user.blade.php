@extends('layout.main')
@extends('layout.tablestyle')

@php
    $permissions = auth()->user()->rolePermission->permissions ?? [];
    $isSuperAdmin = auth()->user()->role_id == 1;
@endphp

@section('action-button')
   @if($isSuperAdmin || in_array('users.create', $permissions))
        <a href="{{route('users.create')}}"
            class="px-4 py-2 rounded-xl text-sm font-semibold shadow-md transition-all duration-200
            hover:scale-105"
            style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">
            ADD USER
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

            <i class="las la-users-cog text-white text-xl sm:text-2xl leading-none"></i>

        </div>

        <!-- TITLE -->
        <div class="min-w-0">

            <h2 class="text-lg sm:text-xl lg:text-2xl
                font-extrabold uppercase tracking-wide
                text-gray-800 leading-tight truncate">

                User Management

            </h2>

            <p class="text-[11px] sm:text-sm text-gray-500 font-medium mt-1">

                Manage users, permissions & operations

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

            <table class="select-all-table" id="transactionTable1">

                <thead class="sticky top-0 z-10 bg-white dark:bg-bg3 border-b border-gray-200 dark:border-gray-700 shadow-sm">

                    <tr class="text-[11px] md:text-xs lg:text-sm font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-200">

                        <!-- SR NO -->
                        <th class="px-3 sm:px-5 py-4 text-center min-w-[90px]">

                            <div class="flex items-center justify-center gap-2">

                                <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                    <i class="las la-hashtag text-sm sm:text-base text-black"></i>
                                </div>

                                <span class="text-black whitespace-nowrap">SR NO</span>

                            </div>

                        </th>

                        <!-- USER NAME -->
                        <th class="text-start py-4 px-3 md:px-5 min-w-[180px]">

                            <div class="flex items-center gap-2 whitespace-nowrap">

                                <i class="las la-user-circle text-base text-primary"></i>

                                <span>USER NAME</span>

                            </div>

                        </th>

                        <!-- EMAIL -->
                        <th class="text-start py-4 px-3 md:px-5 min-w-[220px]">

                            <div class="flex items-center gap-2 whitespace-nowrap">

                                <i class="las la-envelope text-base text-blue-600"></i>

                                <span>EMAIL</span>

                            </div>

                        </th>

                        <!-- CONTACT -->
                        <th class="text-start py-4 px-3 md:px-5 min-w-[150px]">

                            <div class="flex items-center gap-2 whitespace-nowrap">

                                <i class="las la-phone text-base text-green-600"></i>

                                <span>CONTACT</span>

                            </div>

                        </th>

                        <!-- ROLE -->
                        <th class="text-start py-4 px-3 md:px-5 min-w-[150px]">

                            <div class="flex items-center gap-2 whitespace-nowrap">

                                <i class="las la-user-shield text-base text-blue-600"></i>

                                <span>ROLE</span>

                            </div>

                        </th>

                        <!-- ACTIVE -->
                        <th class="text-start py-4 px-3 md:px-5 min-w-[120px]">

                            <div class="flex items-center gap-2 whitespace-nowrap">

                                <i class="las la-toggle-on text-base text-emerald-600"></i>

                                <span>STATUS</span>

                            </div>

                        </th>

                        <!-- ACTION -->
                        <th class="text-center py-4 px-3 md:px-5 min-w-[130px]">

                            <div class="flex items-center justify-center gap-2 whitespace-nowrap">

                                <i class="las la-cogs text-base text-red-500"></i>

                                <span>ACTION</span>

                            </div>

                        </th>

                    </tr>

                </thead>

                <tbody>
                    @forelse ($users as $index => $user)
                    <tr class="table-row dark:even:bg-bg3 border-b hover:bg-gray-50 dark:hover:bg-bg3"
                        style="animation-delay: {{ $loop->index * 0.05 }}s">

                        <!-- SR NO -->
                        <td class="px-6 py-5 text-center font-semibold text-gray-700">

                            {{ $loop->iteration }}

                        </td>

                        <td class="px-3 py-2">
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-green-800">
                                    {{ $user->fname }} {{ $user->lname }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4  ">{{ $user->email }}</td>
                        <td class="px-6 py-4">{{ $user->mobile ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            {{ $user->role->name ?? 'N/A' }}
                        </td>
                        {{-- <td class="px-6 py-4">{{ $user->user_active ?? 'N/A' }}</td> --}}
                        <td class="px-6 py-4 ">
                            @if ($user->user_active == 1)
                            <span
                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                ACTIVE
                            </span>

                            @elseif ($user->user_active == 0)
                            <span
                                class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16">
                                INACTIVE
                            </span>
                            @else
                            N/A
                            @endif
                        </td>
                         <td class="px-4 py-3 text-center">

                            <div class="flex items-center justify-center gap-2 whitespace-nowrap">

                                <!-- VIEW -->
                                @if($isSuperAdmin || in_array('users.show', $permissions))
                                <a href="{{ route('users.show', base64_encode($user->id)) }}"
                                    class="action-btn action-view">

                                    <i class="las la-eye text-sm"></i>

                                    <span>View</span>

                                </a>
                                @endif

                                <!-- EDIT -->
                                @if($isSuperAdmin || in_array('users.edit', $permissions))
                                <a href="{{ route('users.edit', base64_encode($user->id)) }}"
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
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

        <div class="mt-3">
            <x-pagination :paginator="$users" />
        </div>

    </div>

</div>

@endsection