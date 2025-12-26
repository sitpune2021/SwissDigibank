@extends('layout.main')
@section('content')
    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-lg   uppercase font-semibold">
                Groups
            </h3>
            <a href="{{ route('groups.create') }}" class="btn-primary">Add</a>
        </div>
        @if(session('success'))
            <div class="">
                <div class="w-44 mb-5 flex justify-end">
                    <x-alert />
                </div>
                {{-- {{ session('success') }} --}}
            </div>
        @endif
        <div class="col-span-12 box lg:col-span-12">
            <div class="pb-4 overflow-x-auto lg:pb-6">

                <table class="w-full whitespace-nowrap select-all-table" id="">

                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    CENTER
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    G. NO
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    G. NAME
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    G. HEAD
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    OPEN DATE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    MEMBER COUNT
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    ACTIVE
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    ACTIONS
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($groups as $group)
                            <tr class="border-b">
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

                                {{-- Actions --}}
                                <td class="text-start !py-5 px-6">
                                    <div class="relative inline-block">
                                        <i class="las la-ellipsis-v cursor-pointer popover-button"></i>
                                        <ul class="horiz-option popover-content">
                                            <li>
                                                <a href="{{ route('groups.show', base64_encode($group->id)) }}"
                                                    class="single-option uppercase">View</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('groups.edit', base64_encode($group->id)) }}"
                                                    class="single-option uppercase">Edit</a>
                                            </li>
                                        </ul>
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
        </div>


@endsection