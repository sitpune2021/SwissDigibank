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
        <h1 class="text-lg font-semibold">MIS ACCOUNT - 
            {{ $account->mis_account_no }}
        </h1>
        <div class="text-center flex justify-center gap-5 mt-4">
            <a href="{{ route('misaccount.openingform', $account->id) }}" class="px-4 py-2 btn-primary uppercase"
                target="_blank">
                <i class="las la-download"></i> Download
            </a>
            <a href="{{ route('misaccount.show', $account->id) }}" class="px-4 py-2 btn-outline uppercase"
                target="_self">
                BACk
            </a>
        </div>
        <div class="box mt-5">
          <div class="form-container">
               <div style="width:100%; font-family: dejavusans; border-bottom: 2px solid #000 ; padding: 5px;">

            <!-- Logo -->

            <div style="float:left; width:30%; text-align:left;">
               <img src="{{ asset('assets/images/SBC_Logo_gpg.jpg') }}" alt="logo"
                                style=" width:200px; height:60px;">
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

                <div style="height:10px; margin-top: 40px;">&nbsp;</div>

              
            </div>
 
            <!-- Clear Float -->
            <div style="clear:both; "></div>
 <h4 style="   margin-top:30px;  text-align: center; font-size:18px; font-weight:bold;">
                  Account Opening Form For MIS Account
                </h4>
        </div>
        
        <table>
            <tr>
                <td>Member Folio No :</td>
                <td style=" border: 1px solid #000; vertical-align: top; ">{{$account->members->member_no??''}}</td>
                <td colspan="2"></td>
                <td>Account No : </td>
                <td style=" border: 1px solid #000; vertical-align: top;">{{$account->id ??''}}</td>
            </tr>
            <tr>
                <td><label style="display:flex; align-items:center;"><input type="checkbox" style="width: 20px; height: 20px;">: RD</label></td>
                <td><label style="display:flex; align-items:center;"><input type="checkbox" style="width: 20px; height: 20px;">: DD</label></td>
                <td><label style="display:flex; align-items:center;"><input type="checkbox" style="width: 20px; height: 20px;">: FD</label></td>
                <td><label style="display:flex; align-items:center;"><input type="checkbox" style="width: 20px; height: 20px;" checked>: MIS</label></td>
                <td><label style="display:flex; align-items:center;"><input type="checkbox" style="width: 20px; height: 20px;">: Saving</label></td>
            </tr>
            <tr>
                <td>Scheme Name :</td>
                <td style=" border: 1px solid #000;vertical-align: top; ">{{$account->fdscheme->scheme_name ??''}} </td>
                <td style="text-align: right;">Interest Rate : </td>
                <td style=" border: 1px solid #000;vertical-align: top; ">{{$interestRate??''}}</td>
                <td style="text-align: right;">Date:</td>
                <td style="border: 1px solid #000; vertical-align: top;">
                    {{ $account->open_date ? \Carbon\Carbon::parse($account->open_date)->format('d-m-Y') : '' }}
                </td>
            </tr>
        </table>
        <p class="section-title">Details of Applicants</p>
        <table>
            <tr>
                <td>Name :</td>
                <td>{{$account->member->member_info_title??''}}. {{$account->member->member_info_first_name??''}} {{$account->member->member_info_middle_name??''}} {{$account->member->member_info_last_name??''}}</td>
                <td style="text-align: right;">DOB :</td>
                <td style=" border: 1px solid #000;vertical-align: top; ">{{optional($account->member)->member_info_dob
                     ? \Carbon\Carbon::parse($account->member->member_info_dob)->format('d-m-Y') 
                     : '' }}</td>
                <td style="text-align: right;">Gender :</td>
                <td style=" border: 1px solid #000;vertical-align: top; ">{{$account->member->member_info_gender??''}}</td>
            </tr>
            <tr>
        </table>
        <table>
            <td>PAN No: :</td>
            <td style=" border: 1px solid #000;vertical-align: top; ">{{$account->member->kyc->member_kyc_pan_no??''}}</td>
            <td colspan="2"></td>
            <td>Aadhar No :</td>
            <td style=" border: 1px solid #000;vertical-align: top; ">{{$account->member->kyc->member_kyc_aadhaar_no??''}}</td>
            </tr>
        </table>
        <table>
            <tr>
                <td>Present Address (City):</td>
                <td>{{$account->member->address->member_address_city_district??''}}</td>
                <td style="text-align: right;">Pin Code :</td>
                <td>{{$account->member->address->member_address_pincode??''}}</td>
                <td style="text-align: right;">State :</td>
                <td>{{$account->member->address->state->name??''}}</td>
            </tr>
            <tr>
                <td>Permanent Address (City):</td>
                <td>{{$account->member->address->member_address_city_district??''}}</td>
                <td style="text-align: right;">Pin Code :</td>
                <td>{{$account->member->address->member_address_pincode??''}}</td>
                <td style="text-align: right;">State :</td>
                <td>{{$account->member->address->state->name??''}}</td>
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
                            {{ $account->account_type == 'single' ? 'checked' : '' }}> : Self
                    </label>
                </td>

                <td>
                    <label style="display:flex; align-items:center;">
                        <input
                            type="checkbox"
                            style="width: 20px; height: 20px;"
                            {{ $account->account_type == 'joint' ? 'checked' : '' }}> : Jointly
                    </label>
                </td>

                <td>
                    <label style="display:flex; align-items:center;">
                        <input
                            type="checkbox"
                            style="width: 20px; height: 20px;"
                            {{ $account->account_type == 'either' ? 'checked' : '' }}> : Either of Survivor
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
                            {{ $account->interest_payout_type == 'monthly' ? 'checked' : '' }}> : Monthly
                    </label>
                </td>

                <td>
                    <label style="display:flex; align-items:center;">
                        <input
                            type="checkbox"
                            style="width: 20px; height: 20px;"
                            {{ $account->interest_payout_type == 'Quarterly' ? 'checked' : '' }}> : Quarterly
                    </label>
                </td>

                <td>
                    <label style="display:flex; align-items:center;">
                        <input
                            type="checkbox"
                            style="width: 20px; height: 20px;"
                            {{ $account->interest_payout_type == 'Half Yearly' ? 'checked' : '' }}> : Half Yearly
                    </label>
                </td>

                <td>
                    <label style="display:flex; align-items:center;">
                        <input
                            type="checkbox"
                            style="width: 20px; height: 20px;"
                            {{ $account->interest_payout_type == 'Yearly' ? 'checked' : '' }}> : Yearly
                    </label>
                </td>

                <td>
                    <label style="display:flex; align-items:center;">
                        <input
                            type="checkbox"
                            style="width: 20px; height: 20px;"
                            {{ !in_array($account->interest_payout_type, ['monthly', 'Quarterly', 'Half Yearly', 'Yearly']) ? 'checked' : '' }}> : End of Term
                    </label>
                </td>
            </tr>
        </table>


        <div class="declaration">
            I/We {{ strtoupper(($account->members->member_info_first_name ?? '') . ' ' . ($account->members->member_info_middle_name ?? '') . ' ' . ($account->members->member_info_last_name ?? '')) }}
            are opening an account under SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA
            LIMITED-{{ strtoupper($account->fdscheme->scheme_name ?? '') }} scheme, the rules related to which/ we have read and understood and accept the rules
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
   </div>
        </div>


    </div>
@endsection