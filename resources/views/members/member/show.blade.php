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
                                <div><span>REGULAR</span></div>
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
                    </tbody>
                </table>
            </div>

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
                                <th class="px-6 py-2 font-semibold text-left">Aadhaar No.</th>
                                <td class="flex items-center justify-between px-6 py-2">
                                    <span>XXXX XXXX 1231</span>
                                    <i class="text-green-600 fa fa-check-circle"></i>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-left">Voter ID No.</th>
                                <td class="px-6 py-2">-</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-left">Pan No.</th>
                                <td class="flex items-center justify-between px-6 py-2">
                                    <span>CGI009876O</span>
                                    <i class="text-green-600 fa fa-check-circle"></i>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-left">Ration Card No.</th>
                                <td class="px-6 py-2">-</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-left">Meter No.</th>
                                <td class="px-6 py-2">-</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-left">CI No.</th>
                                <td class="px-6 py-2">-</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-left">CI Relation</th>
                                <td class="px-6 py-2">-</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-left">DL No</th>
                                <td class="px-6 py-2">-</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-left">CKYC No</th>
                                <td class="px-6 py-2">-</td>
                            </tr>
                            <tr>
                                <th class="px-6 py-2 font-semibold text-left">CKYC Updated At</th>
                                <td class="px-6 py-2">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

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
                                <th class="px-6 py-2 font-semibold text-left">Name</th>
                                <td class="flex items-center justify-between px-6 py-2">
                                    <span></span>

                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-left">DOB</th>
                                <td class="px-6 py-2"></td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-left">Gender</th>
                                <td class="flex items-center justify-between px-6 py-2">
                                    <span>Male</span>

                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-left">Relation</th>
                                <td class="px-6 py-2"></td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-left">Meter No.</th>
                                <td class="px-6 py-2">-</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-left">CI No.</th>
                                <td class="px-6 py-2">-</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-left">CI Relation</th>
                                <td class="px-6 py-2">-</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-left">DL No</th>
                                <td class="px-6 py-2">-</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-left">CKYC No</th>
                                <td class="px-6 py-2">-</td>
                            </tr>
                            <tr>
                                <th class="px-6 py-2 font-semibold text-left">CKYC Updated At</th>
                                <td class="px-6 py-2">-</td>
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
                                    <span></span>

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
        <div class="col-span-12 lg:col-span-6 overflow-x-hidden" x-data="{ showMobile: true, showAddress: true,: true, showMember: true }">

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
                            <span>9090908080</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="font-medium">Email</span>
                            <span>-</span>
                        </div>
                    </div>
                </div>

                <!-- MINORS -->
                <div class="mt-4 bg-white border rounded shadow">
                    <div class="h-1 bg-green-500"></div>
                    <!-- Header -->
                    <div class="flex items-center justify-between px-4 py-2 rounded-t">
                        <span class="font-semibold uppercase">Minors</span>
                        <button class="px-2 py-1 text-xs border rounded " style="background-color: #f4f4f4">+
                            Minor

                        </button>
                    </div>
                </div>

                <!-- ADDRESS & CONTACT INFO -->
                <div class="mt-4 border rounded shadow">
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
                            <span>Maharashtra 411239</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="font-medium">Para/ Ward/ Panchayat/ Area</span>
                            <span>-</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="font-medium">Landmark</span>
                            <span>-</span>
                        </div>

                        <h5 class="mb-2 font-semibold text-center">Permanent Address</h5>
                        <div class="flex justify-between py-2 border-b">
                            <span class="font-medium">Address</span>
                            <span>-</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="font-medium">City / District</span>
                            <span>-</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="font-medium">State</span>
                            <span>Rajasthan</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="font-medium">GPS Lat/ Log</span>
                            <span>-</span>
                        </div>
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
                            <span></span>
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

            </div>
        </div>
    </div>
@endsection
