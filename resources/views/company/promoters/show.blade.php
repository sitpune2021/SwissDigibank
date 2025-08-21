@extends('layout.main')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@section('page-title', isset($promoter) ? $promoter->first_name : 'Add Promoter')

@section('content')
    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>
    <div class="flex flex-wrap gap-3 mb-3 text-center">

        <a class="btn-info rounded-md px-2 py-1 text-white  text-sm bg-blue-500 hover:bg-blue-600">VIEW TRANSACTIONS</a>

        <a href="{{ isset($promoter) ? route('form15g15h.download.promoter', $promoter->id) : '#' }}"
            title="DOWNLOAD 15G/ 15H"
            class="btn-default rounded-md px-2 py-1 text-sm text-gray-700 bg-gray-200 hover:bg-gray-300">
            <i class="fa fa-download"></i> DOWNLOAD 15G/15H
        </a>

        <a href="{{ isset($promoter) ? route('form15g15h.create', ['promoter_id' => $promoter->id, 'type' => 'promoter']) : '#' }}"
            class="btn-warning rounded-md px-2 py-1 text-white text-sm bg-yellow-500 hover:bg-yellow-600">
            <i class="fa fa-plus" aria-hidden="true"></i> UPLOAD 15G/ 15H
        </a>
    </div>

    <div class="grid grid-cols-12 gap-4 xxl:gap-6">
        <div class="col-span-12 lg:col-span-6 overflow-x-hidden">
            <div class="col-span-12 box overflow-x-hidden">
                <table class="w-full whitespace-nowrap text-sm">
                    <tbody>

                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Branch</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>{{ $promoter->branch->branch_name }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Enrollment Date</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>{{ $promoter->enrollment_date }}</span>
                                </div>
                            </td>
                        </tr>

                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Name</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>{{ $promoter->first_name . ' ' . $promoter->middle_name . ' ' . $promoter->last_name }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>DOB</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>{{ $promoter->date_of_birth }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Age</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>{{ \Carbon\Carbon::parse($promoter->date_of_birth)->age }} years</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Senior Citizen</span></div>
                            </th>
                            @php
                                $dob = \Carbon\Carbon::parse($promoter->date_of_birth);
                                $age = $dob->age;
                            @endphp
                            <td class="p-2">
                                @if ($age >= 60)
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                        Yes
                                    </span>
                                @else
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                        No
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Gender</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>{{ $promoter->gender }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Folio No.</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>{{ $promoter->folio_no }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Father Name</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>{{ $promoter->father_name }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Mother Name</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>{{ $promoter->mother_name }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Marital Status</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>{{ $promoter->maritalStatus?->status }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Religion</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>{{ $promoter->religion?->name }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Spouse Name </span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>{{ $promoter->husband_wife_name }}</span>
                                </div>
                            </td>
                        </tr>

                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Occupation</span></div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span>{{ $promoter->occupation }}</span>
                                </div>
                            </td>
                        </tr>

                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <th class="py-2 px-6">
                                <div class="flex items-center gap-3"><span>Form 15G/ 15H Uploaded<br>(FY 2025 -
                                        2026)</span>
                                </div>
                            </th>
                            <td class="p-2">
                                <div>
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                        {{ $promoter->form15G15H->count() >= 1 ? 'Yes' : 'No' }}
                                    </span>
                                </div>
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
                                <td class="flex items-center justify-between px-6 py-2 text-start">
                                    <span>{{ $promoter->kyc->aadhaar_no }}</span>
                                    <i class="text-green-600 fa fa-check-circle"></i>
                                </td>
                            </tr> {{-- Added closing </tr> here --}}
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Voter ID No.</th>
                                <td class="flex items-center justify-between px-6 py-2 text-start">
                                    <span>{{ $promoter->kyc->voter_id_no }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Pan No.</th>
                                <td class="flex items-center justify-between px-6 py-2 text-start">
                                    <span>{{ $promoter->kyc->pan_no }}</span>
                                    <i class="text-green-600 fa fa-check-circle"></i>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Ration Card No.</th>
                                <td class="flex items-center justify-between px-6 py-2 text-start">
                                    <span>{{ $promoter->kyc->ration_card_no }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Meter No.</th>
                                <td class="px-6 py-2 text-start">
                                    <span>{{ $promoter->kyc->meter_no }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">CI No.</th>
                                <td class="px-6 py-2 text-start">
                                    <span>{{ $promoter->kyc->ci_no }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">CI Relation</th>
                                <td class="px-6 py-2 text-start">
                                    <span>{{ $promoter->kyc->ci_relation }}</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">DL No</th>
                                <td class="px-6 py-2 text-start">
                                    <span>{{ $promoter->kyc->dl_no }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Member Nominee Info --}}
            <div x-data="{ open: true }" class="mt-4 rounded shadow">
                <div class="flex items-center justify-between px-4 py-2 text-white bg-blue-500 rounded-t cursor-pointer"
                    @click="open = !open">
                    <span class="font-semibold uppercase">Nominee Info</span>
                    <i :class="open ? 'fa fa-minus' : 'fa fa-plus'"></i>
                </div>

                <div x-show="open" x-transition class="bg-white">
                    <table class="w-full text-sm">
                        <tbody>
                            <tr class="border-b">
                                <th class="px-6 py-2 font-semibold text-start">Name</th>
                                <td class="flex items-center justify-between px-6 py-2">
                                    <span>{{ $promoter->nominees->first()?->name }}</span>
                                </td>
                            </tr>

                            <div x-show="open" x-transition class="bg-white">
                                <table class="w-full text-sm">
                                    <tbody>
                                        <tr class="border-b">
                                            <th class="px-6 py-2 font-semibold text-start">Name</th>
                                            <td class="flex items-center justify-between px-6 py-2">
                                                <span>{{ $promoter->nominees->first()?->name }}</span>
                                            </td>
                                        </tr>

                                        <tr class="border-b">
                                            <th class="px-6 py-2 font-semibold text-start">Relation</th>
                                            <td class="px-6 py-2">
                                                <span>{{ $promoter->nominees->first()?->relation }}</span>
                                            </td>
                                        </tr>
                                        <tr class="border-b">
                                            <th class="px-6 py-2 font-semibold text-start">Mobile No.</th>
                                            <td class="px-6 py-2">
                                                <span>{{ $promoter->nominees->first()?->mobile_no }}</span>
                                            </td>
                                        </tr>
                                        <tr class="border-b">
                                            <th class="px-6 py-2 font-semibold text-start">Aadhaar No.</th>
                                            <td class="px-6 py-2">
                                                <span>{{ $promoter->nominees->first()?->aadhaar_no }}</span>
                                            </td>
                                        </tr>
                                        <tr class="border-b">
                                            <th class="px-6 py-2 font-semibold text-start">Voter ID No. </th>
                                            <td class="px-6 py-2">
                                                <span>{{ $promoter->nominees->first()?->voter_id_no }}</span>
                                            </td>
                                        </tr>
                                        <tr class="border-b">
                                            <th class="px-6 py-2 font-semibold text-start">Pan No.</th>
                                            <td class="px-6 py-2">
                                                <span>{{ $promoter->nominees->first()?->pan_no }}</span>
                                            </td>
                                        </tr>
                                        <tr class="border-b">
                                            <th class="px-6 py-2 font-semibold text-start">Address</th>
                                            <td class="px-6 py-2">
                                                <span>{{ $promoter->nominees->first()?->address }}</span>
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
                            {{-- <i class="cursor-pointer fa fa-pencil"></i> --}}
                            <a
                                href="{{ isset($promoter) ? route('promotor.document', ['id' => $promoter->id, 'type' => 'promoter']) : '#' }}">
                                <i class="cursor-pointer fa fa-pencil text-white-600 hover:text-blue-800"></i>
                            </a>

                            <i :class="open ? 'fa fa-minus' : 'fa fa-plus'"></i>
                        </div>
                    </div>

                    <!-- Content -->
                    <div x-show="open" x-transition class="bg-white">
                        <table class="w-full text-sm">
                            <tbody>
                                <tr class="border-b">
                                    <th class="px-6 py-2 font-semibold text-start">Photo (Photo)</th>
                                    <td class="flex items-center justify-between px-6 py-2"text-start>
                                        <span></span>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-6 py-2 font-semibold text-start">Signature (Signature)</th>
                                    <td class="px-6 py-2"text-start></td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-6 py-2 font-semibold text-start">Id Proof (Passport)</th>
                                    <td class="flex items-center justify-between px-6 py-2"text-start>
                                        <span></span>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-6 py-2 font-semibold text-start">Id Proof Back (Aadhar Card)</th>
                                    <td class="px-6 py-2"text-start></td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-6 py-2 font-semibold text-start">Address Proof (Passport) </th>
                                    <td class="px-6 py-2"text-start></td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-6 py-2 font-semibold text-start">Address Proof Back (Aadhar Card) </th>
                                    <td class="px-6 py-2"text-start></td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-6 py-2 font-semibold text-start">Pan Number (Pan)</th>
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
                    <!-- Settings Section -->
                    <div class="mt-4 overflow-hidden border rounded shadow">
                        <div class="h-1 bg-red-500"></div>
                        <div class="px-4 py-2 font-semibold uppercase bg-white border-b">Settings</div>
                        <div class="p-4 space-y-4 bg-white">
                            <div class="flex items-center justify-between">
                                <span>Internet Banking / Mob App Enabled</span>
                                <input type="checkbox" class="w-5 h-5 accent-blue-600">
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Money Transfer</span>
                                <input type="checkbox" class="w-5 h-5 accent-blue-600" checked>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Account Locked</span>
                                <input type="checkbox" class="w-5 h-5 accent-blue-600">
                            </div>
                            <div class="flex items-center justify-between">
                                <span>SMS</span>
                                <input type="checkbox" class="w-5 h-5 accent-blue-600" checked>
                            </div>
                        </div>
                    </div>
                    {{-- Internet Banking section --}}
                    <div class="mt-4 bg-white border rounded shadow-sm">

                        <div class="h-1 rounded-t" style="background: #2b9bd6;"></div>

                        <!-- Header -->
                        <div class="px-4 py-3 bg-white border-b">
                            <h3 class="text-sm font-medium tracking-wide text-gray-700">INTERNET BANKING USERNAME</h3>
                        </div>

                        <!-- Body -->
                        <div class="flex items-center justify-between px-6 py-4">
                            <!-- Left label -->
                            <div class="flex-1">
                                <div class="text-xs font-semibold text-gray-700 uppercase">USERNAME</div>
                            </div>

                            <!-- Center username -->
                            <div class="flex-1 text-center">
                                <span class="text-sm text-gray-700">demo04421</span>
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

                        <!-- MINORS -->
                        <div class="mt-4 bg-white border rounded shadow">
                            <div class="h-1 bg-green-500"></div>

                            <!-- Header -->
                            <div class="flex items-center justify-between px-4 py-2 rounded-t">
                                <span class="font-semibold uppercase">
                                    {{ isset($promoter) ? $promoter->first_name : 'Add Promoter' }}
                                </span>

                                <!-- Redirect to create page -->
                                <a href="{{ isset($promoter) ? route('minor.create', ['promotor_id' => $promoter->id, 'type' => 'promotor']) : '#' }}"
                                    class="px-4 py-1 text-sm text-white bg-green-500 {{ isset($promoter) ? 'rounded-r hover:bg-green-600' : 'bg-gray-300 cursor-not-allowed' }}"
                                    {{ isset($promoter) ? '' : 'onclick="return false;"' }}>
                                    + Minor
                                </a>
                            </div>

                            <!-- Table for minors -->
                            <div class="p-4">
                                <table class="w-full text-sm text-left">
                                    <thead>
                                        <tr class="border px-4 py-2">
                                            <th class="font-semibold px-4 py-2 text-start">NAME</th>
                                            <th class="font-semibold text-gray-ft-600 px-4 py-2 text-start">DOB</th>
                                            <th class="font-semibold text-gray-ft-600 py-8 text-left">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($promoter->minor) && is_iterable($promoter->minor))
                                            @foreach ($promoter->minor as $minors)
                                                <tr>
                                                    <td class="border px-4 py-2">{{ $minors?->first_name ?? '' }}
                                                        {{ $minors?->last_name ?? '' }}
                                                    </td>
                                                    <td class="border px-4 py-2">
                                                        {{ \Carbon\Carbon::parse($minors->dob)->format('d/m/Y') }}
                                                    </td>
                                                    <td class="border px-4 py-2">
                                                        <a href="{{ route('minor.show', $minors->id) }}" title="View"
                                                            class="text-green-600 hover:underline mr-2">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                        <a href="{{ route('minor.edit', $minors->id) }}" title="Edit"
                                                            class="text-green-600 hover:underline">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="border px-4 py-2 text-center text-gray-500">No
                                                    minors available.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
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
                                <table class="w-full border-collapse">
                                    <tbody>
                                        <tr>
                                            <th class="px-4 py-2 text-xs font-semibold text-left text-gray-700 uppercase">
                                                No. of Shares
                                            </th>
                                            <td class="px-4 py-2 text-sm text-center text-gray-700">
                                                0
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-4 bg-green-500 border rounded shadow" x-data="{ showPromoterAccounts: false }">
                            <div class="flex items-center justify-between px-4 py-2 text-white bg-orange-500 rounded-t">
                                <span class="font-semibold uppercase">SHARE HOLDING NOMINEE'S INFO</span>
                                <div class="flex gap-2 space-x-2">
                                    <i class="cursor-pointer fa" :class="showPromoterAccounts ? 'fa-minus' : 'fa-plus'"
                                        @click="showPromoterAccounts = !showPromoterAccounts"></i>
                                </div>
                            </div>

                            <div class="p-4 text-sm bg-white" x-show="showPromoterAccounts" x-transition>
                                <div class="p-4">
                                    <table class="w-full text-sm text-left">
                                        <thead>
                                            <tr>
                                                <th class="font-semibold px-4 py-2 text-start">ACCOUNT TYPE</th>
                                                <th class="font-semibold px-4 py-2 text-start">ACCOUNT NO.</th>
                                                <th class="font-semibold px-4 py-2 text-start">OPEN DATE</th>
                                                <th class="font-semibold px-4 py-2 text-start">STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($promoter->minor) && is_iterable($promoter->minor))
                                                @foreach ($promoter->minor as $minors)
                                                    <tr>
                                                        <td>{{ $minors?->first_name ?? '' }}
                                                            {{ $minors?->last_name ?? '' }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($minors->dob)->format('d/m/Y') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($minors->dob)->format('d/m/Y') }}</td>
                                                        <td>
                                                            <a href="{{ route('minor.show', $minors->id) }}"
                                                                title="View"
                                                                class="text-green-600 hover:underline mr-2">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                            <a href="{{ route('minor.edit', $minors->id) }}"
                                                                title="Edit" class="text-green-600 hover:underline">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="border px-4 py-2 text-center text-gray-500">
                                                        No minors available.
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- ADDRESS & CONTACT INFO -->
                        <div class="mt-4 border rounded shadow">
                            <div class="flex items-center justify-between px-4 py-2 text-white rounded-t"
                                style="background-color:#3c8dbc;">
                                <span class="font-semibold uppercase">Address & Contact Info</span>
                                <div class="flex gap-2">
                                    <a
                                        href="{{ isset($promoter) ? route('promotor.address', ['id' => $promoter->id, 'type' => 'promoter']) : '#' }}">
                                        <i class="cursor-pointer fa fa-pencil"></i>
                                    </a>
                                    <i class="cursor-pointer fa" :class="showAddress ? 'fa-minus' : 'fa-plus'"
                                        @click="showAddress = !showAddress"></i>
                                </div>
                            </div>
                            <div class="p-4 space-y-4 text-sm bg-white" x-show="showAddress" x-transition>
                                <h5 class="mb-2 font-semibold text-center">Correspondence Address</h5>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="font-medium">Address</span>
                                    {{-- <span>{{ $member->address->member_address_line_1 }}</span> --}}
                                </div>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="font-medium">Para/ Ward/ Panchayat/ Area</span>
                                    {{-- <span>
                                {{ $member->address->member_address_para }}/
                            {{ $member->address->member_address_ward }}/
                            {{ $member->address->member_address_panchayat }}/
                            {{ $member->address->member_address_area }}
                            </span> --}}
                                </div>
                                <div class="flex justify-between py-2">
                                    <span class="font-medium">Landmark</span>
                                    {{-- <span>{{ $member->address->member_address_landmark }}</span> --}}
                                </div>
                                <div class="flex justify-between py-2">
                                    <span class="font-medium">GPS Lat/ Log</span>
                                    {{-- <span>{{ $member->address->member_gps_location_latitude }}
                            {{ $member->address->member_gps_location_latitude }}
                            </span> --}}
                                </div>
                                <div class="flex justify-between py-2">
                                    <span class="font-medium">Email </span>
                                    {{-- <span>{{ $member->address->member_address_landmark }}</span> --}}
                                </div>
                                <div class="flex justify-between py-2">
                                    <span class="font-medium">Mobile No.</span>
                                    {{-- <span>{{ $member->address->member_address_landmark }}</span> --}}
                                </div>
                            </div>
                        </div>
                        <!-- BANK DETAILS -->
                        <div class="mt-4 bg-red-500 border rounded shadow" x-data="{ showBankDetails: false }">
                            <div class="flex items-center justify-between px-4 py-2 text-white bg-orange-500 rounded-t">
                                <span class="font-semibold uppercase">Bank Details</span>
                                <div class="flex gap-2 space-x-2">
                                    <i class="cursor-pointer fa fa-pencil"></i>
                                    <i class="cursor-pointer fa" :class="showBankDetails ? 'fa-minus' : 'fa-plus'"
                                        @click="showBankDetails = !showBankDetails"></i>
                                </div>
                            </div>
                            <div class="p-4 text-sm bg-white" x-show="showBankDetails" x-transition>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="font-medium">Bank Name</span>
                                    {{-- <span>{{ $member->branch->branch_name }}</span> --}}
                                </div>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="font-medium">IFSC Code</span>
                                    {{-- <span>{{ $member->branch->ifsc_code }}</span> --}}
                                </div>
                                {{-- <div class="flex justify-between py-2 border-b">
        <span class="font-medium">Account Type</span>
        <span>{{ $member->accounts->account_type }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="font-medium">Account No.</span>
                        <span>{{ $member->accounts->account_no }}</span>
                    </div> --}}
                            </div>
                        </div>

                        <!-- Promoter AccountsS -->
                        <div class="mt-4 bg-green-500 border rounded shadow" x-data="{ showPromoterAccounts: false }">
                            <div class="flex items-center justify-between px-4 py-2 text-white bg-orange-500 rounded-t">
                                <span class="font-semibold uppercase">Promoter Accounts</span>
                                <div class="flex gap-2 space-x-2">
                                    <i class="cursor-pointer fa" :class="showPromoterAccounts ? 'fa-minus' : 'fa-plus'"
                                        @click="showPromoterAccounts = !showPromoterAccounts"></i>
                                </div>
                            </div>

                            <div class="p-4 text-sm bg-white" x-show="showPromoterAccounts" x-transition>
                                <div class="p-4">
                                    <table class="w-full text-sm text-left">
                                        <thead>
                                            <tr>
                                                <th class="font-semibold px-4 py-2 text-start">ACCOUNT TYPE</th>
                                                <th class="font-semibold px-4 py-2 text-start">ACCOUNT NO.</th>
                                                <th class="font-semibold px-4 py-2 text-start">OPEN DATE</th>
                                                <th class="font-semibold px-4 py-2 text-start">STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($promoter->minor) && is_iterable($promoter->minor))
                                                @foreach ($promoter->minor as $minors)
                                                    <tr>
                                                        <td>{{ $minors?->first_name ?? '' }}
                                                            {{ $minors?->last_name ?? '' }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($minors->dob)->format('d/m/Y') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($minors->dob)->format('d/m/Y') }}</td>
                                                        <td>
                                                            <a href="{{ route('minor.show', $minors->id) }}"
                                                                title="View"
                                                                class="text-green-600 hover:underline mr-2">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                            <a href="{{ route('minor.edit', $minors->id) }}"
                                                                title="Edit" class="text-green-600 hover:underline">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="border px-4 py-2 text-center text-gray-500">
                                                        No minors available.
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- JOINT ACCOUNTS -->
                        <div class="mt-4 bg-blue-500 border rounded shadow" x-data="{ showJointAccounts: false }">
                            <div class="flex items-center justify-between px-4 py-2 text-white bg-orange-500 rounded-t">
                                <span class="font-semibold uppercase">JOINT ACCOUNTS</span>
                                <div class="flex gap-2 space-x-2">
                                    <i class="cursor-pointer fa" :class="showJointAccounts ? 'fa-minus' : 'fa-plus'"
                                        @click="showJointAccounts = !showJointAccounts"></i>
                                </div>
                            </div>

                            <div class="p-4 text-sm bg-white" x-show="showJointAccounts" x-transition>
                                <div class="p-4">
                                    <table class="w-full text-sm text-left">
                                        <thead>
                                            <tr>
                                                <th class="font-semibold px-4 py-2 text-start">ACCOUNT TYPE</th>
                                                <th class="font-semibold px-4 py-2 text-start">ACCOUNT NO.</th>
                                                <th class="font-semibold px-4 py-2 text-start">OPEN DATE</th>
                                                <th class="font-semibold px-4 py-2 text-start">STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($promoter->minor) && is_iterable($promoter->minor))
                                                @foreach ($promoter->minor as $minors)
                                                    <tr>
                                                        <td>{{ $minors?->first_name ?? '' }}
                                                            {{ $minors?->last_name ?? '' }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($minors->dob)->format('d/m/Y') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($minors->dob)->format('d/m/Y') }}</td>
                                                        <td>
                                                            <a href="{{ route('minor.show', $minors->id) }}"
                                                                title="View"
                                                                class="text-green-600 hover:underline mr-2">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                            <a href="{{ route('minor.edit', $minors->id) }}"
                                                                title="Edit" class="text-green-600 hover:underline">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="border px-4 py-2 text-center text-gray-500">
                                                        No minors available.
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- CO APPLICANT LOANS -->
                        <div class="mt-4 bg-green-500 border rounded shadow" x-data="{ showCoApplicantLoans: false }">
                            <div class="flex items-center justify-between px-4 py-2 text-white bg-orange-500 rounded-t">
                                <span class="font-semibold uppercase">CO APPLICANT LOANS</span>
                                <div class="flex gap-2 space-x-2">
                                    <i class="cursor-pointer fa" :class="showCoApplicantLoans ? 'fa-minus' : 'fa-plus'"
                                        @click="showCoApplicantLoans = !showCoApplicantLoans"></i>
                                </div>
                            </div>

                            <div class="p-4 text-sm bg-white" x-show="showCoApplicantLoans" x-transition>
                                <div class="p-4">
                                    <table class="w-full text-sm text-left">
                                        <thead>
                                            <tr>
                                                <th class="font-semibold px-4 py-2 text-start">ACCOUNT TYPE</th>
                                                <th class="font-semibold px-4 py-2 text-start">ACCOUNT NO.</th>
                                                <th class="font-semibold px-4 py-2 text-start">OPEN DATE</th>
                                                <th class="font-semibold px-4 py-2 text-start">STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($promoter->minor) && is_iterable($promoter->minor))
                                                @foreach ($promoter->minor as $minors)
                                                    <tr>
                                                        <td>{{ $minors?->first_name ?? '' }}
                                                            {{ $minors?->last_name ?? '' }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($minors->dob)->format('d/m/Y') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($minors->dob)->format('d/m/Y') }}</td>
                                                        <td>
                                                            <a href="{{ route('minor.show', $minors->id) }}"
                                                                title="View"
                                                                class="text-green-600 hover:underline mr-2">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                            <a href="{{ route('minor.edit', $minors->id) }}"
                                                                title="Edit" class="text-green-600 hover:underline">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="border px-4 py-2 text-center text-gray-500">
                                                        No minors available.
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- MY GUARANTOR SHIP -->
                        <div class="mt-4 bg-yellow-500 border rounded shadow" x-data="{ showGuarantorShip: false }"
                            style="background-color:#3c8dbc;">

                            <div class="flex items-center justify-between px-4 py-2 text-white bg-orange-500 rounded-t">
                                <span class="font-semibold uppercase">MY GUARANTOR SHIP</span>
                                <div class="flex gap-2 space-x-2">
                                    <i class="cursor-pointer fa" :class="showGuarantorShip ? 'fa-minus' : 'fa-plus'"
                                        @click="showGuarantorShip = !showGuarantorShip"></i>
                                </div>
                            </div>

                            <div class="p-4 text-sm bg-white" x-show="showGuarantorShip" x-transition>
                                <div class="p-4">
                                    <table class="w-full text-sm text-left">
                                        <thead>
                                            <tr>
                                                <th class="font-semibold px-4 py-2 text-start">ACCOUNT TYPE</th>
                                                <th class="font-semibold px-4 py-2 text-start">ACCOUNT NO.</th>
                                                <th class="font-semibold px-4 py-2 text-start">OPEN DATE</th>
                                                <th class="font-semibold px-4 py-2 text-start">STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($promoter->minor) && is_iterable($promoter->minor))
                                                @foreach ($promoter->minor as $minors)
                                                    <tr>
                                                        <td>{{ $minors?->first_name ?? '' }}
                                                            {{ $minors?->last_name ?? '' }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($minors->dob)->format('d/m/Y') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($minors->dob)->format('d/m/Y') }}</td>
                                                        <td>
                                                            <a href="{{ route('minor.show', $minors->id) }}"
                                                                title="View"
                                                                class="text-green-600 hover:underline mr-2">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                            <a href="{{ route('minor.edit', $minors->id) }}"
                                                                title="Edit" class="text-green-600 hover:underline">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="border px-4 py-2 text-center text-gray-500">
                                                        No minors available.
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endsection
