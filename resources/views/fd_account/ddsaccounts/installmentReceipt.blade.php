<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Header Section</title>
  <style>
    .header {
      width: 100%;
      overflow: hidden;
      /* clear floats */
      /* background-color: #000; */
      color: #101010;
      padding: 10px 15px;
      box-sizing: border-box;
      /* border: 1px solid black; */
    }

    .header-left {
      float: left;
      width: 20%;
    }

    .header-left img {
      max-width: 100%;
      height: auto;
      display: block;
    }

    .header-right {
      float: right;
      width: 75%;
      text-align: right;
      font-size: 14px;
      line-height: 1.5;
    }

    /* Ensure both sides align properly in PDF renderers */
    .clearfix::after {
      content: "";
      display: table;
      clear: both;
    }

    .name-left {
      float: left;
      width: 70%;
    }

    .name-right {
      float: right;
      width: 30%;
      text-align: right;
      font-size: 14px;
      line-height: 1.5;
    }

    .nameAndrecipt {
      border: 1px solid black;
    }

    .receipt-table {
      width: 100%;
      border-collapse: collapse;
      font-family: Arial, sans-serif;
      font-size: 14px;
    }

    .receipt-table,
    .receipt-table th,
    .receipt-table td {
      /* border: 1px solid #000; */
    }

    .receipt-table td {
      padding: 6px 10px;
      vertical-align: top;
    }

    .receipt-table tr:nth-child(even) {
      background-color: #f9f9f9;
      /* optional row shading */
    }

    .receipt-label {

      width: 50%;
    }

    .receipt-value {
      text-align: right;
      /* optional: aligns content right */
      width: 50%;

    }

    .cutomer-right {
      float: left;
      width: 70%;
      border: 1px solid black;
      border-top: none;
    }

    .installment-left {
      float: right;
      width: 30%;
    }

    .equal-width-row {
      width: 33.33%;
      box-sizing: border-box;
    }

    .signatures {
      width: 100%;
    }

    .signatures p {
      float: left;
      width: 33.33%;
      text-align: center;
    }

    .rupee:before {
      content: "\20B9\00a0";
    }
   
  </style>
</head>

<body>

  <div class="header clearfix">
    <div class="header-left">
      <img src="{{ public_path('assets/images/sbc-image.png') }}" alt="err" style="width: 90px; height: 90px;">
    </div>

    <div class="header-right">

    </div>
  </div>
  <div class="nameAndrecipt clearfix">
    <div class="name-left">
     <p style="padding:0px 10px; font-size:14px;">
    Received with thanks from: <b>{{ $name }}</b><br>
    {{ $state }}
  </p>
    </div>

    <div class="name-right">
      <table class="receipt-table">
        <tr>
          <td class="receipt-label" style="border: 1px solid black; border-top: none;font-size: 12px;">RECEIPT NO.</td>
          <td class="receipt-value" style="border-bottom: 1px solid black;font-size: 12px;">{{ $receiptno }}</td>
        </tr>
        <tr>
          <td class="receipt-label" style="border-left: 1px solid black; font-size: 12px;">DATED</td>
          <td class="receipt-value" style="border-left: 1px solid black;font-size: 12px;">{{ $dated }}</td>

        </tr>
      </table>
    </div>
  </div>

  <div class="">
    <div class="">
      <div class="cutomer-right">
        <table style="border-collapse:collapse" cellpadding="10">
          <tr>
            <td colspan="4" style="border-bottom: 1px solid black ;  font-size: 14px;">
              CustomerNo. {{$member_no}}
            </td>
          </tr>
          <tr>
            <td style="border-bottom: 1px solid black !important; padding: 3px; font-size: 14px; padding:3px 13px">
              DD No.
              {{ $dd_no }}
            </td>
            <td style="border: 1px solid black !important; font-size: 14px; padding:3px 13px">
              Effective Date<br>
               {{$open_date}}
            </td>
            <td style="border-bottom: 1px solid black !important;padding:3px 20px ;font-size: 14px;">
              Plan Tenure <br>
             {{$total_installments}} DAYS
            </td>
            <td
              style="border-bottom: 1px solid black !important; border-left: 1px solid black; padding:3px 34px; font-size: 14px;">
              Payment Mode <br>
              {{$pay_mode}} 
            </td>
          </tr>

        </table>

        <table style="border-collapse:collapse;  ">
          <tr class="equal-width-row">
            <td style="border-right: 1px solid black; padding-bottom: 15px !important; padding: 10px ;">
              Due  Date 
               {{$dueDate }} 
            </td>
            <td style="border-right: 1px solid black; padding: 5px ; ">
              Next Installment Due Date
              {{$nextinsdue }} 
            </td>
            <td style="padding: 1px; font-family: 'DejaVu Sans'; font-size:14px;">
              Deposit Amount as per Mode
              ₹ {{$DepositAmountperMode }} 
            </td>
          </tr>

        </table>

      </div>
      <div class="installment-left">
        <table
          style="border-collapse: collapse; width: 100%;  border: 1px solid black; border-top:none; border-left: none;">
          <tr>
            <td style="border-bottom: 1px solid black ; padding: 10px 5px; font-size:14px ;">
              Installment No.
            </td>
            <td
              style="border-bottom: 1px solid #101010;border-left: 1px solid black; padding: 5px; text-align: center; font-size:14px ;">
            {{$installmentNo }} 
            </td>
          </tr>
          <tr>
            <td style="padding:3px 5px; font-size: 14px;">
              Deposit Amount
            </td>
            <td
              style="border-top: 1px solid #101010;border-left: 1px solid black; padding: 5px; text-align: center; font-size:14px ;">
             {{$depositAmount}}
            </td>
          </tr>
          <tr>
            <td style="padding:3px 5px;font-size:14px ;">
              Other Charges
            </td>
            <td
              style="border-top: 1px solid #101010;border-left: 1px solid black; padding: 5px; text-align: center;font-size:14px ;">
               {{$otherCharges}}
            </td>
          </tr>
          <tr>
            <td style="padding:3px 5px;font-size:14px ;">
              Previous Balance
            </td>
            <td
              style="border-top: 1px solid #101010;border-left: 1px solid black; padding: 5px; text-align: center;font-size:14px ;">
               {{$previousBalance}}
            </td>
          </tr>
          <tr>
            <td style="border-top: 1px solid black ; padding:10px 5px;font-size:14px ;">
              Total
            </td>
            <td
              style="border-top: 1px solid #101010;border-left: 1px solid black; padding: 5px; text-align: center;font-size:14px ;">
               {{$total}}
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <div style=" border: 1px solid black; border-top:none; box-sizing: border-box;">

    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
      <tr>
        <td style="width: 100%; padding-bottom: 7px; border: none;">
          <div  style="width: 100%;  padding: 5px; font-family: 'DejaVu Sans'">
           <span style="font-weight: 800;">Amount in words:</span>  ₹  <span style="font-weight: 800;"> {{$wordAmt}}  </span>
          </div>
        </td>
      </tr>
    </table>

  </div>
  <div style="border: 1px solid black; border-top: none; font-size: 14px;">

    <table style="width: 100%; border-collapse: collapse; font-size: 14px; text-align: center;">
      <tr>
        <td colspan="3" style="padding: 8px; padding-bottom: 20px !important; text-align: left; font-size: 14px;">
          Receipt of Payment made by Cheque is issued subject to realization of the cheque
        </td>
      </tr>
      <tr>
        <td style="width: 33.33%;  padding: 10px;font-weight: 900; font-size: 14px; ">
          Signature of Cashier
        </td>
        <td style="width: 33.33%; padding: 10px;font-weight: 900; font-size: 14px;">
          Signature of Authorised Officials
        </td>
        <td style="width: 33.33%; padding: 10px;font-weight: 900; font-size: 14px; ">
          Company Seal
        </td>
      </tr>
    </table>
  </div>
</body>

</html>