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
     <h1 class="text-lg font-semibold uppercase" style="font-family: sans-serif !important; ">
        Letter Head
    </h1>
<div class="text-center flex justify-center gap-5 mt-4" >
     <a href="{{ route('letterheadPrint') }}" target="_blank" class="px-4 py-2 btn-primary uppercase">
    <i class="las la-print"></i> Print
</a>
     <a href=" {{ route('letterhead-e.pdf') }}"
   class="px-4 py-2 btn-primary uppercase" style="font-family: sans-serif !important; "
   target="_blank">
   <i class="las la-download"></i> Download
</a>
 <a href="
 {{ route('index-from-e') }}
  "
   class="px-4 py-2 btn-outline uppercase" style="font-family: sans-serif !important; "
   target="_self">
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
                   {{ $companyName }} &nbsp; र.नं.12345
                </h4 >
                <hr>
            </div>


    <div style="font-size:16px; ">
    <table style="width:100%; border: none;">
        <tr>
            <td style="text-align:left; border: none;">
                पत्ता: 
                {{-- मटकारी गल्ली, माहेश्वरी भवन जवळ, शेगाव 444203 जि. बुलढाणा --}}
            </td>
            <td style="text-align:right;border: none;">
                फोन:
                 {{-- (09876) 23456 --}}
            </td>
        </tr>
    </table>
    <hr>
    <div class="" style="height: 500px">
       <div class="" style="margin-top:50px;">
        <table style="width:100%; border: none;">
        <tr>
            <td style="text-align:left; border: none;">
               जा. क्र.---------
            </td>
            <td style="text-align:right;border: none;">
                दिनांक:.....................
                {{-- {{ \Carbon\Carbon::now()->format('d-m-Y') }} --}}


                 {{-- 10-10-2025 --}}
            </td>
        </tr>
    </table>
       </div>
    </div>
</div>
    <hr>
    



   </div>

</div>
    @endsection