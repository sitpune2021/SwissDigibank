@extends('layout.main')

@section('content')

<div class="container">

<h3 class="mb-3">Trial Balance</h3>

<form method="GET" class="row mb-3">

    <div class="col-md-2">
        <input type="date" name="from" value="{{ $from }}" class="form-control">
    </div>

    <div class="col-md-2">
        <input type="date" name="to" value="{{ $to }}" class="form-control">
    </div>

    <div class="col-md-2">
        <select name="type" class="form-control">
            <option value="ALL">ALL</option>
            <option value="Asset">ASSETS</option>
            <option value="Liability">LIABILITIES</option>
            <option value="Equity">EQUITY</option>
            <option value="Expense">EXPENSES</option>
            <option value="Revenue">REVENUE</option>
        </select>
    </div>

    <div class="col-md-3">
        <input type="text" name="search"
               value="{{ $search }}"
               placeholder="Search..."
               class="form-control">
    </div>

    <div class="col-md-2">
        <button class="btn btn-dark w-100">Filter</button>
    </div>

</form>

<div class="table-responsive">
<table class="table table-bordered table-striped">

<thead class="table-dark text-center">
<tr>
<th>Code</th>
<th>Name</th>
<th>System Name</th>
<th>Group</th>
<th>Type</th>
<th>Opening</th>
<th>Debit</th>
<th>Credit</th>
<th>Balance</th>
</tr>
</thead>

<tbody>

@foreach($data as $row)

<tr>
<td>{{ $row['code'] }}</td>
<td>{{ $row['name'] }}</td>
<td>{{ $row['system_name'] }}</td>
<td>{{ $row['group'] }}</td>
<td>{{ $row['type'] }}</td>
<td class="text-end">{{ number_format($row['opening'],2) }}</td>
<td class="text-end">{{ number_format($row['debit'],2) }}</td>
<td class="text-end">{{ number_format($row['credit'],2) }}</td>
<td class="text-end">{{ number_format($row['balance'],2) }}</td>
</tr>

@endforeach

<tr class="fw-bold table-secondary">
<td colspan="6">GRAND TOTAL</td>
<td class="text-end">{{ number_format($totalDebit,2) }}</td>
<td class="text-end">{{ number_format($totalCredit,2) }}</td>
<td></td>
</tr>

</tbody>
</table>
</div>

</div>

@endsection
