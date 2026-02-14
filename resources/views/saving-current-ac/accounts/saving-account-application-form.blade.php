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
  <h1 class="text-lg uppercase font-semibold">Saving Account - {{ $account->account_no }}</h1>
  <div class="text-center flex justify-center gap-5 mt-4">
      <a href="{{ route('account.print', base64_encode($account->id)) }}"
   class="px-4 py-2 btn-primary uppercase"
   target="_blank">
   <i class="las la-print"></i> Print
</a>
    <a href="{{ route('saving.account.opening.pdf', base64_encode($account->id)) }}"
      class="px-4 py-2 btn-primary uppercase" target="_blank">
      <i class="las la-download"></i> Download
    </a>
    <a href="{{ route('accounts.show', base64_encode($account->id)) }}" class="px-4 py-2 btn-outline uppercase"
      target="_self">
      BACk
    </a>


  </div>
  <div class="box mt-5">
    <div class="form-container">

     <div style="width:100%; font-family: dejavusans; border-bottom: 2px solid #000 ; padding: 5px;">

            <!-- Logo -->

            <div style="float:left; width:30%; text-align:left;">
               <img src="{{asset('assets/images/SBC_Logo_gpg.jpg') }}" alt="logo"
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
 <h4 style="   text-align: center; font-size:18px; font-weight:bold;">
               Account Opening Form For Saving
                </h4>
        </div>

      <div style="width:100%; margin-top: 10px; overflow:hidden;">

        <!-- Left block -->
        <div style="float:left; width:55%;">
          <div style="float:left;width:40% ; margin-top: 5px; font-size: 14px;">Member Folio No :</div>
          <div style="float:left; width:50%; height: 25px;  border:1px solid #000;padding: 5px;  vertical-align:top;">
            {{-- {{ $account->members->member_no ?? '' }} --}}
          </div>
        </div>

        <!-- Right block -->
        <div style="float:right; width:45%;">
          <div style="float: left;margin-top: 5px; margin-left: 20px;  width:40%;font-size: 14px;">Account No :</div>
          <div style="float:left; width:50%; border:1px solid #000;padding: 5px;  vertical-align:top;">
            {{ $account->account_no ?? '' }}
          </div>
        </div>

      </div>

      <!-- Clear float -->
      <div style="clear:both;"></div>

      <table>
        <tr>
          <td><label style="display:flex; align-items:center;"><input type="checkbox"
                style="width: 20px; height: 20px;"> : RD</label></td>
          <td><label style="display:flex; align-items:center;"><input type="checkbox"
                style="width: 20px; height: 20px;"> : DD</label></td>
          <td><label style="display:flex; align-items:center;"><input type="checkbox"
                style="width: 20px; height: 20px;"> : FD</label></td>
          <td><label style="display:flex; align-items:center;"><input type="checkbox"
                style="width: 20px; height: 20px;"> : MIS</label></td>
          <td><label style="display:flex; align-items:center;"><input type="checkbox" style="width: 20px; height: 20px;"
                checked>: Saving</label></td>
        </tr>
      </table>
       <div style="width:100%; overflow:hidden; margin-top: 20px;">

  <!-- Scheme Name -->
  <div style="float:left; width:45%;">
    <div style="float:left; width:30%; font-size: 14px; margin-top: 5px;">Scheme Name :</div>
    <div style="float:left; width:70%; padding: 5px; border:1px solid #000; vertical-align:top;">
      {{ $account->scheme->scheme_name ?? '' }}
    </div>
  </div>

  <!-- Interest Rate -->
  <div style="float:left; width:27%;">
    <div style="float:left; width:45%; text-align:right; font-size: 14px; margin-top: 5px;">Interest Rate :</div>
    <div style="float:left; width:55%; border:1px solid #000;padding: 5px; vertical-align:top;">
      {{ $account->scheme->annual_int_rate ?? '' }}
    </div>
  </div>

  <!-- Date -->
  <div style="float:right; width:25%;">
    <div style="float:left; width:30%; text-align:right; font-size: 14px; margin-top: 5px;">Date :</div>
    <div style="float:left; width:70%; border:1px solid #000; padding: 5px; vertical-align:top;">
     {{ \Carbon\Carbon::parse($account->open_date)->format('d-m-Y') }}
    </div>
  </div>

</div>

<!-- Clear floats -->
<div style="clear:both;"></div>

      <p class="section-title">Details of Applicants</p>
<div style="width: 100%; overflow: hidden; font-size: 12px; font-family: Arial, sans-serif;">

  <!-- Name -->
  <div style="float: left; width: 39%; margin-bottom: 5px;font-size: 14px;">
    <p style="float: left;">1. Mr./Mrs./Miss : </p> 
 <p  style=" float: left; margin-left: 5px;">
     {{$account->members->member_info_first_name ?? ''}} 
    {{$account->members->member_info_middle_name ?? ''}} 
    {{$account->members->member_info_last_name ?? ''}}
 </p>
  </div>

  <!-- DOB -->
  <div style="float: left; width: 30%; font-size: 14px; margin-bottom: 5px;">
    <p style="float: left; margin-right: 30px;">DOB :</p>
    <p style=" float: left;border: 1px solid #000; padding: 2px 5px; width: 60%;">
      {{ \Carbon\Carbon::parse($account->members->member_info_dob ?? '')->format('d-m-Y') }}
    </p>
  </div>

  <!-- Gender -->
  <div style="float: left; width: 30%; font-size: 14px; margin-bottom: 5px;">
    <p style="float: left; margin-right: 25px;">Gender :</p>
    <p style=" float: left;border: 1px solid #000; padding: 2px 5px; width: 60%;">
      {{$account->members->member_info_gender ?? ''}}
    </p>
  </div>

</div>
<div style="clear:both;"></div>

      <table>
        <td>PAN No :</td>
        <td style="width: 20%;  border: 1px solid #000;vertical-align: top; ">{{$account->members->kyc->member_kyc_pan_no??''}}</td>
        <td colspan="2"></td>
        <td style="width: 20%;">Aadhar No :</td>
        <td style="width: 30%; border: 1px solid #000;vertical-align: top; ">
          {{ $account->members->kyc->member_kyc_aadhaar_no 
    ? 'XXXX-XXXX-' . substr($account->members->kyc->member_kyc_aadhaar_no, -4) 
    : '' }}

        </td>
        </tr>
      </table>
      <p style="margin-top: 10px;">Present Address</p>
      <table>
        <tr>
          <td> City:</td>
          <td >{{$account->members->address->member_address_city_district??''}}</td>
          <td style="text-align: right;">Pin Code :</td>
          <td>{{$account->members->address->member_address_pincode??''}}</td>
          <td style="text-align: right;">State :</td>
          <td>{{$account->members->address->state->name??''}}</td>
        </tr>
     </table>
      <p style="margin-top: 10px;">Permanent Address </p>
        <table>
        <tr>
          <td>City:</td>
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
              <input type="checkbox" style="width: 20px; height: 20px;" {{ $account->account_holder_type == 'single' ?
              'checked' : '' }}> : Self
            </label>
          </td>

          <td>
            <label style="display:flex; align-items:center;">
              <input type="checkbox" style="width: 20px; height: 20px;" {{ $account->account_holder_type == 'joint' ?
              'checked' : '' }}> : Jointly
            </label>
          </td>

          <td>
            <label style="display:flex; align-items:center;">
              <input type="checkbox" style="width: 20px; height: 20px;" {{ $account->account_holder_type == 'either' ?
              'checked' : '' }}> : Either of Survivor
            </label>
          </td>
        </tr>
      </table>


      <p class="section-title">Interest Payout</p>
      <table>
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
              <input type="checkbox" style="width: 20px; height: 20px;" {{ $account->interest_pay_cycle == 'Half Yearly'
              ? 'checked' : '' }}> : Half Yearly
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
      </table>


      <div class="declaration" style="line-height: 1.5 ; font-size: 16px;">
        I/We {{ strtoupper(($account->members->member_info_first_name ?? '') . ' ' .
        ($account->members->member_info_middle_name ?? '') . ' ' . ($account->members->member_info_last_name ?? '')) }}
        are opening an account under {{--SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA--}}
        LIMITED-{{ strtoupper($account->scheme->scheme_name ?? '') }} scheme, the rules related to which/ we have read
        and understood and accept the rules
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
        <span>Date: {{ now()->format('d-m-Y') }}</span>
        <span>(Applicant Signature)</span>
      </div>

      <div class="office-use">
        <p style="text-align:center; font-size: 10px ; font-weight: 700;">(For Office Use Only)</p>
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
      </div>
    </div>
  </div>


</div>
@endsection