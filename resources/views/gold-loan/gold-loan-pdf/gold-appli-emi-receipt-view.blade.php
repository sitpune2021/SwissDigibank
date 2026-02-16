@extends('layout.main')
@section('content')
    <div class="main-inner">
        <div class="box mt-5" style="padding:20px;">

            <div style="text-align:center;">
                <div style="text-align:center; margin-bottom:15px;">

                    <a href="{{ route('loan.emi_receipt.pdf', [$loan->id, $emiNo]) }}"
                        style="background:#28a745; color:white; padding:8px 20px; border-radius:4px; text-decoration:none;">
                        PRINT
                    </a>
                </div>

                <img src="{{ asset('assets/images/SBC_Logo_gpg.jpg') }}" style="height:70px;">

                <h2 style="margin:5px 0;">
                    SHRI SAMARTH NAGRI SAHAKARI PAT SANSTHA LIMITED
                </h2>

                <div>SHEGAON Maharashtra - 110012</div>


                <h3 style="margin-top:10px;">EMI RECEIPT</h3>

            </div>

            <hr>

            <table width="100%">
                <tr>
                    <td>
                        Printed on : {{ now()->format('d-M-Y h:i:s A') }}
                    </td>
                    <td style="text-align:right;">
                        Branch : {{ $loan->branch->name ?? 'HEAD OFFICE' }}
                    </td>
                </tr>
            </table>

            <hr>

            <table width="100%" style="margin-top:10px;">
                <tr>
                    <td><strong>EMI No :</strong> {{ $emiNo }}
                    </td>
                    <td style="text-align:right;">
                        <strong>EMI Date :</strong>
                        {{ \Carbon\Carbon::parse($transactions->first()->transaction_date)->format('d-m-Y') }}
                    </td>
                </tr>
            </table>

            <br>

            <table width="100%">
                <tr>
                    <td width="30%">Member</td>
                    <td>:
                        {{ $loan->member->member_no ?? '' }}
                        -
                        {{ $loan->member->member_info_first_name . ' ' . $loan->member->member_info_last_name }}
                    </td>
                </tr>

                <tr>
                    <td>Account No</td>
                    <td>:
                        {{ str_pad($loan->account_no ?? $loan->id, 6, '0', STR_PAD_LEFT) }}
                    </td>

                </tr>

                <tr>
                    <td>Principal Amount</td>
                    <td>:
                        ₹ {{ number_format($emiData['principal'], 2) }}
                    </td>
                </tr>

                <tr>
                    <td>Interest Amount</td>
                    <td>:
                        ₹ {{ number_format($emiData['interest'], 2) }}
                    </td>
                </tr>

                <tr>
                    <td>EMI Amount</td>
                    <td>:
                        ₹ {{ number_format($emiData['emi_amount'], 2) }}
                    </td>
                </tr>

                <tr>
                    <td>Balance Principal Amount</td>
                    <td>:
                        ₹ {{ number_format($emiData['balance_principal'], 2) }}
                    </td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>: <strong>PAID</strong></td>
                </tr>
            </table>

            <br><br>

            <table width="100%">
                <tr>
                    <td style="text-align:center;">(Approved by)</td>
                    <td style="text-align:center;">(Verified by)</td>
                    <td style="text-align:center;">(Posted by)</td>
                </tr>
            </table>

            <hr>

            <div style="text-align:center; font-size:12px;">
                Thank you for your business!
            </div>

        </div>
    </div>
@endsection
