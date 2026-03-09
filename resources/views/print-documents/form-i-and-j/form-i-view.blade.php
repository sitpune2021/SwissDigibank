@extends('layout.main')
@section('content')
<style>
        body {
            font-family: marathi;
            font-size: 12px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }
    </style>

<div class="main-inner">
     <h1 class="text-lg font-semibold" style="font-family: sans-serif !important; ">
        FORM I
    </h1>
<div class="text-center flex justify-center gap-5 mt-4" >
      <a href=" {{ route('generateFormIPrint') }}"
   class="px-4 py-2 btn-primary uppercase" style="font-family: sans-serif !important; "
   target="_blank">
   <i class="las la-print"></i> Print
</a>
     <a href=" {{ route('formi.pdf') }}"
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
     
    <div class="" style=" text-align:center; border:none; font-size: 20px;  font-weight: bold;">
           <b>{{ $company->company_name }}  &nbsp; <!-- र. नं.  {{ $company->cin_no }} -->
            र. नं. १५३</b>
    </div>

    {{-- <table style="width:100%; font-size:20px; margin-bottom:10px; border:none;">
        <tr>
            <td style="width:33%; text-align:center; border:none; font-size: 18px;  font-weight: bold;"> --}}
                {{-- सहकारी --}}
            {{-- </td>
            <td style="width:34%; text-align:center; border:none; font-size: 18px;  font-weight: bold;">
               {{ $companyName }}    --}}
               {{-- संस्था म. --}}
            {{-- </td>
            <td style="width:33%; text-align:center; border:none; font-size: 18px;  font-weight: bold;"> --}}
                {{-- र. नं. --}}
            {{-- </td>
        </tr>
    </table> --}}

    <div class="title" style="font-size:20px;  ">नमुना "आय"</div>
    <div class="subtitle" style="font-size:14px;  text-align: center; ">
        <b>नियम (३२ व ६५ १) महाराष्ट्र सरकारी संस्था अधिनियम १९६० याचे कलम ३८ (१)</b>
    </div>
    <div class="title" style="text-align:center; font-weight:bold;font-size: 20px;  margin-top: 12px; ">सदस्याचे नोंदणी पुस्तक</div>

    <table style="width:100%; margin-top:20px; border:none; font-size:14px;">
        <tr>
            <td style="width:50%; border:none;">
                १) अनुक्रमांक ..........................................................................
            </td>
            <td style="width:50%; border:none;">
                २) दाखल करून घेतल्याची तारीख ................................
            </td>
        </tr>
    </table>

    <table style="width:100%; margin-top:10px; border:none; font-size:14px;">
        <tr>
            <td style="width:50%; border:none;">
                ३) प्रवेश फी दिल्याची तारीख ..................................................
            </td>
            <td style="width:50%; border:none;">
                ४) संपुर्ण नाव ______________________________
            </td>
        </tr>
    </table>
     
    {{-- <hr> --}}
    <p style="padding: 0px 20px; font-size: 14px;">
        ५)पत्ता___________________________________________________________________________________________
    </p>
    <p style="padding: 0px 20px; font-size: 14px;">
        ६)व्यवसाय____________________________________ &nbsp;&nbsp; &nbsp;
        ७)दाखल करून घेतल्याच्या तारखेस असलेले वय........................
    </p>
    <p style="padding: 0px 20px; font-size: 14px;">
        ८)कलम ३० (१ ) अन्वये सदस्याने नामनिर्देष्ट केलेल्या इसमाचे
        नाव व पत्ता
        ___________________________________________________________________________________________
    </p>
    <p style="padding: 0px 20px; font-size: 14px;">
        ९)नामनिर्देष्ट केल्याची तारीख................................... &nbsp;&nbsp; &nbsp;
        १०)सदस्यत्व बंद झाल्याची तारीख....................................
    </p>
    <p style="padding: 0px 20px; font-size: 14px;">

        ११)बंद झाल्याची कारणे_____________________________________________________________________
    </p>
    <p style="padding: 0px 20px; font-size: 14px;">

        १२)शेरा_________________________________________________________________________________
    </p>
    <p style="padding: 0px 20px; font-size: 14px;">

    </p>


    <table style="width:100%; border-collapse:collapse; font-size:12px; margin-top:20px;">
        
        <thead>
            <tr>
                <th rowspan="3" style="border:1px solid #000; border-left: none  !important; width:6%;">तारीख</th>
                <th rowspan="3" style="border:1px solid #000; width:8%;">रोकड<br>वहीचे<br>पान</th>
                <th colspan="4" style="border:1px solid #000;">धारण केलेल्या शेअर्सचा तपशील</th>
                <th rowspan="3" style="border:1px solid #000; width:10%;">मिळालेली<br>एकूण<br>रक्कम</th>
                <th rowspan="3" style="border:1px solid #000; width:10%;">धारण केलेल्या<br>शेअर्सची<br>संख्या</th>
                <th rowspan="3" style="border:1px solid #000; width:10%;">शेअर<br>प्रमाणपत्राचा<br>अनुक्रमांक</th>
                <th rowspan="3" style="border:1px solid #000; width:8%; border-right: none  !important;">शेरा</th>
            </tr>
            <tr>
                <th rowspan="2" style="border:1px solid #000;">अर्ज</th>
                <th rowspan="2" style="border:1px solid #000;">वाटणी</th>
                <th colspan="2" style="border:1px solid #000;">मिळालेली रक्कम</th>
            </tr>
            <tr>
                <th style="border:1px solid #000;">प्रथम भाग<br>दिल्यानंतर</th>
                <th style="border:1px solid #000;">दुसऱ्यांदा भाग दिल्या नंतर</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; border-left: none  !important;">१ </th>
                
                <th style="border:1px solid #000;">२</th>
                <th style="border:1px solid #000;">३</th>
                <th style="border:1px solid #000;">४ </th>
                <th style="border:1px solid #000;">५</th>
                <th style="border:1px solid #000;">६</th>
                <th style="border:1px solid #000;">७ </th>
                <th style="border:1px solid #000;">८</th>
                <th style="border:1px solid #000;">९</th>
                <th style="border:1px solid #000; border-right: none  !important;">१०</th>
            </tr>
        </thead>
        <tbody>
            <tr style=" height: 200px;">
                <td style="  height: 220px; border-left: none; "></td>
                <td></td>
                 <td></td>
                 <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td ></td>
                <td style="border-right: none;"></td>
            </tr>
        </tbody>

     </table>

     <table style="width:100%; border-collapse:collapse; font-size:12px; margin-top:20px;">
        
        <thead>
            <tr>
                <th colspan="9" style="border:1px solid #000; text-align:center; border-right: none  !important; border-left: none  !important;">
                    हस्तांतरित किंवा स्वाधीन केलेल्या शेअर्सचा तपशील
                </th>
            </tr>
            <tr>
                <th rowspan="3" style="border:1px solid #000; width:6%; border-left: none  !important;">तारीख</th>
                <th rowspan="3" style="border:1px solid #000; width:7%;">रोकड<br>वहीचे<br>पान</th>
                
            </tr>
            <tr>
                <th rowspan="2" style="border:1px solid #000; width:8%;">तारीख</th>
                <th rowspan="2" style="border:1px solid #000; width:15%;">
                    रोकड वहीच्या पानाचा किंवा शेअर्स<br>
                    हस्तांतरण नोंदणी पु. क्र.
                </th>
                <th rowspan="2" style="border:1px solid #000; width:12%;">
                    हस्तांतरित केलेल्या शेअर्सची संख्या<br>
                    शेअर प्रमाणपत्राचा अनुक्रमांक
                </th>
                <th rowspan="2" style="border:1px solid #000; width:10%;">
                    हस्तांतरित केलेल्या किंवा परत केलेल्या<br>
                    शेअर्सची संख्या
                </th>
                <th colspan="4" style="border:1px solid #000; width:18%; border-right: none  !important;">
                    शिल्लक
                </th>
            </tr>
            <tr>
                <th>धारण केलेल्या शेअर्सची संख्या</th>
                <th>शेअर प्रमाण पत्राचा अ. नु.</th>
                <th colspan="2" style="border-right: none  !important;">रक्कम</th>
            </tr>
            <tr>
                <th style="border:1px solid #000; border-left: none  !important;">११</th>
                <th style="border:1px solid #000;">१२</th>
                <th style="border:1px solid #000;">१३</th>
                <th style="border:1px solid #000;">१४</th>
                <th style="border:1px solid #000;">१५</th>
                <th style="border:1px solid #000;">१६</th>
                <th style="border:1px solid #000;">१७</th>
                <th style="border:1px solid #000;">१८</th>
                <th colspan="2" style="border:1px solid #000; border-right: none  !important;">१९</th>
            </tr>

        </thead>
        <tbody>
            <tr style="">
                <td style="height: 100px; border-left: none "></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2" style="border-right: none;"></td>
            </tr>
        </tbody>

    </table>


   </div>

</div>

    @endsection