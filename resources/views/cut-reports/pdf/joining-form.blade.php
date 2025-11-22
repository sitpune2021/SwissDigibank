{{-- <!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Associate Joining Form</title>

    <style>
        /* Page size for printing */
        @page {
            size: A4 portrait;
            /* margin: 18mm 12mm; */
        }

        html,
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 12px;
            color: #111;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
        }

        .sheet {
            width: 210mm;
            min-height: 297mm;
            padding: 12mm;
            box-sizing: border-box;
            background: #fff;
            margin: auto;
            /* border: 1px solid black; */
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 6px;
        }

        .company-name {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.6px;
        }

        .company-meta {
            font-size: 10px;
            margin-top: 2px;
        }

        .title-row {
            margin-top: 10px;
            text-align: center;
        }

        .form-title {
            font-size: 16px;
            font-weight: 700;
            /* border: 1px solid #000; */
            display: inline-block;
            padding: 6px 12px;
            letter-spacing: 0.6px;
        }

        /* Two column header meta */
        .meta {
            display: flex;
            justify-content: space-between;
            margin: 12px 0;
            gap: 8px;
            font-size: 12px;
        }

        .meta .left,
        .meta .right {
            width: 48%;
        }

        /* Table-like section */
        .details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        .details .row {
            display: flex;
            width: 100%;
            border-bottom: 1px dashed #d6d6d6;
            padding: 8px 0;
            align-items: center;
        }

        .col-label {
            width: 28%;
            font-weight: 600;
            padding-right: 8px;
            color: #222;
        }

        .col-value {
            width: 72%;
            word-break: break-word;
        }

        /* Two-columns within details for address, nominee etc */
        .two-cols {
            display: flex;
            gap: 12px;
        }

        .two-cols .col {
            flex: 1;
        }

        /* Signature area */
        .signature {
            margin-top: 28px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .sig-box {
            width: 30%;
            min-height: 60px;
            border-top: 1px solid #000;
            text-align: center;
            padding-top: 6px;
            font-size: 11px;
        }

        /* Small labels */
        .muted {
            color: #555;
            font-size: 11px;
        }

        /* Print helper - remove buttons when printing */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                margin: 0;
            }
        }

        /* small responsiveness for screen preview */
        @media (max-width:900px) {
            .meta {
                flex-direction: column;
            }

            .meta .left,
            .meta .right {
                width: 100%;
            }

            .col-label {
                width: 35%;
            }
        }
    </style>
</head>

<body>
    <div class="sheet">
        <div class="header"
            style="display: flex; flex-direction: row; align-items: start; justify-content: start; gap: 12px; border-bottom: 1px solid #111; padding-bottom: 10px !important;">
            <div style="flex-shrink: 0;">
                <img src="{{ asset('assets/images/sbc-image.jpg') }}"
                    style="width: 100px; height: 100px; object-fit: contain;" alt="">
            </div>
            <div class="company-name"
                style="font-size: 18px; font-weight: 700; letter-spacing: 0.6px; text-align: center;">
                {{ $company['name'] ?? 'SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA' }}
            </div>
        </div>
        <div class="title-row">
            <div class="form-title">ASSOCIATE JOINING DETAILS</div>
        </div>
        <div class="meta">
            <table style="width: 100%; border: 1px solid #111; border-collapse: collapse; font-size: 12px;">
                <tr style="border: 1px solid black;
                         border-collapse: collapse;">
                    <td
                        style="width: 25%; padding: 8px 8px; font-weight: 600; border: 1px solid black; border-collapse: collapse;">
                        Associate Code
                    </td>
                    <td style="width: 25%; padding: 8px 8px; border: 1px solid black; border-collapse: collapse;">
                        {{ $associate['code'] ?? 'AGT00016' }}
                    </td>

                    <td style="padding: 8px 8px; font-weight: 600;border: 1px solid black; border-collapse: collapse;">
                        Joining Date
                    </td>
                    <td style="padding: 8px 8px; border: 1px solid black; border-collapse: collapse;">
                        {{ $associate['joining_date'] ?? '18-01-2025' }}
                    </td>

                </tr>

                <tr>
                    <td style="padding: 8px 8px; font-weight: 600; border: 1px solid black; border-collapse: collapse;">
                        Associate Rank
                    </td>
                    <td style="padding: 8px 8px; border: 1px solid black; border-collapse: collapse;">
                        {{ $associate['rank'] ?? 'SALES EXECUTIVE' }}
                    </td>
                    <td
                        style="width: 25%; padding: 8px 8px; font-weight: 600;border: 1px solid black; border-collapse: collapse;">
                        Supervisor
                    </td>
                    <td style="width: 25%; padding: 8px 8px; border: 1px solid black; border-collapse: collapse;">
                        {{ $associate['supervisor'] ?? '' }}
                    </td>

                </tr>

                <tr>
                    <td style="padding: 8px 8px; font-weight: 600;border: 1px solid black; border-collapse: collapse;">
                        Employee Code
                    </td>
                    <td style="padding: 8px 8px; border: 1px solid black; border-collapse: collapse;">
                        {{ $associate['employee_code'] ?? 'EMP00024' }}
                    </td>
                    <td style="padding: 8px 8px; font-weight: 600; border: 1px solid black; border-collapse: collapse;">
                        User Id
                    </td>
                    <td style="padding: 8px 8px; border: 1px solid black; border-collapse: collapse;">
                        {{ $associate['user_id'] ?? 'nitin123' }}
                    </td>
                </tr>
            </table>

        </div>

        <!-- Personal Details -->
        <div style="margin-top:25px; font-weight:700; font-size: 14px; margin-bottom: 6px;">Personal Details</div>
        <div class="">
            <table style="width: 100%; border: 1px solid #111; border-collapse: collapse; font-size: 12px;">
                <tr style="">
                    <td
                        style="width: 25%; padding: 8px 8px; font-weight: 600; border: 1px solid black; border-collapse: collapse;">
                        Name
                    </td>
                    <td colspan="2"
                        style="width: 25%; padding: 8px 8px; border: 1px solid black; font-weight: 600; border-collapse: collapse;">
                        {{ $personal['name'] ?? 'NITIN ILLARKAR' }}
                    </td>

                    <td style="padding: 8px 8px; ">

                    </td>

                </tr>

                <tr>
                    <td style="padding: 8px 8px; font-weight: 600; border: 1px solid black; border-collapse: collapse;">
                        Father's Name
                    </td>
                    <td colspan="2" style="padding: 8px 8px; border: 1px solid black; border-collapse: collapse;">
                        {{ $personal['father_name'] ?? 'MANIKRAO GANPAT ILLARKAR' }}
                    </td>
                    <td style="width: 25%; padding: 8px 8px;">
                        {{ $associate['supervisor'] ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 8px; font-weight: 600;border: 1px solid black; border-collapse: collapse;">
                        D.O.B. (DD-MM-YYYY)
                    </td>
                    <td colspan="2" style="padding: 8px 8px; border: 1px solid black; border-collapse: collapse;">
                        {{ $personal['dob'] ?? '' }}
                    </td>

                    <td style="padding: 8px 8px; ">

                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 8px; font-weight: 600;border: 1px solid black; border-collapse: collapse;">
                        Reference by
                    </td>
                    <td colspan="2" style="padding: 8px 8px; border: 1px solid black; border-collapse: collapse;">
                        {{ $personal['reference_by'] ?? '' }}
                    </td>
                    <td style="padding: 8px 8px; "></td>
                </tr>
            </table>

            <div style="margin-top:25px; font-weight:700; font-size: 14px; ">KYC Details</div>
            <div class="row two-cols" style="padding-top:12px; padding-bottom:12px;">
                <table style="width: 100%; border: 1px solid #111; border-collapse: collapse; font-size: 12px;">
                    <tr style="border: 1px solid black;
                         border-collapse: collapse;">
                        <td
                            style="width: 25%; padding: 8px 8px; font-weight: 600; border: 1px solid black; border-collapse: collapse;">
                            Address
                        </td>


                        <td colspan="3" style="padding: 8px 8px; border: 1px solid black; border-collapse: collapse;">
                            MATA NAGAR RAMDAS PETH POLICE STATION AKOLA
                        </td>


                    </tr>

                    <tr>
                        <td
                            style="padding: 8px 8px; font-weight: 600; border: 1px solid black; border-collapse: collapse;">
                            Aadhaar No
                        </td>
                        <td style="padding: 8px 8px; border: 1px solid black; border-collapse: collapse;">
                            {{ $kyc['aadhaar'] ?? '593173951757' }}
                        </td>
                        <td
                            style="width: 25%; padding: 8px 8px; font-weight: 600;border: 1px solid black; border-collapse: collapse;">
                            Pan No
                        </td>
                        <td style="width: 25%; padding: 8px 8px; border: 1px solid black; border-collapse: collapse;">
                            {{ $kyc['pan'] ?? 'AFGPI3017Q' }}
                        </td>

                    </tr>

                    <tr>
                        <td
                            style="padding: 8px 8px; font-weight: 600;border: 1px solid black; border-collapse: collapse;">
                            Mobile No.
                        </td>
                        <td style="padding: 8px 8px; border: 1px solid black; border-collapse: collapse;">
                            {{ $contact['mobile'] ?? '9011446171' }}
                        </td>
                        <td
                            style="padding: 8px 8px; font-weight: 600; border: 1px solid black; border-collapse: collapse;">
                            Email
                        </td>
                        <td style="padding: 8px 8px; border: 1px solid black; border-collapse: collapse;">
                            {{ $contact['email'] ?? '' }}
                        </td>
                    </tr>
                </table>
            </div>


            <div style="margin-top:25px; font-weight:700; font-size: 14px; margin-bottom: 10px;">Nominee Details</div>
            <table style="width: 100%; border: 1px solid #111; border-collapse: collapse; font-size: 12px;">
                <tr style="border: 1px solid black;
                         border-collapse: collapse;">
                    <td
                        style="width: 25%; padding: 8px 8px; font-weight: 600; border: 1px solid black; border-collapse: collapse;">
                        Name
                    </td>
                    <td style="width: 25%; padding: 8px 8px; border: 1px solid black; border-collapse: collapse;">
                       {{ $nominee['name'] ?? 'PRAGATI NITIN ILLARKAR' }}
                    </td>

                    <td style="padding: 8px 8px; font-weight: 600;border: 1px solid black; border-collapse: collapse;">
                       Relation
                    </td>
                    <td style="padding: 8px 8px; border: 1px solid black; border-collapse: collapse;">
                       {{ $nominee['relation'] ?? 'Spouse' }}
                    </td>

                </tr>

                <tr>
                    <td style="padding: 8px 8px; font-weight: 600; border: 1px solid black; border-collapse: collapse;">
                       Address
                    </td>
                    <td colspan="3" style="padding: 8px 8px; border: 1px solid black; border-collapse: collapse;">
                      {{ $nominee['address'] ?? 'MATA NAGAR RAMDDAS PETH POLICE STATION AKOLA' }}
                    </td>
                </tr> 
            </table>
           
            <div class="row" style="border-bottom:none; margin-bottom: 50px; margin-top: 30px !important;padding-top:18px;">
                <div class="col-label" style="font-size: 14px; font-weight: 600">Remarks</div>
                <div class="col-value">{{ $remarks ?? '' }}</div>
            </div>
        </div>

        <div class="signature">
            <div style="width:40%;">
                <div class="" style="font-size: 14px; font-weight: 600">Signature of Branch Manager</div>
                <div class="" style="margin-top:18px;"></div>
            </div>

           

            <div style="width:25%;">
                <div class="" style="font-size: 14px; font-weight: 600">Company Seal</div>
                <div class="" style="margin-top:18px;"></div>
            </div>
        </div>

       

        <!-- Print / view helpers -->
        <div style="margin-top:14px;" class="no-print">
            <button onclick="window.print()"
                style="padding:8px 12px; border-radius:6px; border:1px solid #666; background:#fff; cursor:pointer;">Print
                / Save as PDF</button>
        </div>
    </div>
</body>

</html> --}}


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Associate Joining Form</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #111;
            margin: 0;
            padding: 0;
        }

        .sheet {
            width: 100%;
            background: #fff;
        }

        .header-table {
            width: 100%;
            border-bottom: 1px solid #000;
            margin-bottom: 10px;
        }

        .header-table td {
            vertical-align: middle;
            text-align: center;
            padding: 5px;
        }

        .header-table img {
            width: 90px;
            height: 90px;
        }

        .company-name {
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 0.6px;
        }

        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin: 15px 0 8px 0;
        }
        .section-title-remark{
            font-weight: 600;
            font-size: 14px;
            margin-top: 50px;
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

        .label {
            font-weight: 600;
            width: 25%;
        }

        .signature-section {
            margin-top: 40px;
            width: 100%;
            border: none;
        }

        .signature-section td {
            text-align: center;
            padding-top: 30px;
        }

        .signature-label {
            font-size: 14px;
            font-weight: 600;
            /* border-top: 1px solid #000; */
            padding-top: 4px;
        }
    </style>
</head>

<body>
    <div class="sheet">
        <table class="header-table">
            <tr>
                <td style="width: 10%; text-align:left;">
                    <img src="{{ public_path('assets/images/sbc-image.jpg') }}" alt="Company Logo">
                </td>
                <td style="width: 90%;">
                    <div class="company-name">{{ $company['name'] ?? 'SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA LIMITED' }}</div>
                    <div style="font-size:11px">&nbsp;</div>
                     <div style="font-size:11px">&nbsp;</div>
                     <div style="font-size:11px">&nbsp;</div> 
                     
                </td>
            </tr>
        </table>

        <h3 style="text-align:center; margin:10px 0;">ASSOCIATE JOINING DETAILS</h3>

        <table class="data-table">
            <tr>
                <td class="label">Associate Code</td>
                <td>{{ $associate['code'] ?? '' }}</td>
                <td class="label">Joining Date</td>
                <td>{{ $associate['joining_date'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Associate Rank</td>
                <td>{{ $associate['rank'] ?? '' }}</td>
                <td class="label">Supervisor</td>
                <td>{{ $associate['supervisor'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Employee Code</td>
                <td>{{ $associate['employee_code'] ?? '' }}</td>
                <td class="label">User ID</td>
                <td>{{ $associate['user_id'] ?? '' }}</td>
            </tr>
        </table>

        <div class="section-title">Personal Details</div>
        <table class=" " style=" width: 100%; border:1px solid black;  padding: 6px 8px; border-collapse: collapse;">
            <tr >
                <td style="border:1px solid black;  padding: 6px 8px; border-collapse: collapse;" class="label">Name</td>
                <td style="border:1px solid black;  padding: 6px 8px; border-collapse: collapse;" colspan="2">{{ $personal['name'] ?? '' }}</td>
                
                <td ></td>
            </tr>
            <tr>
                <td style="border:1px solid black;  padding: 6px 8px; border-collapse: collapse;" class="label">Fathers Name</td>
                <td style="border:1px solid black;  padding: 6px 8px; border-collapse: collapse;" colspan="2">{{ $personal['father_name'] ?? '' }}</td>
              
                <td></td>
            </tr>
            <tr>
                <td style="border:1px solid black;  padding: 6px 8px; border-collapse: collapse;" class="label">D.O.B(DD-MM-YYYY)</td>
                <td style="border:1px solid black;  padding: 6px 8px; border-collapse: collapse;" colspan="2">{{ $personal['dob'] ?? '' }}</td>
                
                <td></td>
            </tr>
             <tr>
                <td style="border:1px solid black;  padding: 6px 8px; border-collapse: collapse;" class="label">Reference By</td>
                <td style="border:1px solid black;  padding: 6px 8px; border-collapse: collapse;" colspan="2">{{ $personal['reference_by'] ?? '' }}</td>
                
                <td></td>
            </tr>
            
        </table>
        <div class="section-title">KYC Details</div>
        <table class="data-table">
            <tr>
                <td class="label">Address</td>
                <td colspan="3">{{ $kyc['address'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Aadhaar No</td>
                <td>{{ $kyc['aadhaar'] ?? '' }}</td>
                <td class="label">PAN No</td>
                <td>{{ $kyc['pan'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Mobile</td>
                <td>{{ $contact['mobile'] ?? '' }}</td>
                <td class="label">Email</td>
                <td>{{ $contact['email'] ?? '' }}</td>
            </tr>
        </table>

        <div class="section-title">Nominee Details</div>
        <table class="data-table">
            <tr>
                <td class="label">Name</td>
                <td>{{ $nominee['name'] ?? '' }}</td>
                <td class="label">Relation</td>
                <td>{{ $nominee['relation'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Address</td>
                <td colspan="3">{{ $nominee['address'] ?? '' }}</td>
            </tr>
        </table>

        <div class="section-title-remark " style="margin-top: 50px"> Remarks</div>
        {{-- <div style="border:1px solid #000; min-height:40px; padding:5px;">{{ $remarks ?? '' }}</div> --}}

        <table class="signature-section">
            <tr>
                <td width="40%">
                    <div class="signature-label">Signature of Branch Manager</div>
                </td>
                <td width="30%">
                    <div class="signature-label">Company Seal</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
