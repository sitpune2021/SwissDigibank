<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Letter udertaking gold loan</title>

    <style>
        @page {
            margin: 30px 40px;
            /* margin: 25mm; */
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .header {
            width: 100%;
            margin-bottom: 15px;
        }

        .header td {
            font-size: 11px;
        }

        .line {
            border-bottom: 2px solid #000;
            margin-top: 5px;
        }

        .content {
            margin-top: 20px;
            line-height: 1.6;
        }

        .address {
            margin-bottom: 20px;
        }

        .subject {
            margin: 15px 0;
        }

        table.details {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }

        table.details td {
            padding: 3px 0;
            vertical-align: top;
        }

        table.details td.label {
            width: 45%;
        }

        table.details td.colon {
            width: 5%;
        }

        table.details td.value {
            width: 50%;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 10px;
        }

        td {
            padding: 0px 45px;
        }

        .footer {
            margin-top: 25px;
        }

        .signature {
            margin-top: 40px;
        }

        .signature-name {
            margin-top: 5px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <table class="header" style="border:none !important;">
        <tr style="border:none !important;">
            <td align="left" style="font-size :14px; border:none !important;">
                Printed On : {{ $printed_on }}
            </td>
            <td align="right" style="font-size :14px; border:none !important;">
                Date :{{ $date }}
            </td>
        </tr>
    </table>

    <div class="line"></div>

    <!-- Content -->
    <div class="content">

        <div class="address" style="font-size: 14px; line-height: 1;">
            To <br>
            The Chief Loan Officer
            <br>
            {{  $bank_name  }}<br>
            {{ $bank_adr_branch}} <br>
            {{$bank_adr}}
        </div>


        <div class="" style="font-size:14px; font-weight: 800; font-size: larger; ">
            SUBJECT : LETTER OF UNDERTAKING
        </div>

        <div style="font-size: 14px;  margin-top: 12px;">
            Dear Sir,
        </div>
        <div class="">
            <span style="font-size:14px; font-weight: 800; font-size: larger; "> Ref: POST DATED CHEQUES IN CONNECTION
                WITH REPAYMENT OF LOAN ACCOUNT
               {{ str_pad( $loan_no, 10, '0', STR_PAD_LEFT) }} (Gold Loan)
            </span>
            ₹
            <span style="font-size:16px; font-weight: 800; font-size: larger; "> {{ number_format($loan_amount, 2) }}
                /-</span>
        </div>
        <div class="subject" style="font-size: 14px; line-height: 1;">
            In consideration of your having agreed to grant continued to grant loan of
            ₹{{ number_format($loan_amount, 2) }}/- 
            {{-- ({{ $loan_amount_words }})  --}}
            in the name(s) of {{ $account_holder }} repayable
            in MONTHLY installments of
            ₹ 
            {{-- {{ number_format($installments, 2)}} --}}
            /- each along with the interest/ service charges as per contractual
            obligation. I
            hereby deliver to you the post dated cheques with particulars as under to be enchased by you towards
            outstanding liability in aforesaid
            loan account
        </div>

        <!-- Details Table -->
        <table class="" style="font-size: 14px; border:1px solid #000 ;">
            <tr>
                <th>S.No</th>
                <th>Bank Name</th>
                <th>Cheque No.</th>
                <th>Account No.</th>
                <th>Cheque Date</th>
                <th>Amount</th>
            </tr>
            <tr>
                <td>&nbsp; &nbsp; &nbsp; &nbsp;</td>
                <td>&nbsp; &nbsp; &nbsp; &nbsp;</td>
                <td>&nbsp; &nbsp; &nbsp; &nbsp;</td>
                <td>&nbsp; &nbsp; &nbsp; &nbsp;</td>
                <td>&nbsp; &nbsp; &nbsp; &nbsp;</td>
                <td>&nbsp; &nbsp; &nbsp; &nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp; &nbsp; &nbsp; &nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp; &nbsp; &nbsp; &nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp; &nbsp; &nbsp; &nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp; &nbsp; &nbsp; &nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

        <div class="" style="font-size: 14px; line-height: 1; margin-top:13px; ">
            In case the above cheques are exhausted and other cheques are required in payment of the outstanding
            liability, I/ We
            undertake to deliver the same to you.
        </div>
        <div class="" style="font-size: 14px; line-height: 1; margin-top:13px; ">
            I/ We hereby undertake to provide adequate balance in the account with the drawee Bank to ensure that the
            aforesaid cheques
            as well as other cheques which may be delivered by me/ us in due course, as and when presented by you for
            payment, are
            honored and paid.
        </div>
        <div class="" style="font-size: 14px; line-height: 1; margin-top:13px; ">
            I/ We also undertake that in case any of the above cheque(s) is returned unpaid for any reason whatsoever,
            without prejudice to
            rights and privileges to recover the money in default, shall be entitled to initiate the proceedings against
            me/ us under section
            138 of Negotiable Instruments Act, 1881 and other relevant provisions of law for the time being in force at
            our cost and
            consequences.
        </div>
        <div class="" style="font-size: 14px; line-height: 1; margin-top:13px; ">
            I/ We distinctly understand that it is at the faith and belief of this undertaking that you have agreed to
            grant loan of
            ₹
           {{ number_format($loan_amount, 2) }}/- in name(s) of : {{ $account_holder }} (Name of Borrower Account)
        </div>

        <div class="signature" style="font-size: 14px;">
           Yours Faithfully,
            <br><br>
             <b>Signature of Borrower</b><br>
            {{ $account_holder }}<br>
          {{ $state }}  
        </div>

    </div>

</body>

</html>