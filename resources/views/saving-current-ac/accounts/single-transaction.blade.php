@extends('layout.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="main-inner">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-2 lg:mb-2">
        <h3 class="font-semibold text-lg text-gray-800 ">TRANSACTION</h3>
    </div>
    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-3 lg:pb-3" style="flex-direction: row-reverse;">
        <x-alert />
    </div>
    <!-- Transaction Details Card -->
    
    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 p-6 rounded-10 min-h-screen md-4">
      <div class="col-span-2 md:col-span-1 bg-white rounded-10  dark:bg-bg3 p-6">
    <div class="relative   border-gray-300 rounded-lg ">
        <!-- Action Icons Top-Right -->
        <div class="flex items-center justify-between px-4 py-2 border-b bg-gray-50">
            <!-- Member Name -->
            <span class="text-sm font-semibold text-blue-600"></span>
            <!-- Icons -->
            <div class="flex gap-2">
                <button class="p-2 text-xs btn-primary  " title="Print">
                    <i class="las la-print"></i>
                </button>

                <a href="{{route('reverse-transaction.view',['id' => base64_encode($transactions->id)])}}"
                    class="p-2 text-xs btn-secondary"
                    title="Reverse Transaction">
                    <i class="las la-recycle"></i>
                </a>


                <button class="p-2 text-xs btn-error" title="Delete">
                    <i class="las la-trash-alt"></i>
                </button>
            </div>

        </div>

        
        <!-- Transaction Details Table -->
        <table class="w-full text-sm text-left ">
            <tbody>
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold bg-gray-50 uppercase">Customer</td>
                    <td class="px-4 py-2 text-primary">{{$transactions->accounts->members->member_info_first_name??''}}</td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold bg-gray-50 uppercase">Account No.</td>
                    <td class="px-4 py-2">{{$transactions->accounts->account_no}}</td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold bg-gray-50 uppercase">Transaction Date</td>
                    <td class="px-4 py-2">
                        {{ $transactions->accounts->transaction_date ? \Carbon\Carbon::parse($transactions->accounts->transaction_date)->format('d-m-Y') : '-' }}
                    </td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold bg-gray-50 uppercase">Reference Id</td>
                    <td class="px-4 py-2">S11863</td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold bg-gray-50 uppercase">Transaction Type</td>
                    <td class="px-4 py-2">Credit</td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold bg-gray-50 uppercase">Amount</td>
                    <td class="px-4 py-2  text-green-600">{{$transactions->amount}}</td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold bg-gray-50 uppercase">Transaction Status</td>
                    <td class="px-4 py-2 ">
                        {{$transactions->approve_status}}
                    </td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold bg-gray-50 uppercase">Payment Mode</td>
                    <td class="px-4 py-2">  {{ $transactions->source_type === 'OTHER_CHARGE' ? 'System' : ($transactions->payment_mode ?? '-') }}</td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold bg-gray-50 uppercase">Tranx Receipt</td>
                    <td class="px-4 py-2"></td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold bg-gray-50 uppercase">Remarks</td>
                    <td class="px-4 py-2"></td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold bg-gray-50 uppercase">Created at</td>
                    <td class="px-4 py-2">
                        {{ $transactions->accounts->created_at ? \Carbon\Carbon::parse($transactions->accounts->created_at)->format('d-m-Y') : '-' }}
                    </td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold bg-gray-50 uppercase">Updated at</td>
                    <td class="px-4 py-2">
                        {{ $transactions->accounts->updated_at ? \Carbon\Carbon::parse($transactions->accounts->updated_at)->format('d-m-Y') : '-' }}
                    </td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold bg-gray-50 uppercase">Is Accounted</td>
                    <td class="px-4 py-2">
                       <div class="flex items-center gap-1">
                                    {{-- <span
                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                Yes
                            </span> --}}
                             <span
                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                No
                            </span>
                                </div>
                    </td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold bg-gray-50 uppercase">Branch</td>
                    <td class="px-4 py-2">{{$transactions->accounts->branch->branch_name}}</td>
                </tr>
                <!-- New Fields Added -->
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold bg-gray-50 uppercase">Entry Created By</td>
                    <td class="px-4 py-2">NA</td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold bg-gray-50 uppercase">Entry Collected By</td>
                    <td class="px-4 py-2">NA</td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold bg-gray-50 uppercase">Entry Approved By</td>
                    <td class="px-4 py-2">NA</td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold bg-gray-50 uppercase">Approval Date</td>
                    <td class="px-4 py-2">NA</td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>
    </div>

    <!-- Collapsible Audit Trail Section -->
    <div class="mt-6 rounded-10 shadow box bg-gray-50" x-data="{ open: true }">
        <!-- Header with toggle -->
        <div class="flex items-center justify-between px-4 py-3  font-bold bg-secondary/5 uppercase rounded-10 cursor-pointer" style=""
            @click="open = !open">
            <span>SAVING ACCOUNT TRANSACTION AUDIT TRAIL</span>
            <span x-text="open ? '−' : '+'"></span>
        </div>

        <!-- Content -->
        <div x-show="open" class="overflow-x-auto">
            <table class="w-full text-sm text-left bg-white ">
                <thead class="font-semibold text-gray-700 bg-gray-100">
                    <tr class="border-b">
                        <th class="px-4 py-2  uppercase ">Creator</th>
                        <th class="px-4 py-2  uppercase">Event</th>
                        <th class="px-4 py-2  uppercase">Create On</th>
                        <th class="px-4 py-2  uppercase">Change Logs</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection