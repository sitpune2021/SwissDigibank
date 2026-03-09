<!DOCTYPE html>
<html>
<head>
    <style>
        body{
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .title{
            text-align:center;
            font-size:18px;
            font-weight:bold;
            margin-bottom:15px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table, th, td{
            border:1px solid #000;
        }

        th{
            background:#f2f2f2;
            padding:6px;
            text-align:center;
        }

        td{
            padding:5px;
        }
    </style>
</head>
<body>

       <div style="width:100%; font-family: dejavusans;">

        <!-- <div class="header">
        <div class="title" style="font-size:20px;"><b>{{ $members['name'] ?? 'दि कुबेर कमर्शियल को-ऑपरेटिव्ह क्रेडिट सोसायटी लिमिटेड. अकोला' }}</b></div>
        <div class="title" style="font-size:20px;"><b>केशव नगर चौक अकोला</b></div>
        <div class="title" style="font-size:20px;"><b> र. नं. १५३ </b></div>
    </div>

    <div class="sub-header" style="font-size:20px;">
       <b>संचालक यादी - {{ date('Y') }}</b>
    </div>
    <hr> -->
            <!-- Logo -->
            <!-- <div style="float:left; text-align:left;">
                <img src="{{ public_path('assets/images/SBC_Logo_gpg.jpg') }}" alt="Company Logo"
                    style="width:auto; height:50px;">
            </div> -->

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

        </div>
<div class="title" style="border-bottom: 2px solid #000 ; padding: 5px;">Promoters / Members Report</div>

<table>
    <thead>
        <tr>
            <th style="width: 12%; text-align: center;">MEMBER NO.</th>
            <th style="width: 30%; text-align: center;">MEMBER NAME</th>
            <th style="width: 15%; text-align: center;">BRANCH</th>
            <th style="width: 15%; text-align: center;">KYC STATUS</th>
            <th style="width: 15%; text-align: center;">ENROLLMENT DATE</th>
            <th style="width: 15%; text-align: center;">STATUS</th>
        </tr>
    </thead>

    <tbody>
        @foreach($members as $member)
        <tr>
            <td style="text-align: center;">{{ $member->member_no }}</td>

            <td style="text-align: center;">
                {{ $member->member_info_first_name }}
                {{ $member->member_info_middle_name ?? '' }}
                {{ $member->member_info_last_name }}
            </td>

            <td style="text-align: center;">{{ $member->branch->branch_name ?? '-' }}</td>

            <td style="text-align: center;">
                {{-- @if($member->kyc && $member->kyc->status == 1)
                    VERIFIED
                @else
                    PENDING
                @endif --}}
            </td>

            <td style="text-align: center;">
                {{ \Carbon\Carbon::parse($member->created_at)->format('d-m-Y') }}
            </td>

            <td style="text-align: center;">
                {{-- {{ $member->status == 1 ? 'ACTIVE' : 'INACTIVE' }} --}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>