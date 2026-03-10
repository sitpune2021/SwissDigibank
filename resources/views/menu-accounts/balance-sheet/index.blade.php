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


                <div class="max-w-7xl mx-auto p-6 bg-gray-50 rounded-xl shadow-sm">

                    <h3 class="text-center text-xl font-semibold mb-8 text-gray-700">
                        Balance Sheet for the period
                        <span class="block text-blue-500 text-sm mt-1">
                        01/04/{{ date('Y') }} to {{ $today->format('d/m/Y') }}
                        </span>
                    </h3>

                    <!-- TWO COLUMNS: LEFT = Liabilities+Equity, RIGHT = Assets -->
                    <div class="flex flex-col lg:flex-row gap-8">

                        <!-- LEFT COLUMN -->
                        <div class="flex-1 bg-white rounded-xl shadow-sm border border-gray-100 p-4">

                        <h4 class="font-semibold text-gray-600 text-center mb-4 tracking-wide">
                            LIABILITIES & EQUITY
                        </h4>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">

                            <thead class="bg-gray-50 text-gray-600">
                                <tr>
                                <th class="text-left p-3">PARTICULARS</th>
                                <th class="text-right p-3">CURRENT</th>
                                <th class="text-right p-3">PREVIOUS</th>
                                </tr>
                            </thead>

                            <tbody class="text-gray-700">

                                <!-- EQUITY -->
                                <tr class="bg-blue-100 text-blue-800 font-semibold" style="background-color: wheat;">
                                    <td class="p-3" colspan="3">EQUITY</td>
                                </tr>

                                @foreach($equities as $equity)
                                <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ strtoupper($equity['name']) }}</td>
                                <td class="p-3 text-right">{{ number_format($equity['current'],2) }}</td>
                                <td class="p-3 text-right">{{ number_format($equity['previous'],2) }}</td>
                                </tr>
                                @endforeach

                                <tr class="font-semibold bg-gray-50">
                                <td class="p-3">TOTAL EQUITY</td>
                                <td class="p-3 text-right">{{ number_format($totalEquity,2) }}</td>
                                <td></td>
                                </tr>

                                <!-- LIABILITIES -->
                                <tr class="bg-blue-200 font-semibold" style="background-color: wheat;">
                                    <td class="p-3" colspan="3">LIABILITIES</td>
                                </tr>

                                @foreach($liabilities as $liability)
                                <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ strtoupper($liability['name']) }}</td>
                                <td class="p-3 text-right">{{ number_format($liability['current'],2) }}</td>
                                <td class="p-3 text-right">{{ number_format($liability['previous'],2) }}</td>
                                </tr>
                                @endforeach

                                <tr class="font-semibold bg-gray-50">
                                <td class="p-3">TOTAL LIABILITIES</td>
                                <td class="p-3 text-right">{{ number_format($totalLiabilities,2) }}</td>
                                <td></td>
                                </tr>

                            </tbody>
                            </table>
                        </div>

                        </div>

                        <!-- RIGHT COLUMN -->
                        <div class="flex-1 bg-white rounded-xl shadow-sm border border-gray-100 p-4">

                        <h4 class="font-semibold text-gray-600 text-center mb-4 tracking-wide">
                            ASSETS
                        </h4>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">

                            <thead class="bg-gray-50 text-gray-600">
                                <tr>
                                <th class="text-left p-3">PARTICULARS</th>
                                <th class="text-right p-3">CURRENT</th>
                                <th class="text-right p-3">PREVIOUS</th>
                                </tr>
                            </thead>

                            <tbody class="text-gray-700">

                                <tr class="bg-green-100 text-green-800 font-semibold" style="background-color: wheat;">
                                    <td class="p-3" colspan="3">ASSETS</td>
                                </tr>

                                @foreach($assets as $asset)
                                <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ strtoupper($asset['name']) }}</td>
                                <td class="p-3 text-right">{{ number_format($asset['current'],2) }}</td>
                                <td class="p-3 text-right">{{ number_format($asset['previous'],2) }}</td>
                                </tr>
                                @endforeach

                                <tr class="font-semibold bg-gray-50">
                                <td class="p-3">TOTAL ASSETS</td>
                                <td class="p-3 text-right">{{ number_format($totalAssets,2) }}</td>
                                <td></td>
                                </tr>

                            </tbody>
                            </table>
                        </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
       
</div>


@endsection
