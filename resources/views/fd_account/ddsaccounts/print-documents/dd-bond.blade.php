<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DD Bond / Deposit Receipt</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <style>
        /* Page & base */
        @page {
            size: A4;
            margin: 18mm 12mm;
        }

        /* Use a Devanagari-capable TTF placed in public/fonts/ */
        @font-face {
            font-family: "NotoDeva";
            src: url("{{ public_path('fonts/NotoSansDevanagari-Regular.ttf') }}") format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: "NotoDeva";
            src: url("{{ public_path('fonts/NotoSansDevanagari-Bold.ttf') }}") format("truetype");
            font-weight: bold;
            font-style: normal;
        }

        body {
            font-family: "NotoDeva", "DejaVu Sans", Arial, sans-serif;
            font-size: 12px;
            color: #111;
            line-height: 1.25;
            -webkit-print-color-adjust: exact;
        }

        /* Container */
        .sheet {
            width: 100%;
            border: 1px solid #111;
            padding: 5px;
            /* keep consistent for PDF */
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 6px;
        }

        .logo {
            float: left;
            width: 90px;
            height: 90px;
        }

        .company {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.6px;
        }

        .subtitle {
            font-size: 11px;
            margin-top: 2px;
        }

        .header-right {
            float: right;
            text-align: right;
            font-size: 11px;
        }

        .clear {
            clear: both;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .no-border td {
            border: none;
            padding: 4px 6px;
            vertical-align: top;
        }

        .btable th,
        .btable td {
            border: 1px solid #222;
            padding: 6px 8px;
            vertical-align: middle;
            font-size: 12px;
        }

        .btable th {
            background: #f4f4f4;
            font-weight: 700;
        }

        .small {
            font-size: 11px;
            text-align: left;
            text-transform: uppercase;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        /* Amount / emphasis */
        .big {
            font-size: 12px;
        }

        .amount {
            font-weight: 700;
        }

        /* Footer note & signature */
        .signature {
            margin-top: 28px;
            width: 100%;
        }

        .sig-left {
            float: left;
            width: 40%;
            text-align: left;
            font-size: 12px;
        }

        .sig-right {
            float: right;
            width: 40%;
            text-align: right;
            font-size: 12px;
        }

        .sig-line {
            display: inline-block;
            margin-top: 36px;
            border-top: 1px solid #333;
            padding-top: 4px;
        }

        .footer {
            margin-top: 18px;
            font-size: 11px;
            text-align: center;
            color: #333;
        }

        /* small helpers */
        .muted {
            color: #555;
            font-size: 11px;
        }

        .mt-6 {
            margin-top: 6px;
        }

        .mt-12 {
            margin-top: 12px;
        }

        /* Ensure page-break friendliness */
        .page-break {
            page-break-after: always;
        }

        /* Prevent tables from splitting awkwardly */
        tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    <div class="" style="border: 1px solid #111; padding: 2px 5px;">

        <!-- Header -->
        
        <div class="header" style="padding : 10px 0px ; border-bottom:  1px solid black; ">
            <!-- Logo (optional) -->
            <div style="width:100%; font-family: dejavusans; ">

            <!-- Logo -->
            <div style="float:left; width:50%; padding: 0px 5px; text-align:left;">
                <img src="{{ public_path('assets/images/SBC_Logo_gpg.jpg') }}" alt="Company Logo"
                    style="width:auto; height:50px;">
            </div>

            <!-- Title Section -->
            <div style="float:left; width:50%; text-align:center;">
                <div style="  font-size:30px; font-weight: 800;  text-transform:uppercase; ">
                    {{-- SBC Global --}}
                </div>

                <div style="height:10px; margin-top: 40px;">&nbsp;</div>


            </div>

            <!-- Clear Float -->
            <div style="clear:both; "></div>
            <h4 style="   margin:0; text-align: center;  font-size:18px; font-weight:bold;">
               DAILY DEPOSIT ADVICE
               <br>
(In lieu of daily deposit)
            </h4>
        </div>
            <div style="clear:both; "></div>
        </div>

        <!-- Member & Account info -->
        <div class="" style="">
            <table class="no-border mt-6 " >
            <tr>
                <td style="width:60%" class="no-border">
                    <div>
                        {{ $ddAccount->member->member_info_first_name ?? 'N/A' }}
                        {{ $ddAccount->member->member_info_last_name ?? '' }}
                    </div>
                    <div class="small muted">
                        {{ $ddAccount->member_address ?? 'N/A' }}
                    </div>
                </td>
                <td style="width:40%" class="no-border right">
                    <div class="small">
                        BRANCH : {{ $company_address ?? '' }}
                    </div>
                    <div class="small"> MEMEBER NO :
                        {{ $ddAccount->id ?? '' }}
                    </div>
                    <div class="small">
                        DATE :{{ $date ?? '' }}
                    </div>
                    <div class="small">
                        NOMINEE :
                        {{ optional($ddAccount->nominee->first())->nominee_name ?? 'Not Reg.' }}
                    </div>

                    <div class="small">
                        RELATION :
                        {{ optional($ddAccount->nominee->first())->relation ?? 'Not Reg.' }}
                    </div>
                </td>
            </tr>
        </table>
        </div>

        <div>
            <p style="font-size:11px;"> Dear Sir/ Madam<br>
                We have pleasure in confirming details of the following amount held in deposit with us. Thank you for banking with us.</p>
        </div>

        <table class="no-border mt-6">
            <tr>

                <td style="text-align:left !important;"> Scheme Code : {{ $ddAccount->scheme->scheme_code ?? '' }}</td>
                <td> Scheme Name : {{ $ddAccount->scheme->scheme_name ?? '' }}</td>
            </tr>
        </table>
        <!-- Main table -->
        <table class=" mt-6" style="border: 1px solid #111;">
            <thead>
                <tr>
                    <th style="" >Account No</th>
                    <th style="border: 1px solid #111;" >Term</th>
                    <th style="border: 1px solid #111;" >Interest @</th>
                    <th style="border: 1px solid #111;" >Amount</th>
                    <th style="border: 1px solid #111;" >Frequency</th>
                    <th style="border: 1px solid #111;" >Open Date</th>
                    <th style="border: 1px solid #111;" >Maturity Date</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
                <tr>
                    <td style="border: 1px solid #111;" class="">{{ $ddAccount->dd_no }}</td>

                    <td style="border: 1px solid #111;" class="">
                        {{ $ddAccount->scheme->tenure_of_rd_dd_value }}
                        {{ strtoupper($ddAccount->scheme->tenure_of_rd_dd_type) }}
                    </td>

                    <td style="border: 1px solid #111;" class="">
                        {{ $ddAccount->scheme->anuual_interest_rate }} %
                    </td>

                    <td style="border: 1px solid #111;" class="">
                        ₹ {{ number_format($ddAccount->dd_amount, 2) }}
                    </td>

                    <td style="border: 1px solid #111;" class="">
                        {{ ucfirst($ddAccount->scheme->rd_dd_frequency) }}
                    </td>

                    <td style="border: 1px solid #111;" class="">
                        {{ \Carbon\Carbon::parse($ddAccount->open_date)->format('d-m-Y') }}
                    </td>

                    <td style="border: 1px solid #111;" class="">
                        {{ \Carbon\Carbon::parse($ddAccount->maturity_date)->format('d-m-Y') }}
                    </td>
                </tr>
            </tbody>

            </tbody>
        </table>

        <!-- Amount words and details -->
        <table class="no-border mt-6">
            <tr>
                <td style="width:70%" class="no-border">

                    <div class="big">
    Maturity Value : ₹ {{ number_format($ddAccount->maturity_amount, 2) }} (approx.)
</div>

                </td>
                <td style="width:30%" class="no-border right">
                    <div class="" style="text-align: center; margin-top: 6px;">
                        Your Faithfully
                    </div>

                </td>
            </tr>
        </table>

        {{-- <!-- Terms (small) -->
        <div class="mt-12 small muted">
            <strong>Terms & Conditions:</strong>
            <ol style="margin:6px 0 0 18px; padding:0;">
                <li>Interest will be paid as per scheme rules.</li>
                <li>Premature withdrawal rules as per society policy.</li>
                <li>Receipt subject to terms and conditions of the society.</li>
            </ol>
        </div> --}}

        <div class="" style="text-align: right ; margin-top: 50px; margin-right: 30px !important;">
            Authorised Signatory
        </div>

        <div class="" style="text-align: center; margin-top: 20px;">
            THANK YOU FOR YOUR CONTINUED PATRONAGE WITH OUR SOCIETY
        </div>

    </div>


</body>

</html>