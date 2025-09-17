@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Transactions for Member: {{ $member->name }}</h1>

        <!-- Success message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Transaction Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Transaction Date</th>
                    <th>Payment Mode</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    <th>Is Accounted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                        <td>{{ $transaction->payment_mode }}</td>
                        <td>{{ $transaction->type }}</td>
                        <td>{{ $transaction->amount }}</td>
                        <td>{{ $transaction->remarks ?? 'N/A' }}</td>
                        <td>{{ $transaction->status }}</td>
                        <td>{{ $transaction->is_accounted ? 'Yes' : 'No' }}</td>
                        <td>
                            <!-- Add edit or delete actions as needed -->
                            <!-- For now we just display a placeholder -->
                            <button class="btn btn-warning">Edit</button>
                            <button class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>