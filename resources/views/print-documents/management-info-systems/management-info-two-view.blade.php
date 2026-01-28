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
     <a href=" {{ route('MisTwo') }}"
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

    <div class="header" style="font-size: 14px;">
       _________________________ र. नं.____________
    </div>
    <div class="header" style="margin-top: 20px; font-size: 14px;">
        प्रगती (एम आय एस) अहवाल माहे__________ अखेर
    </div>

    <!-- MAIN FINANCIAL TABLE -->
    <table style="margin-top: 50px;">
        <tr>
            <th>अ.क्र.</th>
            <th>संस्थेचे नाव</th>
            <th>एकूण सभासद</th>
            <th>वसूल भाग भांडवल</th>
            <th>ठेवी</th>
            <th>दिलेले कर्ज</th>
            <th>लेखा परीक्षण वर्ग</th>
            <th>खेळते भाग भांडवल</th>
            <th>बाहेरील कर्ज</th>
            <th>स्वनिधी</th>
            <th>राखीव निधी</th>
        </tr>

        <tr>
            
             <td >१</td>
            <td >२</td>
            <td >३</td>
            <td >४</td>
            <td >५</td>
             <td>६</td>
            <td>७</td>
            <td>८</td>
            <td>९</td>
            <td>१० </td>
              <td> ११ </td>
        </tr>
  
        <tr>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;" class="text-left" >
               
            </td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
        </tr>
    </table>
  
    <div class="" style="margin-top: 30px ; ">
        पुढे चालू
    </div>
    <!-- PERFORMANCE TABLE -->
    <table style="margin-top: 20px;">
        <tr>
            <th>थकीत रक्कम</th>
            <th>नफा</th>
            <th>तोटा</th>
            <th>सी डी रेषो</th>
            <th>ओव्हर ड्यूज प्रमाण</th>
            <th>सी डी रेषो गुण</th>
            <th>ओव्हर ड्यूज गुण</th>
            <th>नफा/तोटा गुण</th>
            <th>एकूण गुण</th>
            <th>वर्गवारी</th>
            <th>शेरा</th>
        </tr>

        <tr>
            <td style="padding: 20px;" >१२</td>
            <td style="padding: 20px;" >१३ </td>
            <td style="padding: 20px;" >१४</td>
            <td style="padding: 20px;" >१५</td>
            <td style="padding: 20px;">१६</td>
            <td style="padding: 20px;">१७</td>
            <td style="padding: 20px;">१८</td>
            <td style="padding: 20px;">१९</td>
            <td style="padding: 20px;">२०</td>
            <td style="padding: 20px;">२१</td>
            <td style="padding: 20px;">२२</td> 
        </tr>
        <tr>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
        </tr>
        <tr>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
        </tr>
    </table>

    <!-- SIGNATURE -->
    

</div>

</div>
    @endsection