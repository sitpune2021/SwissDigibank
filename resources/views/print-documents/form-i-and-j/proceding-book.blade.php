<!DOCTYPE html>
<html lang="mr">

<head>
    <meta charset="UTF-8">
    <style>
         @page {
        size: A4 landscape;
        /* margin: 15mm; */
    }
     body {
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #000;
        padding: 6px;
        vertical-align: top;
    }

    thead {
        display: table-header-group;
    }

    tr {
        page-break-inside: avoid;
    }
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

    <div class="title" style="font-size:24px;  ">सहकारी संस्था मर्यादीत &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; र. नं.</div>
    <div class="subtitle" style="font-size:18px; font-weight: bold; ">मासिक / वार्षिक प्रोसिडींग बुक</div>

   

    <table style="width: 100%">
        <thead>
            <tr>
                <th style="width:10%; font-size: 16px;">तारीख वेळ व ठिकाण</th>
                <th style=" width:35%;font-size: 16px;">सभेत हजर असलेल्या सदस्यांची  नावे</th>
                <th style="width:12%; font-size: 16px;">सदस्यांच्या सह्या</th>
                <th style="width:10%; font-size: 16px;">विषय क्रमांक</th>
                <th style="width:45%; font-size: 16px;">विषय</th>
                 <th style="width:10%; font-size: 16px;">ठराव क्र.</th>
                <th style="width:45%; font-size: 16px;">मंजूर झालेला ठराव</th>
                <th style="width:10%; font-size: 16px;">ठरावास अनुकूल सदस्यांची संख्या</th>
                <th style="width:10%; font-size: 16px;">ठरावास प्रतिकूल सदस्यांची संख्या</th>
                <th style="width:10%; font-size: 16px;">शेरा</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-size: 16px;   text-align: center;">१</td>
                <td style="font-size: 16px;  text-align: center;">२</td>
                <td style="font-size: 16px;  text-align: center;">३</td>
                <td style="font-size: 16px;  text-align: center;">४</td>
                <td style="font-size: 16px;  text-align: center;">५</td>
                 <td style="font-size: 16px;  text-align: center;">६ </td>
                <td style="font-size: 16px;  text-align: center;">७</td>
                <td style="font-size: 16px;  text-align: center;">८ </td>
                <td style="font-size: 16px;  text-align: center;">९</td>
                <td style="font-size: 16px;  text-align: center;">१०</td>
            </tr>
            @for ($i = 1; $i <= 40; $i++)
    <tr>
        <td style="padding: 20px 0px;"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
@endfor
        
           
        </tbody>
    </table>

</body>

</html>