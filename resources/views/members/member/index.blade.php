@extends('layout.main')
@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3 lg:mb-5">
            <h4 class="h2">Member</h4>
            <a class="btn-primary" href="{{ route('member.create') }}">
                <i class=" text-base md:text-lg"></i>
                Add
            </a>
        </div>
        <div class="box col-span-12 lg:col-span-12">
            <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2 mb-4">
                    <label for="perPage" class="text-sm">Show</label>
                    <select name="perPage" id="perPage" onchange="this.form.submit()"
                        class="border rounded px-2 py-1 text-sm">
                        <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span class="text-sm">entries</span>
                </form>
                <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                    <form method="GET" action="{{ route('member.index') }}"
                        class="relative flex items-center gap-2 bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xl:max-w-[319px]">
                        <input type="text" id="transaction-search" name="search" placeholder="Search"
                            value="{{ request('search') }}"
                            class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                        <button type="submit"
                            class="w-7 h-7 bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                            <i class="las la-search text-lg"></i>
                        </button>
                        @if (request('search'))
                            <a href="{{ route('member.index') }}"
                                class="w-7 h-7 bg-grey-500 hover:bg-grey-900 text-dark rounded-full flex items-center justify-center transition duration-200"
                                title="Clear Search">
                                <i class="las la-times text-lg"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
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
                                        ]) </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
