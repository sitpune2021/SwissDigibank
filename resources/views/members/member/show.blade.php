@extends('layout.main')
@section('page-title',
    isset($member)
    ? $member->member_info_first_name . ' ' . $member->member_info_last_name
    : 'ADD
    CUSTOMER')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- FancyBox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox.css" />
    <!-- FancyBox JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox.umd.js"></script>
    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-2 lg:mb-2 lg:pb-2" style="flex-direction: row-reverse;">
        <x-alert />
    </div>
    <div class="flex flex-wrap gap-3 mb-3 text-center">
        {{-- <a href="{{ route('member.shareholding', $member->id) }}"
        class="btn-info rounded-md px-2 py-1 text-white text-sm bg-blue-500 hover:bg-blue-600">
        SHARE HOLDINGS
    </a> --}}
        @if ($member->share_allocated == 1)
            <a href="{{ route('member.shareholding', $member->id) }}" class="text-sm rounded-10 px-2 py-2 btn-secondary">
                SHARE HOLDINGS
            </a>
        @endif

        <a href="{{ url('/share/allocate') }}?member_id={{ $member->id }}"
            class="text-sm rounded-10 px-2 py-2 btn-primary">
            ALLOCATE SHARES
        </a>

        <a href="{{ route('members.transactions.share-amount.store', $member->id) }}"
            class="btn-warning text-sm rounded-10 px-2 py-2 ">ADD SHARE
            AMOUNT</a>


        <a href="{{ route('members.transactions', $member->id) }}" class="text-sm rounded-10 px-2 py-2 btn-secondary">
            VIEW
            TRANSACTIONS
        </a>


        <div x-data="{ open: false }" class="relative inline-block">

            <a @click="open = !open" class="toggle-btn text-sm cursor-pointer rounded-10 px-2 py-2 btn-primary"
                href="javascript:void(0);">
                <span class="text-sm">DEBIT OTHER CHARGES</span>
                <i class="las la-angle-down text-sm toggle-icon"></i>
            </a>

            <!-- Dropdown -->
            <div x-show="open" @click.outside="open = false"
                class="absolute mt-2 w-48 bg-white border border-gray-300 rounded-lg shadow-lg z-50">
                <ul class="py-2 whitespace-nowrap">
                    <li>
                        <a href="{{ route('members.other-charges.list', ['id' => $member->id]) }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 border-b text-sm">
                            OTHER CHARGES LIST
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('members.other-charges', ['id' => $member->id]) }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 border-b text-sm ">
                            DEBIT OTHER CHARGES
                        </a>
                    </li>
                    <li>

                        <a href="{{ $charge && $charge->member_id && $charge->id ? route('members.other-charges.clearDue.form', ['id' => $charge->member_id, 'chargeId' => $charge->id]) : '#' }}"
                            class="{{ !$charge || !$charge->member_id || !$charge->id ? 'text-black cursor-not-allowed' : '' }} block px-4 py-2 text-sm text-black hover:bg-gray-100 uppercase">
                            {{-- href="{{ route('members.other-charges.clearDue.form', ['id' => $charge->member_id ?? '',
                            'chargeId' => $charge->id ?? '']) }}"> --}}
                            Clear Due

                        </a>
                    </li>
                </ul>
            </div>
           
        </div>

        <a title="DOWNLOAD 15G/ 15H"
            href="{{ isset($member) ? route('form15g15h.download', ['member_id' => $member->id]) : '#' }}"
            class="text-sm rounded-10 px-2 py-2 btn-secondary">
            <i class="las la-print"></i> DOWNLOAD 15G/ 15H
        </a>

        <a href="{{ isset($member) ? route('form15g15h.create', ['member_id' => $member->id, 'type' => 'member']) : '#' }}"
            class="text-sm rounded-10 px-2 py-2 btn-warning">
            <i class="las la-plus" aria-hidden="true"></i> UPLOAD 15G/ 15H
        </a>
        <a href="#" class="text-sm rounded-10 px-2 py-2 btn-error cursor-pointer">REMOVE CUSTOMER</a>

        <a href="{{ route('members.application_form', $member->id) }}" target="_blank"
            class="text-sm rounded-10 px-2 py-2 btn-primary">
            <i class="las la-print"></i> APPLICATION FORM
        </a>
        <a class="text-sm rounded-10 px-2 py-2 cursor-pointer btn-secondary">SHOW AUDIT TRAIL</a>
    </div>
    <div class="grid grid-cols-12 gap-4 xxl:gap-6">
        <div class="col-span-12 lg:col-span-6 overflow-x-hidden">

            <div class="col-span-12 box overflow-x-hidden">
                <div class="text-end">
                    <a href=" {{ route('member.edit', $member->id) }}" class="btn-primary  p-1">
                        <i class="las la-pencil-alt"></i>
                    </a>
                </div>
                <table class="w-full overflow-x-auto whitespace-nowrap text-sm">
                    <tbody>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Membership Type</span>
                                </div>
                            </th>
                            <td class="p-2">

                                <div><span class=" uppercase ">{{ $member->membership_type }}</span></div>
                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Create on</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>Admin App</span></div>
                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Created by</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ auth()->user()->name }}</span></div>
                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Status</span></div>
                            </th>
                            <td>
                                <span
                                    class="block w-20 rounded-[30px] border border-n30 bg-primary/20 py-1 text-center text-[10px] text-primary dark:border-n500 uppercase  dark:bg-bg3 xxl:w-19">
                                    ACTIVE
                                </span>
                            </td>
                        </tr>

                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Branch</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->branch->branch_name ?? '' }}</span></div>
                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Advisor/ Staff</span>
                                </div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->general_advisor_staff }}</span></div>
                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Old Customer No</span>
                                </div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_old_member_no }}</span></div>
                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Enrollment Date</span>
                                </div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>{{ $member->general_enrollment_date
                                        ? \Carbon\Carbon::parse($member->general_enrollment_date)->format('d-m-Y')
                                        : 'N/A' }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">

                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Name</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>
                                        {{ $member->member_info_title .
                                            ' ' .
                                            $member->member_info_first_name .
                                            ($member->member_info_middle_name ? ' ' . $member->member_info_middle_name : '') .
                                            ' ' .
                                            $member->member_info_last_name }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>DOB</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>
                                        {{ $member->member_info_dob ? \Carbon\Carbon::parse($member->member_info_dob)->format('d-m-Y') : 'N/A' }}
                                    </span>
                                </div>

                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Age</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>{{ \Carbon\Carbon::parse($member->member_info_dob)->age }} years</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Senior Citizen</span>
                                </div>
                            </th>

                            @php
                                $dob = \Carbon\Carbon::parse($member->member_info_dob);
                                $age = $dob->age;
                            @endphp

                            <td class="p-2">
                                @if ($age >= 60)
                                    <span
                                        class="block w-20 rounded-[30px] border border-n30 bg-primary/20 py-1 text-center text-[10px] text-primary dark:border-n500 dark:bg-bg3 xxl:w-19">
                                        Yes
                                    </span>
                                @else
                                    <span
                                        class="block w-20 rounded-[30px] border border-n30 bg-error/20 py-1 text-center text-[10px] text-error dark:border-n500 dark:bg-bg3 xxl:w-19">
                                        No
                                    </span>
                                @endif
                            </td>


                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Gender</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_gender }}</span></div>
                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Folio No.</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->folio_no }}</span></div>
                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Father Name</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_middle_name }}</span></div>
                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Mother Name</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_mother_name }}</span></div>
                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Marital Status</span>
                                </div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_marital_status }}</span></div>
                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Religion</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->religion?->name ?? 'N/A' }}</span></div>
                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Qualification</span>
                                </div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_qualification }}</span></div>
                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Husband/ Wife Name
                                    </span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_spouse_name }}</span></div>
                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Husband/ Wife
                                        D.O.B</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_spouse_dob }}</span></div>
                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Occupation</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_occupation }}</span></div>
                            </td>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Monthly Income</span>
                                </div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_monthly_income }}</span></div>
                            </td>
                        </tr>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Collection Time</span>
                                </div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_collection_time }}</span></div>
                            </td>
                        </tr>
                        </tr>
                        <tr class="border-b dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center font-semibold gap-3 uppercase"><span>Form 15G/ 15H
                                        Uploaded<br>(FY 2025 -
                                        2026)</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span
                                        class="block w-20 py-2 text-xs rounded-[30px] border text-center border-n30 {{ $member->form15G15H->count() >= 1
                                            ? 'border-white bg-primary/20 text-primary'
                                            : 'border-white bg-error/20 text-error' }}">
                                        {{ $member->form15G15H->count() >= 1 ? 'Yes' : 'No' }}</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- Member KYC Info --}}
            <!-- <div x-data="{ open: true }" class="mt-4 rounded-md shadow">

                                                                                                                                <div class="flex items-center justify-between px-4 py-2 text-white bg-red-500 rounded-t cursor-pointer"
                                                                                                                                    @click="open = !open">
                                                                                                                                    <span class="font-semibold uppercase">Member KYC Info</span>
                                                                                                                                    <i :class="open ?
                                                                                                                                        'las la-minus' :
                                                                                                                                        'lad la-plus'"></i>
                                                                                                                                </div>

                                                                                                                                <div x-show="open" x-transition class="bg-white rounded-md">
                                                                                                                                    <table class="w-full text-sm">
                                                                                                                                        <tbody>
                                                                                                                                            <tr class="border-b">
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">Aadhaar No.</th>
                                                                                                                                                <td class="flex items-center justify-between px-6 py-2" text-start>
                                                                                                                                                    <span>{{ $member->kyc?->member_kyc_aadhaar_no ?? '' }}</span>
                                                                                                                                                    <i class="text-green-600 fa fa-check-circle"></i>
                                                                                                                                                </td>
                                                                                                                                            <tr class="border-b">
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">Voter ID No.</th>
                                                                                                                                                <td class="flex items-center justify-between px-6 py-2" text-start>
                                                                                                                                                    {{ $member->kyc?->member_kyc_voter_id_no ?? '' }}
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                            <tr class="border-b">
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">Pan No.</th>
                                                                                                                                                <td class="flex items-center justify-between px-6 py-2" text-start>
                                                                                                                                                    <span>{{ $member->kyc?->member_kyc_pan_no ?? '' }}</span>
                                                                                                                                                    <i class="text-green-600 fa fa-check-circle"></i>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                            <tr class="border-b">
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">Ration Card No.</th>
                                                                                                                                                <td class="flex items-center justify-between px-6 py-2" text-start>
                                                                                                                                                    <span>{{ $member->kyc?->member_kyc_ration_card_no ?? '' }}</span>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                            <tr class="border-b">
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">Meter No.</th>
                                                                                                                                                <td class="px-6 py-2">{{ $member->kyc?->member_kyc_meter_no ?? '' }}</td>
                                                                                                                                            </tr>
                                                                                                                                            <tr class="border-b">
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">CI No.</th>
                                                                                                                                                <td class="px-6 py-2">{{ $member->kyc?->member_kyc_ci_no ?? '' }}</td>
                                                                                                                                            </tr>
                                                                                                                                            <tr class="border-b">
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">CI Relation</th>
                                                                                                                                                <td class="px-6 py-2">{{ $member->kyc?->member_kyc_ci_relation ?? '' }}</td>
                                                                                                                                            </tr>
                                                                                                                                            <tr class="border-b">
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">DL No</th>
                                                                                                                                                <td class="px-6 py-2">{{ $member->kyc?->member_kyc_dl_no ?? '' }}</td>
                                                                                                                                            </tr>
                                                                                                                                            <tr class="border-b">
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">CKYC No</th>
                                                                                                                                                {{-- <td class="px-6 py-2">{{$member->kyc?->member_kyc_ci_no??''}}</td> --}}
                                                                                                                                            </tr>
                                                                                                                                            <tr>
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">CKYC Updated At</th>
                                                                                                                                                <td class="px-6 py-2">-</td>
                                                                                                                                            </tr>
                                                                                                                                        </tbody>
                                                                                                                                    </table>
                                                                                                                                </div>
                                                                                                                            </div> -->
            {{-- Member Nominee Info --}}
            <!-- <div x-data="{ open: true }" class="mt-4 rounded shadow">
                                                                                                                                <div class="flex items-center justify-between px-4 py-2 text-white bg-blue-500 rounded-t cursor-pointer"
                                                                                                                                    @click="open = !open">
                                                                                                                                    <span class="font-semibold uppercase">Member Nominee Info</span>
                                                                                                                                    <i :class="open ?
                                                                                                                                        'las la-minus' :
                                                                                                                                        'lad la-plus'"></i>
                                                                                                                                </div>

                                                                                                                                <div x-show="open" x-transition class="bg-white">
                                                                                                                                    <table class="w-full text-sm">
                                                                                                                                        <tbody>
                                                                                                                                            <tr class="border-b">
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">Name</th>
                                                                                                                                                <td class="flex items-center justify-between px-6 py-2">
                                                                                                                                                    <span>{{ $member->kyc?->nominee_name ?? '' }}</span>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                            <tr class="border-b">
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">DOB</th>
                                                                                                                                                <td class="px-6 py-2"><span>{{ $member->kyc?->nominee_dob ?? '' }}</span>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                            <tr class="border-b">
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">Gender</th>
                                                                                                                                                <td class="flex items-center justify-between px-6 py-2">
                                                                                                                                                    <span>{{ $member->kyc?->nominee_gender ?? '' }}</span>

                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                            <tr class="border-b">
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">Relation</th>
                                                                                                                                                <td class="px-6 py-2">
                                                                                                                                                    <span>{{ $member->kyc?->nominee_relation ?? '' }}</span>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                            <tr class="border-b">
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">Mobile No.</th>
                                                                                                                                                <td class="px-6 py-2">
                                                                                                                                                    <span>{{ $member->kyc?->nominee_mobile_no ?? '' }}</span>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                            <tr class="border-b">
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">Aadhaar No.</th>
                                                                                                                                                <td class="px-6 py-2"><span>{{ $member->kyc?->nominee_aadhaar_no ?? '' }}</span>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                            <tr class="border-b">
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">Voter ID No. </th>
                                                                                                                                                <td class="px-6 py-2"><span>{{ $member->kyc?->nominee_voter_id_no ?? '' }}</span>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                            <tr class="border-b">
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">Pan No.</th>
                                                                                                                                                <td class="px-6 py-2">
                                                                                                                                                    <span>{{ $member->kyc?->nominee_pan_no ?? '' }}</span>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                            <tr class="border-b">
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">Address</th>
                                                                                                                                                <td class="px-6 py-2"><span>{{ $member->kyc?->nominee_address ?? '' }}</span>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                            <tr>
                                                                                                                                                <th class="px-6 py-2 font-semibold text-start">Ration Card No.</th>
                                                                                                                                                <td class="px-6 py-2"><span>{{ $member->kyc?->nominee_ration_card_no ?? '' }}</span>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                        </tbody>
                                                                                                                                    </table>
                                                                                                                                </div>
                                                                                                                            </div> -->

            <div x-data="{ open: true }" class="mt-4 box rounded-10 shadow">
                <!-- Header -->
                <div class="flex items-center justify-between px-4 py-3   bg-secondary/5 rounded-10 cursor-pointer"
                    @click="open = !open">
                    <span class="font-semibold text-lg uppercase">Member KYC Info</span>
                    <i :class="open ? 'las la-minus' : 'lad la-plus'"></i>
                </div>
                <!-- Content -->
                <div x-show="open" x-transition class="bg-white rounded-md">
                    <table class="w-full text-sm">
                        <tbody>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start text-lg uppercase">
                                    <span class=""> Aadhaar No.</span>
                                </th>
                                <td class="flex items-center justify-between  px-6 py-2" text-start>
                                    <span class="">{{ $member->kyc?->member_kyc_aadhaar_no ?? '' }}</span>
                                    <i class="text-green-600 fa fa-check-circle"></i>
                                </td>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>Voter ID No.</span>
                                </th>
                                <td class="flex items-center justify-between px-6 py-2" text-start>
                                    {{ $member->kyc?->member_kyc_voter_id_no ?? '' }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>Pan No.</span>
                                </th>
                                <td class="flex items-center justify-between px-6 py-2" text-start>
                                    <span>{{ $member->kyc?->member_kyc_pan_no ?? '' }}</span>
                                    <i class="text-green-600 fa fa-check-circle"></i>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>Ration Card No.</span>
                                </th>
                                <td class="flex items-center justify-between px-6 py-2" text-start>
                                    <span>{{ $member->kyc?->member_kyc_ration_card_no ?? '' }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>Meter No.</span>
                                </th>
                                <td class="px-6 py-2">{{ $member->kyc?->member_kyc_meter_no ?? '' }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>CI No.</span>
                                </th>
                                <td class="px-6 py-2">{{ $member->kyc?->member_kyc_ci_no ?? '' }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>CI Relation</span>
                                </th>
                                <td class="px-6 py-2">{{ $member->kyc?->member_kyc_ci_relation ?? '' }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>DL No</span>
                                </th>
                                <td class="px-6 py-2">{{ $member->kyc?->member_kyc_dl_no ?? '' }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>CKYC No</span>
                                </th>
                                {{-- <td class="px-6 py-2">{{$member->kyc?->member_kyc_ci_no??''}}</td> --}}
                            </tr>
                            <tr>
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>CKYC Updated At</span>
                                </th>
                                <td class="px-6 py-2">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Member Nominee Info --}}
            <div x-data="{ open: true }" class="mt-4 box rounded-10 shadow">
                <div class="flex items-center justify-between px-4 py-3  bg-secondary/5  rounded-10  cursor-pointer"
                    @click="open = !open">
                    <span class="font-semibold uppercase text-lg">Customer Nominee Info</span>
                    <i :class="open ? 'las la-minus' : 'lad la-plus'"></i>
                </div>

                <div x-show="open" x-transition class="bg-white">
                    <table class="w-full text-sm">
                        <tbody>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>Name</span>
                                </th>
                                <td class="flex items-center justify-between px-6 py-2">
                                    <span>{{ $member->kyc?->nominee_name ?? '' }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>DOB</span>
                                </th>
                                <td class="px-6 py-2"><span>{{ $member->kyc?->nominee_dob ?? '' }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>Gender</span>
                                </th>
                                <td class="flex items-center justify-between px-6 py-2">
                                    <span>{{ $member->kyc?->nominee_gender ?? '' }}</span>

                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>Relation</span>
                                </th>
                                <td class="px-6 py-2">
                                    <span>{{ $member->kyc?->nominee_relation ?? '' }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>Mobile No.</span>
                                </th>
                                <td class="px-6 py-2">
                                    <span>{{ $member->kyc?->nominee_mobile_no ?? '' }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>Aadhaar No.</span>
                                </th>
                                <td class="px-6 py-2"><span>{{ $member->kyc?->nominee_aadhaar_no ?? '' }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>Voter ID No.</span>
                                </th>
                                <td class="px-6 py-2"><span>{{ $member->kyc?->nominee_voter_id_no ?? '' }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>Pan No.</span>
                                </th>
                                <td class="px-6 py-2">
                                    <span>{{ $member->kyc?->nominee_pan_no ?? '' }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>
                                        Address
                                    </span>
                                </th>
                                <td class="px-6 py-2"><span>{{ $member->kyc?->nominee_address ?? '' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>Ration Card No.</span>
                                </th>
                                <td class="px-6 py-2"><span>{{ $member->kyc?->nominee_ration_card_no ?? '' }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            @php
                // Ensure $documents is always defined as a Collection
                $documents = $promoter->documents ?? collect();
            @endphp

            <div x-data="{ open: true }" class="mt-4 rounded-10 box shadow">
                <!-- Header -->
                <div class="flex items-center justify-between px-4 py-3 text-lg  bg-secondary/5 rounded-10 cursor-pointer"
                    @click="open = !open">
                    <span class="font-semibold uppercase">Documents</span>
                    <div class="flex gap-2 items-center space-x-2">
                        {{-- Link to document edit page --}}
                        <a href="{{ route('member.document', $member->id) }}" class="btn-primary p-1">
                            <i class="cursor-pointer las la-pencil-alt "></i>
                        </a>
                        {{-- Toggle button for showing/hiding sections --}}
                        <i :class="open ? 'las la-minus' : 'lad la-plus'"></i>
                    </div>
                </div>

                <!-- Content -->
                <div x-show="open" x-transition class="bg-white">
                    <table class="w-full text-sm ">
                        <tbody>
                            {{-- Photo --}}
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>Photo (Photo)</span>
                                </th>
                                <td class="px-6 py-2 text-start">
                                    @php $photo = $documents->where('document_category', 'photo')->first(); @endphp
                                    @if ($photo && $photo->file_path)
                                        <button type="button" class="text-blue-600 underline"
                                            onclick="previewDoc('{{ asset('storage/' . $photo->file_path) }}','Photo')">
                                            View
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            {{-- Signature --}}
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>Signature (Signature)</span>
                                </th>
                                <td class="px-6 py-2 text-start">
                                    @php $signature = $documents->where('document_category', 'signature')->first(); @endphp
                                    @if ($signature && $signature->file_path)
                                        <button type="button" class="text-blue-600 underline"
                                            onclick="previewDoc('{{ asset('storage/' . $signature->file_path) }}','Signature')">
                                            View
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            {{-- ID Proof --}}
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>ID Proof (Passport)</span>
                                </th>
                                <td class="px-6 py-2 text-start">
                                    @php $idProof = $documents->where('document_category', 'id_proof')->first(); @endphp
                                    @if ($idProof && $idProof->file_path)
                                        <button type="button" class="text-blue-600 underline"
                                            onclick="previewDoc('{{ asset('storage/' . $idProof->file_path) }}','ID Proof')">
                                            View
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            {{-- ID Proof Back --}}
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>ID Proof Back (Aadhar Card)</span>
                                </th>
                                <td class="px-6 py-2 text-start">
                                    @php
                                        $idProofBack = $documents->where('document_category', 'id_proof_back')->first();
                                    @endphp

                                    @if ($idProofBack && $idProofBack->file_path)
                                        <button type="button" class="text-blue-600 underline"
                                            onclick="previewDoc('{{ asset('storage/' . $idProofBack->file_path) }}','ID Proof Back')">
                                            View
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            {{-- Address Proof --}}
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>Address Proof (Passport)</span>
                                </th>
                                <td class="px-6 py-2 text-start">
                                    @php
                                        $addressProof = $documents
                                            ->where('document_category', 'address_proof')
                                            ->first();
                                    @endphp

                                    @if ($addressProof && $addressProof->file_path)
                                        <button type="button" class="text-blue-600 underline"
                                            onclick="previewDoc('{{ asset('storage/' . $addressProof->file_path) }}','Address Proof')">
                                            View
                                        </button>
                                    @endif
                                </td>if
                                </td>
                            </tr>

                            {{-- Address Proof Back --}}
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span> Address Proof Back (Aadhar Card)</span>
                                </th>
                                <td class="px-6 py-2 text-start">
                                    @php $addressProofBack = $documents->where('document_category', 'address_proof_back')->first(); @endphp
                                    @if ($addressProofBack && $addressProofBack->file_path)
                                        <button type="button" class="text-blue-600 underline"
                                            onclick="previewDoc('{{ asset('storage/' . $addressProofBack->file_path) }}','Address Proof Back')">
                                            View
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            {{-- PAN --}}
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">
                                    <span>PAN Number (PAN)</span>
                                </th>
                                <td class="px-6 py-2 text-start">
                                    @php $pan = $documents->where('document_category', 'pan_number')->first(); @endphp
                                    @if ($pan && $pan->file_path)
                                        <button type="button" class="text-blue-600 underline"
                                            onclick="previewDoc('{{ asset('storage/' . $pan->file_path) }}','PAN')">
                                            View
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <script>
                    function previewDoc(fileUrl, docType) {
                        window.open(fileUrl, '_blank');
                    }
                </script>
            </div>

            <!-- MY GUARANTOR SHIP -->
            <div x-data="{ open: true }" class="mt-4 mb-4 box border rounded-10 shadow">
                <!-- Header -->
                <div class="flex items-center justify-between text-lg  px-4 py-3 text-black bg-secondary/5 rounded-10 cursor-pointer"
                    style="" @click="open = !open">
                    <span class="font-semibold text-lg uppercase">Joint Accounts</span>
                    <i :class="open ? 'las la-minus' : 'lad la-plus'"></i>
                </div>

                <!-- Content -->
                <div x-show="open" x-transition class="bg-white overflow-x-auto whitespace-nowrap px-4 mt-5">
                    <table class="w-full text-sm text-left border-collapse overflow-x-auto whitespace-nowrap">
                        <thead class="border-b">
                            <tr class="bg-secondary/5">
                                <th class="px-4 py-2 font-semibold uppercase">Account Type</th>
                                <th class="px-4 py-2 font-semibold uppercase">Account No.</th>
                                <th class="px-4 py-2 font-semibold uppercase">Open Date</th>
                                <th class="px-4 py-2 font-semibold uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($member->accounts as $account)
                                <tr>
                                    <td class="px-4 py-2">{{ $account->account_holder_type }}</td>
                                    <td class="px-4 py-2">{{ $account->account_no }}</td>
                                    <td class="px-4 py-2">
                                        {{-- {{ $account->open_date }} --}}
                                        {{ \Carbon\Carbon::parse($account->open_date)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-4 py-2">{{ $account->account_status == 1 ? 'Active' : 'Inactive' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MY GUARANTOR SHIP -->
            <div x-data="{ open: true }" class="mt-4 mb-4 border rounded-10 box shadow">
                <!-- Header -->
                <div class="flex items-center justify-between px-4 py-3  bg-secondary/5 rounded-t cursor-pointer"
                    @click="open = !open">
                    <span class="font-semibold text-lg uppercase">CO APPLICANT LOANS</span>
                    <i :class="open ? 'las la-minus' : 'lad la-plus'"></i>
                </div>

                <!-- Content -->
                <div x-show="open" x-transition class="  overflow-x-auto whitespace-nowrap">
                    <table class="w-full text-sm mt-5 text-left border-collapse overflow-x-auto whitespace-nowrap">
                        <thead class="border-b">
                            <tr class="bg-secondary/5">
                                <th class="px-4 py-2 font-semibold uppercase">Account Type</th>
                                <th class="px-4 py-2 font-semibold uppercase">Account No.</th>
                                <th class="px-4 py-2 font-semibold uppercase">Open Date</th>
                                <th class="px-4 py-2 font-semibold uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($member->accounts as $account)
                                <tr>
                                    <td class="px-4 py-2"> not confirm {{ $account->account_holder_type }}</td>
                                    <td class="px-4 py-2"> N confirm {{ $account->account_no }}</td>
                                    <td class="px-4 py-2">
                                        N confirm {{ \Carbon\Carbon::parse($account->open_date)->format('d-m-Y') }}</td>
                                    <td class="px-4 py-2">N confirm {{ $account->account_status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MY GUARANTOR SHIP -->
            <div x-data="{ open: true }" class="mt-4 mb-4 box border  rounded-10 shadow">
                <!-- Header -->
                <div class="flex items-center justify-between px-4 py-3 text-lg bg-secondary/5  rounded-t cursor-pointer"
                    style="" @click="open = !open">
                    <span class="font-semibold text-lg uppercase">My Guarantor Ship</span>
                    <i :class="open ? 'las la-minus' : 'lad la-plus'"></i>
                </div>

                <!-- Content -->
                <div x-show="open" x-transition class="bg-white overflow-x-auto whitespace-nowrap">
                    <table class="w-full text-sm text-left border-collapse mt-5 overflow-x-auto whitespace-nowrap">
                        <thead class="border-b">
                            <tr class="bg-secondary/5">
                                <th class="px-4 py-2 font-semibold uppercase">Account Type</th>
                                <th class="px-4 py-2 font-semibold uppercase">Account No.</th>
                                <th class="px-4 py-2 font-semibold uppercase">Open Date</th>
                                <th class="px-4 py-2 font-semibold uppercase">Status</th>
                                <th class="px-4 py-2 font-semibold uppercase">State</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 py-2">-</td>
                                <td class="px-4 py-2">-</td>
                                <td class="px-4 py-2">-</td>
                                <td class="px-4 py-2">-</td>
                                <td class="px-4 py-2">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div x-data="{ open: true }" class="mt-4 border box rounded shadow">
                <!-- Header for Collapsible Comments Section -->
                <div class="flex items-center justify-between px-4 py-3 bg-secondary/5 rounded-10 text-lg cursor-pointer"
                    @click="open = !open">
                    <span class="font-semibold text-lg uppercase">Comments</span>
                    <i :class="open ? 'las la-minus' : 'lad la-plus'"></i>
                </div>

                <!-- Content (Show comments or No comments message) -->
                <div x-show="open" x-transition class="p-4 bg-white">
                    @if ($comments->isEmpty())
                        <p class="mb-4 text-sm text-gray-700">No Comment Found</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse text-start mt-5 text-lg">
                                <thead class="text-start">
                                    <tr class="bg-secondary/5 dark:bg-bg3 text-start text-black">
                                        <th class="px-4 py-2 font-semibold text-start">DATE</th>
                                        <th class="px-4 py-2 font-semibold text-start">COMMENT BY</th>
                                        <th class="px-4 py-2 font-semibold text-start">COMMENT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comments as $comment)
                                        <tr
                                            class="border-b text-center border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 py-2 text-start">
                                                {{ \Carbon\Carbon::parse($comment->transaction_date)->format('d-m-Y H:i') }}
                                            </td>
                                            <td class="px-4 py-2 text-start">{{ $comment->member->name ?? '-' }}</td>
                                            <td class="px-4 py-2 text-start">{{ $comment->comment }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <!-- Add Comment Button -->
                    <div class="w-full flex items-center  justify-center  gap-4 mt-4">
                        <a href="{{ route('member.addComment', ['member_id' => $member->id]) }}"
                            class="text-center btn-primary  rounded-10 py-2 hover:bg-green-600">

                            ADD COMMENT

                        </a>
                        <!-- View All Button (Disabled if no comments) -->
                        @if ($comments->isNotEmpty())
                            <a class="btn-primary rounded-10 py-2"
                                href="{{ route('member.addComment', ['member_id' => $member->id]) }}">
                                VIEW ALL
                            </a>
                        @else
                            <a class="btn-primary rounded-10 py-2 cursor-not-allowed opacity-0" href="#" disabled>
                                VIEW ALL
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="col-span-12 lg:col-span-6" x-data="{
            showMobile: true,
            showAddress: true,
            showBank: true,
            showMember: true
        }">
            <div class=" space-y-6">
                <!-- Top 2 Cards -->
                <div class="flex flex-col lg:flex-row gap-4">
                    <!-- Total Deposits -->
                    <div class="flex items-center box overflow-hidden bg-white rounded-10 shadow">
                        <div class="flex items-center justify-center w-20 h-20 bg-primary rounded-10">
                            <i class="text-3xl text-white fa fa-money"></i>
                        </div>
                        <div class="pl-6">
                            <span class="block text-sm font-medium text-gray-700 uppercase">Total Deposits</span>
                            <span class="text-xl font-bold text-black">0.00</span>
                        </div>
                    </div>
                    <!-- Loan Outstanding -->
                    <div class="flex items-center box overflow-hidden bg-white rounded-10 shadow">
                        <div class="flex items-center justify-center w-20 h-20 bg-secondary rounded-10">
                            <i class="text-3xl text-white fa fa-money"></i>
                        </div>
                        <div class="pl-6">
                            <span class="block text-sm font-medium text-gray-700 uppercase">Loan Outstanding</span>
                            <span class="text-xl font-bold text-black">0.00</span>
                        </div>
                    </div>
                </div>
                <div>

                    <!-- KYC Status Section -->
                    <div class="mt-4 overflow-hidden bg-white box border rounded shadow">

                        <div class="flex items-center justify-between px-4 py-2 border-b">
                            <span class="font-semibold text-gray-700 uppercase">Current KYC Status</span>
                            <span class="px-4 py-2 text-sm font-bold text-error bg-error/20 rounded"><span
                                    class="px-4 py-2 text-sm font-bold rounded
                       {{ $member->kyc_status == 'completed' ? 'text-green-600 bg-green-100' : 'text-red-600 bg-red-100' }}">

                                    {{ strtoupper($member->kyc_status ?? 'pending') }}
                                </span></span>
                        </div>
                        <div class="flex items-center justify-between p-4">
                            <label class="font-semibold text-gray-700 uppercase">KYC Status</label>
                            <div class="flex  gap-2">
                                <select
                                    class="px-3 py-3 text-sm bg-secondary/5 rounded-10 border rounded-l focus:outline-none">
                                    <option>PENDING</option>
                                    <option>MINI_KYC</option>
                                    <option>FULL_KYC</option>

                                </select>
                                <button class="px-4 py-1 text-sm rounded-10  btn-primary">
                                    UPDATE
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="mt-4 box p-4 rounded-10 shadow bg-white">

                    <h3 class="text-lg font-semibold mb-4 uppercase text-center">
                        KYC Verification
                    </h3>

                    @php $kyc = $member->kyc; @endphp

                    {{-- STEP 1: PAN --}}
                    <div class="mb-4 border rounded p-3">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold">Step 1: PAN Verification</span>
                            <span class="{{ $kyc?->pan_verified ? 'text-green-600' : 'text-red-500' }}">
                                {{ $kyc?->pan_verified ? '✔ Verified' : 'Pending' }}
                            </span>
                        </div>

                        <form method="POST" action="{{ route('member.pan.submit', $member->id) }}" class="flex gap-2">
                            @csrf
                            <input type="text" name="member_kyc_pan_no" value="{{ $kyc?->member_kyc_pan_no }}"
                                {{ $kyc?->pan_verified ? 'disabled' : '' }} class="border px-3 py-2 rounded">

                            <button class="btn-warning px-4 py-2 rounded">Submit PAN</button>
                        </form>
                    </div>
                    @if ($errors->any())
                        <div class="mb-3 p-2 bg-red-100 text-red-600 rounded">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    {{-- STEP 2: Aadhaar --}}
                    <div class="mb-4 border rounded p-3">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold">Step 2: Aadhaar Verification</span>
                            <span class="{{ $kyc?->aadhaar_submitted ? 'text-green-600' : 'text-red-500' }}">
                                {{ $kyc?->aadhaar_submitted ? '✔ OTP Sent' : 'Pending' }}
                            </span>
                        </div>

                        <form method="POST" action="{{ route('member.aadhaar.submit', $member->id) }}"
                            class="flex gap-2">
                            @csrf
                            <input type="text" name="aadhaar" value="{{ $kyc?->member_kyc_aadhaar_no }}"
                                {{ $kyc?->aadhaar_submitted ? 'disabled' : '' }} class="border px-3 py-2 rounded">

                            <button class="btn-primary px-4 py-2 rounded">Submit Aadhaar</button>
                        </form>
                    </div>

                    {{-- STEP 3: OTP VERIFY --}}
                    <div class="mb-4 border rounded p-3">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold">Step 3: Verify OTP</span>
                            <span class="{{ $kyc?->otp_verified ? 'text-green-600' : 'text-red-500' }}">
                                {{ $kyc?->otp_verified ? '✔ Verified' : 'Pending' }}
                            </span>
                        </div>

                        <form method="POST" action="{{ route('member.aadhaar.verify', $member->id) }}"
                            class="flex gap-2">
                            @csrf
                            <input type="text" name="otp" placeholder="Enter OTP"
                                class="border px-3 py-2 rounded">

                            <button class="btn-primary px-4 py-2 rounded">Verify OTP</button>
                        </form>
                    </div>

                    {{-- STEP 4: SELFIE --}}
                    <div class="border rounded p-3">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold">Step 4: Upload Selfie</span>
                            <span class="{{ $kyc?->selfie_uploaded ? 'text-green-600' : 'text-red-500' }}">
                                {{ $kyc?->selfie_uploaded ? '✔ Uploaded' : 'Pending' }}
                            </span>
                        </div>

                        <form method="POST" action="{{ route('member.selfie', $member->id) }}">
                            @csrf

                            <br>

                            <button type="button" id="openCameraBtn" onclick="startCamera()" class="btn-primary px-4 py-2 rounded">
                                Upload Selfie
                            </button>

                            <br><br>

                            <video id="video" width="250" autoplay style="display:none;"></video>

                            <canvas id="canvas" style="display:none;"></canvas>

                            <img id="preview" width="250" style="display:none;border:1px solid #ccc;margin-top:10px;">

                            <br><br>

                            <button type="button" class="btn-primary px-4 py-2 rounded" id="captureBtn" onclick="capture()" style="display:none;">
                            Capture
                            </button>

                            <input type="hidden" name="selfie_base64" id="selfie_base64">

                            <br><br>

                            <button type="submit" class="btn-primary px-4 py-2 rounded" id="submitBtn" style="display:none;">
                            Submit Selfie
                            </button>

                        </form>

                    </div>

                </div>
                <!-- Settings Section -->
                <div class="mt-4 overflow-hidden box border rounded shadow">

                    <div class="px-4 py-2 font-semibold uppercase bg-white text-lg border-b ">Settings</div>
                    <div class="p-4 space-y-4 bg-white">
                        <div class="flex items-center justify-between uppercase">
                            <span class="font-semibold">Internet Banking / Mob App Enabled</span>
                            <input type="checkbox" class="w-5 h-5 accent-blue-600">
                        </div>
                        <div class="flex items-center justify-between uppercase">
                            <span class="font-semibold">Money Transfer</span>
                            <input type="checkbox" class="w-5 h-5 accent-blue-600" checked>
                        </div>
                        <div class="flex items-center justify-between uppercase">
                            <span class="font-semibold">Account Locked</span>
                            <input type="checkbox" class="w-5 h-5 accent-blue-600">
                        </div>
                        <div class="flex items-center justify-between uppercase">
                            <span class="font-semibold">SMS</span>
                            <input type="checkbox" class="w-5 h-5 accent-blue-600" checked>
                        </div>
                    </div>
                </div>
                <div>
                    {{-- Internet Banking section --}}
                    <div class="mt-4  ">
                        <div class="">
                            <!-- Header -->
                            <div class="box">
                                <div class="px-4 py-3  bg-white border-b">
                                    <h3 class="text-lg font-medium tracking-wide text-gray-700">INTERNET BANKING USERNAME
                                    </h3>
                                </div>
                                <!-- Table Body -->
                                <div class="px-8  py-4">
                                    {{-- <table class="w-full border-collapse"> --}}

                                    <!-- Body -->
                                    <div class="flex items-center justify-between px-6 py-4">
                                        <!-- Left label -->
                                        <div class="flex-1">
                                            <div class=" font-semibold text-gray-700 uppercase">USERNAME</div>
                                        </div>

                                        <!-- Center username -->
                                        <div class="flex-1 text-center">
                                            <span class="text-lg text-gray-700">04421</span>
                                        </div>

                                        <!-- Right small action buttons -->
                                        <div class="flex justify-end flex-1  gap-2">
                                            <button type="button"
                                                class="flex items-center justify-center btn-primary p-1"
                                                title="Reset username">
                                                <i class="las la-undo"></i>
                                            </button>

                                            <button type="button"
                                                class="flex items-center justify-center btn-primary p-1"
                                                title="Send username">
                                                <i class="las la-share-square"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div x-data="{
                            showMobile: true,
                            editing: false
                        }" class="mt-5  border box rounded-10 py-3 shadow">
                            <!-- Header -->
                            <div class="flex items-center justify-between px-4 py-2 bg-secondary/5 rounded-10">
                                <span class="font-semibold uppercase text-lg">Mobile & Email Details</span>
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('member.mobile', $member->id) }}" class="btn-primary p-1">
                                        <i class="cursor-pointer las la-pencil-alt " @click="editing = !editing"></i>
                                    </a>
                                    <i class="cursor-pointer las" :class="showMobile ? 'la-minus' : 'la-plus'"
                                        @click="showMobile = !showMobile"></i>
                                </div>
                            </div>
                            <div class="p-4 text-sm bg-white" x-show="showMobile" x-transition>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="font-medium uppercase">Mobile No</span>
                                    <span>{{ $member->member_info_mobile_no }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="font-medium uppercase">Email</span>
                                    <span>{{ $member->member_info_email }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 box  border rounded shadow">

                            <!-- Header -->
                            <div class="flex items-center justify-between px-4 py-2 rounded-t">
                                <span class="font-semibold text-lg uppercase">
                                    {{ isset($member) ? $member->member_info_first_name . ' ' . $member->member_info_last_name : 'Add member' }}
                                </span>
                                <!-- Redirect to create page -->
                                <a href="{{ isset($member) ? route('minor.create', ['member_id' => $member->id, 'type' => 'member']) : '#' }}"
                                    class="px-4 py-2 text-sm uppercase btn-primary rounded-10">
                                    + Minor
                                </a>
                            </div>
                            <!-- Table for minors -->
                            <div class="p-4 overflow-x-auto whitespace-nowrap ">
                                <table class="w-full text-sm overflow-x-auto whitespace-nowrap text-left">
                                    <thead>
                                        <tr class="border-b bg-secondary/5 px-4 py-2">
                                            <th class="font-semibold  px-4 py-2 text-start">NAME</th>
                                            <th class="font-semibold text-gray-ft-600  px-4 py-2 text-start">DOB</th>
                                            <th class="font-semibold text-gray-ft-600  py-8 text-left">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($member->minors as $minor)
                                            <tr>
                                                <td class="border  px-4 py-2">{{ $minor->first_name }}
                                                    {{ $minor->last_name }}
                                                </td>
                                                <td class="border  px-4 py-2">
                                                    {{ \Carbon\Carbon::parse($minor->dob)->format('d-m-Y') }}
                                                </td>
                                                <td class="border  px-4 py-2">
                                                    <a href="{{ route('minor.show', $minor->id) }}" title="View"
                                                        class="text-green-600 hover:underline mr-2">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                    <a href="{{ route('minor.edit', $minor->id) }}" title="Edit"
                                                        class="text-green-600 hover:underline">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- Share Holdings section - table format --}}
                    <div class="mt-4 bg-white border rounded-10 shadow-sm">

                        <!-- Top red border -->


                        <!-- Header -->
                        <div class="px-4 py-3 bg-white border-b">
                            <h6 class="font-semibold tracking-wide text-lg  text-gray-700 text-md">
                                SHARE HOLDING DETAILS
                            </h6>
                        </div>

                        <!-- Table Body -->
                        <div class="px-6 py-4">
                            <table class="w-full border-collapse mb-4">
                                <tbody>
                                    <tr>
                                        <th class="px-4 py-2  font-semibold text-start text-gray-700 uppercase">
                                            Total No. of Shares
                                        </th>
                                        <td class="px-4 py-2 text-lg text-start text-gray-700">
                                            {{ $shareholdings->sum('shares') ?? '—' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div>
                        <!-- ADDRESS & CONTACT INFO -->
                        <div class="mt-4  box rounded shadow">
                            <div class="flex items-center justify-between px-4 py-3 bg-secondary/5 rounded-10"
                                style="">
                                <span class="font-semibold text-lg uppercase">Address</span>
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('member.address', $member->id) }}" class="btn-primary p-1">
                                        <i class="cursor-pointer las la-pencil-alt "></i>
                                    </a>
                                    <i :class="showAddress ? 'las la-minus' : 'lad la-plus'"
                                        @click="showAddress = !showAddress"></i>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 space-y-4 text-sm bg-white" x-show="showAddress" x-transition>
                            <h5 class="mb-2 font-semibold text-center text-lg uppercase">
                                Correspondence Address
                            </h5>
                            <div class="flex justify-between py-2 px-4 border-b">
                                <span class="font-semibold uppercase ">Address</span>
                                <span>{{ $member->address?->member_address_line_1 ?? '' }}</span>
                            </div>
                            <div class="flex justify-between py-2  px-4 border-b">
                                <span class="font-semibold uppercase">Para/ Ward/ Panchayat/ Area</span>
                                <span>
                                    {{ $member->address?->member_address_para ?? '' }}/
                                    {{ $member->address?->member_address_ward ?? '' }}/
                                    {{ $member->address?->member_address_panchayat ?? '' }}/
                                    {{ $member->address?->member_address_area ?? '' }}
                                </span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="font-semibold uppercase  px-4">Landmark</span>
                                <span>{{ $member->address?->member_address_landmark ?? '' }}</span>
                            </div>

                            <h5 class="mb-2 font-semibold text-lg text-center uppercase">
                                Permanent Address
                            </h5>
                            <div class="flex justify-between py-2 px-4 border-b">
                                <span class="font-semibold uppercase">Address</span>
                                <span>{{ $member->address?->member_address_address ?? '' }}</span>
                            </div>
                            <div class="flex justify-between py-2 px-4 border-b uppercase">
                                <span class="font-semibold">City / District</span>
                                <span>{{ $member->address?->member_perm_address_city ?? '' }}/
                                    {{ $member->address?->member_address_city_district ?? '' }}
                                </span>
                            </div>
                            <div class="flex justify-between py-2 px-4 border-b uppercase">
                                <span class="font-semibold">State</span>
                                <span>{{ $member->address?->state?->name ?? 'N/A' }}</span>
                            </div>

                            <div class="flex justify-between py-2 px-4">
                                <span class="font-semibold uppercase">GPS Lat/ Log</span>
                                <span>{{ $member->address?->member_gps_location_latitude ?? '' }}
                                    {{ $member->address?->member_gps_location_latitude ?? '' }}
                                </span>
                            </div>
                        </div>
                        <!-- BANK DETAILS -->
                        <div class="mt-4 box  border rounded shadow">
                            <div class="flex items-center bg-secondary/5 justify-between px-4 py-3 rounded-10 rounded-t">
                                <span class="font-semibold text-lg uppercase uppercase">Bank Details</span>
                                <div class="flex gap-4  items-center justify-center space-x-2">
                                    <div class="btn-primary p-1">
                                        <i class="cursor-pointer las la-pencil-alt"></i>
                                    </div>
                                    <i class="cursor-pointer las" :class="showBank ? 'la-minus' : 'la-plus'"
                                        @click="showBank = !showBank"></i>
                                </div>
                            </div>
                            <div class="p-4 text-sm bg-white" x-show="showBank" x-transition>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="font-semibold uppercase">Bank Name</span>
                                    <span>{{ $member->branch?->branch_name ?? '' }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="font-semibold uppercase">IFSC Code</span>
                                    <span>{{ $member->branch?->ifsc_code ?? '' }}</span>
                                </div>

                                <div class="flex justify-between py-2 border-b">
                                    <span class="font-semibold uppercase">Account Type</span>
                                    <span>
                                        @foreach ($member->accounts as $acc)
                                            {{ $acc->account_type }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    </span>
                                </div>

                                <div class="flex justify-between py-2">
                                    <span class="font-semibold uppercase">Account No.</span>
                                    <span>
                                        @foreach ($member->accounts as $acc)
                                            {{ $acc->account_no }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    </span>
                                </div>

                            </div>
                        </div>

                        <!-- MEMBER ACCOUNTS -->
                        <div class="mt-4 box border rounded shadow">
                            <div class="px-4 py-3 text-lg font-semibold  uppercase bg-secondary/5  rounded-10 ">
                                Customer Accounts
                            </div>
                            <div class="flex mt-5 bg-white gap-3 ">
                                <button class="px-4 py-2 text-sm font-semibold uppercase btn-primary">
                                    Active Account
                                </button>
                                <button class="px-4 py-2 text-sm font-semibold uppercase btn-primary">
                                    Closed Account
                                </button>
                            </div>
                            <div class="bg-white mt-4">
                                <table class="w-full text-sm text-left border-collapse">
                                    <thead class="border-b bg-secondary/5">
                                        <tr>
                                            <th class="px-4 py-2 font-semibold uppercase">Account Type</th>
                                            <th class="px-4 py-2 font-semibold uppercase">Account No.</th>
                                            <th class="px-4 py-2 font-semibold uppercase">Open Date</th>
                                            <th class="px-4 py-2 font-semibold uppercase">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('click', function(e) {
            const button = e.target.closest('.toggle-btn');
            if (!button) return;

            const icon = button.querySelector('.toggle-icon');
            if (!icon) return;

            icon.classList.toggle('la-angle-down');
            icon.classList.toggle('la-angle-up');
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const aadhaar = document.querySelector('[name="aadhaar"]');
            const pan = document.querySelector('[name="member_kyc_pan_no"]');

            if (aadhaar) {
                aadhaar.addEventListener("input", function() {
                    if (aadhaar.value === "{{ $kyc?->member_kyc_aadhaar_no }}") {
                        alert("Aadhaar already exists!");
                    }
                });
            }

            if (pan) {
                pan.addEventListener("input", function() {
                    if (pan.value === "{{ $kyc?->member_kyc_pan_no }}") {
                        alert("PAN already exists!");
                    }
                });
            }

        });
    </script>

<script>

let stream;

// camera start
function startCamera()
{
    navigator.mediaDevices.getUserMedia({ video: true })
    .then(function(s){
        stream = s;

        document.getElementById('video').srcObject = stream;
        document.getElementById('video').style.display="block";

        // capture button show
        document.getElementById('captureBtn').style.display="inline-block";

        // open camera button hide
        document.getElementById('openCameraBtn').style.display="none";
    })
    .catch(function(err){
        console.log("Camera error:", err);
        alert("Camera access denied");
    });
}

// capture image
function capture()
{
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const preview = document.getElementById('preview');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    const ctx = canvas.getContext('2d');
    ctx.drawImage(video,0,0,canvas.width,canvas.height);

    let data = canvas.toDataURL('image/jpeg');

    document.getElementById('selfie_base64').value = data;

    // preview show
    preview.src = data;
    preview.style.display = "block";

    // camera stop
    stream.getTracks().forEach(track => track.stop());

    // hide video
    video.style.display = "none";

    // show submit button
    document.getElementById('submitBtn').style.display="inline-block";

    // hide capture button
    document.getElementById('captureBtn').style.display="none";
}
</script>

@endsection
