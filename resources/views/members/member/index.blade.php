@extends('layout.main')
@section('page-title', 'MEMBERS')
@section('action-button')
<a class="btn-primary" href="{{ route('member.create') }}">
    ADD
</a>
@endsection
@section('content')

    <div class="overflow-x-auto pb-4 lg:pb-6">
        <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
            <thead>
                <tr class="bg-secondary/5 dark:bg-bg3">
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            GROUP
                        </div>
                    </th>
                    <th class="text-start text-center !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1 text-center">
                            MEMBER NO
                        </div>
                    </th>
                    <th class="text-start text-center !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1 text-center">
                            BRANCH
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            NAME
                        </div>
                    </th>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            F/H NAME
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            SENIOR CTZ
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            ENROLL DATE
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            AADHAR NO
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            PAN NO
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            KYC STATUS
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            MOBILE NO
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            STATUS
                        </div>
                    </th>
                    <th class="text-center !py-5" data-sortable="false">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $index => $item)
                <tr class="border-b dark:border-bg3">
                    <td class="py-3 px-6">{{ $item->general_group }}</td>

                    <td class="py-3 px-6 text-center ">
                        <a href="{{ $item?->id ? route('member.show', $item->id) : '#' }}" class="text-primary hover:underline">
                            {{ $item->id ?? 'N/A' }}
                        </a>
                    </td>
                    <td class="py-3 px-6">{{ $item->branch->branch_name }}</td>

                    <td class="py-3 px-6">
                        {{ $item->member_info_first_name }}
                        {{ $item->member_info_last_name }}
                    </td>

                    <td class="py-3 px-6">
                        {{ $item->member_info_father_name ?? ($item->member_info_spouse_name ?? 'N/A') }}
                    </td>

                    <td class="py-3 px-6">
                        @php
                        $age = \Carbon\Carbon::parse($item->member_info_dob)->age;
                        @endphp

                        @if ($age >= 60)
                        <span
                            class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            Yes
                        </span>
                        @else
                        <span
                            class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            No
                        </span>
                        @endif
                    </td>

                    <td class="py-3 px-6">
                        {{ \Carbon\Carbon::parse($item->general_enrollment_date)->format('d-m-Y') }}
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
                        <span class="text-sm px-2 py-1 rounded bg-green-100 text-green-700">
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
    <!-- </div> -->
    <x-pagination :paginator="$members" />
</div>
@endsection
