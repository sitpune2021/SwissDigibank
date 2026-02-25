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
        FORM J
    </h1>
<div class="text-center flex justify-center gap-5 mt-4" >
    <a href=" {{ route('generateFormJPrint') }}"
   class="px-4 py-2 btn-primary uppercase" style="font-family: sans-serif !important; "
   target="_blank">
   <i class="las la-print"></i> Print
</a>
     <a href=" {{ route('formj.download') }}"
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


    <div class="title" style="font-size:24px;  ">नमुना ‘जे’</div>
    <div class="subtitle" style="font-size:14px; text-align: center;  ">नियम ३२ (कलम ३९ अन्वये)</div>

    <div class="header" style="font-size: 20px; text-align: center;">
         {{$companyName}} र. नं. 12345
    </div>

    <div style="text-align:center; font-weight:bold;font-size: 20px;  margin-top: 12px; ">
        ________________________सदस्यांची यादी
    </div>

    <table style="width: 100%">
        <thead>
            <tr>
                <th style="width:6%; font-size: 16px;">अनुक्रमांक</th>
                <th style="width:30%; font-size: 16px;">सदस्याचे नाव</th>
                <th style="width:40%; font-size: 16px;">पत्ता</th>
                <th style="width:12%; font-size: 16px;">सदस्याचा वर्ग</th>
                <th style="width:13%; font-size: 16px;">शेरा</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-size: 16px;  text-align: center;">१</td>
                <td style="font-size: 16px;  text-align: center;">२</td>
                <td style="font-size: 16px;  text-align: center;">३</td>
                <td style="font-size: 16px;  text-align: center;">४</td>
                <td style="font-size: 16px;  text-align: center;">५</td>
            </tr>
            @foreach($members as $index => $member)
            <tr>
                <td style="font-size: 16px;">{{ $index + 1 }}</td>

                <td style="font-size: 16px;">
                    {{ $member->member_info_first_name }}
                     {{ $member->member_info_middle_name }}
                    {{ $member->member_info_last_name }}
                </td>

                <td style="font-size: 16px;">
                    {{ $member->address->member_address_line_1 ?? '' }},
                    {{ $member->address->member_address_city_district ?? '' }},
                    {{ $member->address->state->name ?? '-' }},
                    {{ $member->address->member_address_country ?? '' }},
                    {{ $member->address->member_address_pincode ?? '' }},
                </td>

                <td style="font-size: 16px;">{{ $member->membership_type }}</td>

                <td style="font-size: 16px;"></td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

</div>
    @endsection