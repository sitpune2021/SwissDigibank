     @php
     function numberToWords($num) {
     $ones = [
     0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four',
     5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine',
     10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen',
     14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen',
     17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen'
     ];
     $tens = [
     0 => '', 2 => 'twenty', 3 => 'thirty', 4 => 'forty',
     5 => 'fifty', 6 => 'sixty', 7 => 'seventy',
     8 => 'eighty', 9 => 'ninety'
     ];

     if ($num < 20) {
         return ucfirst($ones[$num]);
         } elseif ($num < 100) {
         return ucfirst($tens[intval($num / 10)] . ($num % 10 ? '-' . $ones[$num % 10] : '' ));
         } elseif ($num < 1000) {
         return ucfirst($ones[intval($num / 100)] . ' hundred' . ($num % 100 ? ' ' . numberToWords($num % 100) : '' ));
         } elseif ($num < 100000) {
         return ucfirst(numberToWords(intval($num / 1000)) . ' thousand' . ($num % 1000 ? ' ' . numberToWords($num % 1000) : '' ));
         }

         return (string) $num;
         }

         $sharesInWords=numberToWords((int) $shareholding->shares);

         @endphp

         <!DOCTYPE html>
         <html lang="en">

         <head>
             <meta charset="UTF-8">
             <title>Share Certificate</title>
             <style>
                 @page {
                     size: A4;
                     margin: 20mm;
                 }

                 body {
                     font-family: Arial, sans-serif;
                     margin: 0;

                     background: #f4f8f9;
                 }

                 .container {
                     width: 600px;
                     margin: auto;
                     padding: 20px 20px;
                     box-sizing: border-box;
                     background: white;

                 }

                 .header {
                     display: flex;
                     justify-content: space-between;
                     align-items: flex-start;
                     padding-bottom: 5px;
                 }

                 .header-left {
                     font-size: 15px;
                     line-height: 1.4;
                 }

                 .header-left h1 {
                     color: #004f9e;
                     font-size: 20px;
                     margin: 0;
                     font-weight: bold;
                     line-height: 1.3;
                 }

                 .header-left .reg {
                     color: red;
                     font-weight: bold;
                     margin-top: 2px;
                 }

                 .header-hr {
                     border: none;
                     border-top: 2px solid red;
                     margin: 6px 0 10px;
                     width: 100%;
                 }

                 .logo img {
                     height: 80px;
                 }

                 .form-title {
                     text-align: center;
                     font-weight: bold;
                     margin-top: 15px;
                 }

                 .share-title {
                     text-align: center;
                     font-weight: bold;
                     margin-top: 5px;
                 }

                 .subtitle {
                     font-size: 15px;
                     text-align: center;
                     font-style: italic;
                     font-weight: bold;
                     margin: 5px 0 15px;
                 }

                 p {
                     font-size: 15px;
                     text-align: justify;
                     line-height: 1.5;
                 }

                 .box {
                     border: 1px solid black;
                     padding: 10px;
                     font-size: 15px;
                     margin-top: 8px;
                 }

                 .row {
                     display: flex;
                     justify-content: space-between;
                     margin-top: 8px;
                     border: 1px solid black;
                     padding: 10px;
                 }

                 .row div {
                     width: 48%;
                     font-size: 15px;
                 }
             </style>
         </head>

         <body>

             <div class="container">
                 <div class="header">
                     <div class="header-left">
                         <h1>SHRI SAMARTH NAGRI SAHKARI<br>PAT SANSTHA LIMITED</h1>
                         <div class="reg">Reg No: 969/03-04</div>
                         <hr class="header-hr">
                         SHEGAON SHEGAON Maharashtra - 110012<br>
                         Tel : 9922870805, 0724-2991230<br>
                         Email : sbcglobalbank@gmail.com
                     </div>
                     <div class="logo">
                         <img src="data:image/png;base64,PUT-YOUR-LOGO-BASE64-HERE" alt="Logo">
                     </div>
                 </div>

                 <div class="form-title">Form No. SH - 1</div>
                 <div class="share-title">SHARE CERTIFICATE</div>
                 <div class="subtitle">[Pursuant to sub-section (3) of section 46 of the Companies Act, 2013 and rule 5(2) of the Companies (Share Capital and Debentures) Rules 2014]</div>

                 <p>This is to certify that the person(s) named in this Certificate is/are the Registered Holder(s) of the within mentioned share(s) bearing the distinctive number(s) herein specified in the above named Company subject to the Memorandum and Articles of Association of the Company and the amount endorsed herein has been paid up on each such share.</p>

                 <div class="box">
                     EQUITY SHARES EACH OF RUPEES 10/- (TEN ONLY) (Nominal value)<br>
                     AMOUNT PAID-UP PER SHARE RUPEES 10/- (TEN ONLY)
                 </div>

                 <div class="row">
                     <div>
                         <b>Reg. Folio No:</b> 2<br>
                         <b>Name(s) of the Holder(s):</b>{{ $shareholding->members->member_info_first_name }}<br>

                         <b>No. of Shares Held:</b> {{ $sharesInWords }} (in words) {{ $shareholding->shares }} (in figures)<br>
                         <b>Distinctive No (s):</b> From {{ $shareholding->from_share_no }} to {{ $shareholding->to_share_no }} (Both inclusive)
                     </div>
                     <div style="text-align: right;">
                         <b>Certificate No:</b> {{ $shareholding->certificate_number }}
                     </div>
                 </div>

                 <p>Given under the common seal of the Company on {{ \Carbon\Carbon::now()->format('d/m/Y') }}<br><br>


                     1. Secretary/ any other Authorised person :</p>
                 <br><br><br><br><br>
             </div>


             <!-- Start Second Page -->
             <div class="container" style="page-break-before: always;">
                 <table style="width:100%; border-collapse:collapse; font-size:14px; text-align:center;">
                     <thead>
                         <tr>
                             <th colspan="6" style="border:1px solid #000; font-weight:bold; padding:10px;">
                                 MEMORANDUM OF TRANSFERS
                             </th>
                         </tr>
                         <tr>
                             <th style="border:1px solid #000; padding:10px;">Name of Transferor</th>
                             <th style="border:1px solid #000; padding:10px;">Name of Transferee</th>
                             <th style="border:1px solid #000; padding:10px;">Reg. Ledger Folio No. of Transferee</th>
                             <th style="border:1px solid #000; padding:10px;">Number of Shares</th>
                             <th style="border:1px solid #000; padding:10px;">Date of Transfer</th>
                             <th style="border:1px solid #000; padding:10px;">Signature of Authorised Signatory</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr>
                             <td style="border:1px solid #000; padding:10px; text-align:left;">{{ $shareholding->shareholdings?->promotor?->first_name ?? '' }}</td>
                             <td style="border:1px solid #000; padding:10px; text-align:left;">{{ $shareholding?->members?->member_info_first_name??'' }}</td>
                             <td style="border:1px solid #000; padding:10px;">6426</td>
                             <td style="border:1px solid #000; padding:10px;">{{ $shareholding?->shares??'' }}</td>
                             <td style="border:1px solid #000; padding:10px;">{{ $shareholding?->transfer_date??'' }}</td>
                             <td style="border:1px solid #000; padding:10px;"></td>
                         </tr>
                         <!-- Empty rows for future entries -->
                         <tr>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                         </tr>
                         <tr>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                         </tr>
                         <tr>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                         </tr>
                         <tr>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                         </tr>
                         <tr>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                         </tr>
                         <tr>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                             <td style="border:1px solid #000; padding:40px;"></td>
                         </tr>
                     </tbody>
                 </table>

                 <div style="font-size:12px; font-style:italic; margin-top:4px;">
                     Note: No transfer of the Share(s) comprised in the Certificate can be registered unless accompanied by this Certificate
                 </div>
                 <br><br><br><br><br><br><br><br>
             </div>
         </body>
         </html>