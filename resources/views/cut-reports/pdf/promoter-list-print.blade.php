<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <title>promoter List Cut Report</title>
    <style>
        body {
            font-family: dejavusans;
            font-size: 12px;
        }

        .container {
            width: 100%;
        }

        .header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .sub-header {
            text-align: center;
            font-size: 14px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
        }

        th {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">

        <!-- Society Header -->
        <div class="header">
            {{ $company['name'] ?? '' }}
            {{ isset($company['address_line1']) ? ', ' . $company['address_line1'] : '' }}
            {{ isset($company['address_line2']) ? ', ' . $company['address_line2'] : '' }}
            {{ isset($company['city']) ? ', ' . $company['city'] : '' }}
            {{ isset($company['cin_no']) ? ', र. नं. ' . $company['cin_no'] : '' }}
        </div>

        <div class="sub-header">
            संचालक यादी - {{ date('d-m-Y') }}
        </div>
        <hr>
        <!-- Data Table -->
        <table>
            <tr>
                <th style="color: #c60707; font-size: 14px;">अनु.क्र.</th>
                <th style="color: #c60707; font-size: 14px;">संचालक क्रमांक</th>
                <th style="color: #c60707; font-size: 14px;">पद</th>
                <th style="color: #c60707; font-size: 14px;">संचालकांचे नाव</th>
                <th style="color: #c60707; font-size: 14px;">ले.पा.नं. </th>
                <th style="color: #c60707; font-size: 14px;">शिल्लक</th>
            </tr>

            @php
            $totalShare = 0;
            $totalBalance = 0;
            @endphp

            @foreach($promoters as $key => $member)

            @php

            $promotor = $member->promotor->first(); // get first promoter record

            $shareAmount = $promotor
            ? $promotor->shareHoldings->sum('amount')
            : 0;
            @endphp
            <tr>
                <td>{{ $key + 1 }}</td>

                 <td>
                    {{ $member->member_no ?? '-' }}
                </td>

                <td>
                    {{ $member->promotor?->occupation ?? '-' }}
                </td>

                <td>
                
                    {{ $member->promotor?->first_name }} 
                    {{ $member->promotor?->middle_name }} 
                    {{ $member->promotor?->last_name }}
                </td>

                <td>
                    -
                </td>

                <td style="text-align:right;">
                    {{ number_format($shareAmount, 2) }} जमा
                </td>
            </tr>

            @endforeach

        </table>

    </div>
</body>

</html>