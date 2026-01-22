@extends('layout.main')
@section('content')
<style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f8f8;
            margin: 0;
            padding: 8px;
        }

        .form-container {
            background: #fff;
            max-width: 800px;
            margin: auto;
            padding: 15px 25px;
            font-size: 13px;
            /* slightly smaller text */
            line-height: 1.3;
        }

        .header {
            text-align: center;
        }

        .letterhead {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            margin-bottom: 8px;
        }

        .logo {
            width: 100px;
            text-align: center;
        }

        .logo img {
            width: 100%;
            height: auto;
        }

        hr {
            margin: 10px 0;
            border: 1px solid #ccc;
        }

        .section-title {
            font-weight: bold;
            margin: 8px 0 3px;
            text-decoration: underline;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 6px;
        }

        .row label {
            flex: 1;
            font-size: 13px;
            padding: 1px 0;
        }


        .declaration {
            font-size: 12px;
            margin: 10px 0;
            line-height: 1.3;
            text-align: justify;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 12x;
        }

        .signature {
            text-align: right;
            margin-top: 10px;
            font-size: 13px;
        }



        .office-use {
            border-top: 1px dashed #000;
            margin-top: 20px;
            padding-top: 10px;
            font-size: 13px;

        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 10px;
        }

        td {
            padding: 4px;
        }
    </style>

<div class="main-inner">
     <h1 class="text-lg font-semibold">DDS ACCOUNT - {{ $ddAccount->dd_no }}</h1>
<div class="text-center flex justify-center gap-5 mt-4" >
     <a href="{{ route('dd.bond.download', $ddAccount->id) }}"
   class="px-4 py-2 btn-primary uppercase"
   target="_blank">
   <i class="las la-download"></i> Download
</a>
 {{-- <a href="
 {{ route('dds-accounts.show', $ddAccount->id) }}
  "
   class="px-4 py-2 btn-outline uppercase"
   target="_self">
   BACK
</a> --}}
</div>
    <div class="box mt-5">
        <div class="" style="border: 1px solid #111; padding: 2px 5px;">

        <!-- Header -->
        <div class="header" style="padding : 10px 0px ; border-bottom:  1px solid black; ">
            <!-- Logo (optional) -->
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


    </div>


</div>
    @endsection