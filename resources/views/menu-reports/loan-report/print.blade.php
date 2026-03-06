<body onload="window.print()">

<style>

body{
font-family:Arial;
font-size:12px;
}

table{
width:100%;
border-collapse:collapse;
}

th,td{
border:1px solid #ccc;
padding:6px;
text-align:left;
}

th{
background:#f5f5f5;
font-size:12px;
}

.amount{
text-align:right;
}

</style>

    <div style="float:left; text-align:left;">
        <img src="{{ $logoUrl }}" alt="Company Logo" style="width:auto; height:50px;">
    </div>

    <div style="clear:both; "></div>

<h2 style="text-align:center">Loan Report</h2>

<table>

<thead>

<tr>

<th>Member Name</th>
<th>Member No</th>
<th>Account No</th>
<th>Loan Amount</th>
<th>Total Received</th>
<th>Daily Collection</th>
<th>Tenure</th>
<th>DOJ</th>
<th>DOM</th>
<th>Agent</th>
<th>Contact</th>
<th>Processing Fee</th>
<th>Disburse Date</th>
<th>Mode</th>
<th>Scheme</th>

</tr>

</thead>


<tbody>

@foreach($loans as $loan)

<tr>

<td>
{{ ($loan->member->member_info_first_name ?? '-') .' '.($loan->member->member_info_last_name ?? '-') }}
</td>

<td>{{ $loan->member->member_no ?? '-' }}</td>

<td>{{ $loan->application_no ?? str_pad($loan->id,10,'0',STR_PAD_LEFT) }}</td>

<td>{{ $loan->loan_amount ?? '-' }}</td>

<td>{{ $loan->emiPayments->sum('amount') }}</td>

<td>{{ $loan->emi_amount ?? '-' }}</td>

<td>{{ $loan->tenure_value ?? '-' }}</td>

<td>{{ $loan->member->date_of_joining ?? '-' }}</td>

<td>{{ $loan->member->date_of_maturity ?? '-' }}</td>

<td>{{ $loan->advisor_id ?? '-' }}</td>

<td>{{ $loan->member->member_info_mobile_no ?? '-' }}</td>

<td>{{ $loan->processing_fee_total ?? '-' }}</td>

<td>
@php $date = $loan->disbursement?->disbursal_date; @endphp
{{ $date ? \Carbon\Carbon::parse($date)->format('d-m-Y') : '-' }}
</td>

<td>{{ $loan->transfer_mode ?? '-' }}</td>

<td>{{ $loan->scheme->scheme_name ?? '-' }}</td>

</tr>

@endforeach

</tbody>

</table>

</body>