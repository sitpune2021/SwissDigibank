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
     <style>
.header{
    text-align:center;
    font-size:22px;
    font-weight:600; /* semi bold */
    line-height:1.5;
}

.sub-header{
    text-align:center;
    font-size:18px;
    font-weight:600; /* semi bold */
    margin-top:5px;
}
</style>
</head>

<body>
<div class="container">

    <!-- Society Header -->
    <div class="header">
        <div class="title" style="font-size:20px;"><b>{{ $company['name'] ?? '' }}</b></div>
        <div class="title" style="font-size:20px;"><b>केशव नगर चौक अकोला</b></div>
        <div class="title" style="font-size:20px;"><b> र. नं. १५३ </b></div>
    </div>

    <div class="sub-header" style="font-size:20px;">
       <b>सभासद यादी - {{ date('Y') }}</b>
    </div>
    <hr>

        <!-- Data Table -->
        <table>
            <tr>
                <th style="color: #c60707; font-size: 14px;">अनु.क्र.</th>
                <th style="color: #c60707; font-size: 14px;">सभासद क्रमांक</th>
                <th style="color: #c60707; font-size: 14px;">सभासदाचे नाव</th>
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
            $totalBalance += $shareAmount;
            @endphp

            <tr>
                <td>{{ $key + 1 }}</td>

                <td>
                    {{ $member->member_no ?? '-'}}
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

            <tr style="font-weight:bold; border:none;">
                <td colspan="2" style="border:none;">
                    Total Records : {{ count($members) }}
                </td>

                <td colspan="2" class="text-right" style="border:none;">
                    Total Balance
                </td>

                <td class="text-right" style="border:none;">
                    {{ number_format($totalBalance, 2) }}
                </td>
            </tr>

            <tr style="border:none;">
                <td colspan="2" style="border:none;">
                    Credit Balance : {{ number_format($totalBalance, 2) }}
                </td>

                <td colspan="2" class="text-center" style="border:none;">
                    Debit Balance : {{ number_format(0, 2) }}
                </td>

                <td class="text-right" style="border:none;">
                    GL Total : {{ number_format(0, 2) }}
                </td>
            </tr>
            
        </table>

    </div>
</body>

</html>