@extends('layout.main')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="min-h-screen p-4 font-sans text-sm bg-gray-100" x-data>

    <div class="flex flex-wrap justify-center gap-3 mb-3 text-center">
        <a href="{{ route('account.transaction', base64_encode($account->id)) }}"
            class="px-4 py-2 text-base text-white bg-blue-600 rounded hover:bg-blue-700">
            View Transactions
        </a>
        <a class="px-4 py-2 text-base text-white bg-green-600 rounded hover:bg-green-700" href="{{route('deposit.create',base64_encode($account->id))}}">Deposit Money</a>
        <a class="px-4 py-2 text-base text-white bg-red-600 rounded hover:bg-red-700" href="{{route('withdraw.create',base64_encode($account->id))}}">Withdraw Money</a>
        <!-- <button class="px-4 py-2 text-base text-white bg-green-600 rounded hover:bg-green-700">Deposit Money</button>
        <button class="px-4 py-2 text-base text-white bg-red-600 rounded hover:bg-red-700">Withdraw Money</button> -->
        <!-- <button class="px-4 py-2 text-base text-white bg-yellow-500 rounded hover:bg-yellow-600">Debit Other Charges</button> -->
        <!-- <button class="px-4 py-2 text-base text-white bg-teal-500 rounded hover:bg-teal-600">Account Details</button> -->
        <!-- <button class="px-4 py-2 text-base text-white bg-gray-800 rounded hover:bg-gray-900">Print Documents</button> -->
        <!-- <button class="px-4 py-2 text-base text-white bg-gray-500 rounded hover:bg-gray-600">Show Audit Trail</button> -->
    </div>

    <div class="container px-2 mx-auto">
        <div class="flex flex-col gap-4 md:flex-row">

            <!-- Left Panel -->
            <div class="space-y-3 md:w-7/12">

                {{-- Account Info Table --}}
                <div class="bg-white rounded shadow">
                    <div class="flex items-center justify-between px-3 py-2 font-semibold bg-green-500 cursor-pointer" @click="open=!open">
                        <span>Account Info - {{ $account->account_no }} </span>
                        <span x-text="open ? '−' : '+'">−</span>
                    </div>
                    <table class="w-full text-sm">
                        <tbody>
                            <tr class="border-b">
                                <th class="w-1/2 p-2 font-medium text-gray-700">Member</th>
                                <td class="p-2">{{ ucfirst($account->members->member_info_first_name)." ".ucfirst($account->members->member_info_last_name) }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700">Created On</th>
                                <td class="p-2">Admin App</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700">Created By</th>
                                <td class="p-2">Admin</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700">Account No.</th>
                                <td class="p-2"> {{ $account->account_no }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700">Old Account No.</th>
                                <td class="p-2">-</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700">Scheme Name</th>
                                <td class="p-2"> {{ $account->scheme->scheme_name }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700">Open Date</th>
                                <td class="p-2">{{ \Carbon\Carbon::parse($account->open_date)->format('D M d Y') }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700">Status</th>
                                <td class="p-2"> Active </td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700">Lock Balance (A)</th>
                                <td class="p-2">0.00</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700">Hold Balance (B)</th>
                                <td class="p-2">0.00</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700">Available Balance (C)</th>
                                <td class="p-2">{{ $combined_balace }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700">Sweep In Balance (D)</th>
                                <td class="p-2">₹0.00</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700">Combined Balance (A+B+C+D)</th>
                                <td class="p-2" style="color: green; font-size: 15px; font-weight: bold;">
                                    ₹{{ number_format($combined_balace, 2) }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700">Penalty Dues</th>
                                <td class="p-2">₹0.00</td>
                            </tr>
                            <tr class="border-b">
                                <th class="p-2 font-medium text-gray-700">Special Account</th>
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
                        <span class="font-semibold text-green-700">Allocated Passbook</span>
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
                        <span>Transaction Info</span>
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
                                    <th class="p-2">Date</th>
                                    <th class="p-2">Type</th>
                                    <th class="p-2">Payment Mode</th>
                                    <th class="p-2">Status</th>
                                    <th class="p-2">Amount</th>
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
                    <span>Settings Info</span>
                    <span x-text="open ? '−' : '+'">−</span>
                </div>
                <div class="p-3 space-y-2 bg-white rounded shadow">
                    <div class="flex justify-between">
                        <label>SMS</label>
                        <input type="checkbox" disabled>
                    </div>
                    <div class="flex justify-between">
                        <label>Account on Hold</label>
                        <input type="checkbox" disabled>
                    </div>
                    <div class="flex justify-between">
                        <label>Change Account Type to Current</label>
                        <input type="checkbox" disabled>
                    </div>
                    <div class="flex justify-between">
                        <label>Deduct Charges</label>
                        <input type="checkbox" disabled>
                    </div>
                </div>

                {{-- Branch Info --}}
                <div class="bg-white rounded shadow" x-data="{ open: false }">
                    <div class="flex items-center justify-between px-3 py-2 font-semibold bg-green-500 cursor-pointer"
                        @click="open=!open">
                        <span>Branch Info</span>
                        <span x-text="open ? '−' : '+'"></span>
                    </div>
                    <div x-show="open" class="border-t">
                        <table class="w-full text-sm">
                            <tbody>
                                <tr class="border-b">
                                    <th class="p-2 text-gray-700">Branch</th>
                                    <td class="p-2">{{ $account->branch->branch_name }}</td>
                                </tr>
                                <tr>
                                    <th class="p-2 text-gray-700">Joint Account</th>
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
                    <h3 class="mb-2 text-lg font-semibold text-gray-700">Sweep-In Settings</h3>
                    <div>
                        <label class="mr-2 font-semibold text-gray-700">Sweep-In:</label>
                        <input type="checkbox" disabled>
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="font-semibold text-gray-700 w-28">Saving Scheme</label>
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
                        <label class="w-32 font-semibold text-gray-700">Member</label>
                        <input type="text" class="flex-1 px-2 py-1 border border-gray-300 rounded"
                            value="{{ $account->members->member_info_first_name.' '.$account->members->member_info_last_name }}" readonly>
                        <button class="px-3 py-1 text-xs text-white bg-green-600 rounded">UPDATE</button>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <label class="w-32 font-semibold text-gray-700">Old Account No</label>
                        <input type="text" readonly class="flex-1 px-2 py-1 border border-gray-300 rounded"
                            placeholder="Enter Old Account No">
                        <button class="px-3 py-1 text-xs text-white bg-green-600 rounded">UPDATE</button>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <label class="w-32 font-semibold text-gray-700">Branch</label>
                        <select class="flex-1 px-2 py-1 border border-gray-300 rounded" disabled>
                            <option>{{ $account->branch->branch_name }}</option>
                        </select>
                        <button class="px-3 py-1 text-xs text-white bg-green-600 rounded">UPDATE</button>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <label class="w-32 font-semibold text-gray-700">Open Date</label>
                        <input type="text" class="flex-1 px-2 py-1 border border-gray-300 rounded"
                            value="{{ \Carbon\Carbon::parse($account->open_date)->format('D M d Y') }}">
                        <button class="px-3 py-1 text-xs text-white bg-green-600 rounded">UPDATE</button>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <label class="w-32 font-semibold text-gray-700">Advisor/ Staff</label>
                        <select class="flex-1 px-2 py-1 border border-gray-300 rounded" disabled>
                            <option> {{ isset($account->users) ? $account->users->fname.' '.$account->users->lname : '-' }}</option>
                        </select>
                        <button class="px-3 py-1 text-xs text-white bg-green-600 rounded">UPDATE</button>
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="w-32 font-semibold text-gray-700">Lock Amount</label>
                        <input type="text" class="flex-1 px-2 py-1 border border-gray-300 rounded" value="0.0" readonly>
                        <button class="px-3 py-1 text-xs text-white bg-green-600 rounded">UPDATE</button>
                    </div>
                </div>

                {{-- Nominee Info --}}
                <div class="bg-white rounded shadow" x-data="{ open: true }">
                    <div class="flex items-center justify-between px-3 py-2 font-semibold text-white bg-green-600 cursor-pointer"
                        @click="open=!open">
                        <span>Nominee Info</span>
                        <span x-text="open ? '−' : '+'"></span>
                    </div>
                    <div x-show="open" class="border-t">
                        <table class="w-full text-sm border-collapse">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2 text-left border-b">Name</th>
                                    <th class="p-2 text-left border-b">Relation</th>
                                    <th class="p-2 text-left border-b">Address</th>
                                    <th class="p-2 text-left border-b">Percentage</th>
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
@endsection