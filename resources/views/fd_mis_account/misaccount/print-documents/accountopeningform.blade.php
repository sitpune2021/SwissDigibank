<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Opening Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* background: #f8f8f8; */
            margin: 0;
            padding: 8px;
        }

        .form-container {
            /* background: #fff; */
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
</head>

<body>

    <div class="form-container">

        <div style="width:100%; font-family: dejavusans; border-bottom: 2px solid #000 ; padding: 5px;">

            <!-- Logo -->
            <div style="float:left; width:50%; text-align:left;">
                <img src="{{ public_path('assets/images/SBC_Logo_gpg.jpg') }}" alt="Company Logo"   style="height: 50px; width: auto;">
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
                Account Opening Form For MIS Account
            </h4>
        </div>
        <table>
            <tr>
                <td style="width: 25%; ">Member Folio No :</td>
                <td style=" border: 1px solid #000; width: 25%;  ">
                    {{-- {{$account->members->member_no??''}} --}}

                </td>
                <td colspan="2"></td>
                <td style="width: 25%; padding-left: 20px;">Account No : </td>
                <td style=" border: 1px solid #000; width: 25%">

                    {{$account->mis_account_no ??''}}
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <label style="float:left;">
                        <input type="checkbox" style="width:24px; height:24px;">
                    </label>

                    <p style="float:left; margin-top:3px;">RD</p>

                    <div style="clear:both;"></div>
                </td>
                <td>
                    <label style="float:left;">
                        <input type="checkbox" style="width:24px; height:24px;">

                    </label>
                    <p style="float:left; margin-top:3px;">DD</p>
                    <div style="clear:both;"></div>
                </td>
                <td>
                    <label style="float:left;">
                        <input type="checkbox" style="width:24px; height:24px;" >

                    </label>
                    <p style="float:left; margin-top:3px;"> FD</p>
                    <div style="clear:both;"></div>
                </td>
                <td>
                    <label style="float:left;">
                        <input type="checkbox" style="width:24px; height:24px;" checked>
                    </label>
                    <p style="float:left; margin-top:3px;">MIS</p>
                    <div style="clear:both;"></div>
                </td>
                <td>
                    <label style="float:left;">
                        <input type="checkbox" style="width:24px; height:24px;">
                    </label>
                    <p style="float:left; margin-top:3px;">Saving</p>
                    <div style="clear:both;"></div>
                </td>
            </tr>
        </table>

        <div style="width: 100%; font-size: 12px; ">

            <!-- Scheme Name -->
            <div style="float: left; margin-right: 8px;">
                Scheme Name :
            </div>

            <div style="float: left;  border: 1px solid #000; padding: 2px 6px; min-width: 200px; margin-right: 16px;">
                {{ $account->fdscheme->scheme_name ?? '' }}
            </div>

            <!-- Interest Rate -->
            <div style="float: left; margin-right: 8px;">
                Interest Rate :
            </div>

            <div
                style="float: left; text-align: center; border: 1px solid #000; padding: 2px 6px; min-width: 60px; margin-right: 16px;">
                {{ $interestRate ?? '' }}
            </div>

            <!-- Date -->
            <div style="float: left; margin-right: 8px;">
                Date :
            </div>

            <div style="float: left; text-align: center; border: 1px solid #000; padding: 2px 6px; min-width: 80px;">
                {{ $account->open_date
                ? \Carbon\Carbon::parse($account->open_date)->format('d-m-Y')
                : '' }}
            </div>

            <!-- Clear floats -->
            <div style="clear: both;"></div>

        </div>


        <p class="section-title" style="">Details of Applicants</p>
        <div style="width: 90%; font-size: 12px;">

            <!-- Name -->
            <div style="float: left; margin-right: 6px; font-weight: 800;">
                1 Mr./Mrs./Miss :
            </div>

            <div style="float: left; margin-right: 16px; width: 30%;">
                {{ $account->member->member_info_title ?? '' }}.
                {{ $account->member->member_info_first_name ?? '' }}
                {{ $account->member->member_info_middle_name ?? '' }}
                {{ $account->member->member_info_last_name ?? '' }}
            </div>

            <!-- DOB -->
            <div style="float: left; margin-left: 26px;margin-right: 10px; margin-top: 2px;">
                DOB :
            </div>

            <div
                style="float: left; text-align: center; border: 1px solid #000; padding: 2px 6px; min-width: 90px; margin-right: 16px;">
                {{ optional($account->member)->member_info_dob
                ? \Carbon\Carbon::parse($account->member->member_info_dob)->format('d-m-Y')
                : '' }}
            </div>

            <!-- Gender -->
            <div style="float: left; margin-right: 6px;">
                Gender :
            </div>

            <div style="float: left; text-align: center; border: 1px solid #000; padding: 2px 6px; min-width: 60px;">
                {{ $account->member->member_info_gender ?? '' }}
            </div>

            <!-- Clear floats -->
            <div style="clear: both;"></div>

        </div>



        <table style="">
            <tr>
                <td>PAN No :</td>
                <td style=" border: 1px solid #000; text-align: left; width: 25%; ">
                    {{$account->member->kyc->member_kyc_pan_no??''}}
                </td>
                <td colspan=""></td>
                <td style="">Aadhar No :</td>
                <td style=" border: 1px solid #000;width: 25%; ">
                    {{-- {{$account->member->kyc->member_kyc_aadhaar_no??''}} --}}
                    {{
                    $account->member->kyc->member_kyc_aadhaar_no
                    ? 'XXXX XXXX ' . substr($account->member->kyc->member_kyc_aadhaar_no, -4)
                    : ''
                    }}
                </td>
            </tr>
        </table>
        <div class="" style=" font-weight: 700;">Present Address</div>
        <div style="width: 90%; font-size: 12px;">

            <!-- Row 1 : City -->
            <div style="width: 100%; margin-top: 10px;">

                <div style="float: left; font-weight: 700; margin-right: 6px; width: 16.66%;">
                    City :
                </div>

                <div style="float: left; margin-right: 16px; width: 16.66%;">
                    {{ $account->member->address->member_address_city_district ?? '' }}
                </div>

                <div style="float: left; font-weight: 700; text-align: right; margin-right: 6px; width: 16.66%;">
                    Pin Code :
                </div>

                <div style="float: left; margin-right: 16px; width: 16.66%;">
                    {{ $account->member->address->member_address_pincode ?? '' }}
                </div>

                <div style="float: left; font-weight: 700; text-align: right; margin-right: 6px; width: 16.66%;">
                    State :
                </div>

                <div style="float: left; width: 16.66%;">
                    {{ $account->member->address->state->name ?? '' }}
                </div>

                <div style="clear: both;"></div>
            </div>
            <div class="" style="margin-top: 10px; font-weight: 700; font-weight: 700;">
                 Permanent Address 
            </div>

            <!-- Row 2 : Permanent Address -->
            <div style="width: 100%; margin-top: 10px;">

                <div style="float: left; font-weight: 700; margin-right: 6px; width: 16.66%;">
                 City :
                </div>

                <div style="float: left; margin-right: 16px; width: 16.66%;">
                    {{ $account->member->address->member_address_city_district ?? '' }}
                </div>

                <div style="float: left; font-weight: 700; text-align: right; margin-right: 6px;width: 16.66%;">
                    Pin Code :
                </div>

                <div style="float: left; margin-right: 16px;width: 16.66%;">
                    {{ $account->member->address->member_address_pincode ?? '' }}
                </div>

                <div style="float: left; font-weight: 700; text-align: right; margin-right: 6px;width: 16.66%;">
                    State :
                </div>

                <div style="float: left;width: 16.66%;">
                    {{ $account->member->address->state->name ?? '' }}
                </div>

                <div style="clear: both;"></div>
            </div>

        </div>
         <div style="width: 90%; font-size: 12px;">

         
            <div class="" style="; font-weight: 700; font-weight: 700;">
                 Permanent Address 
            </div>

            <!-- Row 2 : Permanent Address -->
            <div style="width: 100%;">

                <div style="float: left; font-weight: 700; margin-right: 6px; width: 16.66%;">
                 City :
                </div>

                <div style="float: left; margin-right: 16px; width: 16.66%;">
                    {{ $account->member->address->member_address_city_district ?? '' }}
                </div>

                <div style="float: left; font-weight: 700; text-align: right; margin-right: 6px;width: 16.66%;">
                    Pin Code :
                </div>

                <div style="float: left; margin-right: 16px;width: 16.66%;">
                    {{ $account->member->address->member_address_pincode ?? '' }}
                </div>

                <div style="float: left; font-weight: 700; text-align: right; margin-right: 6px;width: 16.66%;">
                    State :
                </div>

                <div style="float: left;width: 16.66%;">
                    {{ $account->member->address->state->name ?? '' }}
                </div>

                <div style="clear: both;"></div>
            </div>

        </div>
  <div style="width: 100%; font-size: 12px;">
            <!-- Row 2 : Permanent Address -->
            <div style="width: 100%; margin-top: 10px;">

                <div style="float: left; font-weight: 700; margin-right: 6px; width: 16.66%;">
                Nominee :
                </div>

                <div style="float: left; margin-right: 16px; width: 16.66%;">
                    {{-- {{ $account->member->address->member_address_city_district ?? '' }} --}}
                </div>

                <div style="float: left; font-weight: 700; text-align: right; margin-right: 6px;width: 16.66%;">
                   Relationship :
                </div>

                <div style="float: left; margin-right: 16px;width: 16.66%;">
                    {{-- {{ $account->member->address->member_address_pincode ?? '' }} --}}
                </div>

                <div style="float: left; font-weight: 700; text-align: right; margin-right: 6px;width: 16.66%;">
                   Address :
                </div>

                <div style="float: left;width: 16.66%;">
                    {{-- {{ $account->member->address->state->name ?? '' }} --}}
                </div>

                <div style="clear: both;"></div>
            </div>

        </div>
        <div style="margin-top: 25px;">
            (In case Nominee Is Minor) Guardian Name  : 
        </div>


        <p class="section-title">Mode of Operations</p>
     <table style="width:100%; border-collapse:collapse;">
  <tr>

    <!-- Self -->
    <td style="width:33.33%; vertical-align:top;">
      <div style="width:100%;">
        <div style="float:left; width:25%;">
          <input type="checkbox"
            style="width:18px; height:18px;"
            {{ $account->account_type == 'single' ? 'checked' : '' }}>
        </div>
        <div style="float:left; width:75%; padding-top:2px;">
          : Self
        </div>
        <div style="clear:both;"></div>
      </div>
    </td>

    <!-- Joint -->
    <td style="width:33.33%; vertical-align:top;">
      <div style="width:100%;">
        <div style="float:left; width:25%;">
          <input type="checkbox"
            style="width:18px; height:18px;"
            {{ $account->account_type == 'joint' ? 'checked' : '' }}>
        </div>
        <div style="float:left; width:75%; padding-top:2px;">
          : Jointly
        </div>
        <div style="clear:both;"></div>
      </div>
    </td>

    <!-- Either -->
    <td style="width:33.33%; vertical-align:top;">
      <div style="width:100%;">
        <div style="float:left; width:25%;">
          <input type="checkbox"
            style="width:18px; height:18px;"
            {{ $account->account_type == 'either' ? 'checked' : '' }}>
        </div>
        <div style="float:left; width:75%; padding-top:2px;">
          : Either of Survivor
        </div>
        <div style="clear:both;"></div>
      </div>
    </td>

  </tr>
</table>

        {{-- <table>
            <tr>
                <td>
                    <label style="display:flex; align-items:center;">
                        <input type="checkbox" style="width: 20px; height: 20px;" {{ $account->account_type == 'single'
                        ? 'checked' : '' }}> : Self
                    </label>
                </td>

                <td>
                    <label style="display:flex; align-items:center;">
                        <input type="checkbox" style="width: 20px; height: 20px;" {{ $account->account_type == 'joint' ?
                        'checked' : '' }}> : Jointly
                    </label>
                </td>

                <td>
                    <label style="display:flex; align-items:center;">
                        <input type="checkbox" style="width: 20px; height: 20px;" {{ $account->account_type == 'either'
                        ? 'checked' : '' }}> : Either of Survivor
                    </label>
                </td>
            </tr>
        </table> --}}


        <p class="section-title">Interest Payout</p>
        <table style="width:100%; border-collapse:collapse;">
  <tr>

    <!-- Monthly -->
    <td style="width:20%; vertical-align:top;">
      <div style="width:100%;">
        <div style="float:left; width:25%;">
          <input type="checkbox" style="width:18px; height:18px;"
            {{ $account->interest_payout_type == 'monthly' ? 'checked' : '' }}>
        </div>
        <div style="float:left; width:75%; padding-top:2px;">
          : Monthly
        </div>
        <div style="clear:both;"></div>
      </div>
    </td>

    <!-- Quarterly -->
    <td style="width:20%; vertical-align:top;">
      <div style="width:100%;">
        <div style="float:left; width:25%;">
          <input type="checkbox" style="width:18px; height:18px;"
            {{ $account->interest_payout_type == 'Quarterly' ? 'checked' : '' }}>
        </div>
        <div style="float:left; width:75%; padding-top:2px;">
          : Quarterly
        </div>
        <div style="clear:both;"></div>
      </div>
    </td>

    <!-- Half Yearly -->
    <td style="width:20%; vertical-align:top;">
      <div style="width:100%;">
        <div style="float:left; width:25%;">
          <input type="checkbox" style="width:18px; height:18px;"
            {{ $account->interest_payout_type == 'Half Yearly' ? 'checked' : '' }}>
        </div>
        <div style="float:left; width:75%; padding-top:2px;">
          : Half Yearly
        </div>
        <div style="clear:both;"></div>
      </div>
    </td>

    <!-- Yearly -->
    <td style="width:20%; vertical-align:top;">
      <div style="width:100%;">
        <div style="float:left; width:25%;">
          <input type="checkbox" style="width:18px; height:18px;"
            {{ $account->interest_payout_type == 'Yearly' ? 'checked' : '' }}>
        </div>
        <div style="float:left; width:75%; padding-top:2px;">
          : Yearly
        </div>
        <div style="clear:both;"></div>
      </div>
    </td>

    <!-- End of Term -->
    <td style="width:20%; vertical-align:top;">
      <div style="width:100%;">
        <div style="float:left; width:25%;">
          <input type="checkbox" style="width:18px; height:18px;"
            {{ !in_array($account->interest_payout_type, ['monthly','Quarterly','Half Yearly','Yearly']) ? 'checked' : '' }}>
        </div>
        <div style="float:left; width:75%; padding-top:2px;">
          : End of Term
        </div>
        <div style="clear:both;"></div>
      </div>
    </td>

  </tr>
</table>

        {{-- <table>
            <tr>
                <td>
                    <label style="display:flex; align-items:center;">
                        <input type="checkbox" style="width: 20px; height: 20px;" {{ $account->interest_payout_type ==
                        'monthly' ? 'checked' : '' }}> : Monthly
                    </label>
                </td>

                <td>
                    <label style="display:flex; align-items:center;">
                        <input type="checkbox" style="width: 20px; height: 20px;" {{ $account->interest_payout_type ==
                        'Quarterly' ? 'checked' : '' }}> : Quarterly
                    </label>
                </td>

                <td>
                    <label style="display:flex; align-items:center;">
                        <input type="checkbox" style="width: 20px; height: 20px;" {{ $account->interest_payout_type ==
                        'Half Yearly' ? 'checked' : '' }}> : Half Yearly
                    </label>
                </td>

                <td>
                    <label style="display:flex; align-items:center;">
                        <input type="checkbox" style="width: 20px; height: 20px;" {{ $account->interest_payout_type ==
                        'Yearly' ? 'checked' : '' }}> : Yearly
                    </label>
                </td>

                <td>
                    <label style="display:flex; align-items:center;">
                        <input type="checkbox" style="width: 20px; height: 20px;" {{
                            !in_array($account->interest_payout_type, ['monthly', 'Quarterly', 'Half Yearly', 'Yearly'])
                        ? 'checked' : '' }}> : End of Term
                    </label>
                </td>
            </tr>
        </table> --}}
<div style="width:100%; font-size:12px; margin-top:12px;">

  <!-- RD -->
  <div style="float:left; width:22%; margin-right:1%;">
    <span style="display:inline-block; width:45%; font-weight:600;">Term of RD</span>
    <span style="display:inline-block; width:50%; border:1px solid #000; height:18px;"></span>
  </div>

  <!-- FD -->
  <div style="float:left; width:30%; margin-right:1%;">
    <span style="display:inline-block; width:40%; font-weight:600;">Term of MIS</span>
    <span style="display:inline-block; width:55%; border:1px solid #000; height:18px;">

    </span>
  </div>

  <!-- Installment -->
  <div style="float:left; width:24%; margin-right:1%;">
    <span style="display:inline-block;width:35%; font-weight:600;">Installment</span>
    <span style="display:inline-block; margin-left: 10px; width:50%; border:1px solid #000; height:18px;"></span>
  </div>

  <!-- Amount -->
  <div style="float:left; width:24%;">
    <span style="display:inline-block; width:35%; font-weight:600;">Amount</span>
    <span style="display:inline-block; width:60%; border:1px solid #000; height:18px;"></span>
  </div>

  <div style="clear:both;"></div>
</div>




        <div class="declaration" style="line-height: 1.5; ">
           I/We {{ strtoupper(($account->member_name ?? '') ) }} are opening an account under
            {{-- SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA LIMITED --}}
            -
            {{ strtoupper($account->fdscheme->scheme_name ?? '') }} scheme, the rules related to which/ we have read and
            understood and accept the rules of the scheme and agree to abide by any future amendments/ changes in the
            scheme. I/ We hereby declare that the amount deposited here with is not out of any funds acquired by me/us
            borrowing or accepting deposits from any other person. I/We declare that I/We are reside in India and am
            /are not depositing this amount as nominee(s) of any non resident. I/We declare that the forth named
            depositor should be treated as the pay purpose of deduction of tax under section 194A of the Income Tax Act,
            1961. I/We have gone through the financial and other declarations furnished by company and after careful
            consideration I/ We am are making the deposit with the company at my/ our own risk and volition.
        </div>

        <div class="footer" style="width:100%;  font-size:12px;">

  <div style="float:left; width:33.33%;">
    Place: ________
  </div>

  <div style="float:left; width:33.33%; text-align:center;">
    Date: {{ now()->format('d-m-Y') }}
  </div>

  <div style="float:left; width:33.33%; text-align:right;">
    (Applicant Signature)
  </div>

  <div style="clear:both;"></div>
</div>

        {{-- <div class="footer">
            <span>Place: ________</span>
            <span>Date: {{ now()->format('d/m/Y') }}</span>
            <span>(Applicant Signature)</span>
        </div> --}}

        <div class="office-use" style="width:100%; font-size:9px; margin-top:15px;">

  <p style="text-align:center; font-weight:600; font-size: 12px; margin-bottom:8px;">
    (For Office Use Only)
  </p>

  <!-- Row 1 -->
  <div style="width:100%; margin-bottom:6px;">
    <div style="float:left; width:60%;font-size: 14px; font-weight: 600;">
      Date of Receipt of Application : {{ now()->format('d-m-Y') }}
    </div>

    <div style="float:left; width:40%;font-size: 14px; font-weight: 600;">
      Introducer Details :
    </div>

    <div style="clear:both;"></div>
  </div>

  <!-- Row 2 -->
  <div style="width:100%; margin-bottom:12px;">
    <div style="float:left; width:60%; font-size: 12px;font-weight: 600;">
      Deposit / Account No : {{ $account->mis_account_no ?? '' }}
    </div>

    <div style="float:left; width:40%;font-size: 14px; font-weight: 600;">
      Date of Maturity :{{ $account->maturity_date ?
                        \Carbon\Carbon::parse($account->maturity_date)->format('d-m-Y') : '' }}

    </div>

    <div style="clear:both;"></div>
  </div>

  <!-- Signature -->
  <div style="width:100%; text-align:right; margin-top:25px;font-size: 14px;  font-weight: 600;">
    (Manager’s Signature)
  </div>

</div>

        {{-- <div class="office-use">
            <p style="text-align:center; font-size: 9px">(For Office Use Only)</p>
            <div class="row">
                <label>Date of Receipt of Application &nbsp;: <div style="display: inline-block;"> &nbsp;{{
                        now()->format('d/m/Y') }}</div></label>
                <label>Introducer Details &nbsp;: <div> &nbsp;</div></label>
            </div>
            <div class="row">
                <label>Deposit/ Account No &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;: &nbsp; <div
                        style="display: inline-block;"> &nbsp;{{$account->account_no??''}}</div></label>
                <label>Date of Maturity &nbsp; &nbsp; &nbsp;: <div style="display: inline-block;"> &nbsp;</div></label>
            </div>

            <div class="signature">
                <p>(Manager’s Signature)</p>
            </div>
        </div> --}}
    </div>
</body>

</html>