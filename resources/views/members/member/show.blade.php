@extends('layout.main')
@section('page-title',
    isset($member)
    ? $member->member_info_first_name . ' ' . $member->member_info_last_name
    : 'Add
    member')

    @push('script')
        {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
        {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
    @endpush

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
        <!-- Left Panel -->
        <div class="col-span-12 lg:col-span-6 box overflow-x-hidden">
            <table class="w-full whitespace-nowrap text-sm">
                <tbody>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <th class="py-2 px-6">
                            <div class="flex items-center gap-3"><span>Membership Type</span></div>
                        </th>
                        <td class="p-2">
                            <div><span>REGULAR</span></div>
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
                            <div><span>Test Test</span></div>
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
                            <div><span>dhayari</span></div>
                        </td>
                    </tr>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <th class="py-2 px-6">
                            <div class="flex items-center gap-3"><span>Advisor/ Staff</span></div>
                        </th>
                        <td class="p-2">
                            <div><span></span></div>
                        </td>
                    </tr>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <th class="py-2 px-6">
                            <div class="flex items-center gap-3"><span>Old Member No</span></div>
                        </th>
                        <td class="p-2">
                            <div><span></span></div>
                        </td>
                    </tr>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <th class="py-2 px-6">
                            <div class="flex items-center gap-3"><span>Enrollment Date</span></div>
                        </th>
                        <td class="p-2">
                            <div><span>29 July 2025</span></div>
                        </td>
                    </tr>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <th class="py-2 px-6">
                            <div class="flex items-center gap-3"><span>Name</span></div>
                        </th>
                        <td class="p-2">
                            <div><span>Mr. ashok jagdale</span></div>
                        </td>
                    </tr>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <th class="py-2 px-6">
                            <div class="flex items-center gap-3"><span>DOB</span></div>
                        </th>
                        <td class="p-2">
                            <div><span>17 Jul 1970</span></div>
                        </td>
                    </tr>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <th class="py-2 px-6">
                            <div class="flex items-center gap-3"><span>Age</span></div>
                        </th>
                        <td class="p-2">
                            <div><span>55 years</span></div>
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
                            <div><span>Male</span></div>
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
                            <div><span></span></div>
                        </td>
                    </tr>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <th class="py-2 px-6">
                            <div class="flex items-center gap-3"><span>Mother Name</span></div>
                        </th>
                        <td class="p-2">
                            <div><span></span></div>
                        </td>
                    </tr>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <th class="py-2 px-6">
                            <div class="flex items-center gap-3"><span>Marital Status</span></div>
                        </th>
                        <td class="p-2">
                            <div><span></span></div>
                        </td>
                    </tr>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <th class="py-2 px-6">
                            <div class="flex items-center gap-3"><span>Religion</span></div>
                        </th>
                        <td class="p-2">
                            <div><span></span></div>
                        </td>
                    </tr>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <th class="py-2 px-6">
                            <div class="flex items-center gap-3"><span>Qualification</span></div>
                        </th>
                        <td class="p-2">
                            <div><span></span></div>
                        </td>
                    </tr>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <th class="py-2 px-6">
                            <div class="flex items-center gap-3"><span>Husband/ Wife Name</span></div>
                        </th>
                        <td class="p-2">
                            <div><span></span></div>
                        </td>
                    </tr>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <th class="py-2 px-6">
                            <div class="flex items-center gap-3"><span>Husband/ Wife D.O.B</span></div>
                        </th>
                        <td class="p-2">
                            <div><span></span></div>
                        </td>
                    </tr>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <th class="py-2 px-6">
                            <div class="flex items-center gap-3"><span>Occupation</span></div>
                        </th>
                        <td class="p-2">
                            <div><span></span></div>
                        </td>
                    </tr>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <th class="py-2 px-6">
                            <div class="flex items-center gap-3"><span>Monthly Income</span></div>
                        </th>
                        <td class="p-2">
                            <div><span></span></div>
                        </td>
                    </tr>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <th class="py-2 px-6">
                            <div class="flex items-center gap-3"><span>Collection Time</span></div>
                        </th>
                        <td class="p-2">
                            <div><span></span></div>
                        </td>
                    </tr>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <th class="py-2 px-6">
                            <div class="flex items-center gap-3"><span>Form 15G/15H Uploaded (FY 2025 - 2026)</span></div>
                        </th>
                        <td class="p-2">
                            <div><span>No</span></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Right Panel -->
        <div class="col-span-12 lg:col-span-6 box overflow-x-hidden">
        </div>
    </div>
@endsection
