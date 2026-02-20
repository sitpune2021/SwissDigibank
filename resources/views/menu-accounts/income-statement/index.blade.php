@extends('layout.main')

@section('content')

<div class="container">

    <h3 class="mb-4 text-center">INCOME STATEMENT</h3>

    {{-- Branch Filter --}}
    <form class="mb-4 text-center">
        <select name="branch_id" class="form-control w-25 d-inline">
            <option value="">ALL BRANCH</option>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}"
                    {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                    {{ $branch->branch_name }}
                </option>
            @endforeach
        </select>

        <button class="btn btn-primary">GET</button>
    </form>

    <div class="card shadow">
        <div class="card-body">

            {{-- REVENUES --}}
            <h5 class="text-success">Revenues</h5>

            @foreach($revenues as $rev)
                <div class="d-flex justify-content-between border-bottom py-1">
                    <span>{{ $rev['name'] }}</span>
                    <span>{{ number_format($rev['amount'],2) }}</span>
                </div>
            @endforeach

            <div class="d-flex justify-content-between fw-bold mt-2">
                <span>TOTAL REVENUES</span>
                <span>{{ number_format($totalRevenue,2) }}</span>
            </div>

            <hr>

            {{-- EXPENSES --}}
            <h5 class="text-danger mt-4">Expenses</h5>

            @foreach($expenses as $exp)
                <div class="d-flex justify-content-between border-bottom py-1">
                    <span>{{ $exp['name'] }}</span>
                    <span>{{ number_format($exp['amount'],2) }}</span>
                </div>
            @endforeach

            <div class="d-flex justify-content-between fw-bold mt-2">
                <span>TOTAL EXPENSES</span>
                <span>{{ number_format($totalExpense,2) }}</span>
            </div>

            <hr>

            {{-- NET PROFIT / LOSS --}}
            <div class="d-flex justify-content-between fw-bold fs-5 mt-3">
                <span>
                    {{ $netProfit >= 0 ? 'NET PROFIT' : 'NET LOSS' }}
                </span>
                <span class="{{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ number_format($netProfit,2) }}
                </span>
            </div>

        </div>
    </div>

</div>

@endsection
