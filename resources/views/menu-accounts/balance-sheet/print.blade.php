<body onload="window.print()">

<style>

body{
font-family:Arial, sans-serif;
font-size:13px;
margin:20px;
color:#333;
}

.header{
display:flex;
align-items:center;
justify-content:space-between;
margin-bottom:20px;
}

.logo img{
height:50px;
}

.title{
text-align:center;
flex:1;
}

.title h2{
margin:0;
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

.section-title{
font-weight:bold;
background:#f2f2f2;
padding:6px;
margin-top:10px;
}

table{
width:100%;
border-collapse:collapse;
margin-top:5px;
}

table td{
padding:6px;
border-bottom:1px solid #eee;
}

.amount{
text-align:right;
}

.total{
font-weight:bold;
border-top:2px solid #000;
}

</style>

<div class="header">

    <!-- <div class="logo">
        <img src="{{ $logoUrl }}">
    </div> -->

    <div class="title">
        <h2>Balance Sheet</h2>
    <div>
        01/04/{{ date('Y') }} to {{ $today->format('d/m/Y') }}
</div><br>

<div style="width:50px"></div>

<div class="columns">

    <!-- LEFT COLUMN -->
    <div class="column">

    <div class="section-title">EQUITY</div>

    <table>

    @foreach($equities as $equity)

    <tr>
    <td>{{ strtoupper($equity['name']) }}</td>
    <td class="amount">{{ number_format($equity['amount'],2) }}/td>
    </tr>

    @endforeach

    <tr class="total">
    <td>Total Equity</td>
    <td class="amount">{{ number_format($totalEquity,2) }}</td>
    </tr>

    </table>


    <div class="section-title">LIABILITIES</div>

    <table>

    @foreach($liabilities as $liability)

    <tr>
    <td>{{ strtoupper($liability['name']) }}</td>
    <td class="amount">{{ number_format($liability['amount'],2) }}</td>
    </tr>

    @endforeach

    <tr class="total">
    <td>Total Liabilities</td>
    <td class="amount">{{ number_format($totalLiabilities,2) }}</td>
    </tr>

    </table>

    </div>


    <!-- RIGHT COLUMN -->
    <div class="column">

    <div class="section-title">ASSETS</div>

    <table>

    @foreach($assets as $asset)

    <tr>
    <td>{{ strtoupper($asset['name']) }}</td>
    <td class="amount">{{ number_format($asset['amount'],2) }}</td>
    </tr>

    @endforeach

    <tr class="total">
    <td>Total Assets</td>
    <td class="amount">{{ number_format($totalAssets,2) }}</td>
    </tr>

    </table>

    </div>

</div>

</body>