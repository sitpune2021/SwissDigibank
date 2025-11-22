{{-- resources/views/pdf/id-card.blade.php --}}
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ID Card</title>
    <style>
        /* Page size set to standard CR80 / credit-card size */
        @page {
            size: a4;
            margin: 0;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            -webkit-font-smoothing: antialiased;
        }

        .card {
            width: 85.6mm;
            height: 53.98mm;
            box-sizing: border-box;
            padding: 4mm;
            margin: auto;
            margin-top: 40px !important;
        }

        /* Outer table keeps predictable layout for PDF engines */
        table.outer {
            /* border:1px solid #000;   */
            width: 53.98mm;
            height: 85.6mm;
            margin: auto;
            border-collapse: collapse;
            table-layout: fixed;
        }

        table.outer td {
            vertical-align: middle;
            /* vertical center */
            text-align: center;
            /* horizontal center */
        }

        td.no-wrap {
            white-space: nowrap;
        }

        /* Left column (logo / title) and right column (photo & details) */
        table.inner {
            width: 100%;
            border-collapse: collapse;
        }

        .logo {
            font-size: 9px;
            font-weight: bold;
            text-align: left;
            line-height: 1;
        }

        .org-name {
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 0.6px;
        }

        .designation {
            font-size: 8.5px;
        }

        .details-table td {
            padding: 1px 3px;
            vertical-align: top;
        }

        .big-name {
            font-size: 12px;
            font-weight: 700;
            margin: 0;
            line-height: 2.05;
        }

        .small {
            font-size: 8.5px;
            line-height: 2.05;
            text-align: left;
            margin: auto;
            padding-left: 10px;
        }

        .photo {
            width: 24mm;
            height: 30mm;
            border: 1px solid #000;
            display: block;
            object-fit: cover;
        }

        .barcode {
            width: 100%;
            height: 10mm;
            display: block;
        }

        /* Minor utility */
        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="card">
        <table class="outer">
            <tr>
                <td>
                    <img src="{{ public_path('assets/images/sbc-image.jpg')}}" alt="logo"
                        style="width:150px; height:150px; display:block;">
                </td>

            </tr>
            <tr>
                <td>
                    <div class="org-name" style="font-size: 14px; margin-top: 8px;" >SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA LIMITED</div>
                    <div class="" style="font-size: 12px;">969/03-04</div>
                    <div style="height:4px;"></div>


                </td>
            </tr>

            <tr style="border-top: 1px solid black; ">
                <td>
                    <img src="{{ public_path('assets/images/pexels-supratik-sahis-269808633-30522882.jpg')}}" alt="logo"
                        style="width:150px; height:150px; object-fit: fill; display:block; padding-top: 10px;">
                </td>
            </tr>
            <tr class="">
                <td>
                    
                    <table style="width:100%; border-collapse: collapse; line-height: 1.1;">
                        <tr>
                            <td colspan="2" class="big-name"
                                style="font-size:10pt; font-weight:bold; padding-bottom:2px;">
                                {{ $name ?? 'NITIN ILLARKAR' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="small" style="font-size:14px; width:40%; text-align: left;">ASSOCIATE CODE:</td>
                            <td class="small" style="font-size:12px;text-align: left;">{{ $code ?? 'AGT00016' }}</td>
                        </tr>
                        <tr>
                            <td class="small" style="font-size:12px; text-align: left;">DESIGNATION:</td>
                            <td class="small" style="font-size:12px; text-align: left;">{{ $designation ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="small" style="font-size:12px; text-align: left;">MOB NO:</td>
                            <td class="small" style="font-size:12px; text-align: left;">{{ $mobile ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="small" style="font-size:12px; text-align: left;">BLOOD GRP.:</td>
                            <td class="small" style="font-size:12px; text-align: left;">{{ $blood ?? '' }}</td>
                        </tr>
                    </table>

                </td>
            </tr>
            <tr style="border-top: 1px solid black; ">
                <td>
                    <div class="" style="margin-top: 6px;"> <strong> {{ $address ?? '' }} </strong></div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>