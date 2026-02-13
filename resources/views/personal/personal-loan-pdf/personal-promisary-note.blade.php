
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Promissory Note & Receipt</title>
    <style>
        @page {
            /* margin: 30px 50px; */
            margin: 15mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px !important;
            color: #000;
        }

        .container {
            width: 100%;
        }

        .left-col {
            float: left;
            width: 58%;
            /* 60% minus spacing */
        }

        .right-col {
            float: right;
            width: 38%;
            /* 40% minus spacing */
        }

        .clearfix {
            clear: both;
        }
    </style>
</head>

<body>

    <div style="width:100%; ">
        <div style="float:left; width:60%; border:1px solid #000; padding:8px; margin-right:2%; padding:20px 5px ">

            <div class="" style=" text-align: center;">
                <span style="border: 1px solid #000; padding:5px; font-weight: 800; font-size: larger;">
                    PROMISSORY
                    NOTE
                </span>
            </div>
            <div class="" style="text-align: right; padding: 0 10px; margin-top: 10px;">
                date:{{$date}}
            </div>
            <div class="" style="padding: 5px;">
        <p style="font-size: 12px;line-height: 1; ">On demand I/ We {{$name}} of hereby promise to pay to
                   {{$bank_name}} residing at {{$bank_adr_branch}} {{$bank_adr}} the sum of
                    Rupees {{$amount_words}} only with interest at the rate of {{$interest_rate}}% annually for the value received in
                    this day.
                </p>
            </div>
            <div class="" style="width: 100%; height: 100px;">
                <div class="" style="float: left;">
                    ₹
                    <span style="border-bottom: 1px solid #000;">
                        {{$amount}}/-
                    </span>
                </div>
                <div class="" style="float: right; margin-right: 10px;">
                    <p style="border: 1px solid #000; padding: 16px;">STAMP</p>
                    <p style="text-align: center">Signature</p>
                </div>
            </div>
            <div class="" style=" text-align: center;">
                <span style="border: 1px solid #000; padding:5px; font-weight: 800; font-size: larger;">
                    SECURITY
                </span>
            </div>
            <div class="" style="padding: 5px;">
                <p style="font-size: 12px;line-height: 1; ">
                    I {{$name}} of Occupation residing at {{$state}} do hereby stand security for the
                    promissory note amount of
                    ₹
                    {{$amount}}/- and agree that on demand if {{$name}} does not
                    repay this promissory note amount to the said company {{$bank_name}}, I will pay the same myself.
                    I have written this as a deed of security so that it may remain as an authority

                </p>
            </div>
            <div class="" style="width: 100%; height: 100px;">
                <div class="" style="padding: 5px; float: left;">
                    <table>
                        <tr>
                            <th>witness: </th>
                            <td>1)</td>
                        </tr>
                        <tr>
                            <th> </th>
                            <td>2)</td>
                        </tr>
                        <tr>
                            <th> </th>
                            <td> 3)</td>
                        </tr>
                        <tr>
                            <th> </th>
                            <td>4)</td>
                        </tr>

                    </table>

                </div>
                <div class="" style="float: right; margin-top: 60px;">Signature</div>
            </div>

            <div class="" style="padding: 5px;">
                <p>Written By :</p>
            </div>
        </div>

        <div style="float:left; width:38%; border:1px solid #000; padding:8px;  padding:20px 5px ">


            <div class="" style=" text-align: center;">
                <span style="border: 1px solid #000; padding:5px; font-weight: 800; font-size: larger;">
                    RECEIPT

                </span>
            </div>
            <div class="" style="text-align: right; padding: 0 10px; margin-top: 10px;">
                date:{{$date}}
            </div>
            <div class="" style="padding: 5px;">
                <p style="font-size: 12px;line-height: 1; ">
                    I/ We {{$name}} Son/ Daughter/ Wife of Received
                    from {{$bank_name}} the sum of {{$amount_words}} only towards the
                    Promissory Note executed by me/ us on this day
                </p>
            </div>
            <div class="" style="width: 100%; height: 86px;">
                <div class="" style="float: left;">
                    ₹
                    <span style="border-bottom: 1px solid #000;">
                        {{$amount}}/-
                    </span>
                </div>
                <div class="" style="float: right; margin-right: 10px;">
                    <p style="border: 1px solid #000; padding: 16px;">STAMP</p>
                    <p style="text-align: center ; margin-top:0px;">Signature</p>
                </div>
            </div>
           
            <div class="" style="width: 100%; height: 296px;">
                <div class="" style="padding: 5px; float: left;">
                    <table>
                        <tr >
                            <th style="padding: 3px 0 !important;" >witness: </th>
                            <td  >1)</td>
                        </tr>
                        <tr>
                            <th > </th>
                            <td style="padding: 3px 0 !important;">2)</td>
                        </tr>
                        <tr>
                            <th > </th>
                            <td style="padding: 3px 0 !important;"> 3)</td>
                        </tr>
                        <tr>
                            <th > </th>
                            <td style="padding: 3px 0 !important;" >4)</td>
                        </tr>

                    </table>

                </div>
              
            </div>

           
        </div>

        <div style="clear:both;"></div>
    </div>


</body>

</html>