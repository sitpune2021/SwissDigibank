@extends('layout.main')
@section('content')
<style>
    @page {
        size: A4;
        margin: 10mm 10mm 10mm 10mm;
    }

    body {
        font-family: marathi;
        font-size: 12px;
    }

    .title {
        text-align: center;
        font-weight: bold;
        font-size: 16px;
    }


    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        margin: 0;
    }

    h2,
    h3 {
        text-align: center;
        margin-top: 10px;
    }

    .title {
        text-align: center;
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 5px;
    }

    .sub-title {
        text-align: center;
        font-weight: bold;
        margin-bottom: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #000;
        /* padding: 4px; */
        text-align: center;
        vertical-align: middle;
    }

    th {
        font-weight: bold;
    }

    .left {
        text-align: left;
    }

    .small {
        font-size: 11px;
    }
</style>

<div class="main-inner">
    <h1 class="text-lg font-semibold uppercase" style="font-family: sans-serif !important; ">
        Form E1
    </h1>
    <div class="text-center flex justify-center gap-5 mt-4">
        <a href="{{ route('eOneForm') }} " class="px-4 py-2 btn-primary uppercase"
            style="font-family: sans-serif !important; " target="_blank">
            <i class="las la-download"></i> Download
        </a>
        <a href="
 {{ route('index-from-e') }}
  " class="px-4 py-2 btn-outline uppercase" style="font-family: sans-serif !important; " target="_self">
            BACK
        </a>
    </div>
    <div class="box mt-5">

        <div style="width:100%; font-family: dejavusans; ">

            <!-- Logo -->
            <div style="float:left; width:50%; padding: 0px 5px; text-align:left;">
                <img src="{{ asset('assets/images/SBC_Logo_gpg.jpg') }}" alt="Company Logo"
                    style="width:auto; height:50px;">
            </div>

            <!-- Title Section -->
            <div style="float:left; width:50%; text-align:center;">
                <div style="  font-size:30px; font-weight: 800;  text-transform:uppercase; ">
                    {{-- SBC Global --}}
                </div>

                <div style="height:10px; margin-top: 40px;">&nbsp;</div>


            </div>

            <!-- Clear Float -->
            <div style="clear:both; "></div>
            <h4 style=" padding-bottom: 5px;  margin:0; text-align: center;  font-size:18px; font-weight:bold;">
                <h2>नमुना ई-1</h2>
            </h4>

            <h3 style="margin-bottom: 10px">___________________र. नं. ______ तालुका ______ जि._________</h3>

            <hr>
        </div>
        <table style="margin-top: 15px">
            <thead>
                <tr>
                    <th rowspan="2" style="width: 5%;">अ.क्र.</th>
                    <th rowspan="2" style="width: 7%;">विभाग</th>
                    <th rowspan="2" style="width: 7%;">जिल्हा</th>
                    <th rowspan="2" style="width: 7%;">तालुका/प्रभाग</th>
                    <th rowspan="2" style="width: 15%;">संस्थेचे नाव व नोंदणी क्रमांक व संपूर्ण पत्ता</th>
                    <th rowspan="2" style="width: 7%;">सदस्यांची संख्या दर्शविणारा पोटनियम क्रमांक</th>
                    <th colspan="2" style="width: 25%;">एकूण निवडायचे सदस्य </th>
                    <th rowspan="2" style="width: 7%;">
                        व्यवस्थापक समितीची शेवटची निवडणुक झाली त्याचा दिनांक
                    </th>
                    <th rowspan="2" style="width: 7%;">व्यवस्थापक समितीची मुदत संपण्याचा दिनांक</th>
                    <th rowspan="2" style="width: 7%;">शेरा</th>
                </tr>
                <tr>
                    <th>मतदार संघाचा प्रकार</th>
                    <th style="width: 6%">सदस्य संख्या</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="left"></td>
                    <td class="left" style="border-right: none"></td>

                    <td class="" colspan="2" style="padding: 0; border:none;">
                        <table class="" style="width:100%; border:none !important;">
                            <tr>
                                <td style="width: 50%; ">
                                    1. सर्वसाधारण प्रतिनिधी
                                </td>
                                <td style="width: 50%; ">

                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; ">
                                    2.अनुसुचित जाती/जमाती साठी राखीव.
                                </td>
                                <td style="width: 50%; ">

                                </td>
                            </tr>
                            <tr>
                                <td style="width: 76%; ">
                                    3. महिला प्रतिनिधी राखीव
                                </td>
                                <td style="width: 20%; ">

                                </td>
                            </tr>
                            <tr>
                                <td style="width: 76%; ">
                                    4. इतर मागासवर्गीयासाठी राखीव
                                </td>
                                <td style="width: 20%; ">

                                </td>
                            </tr>
                            <tr>
                                <td style="width:76%; ">
                                    5. भटक्या विमुक्त जाती/जमाती विशेष मागास प्रवर्ग
                                </td>
                                <td style="width: 20%; ">

                                </td>
                            </tr>
                            <tr>
                                <td style="width: 76%; "><strong>एकुण</strong></td>
                                <td style="width: 20%; ">

                                </td>
                            </tr>
                        </table>
                    </td>


                    <td style="border-left: none">

                    </td>

                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <div class="" style="text-align: right; margin-top: 55px; font-size: 14px; font-weight: 700;">
            सचिव/ व्यवस्थाक/ कार्यकारी संचालक
        </div>
    </div>

</div>
@endsection