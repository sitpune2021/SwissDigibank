<!DOCTYPE html>
<html>
<head>
    <title>Passbook Print</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background: #f5f5f5; }
    </style>
</head>
<body onload="window.print()">
    <h2>Passbook Statement</h2>
    <p>From: {{ $fromDate }} To: {{ $toDate }}</p>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Cheque No</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $txn)
                <tr>
                    <td>{{ $txn['date'] }}</td>
                    <td>{{ $txn['description'] }}</td>
                    <td>{{ $txn['cheque_no'] }}</td>
                    <td>{{ $txn['debit_amount'] ?? '-' }}</td>
                    <td>{{ $txn['credit_amount'] ?? '-' }}</td>
                    <td>{{ $txn['balance'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
