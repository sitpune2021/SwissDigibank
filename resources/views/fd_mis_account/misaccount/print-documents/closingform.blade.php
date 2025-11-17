<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FD Closing Form - SHRI SAMARTH NAGRI</title>
    <style>
        @page {
            size: A4;
            margin: 10mm 15mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .address {
            text-align: center;
            font-size: 11px;
            line-height: 1.3;
            margin-bottom: 15px;
        }

        .subtitle {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 15px;
            text-decoration: underline;
        }

        /* .section { margin-bottom: 12px; } */

        p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            font-size: 12px;
        }

        td {
            padding: 4px 0;
            vertical-align: top;
        }

        .signatures td {
            text-align: center;
            padding-top: 25px;
        }

        .instructions {
            margin-top: 25px;
            font-size: 11px;
            border-top: 1px solid #000;
            padding-top: 10px;
        }

        .instruction-title {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 5px;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="title">
            <table style="width:100%; border-collapse:collapse; border-bottom: 1px solid #000;">
                <tr>
                    <td style=" text-align:left;">
                        <img src="{{ public_path('assets/images/sbc-image.jpg') }}" alt="Logo"
                            style="width:90px; height:90px;">
                    </td>
                    <td style="text-align:center; vertical-align:start; ">
                        <div class="" style="font-size: 18px;"> SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA LIMITED</div>
                        <div class="" style="margin-top: 30px; text-transform: capitalize; font-size: 16px;">Issue Of
                            Discharge Form for End of Term / Pre-Maturity</div>
                    </td>
                </tr>
            </table>
        </div>



        <div class="section">
            <table style="width:100%; border-collapse:collapse; border-spacing:0; font-size:12px; line-height:0.8;">
                <tr>
                    <td style="width:70%; padding:2px 0;">Mr. {{ $name }}</td>
                    <td style="padding:2px 0;">Date : {{ $date }}</td>
                </tr>
                <tr>
                    <td style="padding:2px 0;">S/O: Mr.</td>
                </tr>
                <tr>
                    <td style="padding:2px 0;">Address:Maharashtra</td>
                    <td style="padding:2px 0;">Branch Name : {{ $branch_name }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding:2px 0;">
                        TO.<br>
                        BRANCH INCHARGE : {{ $branch_name }}<br>
                        {{ $branch_address }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="section">
            <p>Entered By:</p>
            <p>Agreement No: <strong>{{ $agreement_no }}</strong> &nbsp;&nbsp;&nbsp; Holder Name:
                <strong>{{ $holder_name }}</strong> &nbsp;&nbsp;&nbsp; Exp. Date: <strong>{{ $expiry_date }}</strong>
            </p>
            <p> The joint venture/ assignee of the above mentioned case down payment certificate do hereby acknowledge
                receipt from the of sum specified below in full and final satisfaction and discharge/loan of all my
                claims and
                demands under above certificate as per particulars given below :-</p>
        </div>

        <table style="width:100%; border-collapse:collapse; border-spacing:0; font-size:12px; line-height:0.5;">
            <tr>
                <td>TOTAL RECEIVED AMOUNT</td>
                <td>
                    <div style="float:right;">______________</div>
                </td>
            </tr>
            <tr>
                <td>ADD : INTEREST/OTHER BENEFIT (IF ANY)</td>
                <td>
                    <div style="float:right;">______________</div>
                </td>
            </tr>
            <tr>
                <td>MATURITY/DEATH CLAIM AMOUNT PAYABLE</td>
                <td>
                    <div style="float:right;">______________</div>
                </td>
            </tr>
            <tr>
                <td>LESS : LATE FEE/PENAL BALANCE AMOUNT</td>
                <td>
                    <div style="float:right;">______________</div>
                </td>
            </tr>
            <tr>
                <td>LESS : OUTSTANDING LOAN AMOUNT</td>
                <td>
                    <div style="float:right;">______________</div>
                </td>
            </tr>
            <tr>
                <td>LESS : INTEREST ON OUTSTANDING LOAN AMOUNT</td>
                <td>
                    <div style="float:right;">______________</div>
                </td>
            </tr>
            <tr>
                <td>LESS : PRE-MATURITY DEDUCTION AMOUNT</td>
                <td>
                    <div style="float:right;">______________</div>
                </td>
            </tr>
            <tr style=" ">
                <td style="border-bottom: 1px solid #000;">LESS : TDS DEDUCTION AMOUNT</td>
                <td>
                    <div style="float:right;">______________</div>
                </td>
            </tr>
            <tr>
                <td class="bold " style="line-height: 1;">NET EXPIRE AMOUNT PAYABLE</td>
                <td>
                    <div style="float:right;">______________</div>
                </td>
            </tr>
            <tr>
                <td class="bold">AMOUNT IN WORDS</td>
                <td>
                    <div style="float:right;">______________</div>
                </td>
            </tr>
        </table>

        <div class="section">
            <p>BRANCH ADDRESS: {{ $branch_address }}</p>
            <p style="text-align: center;">SAVING/CURRENT ACCOUNT NO. : ______________</p>

        </div>

        <table class=""
            style="margin-top: 12px; width:100%; border-collapse:collapse; border-spacing:0; font-size:12px; line-height:0.8; padding-bottom:8px ;">
            <tr>
                <td style="width: 60%">
                    <p style="text-align: left;">The said Welfare case down payment is hereby delivered up to the
                        company for cancellation.</p>
                </td>
                <td style="width: 40% ; text-align: center; font-weight: bold; vertical-align:middle;">FULL SIGNATURE
                </td>
            </tr>
            <tr>
                <td>Dated as this day of: {{ $date }}</td>
            </tr>
            <tr>
                <td> <strong>Customer Signature</strong></td>
            </tr>
            <tr>
                <td style="width: 60%; line-height: 1;">
                    <p style="text-align: left; "> Witness:<br>
                        1._________<br>
                        2._________<br>
                        3._________<br><br></p>
                </td>
                <td style="width: 40% ; text-align: center; font-weight: bold; vertical-align:middle; ">
                    <span style=" border: 1px solid #000; padding:30px 20px;  ">Stamp</span>
                </td>

            </tr>
            <tr style="">
                <td> </td>
                <td style="text-align: center ;"> <strong> Authorized Signatory</strong></td>
            </tr>
        </table>

        <div class="" style="border-top: 1px solid #000;">
            <div class="" style="text-align: center; font-size: 14px;">INSTRUCTION</div>
            <p style="font-size: 14px;">1. Signature in vernacular must have their English translation written beneath. Illiterate persons must
                affix their
                left thumb marks which should be identified by a magistrate or gazetted officer/notary public or
                advocate by
                putting his SEAL & SIGNATURE.</p>
            <p style="font-size: 14px;">2.Payment will made by A/C payee cheque on the company's bankers payment of bank draft or money
                order commission as the case may be.</p>
            <p style="font-size: 12px; text-align: center; font-weight: bold;">{{ $branch_address }}</p>
        </div>

    </div>
</body>

</html>