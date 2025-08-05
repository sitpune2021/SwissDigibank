@extends('layout.main')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@section('page-title',
    isset($member)
    ? $member->member_info_first_name . ' ' . $member->member_info_last_name
    : 'Add
    member')

@section('content')
    <div class="flex flex-wrap gap-3 mb-3 text-center">
        <a class="btn-info rounded-md px-2 py-1 text-white  text-sm bg-blue-500 hover:bg-blue-600">SHARE HOLDINGS</a>

        <a class="btn-success rounded-md px-2 py-1 text-white  text-sm bg-green-500 hover:bg-green-600">ALLOCATE SHARES</a>

        <a class="btn-warning rounded-md px-2 py-1 text-white  text-sm bg-yellow-500 hover:bg-yellow-600">ADD SHARE
            AMOUNT</a>

        <a class="btn-warning rounded-md px-2 py-1 text-white  text-sm bg-yellow-500 hover:bg-yellow-600">ADD MEMBERSHIP
            CHARGES</a>

        <a class="btn-info rounded-md px-2 py-1 text-white  text-sm bg-blue-500 hover:bg-blue-600">VIEW TRANSACTIONS</a>

        <!-- Dropdown -->
        <div class="relative">
            <button type="button" class="rounded-md px-2 py-1 text-white  text-sm bg-green-500 hover:bg-green-600"
                onclick="toggleDropdown()">DEBIT OTHER CHARGES</button>
            <ul id="dropdown-menu" class="absolute right-0 mt-2 hidden bg-white border rounded shadow-md text-left z-10">
                <li><a class="block px-4 py-2 hover:bg-gray-100">OTHER CHARGES LIST</a></li>
                <li><a class="block px-4 py-2 hover:bg-gray-100">DEBIT OTHER CHARGES</a></li>
                <li><a class="block px-4 py-2 hover:bg-gray-100">CLEAR DUES</a></li>
            </ul>
        </div>

        <a title="DOWNLOAD 15G/ 15H"
            class="btn-default rounded-md px-2 py-1 text-sm text-gray-700 bg-gray-200 hover:bg-gray-300">
            <i class="fa fa-print"></i> DOWNLOAD 15G/ 15H
        </a>

        <a class="btn-warning rounded-md px-2 py-1 text-white  text-sm bg-yellow-500 hover:bg-yellow-600">
            <i class="fa fa-plus" aria-hidden="true"></i> UPLOAD 15G/ 15H
        </a>

        <a class="btn-danger rounded-md px-2 py-1 text-white  text-sm bg-red-500 hover:bg-red-600">REMOVE MEMBER</a>

        <a class="btn-primary rounded-md px-2 py-1 text-white  text-sm bg-indigo-500 hover:bg-indigo-600">
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
                                <div class="flex items-center gap-3"><span>Membership Type</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->membership_type }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Create on</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>Admin App</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Created by</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ auth()->user()->name }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Status</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>ACTIVE</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Branch</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->general_branch }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Advisor/ Staff</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->general_advisor_staff }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Old Member No</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_old_member_no }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Enrollment Date</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->general_enrollment_date }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Name</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_first_name }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>DOB</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_dob }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Age</span></div>
                            </th>
                            <td class="p-2">
                                <div><span></span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Senior Citizen</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>No</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Gender</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_gender }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Folio No.</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>4415</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Father Name</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_middle_name }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Mother Name</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_mother_name }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Marital Status</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_marital_status }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Religion</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_religion }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Qualification</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_qualification }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Husband/ Wife Name </span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_spouse_name }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Husband/ Wife D.O.B</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_spouse_dob }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Occupation</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_occupation }}</span></div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Monthly Income</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_monthly_income }}</span></div>
                            </td>
                        </tr>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Collection Time</span></div>
                            </th>
                            <td class="p-2">
                                <div><span>{{ $member->member_info_collection_time }}</span></div>
                            </td>
                        </tr>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Form 15G/ 15H Uploaded<br>(FY 2025 -
                                        2026)</span></div>
                            </th>
                            <td class="p-2">
                                <div><span></span></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- Member KYC Info --}}
            <div x-data="{ open: true }" class="mt-4 rounded-md shadow">
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
                                <th class="px-6 py-2 font-semibold text-start">Aadhaar No.</th>
                                <td class="flex items-center justify-between px-6 py-2"text-start>
                                    <span>{{ $member->kyc->member_kyc_aadhaar_no }}</span>
                                    <i class="text-green-600 fa fa-check-circle"></i>
                                </td>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Voter ID No.</th>
                                <td class="flex items-center justify-between px-6 py-2"text-start>
                                <td class="px-6 py-2">{{ $member->kyc->member_kyc_voter_id_no }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Pan No.</th>
                                <td class="flex items-center justify-between px-6 py-2"text-start>
                                    <span>{{ $member->kyc->member_kyc_pan_no }}</span>
                                    <i class="text-green-600 fa fa-check-circle"></i>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Ration Card No.</th>
                                <td class="flex items-center justify-between px-6 py-2"text-start>
                                    <span>{{ $member->kyc->member_kyc_ration_card_no }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Meter No.</th>
                                <td class="px-6 py-2">{{ $member->kyc->member_kyc_meter_no }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">CI No.</th>
                                <td class="px-6 py-2">{{ $member->kyc->member_kyc_ci_no }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">CI Relation</th>
                                <td class="px-6 py-2">{{ $member->kyc->member_kyc_ci_relation }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">DL No</th>
                                <td class="px-6 py-2">{{ $member->kyc->member_kyc_dl_no }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">CKYC No</th>
                                {{-- <td class="px-6 py-2">{{$member->kyc->member_kyc_ci_no}}</td> --}}
                            </tr>
                            <tr>
                                <th class="px-6 py-2 font-semibold text-start">CKYC Updated At</th>
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
                    <span class="font-semibold uppercase">Member Nominee Info</span>
                    <i :class="open ? 'fa fa-minus' : 'fa fa-plus'"></i>
                </div>

                <div x-show="open" x-transition class="bg-white">
                    <table class="w-full text-sm">
                        <tbody>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Name</th>
                                <td class="flex items-center justify-between px-6 py-2">
                                    <span>{{ $member->kyc->nominee_name }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">DOB</th>
                                <td class="px-6 py-2"><span>{{ $member->kyc->nominee_dob }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Gender</th>
                                <td class="flex items-center justify-between px-6 py-2">
                                    <span>{{ $member->kyc->nominee_gender }}</span>

                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Relation</th>
                                <td class="px-6 py-2">
                                    <span>{{ $member->kyc->nominee_relation }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Mobile No.</th>
                                <td class="px-6 py-2">
                                    <span>{{ $member->kyc->nominee_mobile_no }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Aadhaar No.</th>
                                <td class="px-6 py-2"><span>{{ $member->kyc->nominee_aadhaar_no }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Voter ID No. </th>
                                <td class="px-6 py-2"><span>{{ $member->kyc->nominee_voter_id_no }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Pan No.</th>
                                <td class="px-6 py-2">
                                    <span>{{ $member->kyc->nominee_pan_no }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Address</th>
                                <td class="px-6 py-2"><span>{{ $member->kyc->nominee_address }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="px-6 py-2 font-semibold text-start">Ration Card No.</th>
                                <td class="px-6 py-2"><span>{{ $member->kyc->nominee_ration_card_no }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div x-data="{ open: true }" class="mt-4 rounded shadow">
                <!-- Header -->
                <div class="flex items-center justify-between px-4 py-2 text-white bg-green-500 rounded-t cursor-pointer"
                    @click="open = !open">
                    <span class="font-semibold uppercase">Documents</span>
                    <div class="flex gap-2 space-x-2">
                        <i class="cursor-pointer fa fa-pencil"></i>
                        <i :class="open ? 'fa fa-minus' : 'fa fa-plus'"></i>
                    </div>
                </div>

                <!-- Content -->
                <div x-show="open" x-transition class="bg-white">
                    <table class="w-full text-sm">
                        <tbody>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Name</th>
                                <td class="flex items-center justify-between px-6 py-2"text-start>
                                    <span>iiiiiiiiii</span>

                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">DOB</th>
                                <td class="px-6 py-2"text-start></td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Gender</th>
                                <td class="flex items-center justify-between px-6 py-2"text-start>
                                    <span></span>

                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Relation</th>
                                <td class="px-6 py-2"text-start></td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Meter No.</th>
                                <td class="px-6 py-2"text-start></td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">CI No.</th>
                                <td class="px-6 py-2"text-start></td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">CI Relation</th>
                                <td class="px-6 py-2"text-start></td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">DL No</th>
                                <td class="px-6 py-2"text-start></td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">CKYC No</th>
                                <td class="px-6 py-2"text-start></td>
                            </tr>
                            <tr>
                                <th class="px-6 py-2 font-semibold text-start">CKYC Updated At</th>
                                <td class="px-6 py-2"text-start></td>
                            </tr>
                        </tbody>
                    </table>
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
                <!-- MOBILE & EMAIL DETAILS -->
                <div class="mt-4 border rounded shadow">
                    <div class="flex items-center justify-between px-4 py-2 text-white bg-green-500 rounded-t">
                        <span class="font-semibold uppercase">Mobile & Email Details</span>
                        <div class="flex gap-2">
                            <i class="cursor-pointer fa fa-pencil"></i>
                            <i class="cursor-pointer fa" :class="showMobile ? 'fa-minus' : 'fa-plus'"
                                @click="showMobile = !showMobile"></i>
                        </div>
                    </div>
                    <div class="p-4 text-sm bg-white" x-show="showMobile" x-transition>
                        <div class="flex justify-between py-2 border-b">
                            <span class="font-medium">Mobile No</span>
                            <span>{{ $member->member_info_mobile_no }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="font-medium">Email</span>
                            <span>{{ $member->member_info_email }}</span>
                        </div>
                    </div>
                </div>

                <!-- MINORS -->
                <div class="mt-4 bg-white border rounded shadow">
                    <div class="h-1 bg-green-500"></div>
                    <!-- Header -->
                    <div class="flex items-center justify-between px-4 py-2 rounded-t">
                        <span class="font-semibold uppercase">Minors</span>
                        <!-- Redirect to create page -->
                        <a href="{{ route('minor.create', ['member_id' => $member->id]) }}"
                            class="px-2 py-1 text-xs border rounded bg-gray-100 hover:bg-gray-200">
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
                                            {{ $minor->last_name }}</td>
                                        <td class="border  px-4 py-2">
                                            {{ \Carbon\Carbon::parse($minor->dob)->format('d/m/Y') }}</td>
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


                <!-- BANK DETAILS -->
                <div class="mt-4 bg-green-500 border rounded shadow">
                    <div class="flex items-center justify-between px-4 py-2 text-white bg-orange-500 rounded-t">
                        <span class="font-semibold uppercase">Bank Details</span>
                        <div class="flex gap-2 space-x-2">
                            <i class="cursor-pointer fa fa-pencil"></i>
                            <i class="cursor-pointer fa" :class="showBank ? 'fa-minus' : 'fa-plus'"
                                @click="showBank = !showBank"></i>
                        </div>
                    </div>
                    <div class="p-4 text-sm bg-white" x-show="showBank" x-transition>
                        <div class="flex justify-between py-2 border-b">
                            <span class="font-medium">Bank Name</span>
                            <span>{{ $member->kyc->member_kyc_aadhaar_no }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="font-medium">IFSC Code</span>
                            <span></span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="font-medium">Account Type</span>
                            <span></span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="font-medium">Account No.</span>
                            <span></span>
                        </div>
                    </div>
                </div>
                <!-- ADDRESS & CONTACT INFO -->
                {{-- <div class="mt-4 border rounded shadow">
                    <div class="flex items-center justify-between px-4 py-2 text-white rounded-t"
                        style="background-color:#3c8dbc;">
                        <span class="font-semibold uppercase">Address & Contact Info</span>
                        <div class="flex gap-2">
                            <i class="cursor-pointer fa fa-pencil"></i>
                            <i class="cursor-pointer fa" :class="showAddress ? 'fa-minus' : 'fa-plus'"
                                @click="showAddress = !showAddress"></i>
                        </div>
                    </div>
                    <div class="p-4 space-y-4 text-sm bg-white" x-show="showAddress" x-transition>
                        <h5 class="mb-2 font-semibold text-center">Correspondence Address</h5>
                        <div class="flex justify-between py-2 border-b">
                            <span class="font-medium">Address</span>
                            <span>{{ $member->address->member_address_line_1 }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="font-medium">Para/ Ward/ Panchayat/ Area</span>
                            <span>
                                {{ $member->address->member_address_para }}
                                {{ $member->address->member_address_ward }}
                                {{ $member->address->member_address_panchayat }}
                                {{ $member->address->member_address_area }}
                            </span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="font-medium">Landmark</span>
                            <span>{{ $member->address->member_address_landmark }}</span>
                        </div>

                        <h5 class="mb-2 font-semibold text-center">Permanent Address</h5>
                        <div class="flex justify-between py-2 border-b">
                            <span class="font-medium">Address</span>
                            <span>{{ $member->address->member_address_address }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="font-medium">City / District</span>
                            <span>{{ $member->address->member_perm_address_city }}
                                {{ $member->address->member_address_city_district }}
                            </span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="font-medium">State</span>
                            <span>{{ $member->address->member_perm_address_state }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="font-medium">GPS Lat/ Log</span>
                            <span>{{ $member->address->member_gps_location_latitude }}
                              {{ $member->address->member_gps_location_latitude }}
                            </span>
                        </div>
                    </div>
                </div> --}}
                
            </div>
        </div>
    </div>
@endsection
