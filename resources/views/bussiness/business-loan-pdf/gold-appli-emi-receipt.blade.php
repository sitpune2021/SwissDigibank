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
            margin-top: 10px;
            text-align: center;
            font-size: 11px;
        }
    </style>
    {{-- <script>
window.onload = function() {
    window.print();
};
</script> --}}
</head>

<body>

    <div style="width:100%; font-family: dejavusans;  padding: 5px;">

        <!-- Logo -->
        <div style="float:left; text-align:left;">
            <img src="{{ public_path('assets/images/SBC_Logo_gpg.jpg') }}" style="width:auto; height:50px;">
        </div>

        <!-- Title Section -->
        <div style="float: right; width:80%; text-align:center;">
            <div style="  font-size:30px; font-weight: 800;  text-transform:uppercase; ">
                {{-- {{ $bank_name }} --}}
            </div>
            <div style="  font-size:12px; font-weight: 800;  text-transform:uppercase; ">
                {{-- {{ $address }} --}}
            </div>

            <div style="height:10px; margin-top: 40px;">&nbsp;</div>


        </div>

        <!-- Clear Float -->
        <div style="clear:both; "></div>
        <div style=" text-align: center; font-size: 18px;">EMI RECEIPT</div>

    </div>
    {{-- <div class="header">
    <img src="{{ public_path('assets/images/SBC_Logo_gpg.jpg') }}" height="60">
 
    <div class="company-name">
        SHRI SAMARTH NAGRI SAHAKARI PAT SANSTHA LIMITED
    </div>
 
    <div class="sub-text">
        SHEGAON Maharashtra - 110012
    </div>
 
    <div class="title">EMI RECEIPT</div>
</div> --}}

    <div class="line"></div>

    <table>
        <tr>
            <td>Printed On : {{ now()->format('d-m-Y') }}</td>
            <td style="text-align:right;">
                Branch : {{ $loan->branch->name ?? 'HEAD OFFICE' }}
            </td>
        </tr>
    </table>

    <div class="line"></div>

    @php
        $transaction = $transactions->first();
    @endphp

    <table>
        <tr>
            <td><strong>EMI No : {{ $emiNo }}</strong></td>
            <td style="text-align:right;">
                EMI Date :
                {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y') }}
            </td>
        </tr>
    </table>



    <table>
        <tr>
            <td width="30%">Member</td>
            <td>: {{ $loan->member->member_no ?? '' }}
                -
                {{ $loan->member->member_info_first_name . ' ' . $loan->member->member_info_last_name }}</td>
        </tr>

        <tr>
            <td>Account No</td>
            <td>: {{ str_pad($loan->account_no ?? $loan->id, 6, '0', STR_PAD_LEFT) }}
            </td>
        </tr>

        <tr>
            <td>Principal Amount</td>
            <td>: ₹ {{ number_format($emiData['principal'] ?? 0, 2) }}</td>
        </tr>

        <tr>
            <td>Interest Amount</td>
            <td>: ₹ {{ number_format($emiData['interest'] ?? 0, 2) }}</td>
        </tr>

        <tr>
            <td>EMI Amount</td>
            <td>: ₹ {{ number_format($totalPaid, 2) }}</td>
        </tr>

        <tr>
            <td>Balance Principal Amount</td>
            <td>: ₹ {{ number_format($emiData['balance_principal'] ?? 0, 2) }}</td>
        </tr>

        <tr>
            <td>Status</td>
            <td>: PAID</td>
        </tr>
    </table>

    <br><br>

    <table>
        <tr>
            <td style="text-align:left;">(Approved by)</td>
            <td style="text-align:center;">(Verified by)</td>
            <td style="text-align:right;">(Posted by)</td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="footer">
        Thank you for your business!
    </div>


</body>

</html>
