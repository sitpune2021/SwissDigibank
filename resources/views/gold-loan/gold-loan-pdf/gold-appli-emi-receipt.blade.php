<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
        }

        .sub-text {
            font-size: 12px;
        }

        .title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 4px 0;
        }

        .line {
            border-top: 1px solid #000;
            margin: 10px 0;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
        }
    </style>
</head>

<body>

<div class="header">
    <img src="{{ public_path('assets/images/SBC_Logo_gpg.jpg') }}" height="60">

    <div class="company-name">
        SHRI SAMARTH NAGRI SAHAKARI PAT SANSTHA LIMITED
    </div>

    <div class="sub-text">
        SHEGAON Maharashtra - 110012
    </div>

    <div class="title">EMI RECEIPT</div>
</div>

<div class="line"></div>

<table>
    <tr>
        <td>Printed On : {{ now()->format('d-M-Y h:i:s A') }}</td>
        <td style="text-align:right;">
            Branch : {{ $loan->branch->name ?? 'HEAD OFFICE' }}
        </td>
    </tr>
</table>

<div class="line"></div>

<table>
    <tr>
        <td><strong>EMI No :</strong> {{ $transaction->emi_no }}</td>
        <td style="text-align:right;">
            <strong>EMI Date :</strong>
            {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y') }}
        </td>
    </tr>
</table>

<br>

<table>
    <tr>
        <td width="30%">Member</td>
        <td>: {{ $loan->member->member_no ?? '' }} - {{ $loan->member->name ?? '' }}</td>
    </tr>

    <tr>
        <td>Account No</td>
        <td>: {{ $loan->account_no ?? 'GL000'.$loan->id }}</td>
    </tr>

    <tr>
        <td>Principal Amount</td>
        <td>: ₹ {{ number_format($transaction->principal ?? 0,2) }}</td>
    </tr>

    <tr>
        <td>Interest Amount</td>
        <td>: ₹ {{ number_format($transaction->interest ?? 0,2) }}</td>
    </tr>

    <tr>
        <td>EMI Amount</td>
        <td>: ₹ {{ number_format($transaction->amount_collected,2) }}</td>
    </tr>

    <tr>
        <td>Balance Principal Amount</td>
        <td>: ₹ {{ number_format($transaction->current_debt ?? 0,2) }}</td>
    </tr>

    <tr>
        <td>Status</td>
        <td>: <strong>PAID</strong></td>
    </tr>
</table>

<br><br>

<table>
    <tr>
        <td style="text-align:center;">(Approved by)</td>
        <td style="text-align:center;">(Verified by)</td>
        <td style="text-align:center;">(Posted by)</td>
    </tr>
</table>

<div class="line"></div>

<div class="footer">
    Thank you for your business!
</div>

</body>
</html>
