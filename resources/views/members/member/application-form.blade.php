<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Membership Application Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      margin: 0;
      padding: 0;
    }

    /* Force A4 page size */
    @page {
      size: A4;
      margin: 0;
    }

    .container,
    .container2 {
      width: 210mm;
      min-height: 297mm;
      margin: auto;
      padding: 20mm;
      page-break-after: always;
      box-sizing: border-box;
      border: none;   /* 🔹 remove outer border lines */
    }

    .container {
      padding-bottom: 20px;
      margin-bottom: 20px;
    }

    .header {
      text-align: center;
    }

    .header img {
      width: 80px;
    }

    h2,
    h3 {
      margin: 5px 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
      margin-top: 10px;
    }

    td,
    th {
      border: 1px solid #000;
      padding: 6px;
      vertical-align: top;
    }

    .section-title {
      font-weight: bold;
      margin-top: 15px;
    }

    .declaration {
      font-weight: bold;
      margin-top: 15px;
    }

    .signature {
      text-align: right;
      margin-top: 40px;
    }

    .print-btn {
      margin: 20px;
      text-align: center;
    }

    @media print {
      .print-btn {
        display: none;
      }
    }

    .membership-box {
      border: 1px solid #000;
      padding: 8px 12px;
      width: 95%;
      font-size: 14px;
    }

    .membership-box strong {
      font-weight: bold;
    }

    .col-idx {
      text-align: center;
      font-weight: 600;
    }

    .col-desc {
      text-align: left;
      padding-left: 12px;
    }

    .col-check {
      text-align: start;
    }

    .checkbox {
      display: inline-block;
      width: 14px;
      height: 14px;
      border: 2px solid #000;
      vertical-align: middle;
      text-align: left;
    }

    .note {
      font-size: 12px;
      border: 1px solid #000;
      border-top: none;
      padding: 5px;
    }

    .remarks {
      margin-top: 20px;
      height: 40px;
      padding: 5px;
    }

    .signature {
      margin-top: 50px;
      display: flex;
      justify-content: space-between;
      padding-bottom: 10px;
    }

    .letterhead {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 2px solid #000;
      padding-bottom: 8px;
      margin-bottom: 15px;
    }

    .logo {
      width: 120px;
      text-align: center;
    }

    .logo img {
      width: 100%;
      height: 100%;
    }

    .bank-details {
      flex: none;
      text-align: center;
      padding: 0 15px;
    }

    .bank-details h1 {
      font-size: 18px;
      margin: 0;
      font-weight: bold;
      white-space: nowrap;
    }

    .bank-details p {
      margin: 3px 0;
      font-size: 13px;
    }
  </style>
</head>


<body>

  <div class="print-btn">
    <button onclick="window.print()">Print Application</button>
  </div>

  <!-- Page 1 -->
  <div class="container">
    <div class="header">

      <div class="letterhead">
        <!-- Logo -->
        <div class="logo">
          <img src="{{ asset('assets/images/Loan_Management_logo.png') }}" alt="Logo">
        </div>
        <!-- Bank Details -->
        <div class="bank-details">
          <h1>SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA <br> LIMITED</h1>
          <br>
          <p>SHEGAON SHEGAON Maharashtra - 110012</p>
          <p>E: sbcglobalbank@gmail.com | L: 0724-2991230 | M: 9922870805</p>
          <p>CIN: 969/03-04</p>
        </div>
        <div class="logo"></div>
      </div>

      <h3>Membership Application Form ( M00081 )</h3>
    </div>

    <table>
      <tr>
        <td>Name</td>
        <td>JYOTI RAJKUMAR KALE</td>
        <td rowspan="5" style="width:150px;"></td>
      </tr>
      <tr>
        <td>F/H Name</td>
        <td></td>
      </tr>
      <tr>
        <td>Mother's Name</td>
        <td></td>
      </tr>
      <tr>
        <td>D.O.B. (DD/MM/YYYY)</td>
        <td>01/01/1976 | Age - 49 years</td>
      </tr>
      <tr>
        <td>Reference by</td>
        <td>GANESH BHATKAR</td>
      </tr>
    </table>

    <div class="section-title">Address</div>
    <table>
      <tr>
        <td>Address</td>
        <td colspan="3"></td>
      </tr>
      <tr>
        <td style="width: 25%;">City</td>
        <td style="width: 25%;"></td>
        <td style="width: 25%;">Pincode</td>
        <td style="width: 25%;"></td>
      </tr>
      <tr>
        <td>State</td>
        <td colspan="3">Maharashtra</td>
      </tr>
      <tr>
        <td>Mobile No.</td>
        <td>0000000000</td>
        <td>Email</td>
        <td></td>
      </tr>
    </table>

    <div class="section-title">Personal Details</div>
    <table>
      <tr>
        <td>Qualification</td>
        <td></td>
        <td>PAN</td>
        <td></td>
      </tr>
      <tr>
        <td>Aadhaar No</td>
        <td></td>
        <td>Voter ID</td>
        <td></td>
      </tr>
      <tr>
        <td>Occupation</td>
        <td></td>
        <td rowspan="2" style="padding-top:2.5%;">Monthly Income</td>
        <td rowspan="2"></td>
      </tr>
      <tr>
        <td>Marital Status</td>
        <td>MARRIED</td>
      </tr>
    </table>

    <div class="section-title">Nominee Details</div>
    <table>
      <tr>
        <td>Name</td>
        <td></td>
        <td>Relation</td>
        <td></td>
      </tr>
      <tr>
        <td>Address</td>
        <td colspan="3"></td>
      </tr>
    </table>

    <div class="section-title">Bank Details</div>
    <table>
      <tr>
        <td>Bank Name</td>
        <td></td>
        <td>IFSC Code</td>
        <td></td>
      </tr>
      <tr>
        <td>A/c No.</td>
        <td></td>
        <td>A/c Type</td>
        <td></td>
      </tr>
    </table>

    <div class="declaration">Declaration</div>
    <table>
      <tr>
        <td style="font-size:11px;">I <b>JYOTI RAJKUMAR KALE</b> want to become a member of <b>SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA LIMITED</b>. <br>
          Also I do hereby declare and affirm that the particulars given by me are correct to the best of my knowledge and nothing has been concealed. I further certify that there are no legal/or police case is/are registered in my name. I am bound to accept all the rules and regulations formed by Registrar of Companies in this regard.
        </td>
      </tr>
      <tr>
        <td style="text-align: end; ">Signature of Applicant</td>
      </tr>
    </table>

  </div>


  <!-- Page 2 -->
  <div class="container2 ">
    <div class="membership-box">
      I <strong>JYOTI RAJKUMAR KALE</strong> <span style="margin-right:80px; "> am paying ₹ </span><span style="margin-right:50%;">as MEMBERSHIP </span> for <strong>10.0/</strong> 1 share as the case maybe. <br>
      Membership Charges : <strong>₹ 10.0</strong><br><br>
      Date : <strong>14 February 2024</strong>
    </div>

    <div class="section-title">For Official use</div>
    <table>
      <tr>
        <td style="width: 30%;">Allotted Membership No.</td>
        <td>M00081</td>
      </tr>
      <tr>
        <td>Introducer Member Name</td>
        <td></td>
      </tr>
      <tr>
        <td>Introducer Member No.</td>
        <td></td>
      </tr>
      <tr>
        <td>Entered By Operator (Name)</td>
        <td></td>
      </tr>
      <tr>
        <td>Date</td>
        <td></td>
      </tr>
    </table>

    <div class="section-title">Know your customer (KYC) Documentation</div>

    <table class="kyc-table" role="table">

      <col style="width:5%">
      <col style="width:45%">
      <col style="width:50%">
      </colgroup>

      <tr>
        <td colspan="3" style="font-weight:700; padding:10px 12px;">A. Proof of Identity (Any one of the following)</td>
      </tr>

      <tr>
        <td class="col-idx">I</td>
        <td class="col-desc">Passport</td>
        <td class="col-check"><span class="checkbox"></span></td>
      </tr>

      <tr>
        <td class="col-idx">II</td>
        <td class="col-desc">Unique Identification No (UID) / Aadhaar No</td>
        <td class="col-check"><span class="checkbox"></span></td>
      </tr>

      <tr>
        <td class="col-idx">III</td>
        <td class="col-desc">Income Tax PAN Card</td>
        <td class="col-check"><span class="checkbox"></span></td>
      </tr>

      <tr>
        <td class="col-idx">IV</td>
        <td class="col-desc">Electoral Photo Identity Card (Voter Card)</td>
        <td class="col-check"><span class="checkbox"></span></td>
      </tr>

      <tr>
        <td class="col-idx">V</td>
        <td class="col-desc">Driving License</td>
        <td class="col-check"><span class="checkbox"></span></td>
      </tr>

      <tr>
        <td class="col-idx">VI</td>
        <td class="col-desc">Ration Card</td>
        <td class="col-check"><span class="checkbox"></span></td>
      </tr>

      <tr>
        <td colspan="3" style="font-weight:700; padding:10px 12px;">B. Proof of Address (Any one of the following)</td>
      </tr>

      <tr>
        <td class="col-idx">I</td>
        <td class="col-desc">Passport</td>
        <td class="col-check"><span class="checkbox"></span></td>
      </tr>

      <tr>
        <td class="col-idx">II</td>
        <td class="col-desc">Unique identification number (UID)</td>
        <td class="col-check"><span class="checkbox"></span></td>
      </tr>

      <tr>
        <td class="col-idx">III</td>
        <td class="col-desc">Electoral Photo identity card (Voter card)</td>
        <td class="col-check"><span class="checkbox"></span></td>
      </tr>

      <tr>
        <td class="col-idx">IV</td>
        <td class="col-desc">Driving License</td>
        <td class="col-check"><span class="checkbox"></span></td>
      </tr>

      <tr>
        <td class="col-idx">V</td>
        <td class="col-desc">Ration Card</td>
        <td class="col-check"><span class="checkbox"></span></td>
      </tr>

      <tr>
        <td class="col-idx">VI</td>
        <td class="col-desc">Telephone Bill</td>
        <td class="col-check"><span class="checkbox"></span></td>
      </tr>

      <tr>
        <td class="col-idx">VII</td>
        <td class="col-desc">Bank A/c Statement</td>
        <td class="col-check"><span class="checkbox"></span></td>
      </tr>

      <tr>
        <td class="col-idx">VIII</td>
        <td class="col-desc">Electricity Bill</td>
        <td class="col-check"><span class="checkbox"></span></td>
      </tr>

      <tr>
        <td colspan="3" class="kyc-note">
          (Document referred to serial numbers (vi), (vii) and (viii) above shall not be more than two months old)
          (One document from each category is must) 3 recent photo PP Size color photographs.
          All photographs to be self attested and verified by Branch Manager.
        </td>
      </tr>
    </table>

    <div class="remarks">Remarks</div>

    <div class="signature">
      <div>Signature of Branch Manager</div>
      <div>Company Seal</div>
    </div>
  </div>

</body>

</html>