<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th {
            background: #f2f2f2;
            padding: 6px;
            text-align: center;
        }

        td {
            padding: 5px;
        }
    </style>
</head>

<body>

    <div style="width:100%; font-family: dejavusans;">

        <!-- Logo -->
        <!-- <div style="float:left; text-align:left;">
            <img src="{{ $logoPath }}" alt="Company Logo" style="width:auto; height:50px;">
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
    <div class="title" style="border-bottom: 2px solid #000 ; padding: 5px;">Share Transfer Histories</div>

    <table>
        <thead>
            <tr>
                <th style=" text-align: center;">BUSINESS TYPE </th>
                <th style="text-align: center;">TRANSFEROR</th>
                <th style=" text-align: center;">TRANSFEREE</th>
                <th style=" text-align: center;">SHARE RANGE</th>
                <th style=" text-align: center;">NOMINAL VALUE</th>
                <th style=" text-align: center;">NO. OF SHARES</th>
                <th style=" text-align: center;">DATE OF TRANSFER</th>
                <th style=" text-align: center;">NEW SHARE</th>
            </tr>
        </thead>

        <tbody>
            @foreach($shareTransfers as $shareTransfer)
            <tr class="border-b dark:border-bg3">
                <td style=" text-align: center;">
                    <div class="flex items-center gap-1  uppercase">
                        {{ $shareTransfer->business_type ?? ''}}
                    </div>
                </td>
                <td style=" text-align: center;">
                    <div class="flex items-center gap-1 Capitalize">
                        {{ $shareTransfer->members->member_info_first_name ?? ''}} {{
                        $shareTransfer->members->member_info_last_name ?? ''}}
                    </div>
                </td>

                <td style=" text-align: center;">
                    <div class="flex items-center  gap-1">
                        {{ $shareTransfer->promotor->first_name ?? ''}} {{ $shareTransfer->promotor->last_name ?? ''}}
                    </div>
                </td>
                <td style=" text-align: center;">
                    <div class="flex items-center t gap-1">
                        {{ $shareTransfer->from_share_no ?? ''}} - {{ $shareTransfer->to_share_no ?? ''}}
                    </div>
                </td>
                <td style=" text-align: center;">
                    <div class="flex items-center gap-1">
                        {{ $shareTransfer->face_value ?? ''}}
                    </div>
                </td>

                <td style=" text-align: center;">
                    <div class="flex items-center gap-1">
                        {{ $shareTransfer->total_consideration ?? ''}}
                    </div>
                </td>
                <td style=" text-align: center;">
                    <div class="flex items-center gap-1">
                        {{ $shareTransfer->total_consideration ?? ''}}
                    </div>
                </td>
                <td style=" text-align: center;">
                    <div class="flex items-center gap-1">
                        <div class="flex items-center gap-1">
                            @if($shareTransfer->certificate_number)
                            {{-- YES badge --}}
                            <span class="">
                                Yes
                            </span>
                            @else
                            {{-- NO badge --}}
                            <span class="">
                                No
                            </span>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>