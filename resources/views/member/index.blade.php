@extends('layout.main')
@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-center gap-2">
                <h1 class="text-xl font-semibold">Member</h1>
                <a href="{{ route('member.create') }}"
                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white hover:bg-green-700">
                    <i class="las la-plus text-lg"></i>
                </a>
            </div>
        </div>
        <div class="box col-span-12 lg:col-span-12">
            <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                    <form
                        class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                        <input type="text" id="transaction-search" placeholder="Search"
                            class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                        <button
                            class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                            <i class="las la-search text-lg"></i>
                        </button>
                    </form>
                </div>
            </div> -->
    <x-searchbox :action="route('member.index')" />
    <div class="overflow-x-auto pb-4 lg:pb-6">
        <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
            <thead>
                <tr class="bg-secondary/5 dark:bg-bg3">
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            Sr No
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            Group
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            Member no
                        </div>
                    </th>
                    <th class="text-start !py-5 min-w-[100px]" data-sortable="false">Gender</th>
                    <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            Branch
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            Name
                        </div>
                    </th>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            F/h name
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            Senior ctz
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            Enroll date
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            Aadhar no
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            Pan no
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            Kyc status
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            Mobile no
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            Status
                        </div>
                    </th>
                    <th class="text-center !py-5" data-sortable="false">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $index => $item)
                <tr class="border-b dark:border-bg3">
                    <td class="py-3 px-6">{{ $index + 1 }}</td>

                    <td class="py-3 px-6">{{ $item->general_group }}</td>

                    <td class="py-3 px-6">{{ $item->member_info_old_member_no ?? 'N/A' }}</td>

                    <td class="py-3 px-6">{{ ucfirst($item->member_info_gender) }}</td>

                    <td class="py-3 px-6">{{ $item->branch->branch_name }}</td>

                    <td class="py-3 px-6">
                        {{ $item->member_info_first_name }}
                        {{ $item->member_info_middle_name }}
                        {{ $item->member_info_last_name }}
                    </td>

                    <td class="py-3 px-6">
                        {{ $item->member_info_father_name ?? ($item->member_info_spouse_name ?? 'N/A') }}
                    </td>

                    <td class="py-3 px-6">
                        @php
                        $age = \Carbon\Carbon::parse($item->member_info_dob)->age;
                        @endphp
                        {{ $age >= 60 ? 'Yes' : 'No' }}
                    </td>

                    <td class="py-3 px-6">
                        {{ \Carbon\Carbon::parse($item->general_enrollment_date)->format('d M Y') }}
                    </td>

                    <td class="py-3 px-6">
                        {{ $item->kyc?->member_kyc_aadhaar_no ?? 'N/A' }}
                    </td>

                    <td class="py-3 px-6">
                        {{ $item->kyc?->member_kyc_pan_no ?? 'N/A' }}
                    </td>

                    <td class="py-3 px-6">
                        @php
                        $hasKYC = $item->kyc?->member_kyc_aadhaar_no || $item->kyc?->member_kyc_pan_no;
                        @endphp
                        <span class="text-sm {{ $hasKYC ? 'text-green-600' : 'text-red-600' }}">
                            {{ $hasKYC ? 'Completed' : 'Pending' }}
                        </span>
                    </td>

                    <td class="py-3 px-6">
                        {{ $item->member_info_mobile_no }}
                    </td>

                                <td class="py-3 px-6">
                                    <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-700">
                                        Active
                                    </span>
                                </td>
                                <td class="py-2 px-6">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options', [
                                            'id' => $item->id,
                                            'viewRoute' => 'member.show',
                                            'editRoute' => 'member.edit',
                                        ])                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

        </table>
    </div>
</div>
</div>
@endsection