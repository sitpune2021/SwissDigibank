<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Payment Receipt</title>
</head>

<body style="font-family:'Courier New', Courier, monospace; font-size:13px; color:#222; margin:0; line-height:1.25;">
    <div style="max-width:80mm; margin:0 auto; padding:8px 6px;">

        <div style="text-align:center; font-weight:800;">
            <h2 style="margin:0; font-size:16px; font-weight:800;">SBC GLOBAL</h2>
            <p style="margin:2px 0 8px; font-size:8px;">969/03-04</p>
        </div>

        <hr style="border-top:1px dashed #999; margin:6px 0;">

        <div style="font-weight:900; font-size:16px; margin-bottom:8px; text-align:center;">
            Payment Receipt
        </div>

        <table style="width:100%; border-collapse:collapse; font-size:12px;">
            <tr>
                <td style="padding:4px 2px; vertical-align:top; font-weight:bold; width:40%;">Reg No :</td>
                <td style="padding:4px 2px; vertical-align:top;">{{ $transaction->member->member_no }}</td>
            </tr>
            <tr>
                <td style="padding:4px 2px; vertical-align:top; font-weight:bold; width:40%;">Name :</td>
                <td style="padding:4px 2px; vertical-align:top;">{{ $transaction->member->member_info_first_name }}
                    {{ $transaction->member->member_info_middle_name ?? '' }}
                    {{ $transaction->member->member_info_last_name }}</td>
            </tr>
            <tr>
                <td style="padding:4px 2px; vertical-align:top; font-weight:bold; width:40%;">A/c No </td>
                <td style="padding:4px 2px; vertical-align:top;"> DDA{{ $transaction->id }}</td>
            </tr>
            <tr>
                <td style="padding:4px 2px; vertical-align:top; font-weight:bold; width:40%;">Phone :</td>
                <td style="padding:4px 2px; vertical-align:top;">{{ $transaction->member->member_info_mobile_no }}</td>
            </tr>

            <tr>
                <td colspan="2" style="padding:4px 2px;">
                    <hr style="border-top:1px dashed #999; margin:6px 0;">
                </td>
            </tr>
            @foreach ($transaction->transactions as $trans)
                <table style="width:100%; border-collapse:collapse; font-size:12px;">
                    <tr>
                        <td style="padding:4px 2px; vertical-align:top; font-weight:bold; width:40%;">Date:</td>
                        <td style="padding:4px 2px; vertical-align:top;">
                            {{ \Carbon\Carbon::parse($trans->transaction_date)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td style="padding:4px 2px; vertical-align:top; font-weight:bold;">Ref Id:</td>
                        <td style="padding:4px 2px; vertical-align:top;">{{ $trans->transactionId ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="padding:4px 2px; vertical-align:top; font-weight:bold;">Amount:</td>
                        <td style="padding:4px 2px; vertical-align:top;">
                            {{ number_format($trans->amount, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:4px 2px; vertical-align:top; font-weight:bold;">Mode:</td>
                        <td style="padding:4px 2px; vertical-align:top;">{{ $trans->pay_mode }}</td>
                    </tr>
                    <tr>
                        <td style="padding:4px 2px; vertical-align:top; font-weight:bold;">Status:</td>
                        <td style="padding:4px 2px; vertical-align:top;">
                            {{ $trans->status ?? 'Approved' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:4px 2px; vertical-align:top; font-weight:bold;">Av Bal.:</td>
                        <td style="padding:4px 2px; vertical-align:top;">
                            {{ number_format($trans->balance_available, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:4px 2px; vertical-align:top; font-weight:bold;">Remarks:</td>
                        <td style="padding:4px 2px; vertical-align:top;">{{ $trans->remarks ?? 'N/A' }}</td>
                    </tr>
                </table>
            @endforeach

        </table>

        <hr style="border-top:1px dashed #999; margin:6px 0;">
        <div style="margin-top:12px; font-size:11px; color:#444; font-weight:800;">
            Printed on: {{ $printedOn }}<br>
            By: {{ $printedBy }}
        </div>

        <div style="margin-top:8px; color:#444; font-weight:800; text-align:center;">
            Thank you for your business!
        </div>
    </div>
</body>

</html>
