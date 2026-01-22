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
     <h1 class="text-lg font-semibold">FD ACCOUNT - {{ $account->fd_no }}</h1>
<div class="text-center flex justify-center gap-5 mt-4" >
     <a href="{{ route('fd.opening.form', $account->id) }}"
   class="px-4 py-2 btn-primary uppercase"
   target="_blank">
   <i class="las la-download"></i> Download
</a>
 <a href="{{ route('fd-mis-schemes.fd_show', $account->id) }}"
   class="px-4 py-2 btn-outline uppercase"
   target="_self">
   BACk
</a>
</div>
    <div class="box mt-5">
        <div class="form-container">

        <div style="width:100%; font-family: dejavusans; border-bottom: 2px solid #000 ; padding: 5px;">

            <!-- Logo -->
            <div style="float:left; width:30%; text-align:left;">
               <img src="{{ asset('assets/images/SBC_Logo_gpg.jpg') }}" alt="Company Logo"
                    style="width:auto; height:50px;">
                {{-- @if($logo) --}}
                     {{-- <img src="{{ asset('storage/' . $logo->image_path) }}"
         alt="logo"
         style=" width:auto; height:50px;"> --}}
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

                <div style="height:10px; margin-top: 40px;">&nbsp;</div>

               
            </div>

            <!-- Clear Float -->
            <div style="clear:both; "></div>
             <h4 style=" text-align: center;  margin:0;  font-size:18px; font-weight:bold;">
                    Account Opening Form For FD
                </h4>

        </div>
        <table>
            <tr>
                <td style="width: 25%; ">Member Folio No :</td>
                <td style=" border: 1px solid #000; width: 25%;  ">{{$account->members->member_no??''}}</td>
                <td colspan="2"></td>
                <td style="width: 25%; padding-left: 20px;">Account No : </td>
                <td style=" border: 1px solid #000; width: 25%">

                    {{ $account->fd_no }}
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <label style="float:left;">
                        <input type="checkbox" style="width:24px; height:24px;">
                    </label>

                    <p style="float:left; margin-left:10px;">RD</p>

                    <div style="clear:both;"></div>
                </td>
                <td>
                    <label style="float:left;">
                        <input type="checkbox" style="width:24px; height:24px;">

                    </label>
                    <p style="float:left; margin-left:10px;">DD</p>
                    <div style="clear:both;"></div>
                </td>
                <td>
                    <label style="float:left;">
                        <input type="checkbox" style="width:24px; height:24px;" checked>

                    </label>
                    <p style="float:left; margin-left:10px;"> FD</p>
                    <div style="clear:both;"></div>
                </td>
                <td>
                    <label style="float:left;">
                        <input type="checkbox" style="width:24px; height:24px;">
                    </label>
                    <p style="float:left; margin-left:10px;">MIS</p>
                    <div style="clear:both;"></div>
                </td>
                <td>
                    <label style="float:left;">
                        <input type="checkbox" style="width:24px; height:24px;">
                    </label>
                    <p style="float:left; margin-left:10px;">Saving</p>
                    <div style="clear:both;"></div>
                </td>
            </tr>
        </table>

        <div style="width: 100%; font-size: 12px; margin-top: 12px;">

            <!-- Scheme Name -->
            <p style="float: left; margin-right: 8px; ">
                Scheme Name :
            </p>

            <p style="float: left;  border: 1px solid #000; padding: 2px 6px; min-width: 200px; margin-right: 16px;">
                {{ $account->fdscheme->scheme_name ?? '' }}
            </p>

            <!-- Interest Rate -->
            <p style="float: left; margin-right: 8px;">
                Interest Rate :
            </p>

            <p
                style="float: left; text-align: center; border: 1px solid #000; padding: 2px 6px; min-width: 60px; margin-right: 16px;">
                {{ $interestRate ?? '' }}
            </p>

            <!-- Date -->
            <p style="float: left; margin-right: 8px;">
                Date :
            </p>

            <p style="float: left; text-align: center; border: 1px solid #000; padding: 2px 6px; min-width: 23%;">
                {{ $account->open_date
                ? \Carbon\Carbon::parse($account->open_date)->format('d-m-Y')
                : '' }}
            </p>

            <!-- Clear floats -->
            <div style="clear: both;"></div>

        </div>


        <p class="section-title" style="">Details of Applicants</p>
        <div style="width: 100%; font-size: 12px;">

            <!-- Name -->
            <p style="float: left; margin-right: 6px; font-weight: 500;">
                1 Mr./Mrs./Miss :
            </p>

            <p style="float: left; margin-right: 16px; width: 30%;">
                {{ $account->member->member_info_title ?? '' }}.
                {{ $account->member->member_info_first_name ?? '' }}
                {{ $account->member->member_info_middle_name ?? '' }}
                {{ $account->member->member_info_last_name ?? '' }}
            </p>

            <!-- DOB -->
            <p style="float: left; margin-left: 26px;margin-right: 10px; margin-top: 2px;">
                DOB :
            </p>

            <p
                style="float: left; text-align: center; border: 1px solid #000; padding: 2px 6px; min-width: 90px; margin-right: 16px;">
                {{ optional($account->member)->member_info_dob
                ? \Carbon\Carbon::parse($account->member->member_info_dob)->format('d-m-Y')
                : '' }}
            </p>

            <!-- Gender -->
            <p style="float: left; margin-right: 6px;">
                Gender :
            </p>

            <p style="float: left; text-align: center; border: 1px solid #000; padding: 2px 6px; min-width: 16%;">
                {{ $account->member->member_info_gender ?? '' }}
            </p>

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
        <p class="" style=" font-weight: 700; margin-top: 10px;">Present Address</p>
        <table style="width:100%; font-size:12px; border-collapse:collapse;">

  <!-- Row 1 : City / Pin / State -->
  <tr>
    <td style="width:16.66%; font-weight:700;">City :</td>
    <td style="width:16.66%;">
      {{ $account->member->address->member_address_city_district ?? '' }}
    </td>

    <td style="width:16.66%; font-weight:700; text-align:right;">Pin Code :</td>
    <td style="width:16.66%;">
      {{ $account->member->address->member_address_pincode ?? '' }}
    </td>

    <td style="width:16.66%; font-weight:700; text-align:right;">State :</td>
    <td style="width:16.66%;">
      {{ $account->member->address->state->name ?? '' }}
    </td>
  </tr>

  <!-- Spacer -->
  <tr>
    <td colspan="6" style="height:10px;"></td>
  </tr>

  <!-- Permanent Address Heading -->
  <tr>
    <td colspan="6" style="font-weight:700;">
      Permanent Address
    </td>
  </tr>

  <!-- Spacer -->
  <tr>
    <td colspan="6" style="height:10px;"></td>
  </tr>

  <!-- Row 2 : Permanent Address -->
  <tr>
    <td style="width:16.66%; font-weight:700;">City :</td>
    <td style="width:16.66%;">
      {{ $account->member->address->member_address_city_district ?? '' }}
    </td>

    <td style="width:16.66%; font-weight:700; text-align:right;">Pin Code :</td>
    <td style="width:16.66%;">
      {{ $account->member->address->member_address_pincode ?? '' }}
    </td>

    <td style="width:16.66%; font-weight:700; text-align:right;">State :</td>
    <td style="width:16.66%;">
      {{ $account->member->address->state->name ?? '' }}
    </td>
  </tr>

</table>

         
  <div style="width: 100%; font-size: 12px;">
          <table style="width:100%; font-size:12px; border-collapse:collapse; margin-top:10px;">
  <tr>

    <td style="width:16.66%; font-weight:700;">
      Nominee :
    </td>
    <td style="width:16.66%;">
      {{-- Nominee Name --}}
    </td>

    <td style="width:16.66%; font-weight:700; text-align:right;">
      Relationship :
    </td>
    <td style="width:16.66%;">
      {{-- Relationship --}}
    </td>

    <td style="width:16.66%; font-weight:700; text-align:right;">
      Address :
    </td>
    <td style="width:16.66%;">
      {{-- Nominee Address --}}
    </td>

  </tr>
</table>


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
<div style="width: 100%; font-size: 12px; margin-top: 12px;">


            <!-- Interest Rate -->
            <p style="float: left; margin-right: 8px; margin-top:3px;  font-size: 14px;">
               Term of RD:

            </p>

            <p
                style="float: left;  border: 1px solid #000; padding: 12px 6px; min-width: 90px; margin-right: 16px; font-size: 1px;">
                {{-- {{ $interestRate ?? '' }} --}}
            </p>
  <p style="float: left; margin-right: 8px; margin-top:3px; font-size: 14px;">
                Term of FD:
            </p>

            <p
                style="float: left;  border: 1px solid #000; padding: 12px 6px; min-width: 90px; margin-right: 16px ; font-size: 12px;">
                {{-- {{ $interestRate ?? '' }} --}}
            </p>
  <p style="float: left; margin-right: 8px; margin-top:3px;  font-size: 14px;">
                Installment:

            </p>

            <p
                style="float: left;  border: 1px solid #000; padding:12px 6px; min-width: 90px; margin-right: 16px; font-size: 12px;">
                {{-- {{ $interestRate ?? '' }} --}}
            </p>
  <p style="float: left; margin-right: 8px; margin-top:3px;  font-size: 14px;">
              Amount :
            </p>

            <p
                style="float: left;  border: 1px solid #000; padding: 12px 6px; min-width: 90px; margin-right: 16px; font-size: 12px;">
                {{-- {{ $interestRate ?? '' }} --}}
            </p>

            

            <!-- Clear floats -->
            <div style="clear: both;"></div>

        </div>

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


        <div class="declaration" style="">
            I/We {{ strtoupper(($account->member->member_info_first_name?? '') . ' ' .
            ($account->member->member_info_middle_name ?? '') . ' ' . ($account->member->member_info_last_name ?? ''))
            }}
            are opening an account under
             {{-- SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA LIMITED--}}
             {{-- bank name --}}
            - {{ strtoupper($account->fdscheme->scheme_name ?? '') }} scheme, the rules related to which/ we have
            read and understood and accept the rules
            of the scheme and agree to abide by any future amendments/ changes in the scheme. I/ We hereby declare
            that the amount deposited here with is not out of any funds acquired by me/ us borrowing or accepting
            deposits from any other person. I/We declare that I/We are reside in India and am /are not depositing this
            amount as nominee(s) of any non resident. I/We declare that the forth named depositor should be treated
            as the pay purpose of deduction of tax under section 194A of the Income Tax Act, 1961. I/We have gone
            through the financial and other declarations furnished by company and after careful consideration I/ We am
            are making the deposit with the company at my/ our own risk and volition.
        </div>

        <div class="footer" style="width:100%;  font-size:12px;">

  <div style="float:left; width:33.33%;font-weight: 600;">
    Place: ________
  </div>

  <div style="float:left; width:33.33%;font-weight: 600; text-align:center;">
    Date: {{ now()->format('d-m-Y') }}
  </div>

  <div style="float:left; width:33.33%; font-weight: 600; text-align:right;">
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
    <div style="float:left; width:60%;font-size: 12px; font-weight: 600;">
      Date of Receipt of Application : {{ now()->format('d-m-Y') }}
    </div>

    <div style="float:left; width:40%;font-size: 12px; font-weight: 600;">
      Introducer Details :
    </div>

    <div style="clear:both;"></div>
  </div>

  <!-- Row 2 -->
  <div style="width:100%; margin-bottom:12px;">
    <div style="float:left; width:60%; font-size: 12px; font-weight: 600;">
      Deposit / Account No : {{ $account->fd_no ?? '' }}
    </div>

    <div style="float:left; width:40%;font-size: 12px; font-weight: 600;">
    

      Date of Maturity :  {{ $account->maturity_date ? \Carbon\Carbon::parse($account->maturity_date)->format('d-m-Y') : '' }}
    </div>

    <div style="clear:both;"></div>
  </div>

  <!-- Signature -->
  <div style="width:100%; text-align:right; font-weight: 600; margin-top:25px;font-size: 12px;">
    (Manager’s Signature)
  </div>

</div>
</div>
    </div>


</div>
    @endsection