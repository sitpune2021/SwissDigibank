@extends('layout.main')
@section('content')
 <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            /* margin: 20px; */
        }

        .header {
            text-align: center;
            font-weight: bold;
            line-height: 1.5;
        }

        .sub-header {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            font-weight: bold;
        }

        .text-left {
            text-align: left;
        }

        .no-border {
            border: none !important;
        }

        .signature {
            margin-top: 40px;
            width: 100%;
        }

        .signature td {
            border: none;
            text-align: right;
            padding-top: 30px;
        }

        .small-table td, .small-table th {
            padding: 5px;
        }

    </style>

<div class="main-inner">
     <h1 class="text-lg font-semibold uppercase" style="font-family: sans-serif !important; ">
       Management Information System
    </h1>
<div class="text-center flex justify-center gap-5 mt-4" >
      <a href=" {{ route('MisOneFormPrint') }}"
   class="px-4 py-2 btn-primary uppercase" style="font-family: sans-serif !important; "
   target="_blank">
   <i class="las la-print"></i> Print
</a>
     <a href=" {{ route('MisOneForm') }}"
   class="px-4 py-2 btn-primary uppercase" style="font-family: sans-serif !important; "
   target="_blank">
   <i class="las la-download"></i> Download
</a>
 <a href="
 {{ route('mis_index') }}
  "
   class="px-4 py-2 btn-outline uppercase" style="font-family: sans-serif !important; "
   target="_self">
   BACK
</a>
</div>
   <div class="box mt-5">

    <!-- Header -->
    <div class="header">
       {{ $companyName }} यांची माहिती व्यवस्थापन प्रणाली
    </div>
    <div class="header">
        अहवाल माहे ________________अखेर
    </div>

    <!-- Society Info Table -->
    <table style="margin-top: 20px;">
        <tr>
            <th style="width: 20% ; text-align: center;">अ. क्र.</th>
            <th style="width: 20% ; text-align: center;">संस्थेचे नाव</th>
            <th style="width: 20% ; text-align: center;">एकुण सभासद</th>
            <th style="width: 20% ; text-align: center;">वसुल भागभांडवल</th>
            <th style="width: 20% ; text-align: center;">ठेवी</th>
        </tr>
        <tr>
            <td style="width: 20% ; text-align: center;">१</td>
            <td style="width: 20% ; text-align: center;">२</td>
            <td style="width: 20% ; text-align: center;">३</td>
            <td style="width: 20% ; text-align: center;">४</td>
            <td style="width: 20% ; text-align: center;">५</td>
        </tr>
        <tr>
            <td style="width: 20% ; text-align: center; padding: 40px !important;"></td>
            <td style="width: 20% ; text-align: center; padding: 10px !important;" class="text-left"></td>
            <td style="width: 20% ; text-align: center; padding: 10px !important;"></td>
            <td style="width: 20% ; text-align: center; padding: 10px !important;"></td>
            <td style="width: 20% ; text-align: center; padding: 10px !important;"></td>
        </tr>
    </table>

    <!-- Loan Details -->
  <table>
        <tr>
            <th style="width: 20% ; text-align: center;">दिलेले कर्ज</th>
            <th style="width: 20% ; text-align: center;">ले. प. वर्ग</th>
            <th style="width: 20% ; text-align: center;">खेळते भागभांडवल</th>
            <th style="width: 20% ; text-align: center;">बाहेरील कर्ज</th>
            <th style="width: 20% ; text-align: center;">स्वनिधी</th>
        </tr>
        <tr>
            <td style="width: 20% ; text-align: center;">६</td>
            <td style="width: 20% ; text-align: center;">७</td>
            <td style="width: 20% ; text-align: center;">८</td>
            <td style="width: 20% ; text-align: center;">९</td>
            <td style="width: 20% ; text-align: center;">१० </td>
        </tr>
        <tr>
            <td style="width: 20% ; text-align: center; padding: 40px !important;"></td>
            <td style="width: 20% ; text-align: center; padding: 40px !important;" class="text-left"></td>
            <td style="width: 20% ; text-align: center; padding: 40px !important;"></td>
            <td style="width: 20% ; text-align: center; padding: 40px !important;"></td>
            <td style="width: 20% ; text-align: center; padding: 40px !important;"></td>
        </tr>
    </table>


    <!-- Profit / Loss -->
     <table>
        <tr>
            <th style="width: 20% ; text-align: center;">राखिव निधी</th>
            <th style="width: 20% ; text-align: center;">थकित रक्कम</th>
            <th style="width: 20% ; text-align: center;">नफा</th>
            <th style="width: 20% ; text-align: center;">तोटा</th>
            <th style="width: 20% ; text-align: center;">सि.डी.रेषो</th>
        </tr>
        <tr>
            <td style="width: 20% ; text-align: center;"> ११ </td>
            <td style="width: 20% ; text-align: center;">१२</td>
            <td style="width: 20% ; text-align: center;"> १३</td>
            <td style="width: 20% ; text-align: center;">१४ </td>
            <td style="width: 20% ; text-align: center;">१५</td>
        </tr>
        <tr>
            <td style="width: 20% ; text-align: center; padding: 40px !important;"> </td>
            <td style="width: 20% ; text-align: center; padding: 40px !important;" ></td>
            <td style="width: 20% ; text-align: center; padding: 40px !important;"></td>
            <td style="width: 20% ; text-align: center; padding: 40px !important;"></td>
            <td style="width: 20% ; text-align: center; padding: 40px !important;"></td>
        </tr>
    </table>


    <!-- Points Table -->
  <table>
        <tr>
            <th style="width: 20% ; text-align: center;">थकित प्रमाण</th>
            <th style="width: 20% ; text-align: center;">सि.डी.रेषो गुण</th>
            <th style="width: 20% ; text-align: center;">थकित गुण</th>
            <th style="width: 20% ; text-align: center;">नफा तोटा गुण</th>
            <th style="width: 20% ; text-align: center;">एकुण गुण</th>
        </tr>
        <tr>
            <td style="width: 20% ; text-align: center;">१६</td>
            <td style="width: 20% ; text-align: center;">१७</td>
            <td style="width: 20% ; text-align: center;"> १८</td>
            <td style="width: 20% ; text-align: center;">१९ </td>
            <td style="width: 20% ; text-align: center;">२०</td>
        </tr>
        <tr>
            <td style="width: 20% ; text-align: center;padding: 40px !important;"></td>
            <td style="width: 20% ; text-align: center;padding: 40px !important;" ></td>
            <td style="width: 20% ; text-align: center;padding: 40px !important;"></td>
            <td style="width: 20% ; text-align: center;padding: 40px !important;"></td>
            <td style="width: 20% ; text-align: center;padding: 40px !important;"></td>
        </tr>
    </table>


    <!-- Classification -->
     <table style="width: 40%">
        <tr>
            <th style="width: 20% ; text-align: center;">वर्गवारी</th>
            <th style="width: 20% ; text-align: center;">शेरा</th>
           
        </tr>
        <tr>
            <td style="width: 20% ; text-align: center;"> २१</td>
            <td style="width: 20% ; text-align: center;">२२ </td>
            
        </tr>
        <tr>
            <td style="width: 20% ; text-align: center; padding: 40px !important;"></td>
            <td style="width: 20% ; text-align: center; padding: 40px !important;" class="text-left"></td>
          
        </tr>
    </table>



    <!-- Signature -->
    
<div class=" " style="text-align: right; padding:5px 30px;">
        <h5>{{ $companyName }}</h5>
    </div>

</div>

</div>
    @endsection