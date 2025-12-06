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
    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>
    <div class="flex flex-wrap gap-3 mb-3 text-center">
        {{-- <a href="{{ route('member.shareholding', $member->id) }}"
    class="btn-info rounded-md px-2 py-1 text-white text-sm bg-blue-500 hover:bg-blue-600">
    SHARE HOLDINGS
    </a> --}}
        @if ($member->share_allocated == 1)
            <a href="{{ route('member.shareholding', $member->id) }}"
                class="btn-info rounded-md px-2 py-1 text-white text-sm bg-blue-500 hover:bg-blue-600">
                SHARE HOLDINGS
            </a>
        @endif

        <a href="{{ url('/share/allocate') }}?member_id={{ $member->id }}"
            class="btn-success rounded-md px-2 py-1 text-white text-sm bg-green-500 hover:bg-green-600">
            ALLOCATE SHARES
        </a>

        <a href="{{ route('members.transactions.share-amount.store', $member->id) }}"
            class="btn-warning rounded-md px-2 py-1 text-white  text-sm bg-yellow-500 hover:bg-yellow-600">ADD SHARE
            AMOUNT</a>


        <a href="{{ route('members.transactions', $member->id) }}"
            class="btn-info rounded-md px-2 py-1 text-white  text-sm bg-blue-500 hover:bg-blue-600">VIEW TRANSACTIONS</a>


        <div x-data="{ open: false }" class="relative inline-block">

            <a @click="open = !open" class="btn-secondary px-2 py-2 rounded-10 flex items-center justify-between space-x-2">
                <span>DEBIT OTHER CHARGES</span>
                <svg class="w-2 h-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </a>

            <!-- Dropdown -->
            <div x-show="open" @click.outside="open = false"
                class="absolute mt-2 w-48 bg-white border border-gray-300 rounded-lg shadow-lg z-50">
                <ul class="py-2 whitespace-nowrap">
                    <li>
                        <a href="{{ route('members.other-charges.list', ['id' => $member->id]) }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            OTHER CHARGES LIST
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('members.other-charges', ['id' => $member->id]) }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            DEBIT OTHER CHARGES
                        </a>
                    </li>
                    <li>

                        <a href="{{ $charge && $charge->member_id && $charge->id ? route('members.other-charges.clearDue.form', ['id' => $charge->member_id, 'chargeId' => $charge->id]) : '#' }}"
                            class="{{ !$charge || !$charge->member_id || !$charge->id ? 'text-gray-500 cursor-not-allowed' : '' }}">
                            {{-- href="{{ route('members.other-charges.clearDue.form', ['id' => $charge->member_id ?? '', 'chargeId' => $charge->id ?? '']) }}"> --}}
                            Clear Due

                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <a title="DOWNLOAD 15G/ 15H"
            href="{{ isset($member) ? route('form15g15h.download', ['member_id' => $member->id]) : '#' }}"
            class="btn-default rounded-md px-2 py-1 text-sm text-gray-700 bg-gray-200 hover:bg-gray-300">
            <i class="fa fa-print"></i> DOWNLOAD 15G/ 15H
        </a>

        <a href="{{ isset($member) ? route('form15g15h.create', ['member_id' => $member->id, 'type' => 'member']) : '#' }}"
            class="btn-warning rounded-md px-2 py-1 text-white text-sm bg-yellow-500 hover:bg-yellow-600">
            <i class="fa fa-plus" aria-hidden="true"></i> UPLOAD 15G/ 15H
        </a>
        <a class="btn-danger rounded-md px-2 py-1 text-white  text-sm bg-red-500 hover:bg-red-600">REMOVE CUSTOMER</a>

        <a href="{{ route('members.application_form', $member->id) }}"
            class="btn-primary rounded-md px-2 py-1 text-white text-sm bg-indigo-500 hover:bg-indigo-600">
            <i class="fa fa-print"></i> APPLICATION FORM
        </a>
        <a class="btn-info rounded-md px-2 py-1 text-white  text-sm bg-blue-500 hover:bg-blue-600">SHOW AUDIT TRAIL</a>
    </div>
    <div class="grid grid-cols-12 gap-4 xxl:gap-6">
        <div class="col-span-12 lg:col-span-6 overflow-x-hidden">
            <div class="col-span-12 box overflow-x-hidden">
                <table class="w-full whitespace-nowrap text-sm">
                    <tbody>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Membership Type</span></div>
                            </th>
                            <td
                                class="block w-20 rounded-[30px] border border-n30 bg-primary/20 py-1 text-center text-[10px] text-primary dark:border-n500 uppercase  dark:bg-bg3 xxl:w-19">

                                <div><span class=" uppercase text-sm">{{ $member->membership_type }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Create on</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>Admin App</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Created by</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ auth()->user()->name }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Status</span></div>
                            </th>
                            <td>
                                <span
                                    class="block w-20 rounded-[30px] border border-n30 bg-primary/20 py-1 text-center text-[10px] text-primary dark:border-n500 uppercase  dark:bg-bg3 xxl:w-19">
                                    ACTIVE
                                </span>
                            </td>
                        </tr>

                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Branch</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->branch->branch_name }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Advisor/ Staff</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->general_advisor_staff }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Old Customer No</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_old_member_no }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Enrollment Date</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>{{ $member->general_enrollment_date ? \Carbon\Carbon::parse($member->general_enrollment_date)->format('d-m-Y') : 'N/A' }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">

                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Name</span></div>
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
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>DOB</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>
                                        {{ $member->member_info_dob ? \Carbon\Carbon::parse($member->member_info_dob)->format('d-m-Y') : 'N/A' }}
                                    </span>
                                </div>

                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Age</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>{{ \Carbon\Carbon::parse($member->member_info_dob)->age }} years</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Senior Citizen</span></div>
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
                                        class="block w-20 rounded-[30px] border border-n30 bg-primary/20 py-1 text-center text-[10px] text-primary dark:border-n500 dark:bg-bg3 xxl:w-19">
                                        No
                                    </span>
                                @endif
                            </td>


                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Gender</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_gender }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Folio No.</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->folio_no }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Father Name</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_middle_name }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Mother Name</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_mother_name }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Marital Status</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_marital_status }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Religion</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->religion?->name ?? 'N/A' }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Qualification</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_qualification }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Husband/ Wife Name </span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_spouse_name }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Husband/ Wife D.O.B</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_spouse_dob }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Occupation</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_occupation }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Monthly Income</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_monthly_income }}</span></div>
                            </td>
                        </tr>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Collection Time</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_collection_time }}</span></div>
                            </td>
                        </tr>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3 uppercase"><span>Form 15G/ 15H Uploaded<br>(FY 2025 -
                                        2026)</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
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
                                                                    <i :class="open ? 'fa fa-minus' : 'fa fa-plus'"></i>
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
                                                                    <i :class="open ? 'fa fa-minus' : 'fa fa-plus'"></i>
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

            <div x-data="{ open: true }" class="mt-4 rounded shadow">
                <!-- Header -->
                <div class="flex items-center justify-between px-4 py-2 text-white bg-red-500 rounded-t cursor-pointer"
                    @click="open = !open">
                    <span class="font-semibold uppercase">Member KYC Info</span>
                    <i :class="open ? 'fa fa-minus' : 'fa fa-plus'"></i>
                </div>
                <!-- Content -->
                <div x-show="open" x-transition class="bg-white rounded-md">
                    <table class="w-full text-sm">
                        <tbody>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">Aadhaar No.</th>
                                <td class="flex items-center justify-between px-6 py-2" text-start>
                                    <span>{{ $member->kyc?->member_kyc_aadhaar_no ?? '' }}</span>
                                    <i class="text-green-600 fa fa-check-circle"></i>
                                </td>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">Voter ID No.</th>
                                <td class="flex items-center justify-between px-6 py-2" text-start>
                                    {{ $member->kyc?->member_kyc_voter_id_no ?? '' }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">Pan No.</th>
                                <td class="flex items-center justify-between px-6 py-2" text-start>
                                    <span>{{ $member->kyc?->member_kyc_pan_no ?? '' }}</span>
                                    <i class="text-green-600 fa fa-check-circle"></i>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">Ration Card No.</th>
                                <td class="flex items-center justify-between px-6 py-2" text-start>
                                    <span>{{ $member->kyc?->member_kyc_ration_card_no ?? '' }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">Meter No.</th>
                                <td class="px-6 py-2">{{ $member->kyc?->member_kyc_meter_no ?? '' }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">CI No.</th>
                                <td class="px-6 py-2">{{ $member->kyc?->member_kyc_ci_no ?? '' }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">CI Relation</th>
                                <td class="px-6 py-2">{{ $member->kyc?->member_kyc_ci_relation ?? '' }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">DL No</th>
                                <td class="px-6 py-2">{{ $member->kyc?->member_kyc_dl_no ?? '' }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">CKYC No</th>
                                {{-- <td class="px-6 py-2">{{$member->kyc?->member_kyc_ci_no??''}}</td> --}}
                            </tr>
                            <tr>
                                <th class="px-6 py-2 font-semibold text-start uppercase">CKYC Updated At</th>
                                <td class="px-6 py-2">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Member Nominee Info --}}
            <div x-data="{ open: true }" class="mt-4 rounded shadow">
                <div class="flex items-center justify-between px-4 py-2 text-white bg-blue-500 rounded-t cursor-pointer"
                    @click="open = !open">
                    <span class="font-semibold uppercase">Customer Nominee Info</span>
                    <i :class="open ? 'fa fa-minus' : 'fa fa-plus'"></i>
                </div>

                <div x-show="open" x-transition class="bg-white">
                    <table class="w-full text-sm">
                        <tbody>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">Name</th>
                                <td class="flex items-center justify-between px-6 py-2">
                                    <span>{{ $member->kyc?->nominee_name ?? '' }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">DOB</th>
                                <td class="px-6 py-2"><span>{{ $member->kyc?->nominee_dob ?? '' }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">Gender</th>
                                <td class="flex items-center justify-between px-6 py-2">
                                    <span>{{ $member->kyc?->nominee_gender ?? '' }}</span>

                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">Relation</th>
                                <td class="px-6 py-2">
                                    <span>{{ $member->kyc?->nominee_relation ?? '' }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">Mobile No.</th>
                                <td class="px-6 py-2">
                                    <span>{{ $member->kyc?->nominee_mobile_no ?? '' }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">Aadhaar No.</th>
                                <td class="px-6 py-2"><span>{{ $member->kyc?->nominee_aadhaar_no ?? '' }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">Voter ID No. </th>
                                <td class="px-6 py-2"><span>{{ $member->kyc?->nominee_voter_id_no ?? '' }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">Pan No.</th>
                                <td class="px-6 py-2">
                                    <span>{{ $member->kyc?->nominee_pan_no ?? '' }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">Address</th>
                                <td class="px-6 py-2"><span>{{ $member->kyc?->nominee_address ?? '' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="px-6 py-2 font-semibold text-start uppercase">Ration Card No.</th>
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

            <div x-data="{ open: true }" class="mt-4 rounded shadow">
                <!-- Header -->
                <div class="flex items-center justify-between px-4 py-2 text-white bg-green-500 rounded-t cursor-pointer"
                    @click="open = !open">
                    <span class="font-semibold uppercase">Documents</span>
                    <div class="flex gap-2 space-x-2">
                        {{-- Link to document edit page --}}
                        <a href="{{ route('member.document', $member->id) }}">
                            <i class="cursor-pointer fa fa-pencil text-white-600 hover:text-blue-800"></i>
                        </a>
                        {{-- Toggle button for showing/hiding sections --}}
                        <i :class="open ? 'fa fa-minus' : 'fa fa-plus'"></i>
                    </div>
                </div>

                <!-- Content -->
                <div x-show="open" x-transition class="bg-white">
                    <table class="w-full text-sm border">
                        <tbody>
                            {{-- Photo --}}
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">Photo (Photo)</th>
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
                                <th class="px-6 py-2 font-semibold text-start uppercase">Signature (Signature)</th>
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
                                <th class="px-6 py-2 font-semibold text-start uppercase">ID Proof (Passport)</th>
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
                                <th class="px-6 py-2 font-semibold text-start uppercase">ID Proof Back (Aadhar Card)</th>
                                <td class="px-6 py-2 text-start">
                                    @php $idProofBack = $documents->where('document_category', 'id_proof_back')->first(); @endphp
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
                                <th class="px-6 py-2 font-semibold text-start uppercase">Address Proof (Passport)</th>
                                <td class="px-6 py-2 text-start">
                                    @php $addressProof = $documents->where('document_category', 'address_proof')->first(); @endphp
                                    @if ($addressProof && $addressProof->file_path)
                                        <button type="button" class="text-blue-600 underline"
                                            onclick="previewDoc('{{ asset('storage/' . $addressProof->file_path) }}','Address Proof')">
                                            View
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            {{-- Address Proof Back --}}
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start uppercase">Address Proof Back (Aadhar Card)
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
                                <th class="px-6 py-2 font-semibold text-start uppercase">PAN Number (PAN)</th>
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
            <div x-data="{ open: true }" class="mt-4 mb-4 border rounded shadow">
                <!-- Header -->
                <div class="flex items-center justify-between px-4 py-2 text-white bg-green-500 rounded-t cursor-pointer"
                    style="background-color:#3c8dbc;" @click="open = !open">
                    <span class="font-semibold uppercase">Joint Accounts</span>
                    <i :class="open ? 'fa fa-minus' : 'fa fa-plus'"></i>
                </div>

                <!-- Content -->
                <div x-show="open" x-transition class="bg-white">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="border-b">
                            <tr>
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
                                    <td class="px-4 py-2">{{ $account->open_date }}</td>
                                    <td class="px-4 py-2">{{ $account->account_status == 1 ? 'Active' : 'Inactive' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MY GUARANTOR SHIP -->
            <div x-data="{ open: true }" class="mt-4 mb-4 border rounded shadow">
                <!-- Header -->
                <div class="flex items-center justify-between px-4 py-2 text-white bg-green-500 rounded-t cursor-pointer"
                    @click="open = !open">
                    <span class="font-semibold uppercase">CO APPLICANT LOANS</span>
                    <i :class="open ? 'fa fa-minus' : 'fa fa-plus'"></i>
                </div>

                <!-- Content -->
                <div x-show="open" x-transition class="bg-white">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="border-b">
                            <tr>
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
                                    <td class="px-4 py-2">N confirm {{ $account->open_date }}</td>
                                    <td class="px-4 py-2">N confirm {{ $account->account_status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MY GUARANTOR SHIP -->
            <div x-data="{ open: true }" class="mt-4 mb-4 border rounded shadow">
                <!-- Header -->
                <div class="flex items-center justify-between px-4 py-2 text-white bg-green-500 rounded-t cursor-pointer"
                    style="background-color:#3c8dbc;" @click="open = !open">
                    <span class="font-semibold uppercase">My Guarantor Ship</span>
                    <i :class="open ? 'fa fa-minus' : 'fa fa-plus'"></i>
                </div>

                <!-- Content -->
                <div x-show="open" x-transition class="bg-white">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="border-b">
                            <tr>
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

            <div x-data="{ open: true }" class="mt-4 border rounded shadow">
                <!-- Header for Collapsible Comments Section -->
                <div class="flex items-center justify-between px-4 py-2 text-white bg-blue-600 rounded-t cursor-pointer"
                    @click="open = !open">
                    <span class="font-semibold uppercase">Comments</span>
                    <i :class="open ? 'fa fa-minus' : 'fa fa-plus'"></i>
                </div>

                <!-- Content (Show comments or No comments message) -->
                <div x-show="open" x-transition class="p-4 bg-white">
                    @if ($comments->isEmpty())
                        <p class="mb-4 text-sm text-gray-700">No Comment Found</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse text-start text-lg">
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
                    <div class="flex justify-center gap-4 mt-4">
                        <a href="{{ route('member.addComment', ['member_id' => $member->id]) }}">
                            <button class="btn-primary rounded-10 py-2 hover:bg-green-600">
                                ADD COMMENT
                            </button>
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
            <div class="p-4 space-y-6">
                <!-- Top 2 Cards -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Total Deposits -->
                    <div class="flex items-center overflow-hidden bg-white rounded shadow">
                        <div class="flex items-center justify-center w-20 h-20 bg-green-500">
                            <i class="text-3xl text-white fa fa-money"></i>
                        </div>
                        <div class="pl-6">
                            <span class="block text-sm font-medium text-gray-700 uppercase">Total Deposits</span>
                            <span class="text-xl font-bold text-black">0.00</span>
                        </div>
                    </div>
                    <!-- Loan Outstanding -->
                    <div class="flex items-center overflow-hidden bg-white rounded shadow">
                        <div class="flex items-center justify-center w-20 h-20 bg-blue-500">
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
                    <div class="mt-4 overflow-hidden bg-white border rounded shadow">
                        <div class="h-1 bg-red-500"></div>
                        <div class="flex items-center justify-between px-4 py-2 border-b">
                            <span class="font-semibold text-gray-700 uppercase">Current KYC Status</span>
                            <span class="px-2 py-1 text-xs font-bold text-white bg-red-500 rounded">PENDING</span>
                        </div>
                        <div class="flex items-center justify-between p-4">
                            <label class="font-semibold text-gray-700 uppercase">KYC Status</label>
                            <div class="flex">
                                <select class="px-3 py-1 text-sm border rounded-l focus:outline-none">
                                    <option>Pending</option>
                                    <option>Approved</option>
                                </select>
                                <button class="px-4 py-1 text-sm text-white bg-green-500 rounded-r hover:bg-green-600">
                                    UPDATE
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Settings Section -->
                <div class="mt-4 overflow-hidden border rounded shadow">
                    <div class="h-1 bg-red-500"></div>
                    <div class="px-4 py-2 font-semibold uppercase bg-white border-b uppercase">Settings</div>
                    <div class="p-4 space-y-4 bg-white">
                        <div class="flex items-center justify-between uppercase">
                            <span>Internet Banking / Mob App Enabled</span>
                            <input type="checkbox" class="w-5 h-5 accent-blue-600">
                        </div>
                        <div class="flex items-center justify-between uppercase">
                            <span>Money Transfer</span>
                            <input type="checkbox" class="w-5 h-5 accent-blue-600" checked>
                        </div>
                        <div class="flex items-center justify-between uppercase">
                            <span>Account Locked</span>
                            <input type="checkbox" class="w-5 h-5 accent-blue-600">
                        </div>
                        <div class="flex items-center justify-between uppercase">
                            <span>SMS</span>
                            <input type="checkbox" class="w-5 h-5 accent-blue-600" checked>
                        </div>
                    </div>
                </div>
                <div>
                    {{-- Internet Banking section --}}
                    <div class="mt-4 bg-white border rounded shadow-sm">

                        <div class="h-1 rounded-t" style="background: #2b9bd6;"></div>

                        <!-- Header -->
                        <div class="px-4 py-3 bg-white border-b">
                            <h3 class="text-sm font-medium tracking-wide text-gray-700">INTERNET BANKING USERNAME</h3>
                        </div>
                        <!-- Table Body -->
                        <div class="px-8 py-4">
                            <table class="w-full border-collapse">

                                <!-- Body -->
                                <div class="flex items-center justify-between px-6 py-4">
                                    <!-- Left label -->
                                    <div class="flex-1">
                                        <div class="text-xs font-semibold text-gray-700 uppercase">USERNAME</div>
                                    </div>

                                    <!-- Center username -->
                                    <div class="flex-1 text-center">
                                        <span class="text-sm text-gray-700">04421</span>
                                    </div>

                                    <!-- Right small action buttons -->
                                    <div class="flex justify-end flex-1 gap-2">
                                        <button type="button"
                                            class="flex items-center justify-center w-8 h-8 text-gray-600 bg-white border rounded hover:bg-gray-50"
                                            title="Reset username">
                                            <i class="fa fa-undo"></i>
                                        </button>

                                        <button type="button"
                                            class="flex items-center justify-center w-8 h-8 text-gray-600 bg-white border rounded hover:bg-gray-50"
                                            title="Send username">
                                            <i class="fa fa-share-square-o"></i>
                                        </button>
                                    </div>
                                </div>
                        </div>
                        <div x-data="{
                            showMobile: false,
                            editing: false
                        }" class="mt-4 border rounded shadow">
                            <!-- Header -->
                            <div class="flex items-center justify-between px-4 py-2 text-white bg-green-500 rounded-t">
                                <span class="font-semibold uppercase">Mobile & Email Details</span>
                                <div class="flex gap-2">
                                    <a href="{{ route('member.mobile', $member->id) }}">
                                        <i class="cursor-pointer fa fa-pencil" @click="editing = !editing"></i>
                                    </a>
                                    <i class="cursor-pointer fa" :class="showMobile ? 'fa-minus' : 'fa-plus'"
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
                        <div class="mt-4 bg-white border rounded shadow">
                            <div class="h-1 bg-green-500"></div>
                            <!-- Header -->
                            <div class="flex items-center justify-between px-4 py-2 rounded-t">
                                <span class="font-semibold uppercase">
                                    {{ isset($member) ? $member->member_info_first_name . ' ' . $member->member_info_last_name : 'Add member' }}
                                </span>
                                <!-- Redirect to create page -->
                                <a href="{{ isset($member) ? route('minor.create', ['member_id' => $member->id, 'type' => 'member']) : '#' }}"
                                    class="px-4 py-1 text-sm text-white bg-green-500 rounded-r hover:bg-green-600">
                                    + Minor
                                </a>
                            </div>
                            <!-- Table for minors -->
                            <div class="p-4">
                                <table class="w-full text-sm text-left">
                                    <thead>
                                        <tr class="border px-4 py-2">
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
                    <div class="mt-4 bg-white border rounded shadow-sm">

                        <!-- Top red border -->
                        <div class="h-1 rounded-t" style="background:red;"></div>

                        <!-- Header -->
                        <div class="px-4 py-3 bg-white border-b">
                            <h6 class="font-medium tracking-wide text-gray-700 text-md">
                                SHARE HOLDING DETAILS
                            </h6>
                        </div>

                        <!-- Table Body -->
                        <div class="px-6 py-4">
                            <table class="w-full border-collapse mb-4">
                                <tbody>
                                    <tr>
                                        <th class="px-4 py-2 text-xs font-semibold text-start text-gray-700 uppercase">
                                            Total No. of Shares
                                        </th>
                                        <td class="px-4 py-2 text-sm text-start text-gray-700">
                                            {{ $shareholdings->sum('shares') ?? '—' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div>
                        <!-- ADDRESS & CONTACT INFO -->
                        <div class="mt-4 border rounded shadow">
                            <div class="flex items-center justify-between px-4 py-2 text-white rounded-t"
                                style="background-color:#3c8dbc;">
                                <span class="font-semibold uppercase">Address</span>
                                <div class="flex gap-2">
                                    <a href="{{ route('member.address', $member->id) }}">
                                        <i class="cursor-pointer fa fa-pencil text-white-600 hover:text-blue-800"></i>
                                    </a>
                                    <i :class="showAddress ? 'fa fa-minus' : 'fa fa-plus'"
                                        @click="showAddress = !showAddress"></i>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 space-y-4 text-sm bg-white" x-show="showAddress" x-transition>
                            <h5 class="mb-2 font-semibold text-center uppercase">Correspondence Address</h5>
                            <div class="flex justify-between py-2 border-b">
                                <span class="font-medium uppercase">Address</span>
                                <span>{{ $member->address?->member_address_line_1 ?? '' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b">
                                <span class="font-medium uppercase">Para/ Ward/ Panchayat/ Area</span>
                                <span>
                                    {{ $member->address?->member_address_para ?? '' }}/
                                    {{ $member->address?->member_address_ward ?? '' }}/
                                    {{ $member->address?->member_address_panchayat ?? '' }}/
                                    {{ $member->address?->member_address_area ?? '' }}
                                </span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="font-medium uppercase">Landmark</span>
                                <span>{{ $member->address?->member_address_landmark ?? '' }}</span>
                            </div>

                            <h5 class="mb-2 font-semibold text-center uppercase">Permanent Address</h5>
                            <div class="flex justify-between py-2 border-b">
                                <span class="font-medium uppercase">Address</span>
                                <span>{{ $member->address?->member_address_address ?? '' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b uppercase">
                                <span class="font-medium">City / District</span>
                                <span>{{ $member->address?->member_perm_address_city ?? '' }}/
                                    {{ $member->address?->member_address_city_district ?? '' }}
                                </span>
                            </div>
                            <div class="flex justify-between py-2 border-b uppercase">
                                <span class="font-medium">State</span>
                                <span>{{ $member->address?->state?->name ?? 'N/A' }}</span>
                            </div>

                            <div class="flex justify-between py-2">
                                <span class="font-medium uppercase">GPS Lat/ Log</span>
                                <span>{{ $member->address?->member_gps_location_latitude ?? '' }}
                                    {{ $member->address?->member_gps_location_latitude ?? '' }}
                                </span>
                            </div>
                        </div>
                        <!-- BANK DETAILS -->
                        <div class="mt-4 bg-green-500 border rounded shadow">
                            <div class="flex items-center justify-between px-4 py-2 text-white bg-orange-500 rounded-t">
                                <span class="font-semibold uppercase uppercase">Bank Details</span>
                                <div class="flex gap-2 space-x-2">
                                    <i class="cursor-pointer fa fa-pencil"></i>
                                    <i class="cursor-pointer fa" :class="showBank ? 'fa-minus' : 'fa-plus'"
                                        @click="showBank = !showBank"></i>
                                </div>
                            </div>
                            <div class="p-4 text-sm bg-white" x-show="showBank" x-transition>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="font-medium uppercase">Bank Name</span>
                                    <span>{{ $member->branch?->branch_name ?? '' }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="font-medium uppercase">IFSC Code</span>
                                    <span>{{ $member->branch?->ifsc_code ?? '' }}</span>
                                </div>

                                <div class="flex justify-between py-2 border-b">
                                    <span class="font-medium uppercase">Account Type</span>
                                    <span>
                                        @foreach ($member->accounts as $acc)
                                            {{ $acc->account_type }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    </span>
                                </div>

                                <div class="flex justify-between py-2">
                                    <span class="font-medium uppercase">Account No.</span>
                                    <span>
                                        @foreach ($member->accounts as $acc)
                                            {{ $acc->account_no }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    </span>
                                </div>

                            </div>
                        </div>

                        <!-- MEMBER ACCOUNTS -->
                        <div class="mt-4 bg-green-500 border rounded shadow">
                            <div class="px-4 py-2 font-semibold text-white uppercase bg-green-600 rounded-t ">
                                Customer Accounts
                            </div>
                            <div class="flex bg-white border-b">
                                <button
                                    class="px-4 py-2 text-sm font-semibold text-green-600 bg-white border border-b-0 border-gray-300 rounded-tl">
                                    Active Account
                                </button>
                                <button
                                    class="px-4 py-2 text-sm font-semibold text-gray-500 border border-b-0 border-gray-300 hover:text-green-600">
                                    Closed Account
                                </button>
                            </div>
                            <div class="bg-white">
                                <table class="w-full text-sm text-left border-collapse">
                                    <thead class="border-b">
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
@endsection
