@extends('layout.main')
@section('content')
<div class="main-inner">
    <div class="mb-5 flex justify-center gap-2 flex-col md:flex-row lg:flex-row">
 
        <a href="{{ route('mortgage_emi.receipt.print', [$loan->id,$emiNo]) }}" class="btn-primary  px-6 py-2 flex justify-center  text-sm uppercase" onclick="printWindow(this.href); return false;">
          <i class="las la-print"></i>
            Print
        </a>
        <script>
           function printWindow(url){
           let w = window.open(url);
           w.onload = function(){
           w.print();
             };
          }
        </script>
        <a href="{{ route('mortgage_loan.emi_receipt.pdf', [$loan->id, $emiNo]) }}" target="_blank"
            class="btn-primary  px-6 py-2 flex justify-center  text-sm uppercase">
            <i class="las la-download"></i>
            download
        </a>
        <a href="" class="btn-primary  px-6 py-2 flex justify-center  text-sm uppercase">
            Back
        </a>
    </div>
    <div class="box mt-5" style="padding:20px;">
 
        <div style="width:100%; font-family: dejavusans;  padding: 5px;">
 
            <!-- Logo -->
            <div style="float:left; text-align:left;">
                <img src="{{ asset('assets/images/SBC_Logo_gpg.jpg') }}" style="width:auto; height:50px;">
            </div>
 
            <!-- Title Section -->
            <div style="float: right; width:80%; text-align:center;">
                <div style="  font-size:30px; font-weight: 800;  text-transform:uppercase; ">
                    {{-- {{ $bank_name }} --}}
                </div>
                <div style="  font-size:12px; font-weight: 800;  text-transform:uppercase; ">
                    {{-- {{ $address }} --}}
                </div>
 
                <div style="height:10px; margin-top: 40px;">&nbsp;</div>
 
 
            </div>
 
            <!-- Clear Float -->
            <div style="clear:both; "></div>
            <h5 style="margin-top:10px ; text-align: center; ">EMI RECEIPT</h5>
 
        </div>
 
        {{-- <div style="text-align:center;">
 
 
            <img src="{{ asset('assets/images/SBC_Logo_gpg.jpg') }}" style="height:70px;">
 
            <h2 style="margin:5px 0;">
                SHRI SAMARTH NAGRI SAHAKARI PAT SANSTHA LIMITED
            </h2>
 
            <div>SHEGAON Maharashtra - 110012</div>
 
 
            <h3 style="margin-top:10px;">EMI RECEIPT</h3>
 
        </div> --}}
 
        <hr>
 
        <table width="100%" style="border: none; ">
            <tr>
                <td>
                    Printed on : {{ now()->format('d-m-Y') }}
                </td>
                <td style="text-align:right;">
                    Branch : {{ $loan->branch->name ?? 'HEAD OFFICE' }}
                </td>
            </tr>
        </table>
 
        <hr>
 
        <table width="100%" style="margin-top:10px;">
            <tr>
                <td><strong>EMI No :{{ $emiNo }}</strong>
                </td>
                <td style="text-align:right;">
                    <strong>EMI Date :</strong>
                    {{ \Carbon\Carbon::parse($transactions->first()->transaction_date)->format('d-m-Y') }}
                </td>
            </tr>
        </table>
 
        <br>
 
        <table width="100%">
            <tr>
                <td width="30%">Member</td>
                <td>:
                    {{ $loan->member->member_no ?? '' }}
                    -
                    {{ $loan->member->member_info_first_name . ' ' . $loan->member->member_info_last_name }}
                </td>
            </tr>
 
            <tr>
                <td>Account No</td>
                <td>:
                    {{ str_pad($loan->account_no ?? $loan->id, 6, '0', STR_PAD_LEFT) }}
                </td>
 
            </tr>
 
            <tr>
                <td>Principal Amount</td>
                <td>:
                    ₹ {{ number_format($emiData['principal'], 2) }}
                </td>
            </tr>
 
            <tr>
                <td>Interest Amount</td>
                <td>:
                    ₹ {{ number_format($emiData['interest'], 2) }}
                </td>
            </tr>
 
            <tr>
                <td>EMI Amount</td>
                <td>:
                    ₹ {{ number_format($emiData['emi_amount'], 2) }}
                </td>
            </tr>
 
            <tr>
                <td>Balance Principal Amount</td>
                <td>:
                    ₹ {{ number_format($emiData['balance_principal'], 2) }}
                </td>
            </tr>
 
            <tr>
                <td>Status</td>
                <td>: PAID</td>
            </tr>
        </table>
 
        <br><br>
 
        <table width="100%">
            <tr>
                <td style="text-align:left;">(Approved by)</td>
                <td style="text-align:center;">(Verified by)</td>
                <td style="text-align:right;">(Posted by)</td>
            </tr>
        </table>
 
        <hr>
 
        <div style="text-align:center; font-size:12px; margin-top: 20px;">
            Thank you for your business!
        </div>
 
    </div>
</div>
@endsection
 