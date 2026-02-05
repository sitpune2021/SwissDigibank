<!DOCTYPE html>
<html lang="mr">
<head>
    <meta charset="UTF-8">
    <title>नमुना ई-2</title>
   
    <style>
        body {
    font-family: "Noto Sans Devanagari", Mangal, sans-serif;
    margin: 0;
    /* padding: 20px; */
    background: #fff;
}

.page {
    width: 210mm;
    margin: auto;
}

h2, h3 {
    text-align: center;
    margin: 4px 0;
    font-weight: bold;
}

.main-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    table-layout: fixed;
}

.main-table th,
.main-table td {
    border: 1px solid #000;
    padding: 6px;
    font-size: 13px;
    vertical-align: top;
}

.main-table th {
    text-align: center;
    font-weight: bold;
}

.numbers td {
    text-align: center;
    font-weight: bold;
}

.inner-cell {
    padding: 0;
}

.inner-table {
    width: 100%;
    border-collapse: collapse;
}

.inner-table td {
    border-bottom: 1px solid #000;
    padding: 6px;
    font-size: 13px;
}

.inner-table tr:last-child td {
    border-bottom: none;
}

.notes {
    margin-top: 20px;
    font-size: 14px;
}

.notes ol {
    margin-top: 8px;
    padding-left: 20px;
}

@media print {
    body {
        padding: 0;
    }
    .page {
        width: 100%;
    }
}

    </style>
</head>
<body>

<div class="page">
   
    <div class="box mt-5">
 <div style="width:100%; font-family: dejavusans; ">

                <!-- Logo -->
                <div style="float:left; width:50%; padding: 0px 5px; text-align:left;">
                    <img src="{{ public_path('assets/images/SBC_Logo_gpg.jpg') }}" alt="Company Logo"
                        style="width:auto; height:50px;">
                </div>

                <!-- Title Section -->
                <div style="float:left; width:50%; text-align:center;">
                    <div style="  font-size:30px; font-weight: 800;  text-transform:uppercase; ">
                        {{-- SBC Global --}}
                    </div>

                    <div style="height:10px;">&nbsp;</div>


                </div>

               
            </div>
        <h2>नमुना ई-2</h2>
        <h3>(नियम 5 (2) पहा)</h3>
        <h3>{{ $companyName }} &nbsp; र. नं. 12345  &nbsp;  तालुका ______ जि._________</h3>

        <table class="main-table">
            <thead>
                <tr>
                    <th style="width: 5%"> अ. क्र.</th>
                    <th style="width: 25%">संस्थेचे नाव, नोंदणी क्रमांक व संपूर्ण पत्ता</th>
                    <th style="width: 12%">विद्यमान व्यवस्थापन समितीची पहिली सभा ज्या तारखेस झाली ती तारीख</th>
                    <th style="width: 12%">विद्यमान व्यवस्थापन समितीची मुदत ज्या तारखेस संपली / संपेल ती तारीख</th>
                    <th style="width: 18%"> उपविधीनुसार मतदार संघ</th>
                    <th>प्रत्येक मतदार संघाने निवडावयाचे व्यवस्थापन समितीचे सदस्य संख्या</th>
                    <th style="width: 10%">शेरा</th>
                </tr>
                <tr class="numbers">
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td style="width: 18%">5</td>
                    <td>6</td>
                    <td>7</td>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="border-right: none" ></td>

                    <!-- Column 5 inner table -->
                    <td class="" colspan="2" style="padding: 0; border: none; ">
                        <table class="" style="width: 100%; border:none !important;border-collapse: collapse;">
                            <tr >
                                <td style="width: 50%; ">
                                    सर्वसाधारण प्रतिनिधी मतदार संघ
                                </td>
                                <td style="width: 50%; padding-right: 50px; ">
                                
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; "   >
                                  अनुसुचित जाती जमाती मतदार संघ
                                </td>
                                <td style="width: 50%; ">
                                
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; ">महिला राखीव मतदार संघ</td>
                                <td style="width: 50%; ">
                                
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; "   >
                                    इतर मागासवर्गीय राखीव मतदार संघ
                                </td>
                                <td style="width: 50%; ">
                                
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; "   >
                                   भटक्या विमुक्त जाती /जमाती  व विषेश मागास प्रवर्ग मतदार संघ
                                </td>
                                <td style="width: 50%; ">
                                
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; "><strong>एकुण</strong></td>
                                <td style="width: 50%; ">
                                
                                </td>
                            </tr>
                        </table>
                    </td>

                

                    <td style="border-left: none"></td>
                </tr>
            </tbody>
        </table>

        <div class="notes">
            <p>प्रमाणित करण्यात येते की,</p>
            <ol>
                <li>	संस्था मतदारांची प्रारुप मतदार यादी संस्थेच्या व्यवस्थापक समितीची मुदत संपण्यापुर्वी 60/120 दिवस अगोदर सादर करेल.</li>
                <li>	नमुना ई-2 मध्ये सादर करण्यात आलेली माहिती संस्थेच्या दस्ताऐवाजांवरुन पडताळणी करुन अचुक / व बरोबर आहे</li>
                <li>	स्था मतदारांची प्रारुप मतदार यादी महाराष्ट्र सहकारी संस्था ( निवडणुक) नियम 2014 नुसार सादर करेल
                </li>
            </ol>
        </div>
        <div class="" style="text-align: right; margin-top: 50px;">सचिव/ व्यवस्थाक/ कार्यकारी संचालक.</div>
    </div>  </div>

</body>
</html>
