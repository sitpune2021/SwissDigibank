<html>
<head>
<title>Payment Collection</title>

<style>

table{
width:100%;
border-collapse:collapse;
}

th,td{
border:1px solid #000;
padding:6px;
}

</style>

</head>

<body onload="window.print()">

<h2>Payment Collection Report</h2>

<table>

<tr>
<th>Branch</th>
<th>Member</th>
<th>Loan Type</th>
<th>Loan ID</th>
<th>Due Date</th>
<th>Amount</th>
</tr>

@foreach($applications as $app)

<tr>
<td>{{ $app->branch_name }}</td>
<td>{{ $app->member_no }}</td>
<td>{{ $app->loan_type }}</td>
<td>{{ $app->loan_id }}</td>
<td>{{ $app->due_date }}</td>
<td>{{ $app->remaining_amount }}</td>
</tr>

@endforeach

</table>

</body>
</html>