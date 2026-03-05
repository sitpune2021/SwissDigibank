<body onload="window.print()">

    <div style="float:left; text-align:left;">
        <img src="{{ $logoUrl }}" alt="Company Logo" style="width:auto; height:50px;">
    </div>

    <div style="clear:both; "></div>

    <h2 style="text-align:center">Income Statement</h2>
             
        <style>
        body{
        font-family: Arial, sans-serif;
        font-size:14px;
        }

        .report-table{
        width:100%;
        border-collapse:collapse;
        margin-top:10px;
        }

        .report-table th,
        .report-table td{
        border:1px solid #ccc;
        padding:8px 10px;
        }

        .report-table th{
        background:#f5f5f5;
        text-align:left;
        }

        .amount{
        text-align:right;
        }

        .total-row{
        font-weight:bold;
        background:#fafafa;
        }

        .section-title{
        margin-top:20px;
        font-size:16px;
        font-weight:bold;
        }

        .net-profit{
        margin-top:20px;
        font-size:18px;
        font-weight:bold;
        }
        </style>

        <div class="section-title">Revenues</div>

            <table class="report-table">

            <thead>
            <tr>
            <th>Revenue Name</th>
            <th class="amount">Amount</th>
            </tr>
            </thead>

            <tbody>

            @foreach($revenues as $rev)
            <tr>
            <td>{{ $rev['name'] }}</td>
            <td class="amount">{{ number_format($rev['amount'],2) }}</td>
            </tr>
            @endforeach

            <tr class="total-row">
            <td>Total Revenue</td>
            <td class="amount">{{ number_format($totalRevenue,2) }}</td>
            </tr>

            </tbody>
            </table>

        <div class="section-title">Expenses</div>

            <table class="report-table">

            <thead>
            <tr>
            <th>Expense Name</th>
            <th class="amount">Amount</th>
            </tr>
            </thead>

            <tbody>

            @foreach($expenses as $exp)
            <tr>
            <td>{{ $exp['name'] }}</td>
            <td class="amount">{{ number_format($exp['amount'],2) }}</td>
            </tr>
            @endforeach

            <tr class="total-row">
            <td>Total Expense</td>
            <td class="amount">{{ number_format($totalExpense,2) }}</td>
            </tr>

            </tbody>
            </table>

        <div class="net-profit">
            {{ $netProfit >=0 ? 'Net Profit :' : 'Net Loss :' }}

        <span style="float:right;">
            {{ number_format($netProfit,2) }}
        </span>
    
</body>