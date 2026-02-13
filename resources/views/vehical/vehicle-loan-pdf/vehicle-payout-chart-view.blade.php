@extends('layout.main')
@section('content')
<style>
    @page {
        margin: 30px 40px;
        /* margin: 25mm; */
    }

    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 14px;
        color: #000;
    }

    .header {
        width: 100%;
        margin-bottom: 15px;
    }

    .header td {
        font-size: 11px;
    }

    .line {
        border-bottom: 2px solid #000;
        margin-top: 5px;
    }

    .content {
        margin-top: 20px;
        line-height: 1.6;
    }

    .address {
        margin-bottom: 20px;
    }

    .subject {
        margin: 15px 0;
    }

    table.details {
        width: 100%;
        margin-top: 10px;
        border-collapse: collapse;
    }

    table.details td {
        padding: 3px 0;
        vertical-align: top;
    }

    table.details td.label {
        width: 45%;
    }

    table.details td.colon {
        width: 5%;
    }

    table.details td.value {
        width: 50%;
    }

    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 10px;
    }

    td {
        padding: 0px 45px;
    }

    .footer {
        margin-top: 25px;
    }

    .signature {
        margin-top: 40px;
    }

    .signature-name {
        margin-top: 5px;
        font-weight: bold;
    }
</style>

<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h3 class="text-lg uppercase  font-semibold">
                PAYOUTS CHART
            </h3>
        </div>
    </div>
    <div class="text-center  flex justify-center gap-5 mt-4">
        <a href="{{ route('vehicle_loan.payout_chart_loan_application.pdf' ,$loan_no) }}" class="px-4 py-2 btn-primary uppercase"
            style="font-family: sans-serif !important; " target="_blank">
            <i class="las la-download"></i> Download
        </a>
        <a href=" {{ route('vehical.applications.view', $loan_no) }}" class="px-4 py-2 btn-outline uppercase" style="font-family: sans-serif !important; " target="_self">
            BACK
        </a>
    </div>
    <div class="box mt-5">
        <div class="sheet">
            <!-- Header -->
            {{-- <div style="width:100%; font-family: dejavusans; border-bottom: 2px solid #000 ; padding: 5px;">

            <!-- Logo -->
            <div style="float:left; width:10%; text-align:left;">
                <img src="{{ public_path('assets/images/sbc-image.jpg') }}" alt="Company Logo"
            style="width:130px; height:130px;">
        </div>

        <!-- Title Section -->
        <div style="float:left; width:90%; text-align:center;">
            <div style="  font-size:30px; font-weight: 800;  text-transform:uppercase; ">
                {{ $bank_name }}
            </div>

            <div style="height:10px; margin-top: 40px;">&nbsp;</div>

            <h4 style="   margin:0;  font-size:18px; font-weight:bold;">
                PAYOUTS CHART
            </h4>
        </div>

        <!-- Clear Float -->
        <div style="clear:both; "></div>

    </div> --}}
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
        <div class="" style="text-align: center; margin-top: 10px; font-size: 16px; font-weight: 600;">
            PAYOUTS CHART
        </div>

        <hr>
    </div>

    <div class="">
        <p style="font-size: 14px; margin-top: 10px;">Printed On : {{ $printed_on ?? '' }}</p>
    </div>
    <div class="" style="margin-top: 10px;">
        <table style="width: 100%; font-size: 16px !important ; padding: 5px; ">

            <tr>
                <th colspan="4" style="color: #a11f1f; font-size: 14px; padding: 5px;">LOAN INFORMATION</th>
            </tr>


            <tr>
                <td style="padding: 5px; font-size:14px;">Disburse Date</td>
                <td style="padding: 5px; font-size:14px;"> {{$disburse_date}}</td>
                <td style="padding: 5px; font-size:14px;"> Loan Amount</td>
                <td style="padding: 5px; font-size:14px;">{{ $loan_amount }}</td>
            </tr>
            <tr>
                <td style="padding: 5px; font-size:14px;">Interest Type</td>
                <td style="padding: 5px; font-size:14px;"> {{ $interest_type }}</td>
                <td style="padding: 5px; font-size:14px;"> Processing Fee</td>
                <td style="padding: 5px; font-size:14px;"> {{ $processing_fee }}</td>
            </tr>
            <tr>
                <td style="padding: 5px; font-size:14px;">Tenure</td>
                <td style="padding: 5px; font-size:14px;"> {{$tenure}}</td>
                <td style="padding: 5px; font-size:14px;"> Stamp Duty Fee</td>
                <td style="padding: 5px; font-size:14px;">{{$stamp_duty_fee}}</td>
            </tr>
            <tr>
                <td style="padding: 5px; font-size:14px;">Interest Rate (Annually)</td>
                <td style="padding: 5px; font-size:14px;"> {{$interest_rate}} % </td>
                <td style="padding: 5px; font-size:14px;"> Insurance Charges</td>
                <td style="padding: 5px; font-size:14px;">{{$insurance_charge}}</td>
            </tr>
            <tr>
                <td style="padding: 5px; font-size:14px;">EMI Count</td>
                <td style="padding: 5px; font-size:14px;">{{$emi_count}}</td>
                <td style="padding: 5px; font-size:14px;"> EMI Payout </td>
                <td style="padding: 5px; font-size:14px;">{{$emi_payout}}</td>
            </tr>
            <tr>
                <td style="padding: 5px; font-size:14px;">Loan In Ratio</td>
                <td style="padding: 5px; font-size:14px; " colspan="3"> {{$loan_in_ratio}}</td>

            </tr>
            <tr>
                <td style="padding: 5px; font-size:14px;">APR Rate</td>
                <td style="padding: 5px; font-size:14px; " colspan="3">{{$apr_rate}}</td>

            </tr>

        </table>
    </div>
    <div class="" style="margin-top:30px;">
        <table style="width: 100%;font-size: 14px !important ; padding: 5px;">

            <tr>
                <th colspan="7" style="color: #a11f1f; font-size: 14px; padding: 5px;">
                    PAYOUTS CHART
                </th>
            </tr>

            <tr>
                <th style="color: #a11f1f; font-size: 14px; padding: 5px;">EMI. NO.</th>
                <th style="color: #a11f1f; font-size: 14px; padding: 5px;"> EMI Date</th>
                <th style="color: #a11f1f; font-size: 14px; padding: 5px;"> EMI Principle</th>
                <th style="color: #a11f1f; font-size: 14px; padding: 5px;"> EMI Interest</th>
                <th style="color: #a11f1f; font-size: 14px; padding: 5px;">Per EMI Charges</th>
                <th style="color: #a11f1f; font-size: 14px; padding: 5px;"> EMI Amount</th>
                <th style="color: #a11f1f; font-size: 14px; padding: 5px;">
                    BalancePrinciple
                </th>
            </tr>
            <tr>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td style="padding:5px; font-weight: 600; font-size: 14px; text-align: left !important;">{{ $loan_amount }}</td>
            </tr>
            @foreach ($payoutSchedule as $row)
            <tr>

                <td style="padding:5px; font-size:14px;">
                    {{ $row['emi_no'] }}
                </td>

                <td style="padding:5px; font-size:14px;">
                    {{ $row['emi_date'] }}
                </td>

                <td style="padding:5px; font-size:14px;">
                    {{ $row['emi_principle'] }}
                </td>

                <td style="padding:5px; font-size:14px;">
                    {{ $row['emi_interest'] }}
                </td>

                <td style="padding:5px; font-size:14px;">
                    {{ $row['per_emi_charges'] }}
                </td>

                <td style="padding:5px; font-size:14px;">
                    {{ $row['emi_amount'] }}
                </td>

                <td style="padding:5px; font-size:14px;">
                    {{ $row['balance_principle'] }}
                </td>
            </tr>
            @endforeach
            <tr>
                <td style="font-weight: 600 ; font-size: 14px; padding: 5px; font-size:14px">Total</td>
                <td style="padding: 5px; font-size:14px"></td>
                <td style="font-weight: 600 ; padding: 5px; font-size:14px">{{$total_emi_principle}}</td>
                <td style="font-weight: 600 ; padding: 5px; font-size:14px">{{$total_emi_interest}}</td>
                <td style="font-weight: 600 ; padding: 5px; font-size:14px">{{$total_per_emi_charges}}</td>
                <td style="font-weight: 600 ; padding: 5px; font-size:14px"> {{ $total_emi_amount }}</td>
                <td style="font-weight: 600 ; padding: 5px; font-size:14px"></td>
            </tr>
        </table>
    </div>


</div>
</div>


@endsection