@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm p-4">
        <h4 class="mb-4">Transaction - {{ $transaction->id }}</h4>

        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-success btn-xs"
                href="{{ url('/print-documents/transaction-receipt?t_id='.$transaction->id.'&t_type=DdAccountTransaction') }}">
                <i class="fa fa-print"></i>
            </a>
            <a class="btn btn-danger btn-xs ms-2" title="Delete"
                data-confirm="Are you sure to delete transaction?"
                rel="nofollow" data-method="delete"
                href="{{ route('dds-accounts.transactions.destroy', [$ddsAccount->id, $transaction->id]) }}">
                <i class="fa fa-trash"></i>
            </a>
        </div>

        <table class="table table-borderless">
            <tr>
                <th>Member</th>
                <td class="font-semibold px-4 py-2">
                    <a href="{{ route('member.show', $ddsAccount->member->id) }}" class="text-primary hover:underline">
                        DEMO-{{ $ddsAccount->member->id }} -
                        {{ $ddsAccount->member->member_info_first_name }}
                        {{ $ddsAccount->member->member_info_last_name }}
                    </a>
                </td>
            </tr>

            <tr>
                <th class="font-semibold px-4 py-2">RD/DD No.</th>
                <td class="font-semibold px-4 py-2">{{ $ddsAccount->id }}</td>
            </tr>

            <tr>
                <th class="font-semibold px-4 py-2">Reference ID</th>
                <td class="font-semibold px-4 py-2">{{ $transaction->id }}</td>
            </tr>

            <tr>
                <th class="font-semibold px-4 py-2">Transaction Date</th>
                <td class="font-semibold px-4 py-2">{{ $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y H:i:s') : '-' }}</td>
            </tr>

            <tr>
                <th class="font-semibold px-4 py-2"> Transaction Type</th>
                <td class="font-semibold px-4 py-2">{{ ucfirst($transaction->transaction_type ?? '') }}</td>
            </tr>

            <tr>
                <th class="font-semibold px-4 py-2">Amount</th>
                <td class="font-semibold px-4 py-2"><strong>{{ number_format($transaction->amount, 2) }}</strong></td>
            </tr>

            <tr>
                <th class="font-semibold px-4 py-2">Transaction Status</th>
                <td class="font-semibold px-4 py-2">
                    <span class=" {{ $transaction->status === 'approved' ? '' : '' }}">
                        {{ ucfirst($transaction->status ?? 'Pending') }}
                    </span>
                </td>
            </tr>

            <tr>
                <th class="font-semibold px-4 py-2">Payment Mode</th>
                <td class="font-semibold px-4 py-2">{{ ucfirst($transaction->pay_mode ?? '-') }}</td>
            </tr>

            <tr>
                <th class="font-semibold px-4 py-2">Remarks</th>
                <td class="font-semibold px-4 py-2">{{ $transaction->remarks ?? '-' }}</td>
            </tr>

            <tr>
                <th class="font-semibold px-4 py-2">Tranx Receipt</th>
                <td class="font-semibold px-4 py-2">{{ $transaction->tranx_receipt ?? '-' }}</td>
            </tr>

            <tr>
                <th class="font-semibold px-4 py-2">Is Accounted</th>
                <td class="font-semibold px-4 py-2">
                    @if($transaction->is_accounted)
                        <span class="badge bg-success">Yes</span>
                    @else
                        <span class="badge bg-danger">No</span>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="font-semibold px-4 py-2">Created At</th>
                <td>{{ $transaction->created_at?->format('d-m-Y H:i') ?? '-' }}</td>
            </tr>

            <tr>
                <th class="font-semibold px-4 py-2">Updated At</th>
                <td class="font-semibold px-4 py-2">{{ $transaction->updated_at?->format('d-m-Y H:i') ?? '-' }}</td>
            </tr>

            <tr>
                <th class="font-semibold px-4 py-2">Branch</th>
                <td class="font-semibold px-4 py-2">{{ $ddsAccount->branch->branch_name ?? '-' }}</td>
            </tr>

            <tr>
                <th class="font-semibold px-4 py-2">Entry Created By</th>
                <td class="font-semibold px-4 py-2">{{ $transaction->created_by->name ?? '-' }}</td>
            </tr>

            <tr>
                <th class="font-semibold px-4 py-2">Entry Collected By</th>
                <td class="font-semibold px-4 py-2">{{ $transaction->collected_by->name ?? '-' }}</td>
            </tr>

            <tr>
                <th class="font-semibold px-4 py-2">Entry Approved By</th>
                <td class="font-semibold px-4 py-2">{{ $transaction->approved_by->name ?? '-' }}</td>
            </tr>

            <tr>
                <th class="font-semibold px-4 py-2">Approval Date</th>
                <td class="font-semibold px-4 py-2">{{ $transaction->approval_date ? \Carbon\Carbon::parse($transaction->approval_date)->format('d-m-Y') : '-' }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
