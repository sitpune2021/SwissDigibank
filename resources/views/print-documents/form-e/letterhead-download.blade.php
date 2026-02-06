<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Letter Head</title>
    <style>
        body {

            font-family: "mukta", Arial, sans-serif;

            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #111;
        }

        .sheet {
            /* width: 190mm; */
            margin: 0 auto;
        }

        table {
            width: 100%;

        }

        table,
        td,
        th {
            /*  border: 1px solid #000; */
            border-collapse: collapse;
            border: 2px solid #000 !important;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 0.6px;
        }

        h3 {
            text-align: center;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="sheet">
        <!-- Header -->
            
   <div style="width:100%; font-family: dejavusans; ">

                <!-- Logo -->
                <div style="float:left; width:50%; padding: 0px 5px; text-align:left;">
                    <img src="{{ public_path('assets/images/SBC_Logo_gpg.jpg') }}" alt="Company Logo"
                        style="width:auto; height:50px;">
                </div>

                <!-- Title Section -->
                <div style="float:left; width:50%; text-align:center;">
                    <div style="  font-size:30px; font-weight: 800;  text-transform:uppercase; ">
                        {{-- SBC Global --}}
                    </div>

                    <div style="height:10px; ">&nbsp;</div>


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
            <div class="" style="">
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
        


        
    </div>
</body>

</html>