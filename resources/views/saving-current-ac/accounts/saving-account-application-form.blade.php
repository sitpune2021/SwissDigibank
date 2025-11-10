<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account Opening Form</title>
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
</head>

<body>

  <div class="form-container">

    <div class="header">
      <div class="letterhead">
        <!-- Logo -->
        <div class="logo">
          <img src="{{ asset('assets/images/Loan_Management_logo.png') }}" alt="Logo">
        </div>
        <!-- Bank Details -->
        <div class="bank-details">
          <h2 style="margin:0; font-size:16px;">SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA LIMITED</h2>
          <p style="margin:2px 0;"><strong>REG. OFFICE:</strong> SHEGAON, Maharashtra - 110012</p>
          <p style="margin:2px 0;"><strong>BR. OFFICE:</strong> SBC GLOBAL TOWER, CHANDABAI PLOT, SHEGAON, Maharashtra - 444001</p>
          <h3 style="margin:5px 0; font-size:15px;">Account Opening Form For Saving</h3>
        </div>
        <div class="logo"></div>
      </div>
      <hr style="border-top: 3px solid black; background: transparent; margin:5px 0;">
    </div>

    <table>
      <tr>
        <td>Member Folio No :</td>
        <td style=" border: 1px solid #000; vertical-align: top; ">{{$account->members->member_no??''}}</td>
        <td colspan="2"></td>
        <td>Account No : </td>
        <td style=" border: 1px solid #000; vertical-align: top;">{{$account->account_no??''}}</td>
      </tr>
      <tr>
        <td><label style="display:flex; align-items:center;"><input type="checkbox" style="width: 20px; height: 20px;">: RD</label></td>
        <td><label style="display:flex; align-items:center;"><input type="checkbox" style="width: 20px; height: 20px;">: DD</label></td>
        <td><label style="display:flex; align-items:center;"><input type="checkbox" style="width: 20px; height: 20px;">: FD</label></td>
        <td><label style="display:flex; align-items:center;"><input type="checkbox" style="width: 20px; height: 20px;">: MIS</label></td>
        <td><label style="display:flex; align-items:center;"><input type="checkbox" style="width: 20px; height: 20px;" checked>: Saving</label></td>
      </tr>
      <tr>
        <td>Scheme Name :</td>
        <td style=" border: 1px solid #000;vertical-align: top; ">{{$account->scheme->scheme_name??''}} </td>
        <td style="text-align: right;">Interest Rate : </td>
        <td style=" border: 1px solid #000;vertical-align: top; ">{{$account->scheme->annual_int_rate??''}}</td>
        <td style="text-align: right;">Date:</td>
        <td style=" border: 1px solid #000;vertical-align: top; ">{{$account->open_date??''}}</td>
      </tr>
    </table>
    <p class="section-title">Details of Applicants</p>
    <table>
      <tr>
        <td>1.{{$account->members->member_info_first_name??''}} {{$account->members->member_info_middle_name??''}} {{$account->members->member_info_last_name??''}} :</td>
        <td>{{$account->members->member_info_title??''}}</td>
        <td style="text-align: right;">DOB :</td>
        <td style=" border: 1px solid #000;vertical-align: top; ">{{$account->members->member_info_dob??''}}</td>
        <td style="text-align: right;">Gender :</td>
        <td style=" border: 1px solid #000;vertical-align: top; ">{{$account->members->member_info_gender??''}}</td>
      </tr>
      <tr>
    </table>
    <table>
      <td>PAN No: :</td>
      <td style=" border: 1px solid #000;vertical-align: top; ">{{$account->members->kyc->member_kyc_pan_no??''}}</td>
      <td colspan="2"></td>
      <td>Aadhar No :</td>
      <td style=" border: 1px solid #000;vertical-align: top; ">{{$account->members->kyc->member_kyc_aadhaar_no??''}}</td>
      </tr>
    </table>
    <table>
      <tr>
        <td>Present Address (City):</td>
        <td>{{$account->members->address->member_address_city_district??''}}</td>
        <td style="text-align: right;">Pin Code :</td>
        <td>{{$account->members->address->member_address_pincode??''}}</td>
        <td style="text-align: right;">State :</td>
        <td>{{$account->members->address->state->name??''}}</td>
      </tr>
      <tr>
        <td>Permanent Address (City):</td>
        <td>{{$account->members->address->member_perm_address_city??''}}</td>
        <td style="text-align: right;">Pin Code :</td>
        <td>{{$account->members->address->member_address_pincode??''}}</td>
        <td style="text-align: right;">State :</td>
        <td>{{$account->members->address->state->name??''}}</td>
      </tr>
    </table>

    <p class="section-title">Mode of Operations</p>
    <table>
      <tr>
        <td>
          <label style="display:flex; align-items:center;">
            <input
              type="checkbox"
              style="width: 20px; height: 20px;"
              {{ $account->account_holder_type == 'single' ? 'checked' : '' }}> : Self
          </label>
        </td>

        <td>
          <label style="display:flex; align-items:center;">
            <input
              type="checkbox"
              style="width: 20px; height: 20px;"
              {{ $account->account_holder_type == 'joint' ? 'checked' : '' }}> : Jointly
          </label>
        </td>

        <td>
          <label style="display:flex; align-items:center;">
            <input
              type="checkbox"
              style="width: 20px; height: 20px;"
              {{ $account->account_holder_type == 'either' ? 'checked' : '' }}> : Either of Survivor
          </label>
        </td>
      </tr>
    </table>


    <p class="section-title">Interest Payout</p>
    <table>
      <tr>
        <td>
          <label style="display:flex; align-items:center;">
            <input
              type="checkbox"
              style="width: 20px; height: 20px;"
              {{ $account->interest_pay_cycle == 'Monthly' ? 'checked' : '' }}> : Monthly
          </label>
        </td>

        <td>
          <label style="display:flex; align-items:center;">
            <input
              type="checkbox"
              style="width: 20px; height: 20px;"
              {{ $account->interest_pay_cycle == 'Quarterly' ? 'checked' : '' }}> : Quarterly
          </label>
        </td>

        <td>
          <label style="display:flex; align-items:center;">
            <input
              type="checkbox"
              style="width: 20px; height: 20px;"
              {{ $account->interest_pay_cycle == 'Half Yearly' ? 'checked' : '' }}> : Half Yearly
          </label>
        </td>

        <td>
          <label style="display:flex; align-items:center;">
            <input
              type="checkbox"
              style="width: 20px; height: 20px;"
              {{ $account->interest_pay_cycle == 'Yearly' ? 'checked' : '' }}> : Yearly
          </label>
        </td>

        <td>
          <label style="display:flex; align-items:center;">
            <input
              type="checkbox"
              style="width: 20px; height: 20px;"
              {{ !in_array($account->interest_pay_cycle, ['Monthly', 'Quarterly', 'Half Yearly', 'Yearly']) ? 'checked' : '' }}> : End of Term
          </label>
        </td>
      </tr>
    </table>


    <div class="declaration">
      I/We {{ strtoupper(($account->members->member_info_first_name ?? '') . ' ' . ($account->members->member_info_middle_name ?? '') . ' ' . ($account->members->member_info_last_name ?? '')) }}
      are opening an account under SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA
      LIMITED-{{ strtoupper($account->scheme->scheme_name ?? '') }} scheme, the rules related to which/ we have read and understood and accept the rules
      of the scheme and agree to abide by any future amendments/ changes in the scheme. I/ We hereby declare
      that the amount deposited here with is not out of any funds acquired by me/ us borrowing or accepting
      deposits from any other person. I/We declare that I/We are reside in India and am /are not depositing this
      amount as nominee(s) of any non resident. I/We declare that the forth named depositor should be treated
      as the pay purpose of deduction of tax under section 194A of the Income Tax Act, 1961. I/We have gone
      through the financial and other declarations furnished by company and after careful consideration I/ We am
      are making the deposit with the company at my/ our own risk and volition.
    </div>

    <div class="footer">
      <span>Place: ________</span>
      <span>Date: {{ now()->format('d/m/Y') }}</span>
      <span>(Applicant Signature)</span>
    </div>

    <div class="office-use">
      <p style="text-align:center; font-size: 9px">(For Office Use Only)</p>
      <div class="row">
        <label>Date of Receipt of Application &nbsp;: <div style="display: inline-block;"> &nbsp;{{ now()->format('d/m/Y') }}</div></label>
        <label>Introducer Details &nbsp;: <div> &nbsp;</div></label>
      </div>
      <div class="row">
        <label>Deposit/ Account No &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;: &nbsp; <div style="display: inline-block;"> &nbsp;{{$account->account_no??''}}</div></label>
        <label>Date of Maturity &nbsp; &nbsp; &nbsp;: <div style="display: inline-block;"> &nbsp;</div></label>
      </div>

      <div class="signature">
        <p>(Manager’s Signature)</p>
      </div>
    </div>

</body>

</html>