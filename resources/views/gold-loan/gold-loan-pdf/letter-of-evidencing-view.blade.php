@extends('layout.main')
@section('content')
  <style>
        /* *{
            font-size: 14px !important;
        } */
        body {
            font-family: Arial, Helvetica, sans-serif;
            /* background:#eee; */
            
        }

        .page{
        width:1000px;
        margin:20px auto;
        background:#fff;
        padding:20px;
     /* border:1px solid #ccc; */
    }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        td,
        th {
            border: 1px solid #333;
            padding: 6px;
            vertical-align: top;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }

        .subtitle {
            font-size: 14px;
            text-align: center;
        }

        .section {
            background: #e6a2a2;
            font-weight: bold;
            text-align: center;
        }

        .logo {
            width: 90px;
        }

        .no-border td {
            border: none;
        }

        .small {
            font-size: 12px;
        }

        @media print {
            body {
                background: #fff;
            }

            .page {
                border: none;
                margin: 0;
                width: 100%;
            }
        }
    </style>

<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h3 class="text-lg uppercase font-semibold">
                  LETTER OF EVIDENCING
            </h3>
        </div>
    </div>
      <div class="text-center flex justify-center gap-5 mt-4">
        <a href="{{ route('loan.letter-of-evidencing-print.pdf',  $loan_id) }} " class="px-4 py-2 btn-primary uppercase"
            style="font-family: sans-serif !important; " target="_blank">
            <i class="las la-print"></i> Print
        </a>
        <a href="{{ route('loan.letter-of-evidencing.pdf',  $loan_id) }} " class="px-4 py-2 btn-primary uppercase"
            style="font-family: sans-serif !important; " target="_blank">
            <i class="las la-download"></i> Download
        </a>
        <a href=" {{ route('gold-loan.applications.view', $loan_id) }}" class="px-4 py-2 btn-outline uppercase" style="font-family: sans-serif !important; " target="_self">
            BACK
        </a>
    </div>
    <div class="box mt-5" style="padding:20px; ">

<div class="page">

        <!-- HEADER -->
        <div style="width:100%; font-family: dejavusans; border-bottom: 1px solid #000 ; padding: 5px;">
            <!-- Clear Float -->
            <div style="clear:both; "></div>
            <h4 style=" text-align: center; font-size:18px; margin: 0 !important; font-weight:bold;">
                LETTER EVIDENCING EXECUTION OF DOCUMENTS
            </h4>
        </div>

        <br>

        <div class="" style="text-align: left">
            We, undersigned confirm that the all the documents and the agreements after understanding the same were
            executed by us in respect of the loan availed from (bank name (static))
        </div>

        <h4
            style=" text-align: center; font-size:18px; margin-top:20px !important; font-weight:bold; text-decoration: underline;">
            Description of Documents
        </h4>
        <table style="margin-top: 10px;">
            <tr>
                <td colspan="" class="center bold">S.No </td>
                <td colspan="" class="center bold">Document Name</td>
                <td colspan="" class="center bold">Name of executor</td>
                <td colspan="" class="center bold">Capacity</td>
                <td colspan="" class="center bold">Signature</td>
            </tr>
            <tr>
                <td colspan="" style="width: 5px;" class="">1 </td>
                <td colspan="" style="width: 25px;"class="">Sanction Letter</td>
                <td colspan="" style="width: 25px;"class="">
                    Applicant & Guarantor
                   
                    <ol type="1">
                        <li>Applicant: shreepad page(static)</li>
                    </ol>
                </td>
                <td colspan="" style="width: 15px;" class=""></td>
                <td rowspan="5" style="width: 15px;" class=""></td>
            </tr>
            <tr>
                <td colspan="" class="">2</td>
                <td colspan="" class="">Loan Agreement</td>
                <td colspan="" class="">
                   Applicant: shreepad page(static)
                  
                </td>
                <td colspan="" class=""></td>
                
            </tr>
             <tr>
                <td colspan="" class="">3 </td>
                <td colspan="" class="">	End-Use Undertaking</td>
                <td colspan="" class="">
                   Applicant: shreepad page(static)
                </td>
                <td colspan="" class=""></td>
               
            </tr>

             <tr>
                <td colspan="" class="">4 </td>
                <td colspan="" class="">Deed of Guarantee</td>
                <td colspan="" class="">
                   Guarantor
                </td>
                <td colspan="" class=""></td>
               
            </tr>
             <tr>
                <td colspan="" class="">5 </td>
                <td colspan="" class="">List of PDC and Security Cheque</td>
                <td colspan="" class="">
                   	Applicant, Co-Borrower and Guarantor
                   
                    <ol type="1">
                        <li>Applicant: shreepad page(static)</li>
                    </ol>
                </td>
                <td colspan="" class=""></td>
                
            </tr>
             <tr>
                <td colspan="" class="">6 </td>
                <td colspan="" class="">Consent form form – Download KYC from CKYC</td>
                <td colspan="" class="">
                    (Applicant & Guarantor)
                   
                    <ol type="1">
                        <li>Applicant: shreepad page(static)</li>
                    </ol>
                </td>
                <td colspan="" class=""></td>
                <td  class=""></td>
            </tr>


        </table>


        <div class="" style="margin-top: 25px; font-weight: 700;">
            Solemnly affirmed at (Maharashtra(static)) on this (14 February 2026 (static)).
        </div>
         <div class="" style="margin-top: 25px;font-weight: 700;">
            Name of Borrower: (shreepad page(static))
        </div>
        
        <table style="margin-top: 45px; border: none;">
             <tr style=" border: none;">
                <td style=" border: none;">
                    ____________________________  </td>
                <td style=" border: none;text-align: center;">
                    __________________
                </td>
            </tr>
            <tr style=" border: none;">
                <td style=" border: none;">
                   
                    Designation / Name of applicant
                </td>
                <td style=" border: none; text-align: center;">
                   
                    Guarantor

                </td>
            </tr>
        </table>

        <div class="" style="margin-top: 35px;">
           <p>
             Date: 14-02-2026(static)
           </p>
<p>
    Place: Maharashtra(static)
</p>
        </div>
    </div>

    </div>
     

    @endsection