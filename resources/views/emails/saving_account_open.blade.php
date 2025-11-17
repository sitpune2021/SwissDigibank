<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Standard Chartered Email</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 30px 0;
        }

        .email-wrapper {
            width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #dcdcdc;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.08);
        }

        .email-header {
            padding: 12px 20px;
            border-bottom: 3px solid #009873;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .email-header h3 {
            margin: 0;
            font-size: 16px;
            color: #888;
            font-weight: 500;
        }

        .email-header small {
            color: #888;
            font-size: 11px;
        }

        .logo {
            height: 60px;
            /* padding: 10px; */
        }

        .email-body {
            padding: 20px 30px;
            font-size: 13px;
            color: #000;
        }

        .email-body p {
            line-height: 1.6;
            margin: 6px 0;
        }

        .highlight {
            color: #009873;
            font-weight: bold;
        }

        .details-table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 4px 0;
            vertical-align: top;
            font-size: 13px;
        }

        .details-table td:first-child {
            width: 170px;
            font-weight: bold;
        }

        .banner {
            margin-top: 15px;
            /* background-color: #eaf8ef; */
            padding: 12px 15px;
            font-size: 12px;
            text-align: start;
            line-height: 1.5;
            color: #333;
            border-radius: 3px;

        }

        .footer {
            font-size: 11px;
            color: #555;
            border-top: 1px solid #ddd;
            padding: 15px 25px;
            background-color: #f9f9f9;
            line-height: 1.4;
        }

        .bottom-note {
            font-size: 11px;
            color: #555;
            padding: 10px 25px;
            line-height: 1.4;
            background-color: #fff;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-header">
            <div style="margin: 20px 0px">
                <h3>Alerts</h3>
                <!-- <small>July 26, 2022, 08:22 PM</small> -->
                <small>{{ now()->format('F d, Y, h:i A') }}</small>
            </div>
            <img src="url('assets/images/Loan_Management_logo.png')" alt="" class="logo">
        </div>

        <div class="email-body" style="border-bottom: 1px solid #ddd;">
            <p
                style="color:rgb(9, 163, 9); font-size:16px; font-weight: 600; margin-bottom: 20px; margin-top: 15px !important; ">
                <!-- Dear Valued Customer, -->
                Dear {{ $member->member_info_first_name ?? 'Valued Customer' }},
            </p>
            <p>Your Saving Account has been successfully opened. Below are your account details:</p>

            <table class="details-table">
                <tr>
                    <td style="padding:6px 0;">Account Number:</td>
                    <td style="padding:6px 0;">{{ $Account->account_no ?? 'XXXXXXXXXX' }}</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;">Customer Name:</td>
                    <td style="padding:6px 0;">{{ $member->member_info_first_name ?? 'NA' }}</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;">Account Type:</td>
                    <td style="padding:6px 0;">Saving Account</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;">Currency:</td>
                    <td style="padding:6px 0;">INR</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;">Opening Balance:</td>
                    <td style="padding:6px 0;">{{ $Account->amount_deposit ?? '0.00' }}</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;">Mobile Number:</td>
                    <td style="padding:6px 0;">{{ $member->member_info_mobile_no ?? 'NA' }}</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;">Branch Name:</td>
                    <td style="padding:6px 0;">{{ $Account->branch->branch_name ?? 'Main Branch' }}</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;">IFSC Code:</td>
                    <td style="padding:6px 0;">{{ $Account->branch->ifsc_code ?? 'NA' }}</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;">Account Opening Date:</td>
                    <td style="padding:6px 0;">{{ now()->setTimezone('Asia/Kolkata')->format('d/m/Y H:i:s') }}</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;">Status:</td>
                    <td style="padding:6px 0; color:green;">ACTIVE</td>
                </tr>
            </table>

            <p style="font-size:12px; margin-top:10px; color:#444;">
                For additional assistance kindly email us through our online banking channel (Please use the Reference
                Number mentioned above in your communication regarding this transaction.)
            </p>
            <p style="font-size:12px; margin-top:50px; color:#444;">
                Dont miss out on the latest Standard Chartered promotions & benefits,
                Log on to <a href="" style="color: #2e84fc; text-decoration: none;">www.sc.com/in</a> to find out more!

            </p>


        </div>
        <div class="banner" style="margin: 20px; text-align: center ;  ">
            <img src="{{ asset('assets/images/LM_logo.png') }}" alt="Standard Chartered" style="height: 60px; width: 250px; object-fit: cover;">
        </div>
        <div class="footer">
            <p>To unsubscribe or modify these alerts, please login to your Online Banking account and Select Alerts and
                SMS Banking. This is a system-generated e-mail and does not require an authorised signature.
                Please do not reply to the sender of this email.</p>


            <div>
                <p>
                    Please note Standard Chartered Bank will never ask you for your account
                    details. To learn more on important legal notices, our
                    <a href="" style="color: #2e84fc; text-decoration: none;">data protection and privacy policy</a> and
                    how
                    you can avoid online fraud please visit our website on online security tips at <a href=""
                        style="color: #2e84fc; text-decoration: none;">www.sc.com/in</a>
                </p>
            </div>
        </div>

    </div>

</body>

</html>