@extends('layout.main')

@section('content')
@if (session('success'))
    <div class="bg-primary border border-primary text-white px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

<div class="main-inner">

    <!-- Header -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-2xl font-semibold">Transaction - MIS{{ $transaction->id }}</h1>
        </div>
    </div>

    <!-- Transaction Details -->
    <div class="w-full grid grid-cols-2 overflow-hidden">
        <div class="overflow-x-auto border rounded-lg dark:bg-bg3 bg-white shadow-md p-4">
              <div class="flex justify-end gap-2">
                 <div class="flex justify-end mb-4">
                    <a href="#" class="btn-primary px-2 py-2 ">
                        <i class="las la-print"></i>
                    </a>
                </div>
                 <!-- <div class="flex justify-end mb-4">
                    <a href="#" class="btn-error px-2 py-2 ">
                        <i class="las la-trash-alt"></i>
                    </a>
                </div> -->
            </div>
            <table class="w-full whitespace-nowrap text-sm text-left">
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <tr>
                        <td class="font-semibold px-4 py-2 w-1/3">Member</td>
                        <td class="px-4 py-2">
                            {{ $misaccount->member->member_info_first_name ?? 'N/A' }}
                            {{ $misaccount->member->member_info_last_name ?? '' }}
                        </td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">MIS No.</td>
                        <td class="px-4 py-2">{{ $misaccount->id ?? 'N/A' }}</td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Reference Id</td>
                        <td class="px-4 py-2">MIS{{ $transaction->id }}</td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Transaction Date</td>
                        <td class="px-4 py-2">
                            {{ $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') : '-' }}
                        </td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Transaction Type</td>
                        <td class="px-4 py-2">{{ ucfirst($transaction->transaction_type ?? '-') }}</td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Amount</td>
                        <td class="px-4 py-2">₹ {{ number_format($transaction->amount ?? 0, 2) }}</td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Transaction Status</td>
                        <td class="px-4 py-2">
                            @if (strtolower($transaction->approve_status ?? '') === 'approved')
                                <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary">
                                    APPROVED
                                </span>
                            @elseif (strtolower($transaction->approve_status ?? '') === 'pending')
                                <span class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning">
                                    PENDING
                                </span>
                            @else
                                <span class="block w-28 rounded-[30px] border border-n30 bg-error/10 py-2 text-center text-xs text-error">
                                    REJECTED
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Payment Mode</td>
                        <td class="px-4 py-2">{{ ucfirst($transaction->pay_mode ?? '-') }}</td>
                    </tr>
                
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Remarks</td>
                        <td class="px-4 py-2">{{ $transaction->remark ?? '-' }}</td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Created At</td>
                        <td class="px-4 py-2">{{ $transaction->created_at ? $transaction->created_at->format('d/m/Y H:i') : '-' }}</td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Updated At</td>
                        <td class="px-4 py-2">{{ $transaction->updated_at ? $transaction->updated_at->format('d/m/Y H:i') : '-' }}</td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Accounted</td>
                        <td class="px-4 py-2">
                            @if($transaction->accounted)
                                <span class="block w-20 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary">
                                    Yes
                                </span>
                            @else
                                <span class="block w-20 rounded-[30px] border border-n30 bg-error/10 py-2 text-center text-xs text-error">
                                    No
                                </span>
                            @endif
                        </td>
                    </tr>
                     <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Branch</td>
                        <td class="px-4 py-2">{{ $misaccount->branch->branch_name ?? 'N/A' }}</td>
                    </tr>
                     <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Entry Created By</td>
                        <td class="px-4 py-2"></td>
                    </tr>
                     <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Entry Collected By</td>
                        <td class="px-4 py-2"></td>
                    </tr>
                    
                   
                </tbody>
            </table>
        </div>
    </div>

    <!-- Audit Trail -->
    <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg mt-4">
        <!-- Header -->
        <div class="flex justify-between items-center px-4 py-2 bg-secondary/10 text-black rounded-t-lg">
            <h3 class="text-black font-semibold text-lg">MIS ACCOUNT TRANSACTION AUDIT TRAIL</h3>
            <button class="p-1 rounded transition" onclick="toggleSection(this)">
                <span class="toggle-icon text-lg font-bold">+</span>
            </button>
        </div>

        <!-- Content (Initially Hidden) -->
        <div class="overflow-x-auto p-4 hidden">
            <table class="w-full border-collapse">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-sm font-semibold text-start">Creator</th>
                        <th class="px-4 py-2 text-sm font-semibold text-start">Event</th>
                        <th class="px-4 py-2 text-sm font-semibold text-start">Created On</th>
                        <th class="px-4 py-2 text-sm font-semibold text-start">Change Logs</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-4 py-2">System Admin</td>
                        <td class="px-4 py-2">Approved Transaction</td>
                        <td class="px-4 py-2">-</td>
                        <td class="px-4 py-2">-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- collapsed logic + - button-->
<script>
    function toggleSection(button) {
        const section = button.closest('.box').querySelector('.overflow-x-auto');
        const icon = button.querySelector('.toggle-icon');

        section.classList.toggle('hidden');
        icon.textContent = section.classList.contains('hidden') ? '+' : '−';
    }
</script>
@endsection
