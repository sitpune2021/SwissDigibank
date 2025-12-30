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
            width: 190mm;
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
        <div style="width:100%; font-family: dejavusans; border-bottom: 2px solid #000 ; padding: 5px;">

            <!-- Logo -->
            <div style="float:left; width:10%; text-align:left;">
                <img src="{{ public_path('assets/images/SBC_Logo.jpg') }}" alt="Company Logo"
                    style="width:130px; height:130px;">
            </div>

            <!-- Title Section -->
            <div style="float: right; width:80%; text-align:center;">
                <div style="  font-size:30px; font-weight: 800;  text-transform:uppercase; ">
                    {{ $bank_name }}
                </div>
                 <div style="  font-size:12px; font-weight: 800;  text-transform:uppercase; ">
                   {{ $address }}
                </div>

                <div style="height:10px; margin-top: 40px;">&nbsp;</div>

               
            </div>

            <!-- Clear Float -->
            <div style="clear:both; "></div>

        </div>

        
    </div>
</body>

</html>