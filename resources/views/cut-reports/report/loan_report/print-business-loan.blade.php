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
            font-weight: bold;
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
        <div style="clear:both;"></div>

    </div>
    <div class="title" style="border-bottom: 2px solid #000 ; padding: 5px;">Other Loan Accounts</div>

    <table>
        <thead>
            <tr>
                <th style=" text-align: center;">BRANCH </th>
                <th style=" text-align: center;">CUSTOMER</th>
                <th style=" text-align: center;">ACCOUNT NO.</th>
                <th style=" text-align: center;">APPLICATION NO.</th>
                <th style=" text-align: center;">SCHEME</th>
                <th style=" text-align: center;">OPEN DATE</th>
                <th style=" text-align: center;">STATUS</th>
                <th style=" text-align: center;">LOAN AMT.</th>
                <th style=" text-align: center;">CURRENT DEBT</th>
            </tr>
        </thead>

        <tbody>
       @forelse($loans as $loan)
                            <tr class="border-b dark:border-bg3">

                                <!-- BRANCH -->
                                <td class="px-6 py-5 uppercase">
                                    {{ $loan->branch->branch_name ?? 'N/A' }}
                                </td>

                                <!-- CUSTOMER -->
                                <td class="text-start !py-5 px-6">
                                   
                                        {{ $loan->member->full_name ?? 'N/A' }} -
                                        {{ $loan->member->member_no ?? '---' }}
                                   
                                </td>

                                <!-- ACCOUNT NO -->
                                <td class="px-6 py-5">
                                   
                                        {{ str_pad($loan->id, 10, '0', STR_PAD_LEFT) }}
                                  
                                </td>

                                <!-- APPLICATION NO -->
                                <td class="px-6 py-5">
                                   {{ str_pad($loan->id, 10, '0', STR_PAD_LEFT) }}
                                  
                                </td>

                                <!-- SCHEME -->
                                <td class="px-6 py-5">
                                    {{ $loan->scheme->scheme_name ?? 'N/A' }}
                                </td>

                                <!-- OPEN DATE -->
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        {{ \Carbon\Carbon::parse($loan->application_date)->format('d-m-Y') ?? '-' }}
                                    </div>
                                </td>

                                <!-- STATUS -->
                                <td class="px-6 py-5">
                                    {{ $loan->status == 2 ? 'Active' : 'Closed' }}
                                </td>

                                <!-- LOAN AMOUNT -->
                                <td class="px-6 py-5">
                                    {{ number_format($loan->loan_amount, 2) }}
                                </td>

                                <!-- CURRENT DEBT -->
                                <td class="px-6 py-5">
                                    {{ number_format($loan->current_debt ?? 0, 2) }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-red-500">
                                    No Records Found
                                </td>
                            </tr>
                        @endforelse
        </tbody>
    </table>

</body>

</html>