<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Account Opening Form</title>

  <style>
    @page {
      size: A4;
      margin: 15mm;
    }

    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;
      color: #000;
    }

    .text-center {
      text-align: center;
    }

    .text-right {
      text-align: right;
    }

    .bold {
      font-weight: bold;
    }

    .underline {
      border-bottom: 1px solid #000;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    td {
      padding: 4px;
      vertical-align: top;
    }

    .box {
      border: 1px solid #000;
      padding: 4px;
      min-height: 16px;
    }

    .checkbox {
      display: inline-block;
      width: 14px;
      height: 14px;
      border: 1px solid #000;
      text-align: center;
      line-height: 12px;
      font-weight: bold;
    }

    .checked {
      background: #000;
      color: #fff;
    }

    .section-title {
      font-weight: bold;
      margin-top: 8px;
      text-decoration: underline;
    }

    .small {
      font-size: 10px;
      line-height: 1.4;
    }

    .signature-line {
      border-top: 1px solid #000;
      width: 200px;
      text-align: center;
      padding-top: 3px;
    }
  </style>
</head>

<body>
  <div class="form-container">

    <div class="header">
      <div style="width:100%; font-family: dejavusans; border-bottom: 1px solid #000 ; padding: 5px;">

        <!-- Logo -->

        <div style="float:left; width:30%; text-align:left;  margin-top: 0 !important;">
          <img src="{{public_path('assets/images/SBC_Logo_gpg.jpg') }}" alt="logo" style=" width:auto; height:50px;">
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
        {{-- <div style="float:left; width:70%; text-align:center;">
          <div style="  font-size:30px; font-weight: 800;  text-transform:uppercase; "> --}}
            {{-- SBC Global --}}
            {{-- </div> --}}

          {{-- <div style="height:10px; margin-top: 40px;">&nbsp;</div> --}}


          {{--
        </div> --}}

        <!-- Clear Float -->
        <div style="clear:both; "></div>
        <h4 style=" text-align: center; font-size:18px; margin: 0 !important; font-weight:bold;">
          Account Opening Form For Saving
        </h4>
      </div>
      {{--
      <hr style="border-top: 3px solid black; background: transparent; margin:5px 0;"> --}}
    </div>

    <table style="margin-top: 10px">
      <tr>
        <td>Member Folio No :</td>
        <td style=" border: 1px solid #000; vertical-align: top; width: 20%; ">
          {{-- {{$account->members->member_no??''}} --}}

        </td>
        <td colspan="2"></td>
        <td>Account No : </td>
        <td style=" border: 1px solid #000; vertical-align: top;">{{$account->account_no ?? ''}}</td>
      </tr>
    </table>
    <table style="margin-top: 5px;">
      <tr>
        <td><label style="display:flex; align-items:center;">
            <input type="checkbox" style="width: 24px; height: 16px; ">: RD</label></td>
        <td><label style="display:flex; align-items:center;"><input type="checkbox" style="width: 20px; height: 16px;">:
            DD</label></td>
        <td><label style="display:flex; align-items:center;"><input type="checkbox" style="width: 20px; height: 16px;">:
            FD</label></td>
        <td><label style="display:flex; align-items:center;"><input type="checkbox" style="width: 20px; height: 16px;">:
            MIS</label></td>
        <td><label style="display:flex; align-items:center;"><input type="checkbox" style="width: 20px; height: 16px;"
              checked>: Saving</label></td>
      </tr>
    </table>
    <table style="margin-top: 5px;">
      <tr>
        <td>Scheme Name :</td>
        <td style=" border: 1px solid #000;vertical-align: top; ">{{$account->scheme->scheme_name ?? ''}} </td>
        <td style="text-align: right;">Interest Rate : </td>
        <td style=" border: 1px solid #000;vertical-align: top; ">{{$account->scheme->annual_int_rate ?? ''}}</td>
        <td style="text-align: right;">Date:</td>
        <td style=" border: 1px solid #000;vertical-align: top; "> {{
  \Carbon\Carbon::parse($account->open_date)->format('d-m-Y') }}

        </td>
      </tr>
    </table>
    <p class="section-title">Details of Applicants</p>
    {{-- <table style="width: 100%">
      <tr>
        <td>1.Mr./Mrs./Miss:</td>
        <td>
          {{$account->members->member_info_first_name??''}} {{$account->members->member_info_middle_name??''}}
          {{$account->members->member_info_last_name??''}} </td>

        <td style="text-align: right;">DOB :</td>
        <td style=" width: 30%; border: 1px solid #000; ">{{$account->members->member_info_dob??''}}</td>
        <td style="text-align: right;">Gender :</td>
        <td style=" border: 1px solid #000; ">{{$account->members->member_info_gender??''}}</td>
      </tr>
      <tr>
    </table> --}}
    <div style="width: 100%;  margin-bottom: 5px;">
      <div style="width: 15%;  margin-top: 3px; float: left; font-weight: bold;">1.Mr./Mrs./Miss:</div>
      <div style="width: 25%;  margin-top: 3px; float: left;">
        {{ $account->members->member_info_first_name ?? '' }}
        {{ $account->members->member_info_middle_name ?? '' }}
        {{ $account->members->member_info_last_name ?? '' }}
      </div>

      <div style="width: 10%; float: left; margin-top: 3px; text-align: right; font-weight: bold;">DOB :</div>
      <div style="width: 15%; float: left; margin-left: 2px; border: 1px solid #000; padding: 2px;">
        {{ \Carbon\Carbon::parse($account->members->member_info_dob ?? '')->format('d-m-Y') ?? '' }}
      </div>

      <div style="width: 10%; float: left; margin-top: 3px; text-align: right; font-weight: bold;">Gender :</div>
      <div style="width: 8%; text-align: center; float: left; margin-left: 2px;  border: 1px solid #000; padding: 2px;">
        {{ $account->members->member_info_gender ?? '' }}
      </div>

      <div style="clear: both;"></div>
    </div>

    <table style="margin-top: 10px">
      <td>PAN No: :</td>
      <td style=" border: 1px solid #000;vertical-align: top; ">{{$account->members->kyc->member_kyc_pan_no ?? ''}}</td>
      <td colspan="2"></td>
      <td>Aadhar No :</td>
      <td style=" border: 1px solid #000;vertical-align: top; ">
        @php
          $aadhaar = optional(optional($account->members)->kyc)->member_kyc_aadhaar_no;
        @endphp
        {{ $aadhaar ? 'XXXX-XXXX-' . substr($aadhaar, -4) : '' }}
        {{-- {{ $account->members->kyc->member_kyc_aadhaar_no
        ? 'XXXX-XXXX-' . substr($account->members->kyc->member_kyc_aadhaar_no, -4)
        : '' }} --}}
      </td>
      </tr>
    </table>
    <p style="margin-top: 10px;font-weight: 600;">Present Address</p>
    <table>
      <tr>
        <td> City:</td>
        <td>{{$account->members->address->member_address_city_district ?? ''}}</td>
        <td style="text-align: right;">Pin Code :</td>
        <td>{{$account->members->address->member_address_pincode ?? ''}}</td>
        <td style="text-align: right;">State :</td>
        <td>{{$account->members->address->state->name ?? ''}}</td>
      </tr>
    </table>
    <p style="margin-top: 10px;font-weight: 600;">Permanent Address </p>
    <table>
      <tr>
        <td>City:</td>
        <td>{{$account->members->address->member_perm_address_city ?? ''}}</td>
        <td style="text-align: right;">Pin Code :</td>
        <td>{{$account->members->address->member_address_pincode ?? ''}}</td>
        <td style="text-align: right;">State :</td>
        <td>{{$account->members->address->state->name ?? ''}}</td>
      </tr>
    </table>

    <p class="section-title">Mode of Operations</p>
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <!-- SELF -->
        <td width="33.33%">
          <div style="float:left; width:20px;">
            <input type="checkbox" style="width:18px; height:18px;" {{ $account->account_holder_type == 'single' ?
  'checked' : '' }}>
          </div>
          <div style="float:left; margin-left:6px; margin-top: 5px;">
            : Self
          </div>
          <div style="clear:both;"></div>
        </td>

        <!-- JOINT -->
        <td width="33.33%">
          <div style="float:left; width:20px;">
            <input type="checkbox" style="width:18px; height:18px;" {{ $account->account_holder_type == 'joint' ?
  'checked' : '' }}>
          </div>
          <div style="float:left; margin-left:6px ;  margin-top: 5px;">
            : Jointly
          </div>
          <div style="clear:both;"></div>
        </td>

        <!-- EITHER -->
        <td width="33.33%">
          <div style="float:left; width:20px;">
            <input type="checkbox" style="width:18px; height:18px;" {{ $account->account_holder_type == 'either' ?
  'checked' : '' }}>
          </div>
          <div style="float:left; margin-left:6px;  margin-top: 5px;">
            : Either of Survivor
          </div>
          <div style="clear:both;"></div>
        </td>
      </tr>
    </table>



    <div style="clear: both;"></div>
    <p class="section-title">Interest Payout</p>
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <!-- Monthly -->
        <td width="20%">
          <div style="float:left; width:20px;">
            <input type="checkbox" style="width:18px; height:18px;" {{ $account->interest_pay_cycle == 'Monthly' ?
  'checked' : '' }}>
          </div>
          <div style="float:left; margin-left:6px; margin-top: 5px;">
            : Monthly
          </div>
          <div style="clear:both;"></div>
        </td>

        <!-- Quarterly -->
        <td width="20%">
          <div style="float:left; width:20px;">
            <input type="checkbox" style="width:18px; height:18px;" {{ $account->interest_pay_cycle == 'Quarterly' ?
  'checked' : '' }}>
          </div>
          <div style="float:left; margin-left:6px; margin-top: 5px;">
            : Quarterly
          </div>
          <div style="clear:both;"></div>
        </td>

        <!-- Half Yearly -->
        <td width="20%">
          <div style="float:left; width:20px;">
            <input type="checkbox" style="width:18px; height:18px;" {{ $account->interest_pay_cycle == 'Half Yearly' ?
  'checked' : '' }}>
          </div>
          <div style="float:left; margin-left:6px;  margin-top: 5px;">
            : Half Yearly
          </div>
          <div style="clear:both;"></div>
        </td>

        <!-- Yearly -->
        <td width="20%">
          <div style="float:left; width:20px;">
            <input type="checkbox" style="width:18px; height:18px;" {{ $account->interest_pay_cycle == 'Yearly' ?
  'checked' : '' }}>
          </div>
          <div style="float:left; margin-left:6px;  margin-top: 5px;">
            : Yearly
          </div>
          <div style="clear:both;"></div>
        </td>

        <!-- End of Term -->
        <td width="20%">
          <div style="float:left; width:20px;">
            <input type="checkbox" style="width:18px; height:18px;" {{ !in_array(
  $account->interest_pay_cycle,
  ['Monthly', 'Quarterly', 'Half Yearly', 'Yearly']
) ? 'checked' : '' }}>
          </div>
          <div style="float:left; margin-left:6px;  margin-top: 5px;">
            : End of Term
          </div>
          <div style="clear:both;"></div>
        </td>
      </tr>
    </table>

    {{-- <table>
      <tr>
        <td>
          <label style="display:flex; align-items:center;">
            <input type="checkbox" style="width: 20px; height: 20px;" {{ $account->interest_pay_cycle == 'Monthly' ?
            'checked' : '' }}> : Monthly
          </label>
        </td>

        <td>
          <label style="display:flex; align-items:center;">
            <input type="checkbox" style="width: 20px; height: 20px;" {{ $account->interest_pay_cycle == 'Quarterly' ?
            'checked' : '' }}> : Quarterly
          </label>
        </td>

        <td>
          <label style="display:flex; align-items:center;">
            <input type="checkbox" style="width: 20px; height: 20px;" {{ $account->interest_pay_cycle == 'Half Yearly' ?
            'checked' : '' }}> : Half Yearly
          </label>
        </td>

        <td>
          <label style="display:flex; align-items:center;">
            <input type="checkbox" style="width: 20px; height: 20px;" {{ $account->interest_pay_cycle == 'Yearly' ?
            'checked' : '' }}> : Yearly
          </label>
        </td>

        <td>
          <label style="display:flex; align-items:center;">
            <input type="checkbox" style="width: 20px; height: 20px;" {{ !in_array($account->interest_pay_cycle,
            ['Monthly', 'Quarterly', 'Half Yearly', 'Yearly']) ? 'checked' : '' }}> : End of Term
          </label>
        </td>
      </tr>
    </table> --}}
    <div style="clear: both;"></div>

    <div class="declaration" style="line-height: 2; margin-top: 10px;">
      I/We {{ strtoupper(($account->members->member_info_first_name ?? '') . ' ' .
  ($account->members->member_info_middle_name ?? '') . ' ' . ($account->members->member_info_last_name ?? '')) }}
      are opening an account under
      {{-- SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA --}}
      {{-- bank name here --}}
      LIMITED-{{ strtoupper($account->scheme->scheme_name ?? '') }} scheme, the rules related to which/ we have read and
      understood and accept the rules
      of the scheme and agree to abide by any future amendments/ changes in the scheme. I/ We hereby declare
      that the amount deposited here with is not out of any funds acquired by me/ us borrowing or accepting
      deposits from any other person. I/We declare that I/We are reside in India and am /are not depositing this
      amount as nominee(s) of any non resident. I/We declare that the forth named depositor should be treated
      as the pay purpose of deduction of tax under section 194A of the Income Tax Act, 1961. I/We have gone
      through the financial and other declarations furnished by company and after careful consideration I/ We am
      are making the deposit with the company at my/ our own risk and volition.
    </div>

    <div class="footer"
      style="width:100%; margin-top:40px; padding-bottom: 15px; font-size:12px; border-bottom: 1px solid #000;">

      <div style="float:left; width:33.33%; font-weight: 600; text-align:left;">
        Place: ________
      </div>

      <div style="float:left; width:33.33%; font-weight: 600; text-align:center;">
        Date: {{ now()->format('d-m-Y') }}
      </div>

      <div style="float:left; width:33.33%;font-weight: 600; text-align:right;">
        (Applicant Signature)
      </div>

      <div style="clear:both;"></div>
    </div>
    {{-- <div class="footer" style="width:100%; margin-top:40px; font-size:12px; border-bottom: 1px solid #000;">

      <div style="float:left; width:33.33%; text-align:left;">
        Place: ________
      </div>

      <div style="float:left; width:33.33%; text-align:center;">
        Date: {{ now()->format('d/m/Y') }}
      </div>

      <div style="float:left; width:33.33%; text-align:right;">
        (Applicant Signature)
      </div>

      <div style="clear:both;"></div>
    </div> --}}


    <div class="office-use" style="width:100%; margin-top:25px; font-size:11px;">

      <p style="text-align:center; font-size:10px; font-weight:600; margin-bottom:10px;">
        (For Office Use Only)
      </p>

      <!-- Row 1 -->
      <div style="width:100%;">

        <div style="float:left; width:60%; font-size:14px; text-align:left;">
          Date of Receipt of Application :
          <span>{{ now()->format('d-m-Y') }}</span>
        </div>

        <div style="float:left; width:40%; font-size:14px; text-align:left;">
          Introducer Details :
          <span>&nbsp;</span>
        </div>

        <div style="clear:both;"></div>
      </div>

      <!-- Row 2 -->
      <div style="width:100%; margin-top:8px;">

        <div style="float:left; width:60%;  font-size:14px; text-align:left;">
          Deposit / Account No :
          <span>{{ $account->account_no ?? '' }}</span>
        </div>

        <div style="float:left; width:40%; font-size:14px; text-align:left;">
          Date of Maturity :
          <span>&nbsp;</span>
        </div>

        <div style="clear:both;"></div>
      </div>

      <!-- Signature -->
      <div style="width:100%; margin-top:30px; font-size:14px; font-weight: 600; text-align:right;">

        (Manager’s Signature)
      </div>

    </div>

    {{-- <div class="office-use">
      <p style="text-align:center; font-size: 10px; font-weight: 600;">(For Office Use Only)</p>
      <div class="row">
        <label>Date of Receipt of Application &nbsp;: <div style="display: inline-block;"> &nbsp;{{
            now()->format('d-m-Y') }}</div></label>
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