@extends('layout.main')
@section('content')
<style>
        
        body {

            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }

        .subtitle {
            text-align: center;
            margin-top: 5px;
        }

        .header {
            margin-top: 15px;
            margin-bottom: 10px;
            font-weight: bold;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            height: 22px;
        }

        th {
            text-align: center;
            font-weight: bold;
        }

        td {
            vertical-align: top;
        }
    </style>

<div class="main-inner">
     <h1 class=" uppercase text-lg font-semibold " style="font-family: sans-serif !important; ">
      Proceeding Book
    </h1>
<div class="text-center flex justify-center gap-5 mt-4" >
     <a href=" {{ route('procedingBookPrint') }}"
   class="px-4 py-2 btn-primary uppercase" style="font-family: sans-serif !important; "
   target="_blank">
   <i class="las la-print"></i> Print
</a>
     <a href=" {{ route('proceding-book.pdf') }}"
   class="px-4 py-2 btn-primary uppercase" style="font-family: sans-serif !important; "
   target="_blank">
   <i class="las la-download"></i> Download
</a>
 <a href="
 {{ route('index-from-i') }}
  "
   class="px-4 py-2 btn-outline uppercase" style="font-family: sans-serif !important; "
   target="_self">
   BACK
</a>
</div>
   <div class="box mt-5">
  

    <div class="title" style="font-size:24px;  ">
       {{ $company->company_name }}  &nbsp; <!--र. नं.  {{ $company->cin_no }}-->
       र. नं. १५३
    </div>
    <div class="subtitle" style="font-size:18px; font-weight: bold; ">मासिक / वार्षिक प्रोसिडींग बुक</div>

   

    <table style="width: 100%">
        <thead>
            <tr>
                <th style="width:10%; font-size: 16px;">तारीख वेळ व ठिकाण</th>
                <th style=" width:35%;font-size: 16px;">सभेत हजर असलेल्या सदस्यांची  नावे</th>
                <th style="width:12%; font-size: 16px;">सदस्यांच्या सह्या</th>
                <th style="width:10%; font-size: 16px;">विषय क्रमांक</th>
                <th style="width:45%; font-size: 16px;">विषय</th>
                 <th style="width:10%; font-size: 16px;">ठराव क्र.</th>
                <th style="width:45%; font-size: 16px;">मंजूर झालेला ठराव</th>
                <th style="width:10%; font-size: 16px;">ठरावास अनुकूल सदस्यांची संख्या</th>
                <th style="width:10%; font-size: 16px;">ठरावास प्रतिकूल सदस्यांची संख्या</th>
                <th style="width:10%; font-size: 16px;">शेरा</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-size: 16px;   text-align: center;">१</td>
                <td style="font-size: 16px;  text-align: center;">२</td>
                <td style="font-size: 16px;  text-align: center;">३</td>
                <td style="font-size: 16px;  text-align: center;">४</td>
                <td style="font-size: 16px;  text-align: center;">५</td>
                 <td style="font-size: 16px;  text-align: center;">६ </td>
                <td style="font-size: 16px;  text-align: center;">७</td>
                <td style="font-size: 16px;  text-align: center;">८ </td>
                <td style="font-size: 16px;  text-align: center;">९</td>
                <td style="font-size: 16px;  text-align: center;">१०</td>
            </tr>
            @for ($i = 1; $i <= 40; $i++)
    <tr>
        <td style="padding: 20px 0px;"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
@endfor
        
           
        </tbody>
    </table>


   </div>

</div>
    @endsection