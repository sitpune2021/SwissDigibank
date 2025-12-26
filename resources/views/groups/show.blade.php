@extends('layout.main')

@section('content')

    <style>
        input[type="checkbox"] {
            width: 28px;
            height: 28px;
            accent-color: green;
            /* For modern browsers */
        }

        /* Fallback for browsers without accent-color support */
        input[type="checkbox"]:checked {
            background-color: green;
            border: none;
        }

        input[type="radio"] {
            width: 24px;
            height: 24px;
            accent-color: green;
            /* Modern browser support */
        }
    </style>

    <div class="main-inner">

        <div class=" flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col  gap-2">
                <div class="flex items-center gap-3">
                    <h1 class="text-lg font-semibold uppercase">
                        Collection Center - {{ $group->group_name }}
                    </h1>
                </div>
            </div>
        </div>

 @if(session('success'))
            <div class="">
                <div class="w-44 mb-5 flex justify-end">
                    <x-alert />
                </div>
                {{-- {{ session('success') }} --}}
            </div>
        @endif
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6   md-4">
            <div class="col-span-2 md:col-span-1  dark:bg-bg3 rounded-2xl ">
                <div class="box">
                    <div class="text-end">
                        {{-- @php
                        $encodedId = base64_encode($notice_board->id);
                        @endphp --}}
                        <a href="{{ route('groups.edit', base64_encode($group->id)) }}" class="btn-primary p-1">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>
                    <div class="whitespace-nowrap overflow-x-auto">
                        <table class="w-full text-lg rounded-md">
                            <tr class="border-b">
                                <th class="px-3 text-start py-2 w-1/3 uppercase">Collection Center</th>
                                <td class="px-3 py-2">
                                    {{ $group->collectionCenter->center_name ?? '-' }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-3 text-start py-2 uppercase">Group No</th>
                                <td class="px-3 py-2">{{ $group->group_no }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-3 text-start py-2 uppercase">Group Name</th>
                                <td class="px-3 py-2">{{ $group->group_name }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-3 text-start py-2 uppercase">Head Name</th>
                                <td class="px-3 py-2">{{ $group->groupHead->member_info_first_name ?? '-' }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-3 text-start py-2 uppercase">Cashier Name</th>
                                <td class="px-3 py-2">{{ $group->cashier->member_info_first_name ?? '-' }}</td>
                            </tr>


                            <tr class="border-b">
                                <th class="px-3 text-start py-2 uppercase">Active</th>
                                <td class="px-3 py-2">
                                    @if($group->is_active)
                                        <span
                                            class="block w-28 rounded-full bg-primary/20 text-primary text-center py-2 text-xs">Yes</span>
                                    @else
                                        <span
                                            class="block w-28 rounded-full bg-error/20 text-error text-center py-2 text-xs">No</span>
                                    @endif
                                </td>
                            </tr>
                        </table>




                    </div>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1  dark:bg-bg3 rounded-2xl ">
                <div class="box">
                    <div class="bg-secondary/5 py-3 px-6 rounded-10 text-lg  font-bold">
                        COMMENTS
                    </div>

                    <div class="pb-4 overflow-x-auto mt-5 lg:pb-6">
                        <table class="w-full whitespace-nowrap select-all-table" id="">

                            <thead>
                                <tr class="bg-secondary/5 dark:bg-bg3">
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-start gap-1">
                                            COMMENT
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-start gap-1">
                                            COMMENT BY
                                        </div>
                                    </th>

                                    <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                        <div class="flex items-start gap-1">
                                            DATE
                                        </div>
                                    </th>

                                </tr>
                            </thead>

                            <tbody>
                                @forelse($comments as $comment)
                                    <tr class="border-b">
                                        <!-- Comment -->
                                        <td class="text-left !py-5 px-6 min-w-[100px] cursor-pointer">
                                            {{ $comment->comment }}
                                        </td>

                                        <!-- Comment By -->
                                        <td class="text-left !py-5 px-6 min-w-[100px] cursor-pointer">
                                            {{ $comment->user->name ?? 'N/A' }}
                                        </td>

                                        <!-- Date -->
                                        <td class="text-left !py-5 px-6 min-w-[130px] cursor-pointer">
                                            {{ $comment->created_at->format('d-m-Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-6 text-gray-500">
                                            No comments found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('groups.comments.index', base64_encode($group->id))  }}"
                            class="btn-primary rounded-10 py-2 px-1 text-sm cursor-pointer">ADD COMMENT</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="box mt-5 w-full">
            <div class="pb-4 overflow-x-auto lg:pb-6">
                <table class="w-full whitespace-nowrap select-all-table" id="">

                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    MEMBER NO.
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    BRANCH
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    MEMBER NAME
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    ENROLLMENT DATE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    MOBILE NO
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-start gap-1">
                                    STATUS
                                </div>
                            </th>

                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($group->members as $member)
                            <tr class="border-b">

                                {{-- MEMBER NO --}}
                                <td class="text-left !py-5 px-6 min-w-[100px]">
                                    <a href="#" class="text-primary">
                                        {{ $member->member_no ?? '-' }}
                                    </a>
                                </td>

                                {{-- BRANCH --}}
                                <td class="text-left !py-5 px-6 min-w-[100px]">
                                    {{ $member->branch->branch_name ?? '-' }}
                                </td>

                                {{-- MEMBER NAME --}}
                                <td class="text-left !py-5 px-6 min-w-[130px]">
                                    {{ $member->member_info_first_name }}
                                </td>

                                {{-- ENROLLMENT DATE --}}
                                <td class="text-left !py-5 px-6 min-w-[130px]">
                                    {{ \Carbon\Carbon::parse($member->general_enrollment_date)->format('d-m-Y') }}


                                </td>

                                {{-- MOBILE NO --}}
                                <td class="text-left !py-5 px-6 min-w-[130px]">
                                    {{ $member->member_info_mobile_no ?? '-' }}
                                </td>

                                {{-- STATUS --}}
                                <td class="text-left !py-5 px-6 min-w-[130px]">
                                    {{-- @if($member->is_active)
                                    <span class="text-primary">Active</span>
                                    @else
                                    <span class="text-error">Inactive</span>
                                    @endif --}}
                                    (temporary static)
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-500">
                                    No members found in this group
                                </td>
                            </tr>
                        @endforelse
                    </tbody>


                </table>
            </div>
        </div>

    </div>
    </div>






@endsection