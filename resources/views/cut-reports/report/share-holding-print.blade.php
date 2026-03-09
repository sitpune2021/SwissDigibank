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

            <!-- Logo -->
            <!-- <div style="float:left; text-align:left;">
                <img src="{{ $logoPath }}" alt="Company Logo"
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
<div class="title" style="border-bottom: 2px solid #000 ; padding: 5px;">Share Holdings Report</div>

<table>
    <thead>
        <tr>
            <th style="width: 30%; text-align: center;">MEMBER </th>
            <th style="width: 16%; text-align: center;">SHARE RANGE</th>
            <th style="width: 10%; text-align: center;">TOTAL SHARES</th>
            <th style="width: 15%; text-align: center;">NOMINAL VAL.</th>
            <th style="width: 15%; text-align: center;">TOTAL SHARE VAL.</th>
            <th style="width: 15%; text-align: center;">ALLOTMENT DATE</th>
             <th style="width: 15%; text-align: center;">TRANSFER DATE</th>
        </tr>
    </thead>

    <tbody>
         @foreach($promoters as $promoter)

                    <tr class="border-b dark:border-bg3">
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1  uppercase">
                                {{ $promoter->first_name }} {{ $promoter->last_name }}
                            </div>
                        </td>

                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center  gap-1">
                                {{ $promoter->latestShare->first_share ?? '' }} - {{ $promoter->latestShare->share_no ?? '' }}
                            </div>
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center t gap-1">
                                {{ $promoter->latestShare->total_share_held ?? '' }}
                            </div>
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center t gap-1">
                                {{ $promoter->latestShare->nominal_value ?? '' }}
                            </div>
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                {{ $promoter->latestShare->total_share_value ?? '' }}
                            </div>
                        </td>

                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                              {{ $promoter->latestShare ? \Carbon\Carbon::parse($promoter->latestShare->allotment_date)->format('d-m-Y') : '' }}

                            </div>
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                {{ $promoter->latestShare ? \Carbon\Carbon::parse($promoter->latestShare->transaction_date)->format('d-m-Y') : '' }}
                            </div>
                        </td>

                    </tr>
                    @endforeach 
    </tbody>
</table>

</body>
</html>