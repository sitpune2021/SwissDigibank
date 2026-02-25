<!DOCTYPE html>
<html lang="mr">

<head>
    <meta charset="UTF-8">
    <style>
        body {

            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }

        .subtitle {
            text-align: center;
            margin-top: 5px;
        }

        .header {
            margin-top: 15px;
            margin-bottom: 10px;
            font-weight: bold;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            height: 22px;
        }

        th {
            text-align: center;
            font-weight: bold;
        }

        td {
            vertical-align: top;
        }
    </style>
</head>

<body>

    <div class="title" style="font-size:24px;  ">नमुना ‘जे’</div>
    <div class="subtitle" style="font-size:14px;  ">नियम ३२ (कलम ३९ अन्वये)</div>

    <div class="header" style="font-size: 20px;">
         {{$companyName}} र. नं. 12345
    </div>

    <div style="text-align:center; font-weight:bold;font-size: 20px;    ">
        ________________________सदस्यांची यादी
    </div>

    <table style="width: 100%">
        <thead>
            <tr>
                <th style="width:6%; font-size: 16px;">अनुक्रमांक</th>
                <th style="width:30%; font-size: 16px;">सदस्याचे नाव</th>
                <th style="width:40%; font-size: 16px;">पत्ता</th>
                <th style="width:12%; font-size: 16px;">सदस्याचा वर्ग</th>
                <th style="width:10%; font-size: 16px;">शेरा</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-size: 16px;  text-align: center;">१</td>
                <td style="font-size: 16px;  text-align: center;">२</td>
                <td style="font-size: 16px;  text-align: center;">३</td>
                <td style="font-size: 16px;  text-align: center;">४</td>
                <td style="font-size: 16px;  text-align: center;">५</td>
            </tr>
            @foreach($members as $index => $member)
            <tr>
                <td style="font-size: 16px;">{{ $index + 1 }}</td>

                <td style="font-size: 16px;">
                    {{ $member->member_info_first_name }}
                    {{ $member->member_info_middle_name }}
                    {{ $member->member_info_last_name }}
                </td>

                <td style="font-size: 16px;">
                    {{ $member->address->member_address_line_1 ?? '' }},
                    {{ $member->address->member_address_city_district ?? '' }},
                    {{ $member->address->state->name ?? '-' }},
                    {{ $member->address->member_address_country ?? '' }},
                    {{ $member->address->member_address_pincode ?? '' }},
                </td>

                <td style="font-size: 16px;">{{ $member->membership_type }}</td>

                <td style="font-size: 16px;"></td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>