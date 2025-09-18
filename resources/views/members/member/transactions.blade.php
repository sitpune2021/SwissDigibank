@extends('layout.main')

@section('page-title', isset($member)
    ? 'Members - ' . ($member->member_info_first_name ?? $member->member_code) . ' Transactions'
    : 'Members Transactions')

@section('content')
    <div class="main-inner">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Table --}}
        <div class="col-span-12 box lg:col-span-6">
            <x-searchbox />

            <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
                <x-alert />
            </div>

            <div class="pb-4 overflow-x-auto lg:pb-6">
                <table class="w-full border border-n30 rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3 text-sm font-semibold">
                            <th class="px-6 py-3 text-center">Transaction Date</th>
                            <th class="px-6 py-3 text-center">Payment Mode</th>
                            <th class="px-6 py-3 text-center">Type</th>
                            <th class="px-6 py-3 text-center">Amount</th>
                            <th class="px-6 py-3 text-center">Remarks</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3 text-center">Is Accounted</th>
                            <th class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td class="px-6 py-4 text-center">
                                    {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y') }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ ucfirst($transaction->charges_pay_mode) }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $transaction->type ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ number_format($transaction->membership_fee, 2) }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $transaction->remarks ?? 'N/A' }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $transaction->approve_status ? 'Approved' : 'Pending' }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $transaction->is_accounted ? 'Yes' : 'No' }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <button class="btn btn-warning">Edit</button>
                                    <button class="btn btn-danger">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                    No transactions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
