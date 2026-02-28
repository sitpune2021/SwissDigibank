<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Customer List Cut Report</title>
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
            font-size:14px;
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

        th, td {
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
       वसूल भाग भांडवल शिल्लक अहवाल - {{ date('d-m-Y') }}
    </div>
    <hr>
        <!-- Data Table -->
        <table>
            <tr>
                <th style="color: #c60707; font-size: 14px;">अनु.क्र.</th>
                <th style="color: #c60707; font-size: 14px;">खाते क्र.</th>
                <th style="color: #c60707; font-size: 14px;">खातेदाराचे नाव</th>
                <th style="color: #c60707; font-size: 14px;">ले.पा.नं. </th>
                <th style="color: #c60707; font-size: 14px;">शिल्लक</th>
            </tr>

            @php
            $totalShare = 0;
            $totalBalance = 0;
            @endphp

            @foreach($members as $key => $member)

            @php
            $shareAmount = optional($member->shareTransfers)->sum('total_consideration') ?? 0;
            $totalShare += $shareAmount;
            @endphp

            <tr>
                <td>{{ $key + 1 }}</td>

                <td>
                    {{ optional($member->accounts->first())->account_no ?? '-' }}
                </td>

                <td>
                    {{ $member->full_name ?? '-' }}
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