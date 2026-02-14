<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Gold Loan Application</title>


    <style>
        *{
            font-size: 11px !important;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            /* background:#eee; */
            
        }

        /* .page{
        width:800px;
        margin:20px auto;
        background:#fff;
        padding:20px;
        border:1px solid #ccc;
    } */

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        td,
        th {
            border: 1px solid #333;
            padding: 6px;
            vertical-align: top;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }

        .subtitle {
            font-size: 14px;
            text-align: center;
        }

        .section {
            background: #e6a2a2;
            font-weight: bold;
            text-align: center;
        }

        .logo {
            width: 90px;
        }

        .no-border td {
            border: none;
        }

        .small {
            font-size: 12px;
        }

        @media print {
            body {
                background: #fff;
            }

            .page {
                border: none;
                margin: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="page">

        <!-- HEADER -->
        <div style="width:100%; font-family: dejavusans; border-bottom: 1px solid #000 ; padding: 5px;">

            <!-- Logo -->

            <div style="float:left; width:30%; text-align:left;  margin-top: 0 !important;">
                <img src="{{public_path('assets/images/SBC_Logo_gpg.jpg') }}" alt="logo"
                    style=" width:auto; height:50px;">
                {{-- @if($logo) --}}

                {{-- <img src="{{ public_path($logo->image_path) }}" alt="logo"
                    style="max-width:90px; max-height:90px;"> --}}
                {{-- @else --}}
                {{-- <img src="{{ public_path('assets/images/Loan_Management_Logo.png') }}" alt="default logo"
                    style="max-width:90px; max-height:90px;"> --}}
                {{-- @endif --}}
                {{-- <img src="{{ public_path('assets/images/SBC_Logo.jpg') }}" alt="Company Logo"
                    style="width:130px; height:130px;"> --}}
            </div>

            <!-- Title Section -->
            {{-- <div style="float:left; width:70%; text-align:center;">
                <div style="  font-size:30px; font-weight: 800;  text-transform:uppercase; "> --}}
                    {{-- SBC Global --}}
                    {{-- </div> --}}

                {{-- <div style="height:10px; margin-top: 40px;">&nbsp;</div> --}}


                {{--
            </div> --}}

            <!-- Clear Float -->
            <div style="clear:both; "></div>
            <h4 style=" text-align: center; font-size:18px; margin: 0 !important; font-weight:bold;">
                GOLD LOAN APPLICATION FORM
            </h4>
        </div>

        <br>

        <div class="" style="text-align: right">
            Printed On :12-12-2025(static)
        </div>
        <table style="margin-top: 10px;">

            <tr>
                <td colspan="2" class="small">
                    Fields marked with (*) are Mandatory<br>
                    Please fill the form in English in BLOCK letters
                </td>
                <td>
                    Application No. GLA00004(static)
                </td>
            </tr>
            <tr>
                <td colspan="3" class="center  small">
                    LANGUAGE UNDERSTOOD BY APPLICANT / BORROWER (HINDI) (ENGLISH)
                </td>
            </tr>
        </table>

        <br>

        <table>
            <tr>
                <td colspan="6" class="section">INDIVIDUAL / SOLE PROPRIETOR</td>
            </tr>

            <tr>
                <td colspan="6" class="center bold">APPLICANT INFORMATION</td>
            </tr>

            <tr>
                <td class="bold">FULL NAME*</td>
                <td colspan="3">Mr. Shreepad Page(static)</td>
                <td class="bold">GENDER*</td>
                <td>Male(static)</td>
            </tr>
        </table>
        <table style="margin-top: 10px;">
            <tr>
                <td class="">PAN*</td>
                <td>AADHAR CARD NO. (last four digits)</td>
                <td class="">BIRTH DATE*</td>
                <td>AGE*</td>
                <td class="">PLACE OF BIRTH*</td>
                <td>CITIZENSHIP</td>
                <td>
                    MARITAL STATUS
                </td>
                <td style="width: 20%;" rowspan="4">
                    Colour Photograph
                </td>
            </tr>

            <tr>
                <td class="">CLOPP3941G(static)</td>
                <td>XXXX XXXX 2964(static)</td>
                <td class="">24-02-1994(static)</td>
                <td>31(static)</td>
                <td class=""></td>
                <td>India(static)</td>
                <td></td>

            </tr>
            <tr>
                <td class="">OCCUPATION*</td>
                <td colspan="4"></td>

                <td>CKYC No. </td>
                <td></td>

            </tr>
            <tr>
                <td class="">PRESENT RESIDENCE ADDRESS*</td>
                <td colspan="4">Maharashtra(static)</td>

                <td>Pin Code*</td>
                <td></td>

            </tr>
            <tr>
                <td class="">PERMANENT ADDRESS*</td>
                <td colspan="4">pune(static)</td>

                <td>Pin Code*</td>
                <td></td>
                <td rowspan="2" style="height: 70px;">Across signature/ Thumb Impression</td>

            </tr>
            <tr>
                <td  class="">E-MAIL*</td>
                <td  colspan="2"></td>
                <td>FATHER'S NAME*</td>
                <td  style="width: 16.66%"></td>
                <td >MOTHER’S NAME*</td>
                <td ></td>

            </tr>
            <tr>
                <td class="">EDUCATION LEVEL </td>
                <td colspan="2"></td>
                <td>MOBILE NO</td>
                <td></td>
                <td>TEL. No.</td>
                <td colspan="2"></td>

            </tr>
            <tr>
                <td colspan="2">YEARS IN PRESENT ADDRESS:</td>

                <td colspan="6"></td>

            </tr>
            <tr>
                <td colspan="3">No. of Dependents (including children (s))*</td>

                <td colspan="2"></td>

                <td colspan="2">Monthly Household Expense</td>

                <td></td>
            </tr>
            <tr>
                <td colspan="2">Type of Loan*</td>

                <td colspan="6"></td>

            </tr>


        </table>

        <table style="margin-top: 10px;">
            <tr>
                <td colspan="6" class="center bold">BUSINESS INFORMATION</td>
            </tr>

            <tr>
                <td style="width: 16.66%;" class="">Name of Entity:*</td>
                <td style="width: 16.66%;" colspan=""></td>
                <td style="width: 16.66%;" class="">Trade Name:</td>
                <td style="width: 16.66%;"></td>
                <td style="width: 16.66%;" class="">CKYC No.</td>
                <td style="width: 16.66%;"></td>
            </tr>
            <tr>
                <td style="width: 16.66%;" class="">Legal Status of Entity:*</td>
                <td style="width: 16.66%;" colspan=""></td>
                <td style="width: 16.66%;" class="">PAN*</td>
                <td style="width: 16.66%;"></td>
                <td style="width: 16.66%;" class="">GST No.</td>
                <td style="width: 16.66%;"></td>
            </tr>
            <tr>
                <td style="width: 16.66%;" class="">Address:*</td>
                <td style="width: 16.66%;" colspan=""></td>
                <td style="width: 16.66%;" class="">Tel. No.</td>
                <td style="width: 16.66%;"></td>
                <td style="width: 16.66%;" class="">Fax No.</td>
                <td style="width: 16.66%;"></td>
            </tr>
            <tr>
                <td style="width: 16.66%;" class="">Years of Stay in present location*</td>
                <td style="width: 16.66%;" colspan=""></td>
                <td style="width: 16.66%;" class="">Years in Operation*</td>
                <td style="width: 16.66%;"></td>
                <td style="width: 16.66%;" class="">No. of Employees</td>
                <td style="width: 16.66%;"></td>
            </tr>
            <tr>
                <td style="width: 16.66%;" class="">Nature of Business*</td>
                <td style="width: 16.66%;"></td>
                <td style="width: 16.66%;" colspan="2">Business Info</td>
                <td style="width: 16.66%;" colspan="2"></td>

            </tr>
        </table>
        <table style="margin-top: 10px;">
            <tr>
                <td colspan="2" class="center bold">YEAR</td>
                <td colspan="2" class="center bold">GROSS SALES/ INCOME/SALARY/ OTHER INCOME</td>
                <td colspan="2" class="center bold">TOTAL INCOME</td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 15px !important;"></td>
                <td colspan="2" class=""></td>
                <td colspan="2" class=""></td>
            </tr>
            <tr>
                <td colspan="2" class="" style="padding: 15px !important;"></td>
                <td colspan="2" class=""></td>
                <td colspan="2" class=""></td>
            </tr>


        </table>
        <table style="margin-top: 10px;">
            <tr>
                <td colspan="6" class="center bold">BANK ACCOUNT DETAILS OF THE CUSTOMER*</td>

            </tr>
            <tr>
                <td style="width: 16.66%;" class="">Account Holder Name</td>
                <td style="width: 16.66%;" colspan="">Name of the Bank*</td>
                <td style="width: 16.66%;" class="">Branch*</td>
                <td style="width: 16.66%;"> IFSC Code</td>
                <td style="width: 16.66%;" class="">Account No. (16 Digits)*</td>
                <td style="width: 16.66%;">Nature of Account*</td>
            </tr>
            <tr>
                <td style="width: 16.66%; padding: 15px;" class=""></td>
                <td style="width: 16.66%;" colspan=""></td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"> </td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"></td>
            </tr>
            <tr>
                <td style="width: 16.66%; padding: 15px;" class=""></td>
                <td style="width: 16.66%;" colspan=""></td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"></td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"></td>
            </tr>
            <tr>
                <td style="width: 16.66%; padding: 15px;" class=""></td>
                <td style="width: 16.66%;" colspan=""></td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"></td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"></td>
            </tr>
            <tr>
                <td style="width: 16.66%; padding: 15px;" class=""></td>
                <td style="width: 16.66%;" colspan=""></td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"></td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"></td>
            </tr>

        </table>
        <table style="margin-top: 10px;">
            <tr>
                <td colspan="6" class="center bold">
                    LOAN INFORMATION
                </td>

            </tr>
            <tr>
                <td style="width: 16.66%;" colspan="2">Loan Amount Applied For (IN INR):</td>
                <td style="width: 16.66%;" colspan="">23000.0(static)</td>

                <td style="width: 16.66%;" colspan="2"> Purpose of the Loan:</td>
                <td style="width: 16.66%;" class="">gold(static)</td>

            </tr>
            <tr>
                <td style="width: 16.66%;" colspan="2">Facility Term Loan:</td>
                <td style="width: 16.66%;" colspan="">5 MONTHS(static)</td>

                <td style="width: 16.66%;" colspan="2">Business Credit Line (BCL)</td>
                <td style="width: 16.66%;" class="">(static)</td>
            </tr>
            <tr>
                <td style="width: 16.66%;" colspan="3">Term / Frequency</td>
                <td style="width: 16.66%;" colspan="3">MONTHLY(static)</td>
            </tr>


        </table>
        <table style="margin-top: 10px;">
            <tr>
                <td colspan="6" class="center bold">
                    REFERENCES
                </td>

            </tr>
            <tr>
                <td style="width: 16.66%;" colspan="2">Full Name</td>
                <td style="width: 16.66%;" colspan=""></td>

                <td style="width: 16.66%;" colspan="2">Relationship with Applicant</td>
                <td style="width: 16.66%;" class=""></td>

            </tr>
            <tr>
                <td style="width: 16.66%;" colspan="2">Address</td>
                <td style="width: 16.66%;" colspan="">City</td>

                <td style="width: 16.66%;" colspan="2">State</td>
                <td style="width: 16.66%;" class="">Telephone No.</td>
            </tr>
            <tr>
                <td style="width: 16.66%; padding: 15px;" colspan="2"></td>
                <td style="width: 16.66%;" colspan=""></td>

                <td style="width: 16.66%;" colspan="2"></td>
                <td style="width: 16.66%;" class=""></td>
            </tr>



        </table>
        <table style="margin-top: 10px;">
            <tr>
                <td colspan="6" class="center bold">LOANS WITH BANKS AND FINANCIAL INSTITUTIONS</td>

            </tr>
            <tr>
                <td style="width: 16.66%;" class="">Name of Bank</td>
                <td style="width: 16.66%;" colspan="">Type of Loan</td>
                <td style="width: 16.66%;" class="">Loan Amount</td>
                <td style="width: 16.66%;"> Monthly Amortization</td>
                <td style="width: 16.66%;" class="">Collateral</td>
                <td style="width: 16.66%;">Outstanding Balance</td>
            </tr>
            <tr>
                <td style="width: 16.66%; padding: 15px;" class=""></td>
                <td style="width: 16.66%;" colspan=""></td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"> </td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"></td>
            </tr>
            <tr>
                <td style="width: 16.66%; padding: 15px;" class=""></td>
                <td style="width: 16.66%;" colspan=""></td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"></td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"></td>
            </tr>
            <tr>
                <td style="width: 16.66%; padding: 15px;" class=""></td>
                <td style="width: 16.66%;" colspan=""></td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"></td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"></td>
            </tr>
            <tr>
                <td style="width: 16.66%; padding: 15px;" class=""></td>
                <td style="width: 16.66%;" colspan=""></td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"></td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"></td>
            </tr>
            <tr>
                <td style="width: 16.66%; padding: 15px;" class=""></td>
                <td style="width: 16.66%;" colspan=""></td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"></td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"></td>
            </tr>
            <tr>
                <td style="width: 16.66%; padding: 15px;" class=""></td>
                <td style="width: 16.66%;" colspan=""></td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"></td>
                <td style="width: 16.66%;" class=""></td>
                <td style="width: 16.66%;"></td>
            </tr>

        </table>
        <table style="margin-top: 10px;">
            <tr>
                <td colspan="6" class="center bold">
                    DECLARATION CUM AUTHORISATION
                </td>
            </tr>
        </table>
        <div class="" style="border: 1px solid black ; font-size: 12px ; padding: 5px;">
            I/We hereby authorize, without any notice to me to conduct credit checks, references, make enquiries, in its
            sole discretion, and also authorise <span style="font-weight: 800;">(bank name (static))</span> its employee, agents, 3rd
            party agencies to share and obtain information, records from any agencies, statutory bodies, credit bureau,
            bank, financial institutions, or any third party in respect of the application, as it may consider necessary
           <span style="font-weight: 800;"> (bank name (static)) </span>shall not be liable for use/ sharing of the information.
            I authorise <span style="font-weight: 800;">(bank name (static)) </span>and/ or its representatives, agents to
            communicate/ call/ SMS to me/ us with respect to this Application or any other promotional activities. I/we
            would like to know as well avail the benefits of various <span style="font-weight: 800;">(bank name (static)) </span>loan
            offer schemes or loan promotional activities or any other promotional schemes and hereby authorize <span style="font-weight: 800;">(bank name (static)) </span>, its employees, agents, representatives, and associates to do so.
            I confirm that laws in relation to the unsolicited communication referred in “national Do Not Call Registry”
            as laid down by Telecom Regulatory of India will not be applicable for such communications/ calls/ SMSs
            received from <span style="font-weight: 800;">(bank name (static)) </span>, its representatives, agents.
           <span style="font-weight: 800;">(bank name (static)) </span> reserves the right to retain the photograph and documents
            submitted with the Application and shall not return back.
            <span style="font-weight: 800;">(bank name (static)) </span> shall be entitled at its sole and absolute discretion to
            approve/reject this Application Form submitted by Applicant/Co-Applicant /Acceptor(s).
            I/we authorise <span style="font-weight: 800;">(bank name (static)) </span> to submit the application/other relevant
            documents submitted by me to CERSAI.
            I/We hereby provide my consent to receive information from Central KYC Registry through SMS/mail on the
            above-registered number/email address.
            I/We declare that all the particulars and information given in this application form are true, correct, and
            complete and that they shall form the basis of any loan may decide to grant to me/us.
            I/We hereby declare and agree to the following on behalf of the Applicant(s).
            I/We declare that all the particulars and information given in the Application Form are true, correct,
            complete, and up-to-date in all respects and I/We have not withheld any information whatsoever.
            I/We confirm that no suit for recovery of outstanding dues or monies whatsoever and/or criminal proceedings
            have been initiated and/or pending against the Applicant(s).
            I/We hereby confirm that no action or any steps have been taken or legal proceedings started by or against
            the Applicant(s) in any court of law/other authorities for winding up, dissolution, administration, or
            re-organization or for the appointment of a receiver, administrator, administrative receiver, trustee or
            similar officer or for Applicant(s)’ assets.
            I/We declare that I/We have not made any payment in cash, bearer, cheque, or kind along with or in
            connection with this Application except for the application fees mentioned for or Processing fees or any
            other fees prescribed in the Application Form to the executive collecting my/our application/and
            I/We/Applicant(s) shall not hold <span style="font-weight: 800;">(bank name (static)) </span> liable for any such payment
            made by us to the executive collecting this application
            I/We understand and confirm that the Application Form and all other documents submitted by me/us to <span style="font-weight: 800;">(bank name (static)) </span> shall not be returned to me/us and <span style="font-weight: 800;">(bank name (static)) </span> shall have the right to retain the same. That submission of loan application to <span style="font-weight: 800;">(bank name (static)) </span> does not imply automatic approval of <span style="font-weight: 800;">(bank name (static)) </span> and that (bank name (static)) will decide the quantum of the loan
            at its sole and absolute discretion, <span style="font-weight: 800;">(bank name (static)) </span> in its sole and absolute
            discretion may either sanction or reject the application for granting the loan in case of rejection, <span style="font-weight: 800;">(bank name (static)) </span> shall not be required to give any reason. In the case of loan
            cancellation, the applicable pro-rate interest charges on any outstanding loan amount will have to be borne
            by me/ us.
            I/We understand that Processing fees, stamp duty are non-refundable charges and would not be
            waived/refundable in case of loan cancellation or where the loan has not been disbursed
            I/We have read the application form and brochures and are agreeable to all the terms/conditions of availing
            finance from the Bank/its Group Companies.
            I/We undertake to inform <span style="font-weight: 800;">(bank name (static)) </span> /its Group Companies/its Agents
            regarding the change in Applicant(s)’ addresses and to provide any further information that <span style="font-weight: 800;">(bank name (static)) </span> /its Group Companies/its Agents may require.
            I/We further declare and confirm that the credit facilities if any enjoyed by the Applicant(s) with other
            banks/financial institutions/non-banking finance companies has been disclosed hereinabove.
            I/We agree that <span style="font-weight: 800;">(bank name (static)) </span> may provide the credit facilities mentioned
            herein only if permitted and if approved in the manner specified or required by the Reserve Bank of India
            from time to time.
            I/We agree and understand that <span style="font-weight: 800;">(bank name (static)) </span> reserves the right to reject
            this application without assigning any reason (unless required as applicable)
            I/We confirm that I/we shall not use the credit facility (or any part thereof) for any improper, illegal or
            unlawful purpose/activities/speculative or antisocial purpose.
            I/We have been read out and explained in the language known to me/us, the contents of the Application Form
            for availing the loan from <span style="font-weight: 800;">(bank name (static)) </span> <span style="font-weight: 800;">Mr./Ms. shreepad page(static)</span> (RO/SO name)
            and I/we have signed the said Application Form after having understood them and by signing the same.
            I/We hereby confirm that I/we am/are competent and fully authorised to give declaration, undertakings etc.
            and to execute and submit this Application Form and all other documents on behalf of the Applicant(s) for
            the purpose of availing loan, creation of security and representing generally for all the purposes
            mentioned/required to be done for these presents.
            I/We hereby agree to abide by and be bound by all applicable rules/regulations/instruction/guidelines
            including but not limited to those issued by the Reserve Bank of India, including the FEMA Regulations 2000
            Governing EEFC Accounts, the Foreign Exchange Management Act, 1999 and Foreign Account Tax Compliance Act,
            2010 (to the extent applicable to India) and the Common Reporting Standards (CRS), in force from time to
            time.
            I/We confirm having declared our status as per the rules applicable under section 285BA of the Income Tax
            Act, 1961 (the Act) as notified by Central Board of Direct Taxes (CBDT) in this regard.
            I/We confirm that except to the extent disclosed to <span style="font-weight: 800;">(bank name (static)) </span>, no
            director or a relative (as specified by RBI) of a director of a banking company (as specified by RBI) or a
            relative of a senior officer of the Bank (as specified by RBI) is - the applicant(s), or a partner, managing
            agent, manager, employee, director of our concern, or of our subsidiary or our holding company, or a
            guarantor on my/our behalf, or holds substantial interest in our concern or my/our subsidiary or holding
            company.
            I/We hereby agree to abide by and be bound by all applicable rules/regulations/instruction/guidelines
            including but not limited to those issued by the Reserve Bank of India, including the Foreign Exchange
            Management Act, 1999 and Foreign Account Tax Compliance Act, 2010 (to the extent applicable to India) and
            the Common Reporting Standards (CRS), in force from time to time.
            I/We confirm having declared our status as per the rules applicable under section 285BA of the Income Tax
            Act, 1961 (the Act) as notified by Central Board of Direct Taxes (CBDT) in this regard.
            I/We hereby authorize <span style="font-weight: 800;">(bank name (static)) </span> or its associates or its authorized
            representatives to verify the details furnished/to be furnished by me/us for the purpose of the loan from
            the Company.
            I/We confirm that I/We have/had no insolvency proceedings against me/us nor have I/We been adjudicated
            insolvent. I/We further confirm that I/We have read the brochure and understood the content.
            I/We also understand that the processing fees are non-refundable and will not claim or raise a dispute in
            the future for a refund of processing fees if the loan is rejected for any reason. All payments in favour of
            the Company should be made only by ECS.
            I/We undertakes to inform the Company regarding any changes in my/our occupation/employment. I/We further
            agree that my/our loan shall be governed by the rules of the Company. I/We have no objection to give the
            documents required as per KYC guidelines issued by RBI.

        </div>

        <div class="" style="border: 1px solid black; border-top:none !important;">
            <table>
            <tr>
                <td colspan="2" style="text-align: left; padding-left: 30px; width: 33.33%; border: none;">
                    <br>
                  ________________________<br>
                  <br>
                  Signature of Applicant / 
                  Authorized <br> Signatory
                  
                </td>
                <td colspan="2"  style="text-align: left; padding-left: 30px; width: 33.33%;border: none;">
                    <br>
                  ________________________<br>
                  <br>
                       Signature of 1st Co-Applicant
                </td>
                <td colspan="2" style="text-align: left; padding-left: 30px; width: 33.33%;border: none;">
                    <br>
                  ________________________<br>
                  <br>
                       Signature of 2nd Co-Applicant
                </td>
            </tr>
              <tr>
                <td colspan="2" style="padding-left:30px ; width: 33.33%; border: none;">
                Date: 14/02/2026(static)
                  
                </td>
                <td colspan="2"  style="padding-left:30px ; width: 33.33%;border: none;">
                    Date: 14/02/2026(static)
                </td>
                <td colspan="2" style="padding-left:30px ; width: 33.33%;border: none;">
                    Date: 14/02/2026(static)
                </td>
            </tr>
             <tr>
                <td colspan="2" style="padding-left:30px ; width: 33.33%; border: none;">
               Place : Maharashtra(static)
                  
                </td>
                <td colspan="2"  style="  padding-left:30px ;  width: 33.33%;border: none;">
                   Place :
                </td>
                <td colspan="2" style="padding-left:30px ; width: 33.33%;border: none;">
                   Place : 
                </td>
            </tr>
        </table>
        </div>
    </div>
</body>

</html>