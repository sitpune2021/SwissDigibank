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
     <h1 class="text-lg font-semibold">RD ACCOUNT - {{ $rdAccount->rd_no }}</h1>
<div class="text-center flex justify-center gap-5 mt-4" >
     <a href="{{ route('closing.form', $rdAccount->id) }}"
   class="px-4 py-2 btn-primary uppercase"
   target="_blank">
   <i class="las la-download"></i> Download
</a>
 <a href="
 {{ route('rd-accounts.show', $rdAccount->id) }}
  "
   class="px-4 py-2 btn-outline uppercase"
   target="_self">
   BACK
</a>
</div>
    <div class="box mt-5">
        <div class="container">

       <div style="width:100%; font-family: dejavusans; border-bottom: 1px solid #000 ; ">

            <!-- Logo -->

            <div style="float:left; width:30%; text-align:left;">
               <img src="{{ asset('assets/images/SBC_Logo_gpg.jpg') }}" alt="logo"
                                style=" width:auto; height:50px;">
                {{-- @if($logo) --}}
                     
                    {{-- <img src="{{ public_path($logo->image_path) }}" alt="logo" style="max-width:90px; max-height:90px;"> --}}
                    {{-- @else --}}
                    {{-- <img src="{{ public_path('assets/images/Loan_Management_Logo.png') }}" alt="default logo"
                        style="max-width:90px; max-height:90px;"> --}}
                    {{-- @endif --}}
                {{-- <img src="{{ public_path('assets/images/SBC_Logo.jpg') }}" alt="Company Logo"
                    style="width:130px; height:130px;"> --}}
            </div>

            <!-- Title Section -->
            <div style="float:left; width:70%; text-align:center;">
                <div style="  font-size:30px; font-weight: 800;  text-transform:uppercase; ">
                    {{-- SBC Global --}}
                </div>

                <div style="height:10px; ">&nbsp;</div>

              
            </div>
 
            <!-- Clear Float -->
            <div style="clear:both; "></div>
 <h4 style="text-align: center; font-size:18px; font-weight:bold;">
             Issue of Discharge Form for End of Term/ Pre-Maturity
                </h4>
        </div>
        <!-- <div class="title">
            <table style="width:100%; border-collapse:collapse; border-bottom: 1px solid #000;">
                <tr>
                    <td style=" text-align:left;">
                        <img src="{{ public_path('assets/images/SBC_Logo.jpg') }}" alt="Logo"
                            style="width:90px; height:90px;">
                    </td>
                    <td style="text-align:center; vertical-align:start; ">
                        <
                        <div class="" style="margin-top: 30px; text-transform: capitalize; font-size: 16px;">Issue Of
                           
                    </td>
                </tr>
            </table>
        </div> -->



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

        <div class="" style="border-top: 1px solid #000; margin-bottom: 25px;">
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

        <div class=""  >
            {{-- SBC GLOBAL TOWAR , KESHAV NAAR CHOWK NEAR JANORKAR MARRAIGE HALL RING ROAD AKOLA Maharashtra - 444001 --}}
        </div>

    </div> </div>


</div>
    @endsection