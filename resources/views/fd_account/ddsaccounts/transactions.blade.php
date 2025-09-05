@extends('layout.main')

@section('content')
    <div class="container-fluid">
        <h3 class="mb-3">DD - {{ $ddsAccount->id }} | Transactions</h3>

        {{-- Filters --}}
        <form method="GET" action="{{ route('dds-accounts.transactions', $ddsAccount->id) }}" class="row g-2 mb-3">
            <div class="box-body">
                <form class="search-form-2" onsubmit="block_ui()" id="rd_account_transaction_search"
                    action="/recurring-deposit/accounts/a80ac358-1593-4c29-81de-7d82402f8ea2/transactions"
                    accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="q_tranx_id_cont">Tranx Id :</label>
                            <input class="form-control" placeholder="Search Tranx Id" autocomplete="off" type="search"
                                name="q[tranx_id_cont]" id="q_tranx_id_cont">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="q_message_cont">Remarks :</label>
                            <input class="form-control" placeholder="Search Remarks" autocomplete="off" type="search"
                                name="q[message_cont]" id="q_message_cont">
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="q_transaction_date_gteq">Transaction Date Range:</label>
                            <input class="form-control bg-white datepicker-inputmask" placeholder="T Date From (DD/MM/YYYY)"
                                autocomplete="off" type="search" name="q[transaction_date_gteq]"
                                id="q_transaction_date_gteq">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="q_transaction_date_lteq">&nbsp;</label>
                            <input class="form-control bg-white datepicker-inputmask" placeholder="T Date To (DD/MM/YYYY)"
                                autocomplete="off" type="search" name="q[transaction_date_lteq]"
                                id="q_transaction_date_lteq">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="q_amount_gteq">Amount Range :</label>
                            <input class="form-control" placeholder="From Amount" autocomplete="off" type="search"
                                name="q[amount_gteq]" id="q_amount_gteq">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="q_amount_lteq">&nbsp;</label>
                            <input class="form-control" placeholder="To Amount" autocomplete="off" type="search"
                                name="q[amount_lteq]" id="q_amount_lteq">
                        </div>
                    </div>

                    <div class="clearfix margin-bottom-10"></div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">
                            <span class="fa fa-search"></span> SEARCH
                        </button>

                        <a class="btn btn-warning" href="{{ route('dds-accounts.transactions', $ddsAccount->id) }}"
                            class="btn btn-secondary">Clear</a>

                    </div>
                </form>
            </div>

        </form>

        {{-- Table --}}
        {{-- <div class="card shadow-sm p-3">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>T. Date</th>
                        <th>Pay Mode</th>
                        <th>Remarks</th>
                        <th>Status</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                        <th>Accounted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $tran)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($tran->transaction_date)->format('d/m/Y') }}</td>
                            <td>{{ ucfirst($tran->pay_mode) }}</td>
                            <td>{{ $tran->remarks ?? '-' }}</td>
                            <td><span class="badge bg-success">Approved</span></td>
                            <td>{{ number_format($tran->debit ?? 0, 2) }}</td>
                            <td>{{ number_format($tran->amount, 2) }}</td>
                            <td>{{ number_format($tran->balance ?? $tran->amount, 2) }}</td>
                            <td><span class="badge bg-danger">{{ $tran->accounted ? 'Yes' : 'No' }}</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-success">Receipt</a>
                                <form action="{{ route('dds-accounts.transactions.destroy', $tran->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this transaction?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No transactions found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div> --}}
        <div class="box">
            <div class="box-body table-responsive">
                <table class="table table-hover table-header">
                    <thead>
                        <tr>
                            <th class="px-6 py-4 text-center">T.DATE</th>
                            <th class="px-6 py-4 text-center">PAY MODE</th>
                            <th class="px-6 py-4 text-center">REMARKS</th>
                            <th class="px-6 py-4 text-center"> STATUS</th>
                            <th class="px-6 py-4 text-center">DEBIT</th>
                            <th class="px-6 py-4 text-center">CREDIT</th>
                            <th class="px-6 py-4 text-center">BALANCE</th>
                            <th class="px-6 py-4 text-center">ACCOUNTED</th>
                            <th class="px-7 py-4 text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $tran)
                            <tr class="popup-gallery">
                                {{-- Transaction Date --}}
                                <td class="px-6 py-4 text-center">
                                    {{ \Carbon\Carbon::parse($tran->transaction_date)->format('d/m/Y') }}</td>

                                {{-- Pay Mode --}}
                                <td class="px-6 py-4 text-center">{{ ucfirst($tran->pay_mode) }}</td>

                                {{-- Remarks --}}
                                <td class="px-6 py-4 text-center"> {{ $tran->remarks ?? '-' }}</td>

                                {{-- Status --}}
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="label {{ $tran->status == 'Approved' ? 'label-success' : 'label-warning' }}">
                                        {{ $tran->status ?? 'Pending' }}
                                    </span>
                                </td>

                                {{-- Debit / Credit / Balance --}}
                                <td class="px-6 py-4 text-center">{{ $tran->debit ? number_format($tran->debit, 2) : '' }}
                                </td>
                                <td class="px-6 py-3 text-center">{{ number_format($tran->amount, 2) }}</td>
                                <td class="px-6 py-3 text-center">{{ number_format($tran->balance ?? $tran->amount, 2) }}
                                </td>

                                {{-- Accounted --}}
                                <td class="text-center">
                                    <span class="label {{ $tran->accounted ? 'label-success' : 'label-danger' }}">
                                        {{ $tran->accounted ? 'Yes' : 'No' }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-3 text-center">
                                    View
                                    <a href="{{ route('dds-accounts.transactions.show', [$ddsAccount->id, $tran->id]) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    {{-- Print --}}
                                    {{-- <a class="btn btn-success btn-xs" href="{{ route('dds-accounts.transactions.print', $tran->id) }}"> --}}
                                    <i class="fa fa-print"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('dds-accounts.transactions.destroy', $tran->id) }}"
                                        method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs"
                                            onclick="return confirm('Are you sure to delete transaction?')">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">No transactions found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Footer --}}
                {{-- <div class="box-footer clearfix">
            <div class="pagination-sm no-margin text-center">
                {{ $transactions->links() }}
            </div>
        </div> --}}

                {{-- CSV Download --}}
                <div class="clearfix"></div>
                {{-- <a class="btn btn-danger btn-xs" href="{{ route('dds-accounts.transactions.export', $ddsAccount->id) }}"> --}}
                <i class="fa fa-download" aria-hidden="true"></i> &nbsp; DOWNLOAD CSV
                </a>
            </div>
        </div>
    @endsection
