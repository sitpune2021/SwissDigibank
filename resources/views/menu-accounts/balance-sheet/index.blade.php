@extends('layout.main')

@section('content')

<div class="container">


    <div class="text-end mb-3 no-print">
        <button onclick="printBalanceSheet()" class="btn btn-dark  btn-primary">
            <i class="fa fa-print"></i> Print
        </button>
    </div>


    <h3 class="mb-4 text-center">
        Balance Sheet as on {{ $today->format('d M Y') }}
    </h3>

    <div class="card shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive" id="printArea">
                <table class="table table-bordered table-striped mb-0">

                    <thead class="table-dark text-center">
                        <tr>
                            <th width="50%">ASSETS</th>
                            <th width="50%">LIABILITIES & EQUITY</th>
                        </tr>
                    </thead>

                    <tbody>

                        @php
                            $maxRows = max(
                                count($assets),
                                count($liabilities) + count($equities) + 1
                            );
                        @endphp

                        @for($i = 0; $i < $maxRows; $i++)
                            <tr>

                                {{-- ASSETS COLUMN --}}
                                <td>
                                    @if(isset($assets[$i]))
                                        <div class="d-flex justify-content-between">
                                            <span>{{ $assets[$i]['name'] }}</span>
                                            <span>{{ number_format($assets[$i]['amount'],2) }}</span>
                                        </div>
                                    @endif
                                </td>

                                {{-- LIABILITIES + EQUITY COLUMN --}}
                                <td>

                                    {{-- Liabilities --}}
                                    @if(isset($liabilities[$i]))
                                        <div class="d-flex justify-content-between">
                                            <span>{{ $liabilities[$i]['name'] }}</span>
                                            <span>{{ number_format($liabilities[$i]['amount'],2) }}</span>
                                        </div>
                                    @endif

                                    {{-- Equity --}}
                                    @if(isset($equities[$i - count($liabilities)]))
                                        <div class="d-flex justify-content-between">
                                            <span>{{ $equities[$i - count($liabilities)]['name'] }}</span>
                                            <span>{{ number_format($equities[$i - count($liabilities)]['amount'],2) }}</span>
                                        </div>
                                    @endif

                                    {{-- Current Profit --}}
                                    @if($i == count($liabilities) + count($equities))
                                        <div class="d-flex justify-content-between fw-semibold">
                                            <span>Current Year Profit</span>
                                            <span>{{ number_format($netProfit,2) }}</span>
                                        </div>
                                    @endif

                                </td>

                            </tr>
                        @endfor

                        {{-- TOTAL ROW --}}
                        <tr class="fw-bold table-secondary">
                            <td>
                                <div class="d-flex justify-content-between">
                                    <span>Total Assets</span>
                                    <span>{{ number_format($totalAssets,2) }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <span>Total Liabilities & Equity</span>
                                    <span>{{ number_format($totalLiabilities + $totalEquity,2) }}</span>
                                </div>
                            </td>
                        </tr>

                    </tbody>

                </table>
            </div>

        </div>
    </div>

    {{-- Difference Alert --}}
    @if($difference != 0)
        <div class="alert alert-danger mt-4 text-center">
            ⚠ Balance Sheet Not Matching. Difference:
            {{ number_format($difference,2) }}
        </div>
    @else
        <div class="alert alert-success mt-4 text-center">
            ✅ Balance Sheet Matched Perfectly
        </div>
    @endif

</div>

<script>
function printBalanceSheet() {

    var printContents = document.getElementById('printArea').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
    location.reload();
}
</script>


@endsection
