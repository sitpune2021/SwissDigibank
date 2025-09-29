@extends('layout.main')
@section('page-title',
    isset($member)
    ? 'Transaction - ' .
    $member->member_info_first_name .
    '
    '
    : 'Members ')
@section('content')
    <div class="main-inner">
        <!-- Header -->
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col gap-2">
                <p class="text-gray-500">
                    <a href="#" class="text-gray-500">Recurring Deposits</a> >
                </p>
            </div>
        </div>
        <div class="w-full grid grid-cols-2 overflow-hidden">
            <div class="box overflow-x-auto border rounded-lg dark:bg-bg shadow-md p-4">
                <div class="flex justify-end gap-2">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('transactions.print-receipt', ['id' => $transaction->id, 'type' => $transaction->transaction_source === 'Membership Charge' ? 'normal' : 'Share amount']) }}"
                            target="_blank" class="btn-primary px-2 py-2">
                            <i class="las la-print"></i>
                        </a>

                    </div>
                    <div class="flex justify-end mb-4">
                        <form action="{{ route('transactions.softDeletetransaction', $transaction->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this transaction?')"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-error px-2 py-2">
                                <i class="las la-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <table class="w-full whitespace-nowrap text-sm text-left">
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr>
                            <td class="font-semibold px-4 py-2 w-1/3">Member</td>
                            <td class="px-4 py-2">
                                {{ $member->member_info_first_name ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr class="border-t">
                            <td class="font-semibold px-4 py-2">Transaction Date</td>
                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y') }}
                            </td>
                        </tr>
                        <tr class="border-t">
                            <td class="font-semibold px-4 py-2">Reference Id</td>
                            <td class="px-4 py-2">RD{{ $transaction->id }}</td>
                        </tr>
                        <tr class="border-t">
                            <td class="font-semibold px-4 py-2">Type</td>
                            <td class="px-4 py-2">{{ $transaction->type ?? 'N/A' }}</td>
                        </tr>
                        <tr class="border-t">
                            <td class="font-semibold px-4 py-2">Transaction Type</td>
                            <td class="px-4 py-2">{{ $transaction->transaction_type ?? 'N/A' }}</td>
                        </tr>
                        <tr class="border-t">
                            <td class="font-semibold px-4 py-2">Amount</td>
                            <td class="px-4 py-2">
                                ₹{{ number_format($transaction->membership_fee ?? ($transaction->amount ?? 0), 2) }}</td>
                        </tr>
                        <tr class="border-t">
                            <td class="font-semibold px-4 py-2">Transaction Status</td>
                            <td class="px-4 py-2">
                                {{ $transaction->status == 1 || strtolower($transaction->status) == 'approved' ? 'Approved' : 'Pending' }}
                            </td>
                        </tr>
                        <tr class="border-t">
                            <td class="font-semibold px-4 py-2">Payment Mode</td>
                            <td class="px-4 py-2">
                                {{ ucfirst($transaction->charges_pay_mode ?? ($transaction->pay_mode ?? 'N/A')) }}</td>
                        </tr>
                        <tr class="border-t">
                            <td class="font-semibold px-4 py-2">Remarks</td>
                            <td class="px-4 py-2">{{ $transaction->remarks ?? 'N/A' }}</td>
                        </tr>
                        <tr class="border-t">
                            <td class="font-semibold px-4 py-2">Created At</td>
                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y') }}
                            </td>
                        </tr>
                        <tr class="border-t">
                            <td class="font-semibold px-4 py-2">Updated At</td>
                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($transaction->updated_at)->format('d-m-Y') }}
                            </td>
                        </tr>
                        <tr class="border-t">
                            <td class="font-semibold px-4 py-2">Is Accounted</td>
                            <td class="px-4 py-2">
                                {{ $transaction->is_accounted ? 'Yes' : 'No' }}
                            </td>
                        </tr>
                        <tr class="border-t">
                            <td class="font-semibold px-4 py-2">Branch</td>
                            <td class="px-4 py-2"> {{ $branch->branch_name ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Audit Trail -->
        <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg mt-4">
            <!-- Header -->
            <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-t-lg">
                <h3 class="text-black font-semibold text-lg">MEMBER ACCOUNT TRANSACTION AUDIT TRAIL</h3>
                <!-- Toggle Button -->
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
                            <td class="px-4 py-2">Test User</td>
                            <td class="px-4 py-2">Approved Transaction</td>
                            <td class="px-4 py-2">{{ now()->format('d M Y ') }}</td>
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
