<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Cut Report</title>
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

        .header-table {
            width: 100%;
            border-bottom: 1px solid #000;
            margin-bottom: 10px;
        }

        .header-table td {
            vertical-align: middle;
            padding: 5px;
        }

        .header-table img {
            width: 90px;
            height: 90px;
            object-fit: cover;
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

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 10px;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }
    </style>
</head>

<body>
    <div class="sheet">
        <!-- Header -->
        <table class="header-table">
            <tr>
                <td style="width: 10%; text-align:left;">
                    <img src="{{ $photoPath }}" alt="Company Logo"  style="width:auto; height:50px;">
                </td>
                <td style="width: 90%; text-align:left; padding: 0px 20px;">
                    <div class="company-name" style="">{{ $company['name'] }}</div>
                    

                </td>
            </tr>
        </table>
        {{-- <div style="width:100%; font-family: dejavusans; ">

                <!-- Logo -->
                <div style="float:left; width:50%; padding: 0px 5px; text-align:left;">
                    <img src="{{ public_path('assets/images/SBC_Logo_gpg.jpg') }}" alt="Company Logo"
                        style="width:auto; height:50px;">
                </div>

                <!-- Title Section -->
                <div style="float:left; width:50%; text-align:center;">
                    <div style="  font-size:30px; font-weight: 800;  text-transform:uppercase; ">
                      
                    </div>

                    <div style="height:10px; ">&nbsp;</div>


                </div>

                <!-- Clear Float -->
                <div style="clear:both; "></div>
                <h4 style=" padding-bottom: 5px;  margin:0; text-align: center;  font-size:18px; font-weight:bold;">
       {{ $company['name'] }}   
                </h4 >
                <hr>
            </div> --}}

        <h3 style="font-family: dejavusans; font-size: 18x; margin:20px 20px; ">
            MIS ACCOUNTS CUT REPORT: {{ date('d-m-Y') }}
        </h3>

        <!-- Data Table -->
        <table class="data-table">
            <tr>
                <th class="" style="color: #c60707; font-size: 14px;">अनुु.क्.</th>
                <th style="color: #c60707; font-size: 14px;">खाते क्.</th>
                <th style="color: #c60707; font-size: 14px;"> नाव</th>
                <th style="color: #c60707; font-size: 14px;"> िशल्लक</th>
            </tr>
            @foreach($associates as $key => $a)
            <tr>
                <td style="font-family: dejavusans; ">{{ $key + 1 }}</td>
                <td style="font-family: dejavusans; ">{{ $a->mis_account_no }}</td>
                <td style="font-family: dejavusans; ">{{ $a->title }} {{ $a->name }} {{ $a->last_name }}</td>
                <td style="font-family: dejavusans; ">{{$a->amount}}</td>

            </tr>
            @endforeach
            <tr>
                <td colspan="3" style="font-family: dejavusans;text-align: center; font-weight: bold; font-size: 12px; ">Total</td>
                <td style="font-family: dejavusans;">
                    {{ number_format($totalAmount ?? 0, 2) }}
                </td>
            </tr>
        </table>
    </div>
</body>

</html>