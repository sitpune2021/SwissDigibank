@extends('layout.main')

@section('content')
<!-- <style>
    .modal-overlay {
        position: fixed;
        inset: 0;
        background-color: rgba(227, 226, 226, 0.5);
        backdrop-filter: blur(3px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 50;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease-in-out;
    }
    .modal-overlay.show {
        opacity: 1;
        pointer-events: auto;
    }
</style> -->
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
    <x-alert />
</div>

<div class="min-h-screen p-4 font-sans text-sm bg-gray-100" x-data>

    <div class="flex flex-wrap justify-center gap-3 mb-3 text-center">
        <a href="{{ route('account.transaction', base64_encode($account->id)) }}"
            class="px-4 py-2 text-base text-white bg-blue-600 rounded hover:bg-blue-700">
            View Transactions
        </a>
        <a class="px-4 py-2 text-base text-white bg-green-600 rounded hover:bg-green-700" href="{{route('deposit.create',base64_encode($account->id))}}">Deposit Money</a>
        <a class="px-4 py-2 text-base text-white bg-red-600 rounded hover:bg-red-700" href="{{route('withdraw.create',base64_encode($account->id))}}">Withdraw Money</a>
        <!-- <a class="px-4 py-2 text-base text-white bg-green-600 rounded hover:bg-green-700" href="{{route('saving.passbook', base64_encode($account->id))}}">Print Documents</a> -->

        <div class="relative inline-block text-left">
            <button id="dropdownPrintMenuBtn" type="button"
                class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-green-600 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                Print Documents
                <svg class="w-5 h-5 ml-2 -mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <!-- Dropdown menu -->
            <div id="printDropdownMenu"
                class="hidden absolute right-0 mt-2 w-56 origin-top-right bg-white border border-gray-200 rounded-md shadow-lg z-50">
                <div class="py-1">
                    <!-- Passbook -->
                    <a href="{{ route('saving.passbook', base64_encode($account->id)) }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Passbook
                    </a>
                    <!-- Account Opening Form -->
                    <a href="{{ route('saving.accounts.open.form', base64_encode($account->id)) }}" id="openModalBtn"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Account Opening Form
                    </a>
                </div>
            </div>
        </div>
        <div class="relative inline-block text-left">
            <button id="dropdownButton"
                class="px-4 py-2 text-base text-white bg-yellow-500 rounded hover:bg-yellow-600 flex items-center">
                Debit Other Charges
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="dropdownMenu"
                class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                <a href="{{route('accounts.other.debit-charges', base64_encode($account->id))}}"
                    class="block px-4 py-2 text-gray-700 hover:bg-yellow-100 rounded-t-lg">Other Charge List</a>
                <a href=""
                    class="block px-4 py-2 text-gray-700 hover:bg-yellow-100">Debit Other Charges</a>

                <a href="{{route('accounts.clear.due',base64_encode($account->id))}}"
                    class="block px-4 py-2 text-gray-700 hover:bg-yellow-100 rounded-b-lg">Clear Due</a>
            </div>
        </div>
        <div class="relative inline-block text-left">
            <!-- Button -->
            <button id="accountDropdownButton"
                class="px-4 py-2 text-base text-white bg-teal-500 rounded hover:bg-teal-600 flex items-center gap-2">
                Account Details
                <svg class="w-4 h-4 ml-1 transition-transform duration-200"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown menu -->
            <div id="accountDropdownMenu"
                class="hidden absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                <ul class="py-2 text-gray-700">
                    <li>
                        <a href="{{route('accounts.credit.interest',base64_encode($account->id))}}" class="block px-4 py-2 hover:bg-teal-50 hover:text-teal-700">Credit Interest</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-teal-50 hover:text-teal-700">Change Account Type</a>
                    </li>
                    <li>
                        <a href="{{route('saving.accounts.nominee',base64_encode($account->id))}}" class="block px-4 py-2 hover:bg-teal-50 hover:text-teal-700">Add Nominee</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-teal-50 hover:text-teal-700">Upgrade Account</a>
                    </li>
                    <li>
                        <a href="{{route('saving.accounts.close.account',base64_encode($account->id))}}" class="block px-4 py-2 hover:bg-teal-50 hover:text-teal-700">Close Account</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-teal-50 hover:text-teal-700">Remove Account</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- <button class="px-4 py-2 text-base text-white bg-yellow-500 rounded hover:bg-yellow-600">Debit Other Charges</button> -->
        <!-- <button class="px-4 py-2 text-base text-white bg-teal-500 rounded hover:bg-teal-600">Account Details</button> -->

        <button class="px-4 py-2 text-base text-white bg-gray-500 rounded hover:bg-gray-600">Show Audit Trail</button>
    </div>

    <div class="container px-2 mx-auto">
        <div class="flex flex-col gap-4 md:flex-row">

            <!-- Left Panel -->
            <div class="space-y-3 md:w-7/12">
                {{-- Account Info Table --}}
                <div class="bg-white rounded shadow">
                    <div class="flex items-center justify-between px-3 py-2 font-semibold bg-green-500 cursor-pointer" @click="open=!open">
                        <span class="uppercase">Account Info - {{ $account->account_no }} </span>
                        <span x-text="open ? '−' : '+'">−</span>
                    </div>
                    <table class="w-full text-sm">
                        <tbody>
                            <tr class="border-b">
                                <th class="w-1/2 p-2 font-medium text-gray-700 uppercase">Customer</th>
                                <td class="p-2">{{ $account->members->member_no 
    ?? ($account->members->id ? str_pad($account->members->id, 6, '0', STR_PAD_LEFT) : '-') }}-{{ ucfirst($account->members->member_info_first_name)." ".ucfirst($account->members->member_info_last_name) }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700 uppercase">Created On</th>
                                <td class="p-2">Admin App</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700 uppercase">Created By</th>
                                <td class="p-2">Admin</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700 uppercase">Account No.</th>
                                <td class="p-2"> {{ $account->account_no }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700 uppercase">Old Account No.</th>
                                <td class="p-2">-</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700 uppercase">Scheme Name</th>
                                <td class="p-2"> {{ $account->scheme->scheme_name }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700 uppercase">Open Date</th>
                                <td class="p-2">{{ \Carbon\Carbon::parse($account->open_date)->format('d-m-Y') }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700 uppercase">Status</th>
                                <td class="p-2"> Active </td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700 uppercase">Lock Balance (A)</th>
                                <td class="p-2">0.00</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700 uppercase">Hold Balance (B)</th>
                                <td class="p-2">0.00</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700 uppercase">Available Balance (C)</th>
                                <td class="p-2">₹{{ number_format($combined_balace, 2) }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700 uppercase">Sweep In Balance (D)</th>
                                <td class="p-2">₹0.00</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700 uppercase">Combined Balance (A+B+C+D)</th>
                                <td class="p-2" style="color: green; font-size: 15px; font-weight: bold;">
                                    ₹{{ number_format($combined_balace, 2) }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700 uppercase">Penalty Dues</th>
                                <td class="p-2">₹0.00</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700 uppercase">Special Account</th>
                                <td class="p-2">
                                    <span class="px-2 py-1 text-xs text-white bg-red-600 rounded">No</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Allocated Passbook --}}
                <div class="bg-white rounded shadow">
                    <div class="flex items-center justify-between px-3 py-2 bg-green-100 border-b-2 border-green-600">
                        <span class="font-semibold text-green-700 uppercase">Allocated Passbook</span>
                        <button class="px-3 py-1 text-xs text-white bg-green-600 rounded">+ PASSBOOK</button>
                    </div>
                </div>
                {{-- Documents --}}
                <div class="bg-white rounded shadow" x-data="{ open: true }">
                    <div class="flex items-center justify-between px-3 py-2 text-white bg-green-600 cursor-pointer"
                        @click="open=!open">
                        <span>DOCUMENTS</span>
                        <div class="flex items-center gap-2">
                            <!-- Upload Icon Button -->
                            <button class="p-1 bg-white rounded hover:bg-gray-200" title="Upload Document">
                                <!-- Heroicons Upload Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-4 h-4 text-green-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2m-4-4l-4-4m0 0l-4 4m4-4v12" />
                                </svg>
                            </button>

                            <!-- Toggle Symbol -->
                            <span x-text="open ? '−' : '+'"></span>
                        </div>
                    </div>
                    <div x-show="open" class="px-3 py-2 border-t">No Document Found</div>
                </div>


                {{-- Comments --}}
                <div class="bg-white rounded shadow" x-data="{ open: true }">
                    <div class="flex items-center justify-between px-3 py-2 text-white bg-green-600 cursor-pointer"
                        @click="open=!open">
                        <span>COMMENTS</span>
                        <span x-text="open ? '−' : '+'"></span>
                    </div>
                    <div x-show="open" class="px-3 py-2 text-center border-t">
                        No Comment Found
                        <button class="px-2 py-1 ml-2 text-xs text-white bg-green-600 rounded">ADD COMMENT</button>
                    </div>
                </div>

                {{-- Transaction Info --}}
                <div class="bg-white rounded shadow" x-data="{ open: true }">
                    <div class="flex items-center justify-between px-3 py-2 text-white bg-green-600 cursor-pointer"
                        @click="open=!open">
                        <span class="uppercase">Transaction Info</span>
                        <span x-text="open ? '−' : '+'"></span>
                    </div>
                    <div x-show="open" class="border-t">
                        <div class="p-2 text-center">
                            <a href="{{ route('account.transaction', base64_encode($account->id) ) }}"
                                class="px-2 py-1 text-xs text-white bg-teal-500 rounded">
                                VIEW ALL
                            </a>
                        </div>
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2 uppercase">Date</th>
                                    <th class="p-2 uppercase">Type</th>
                                    <th class="p-2 uppercase">Payment Mode</th>
                                    <th class="p-2 uppercase">Status</th>
                                    <th class="p-2 uppercase">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-t">
                                    @foreach($account->transaction as $txn)
                                <tr>
                                    <td class="p-2">{{ $txn->transaction_date }}</td>
                                    <td class="p-2">{{ $txn->transaction_type }}</td>
                                    <td class="p-2">{{ $txn->payment_mode }}</td>
                                    <td class="p-2">{{ $txn->approve_status }}</td>
                                    <td class="p-2">{{ number_format($txn->amount, 2) }}</td>
                                </tr>
                                @endforeach

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Panel -->
            <div class="space-y-3 md:w-5/12">

                {{-- Settings --}}
                <div class="flex items-center justify-between px-3 py-2 font-semibold bg-green-500 cursor-pointer" @click="open=!open">
                    <span class="uppercase">Settings Info</span>
                    <span x-text="open ? '−' : '+'">−</span>
                </div>
                <div class="p-3 space-y-2 bg-white rounded shadow">
                    <div class="flex justify-between">
                        <label>SMS</label>
                        <input type="checkbox" disabled>
                    </div>
                    <div class="flex justify-between">
                        <label class="uppercase">Account on Hold</label>
                        <input type="checkbox" disabled>
                    </div>
                    <div class="flex justify-between">
                        <label class="uppercase">Change Account Type to Current</label>
                        <input type="checkbox" disabled>
                    </div>
                    <div class="flex justify-between">
                        <label class="uppercase">Deduct Charges</label>
                        <input type="checkbox" disabled>
                    </div>
                </div>

                {{-- Branch Info --}}
                <div class="bg-white rounded shadow" x-data="{ open: false }">
                    <div class="flex items-center justify-between px-3 py-2 font-semibold bg-green-500 cursor-pointer"
                        @click="open=!open">
                        <span class="uppercase">Branch Info</span>
                        <span x-text="open ? '−' : '+'"></span>
                    </div>
                    <div x-show="open" class="border-t">
                        <table class="w-full text-sm">
                            <tbody>
                                <tr class="border-b">
                                    <th class="p-2 text-gray-700 uppercase">Branch</th>
                                    <td class="p-2">{{ $account->branch->branch_name }}</td>
                                </tr>
                                <tr>
                                    <th class="p-2 text-gray-700 uppercase">Joint Account</th>
                                    <td class="p-2">
                                        <span class="px-2 py-1 text-xs text-white bg-red-600 rounded">{{ $account->account_holder_type }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Sweep-In Settings --}}
                <div class="p-3 space-y-3 bg-white rounded shadow">
                    <h3 class="mb-2 text-lg font-semibold text-gray-700 uppercase">Sweep-In Settings</h3>
                    <div>
                        <label class="mr-2 font-semibold text-gray-700 uppercase">Sweep-In:</label>
                        <input type="checkbox" disabled>
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="font-semibold text-gray-700 w-28 uppercase">Saving Scheme</label>
                        <select class="w-48 px-2 py-1 text-sm border border-gray-300 rounded" disabled>
                            <option value="{{ $account->scheme->id }}" selected>
                                {{ $account->scheme->scheme_name }}
                            </option>
                        </select>
                        <button class="px-3 py-1 text-xs text-white bg-green-600 rounded">Update</button>
                    </div>
                </div>


                {{-- Setup & Settings --}}
                <div class="p-3 space-y-2 bg-white rounded shadow">
                    <div class="flex items-center gap-2 mb-2">
                        <label class="w-32 font-semibold text-gray-700 uppercase">Member</label>
                        <input type="text" class="flex-1 px-2 py-1 border border-gray-300 rounded"
                            value="{{ $account->members->member_info_first_name.' '.$account->members->member_info_last_name }}" readonly>
                        <button class="px-3 py-1 text-xs text-white bg-green-600 rounded">UPDATE</button>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <label class="w-32 font-semibold text-gray-700 uppercase">Old Account No</label>
                        <input type="text" readonly class="flex-1 px-2 py-1 border border-gray-300 rounded"
                            placeholder="Enter Old Account No">
                        <button class="px-3 py-1 text-xs text-white bg-green-600 rounded">UPDATE</button>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <label class="w-32 font-semibold text-gray-700 uppercase">Branch</label>
                        <select class="flex-1 px-2 py-1 border border-gray-300 rounded" disabled>
                            <option>{{ $account->branch->branch_name }}</option>
                        </select>
                        <button class="px-3 py-1 text-xs text-white bg-green-600 rounded">UPDATE</button>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <label class="w-32 font-semibold text-gray-700 uppercase">Open Date</label>
                        <input type="text" class="flex-1 px-2 py-1 border border-gray-300 rounded"
                            value="{{ \Carbon\Carbon::parse($account->open_date)->format('d-m-Y') }}">
                        <button class="px-3 py-1 text-xs text-white bg-green-600 rounded">UPDATE</button>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <label class="w-32 font-semibold text-gray-700 uppercase">Advisor/ Staff</label>
                        <select class="flex-1 px-2 py-1 border border-gray-300 rounded" disabled>
                            <option> {{ isset($account->users) ? $account->users->fname.' '.$account->users->lname : '-' }}</option>
                        </select>
                        <button class="px-3 py-1 text-xs text-white bg-green-600 rounded">UPDATE</button>
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="w-32 font-semibold text-gray-700 uppercase">Lock Amount</label>
                        <input type="text" class="flex-1 px-2 py-1 border border-gray-300 rounded" value="0.0" readonly>
                        <button class="px-3 py-1 text-xs text-white bg-green-600 rounded">UPDATE</button>
                    </div>
                </div>

                {{-- Nominee Info --}}
                <div class="bg-white rounded shadow" x-data="{ open: true }">
                    <div class="flex items-center justify-between px-3 py-2 font-semibold text-white bg-green-600 cursor-pointer"
                        @click="open=!open">
                        <span class="uppercase">Nominee Info</span>
                        <span x-text="open ? '−' : '+'"></span>
                    </div>
                    <div x-show="open" class="border-t">
                        <table class="w-full text-sm border-collapse">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2 text-left border-b uppercase">Name</th>
                                    <th class="p-2 text-left border-b uppercase">Relation</th>
                                    <th class="p-2 text-left border-b uppercase">Address</th>
                                    <th class="p-2 text-left border-b uppercase">Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @php
                                    $totalNominees = count($account->nominee ?? []);
                                    $percentage = $totalNominees > 0 ? (100 / $totalNominees) : 0;
                                    $i=1;
                                    @endphp

                                    @foreach ($account->nominee as $nominee)

                                <tr>
                                    <td class="p-2 border-t">{{$i }}</td>
                                    <td class="p-2 border-t">{{ $nominee->nominee_name }}</td>
                                    <td class="p-2 border-t">{{ $nominee->nominee_relation }}</td>
                                    <td class="p-2 border-t">{{ $nominee->nominee_address }}</td>
                                    <td class="p-2 border-t">{{ $percentage   }}%</td>
                                </tr>
                                @php $i++; @endphp

                                @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<!-- <div id="printing_modal" class="modal-overlay">
    <div class="box rounded-2xl shadow-xl relative p-6" style="width: 500px;">
        <div class="flex justify-between items-center border-b pb-4">
            <h3 class="text-2xl font-semibold text-center w-full">OPENING FORM</h3>
            <button id="closeModalBtn" class="text-gray-400 hidden hover:text-gray-600 text-2xl absolute right-5 top-4">&times;</button>
        </div>

        <form id="introducerForm" class="mt-6 space-y-6" action="" method="">
            @csrf
            <div>
                <label for="introducer_details" class="block uppercase text-lg font-medium text-gray-700 mb-2">
                    Introducer Details
                </label>
                <input
                    type="text"
                    id="introducer_details"
                    class="w-full border border-gray-300 rounded-10 bg-secondary/5 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Enter Introducer Details">
            </div>
            <hr class="mt-5">
            <div class="flex justify-between pt-4 ">
                <button type="button" id="cancelBtn" class="px-4 py-2 btn-outline rounded-10 uppercase transition">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 rounded-10 uppercase btn-primary transition">
                    Submit <i class="las la-arrow-circle-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div> -->

<!-- <script>
    // 🔹 Debit Other Charges Dropdown
    const dropdownButton = document.getElementById('dropdownButton');
    const dropdownMenu = document.getElementById('dropdownMenu');

    dropdownButton.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
        if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
    // 🔹 Account Details Dropdown
    const dropdownBtn = document.getElementById('accountDropdownButton');
    const accountDropdownMenu = document.getElementById('accountDropdownMenu');

    dropdownBtn.addEventListener('click', () => {
        accountDropdownMenu.classList.toggle('hidden');
    });

    window.addEventListener('click', (e) => {
        if (!dropdownBtn.contains(e.target) && !accountDropdownMenu.contains(e.target)) {
            accountDropdownMenu.classList.add('hidden');
        }
    });

    // 🔹 Print Documents Dropdown (Fixed)
    const dropdownPrintMenuBtn = document.getElementById('dropdownPrintMenuBtn');
    const printDropdownMenu = document.getElementById('printDropdownMenu');

    dropdownPrintMenuBtn.addEventListener('click', (e) => {
        e.stopPropagation(); // Prevent window click from immediately closing it
        printDropdownMenu.classList.toggle('hidden');
    });

    window.addEventListener('click', (e) => {
        // Check button AND menu
        if (!dropdownPrintMenuBtn.contains(e.target) && !printDropdownMenu.contains(e.target)) {
            printDropdownMenu.classList.add('hidden');
        }
    });
</script> -->

<script>
    // Dropdowns mapping
    const dropdowns = [{
            button: document.getElementById("dropdownPrintMenuBtn"),
            menu: document.getElementById("printDropdownMenu")
        },
        {
            button: document.getElementById("dropdownButton"),
            menu: document.getElementById("dropdownMenu")
        },
        {
            button: document.getElementById("accountDropdownButton"),
            menu: document.getElementById("accountDropdownMenu")
        }
    ];

    // Toggle function for each dropdown
    dropdowns.forEach(({
        button,
        menu
    }) => {
        button.addEventListener("click", (e) => {
            e.stopPropagation();

            // Close other dropdowns
            dropdowns.forEach(d => {
                if (d.menu !== menu) d.menu.classList.add("hidden");
            });

            // Toggle the clicked dropdown
            menu.classList.toggle("hidden");
        });
    });

    // Global click to close all dropdowns
    window.addEventListener("click", () => {
        dropdowns.forEach(({
            menu
        }) => menu.classList.add("hidden"));
    });
</script>


@endsection