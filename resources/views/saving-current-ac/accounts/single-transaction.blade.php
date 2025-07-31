@extends('layout.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="main-inner">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6 lg:mb-8">
        <h2 class="font-bold text-gray-800 h2">Transaction</h2>
    </div>
    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>
    <!-- Transaction Details Card -->
    <div class="relative bg-white border border-gray-300 rounded-lg shadow-md">
        <!-- Action Icons Top-Right -->
        <div class="flex items-center justify-between px-4 py-2 border-b bg-gray-50">
            <!-- Member Name -->
            <span class="text-sm font-semibold text-blue-600"></span>
            <!-- Icons -->
            <div class="flex gap-2">
                <button class="px-2 py-1 text-xs text-white bg-green-500 rounded hover:bg-gray-300" title="Print">
                    <i class="fas fa-print"></i>
                </button>

                <a href="{{route('reverse-transaction.view',['id' => base64_encode($transactions->id)])}}"
                    class="px-2 py-1 text-xs text-black bg-gray-200 rounded hover:bg-gray-300"
                    title="Reverse Transaction">
                    <i class="fa fa-recycle"></i>
                </a>


                <button class="px-2 py-1 text-xs text-white bg-red-500 rounded hover:bg-gray-300" title="Delete">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>

        </div>
        <!-- Transaction Details Table -->
        <table class="w-full text-sm text-left border border-gray-300">
            <tbody>
                <tr>
                    <td class="px-4 py-2 font-semibold border border-gray-300 bg-gray-50">Member</td>
                    <td class="px-4 py-2 text-blue-600 border border-gray-300">{{$transactions->accounts->members->member_info_first_name}}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border border-gray-300 bg-gray-50">Account No.</td>
                    <td class="px-4 py-2 border border-gray-300">{{$transactions->accounts->account_no}}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border border-gray-300 bg-gray-50">Transaction Date</td>
                    <td class="px-4 py-2 border border-gray-300">{{$transactions->accounts->transaction_date}}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border border-gray-300 bg-gray-50">Reference Id</td>
                    <td class="px-4 py-2 border border-gray-300">S11863</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border border-gray-300 bg-gray-50">Transaction Type</td>
                    <td class="px-4 py-2 border border-gray-300">Credit</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border border-gray-300 bg-gray-50">Amount</td>
                    <td class="px-4 py-2 font-bold text-green-600 border border-gray-300">{{$transactions->amount}}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border border-gray-300 bg-gray-50">Transaction Status</td>
                    <td class="px-4 py-2 text-green-600 border border-gray-300">Approved</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border border-gray-300 bg-gray-50">Payment Mode</td>
                    <td class="px-4 py-2 border border-gray-300">{{$transactions->accounts->payment_mode}}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border border-gray-300 bg-gray-50">Tranx Receipt</td>
                    <td class="px-4 py-2 border border-gray-300"></td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border border-gray-300 bg-gray-50">Remarks</td>
                    <td class="px-4 py-2 border border-gray-300"></td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border border-gray-300 bg-gray-50">Created at</td>
                    <td class="px-4 py-2 border border-gray-300">{{$transactions->created_at}}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border border-gray-300 bg-gray-50">Updated at</td>
                    <td class="px-4 py-2 border border-gray-300">{{$transactions->updated_at}}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border border-gray-300 bg-gray-50">Is Accounted</td>
                    <td class="px-4 py-2 border border-gray-300">
                        <span class="px-2 py-1 text-white bg-red-500 rounded">No</span>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border border-gray-300 bg-gray-50">Branch</td>
                    <td class="px-4 py-2 border border-gray-300">{{$transactions->accounts->branches->branch_name}}</td>
                </tr>
                <!-- New Fields Added -->
                <tr>
                    <td class="px-4 py-2 font-semibold border border-gray-300 bg-gray-50">Entry Created By</td>
                    <td class="px-4 py-2 border border-gray-300">NA</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border border-gray-300 bg-gray-50">Entry Collected By</td>
                    <td class="px-4 py-2 border border-gray-300">NA</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border border-gray-300 bg-gray-50">Entry Approved By</td>
                    <td class="px-4 py-2 border border-gray-300">NA</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border border-gray-300 bg-gray-50">Approval Date</td>
                    <td class="px-4 py-2 border border-gray-300">NA</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Collapsible Audit Trail Section -->
    <div class="mt-6 border border-gray-300 rounded shadow bg-gray-50" x-data="{ open: true }">
        <!-- Header with toggle -->
        <div class="flex items-center justify-between px-4 py-2 font-bold text-white uppercase rounded-t cursor-pointer" style="background-color: green"
            @click="open = !open">
            <span>SAVING ACCOUNT TRANSACTION AUDIT TRAIL</span>
            <span x-text="open ? '−' : '+'"></span>
        </div>

        <!-- Content -->
        <div x-show="open" class="overflow-x-auto">
            <table class="w-full text-sm text-left bg-white border border-gray-300">
                <thead class="font-semibold text-gray-700 bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border border-gray-300">Creator</th>
                        <th class="px-4 py-2 border border-gray-300">Event</th>
                        <th class="px-4 py-2 border border-gray-300">Create On</th>
                        <th class="px-4 py-2 border border-gray-300">Change Logs</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
</div>
@endsection