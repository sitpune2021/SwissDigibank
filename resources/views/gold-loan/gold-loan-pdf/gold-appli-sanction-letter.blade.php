<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px !important;
            line-height: 1.4;
        }

        .page {
            width: 100%;
        }

        .header {
            border-bottom: 1px solid #000;
            margin-bottom: 10px;
        }

        .header td {
            font-size: 11px;
        }

        .section {
            margin-bottom: 10px;
        }

        .label {
            width: 35%;
            font-weight: bold;
        }

        .value {
            width: 65%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            font-size: 10px !important;
        }

        .details td {
            padding: 2px 0;
            vertical-align: top;
            font-size: 12px !important;
        }

        .security-table {
            margin-top: 8px;
            border: 1px solid #000;
        }

        .security-table th,
        .security-table td {
            border: 1px solid #000;
            padding: 4px;
            font-size: 11px;
            text-align: center;
        }

        .security-table th {
            color: red;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
        }

        .signature {
            margin-top: 30px;
            font-weight: bold;
        }

        .page-no {
            text-align: center;
            font-size: 10px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="page">
        <!-- Header -->
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
        <div class="" style="text-align: center; margin-top: 10px; font-size: 16px; font-weight: 600;">
          SANCTION LETTER
        </div>
      
        <hr>
    </div>

        <!-- HEADER -->
        <table class="header">
            <tr>
                <td style="text-align:left; font-size: 13px !important;">Printed On : {{$printed_on}}</td>
                <td style="text-align:right; font-size: 13px !important;">Branch : {{$branch}}</td>
            </tr>
        </table>

        <!-- BORROWER DETAILS -->
        <div class="section">
            <table class="details">
                <tr>
                    <td class="label">Member Name</td>
                    <td class="value">:
                        {{$member_name}} ({{ $member_no }})
                    </td>
                </tr>
                <tr>
                    <td class="label">Father / Husband</td>
                    <td class="value">:{{$father_husband}}</td>
                </tr>
                <tr>
                    <td class="label">Contact No</td>
                    <td class="value">: {{$contact_no}}</td>
                </tr>
                <tr>
                    <td class="label">Address</td>
                    <td class="value">: {{$address}}</td>
                </tr>
            </table>
        </div>

        <!-- INTRO -->
        <div class="section" style="font-size: 13px;">
            We refer to our discussion and pleased to refer our proposal for you favorable consideration the following
            terms
            for providing Loan Facility.
        </div>

        <!-- LOAN DETAILS -->
        <div class="section">
            <table class="details">
                <tr>
                    <td class="label">Application No</td>
                    <td class="value">: {{$application_no}}</td>
                </tr>
                <tr>
                    <td class="label">Application Date</td>
                    <td class="value">: {{$application_date}}</td>
                </tr>
                <tr>
                    <td class="label">Application Status</td>
                    <td class="value">: {{ $application_status }}</td>
                </tr>
                <tr>
                    <td class="label">Loan No</td>
                    <td class="value">: {{$loan_no}}</td>
                </tr>
                <tr>
                    <td class="label">Nature of Loan</td>
                    <td class="value">: {{$nature_of_loan}}</td>
                </tr>
                <tr>
                    <td class="label">Loan Scheme</td>
                    <td class="value">: {{$loan_scheme}}</td>
                </tr>
                <tr>
                    <td class="label">Loan Amount</td>
                    <td class="value">: ₹{{$loan_amount}}</td>
                </tr>
                <tr>
                    <td class="label">Tenure of Loan</td>
                    <td class="value">: {{$tenure_of_loan}}</td>
                </tr>
                <tr>
                    <td class="label">Interest Type</td>
                    <td class="value">: {{$interest_type}}</td>
                </tr>
                <tr>
                    <td class="label">Annual Rate of Interest</td>
                    <td class="value">: {{$annual_interset_rate}}%</td>
                </tr>
                <tr>
                    <td class="label">EMI Payout</td>
                    <td class="value">: {{$emi_payout}}</td>
                </tr>
                <tr>
                    <td class="label">EMI Amount</td>
                    <td class="value">: ₹ {{$emi_amt}}</td>
                </tr>
                <tr>
                    <td class="label">No. of EMIs</td>
                    <td class="value">: {{$no_of_emis}}</td>
                </tr>
                 <tr>
                    <td class="label">Credit Period (Grace Period)</td>
                    <td class="value">: {{$credit_grace_period}}</td>
                </tr>
                <tr>
                    <td class="label">Processing Fee</td>
                    <td class="value">: ₹{{$processing_fee}}</td>
                </tr>
                <tr>
                    <td class="label">Stamp Duty</td>
                    <td class="value">: ₹ {{$stamp_duty}}</td>
                </tr>
                <tr>
                    <td class="label">Insurance Fee</td>
                    <td class="value">: ₹ {{$insurance_fee}}</td>
                </tr>
                <tr>
                    <td class="label">
                        Repayment
                        Execution of Document
                        Other conditions
                    </td>
                    <td class="value">:
                         {{$emi_payout}} installments (EMI) from the date of disbursal. Borrower
                        will execute the documents as per norms of the company all other
                        charges and penalties as mentioned in the application document
                    </td>
                </tr>
            </table>
        </div>

        <!-- SECURITY DEPOSIT -->
        <div class="section">
            <strong>Security Deposits</strong>

            <table class="security-table">
                <tr>
                    <th>ITEM TYPE</th>
                    <th>NAME</th>
                    <th>QTY</th>
                    <th>VAL/gm (₹)</th>
                    <th>GROSS WT (gm)</th>
                    <th>NET WEIGHT (gm)</th>
                    <th>TUNCH (%)</th>
                    <th>FINE WEIGHT (gm)</th>
                    <th>TOTAL VAL. (₹)</th>
                    <th>IMAGE</th>
                    <th>STATUS</th>
                </tr>
                  @foreach($ornaments as $ornament)
                <tr>
                    <td>{{$ornament->item_type}}</td>
                    <td>{{$ornament->item_name}}</td>
                    <td>{{$ornament->no_of_items}}</td>
                    <td>{{$ornament->value_per_gram}}</td>
                    <td>{{$ornament->gross_weight}}</td>
                    <td>{{$ornament->net_weight}}</td>
                    <td>{{$ornament->tunch}}</td>
                    <td>{{$ornament->fine_weight}}</td>
                    <td>{{$ornament->total_value}}</td>
                    <td>
                        {{-- {{$ornament->image}} --}}
                    </td>
                    <td>
                    {{ $ornament->status == 1 ? 'Mortgage' : 'Release' }}
                    </td>
                    
                </tr>
                @endforeach
            </table>
        </div>

        <!-- DECLARATION -->
        <div class="section">
            Please note that any change in the relevant Income tax, GST laws and any other condition of agreement shall
            attract suitable revision in the installments. This offer is subject to standard covenants attaches to the
            Loan
            Agreement and subject to final approval by the management.
        </div>
        <div class="section">
            Please sign and return the duplicate copy of this sanction letter as a token of having accepted the terms
            and
            conditions details above.
        </div>

        <!-- SIGNATURE -->
        <div class="footer">
            Your faithfully<br>
            {{ $bank_name }}

            <div class="" style="margin-top:20px; ">AUTHORIZED SIGNATORY</div>
        </div>

        <div class=""  style="margin-top:20px; ">
            I/ We agree to the above terms and conditions agree to furnish in this connection any details required by "{{$bank_name}}".
        </div>
       <div class="" style="width: 100%; margin-top: 10px; font-weight: 700;">
        <div class=""  style="width: 50%; float: left">
           Thanking you,<br>
            Yours Truly,
        </div>
        <div class="" style="float: right; font-weight: 700;">
           {{$member_name}}<br>
Name and Signature
        </div>
       </div>
    </div>
</body>

</html>