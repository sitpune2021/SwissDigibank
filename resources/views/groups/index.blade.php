@extends('layout.main')
@extends('layout.tablestyle')

@section('page-title')

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 w-full">

    <!-- LEFT SIDE -->
    <div class="flex items-center gap-3 min-w-0">

        <!-- PREMIUM ICON -->
        <div
            class="relative overflow-hidden
            w-11 h-11 sm:w-12 sm:h-12
            rounded-2xl flex items-center justify-center shrink-0"

            style="
                background: linear-gradient(135deg,#06b6d4,#2563eb);
                box-shadow:
                    0 10px 25px rgba(37,99,235,.30),
                    inset 0 1px 0 rgba(255,255,255,.35);
            "
        >

            <!-- SHINE -->
            <div
                class="absolute inset-0"
                style="
                    background:
                    linear-gradient(
                        135deg,
                        rgba(255,255,255,.28),
                        transparent 45%
                    );
                "
            ></div>

            <i class="las la-users text-white text-xl sm:text-2xl relative z-10"></i>

        </div>

        <!-- TITLE -->
        <div class="min-w-0">

            <h2 class="text-lg sm:text-xl lg:text-2xl
                font-extrabold uppercase tracking-wide
                text-gray-800 dark:text-white leading-tight break-words">

                Groups Management

            </h2>

            <p class="text-[11px] sm:text-sm text-gray-500 dark:text-gray-400 font-medium mt-1">

                Manage groups, members & operations

            </p>

        </div>

    </div>

    <!-- RIGHT SIDE BADGE -->
    <div class="hidden md:flex items-center gap-2
        px-4 py-2 rounded-xl
        bg-gradient-to-r from-slate-100 to-slate-50
        border border-slate-200 shadow-sm shrink-0">

        <span class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></span>

        <span class="text-xs font-bold uppercase tracking-wider text-slate-600">

            Banking Panel

        </span>

    </div>

</div>

@endsection

@section('action-button')

<a href="{{ route('groups.create') }}"
    class="inline-flex items-center gap-2
    px-4 sm:px-5 py-2.5 rounded-xl
    text-xs sm:text-sm font-bold uppercase tracking-wide
    shadow-lg hover:scale-105 transition-all duration-300"
    style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">

    <span>Add Group</span>

</a>

@endsection

@section('content')

    <div class="box col-span-12 lg:col-span-6 bank-page-animate">

        <x-searchbox />

        <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
            <x-alert />
        </div>


        <div class="overflow-x-auto pb-4 lg:pb-6 table-premium">

            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">

                <thead class="bg-gradient-to-r from-violet-50 via-white to-blue-50 border-b border-gray-200">

                    <tr class="text-[11px] sm:text-xs uppercase tracking-wider font-bold">

                        <!-- SR NO -->
                        <th class="px-3 sm:px-5 py-4 text-center min-w-[90px]">

                            <div class="flex items-center justify-center gap-2">

                                <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                    <i class="las la-hashtag text-sm sm:text-base text-black"></i>
                                </div>

                                <span class="text-black whitespace-nowrap">SR NO</span>

                            </div>

                        </th>

                        <!-- CENTER -->
                        <th class="px-4 sm:px-5 py-4 text-left min-w-[140px]">

                            <div class="flex items-center gap-2">

                                <div class="
                                    w-7 h-7
                                    rounded-lg
                                    bg-violet-100
                                    flex items-center justify-center
                                    shrink-0
                                ">

                                    <i class="las la-building text-violet-700 text-sm"></i>

                                </div>

                                <span class="text-gray-800 whitespace-nowrap">

                                    Center

                                </span>

                            </div>

                        </th>

                        <!-- GROUP NO -->
                        <th class="px-4 sm:px-5 py-4 text-center min-w-[110px]">

                            <div class="flex items-center justify-center gap-2">

                                <div class="
                                    w-7 h-7
                                    rounded-lg
                                    bg-blue-100
                                    flex items-center justify-center
                                    shrink-0
                                ">

                                    <i class="las la-hashtag text-blue-700 text-sm"></i>

                                </div>

                                <span class="text-gray-800 whitespace-nowrap">

                                    G. No

                                </span>

                            </div>

                        </th>

                        <!-- GROUP NAME -->
                        <th class="px-4 sm:px-5 py-4 text-center min-w-[150px]">

                            <div class="flex items-center justify-center gap-2">

                                <div class="
                                    w-7 h-7
                                    rounded-lg
                                    bg-cyan-100
                                    flex items-center justify-center
                                    shrink-0
                                ">

                                    <i class="las la-layer-group text-cyan-700 text-sm"></i>

                                </div>

                                <span class="text-gray-800 whitespace-nowrap">

                                    G. Name

                                </span>

                            </div>

                        </th>

                        <!-- GROUP HEAD -->
                        <th class="px-4 sm:px-5 py-4 text-center min-w-[140px]">

                            <div class="flex items-center justify-center gap-2">

                                <div class="
                                    w-7 h-7
                                    rounded-lg
                                    bg-orange-100
                                    flex items-center justify-center
                                    shrink-0
                                ">

                                    <i class="las la-user-tie text-orange-700 text-sm"></i>

                                </div>

                                <span class="text-gray-800 whitespace-nowrap">

                                    G. Head

                                </span>

                            </div>

                        </th>

                        <!-- OPEN DATE -->
                        <th class="px-4 sm:px-5 py-4 text-center min-w-[130px]">

                            <div class="flex items-center justify-center gap-2">

                                <div class="
                                    w-7 h-7
                                    rounded-lg
                                    bg-pink-100
                                    flex items-center justify-center
                                    shrink-0
                                ">

                                    <i class="las la-calendar text-pink-700 text-sm"></i>

                                </div>

                                <span class="text-gray-800 whitespace-nowrap">

                                    Open Date

                                </span>

                            </div>

                        </th>

                        <!-- MEMBER COUNT -->
                        <th class="px-4 sm:px-5 py-4 text-center min-w-[150px]">

                            <div class="flex items-center justify-center gap-2">

                                <div class="
                                    w-7 h-7
                                    rounded-lg
                                    bg-green-100
                                    flex items-center justify-center
                                    shrink-0
                                ">

                                    <i class="las la-users text-green-700 text-sm"></i>

                                </div>

                                <span class="text-gray-800 whitespace-nowrap">

                                    Members

                                </span>

                            </div>

                        </th>

                        <!-- STATUS -->
                        <th class="px-4 sm:px-5 py-4 text-center min-w-[120px]">

                            <div class="flex items-center justify-center gap-2">

                                <div class="
                                    w-7 h-7
                                    rounded-lg
                                    bg-emerald-100
                                    flex items-center justify-center
                                    shrink-0
                                ">

                                    <i class="las la-toggle-on text-emerald-700 text-sm"></i>

                                </div>

                                <span class="text-gray-800 whitespace-nowrap">

                                    Status

                                </span>

                            </div>

                        </th>

                        <!-- ACTIONS -->
                        <th class="px-4 sm:px-5 py-4 text-center min-w-[130px]">

                            <div class="flex items-center justify-center gap-2">

                                <div class="
                                    w-7 h-7
                                    rounded-lg
                                    bg-slate-200
                                    flex items-center justify-center
                                    shrink-0
                                ">

                                    <i class="las la-cog text-slate-700 text-sm"></i>

                                </div>

                                <span class="text-gray-800 whitespace-nowrap">

                                    Actions

                                </span>

                            </div>

                        </th>

                    </tr>

                </thead>

                <tbody>
                    @forelse ($groups as $group)
                        <tr class="table-row border-b border-gray-100"
                            style="animation-delay:{{ $loop->index * 0.05 }}s">

                            <!-- SR NO -->
                            <td class="px-6 py-5 text-center font-semibold text-gray-700">

                                {{ $loop->iteration }}
                            </td>

                            {{-- Center --}}
                            <td class="text-start !py-5 px-6">
                                {{ $group->collectionCenter->center_name ?? '-' }}
                            </td>

                            {{-- Group No --}}
                            <td class="text-start !py-5 px-6">
                                {{ $group->group_no }}
                            </td>

                            {{-- Group Name --}}
                            <td class="text-start !py-5 px-6">
                                {{ $group->group_name }}
                            </td>

                            {{-- Group Head --}}
                            <td class="text-start !py-5 px-6">
                                {{ $group->groupHead->member_info_first_name ?? '-' }}
                            </td>

                            {{-- Open Date --}}
                            <td class="text-start !py-5 px-6">
                                {{ \Carbon\Carbon::parse($group->open_date)->format('d-m-Y') }}
                            </td>

                            {{-- Member Count --}}
                            <td class="text-start !py-5 px-6 font-semibold">
                                {{ $group->members_count }}
                            </td>

                            {{-- Active --}}
                            <td class="text-start !py-5 px-6">
                                @if($group->is_active)
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary">
                                        Yes
                                    </span>
                                @else
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error">
                                        No
                                    </span>
                                @endif
                            </td>
                            <!-- ACTION -->
                            <td class="text-center px-4 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    <!-- VIEW -->
                                    <a href="{{ route('groups.show', base64_encode($group->id)) }}"
                                        class="action-btn action-view">

                                        <i class="las la-eye"></i>
                                        <span>VIEW</span>

                                    </a>

                                    <!-- EDIT -->
                                    <a href="{{ route('groups.edit', base64_encode($group->id)) }}"
                                        class="action-btn action-edit">

                                        <i class="las la-edit"></i>
                                        <span>EDIT</span>

                                    </a>

                                </div>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-6 text-gray-500">
                                No groups found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

        <div class="mt-4">
            <x-pagination :paginator="$groups"/>
        </div>

    </div>


@endsection