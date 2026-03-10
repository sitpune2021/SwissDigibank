@extends('layout.main')

@section('content')

<div class="container">

        <div class="mt-5">
            <form>
                <div class="flex justify-center box gap-3">
                    <div class="">
                        <select name="branch_id" class="w-64 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                            <option value="">ALL BRANCH</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}"
                                    {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->branch_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="">
                        <button type="submit" class="btn-warning rounded-10  text-sm">
                            GET
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <style>

        .balance-wrapper{
        width:100%;
        padding:20px 30px;
        }

        /* CARD */

        .balance-card{
        background:#ffffff;
        border-radius:8px;
        box-shadow:0 2px 10px rgba(0,0,0,0.05);
        padding:25px;
        }

        /* TABLE */

        .balance-table{
        width:100%;
        border-collapse:collapse;
        font-size:14px;
        }

        .balance-table thead th{
        background:#f4f6f9;
        padding:12px 14px;
        border-bottom:2px solid #dcdcdc;
        font-weight:600;
        text-align:left;
        }

        .balance-table thead th:nth-child(2),
        .balance-table thead th:nth-child(3){
        text-align:right;
        }

        /* ROWS */

        .balance-table td{
        padding:10px 14px;
        border-bottom:1px solid #eee;
        }

        .balance-table td:nth-child(2),
        .balance-table td:nth-child(3){
        text-align:right;
        font-weight:500;
        }

        /* SECTION TITLE */

        .section-title{
        background:#f1f3f5;
        color:#2c6fb7;
        font-weight:700;
        font-size:15px;
        }

        /* TOTAL ROW */

        .total-row{
        background:#eef3ff;
        font-weight:700;
        border-top:2px solid #cfd8ff;
        }

        /* HOVER */

        .balance-table tbody tr:hover{
        background:#f9fbff;
        }

        /* STICKY HEADER */

        .balance-table thead{
        position:sticky;
        top:0;
        z-index:10;
        }

        /* MOBILE */

        @media (max-width:768px){

        .balance-wrapper{
        padding:10px;
        }

        .balance-card{
        padding:15px;
        }

        .balance-table{
        font-size:12px;
        }

        .balance-table th,
        .balance-table td{
        padding:8px;
        }

        .balance-title{
        font-size:16px;
        }

        }

        </style>


        <div class="balance-wrapper">

            <div class="balance-card">

                <div class="flex justify-end mb-4 no-print">

                    <a href="{{ route('balance.sheet.print',['branch_id'=>$branchId]) }}" 
                    target="_blank"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-md px-4 py-2 flex items-center gap-2">

                    <i class="las la-print"></i> Print

                    </a>

                </div>


                <h3 class="text-center balance-title text-lg font-semibold mb-6">

                    Balance Sheet for the period:

                    <span class="text-blue-600">

                    01/04/{{ date('Y') }} to {{ $today->format('d/m/Y') }}

                    </span>

                </h3>


                <div class="overflow-x-auto">

                    <table class="balance-table">

                    <thead>

                    <tr>

                    <th>PARTICULARS</th>

                    <th>CURRENT ({{ $today->format('d-m-Y') }})</th>

                    <th>PREVIOUS (31-03-{{ date('Y')-1 }})</th>

                    </tr>

                    </thead>

                    <tbody>


                    {{-- EQUITY --}}

                    <tr class="section-title">

                    <td colspan="3">EQUITY</td>

                    </tr>


                    @foreach($equities as $equity)

                    <tr>

                    <td>{{ strtoupper($equity['name']) }}</td>

                    <td>

                    {{ number_format($equity['current'],2) }}

                    </td>

                    <td>

                    {{ number_format($equity['previous'],2) }}

                    </td>

                    </tr>

                    @endforeach


                    <tr class="total-row">

                    <td>TOTAL EQUITY</td>

                    <td>{{ number_format($totalEquity,2) }}</td>

                    <td></td>

                    </tr>


                    {{-- LIABILITIES --}}

                    <tr class="section-title">

                    <td colspan="3">LIABILITIES</td>

                    </tr>


                    @foreach($liabilities as $liability)

                    <tr>

                    <td>{{ strtoupper($liability['name']) }}</td>

                    <td>

                    {{ number_format($liability['current'],2) }}

                    </td>

                    <td>

                    {{ number_format($liability['previous'],2) }}

                    </td>

                    </tr>

                    @endforeach


                    <tr class="total-row">

                    <td>TOTAL LIABILITIES</td>

                    <td>{{ number_format($totalLiabilities,2) }}</td>

                    <td></td>

                    </tr>


                    {{-- ASSETS --}}

                    <tr class="section-title">

                    <td colspan="3">ASSETS</td>

                    </tr>


                    @foreach($assets as $asset)

                    <tr>

                    <td>{{ strtoupper($asset['name']) }}</td>

                    <td>

                    {{ number_format($asset['current'],2) }}

                    </td>

                    <td>

                    {{ number_format($asset['previous'],2) }}

                    </td>

                    </tr>

                    @endforeach


                    <tr class="total-row">

                    <td>TOTAL ASSETS</td>

                    <td>{{ number_format($totalAssets,2) }}</td>

                    <td></td>

                    </tr>


                    </tbody>

                    </table>

                </div>

            </div>

        </div>
       
</div>


@endsection
