<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction Print</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .print-container {
            width: 80%;
            margin: auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="print-container">
        <div class="header">
            <h2>Transaction Details</h2>
        </div>

        <p><strong>ID:</strong> {{ $transaction->id }}</p>
        <p><strong>Date:</strong> {{ $transaction->created_at->format('D M d Y') }}</p>
        <p><strong>Amount:</strong> ₹{{ $transaction->amount }}</p>
        <p><strong>Status:</strong> {{ ucfirst($transaction->status) }}</p>

        <!-- Add more transaction fields as needed -->

        <button class="no-print" onclick="window.print()">Print this page</button>
    </div>
</body>
</html>
