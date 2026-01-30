@extends('layout.main')

@section('content')
    <div class="main-inner">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
            <h2 class="text-lg uppercase">Print Letter Head </h2>

        </div>
<div class="text-center flex justify-center gap-5 mt-4">
        <a href="{{ route('letterhead.download') }} " class="px-4 py-2 btn-primary uppercase"
            style="font-family: sans-serif !important; " target="_blank">
            <i class="las la-download"></i> Download
        </a>
        {{-- <a href="
 {{ route('') }}
  " class="px-4 py-2 btn-outline uppercase" style="font-family: sans-serif !important; " target="_self">
            BACK
        </a> --}}
    </div>

     <div class="box mt-5" >
        <div class="sheet">
        <!-- Header -->
        <div style="width:100%; height: 500px; font-family: dejavusans; padding: 5px; padding-bottom: 20px;">

            <!-- Logo -->
            <div style="float:left;  text-align:left;">
                <img src="{{ asset('assets/images/SBC_Logo_gpg.jpg') }}" alt="Company Logo"
                    style="width:auto; height:50px;">
            </div>
         
            <!-- Title Section -->
            {{-- <div style="float: right; width:80%; text-align:center;">
                <div style="  font-size:30px; font-weight: 800;  text-transform:uppercase; ">
                    {{ $bank_name }}
                </div>
                 <div style="  font-size:12px; font-weight: 800;  text-transform:uppercase; ">
                   {{ $address }}
                </div>

                <div style="height:10px; margin-top: 40px;">&nbsp;</div>

               
            </div> --}}

            <!-- Clear Float -->
            <div style="clear:both; "></div>
         <hr>
        </div>

        
    </div>
     </div>
  
@endsection