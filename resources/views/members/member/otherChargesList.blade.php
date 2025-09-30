@extends('layout.main')

@section('page-title',
    isset($member)
    ? 'Members - ' .
    $member->member_info_first_name .
    '
    Transactions'
    : 'Members Transactions')

@section('content')
    <div class="main-inner">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <a href="{{ route('members.other-charges', ['id' => $member->id]) }}" class="btn-primary rounded-10 px-2 py-2 mb-4">
            DEBIT OTHER CHARGES
        </a>

        <a href="{{ $charge && $charge->id
            ? route('members.other-charges.clearDue.form', [
                'id' => $charge->member_id ?? '',
                'chargeId' => $charge->id ?? '',
            ])
            : '#' }}"
            class="btn-warning rounded-10 px-2 py-2 mb-4">
            CLEAR DUES
        </a>
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
                            <th class="px-6 py-3 text-center">Date</th>
                            <th class="px-6 py-3 text-center">Charge Type</th>
                            <th class="px-6 py-3 text-center">Amount</th>
                            <th class="px-6 py-3 text-center">Remarks</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3 text-center">Created at</th>
                            <th class="px-6 py-3 text-center">Updated at</th>

                            <th class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($otherCharge as $otherCharges)
                            <tr>
                                <td class="px-6 py-4 text-center">
                                    {{ \Carbon\Carbon::parse($otherCharges->transaction_date)->format('d-m-Y') }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ ucfirst($otherCharges->charge_type) }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $otherCharges->charges ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $otherCharges->remarks ?? 'N/A' }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if ($otherCharges->status === 'PAID')
                                        <span class="badge badge-success">PAID</span>
                                    @elseif($otherCharges->status === 'DUE')
                                        <span class="badge badge-warning">DUE</span>
                                    @elseif($otherCharges->status === 'PENDING')
                                        <span class="badge badge-secondary">PENDING</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ \Carbon\Carbon::parse($otherCharges->created_at)->format('d-m-Y') }}

                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ \Carbon\Carbon::parse($otherCharges->updated_at)->format('d-m-Y') }}

                                </td>

                                {{-- ✅ Actions Column --}}
                                <td class="px-6 py-4 text-center">
                                    @if ($otherCharges->status === 'DUE')
                                        <div class="flex justify-center">
                                            @include('partials._vertical-options', [
                                                'id' => $otherCharges->id,
                                                'deleteRoute' => 'transactions.softDelete',
                                            ])
                                        </div>
                                    @else
                                        <div class="text-gray-400 text-sm"></div>
                                    @endif
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
