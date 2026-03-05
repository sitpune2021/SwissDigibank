@extends('layout.main')

<style>
    .breadcrumb {
        list-style: none;
        display: flex;
        padding: 0;
        margin-bottom: 1rem;
        font-size: 14px;
    }

    .breadcrumb li+li::before {
        content: "/";
        padding: 0 8px;
        color: #888;
    }

    .breadcrumb li a {
        text-decoration: none;
        color: #007bff;
    }

    .breadcrumb li.active {
        color: #555;
    }

    .custom-thead {
        background-color: #e6f4ea;
        color: #14532d;
    }

    .custom-thead th {
        font-weight: 600;
        border-bottom: 1px solid #ccc;
    }

    @media (prefers-color-scheme: dark) {
        .custom-thead {
            background-color: #14532d;
            color: #d1fae5;
        }
    }

    input[type="checkbox"] {
        width: 28px;
        height: 28px;
        accent-color: green;
        /* For modern browsers */
    }

    /* Fallback for browsers without accent-color support */
    input[type="checkbox"]:checked {
        background-color: green;
        border: none;
    }

    input[type="radio"] {
        width: 24px;
        height: 24px;
        accent-color: green;
        /* Modern browser support */
    }
</style>

@section('content')


    <div class="main-inner ">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-xl block  uppercase font-semibold">
                Day Book
            </h3>
        </div>

        <div class="box mb-5">

            <div class="flex gap-3  items-center justify-center">
                <form method="GET" class="mb-6 flex flex-wrap gap-3 items-center">
                    <div class="">                
                        <select name="branch_id" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                            <option value="">All Branch</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" 
                                    {{ $branchId == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->branch_name }}
                                </option>
                            @endforeach
                        </select>             
                    </div>

                    <div>
                        <!-- <input type="text" name="" id=""
                            class="datepicker-field w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                            placeholder="DD/MM/YYYY"> -->
                            <input type="date" name="date" value="{{ $date }}" 
                                class="border rounded px-3 py-2 dark:bg-bg3 border rounded-10">
                    </div>

                    <div class="">
                        <button class="uppercase btn-primary py-2 rounded-10">
                            Filter
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- <div class="mt-5 flex justify-end">
                <div class="">
                    <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                        Format:
                    </label>
                    <select name="" id=""
                        class=" text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                        <option value="">Format 1</option>
                        <option value="">Format 2</option>
                    </select>
                </div>
            </div> -->

        </div>

        <div class="flex flex-col md:flex-row lg:flex-row gap-4" id="printArea">

            <div class="box w-full">
                <div class="">

                    <div class="border-b py-3 text-center bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800 tracking-wide">
                           OPENING ({{ \Carbon\Carbon::parse($date)->format('d-m-Y') }})
                        </h3>
                    </div>

                    <div class="py-6 px-4 text-center space-y-5">          
                        <div class="py-5">
                        @foreach($openingData as $ledger)
                            <div class="flex justify-between mb-2">
                                <span class="text-primary uppercase font-semibold">{{ $ledger['name'] }}</span>
                                <span class="text-1xl font-semibold text-gray-900 mb-1">₹ {{ number_format($ledger['amount'],2) }}</span>
                            </div>
                        @endforeach
                        </div>
                    </div>

                </div>
            </div>

            <div class="box w-full">
                <div class="">
                   
                    <div class="border-b py-3 text-center bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800 tracking-wide">
                           CURRENT/ CLOSING ({{ \Carbon\Carbon::parse($date)->format('d-m-Y') }})
                        </h3>
                    </div>

                    <div class="py-6 px-4 text-center space-y-5">          
                        <div class="py-5">          
                            @foreach($closingData as $ledger)
                                <div class="flex justify-between mb-2">
                                    <span class="text-primary uppercase font-semibold">{{ $ledger['name'] }}</span>
                                    <span class="text-1xl font-semibold text-gray-900 mb-1">₹ {{ number_format($ledger['amount'],2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

            <div class="box w-full">
                <div class="">
                  
                    <div class="border-b py-3 text-center bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800 tracking-wide">
                           DAY TRANSACTIONS ({{ \Carbon\Carbon::parse($date)->format('d-m-Y') }})
                        </h3>
                    </div>

                    <div class="py-6 px-4 text-center space-y-5">          
                        <div class="py-5">                                  
                            @foreach($dayTxnData as $ledger)
                                <div class="flex justify-between mb-2">
                                    <span class="text-primary uppercase font-semibold">{{ $ledger['name'] }}</span>
                                    <span class="text-1xl font-semibold text-gray-900 mb-1">₹ {{ number_format($ledger['amount'],2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- this code div use only print page -->
        <div id="printTable" style="display:none; width:100%; font-family: dejavusans; border-bottom: 2px solid #000 ; padding: 5px;">
            
            <div style="float:left; text-align:left;">
                <img src="{{ $logoUrl }}" alt="Company Logo" style="width:auto; height:50px;">
            </div>

             <div style="clear:both; "></div>

            <h2 style="text-align:center; font-weight:bold;">
                Day Book for the period day : 
                {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }} 
                to 
                {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
            </h2>

            <table border="1" cellspacing="0" cellpadding="6" width="100%" style="border-collapse:collapse; margin-top:20px;">

                <thead>
                    <tr>
                        <th>NAME</th>
                        <th>TYPE</th>
                        <th>OPENING BAL.<br>({{ \Carbon\Carbon::parse($date)->format('d/m/Y') }})</th>
                        <th>DEBIT</th>
                        <th>CREDIT</th>
                        <th>CLOSING BAL.<br>({{ \Carbon\Carbon::parse($date)->format('d/m/Y') }})</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $grandOpening = 0;
                        $grandDebit = 0;
                        $grandCredit = 0;
                        $grandClosing = 0;
                    @endphp

                    @foreach($dayBookData as $row)
                        @php
                            $grandOpening += $row['opening'];
                            $grandDebit += $row['debit'];
                            $grandCredit += $row['credit'];
                            $grandClosing += $row['closing'];
                        @endphp
                        <tr>
                            <td>{{ $row['name'] }}</td>
                            <td>{{ $row['type'] }}</td>
                            <td align="right">{{ number_format($row['opening'],2) }}</td>
                            <td align="right">{{ number_format($row['debit'],2) }}</td>
                            <td align="right">{{ number_format($row['credit'],2) }}</td>
                            <td align="right">{{ number_format($row['closing'],2) }}</td>
                        </tr>
                    @endforeach

                    <tr style="font-weight:bold;">
                        <td colspan="2">GRAND TOTAL</td>
                        <td align="right">{{ number_format($grandOpening,2) }}</td>
                        <td align="right">{{ number_format($grandDebit,2) }}</td>
                        <td align="right">{{ number_format($grandCredit,2) }}</td>
                        <td align="right">{{ number_format($grandClosing,2) }}</td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="mt-5 text-center">
            <button onclick="printBalanceSheet()" 
                class="btn-primary uppercase rounded-10">
                <i class="fa fa-print"></i> Print
            </button>
        </div>
       
    </div>


<!-- Datepicker CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

<!-- Datepicker JS -->
<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.datepicker-field').forEach(function(dateInput) {
        const picker = new Datepicker(dateInput, {
            autohide: true,
            format: 'dd-mm-yyyy',
            maxDate: new Date(),
        });

        if (!dateInput.value) {
            const today = new Date();
            const formattedDate = today.toLocaleDateString('en-GB').split('/').join('-');
            dateInput.value = formattedDate;
        }

        const calendarIcon = dateInput.parentElement.querySelector('.la-calendar');
        if (calendarIcon) {
            calendarIcon.addEventListener('click', () => picker.show());
        }
    });
});
</script>

<!-- print document -->
<script>
function printBalanceSheet() {

    var printArea = document.getElementById('printTable');

    if (!printArea) {
        alert('Print table not found!');
        return;
    }

    var content = printArea.innerHTML;

    var printWindow = window.open('', '_blank');

    printWindow.document.write(`
        <html>
        <head>
            <title>Day Book</title>

            <style>
                body { font-family: Arial; padding:20px; }

                table {
                    width:100%;
                    border-collapse: collapse;
                }

                th, td {
                    border:1px solid #000;
                    padding:6px;
                    font-size:14px;
                }

                th {
                    background:#f2f2f2;
                }

                h2 {
                    text-align:center;
                }
            </style>
        </head>
        <body>
            ${content}
        </body>
        </html>
    `);

    printWindow.document.close();

    printWindow.onload = function () {
        printWindow.focus();
        printWindow.print();
    };
}
</script>

@endsection