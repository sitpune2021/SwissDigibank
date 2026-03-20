<body onload="window.print()">

<style>
body{
    font-family: Arial, sans-serif;
    font-size: 13px;
    margin: 20px;
    color: #333;
}

.title{
    text-align:center;
    margin-bottom:20px;
}

.columns{
    display:flex;
    gap:20px;
}

.column{
    width:50%;
    border:1px solid #ddd;
    padding:10px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th, td{
    padding:8px;
    border-bottom:1px solid #eee;
}

th{
    background:#f2f2f2;
}

.text-right{
    text-align:right;
}

.section{
    background:#e6f0ff;
    font-weight:bold;
}

.total{
    font-weight:bold;
    border-top:2px solid #000;
    background:#f9f9f9;
}

@media print {
    body{
        margin:10px;
    }
}
</style>

<div class="title">
    <h2>Balance Sheet</h2>
    <div>
        01/04/{{ date('Y') }} to {{ $today->format('d/m/Y') }}
    </div>
</div>

<div class="columns">

    <!-- LEFT -->
    <div class="column">

        <table>
            <thead>
                <tr>
                    <th class="text-right">PREVIOUS</th>
                    <th>PARTICULARS</th>
                    <th class="text-right">CURRENT</th>
                </tr>
            </thead>

            <tbody>

                <!-- EQUITY -->
                <tr class="section">
                    <td colspan="3">EQUITY</td>
                </tr>

                @foreach($equities as $equity)
                <tr>
                    <td class="text-right">{{ number_format($equity['previous'],2) }}</td>
                    <td>{{ strtoupper($equity['name']) }}</td>
                    <td class="text-right">{{ number_format($equity['current'],2) }}</td>
                </tr>
                @endforeach

                <tr class="total">
                    <td>TOTAL EQUITY</td>
                    <td></td>
                    <td class="text-right">{{ number_format($totalEquity,2) }}</td>
                </tr>

                <!-- LIABILITIES -->
                <tr class="section">
                    <td colspan="3">LIABILITIES</td>
                </tr>

                @foreach($liabilities as $liability)
                <tr>
                    <td class="text-right">{{ number_format($liability['previous'],2) }}</td>
                    <td>{{ strtoupper($liability['name']) }}</td>
                    <td class="text-right">{{ number_format($liability['current'],2) }}</td>
                </tr>
                @endforeach

                <tr class="total">
                    <td>TOTAL LIABILITIES</td>
                     <td></td>
                    <td class="text-right">{{ number_format($totalLiabilities,2) }}</td>
                </tr>

            </tbody>
        </table>

    </div>

    <!-- RIGHT -->
    <div class="column">

        <table>
            <thead>
                <tr>
                    <th class="text-right">PREVIOUS</th>
                    <th>PARTICULARS</th>
                    <th class="text-right">CURRENT</th>
                </tr>
            </thead>

            <tbody>

                <tr class="section">
                    <td colspan="3">ASSETS</td>
                </tr>

                @foreach($assets as $asset)
                <tr>
                    <td class="text-right">{{ number_format($asset['previous'],2) }}</td>
                    <td>{{ strtoupper($asset['name']) }}</td>
                    <td class="text-right">{{ number_format($asset['current'],2) }}</td>
                </tr>
                @endforeach

                <tr class="total">                  
                    <td>TOTAL ASSETS</td>
                    <td></td>
                    <td class="text-right">{{ number_format($totalAssets,2) }}</td>
                </tr>

            </tbody>
        </table>

    </div>

</div>

</body>