<body onload="window.print()">

<style>

body{
font-family:Arial;
font-size:14px;
}

.table{
width:100%;
border-collapse:collapse;
}

.table th,
.table td{
border:1px solid #ccc;
padding:8px;
}

.table th{
background:#f5f5f5;
}

.amount{
text-align:right;
}

.total{
font-weight:bold;
background:#fafafa;
}

</style>

    <div style="float:left; text-align:left;">
        <img src="{{ $logoUrl }}" alt="Company Logo" style="width:auto; height:50px;">
    </div>

    <div style="clear:both; "></div>

<h2 style="text-align:center">Balance Sheet</h2>

<p style="text-align:center">
Date : {{ $today->format('d-m-Y') }}
</p>

<table class="table">

<tr>

<th width="50%">Assets</th>
<th width="50%">Liabilities & Equity</th>

</tr>

@php
$maxRows = max(
count($assets),
count($liabilities) + count($equities) + 1
);
@endphp

@for($i=0;$i<$maxRows;$i++)

<tr>

<td>

@if(isset($assets[$i]))

<span>{{ $assets[$i]['name'] }}</span>

<span style="float:right">
{{ number_format($assets[$i]['amount'],2) }}
</span>

@endif

</td>

<td>

@if(isset($liabilities[$i]))

<span>{{ $liabilities[$i]['name'] }}</span>

<span style="float:right">
{{ number_format($liabilities[$i]['amount'],2) }}
</span>

@endif


@if(isset($equities[$i - count($liabilities)]))

<br>

<span>
{{ $equities[$i - count($liabilities)]['name'] }}
</span>

<span style="float:right">
{{ number_format($equities[$i - count($liabilities)]['amount'],2) }}
</span>

@endif


@if($i == count($liabilities) + count($equities))

<br>

<b>Current Year Profit</b>

<span style="float:right">
{{ number_format($netProfit,2) }}
</span>

@endif

</td>

</tr>

@endfor

<tr class="total">

<td>

Total Assets

<span style="float:right">
{{ number_format($totalAssets,2) }}
</span>

</td>

<td>

Total Liabilities & Equity

<span style="float:right">
{{ number_format($totalLiabilities + $totalEquity,2) }}
</span>

</td>

</tr>

</table>

</body>