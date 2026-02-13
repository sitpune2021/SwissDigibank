@extends('layout.main')
@section('content')
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

<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h3 class="text-lg uppercase font-semibold">
                SANCTION LETTER
            </h3>
        </div>
    </div>
      <div class="text-center flex justify-center gap-5 mt-4">
        <a href="{{ route('business_loan.sanction_letter.pdf',  $loan_id) }} " class="px-4 py-2 btn-primary uppercase"
            style="font-family: sans-serif !important; " target="_blank">
            <i class="las la-download"></i> Download
        </a>
        <a href=" {{ route('bussiness.applications.view', $loan_id) }}" class="px-4 py-2 btn-outline uppercase" style="font-family: sans-serif !important; " target="_self">
            BACK
        </a>
    </div>
    <div class="box mt-5" style="padding:20px; ">

    <div class="page">
        <!-- Header -->
         <div style="width:100%; font-family: dejavusans; ">

        <!-- Logo -->
        <div style="float:left; width:50%; padding: 0px 5px; text-align:left;">
            <img src="{{ asset('assets/images/SBC_Logo_gpg.jpg') }}" alt="Company Logo"
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
        <div class="" style="text-align: center; margin-top: 16px; font-size: 16px; font-weight: 600;">
          SANCTION LETTER
        </div>
      
        
    </div>

        <!-- HEADER -->
        <table class="header" style="border-top:1px solid #000;">
            <tr>
                <td style="text-align:left; font-size: 14px !important;">Printed On : {{$printed_on}}</td>
                <td style="text-align:right; font-size: 14px !important;">Branch : {{$branch}}</td>
            </tr>
        </table>

        <!-- BORROWER DETAILS -->
        <div class="section">
            <table class="details" style="font-size: 16px !important;">
                <tr>
                    <td  class="label" style="font-size: 14px !important;">Member Name</td>
                    <td  class="value" style="font-size: 14px !important;">:
                        {{$member_name}} ({{ $member_no }})
                    </td>
                </tr>
                <tr>
                    <td  class="label" style="font-size: 14px !important;">Father / Husband</td>
                    <td  class="value" style="font-size: 14px !important;">:{{$father_husband}}</td>
                </tr>
                <tr>
                    <td  class="label" style="font-size: 14px !important;">Contact No</td>
                    <td  class="value" style="font-size: 14px !important;">: {{$contact_no}}</td>
                </tr>
                <tr>
                    <td  class="label" style="font-size: 14px !important;">Address</td>
                    <td  class="value" style="font-size: 14px !important;">: {{$address}}</td>
                </tr>
            </table>
        </div>

        <!-- INTRO -->
        <div  class="section" style="font-size: 14px;">
            We refer to our discussion and pleased to refer our proposal for you favorable consideration the following
            terms
            for providing Loan Facility.
        </div>

        <!-- LOAN DETAILS -->
        <div  class="section">
            <table  class="details">
                <tr>
                    <td  class="label" style="font-size: 14px !important;">Application No</td>
                    <td  class="value" style="font-size: 14px !important;">: {{$application_no}}</td>
                </tr>
                <tr>
                    <td  class="label" style="font-size: 14px !important;">Application Date</td>
                    <td  class="value" style="font-size: 14px !important;">: {{$application_date}}</td>
                </tr>
                <tr>
                    <td  class="label" style="font-size: 14px !important;">Application Status</td>
                    <td  class="value" style="font-size: 14px !important;">: {{ $application_status }}</td>
                </tr>
                <tr>
                    <td  class="label" style="font-size: 14px !important;">Loan No</td>
                    <td  class="value" style="font-size: 14px !important;">: {{$loan_no}}</td>
                </tr>
                <tr>
                    <td  class="label" style="font-size: 14px !important;">Nature of Loan</td>
                    <td  class="value" style="font-size: 14px !important;">: {{$nature_of_loan}}</td>
                </tr>
                <tr>
                    <td  class="label" style="font-size: 14px !important;">Loan Scheme</td>
                    <td  class="value" style="font-size: 14px !important;">: {{$loan_scheme}}</td>
                </tr>
                <tr>
                    <td  class="label" style="font-size: 14px !important;">Loan Amount</td>
                    <td  class="value" style="font-size: 14px !important;">: ₹ {{$loan_amount}}</td>
                </tr>
                <tr>
                    <td  class="label" style="font-size: 14px !important;">Tenure of Loan</td>
                    <td  class="value" style="font-size: 14px !important;">: {{$tenure_of_loan}}</td>
                </tr>
                <tr>
                    <td  class="label" style="font-size: 14px !important;">Interest Type</td>
                    <td  class="value" style="font-size: 14px !important;">: {{$interest_type}}</td>
                </tr>
                <tr>
                    <td  class="label" style="font-size: 14px !important;">Annual Rate of Interest</td>
                    <td  class="value" style="font-size: 14px !important;">: {{$annual_interset_rate}}%</td>
                </tr>
                <tr>
                    <td  class="label" style="font-size: 14px !important;">EMI Payout</td>
                    <td  class="value" style="font-size: 14px !important;">: {{$emi_payout}}</td>
                </tr>
                <tr>
                    <td  class="label" style="font-size: 14px !important;">EMI Amount</td>
                    <td  class="value" style="font-size: 14px !important;">: ₹ {{$emi_amt}}</td>
                </tr>
                <tr>
                    <td  class="label" style="font-size: 14px !important;">No. of EMIs</td>
                    <td  class="value " style="font-size: 14px !important;">: {{$no_of_emis}}</td>
                </tr>
                 <tr>
                    <td  class="label" style="font-size: 14px !important;">Credit Period (Grace Period)</td>
                    <td  class="value" style="font-size: 14px !important;">: {{$credit_grace_period}}</td>
                </tr>
                <tr>
                    <td  class="label" style="font-size: 14px !important;">Processing Fee</td>
                    <td  class="value" style="font-size: 14px !important;">: ₹ {{$processing_fee}}</td>
                </tr>
                <tr>
                    <td  class="label" style="font-size: 14px !important;">Stamp Duty</td>
                    <td  class="value" style="font-size: 14px !important;">: ₹ {{$stamp_duty}}</td>
                </tr>
                <tr>
                    <td  class="label" style="font-size: 14px !important;">Insurance Fee</td>
                    <td  class="value" style="font-size: 14px !important;">: ₹ {{$insurance_fee}}</td>
                </tr>
                <tr>
                    <td  class="label" style="font-size: 14px !important;">
                        Repayment
                        Execution of Document
                        Other conditions
                    </td>
                    <td  class="value" style="font-size: 14px !important;">:
                         {{$emi_payout}} installments (EMI) from the date of disbursal. Borrower
                        will execute the documents as per norms of the company all other
                        charges and penalties as mentioned in the application document
                    </td>
                </tr>
            </table>
        </div>
{{--  
        <!-- SECURITY DEPOSIT -->
        <div  class="section" style="font-size: 14px !important;">
            <strong>Security Deposits</strong>

            <table  class="security-table">
                <tr>
                    <th style="font-size: 14px !important;">ITEM TYPE</th>
                    <th style="font-size: 14px !important;">NAME</th>
                    <th style="font-size: 14px !important;">QTY</th>
                    <th style="font-size: 14px !important;">VAL/gm (₹)</th>
                    <th style="font-size: 14px !important;">GROSS WT (gm)</th>
                    <th style="font-size: 14px !important;">NET WEIGHT (gm)</th>
                    <th style="font-size: 14px !important;">TUNCH (%)</th>
                    <th style="font-size: 14px !important;">FINE WEIGHT (gm)</th>
                    <th style="font-size: 14px !important;">TOTAL VAL. (₹)</th>
                    <th style="font-size: 14px !important;">IMAGE</th>
                    <th style="font-size: 14px !important;">STATUS</th>
                </tr>
                  @foreach($ornaments as $ornament)
                <tr>
                    <td style="font-size: 14px !important;">{{$ornament->item_type}}</td>
                    <td style="font-size: 14px !important;">{{$ornament->item_name}}</td>
                    <td style="font-size: 14px !important;">{{$ornament->no_of_items}}</td>
                    <td style="font-size: 14px !important;">{{$ornament->value_per_gram}}</td>
                    <td style="font-size: 14px !important;">{{$ornament->gross_weight}}</td>
                    <td style="font-size: 14px !important;">{{$ornament->net_weight}}</td>
                    <td style="font-size: 14px !important;">{{$ornament->tunch}}</td>
                    <td style="font-size: 14px !important;">{{$ornament->fine_weight}}</td>
                    <td style="font-size: 14px !important;">{{$ornament->total_value}}</td>
                    <td style="font-size: 14px !important;">
                         {{$ornament->image}} }
                    </td>
                    <td style="font-size: 14px !important;">
                    {{ $ornament->status == 1 ? 'Mortgage' : 'Release' }}
                    </td>
                    
                </tr>
                @endforeach
            </table>
        </div>
--}}
        <!-- DECLARATION -->
        <div  class="section" style="font-size: 14px !important;">
            Please note that any change in the relevant Income tax, GST laws and any other condition of agreement shall
            attract suitable revision in the installments. This offer is subject to standard covenants attaches to the
            Loan
            Agreement and subject to final approval by the management.
        </div>
        <div  class="section" style="font-size: 14px !important;">
            Please sign and return the duplicate copy of this sanction letter as a token of having accepted the terms
            and
            conditions details above.
        </div>

        <!-- SIGNATURE -->
        <div  class="footer" style="font-size: 14px !important;">
            Your faithfully<br>
            {{ $bank_name }}

            <div  class="" style="margin-top:20px; ">AUTHORIZED SIGNATORY</div>
        </div>

        <div  class=""  style="margin-top:20px; font-size: 14px !important;">
            I/ We agree to the above terms and conditions agree to furnish in this connection any details required by "{{$bank_name}}".
        </div>
       <div  class="" style="width: 100%; margin-top: 10px; height: 100px; font-size: 14px !important; margin-top: 10px; font-weight: 700;">
        <div  class=""  style="width: 50%; float: left; font-size: 14px !important">
           Thanking you,<br>
            Yours Truly,
        </div>
        <div  class="" style="float: right; font-weight: 700;">
           {{$member_name}}<br>
Name and Signature
        </div>
       </div>
    </div>

    </div>
     

    @endsection