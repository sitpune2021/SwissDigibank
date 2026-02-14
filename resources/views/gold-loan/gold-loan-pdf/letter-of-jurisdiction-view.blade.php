@extends('layout.main')
@section('content')
  <style>
        /* *{
            font-size: 14px !important;
        } */
        body {
            font-family: Arial, Helvetica, sans-serif;
            /* background:#eee; */
            
        }

        .page{
        width:1000px;
        margin:20px auto;
        background:#fff;
        padding:20px;
     /* border:1px solid #ccc; */
    }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        td,
        th {
            border: 1px solid #333;
            padding: 6px;
            vertical-align: top;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }

        .subtitle {
            font-size: 14px;
            text-align: center;
        }

        .section {
            background: #e6a2a2;
            font-weight: bold;
            text-align: center;
        }

        .logo {
            width: 90px;
        }

        .no-border td {
            border: none;
        }

        .small {
            font-size: 12px;
        }

        @media print {
            body {
                background: #fff;
            }

            .page {
                border: none;
                margin: 0;
                width: 100%;
            }
        }
    </style>

<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h3 class="text-lg uppercase font-semibold">
                   LETTER OF JURISDICTION 
            </h3>
        </div>
    </div>
      <div class="text-center flex justify-center gap-5 mt-4">
        <a href="{{ route('loan.letter-of-jurisdiction.pdf',  $loan_id) }} " class="px-4 py-2 btn-primary uppercase"
            style="font-family: sans-serif !important; " target="_blank">
            <i class="las la-print"></i> Print
        </a>
        <a href="{{ route('loan.letter-of-jurisdiction.pdf',  $loan_id) }} " class="px-4 py-2 btn-primary uppercase"
            style="font-family: sans-serif !important; " target="_blank">
            <i class="las la-download"></i> Download
        </a>
        <a href=" {{ route('gold-loan.applications.view', $loan_id) }}" class="px-4 py-2 btn-outline uppercase" style="font-family: sans-serif !important; " target="_self">
            BACK
        </a>
    </div>
    <div class="box mt-5" style="padding:20px; ">


    <div class="page">

        <!-- HEADER -->
        <div style="width:100%; font-family: dejavusans; border-bottom: 1px solid #000 ; padding: 5px;">

            <!-- Logo -->

            <div style="float:left; width:30%; text-align:left;  margin-top: 0 !important;">
                <img src="{{ asset('assets/images/SBC_Logo_gpg.jpg') }}" alt="logo"
                    style=" width:auto; height:50px;">
                {{-- @if($logo) --}}

                {{-- <img src="{{ public_path($logo->image_path) }}" alt="logo"
                    style="max-width:90px; max-height:90px;"> --}}
                {{-- @else --}}
                {{-- <img src="{{ public_path('assets/images/Loan_Management_Logo.png') }}" alt="default logo"
                    style="max-width:90px; max-height:90px;"> --}}
                {{-- @endif --}}
                {{-- <img src="{{ public_path('assets/images/SBC_Logo.jpg') }}" alt="Company Logo"
                    style="width:130px; height:130px;"> --}}
            </div>

            <!-- Title Section -->
            {{-- <div style="float:left; width:70%; text-align:center;">
                <div style="  font-size:30px; font-weight: 800;  text-transform:uppercase; "> --}}
                    {{-- SBC Global --}}
                    {{-- </div> --}}

                {{-- <div style="height:10px; margin-top: 40px;">&nbsp;</div> --}}


                {{--
            </div> --}}

            <!-- Clear Float -->
            <div style="clear:both; "></div>
            <h4 style=" text-align: center; font-size:18px; margin: 5px !important; font-weight:bold;">
                JURISDICTION ACKNOWLEDGMENT LETTER
            </h4>
        </div>

        <br>
        <div class="" style="text-align: right">
            Printed On : 14-02-2026

        </div>

        <div class="" style="text-align: left; font-size: 14px;">
          <span style="font-weight: 700">  TO,</span>
            <br>
            <br>
            (bank name) (static)
            <br>
            SHEGAON SHEGAON Maharashtra - 110012(static)
            <br>
        </div>

        <div class="" style="font-weight: 700; margin-top: 15px;">SUBJECT : Acknowledgment of Jurisdiction for Loan
            Account
        </div>
         <div class="" style=" margin-top: 15px;">
            Dear Dear Sir/Madam
        </div>
        <div class="" style=" margin-top: 15px;">
        I, shreepad page(static), son/daughter/spouse of , residing at Maharashtra(static), holding Loan Account Number GLA00004(static) with (Bank Name)(static), do hereby acknowledge and confirm that I am fully aware of and agree to the terms of jurisdiction as applicable to my loan account.
        </div>
        <div class="" style=" margin-top: 15px;">
        I explicitly acknowledge that all legal proceedings, disputes, and matters arising out of or in connection with my loan account shall be subject to the exclusive jurisdiction of the competent courts at (AKOLA (Maharashtra)(static)) only. I shall not object to or dispute the same under any circumstances.
        </div>
        <div class="" style=" margin-top: 15px;">
       This acknowledgment is given voluntarily and with full understanding of its implications.
        </div>

        <div class="" style=" margin-top: 15px; font-weight: 700;">
            Acknowledged and Accepted By:
        </div>
        <div class="" style=" margin-top: 15px; ">
           <span style="font-weight: 700;"> Borrower’s Name:</span> shreepad page(static) <br><br>
           <span style="font-weight: 700;"> Signature:</span>
           ___________ <br><br>
            <span style="font-weight: 700;">Date:  </span>
            14-02-2026(static)
        </div>
        <div class="" style=" margin-top: 15px; ">
            <br>
        For <span style="font-weight: 700;">(bank name) static</span> 
            <br>
            <br>
        </div>
        <div class="" style=" margin-top: 15px; ">
           <span style="font-weight: 700;"> Authorized Signatory</span> 
           <br><br>
           <span style="font-weight: 700;margin-top: "> Name:</span>
           ___________ <br><br>
           <span style="font-weight: 700;margin-top: "> Designation:</span>
           ___________ <br><br>
            <span style="font-weight: 700;">Date:  </span>
            14-02-2026(static)
        </div>       
    </div>

    </div>
     

    @endsection