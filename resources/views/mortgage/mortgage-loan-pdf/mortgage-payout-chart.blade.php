<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Payout Chart</title>
    <style>
        body {

            font-family: "mukta", Arial, sans-serif;

            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #111;
        }

        .sheet {
            width: 190mm;
            margin: 0 auto;
        }

        table {
            width: 100%;
            
        }

        table,
        td,
        th {
            /*  border: 1px solid #000; */
            border-collapse: collapse;
            border: 2px solid #000 !important;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 0.6px;
        }

        h3 {
            text-align: center;
            margin: 10px 0;
        }
    </style>
</head>

<body>
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
            PAYOUTS CHART
        </div>
      
        <hr>
    </div>

        <div class="">
            <p style="font-size: 14px;">Printed On : {{ $printed_on }}</p>
        </div>
        <div class="">
            <table style="font-size: 12px !important ; padding: 5px; ">

                <tr>
                    <th colspan="4" style="color: #a11f1f; padding: 5px;">LOAN INFORMATION</th>
                </tr>


                <tr>
                    <td style="padding: 5px;">Disburse Date</td>
                    <td style="padding: 5px;"> {{$disburse_date}}</td>
                    <td style="padding: 5px;"> Loan Amount</td>
                    <td style="padding: 5px;">{{ $loan_amount }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Interest Type</td>
                    <td style="padding: 5px;"> {{ $interest_type }}</td>
                    <td style="padding: 5px;"> Processing Fee</td>
                    <td style="padding: 5px;"> {{ $processing_fee }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Tenure</td>
                    <td style="padding: 5px;"> {{$tenure}}</td>
                    <td style="padding: 5px;"> Stamp Duty Fee</td>
                    <td style="padding: 5px;">{{$stamp_duty_fee}}</td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Interest Rate (Annually)</td>
                    <td style="padding: 5px;"> {{$interest_rate}} % </td>
                    <td style="padding: 5px;"> Insurance Charges</td>
                    <td style="padding: 5px;">{{$insurance_charge}}</td>
                </tr>
                <tr>
                    <td style="padding: 5px;">EMI Count</td>
                    <td style="padding: 5px;">{{$emi_count}}</td>
                    <td style="padding: 5px;"> EMI Payout </td>
                    <td style="padding: 5px;">{{$emi_payout}}</td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Loan In Ratio</td>
                    <td style="padding: 5px; " colspan="3"> {{$loan_in_ratio}}</td>

                </tr>
                 <tr>
                    <td style="padding: 5px;">APR Rate</td>
                    <td style="padding: 5px; " colspan="3">{{$apr_rate}}</td>

                </tr>

            </table>
        </div>
        <div class="" style="margin-top:30px;">
            <table style="font-size: 12px !important ; padding: 5px;">

                <tr>
                    <th colspan="7" style="color: #a11f1f; padding: 5px;">
                        PAYOUTS CHART
                    </th>
                </tr>

                <tr>
                    <th style="color: #a11f1f; padding: 5px;">EMI. NO.</th>
                    <th style="color: #a11f1f; padding: 5px;"> EMI Date</th>
                    <th style="color: #a11f1f; padding: 5px;"> EMI Principle</th>
                    <th style="color: #a11f1f; padding: 5px;"> EMI Interest</th>
                    <th style="color: #a11f1f; padding: 5px;">Per EMI Charges</th>
                    <th style="color: #a11f1f; padding: 5px;"> EMI Amount</th>
                    <th style="color: #a11f1f; padding: 5px;">
                        BalancePrinciple
                    </th>
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
                    <td style="font-weight: 800 ; font-size: 14px; padding: 5px;">Total</td>
                    <td style="padding: 5px;"></td>
                    <td style="font-weight: 800 ; padding: 5px;">{{$total_emi_principle}}</td>
                    <td  style="font-weight: 800 ; padding: 5px;" >{{$total_emi_interest}}</td>
                    <td  style="font-weight: 800 ; padding: 5px;" >{{$total_per_emi_charges}}</td>
                    <td  style="font-weight: 800 ; padding: 5px;" > {{ $total_emi_amount }}</td>
                    <td  style="font-weight: 800 ; padding: 5px;" ></td>
                </tr>
            </table>
        </div>


    </div>
</body>

</html>