<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>PAYMENT RECEIPT</title>
    <style>
        @page {
            margin: 12mm;
        }

        body {
            font-family: "Courier New", Courier, monospace;
            font-size: 13px;
            color: #222;
            margin: 0;
            line-height: 1.25;
        }

        .container {
            max-width: 320px;
            margin: 0 auto;
            padding: 8px 6px;
        }

        .heading-bank {
            text-align: center;
            font-weight: 800;
        }

        .heading-bank h2 {
            margin: 0;
            font-size: 16px;
            font-weight: 800;

        }

        .heading-bank p {
            margin: 2px 0 8px;
            font-size: 8px;
        }

        hr {
            border-top: 1px solid #ddd;
            margin: 8px 0;
        }

        .title {
            font-weight: 900;
            font-size: 20px;
            margin-bottom: 8px;
        }

        .row {
            display: flex;
            align-items: flex-start;
            /* align top for multiline values */
            margin-bottom: 4px;
        }

        .label {
            flex: 0 0 35%;
            /* fixed width for labels */
            font-weight: 900;
            color: #555;
        }

        .value {
            flex: 1;
            /* take remaining space */
            text-align: right;
            font-weight: 800;
            color: #555;
        }

        .value.multiline {
            white-space: pre-wrap;
            word-break: break-word;
            text-align: right;
        }

        .printed {
            margin-top: 12px;
            font-size: 11px;
            color: #444;
            font-weight: 800;
        }

        .thankyou {
            margin-top: 8px;
            color: #444;
            font-weight: 800;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="heading-bank">
            <h2>
                SHRI SAMARTH<br>
                NAGRI SAHKARI<br>
                PAT SANSTHA<br>
                LIMITED
            </h2>
            <p>969/03-04</p>
        </div>

        <hr>
        <div class="title">Payment Receipt</div>

        <div class="row">
            <div class="label uppercase">Reg No :</div>
            <div class="value">{{ $reg_no }}</div>
        </div>

        <div class="row">
            <div class="label uppercase">Name :</div>
<div class="value multiline">{{ $member_info_first_name }}</div>
<div class="value multiline">{{ $member_info_middle_name ?? ''}}</div>
<div class="value multiline">{{ $member_info_last_name }}</div>
        </div>

        <div class="row">
            <div class="label uppercase">Phone :</div>
            <div class="value">{{ $member_info_mobile_no }}</div>
        </div>

        <hr>

        <div class="row">
            <div class="label uppercase">Date :</div>
            <div class="value">{{ $transaction_date }}</div>
        </div>

        <div class="row">
            <div class="label uppercase" >Ref Id :</div>
            <div class="value">{{ $ref_id }}</div>
        </div>


        <div class="row">
            <div class="label uppercase">Amount :</div>
            <div class="value">{{ $amount }} {{ $amount_suffix }}</div>
        </div>

        <div class="row">
            <div class="label uppercase">Mode :</div>
            <div class="value">{{ $mode }}</div>
        </div>

        <div class="row">
            <div class="label uppercase">Status:</div>
            <div class="value">{{ $status }}</div>
        </div>

        <div class="row">
            <div class="label uppercase">Type:</div>
            <div class="value">{{ $type }}</div>
        </div>

        <div class="row">
            <div class="label uppercase">Remarks:</div>
            <div class="value multiline">{{ $remarks }}</div>
        </div>

        <hr>

        <div class="printed">
            Printed on: {{ $printed_on }}<br>
            By: {{ $printed_by }}
        </div>


        <div class="thankyou">Thank you for your business!</div>
    </div>
</body>

</html>
