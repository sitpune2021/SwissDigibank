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
    <style>
         input[type="checkbox"] {
        width: 28px;
        height: 28px;
        accent-color: green;
        /* For modern browsers */
    }

    /* Fallback for browsers without accent-color support */
    input[type="checkbox"]:checked {
        background-color: green;
        border: none;
    }


    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>

    <div class="min-h-screen p-4 font-sans text-sm" x-data>

        <div class="flex flex-wrap  justify-start gap-3 mb-3 text-center">
            <a href="{{ route('account.transaction', base64_encode($account->id)) }}"
                class="btn-primary text-sm uppercase px-2 py-2 rounded-10 ">
                View Transactions
            </a>
            <a class="btn-primary  text-sm  uppercase px-2 py-2 rounded-10"
                href="{{route('deposit.create', base64_encode($account->id))}}">Deposit Money</a>
            <a class="btn-error  text-sm  uppercase px-2 py-2 rounded-10"
                href="{{route('withdraw.create', base64_encode($account->id))}}">Withdraw Money</a>
            <!-- <a class="px-4 py-2 text-base text-white bg-green-600 rounded hover:bg-green-700" href="{{route('saving.passbook', base64_encode($account->id))}}">Print Documents</a> -->

            <div class="relative inline-block text-left">
                <button id="dropdownPrintMenuBtn" type="button"
                    class="inline-flex justify-center w-full  text-sm  btn-primary uppercase px-2 py-2 rounded-10">
                    Print Documents
                    <svg class="w-5 h-5 ml-2 -mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="printDropdownMenu"
                    class="hidden absolute right-0 mt-2 w-56 origin-top-right bg-white border border-gray-200 rounded-md shadow-lg z-50">
                    <div class="py-1">
                        <!-- Passbook -->
                        <a href="{{ route('saving.passbook', base64_encode($account->id)) }}"
                            class="block px-4  py-2 text-sm font-semibold uppercase hover:bg-gray-100">
                            Passbook
                        </a>
                        <!-- Account Opening Form -->
                        <a href="{{ route('saving.account.openform.preview', base64_encode($account->id)) }}" id="openModalBtn"
                            class="block px-4 py-2 text-sm font-semibold uppercase hover:bg-gray-100">
                            Account Opening Form
                        </a>
                    </div>
                </div>
            </div>
            <div class="relative inline-block text-left">
                <button id="dropdownButton" class="btn-warning  text-sm  uppercase px-2 py-2 rounded-10">
                    Debit Other Charges
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="dropdownMenus"
                    class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                    <a href="{{route('accounts.other.debit-charges', base64_encode($account->id))}}"
                        class="block px-4 py-2 font-semibold uppercase hover:bg-gray-100 rounded-t-lg">Other Charge List</a>
                    <a href="" class="block px-4 py-2 font-semibold uppercase hover:bg-gray-100">Debit Other Charges</a>

                    <a href="{{route('accounts.clear.due', base64_encode($account->id))}}"
                        class="block px-4 py-2 font-semibold uppercase hover:bg-gray-100 rounded-b-lg">Clear Due</a>
                </div>
            </div>
            <div class="relative inline-block text-left">
                <!-- Button -->
                <button id="accountDropdownButton" class="btn-secondary  text-sm  uppercase px-2 py-2 rounded-10">
                    Account Details
                    <svg class="w-4 h-4 ml-1 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div id="accountDropdownMenu"
                    class="hidden absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                    <ul class="py-2 text-gray-700">
                        <li>
                            <a href="{{route('accounts.credit.interest', base64_encode($account->id))}}"
                                class="block px-4 py-2 hover:bg-teal-50 font-semibold uppercase hover:text-gray-700">Credit Interest</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-teal-50
                            font-semibold uppercase  hover:text-gray-700">Change Account Type</a>
                        </li>
                        <li>
                            <a href="{{route('saving.accounts.nominee', ['type' => 'saving-account', 'id' => base64_encode($account->id)])}}"
                                class="block px-4 py-2 hover:bg-teal-50 
                                font-semibold uppercase hover:text-gray-700">Add Nominee</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-teal-50 
                            font-semibold uppercase hover:text-gray-700">Upgrade Account</a>
                        </li>
                        <li>
                            <a href="{{route('saving.accounts.close.account', base64_encode($account->id))}}"
                                class="block px-4 py-2 hover:bg-teal-50 
                                font-semibold uppercase hover:text-gray-700">Close Account</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-teal-50 
                            font-semibold uppercase hover:text-gray-700">Remove Account</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- <button class="px-4 py-2 text-base text-white bg-yellow-500 rounded hover:bg-yellow-600">Debit Other Charges</button> -->
            <!-- <button class="px-4 py-2 text-base text-white bg-teal-500 rounded hover:bg-teal-600">Account Details</button> -->

            <button class="btn-secondary uppercase  text-sm  px-2 py-2 rounded-10">Show Audit Trail</button>
        </div>

        <div class="container px-2 mx-auto">
            <div class="flex flex-col gap-4 md:flex-row">

                <!-- Left Panel -->
                <div class="space-y-3 md:w-7/12 ">
                    {{-- Account Info Table --}}
                    <div class="rounded-10 box overflow-x-auto whitespace-nowrap">
                        <div class=" flex items-center bg-secondary/5 text-black justify-between px-4 py-3 rounded-10   text-xl font-semibold cursor-pointer"
                            @click="open=!open">
                            <span class="uppercase text-lg">Account Info - {{ $account->account_no }} </span>
                            {{-- <span x-text="open ? '−' : '+'">−</span> --}}
                        </div>
                        <table class="w-full text-sm " >
                            <tbody>
                                <tr class="border-b">
                                    <th class="w-1/2 p-2 font-medium text-start uppercase">Customer</th>
                                    <td class="p-2 text-start">
                                        {{ $account->members->member_no
        ?? ($account->members->id ? str_pad($account->members->id, 6, '0', STR_PAD_LEFT) : '-') }}-{{ ucfirst($account->members->member_info_first_name) . " " . ucfirst($account->members->member_info_last_name) }}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th class="p-2 font-medium text-start uppercase">Created On</th>
                                    <td class="p-2">Admin App (static)</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="p-2 font-medium text-start uppercase">Created By</th>
                                    <td class="p-2">Admin (static)</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="p-2 font-medium text-start uppercase">Account No.</th>
                                    <td class="p-2"> {{ $account->account_no }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="p-2 font-medium text-start uppercase">Old Account No.</th>
                                    <td class="p-2">- (static)</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="p-2 font-medium text-start uppercase">Scheme Name</th>
                                    <td class="p-2"> {{ $account->scheme->scheme_name }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="p-2 font-medium text-start uppercase">Open Date</th>
                                    <td class="p-2">{{ \Carbon\Carbon::parse($account->open_date)->format('d-m-Y') }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="p-2 font-medium text-start uppercase">Status</th>
                                    <td class="p-2"> Active (static)</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="p-2 font-medium text-start uppercase">Lock Balance (A)</th>
                                    <td class="p-2">0.00 (static)</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="p-2 font-medium text-start uppercase">Hold Balance (B)</th>
                                    <td class="p-2">0.00 (static)</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="p-2 font-medium text-start uppercase">Available Balance (C)</th>
                                    <td class="p-2">₹{{ number_format($combined_balace, 2) }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="p-2 font-medium text-start uppercase">Sweep In Balance (D)</th>
                                    <td class="p-2">₹0.00 (static)</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="p-2 font-medium text-start uppercase">Combined Balance (A+B+C+D)</th>
                                    <td class="p-2" style="color: green; font-size: 15px; font-weight: bold;">
                                        ₹{{ number_format($combined_balace, 2) }}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th class="p-2 font-medium text-start uppercase">Penalty Dues</th>
                                    <td class="p-2">₹0.00(static)</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="p-2 font-medium text-start uppercase ">Special Account</th>
                                    <td class="p-2">
                                       <div class="flex items-center gap-1">
                                    <span
                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                Yes
                            </span>
                             <span
                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                No
                            </span>
                                </div>
                                (static)
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Allocated Passbook --}}
                    <div class="box">
                        <div class=" flex items-center bg-secondary/5 text-black justify-between px-4 py-3 rounded-10 cursor-pointer">
                            <span class="font-semibold text-lg text-black uppercase">Allocated Passbook</span>
                            <button class="btn-primary uppercase px-2 py-2 rounded-10"> 
                             <i class="las la-plus text-lg"></i>   PASSBOOK
                            </button>
                        </div>
                    </div>
                    {{-- Documents --}}
                    <div class="box" x-data="{ open: true }">
                        <div class=" flex items-center bg-secondary/5 text-black justify-between px-4 py-3 rounded-10 cursor-pointer"
                            @click="open=!open">
                            <span class="font-semibold text-lg text-black uppercase">DOCUMENTS</span>
                            <div class="flex items-center gap-2">
                                <!-- Upload Icon Button -->
                                <button class="p-1 btn-primary" title="Upload Document">
                                    <!-- Heroicons Upload Icon -->
                                   <i class="las la-upload"></i>
                                </button>

                                <!-- Toggle Symbol -->
                                <span x-text="open ? '−' : '+'"></span>
                            </div>
                        </div>
                        <div x-show="open" class="px-3 py-2 ">No Document Found</div>
                    </div>


                    {{-- Comments --}}
                    <div class="box" x-data="{ open: true }">
                        <div class="flex items-center bg-secondary/5 text-black justify-between px-4 py-3 rounded-10 cursor-pointer"
                            @click="open=!open">
                            <span class="font-semibold text-lg text-black uppercase">COMMENTS</span>
                           

                           <div class="flex gap-3 items-center">
                             <button class="px-2 py-2 ml-2 text-sm rounded-10 btn-primary">ADD COMMENT</button>
                             <span  x-text="open ? '−' : '+'"></span>
                           </div>
                        </div>
                        <div x-show="open" class="px-3 py-2 flex items-center justify-between text-center ">
                           <p> No Comment Found</p>
                            
                        </div>
                    </div>

                    {{-- Transaction Info --}}
                    <div class="box " x-data="{ open: true }">
                        <div class="flex items-center bg-secondary/5 text-black justify-between px-4 py-3 rounded-10 cursor-pointer"
                            @click="open=!open">
                            <span class="font-semibold text-lg text-black uppercase">Transaction Info</span>
                           
                             <div class="flex gap-3 items-center">
                                <a href="{{ route('account.transaction', base64_encode($account->id)) }}"
                                    class="px-2 py-2 btn-primary rounded-10 text-sm">
                                    VIEW ALL
                             </a>
                            <span x-text="open ? '−' : '+'"></span>
                             </div>
                        </div>
                         <div class="p-2 text-center">
                               
                            </div>
                        <div x-show="open" class="overflow-x-auto">
                           
                            <table class="w-full text-sm">
                                <thead class="bg-secondary/5">
                                    <tr class="border-b">
                                        <th class="p-2 text-start uppercase">Date</th>
                                        <th class="p-2 text-start uppercase">Type</th>
                                        <th class="p-2 text-start uppercase">Payment Mode</th>
                                        <th class="p-2 text-start uppercase">Status</th>
                                        <th class="p-2  text-start uppercase">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                        @foreach($account->transaction as $txn)
                                           <tr class="border-b">
                                                <td class="p-2">{{ \Carbon\Carbon::parse($txn->transaction_date)->format('d-m-Y') }}</td>
                                                <td class="p-2">
                                                    {{ $txn->transaction_type }}</td>
                                                <td class="p-2">{{ $txn->payment_mode }}</td>
                                                <td class="p-2">{{ $txn->approve_status }}</td>
                                                <td class="p-2">{{ number_format($txn->amount, 2) }}</td>
                                          
                                    </tr>
                                        @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Panel -->
                <div class="space-y-3 md:w-5/12">

                    {{-- Settings --}}
                   <div class="box">
                     <div class=" flex items-center bg-secondary/5 text-black justify-between px-4 py-3 rounded-10 cursor-pointer"
                        @click="open=!open">
                        <span class="font-semibold text-lg text-black uppercase">Settings Info</span>
                        {{-- <span x-text="open ? '−' : '+'">−</span> --}}
                    </div>
                    <div class="p-3 space-y-2 ">
                        <div class="flex justify-between ">
                            <label class="uppercase text-lg font-semibold">SMS</label>
                            <input type="checkbox" disabled>
                        </div>
                        <div class="flex justify-between">
                            <label class="uppercase text-lg font-semibold">Account on Hold</label>
                            <input type="checkbox" disabled>
                        </div>
                        <div class="flex justify-between">
                            <label class="uppercase text-lg  font-semibold">Change Account Type to Current</label>
                            <input type="checkbox" disabled>
                        </div>
                        <div class="flex justify-between">
                            <label class="uppercase text-lg font-semibold">Deduct Charges</label>
                            <input type="checkbox" disabled>
                        </div>
                    </div>
                   </div>

                    {{-- Branch Info --}}
                    <div class="box" x-data="{ open: false }">
                        <div class="flex items-center bg-secondary/5 text-black justify-between px-4 py-3 rounded-10 cursor-pointer"
                            @click="open=!open">
                            <span class="font-semibold text-lg text-black uppercase">Branch Info</span>
                            <span x-text="open ? '−' : '+'"></span>
                        </div>
                        <div x-show="open" class="border-b">
                            <table class="w-full text-sm">
                                <tbody>
                                    <tr class="border-b">
                                        <th class="p-2 text-start uppercase">Branch</th>
                                        <td class="p-2">{{ $account->branch->branch_name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="p-2 text-start uppercase">Joint Account</th>
                                        <td class="p-2 capitalize">
                                           {{ $account->account_holder_type }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Sweep-In Settings --}}
                    <div class="box">
                        <h3 class="mb-2 font-semibold text-lg text-black uppercase border-b py-2">Sweep-In Settings</h3>
                        <div class="flex items-center justify-start">
                            <label class="mr-2  font-semibold text-gray-700 text-lg uppercase">Sweep-In:</label>
                            <input type="checkbox" disabled >
                        </div>

                        <div class="mt-3">
                            <label class=" font-semibold text-gray-700 text-lg uppercase">Saving Scheme</label>
                         <div class="flex   items-center gap-2 mt-4">
                            <select class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" disabled>
                                <option value="{{ $account->scheme->id }}" selected>
                                    {{ $account->scheme->scheme_name }}
                                </option>
                            </select>
                            <button class=" px-3 py-2 text-sm btn-primary rounded-10 text-center uppercase">Update</button>
                        </div>
                        </div>
                    </div>


                    {{-- Setup & Settings --}}
                    <div class="p-3 space-y-2 box overflow-x-auto whitespace-nowrap">
                        <div class="mb-4">
                            <label class=" font-semibold text-gray-700 text-lg uppercase">Member</label>
                        <div class="flex items-center  gap-2 mt-2 mb-2">
                            <input type="text" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                value="{{ $account->members->member_info_first_name . ' ' . $account->members->member_info_last_name }}"
                                readonly>
                            <button class="px-3 py-2 text-sm btn-primary rounded-10 text-center uppercase">UPDATE</button>
                        </div>
                        </div>
                     <div class="mb-4">
                           <label class="font-semibold text-gray-700 text-lg uppercase">Old Account No</label>
                        <div class="flex items-center  gap-2 mt-2 mb-2">
                            <input type="text" readonly class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Old Account No">
                            <button class="px-3 py-2 text-sm btn-primary rounded-10 text-center uppercase">UPDATE</button>
                        </div>
                     </div>
                     
                       <div class="mb-4">
                        <label class="font-semibold text-gray-700 text-lg uppercase">Branch</label>
                        <div class="flex items-center gap-2 mb-2 mt-2">
                            <select class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" disabled>
                                <option>{{ $account->branch->branch_name ?? ''}}</option>
                            </select>
                            <button class="px-3 py-2 text-sm btn-primary rounded-10 text-center uppercase">UPDATE</button>
                        </div>
                       </div>
                        <div class="mb-4">
                            <label class="font-semibold text-gray-700 text-lg uppercase">Open Date</label>
                        <div class="flex items-center gap-2 mb-2 mt-2">
                            <input type="text" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                value="{{ \Carbon\Carbon::parse($account->open_date)->format('d-m-Y') }}">
                            <button class="px-3 py-2 text-sm btn-primary rounded-10 text-center uppercase">UPDATE</button>
                        </div>
                        </div>
                        <div class="mb-4">
                             <label class="font-semibold text-gray-700 text-lg uppercase">Advisor/ Staff</label>
                        <div class="flex items-center gap-2 mb-2 mt-2">
                            <select class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" disabled>
                                <option>
                                    {{ isset($account->users) ? $account->users->fname . ' ' . $account->users->lname : '-' }}
                                </option>
                            </select>
                            <button class="px-3 py-2 text-sm btn-primary rounded-10 text-center uppercase">UPDATE</button>
                        </div>
                        </div>
                        
                        <div class="">
                            <label class="font-semibold text-gray-700 text-lg uppercase">Lock Amount</label>
                        <div class="flex items-center gap-2 mb-2 mt-2">
                            <input type="text" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" value="0.0" readonly>
                            <button class="px-3 py-2 text-sm btn-primary rounded-10 text-center uppercase">UPDATE</button>
                        </div>
                        </div>
                    </div>

                    {{-- Nominee Info --}}
                    <div class="box" x-data="{ open: true }">
                        <div class="flex items-center bg-secondary/5 text-black justify-between px-4 py-3 rounded-10 cursor-pointer"
                            @click="open=!open">
                            <span class="font-semibold text-lg text-black uppercase">Nominee Info</span>
                            <span x-text="open ? '−' : '+'"></span>
                        </div>
                        <div x-show="open" class="border-b mt-3">
                            <table class="w-full text-sm border-collapse">
                                <thead class="bg-secondary/5">
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
                                            $i = 1;
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
            menu: document.getElementById("dropdownMenus")
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