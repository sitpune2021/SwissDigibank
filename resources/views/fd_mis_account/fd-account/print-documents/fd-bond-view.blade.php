@extends('layout.main')
@section('content')
<style>
    input[type="checkbox"] {
        width: 28px;
        height: 28px;
        accent-color: green;
        /* For modern browsers */
    }

    /* Fallback for browsers without accent-color support */
    input[type="checkbox"]:checked {
        background-color: green;
        border: none;
    }

    input[type="radio"] {
        width: 24px;
        height: 24px;
        accent-color: green;
        /* Modern browser support */
    }

    .tableWidth {
        width: 90%;
        margin: auto;
    }

    .bg-yellow {
        background-color: #e17100;
    }

    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    /* Container for the toggle background */
    .blocks {
        width: 56px;
        /* 14 * 4px */
        height: 32px;
        /* 8 * 4px */
        border-radius: 9999px;
        /* Fully rounded */
        background-color: #9CA3AF;
        /* Tailwind gray-400 default */
        transition: background-color 0.3s ease;
    }

    /* The small white dot */
    .dot {
        position: absolute;
        top: 4px;
        /* 1 * 4px */
        left: 4px;
        /* 1 * 4px */
        width: 24px;
        /* 6 * 4px */
        height: 24px;
        /* 6 * 4px */
        background-color: white;
        border-radius: 9999px;
        transition: transform 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
    }

    /* When the checkbox is checked, change bg color */
    input[type="checkbox"].slider-toggle:checked+div .blocks {
        background-color: #228cc5;
        /* Tailwind green-500 */
    }

    /* Move the dot to right when checked */
    input[type="checkbox"].slider-toggle:checked+div .dot {
        transform: translateX(24px);
        /* 6 * 4px */
    }
    
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

<div class="main-inner">
     <h1 class="text-lg font-semibold">FD ACCOUNT - {{ $fdAccount->fd_no }}</h1>
<div class="text-center flex justify-center mt-4 gap-5" >
     <a href="{{ route('fd.bond.download', $fdAccount->id) }}"
   class="px-4 py-2 btn-primary uppercase"
   target="_blank">
   <i class="las la-download"></i> Download
</a>
 <a href="{{ route('fd-mis-schemes.fd_show', $fdAccount->id) }}"
   class="px-4 py-2 btn-outline uppercase"
   target="_self">
   BACk
</a>
</div>
    <div class="box mt-5">
        <div class="sheet">

        <!-- Header -->
        <div class="header">
            <!-- Logo (optional) -->
            <div style="width:100%;">
                <div class="logo" style="width: 22%">
                    <!-- Replace src path or use base64 img -->

                    @if($logo)
                     <img src="{{ asset('storage/' . $logo->image_path) }}"
         alt="logo"
         style=" width:auto; height:50px;">
                    {{-- <img src="{{ public_path($logo->image_path) }}" alt="logo" style="max-width:90px; max-height:90px;"> --}}
                    @else
                    {{-- <img src="{{ public_path('assets/images/Loan_Management_Logo.png') }}" alt="default logo"
                        style="max-width:90px; max-height:90px;"> --}}
                    @endif

                </div>

                <div style=" text-align:left; ">
                    <div class="company">
                        {{-- SBC GLOBAL --}}
                    </div>
                    <div class="subtitle" style="font-weight: bold;"> 
                        {{-- DEPOSIT CONFIRMATION/ RENEWAL ADVICE --}}
                    </div>
                    <div class="small muted">
                        {{-- BRANCH : {{ $company_address ?? 'Address here' }} --}}
                    </div>
                    <div class="small muted">
                        {{-- DATE :{{ $date ?? 'Address here' }} --}}
                    </div>
                </div>

                {{-- <div class="header-right"></div> --}}

            </div>
            <div class="clear"></div>
        </div>

        <!-- Member & Account info -->
        <table class="no-border mt-6">
            <tr>
                <td style="width:60%" class="no-border">
                    <div>
                         DATE :{{ $date ?? '' }} <br>
                        {{ $fdAccount->member->member_info_first_name ?? 'N/A' }}
                        {{ $fdAccount->member->member_info_last_name ?? '' }}
                    </div>
                    <div class="small muted">
                        {{ $fdAccount->member_address ?? 'N/A' }}
                    </div>
                    <div class="small mt-6">REPAYABLE TO:<br>
                        {{ $fdAccount->nominee->first()->nominee_name ?? 'N/A' }}
                    </div>
                </td>
                <td style="width:40%" class="no-border right">
                    <div class="small">MEMBER NO :
                        {{ $fdAccount->member->member_no ?? '' }}
                    </div>
                    <div class="small"> FD NO :
                        {{ $fdAccount->id ?? '' }}
                    </div>
                    <div class="small"> SCHEME :
                        {{ $fdAccount->fdScheme->scheme_name ?? '' }}
                    </div>
                    <div class="small">Interest Payout :
                        {{ $fdAccount->interest_payout_type }}
                    </div>

                    <div class="small"> TOTAL INTEREST :
                        ₹ {{ $fdAccount->total_interest }}

                    </div>

                    <div class="small">
                        NOMINEE: Not Reg.
                    </div>
                </td>
            </tr>
        </table>

        <!-- Main table -->
        <table class="btable mt-6">
            <thead>
                <tr>
                    <th>Deposit Date</th>
                    <th>
                        Deposit Period
                        (Year, Month, Day)
                    </th>
                    <th>Interest Rate (%)</th>
                    <th>Deposit Amount (₹)</th>
                    <th>Maturity Date</th>
                    <th>Maturity Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="center">{{ \Carbon\Carbon::parse($fdAccount->open_date ?? now())->format('d-m-Y') }}</td>
                    <td class="center">
                        {{ $fdAccount->tenure_year ? $fdAccount->tenure_year . ' Year(s) ' : '' }}
                        {{ $fdAccount->tenure_month ? $fdAccount->tenure_month . ' Month(s) ' : '' }}
                        {{ $fdAccount->tenure_day ? $fdAccount->tenure_day . ' Day(s)' : '' }}
                    </td>
                    <td class="center"> {{ $fdAccount->fdScheme->fdslabs->first()->interest_rate ?? '' }}</td>
                    <td class="right amount">
                        {{ number_format($fdAccount->fd_amount ?? 0, 2) }}
                    </td>
                    <td class="center">{{ \Carbon\Carbon::parse($fdAccount->maturity_date ?? now())->format('d-m-Y') }}
                    </td>
                    <td class="right amount">{{number_format($fdAccount->maturity_amount ?? 0,2)}}
                </tr>
            </tbody>
        </table>

        <!-- Amount words and details -->
        <table class="no-border mt-6">
            <tr>
                <td style="width:70%" class="no-border">

                    <div class="big">₹ {{ $amount_in_words ?? ($amount_words ?? '') }} </div>
                </td>
                <!-- <td style="width:30%" class="no-border right">
                    <div class="" style="text-align: center; margin-top: 6px;">
                        For SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA
                        LIMITED
                    </div>

                </td> -->
            </tr>
        </table>

        {{--
        <!-- Terms (small) -->
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
        <div class="" style="text-align: center">
            <strong> REGD OFFICE: </strong>
            SBC GLOBAL TOWAR , CHANDABAI PLOT NEAR BUS STOP SHEGAON Maharashtra - 444001
        </div>
        <div class="" style="text-align: center">
            <strong>REG NO </strong>: 969/03-04
        </div>

    </div>
    </div>


</div>
    @endsection