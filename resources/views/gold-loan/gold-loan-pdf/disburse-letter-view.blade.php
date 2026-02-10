@extends('layout.main')
@section('content')
<style>
    @page {
        margin: 30px 40px;
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

<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h3 class="text-lg uppercase font-semibold">DIsburse Letter </h3>
        </div>
    </div>
    <div class="text-center flex justify-center gap-5 mt-4">
        <a href="{{ route('loan.disburse_letter.pdf', $loan_no) }} " class="px-4 py-2 btn-primary uppercase"
            style="font-family: sans-serif !important; " target="_blank">
            <i class="las la-download"></i> Download
        </a>
        <a href="
 {{ route('gold-loan.applications.view', $loan_no) }}
  " class="px-4 py-2 btn-outline uppercase" style="font-family: sans-serif !important; " target="_self">
            BACK
        </a>
    </div>
    <div class="box mt-5">


        <!-- Header -->
        <table class="header">
            <tr>
                <td align="left" style="font-size :14px;">
                    Printed On : {{ $printed_on }}
                </td>
                <td align="right" style="font-size :14px;">
                    Date :{{ $date }}
                </td>
            </tr>
        </table>

        <div class="line"></div>

        <!-- Content -->
        <div class="content">

            <div class="address" style="font-size: 14px;">
                To <br>
                The Chief Loan Officer
                <br>
                {{ $bank_name  }}<br>
                {{ $bank_adr_branch}} <br>
                {{$bank_adr}}
            </div>

            <div style="font-size: 14px;">
                Dear Sir,
            </div>

            <div class="subject" style="font-size: 14px;">
                This is with regard to the sanction of
                {{ str_pad( $loan_no, 10, '0', STR_PAD_LEFT) }}
                ( Gold Loan - {{ str_pad( $loan_no, 10, '0', STR_PAD_LEFT) }} ) of
                ₹ {{ number_format($loan_amount, 2) }}
                by your Company, I
                request you to disburse the loan proceeds by way of
                ____________ to my bank account details given here
                under:
            </div>

            <!-- Details Table -->
            <table class="details" style="font-size: 14px;">
                <tr>
                    <td class="label">Name of the Account Holder</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $account_holder }}</td>
                </tr>
                <tr>
                    <td class="label">Name & Address of the Bank</td>
                    <td class="colon">:</td>
                    <td class="value">{{ $bank_name  }}<br>
                        {{$bank_adr}}
                    </td>
                </tr>
                <tr>
                    <td class="label">File Processing Charges</td>
                    <td class="colon">:</td>
                    <td class="value">₹ {{ number_format($processing_charges, 2) }}
                        {{-- {{ number_format($processing_charges, 2) }} --}}
                    </td>
                </tr>
                <tr>
                    <td class="label">Stamp Duty</td>
                    <td class="colon">:</td>
                    <td class="value">₹ {{ number_format($stamp_duty, 2) }}</td>
                </tr>
                <tr>
                    <td class="label">Insurance Fee</td>
                    <td class="colon">:</td>
                    <td class="value">₹ {{ number_format($insurance_fee, 2) }}</td>
                </tr>
                <tr>
                    <td class="label">Final Disburse Amount</td>
                    <td class="colon">:</td>
                    <td class="value">₹ {{ number_format($final_amount, 2) }}</td>
                </tr>
            </table>

            <div class="footer" style="font-size: 14px;">
                Further, I hereby undertake to repay the EMI's by way of
                NACH / Cash / Cheque on due dates.
            </div>

            <div class="signature" style="font-size: 14px;">
                Thanking you,<br>
                Yours Truly,
                <br><br>
                ___________________________<br>
                {{ $account_holder }}<br>
                {{-- state here --}}
            </div>

        </div>


    </div>


    @endsection