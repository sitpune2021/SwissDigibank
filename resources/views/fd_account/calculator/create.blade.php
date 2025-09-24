@extends('layout.main')
@section('page-title', 'FD/ MIS CALCULATOR')

@section('content')

<head>
    <style>
        body {
            font-family: Arial;
        }

        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        /* Style the buttons inside the tab */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }
    </style>
</head>
<div class="main-inner">
    {{-- Alerts --}}
    @if (session('success'))
    <div id="success-alert" class="alert alert-success">
        <strong>Success:</strong> {{ session('success') }}
        <span onclick="this.parentElement.style.display='none';" style="cursor: pointer;">&times;</span>
    </div>
    @endif

    @if (session('error'))
    <div id="error-alert" class="alert alert-danger">
        <strong>Error:</strong> {{ session('error') }}
        <span onclick="this.parentElement.style.display='none';" style="cursor: pointer;">&times;</span>
    </div>
    @endif

    <div class="box mb-4">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <form id="fdForm" class="grid grid-cols-2 gap-4" onsubmit="event.preventDefault(); calculateFD();">

            {{-- Open Date --}}
            <div class="col-span-2 md:col-span-1">
                <label for="open_date" class="font-medium">Open Date <span class="text-red-500">*</span></label>
                <input type="date" id="open_date" value="{{ \Carbon\Carbon::today()->toDateString() }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            {{-- Amount --}}
            <div class="col-span-2 md:col-span-1">
                <label for="amount" class="font-medium">Amount (₹) <span class="text-red-500">*</span></label>
                <input type="number" id="amount" placeholder="Enter amount"
                    class="w-full border rounded px-3 py-2" oninput="updateAmountInWords(); calculateFD();">
                <div id="amount-in-words" class="text-xs text-red-500 mt-1"></div>
            </div>

            {{-- Interest Payout Type --}}
            <div class="col-span-2 md:col-span-1">
                <label for="interest_payout_type" class="font-medium">Interest Payout Type <span class="text-red-500">*</span></label>
                <select id="interest_payout_type" class="w-full border rounded px-3 py-2" onchange="calculateFD()">
                    <option value="">Select Interest Payout Cycle</option>
                    <option value="CUMULATIVE_YEARLY">Cumulative Yearly</option>
                    <option value="CUMULATIVE_HALF_YEARLY">Cumulative Half Yearly</option>
                    <option value="CUMULATIVE_QUARTERLY">Cumulative Quarterly</option>
                    <option value="CUMULATIVE_MONTHLY">Cumulative Monthly</option>
                    <option value="MONTHLY">Monthly</option>
                    <option value="QUARTERLY">Quarterly</option>
                    <option value="HALF_YEARLY">Half Yearly</option>
                    <option value="YEARLY">Yearly</option>
                </select>
            </div>

            {{-- Annual Interest Rate --}}
            <div class="col-span-2 md:col-span-1">
                <label for="annual_interest_rate" class="font-medium">Annual Interest Rate (%) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" id="annual_interest_rate"
                    class="w-full border rounded px-3 py-2" placeholder="Enter Rate" oninput="calculateFD()">
            </div>

            {{-- Tenure --}}
            <div class="col-span-2 md:col-span-1">
                <label class="font-medium">Tenure Period <span class="text-red-500">*</span></label>
                <div class="flex gap-3">
                    <input type="number" id="tenure_year" placeholder="Year" class="w-1/3 border rounded px-2 py-1" oninput="calculateFD()">
                    <input type="number" id="tenure_month" placeholder="Month" class="w-1/3 border rounded px-2 py-1" oninput="calculateFD()">
                    <input type="number" id="tenure_day" placeholder="Days" class="w-1/3 border rounded px-2 py-1" oninput="calculateFD()">
                </div>
            </div>

            {{-- Bonus --}}
            <div class="col-span-2 md:col-span-1">
                <label for="bonus" class="font-medium">Bonus</label>
                <div class="flex gap-3">
                    <select id="bonus_type" class="w-1/3 border rounded px-2 py-1" onchange="calculateFD()">
                        <option value="%">%</option>
                        <option value="fixed">Fixed</option>
                    </select>
                    <input type="number" id="bonus" step="0.01" placeholder="Bonus"
                        class="w-2/3 border rounded px-2 py-1" oninput="calculateFD()">
                </div>
            </div>

            {{-- TDS Deduction --}}
            <div class="col-span-2 md:col-span-1">
                <label class="font-medium">TDS Deduction</label>
                <div class="flex gap-4">
                    <label><input type="radio" name="tds_deduction" value="1" onchange="calculateFD()"> Yes</label>
                    <label><input type="radio" name="tds_deduction" value="0" checked onchange="calculateFD()"> No</label>
                </div>
            </div>




            {{-- Submit --}}
            <div class="col-span-2 mt-4">
                <button type="submit" class="btn-primary px-4 py-2 bg-blue-600 text-white rounded">Calculate</button>
            </div>
        </form>

        <div id="result" class="mt-8"></div>
    </div>



    <!--Tabs-->
    <div id="summaryBox" style="display: none;">
    <div id="accordion" >
        <h2 class="mt-5">Tabs</h2>
        <div class="tab mt-5">
            <button class="tablinks active" onclick="openTab(event, 'finalpayment')">final payment</button>
            <!-- <button class="tablinks" onclick="openTab(event, 'year1')">1 year</button>
            <button class="tablinks" onclick="openTab(event, 'year2')">2 year</button> -->
        </div>
    </div>

    <div id="finalpayment" class="tabcontent w-full" style="display: block;"> <!-- default open -->
        <div class="w-full overflow-x-auto">
            <div class="overflow-x-auto">
                <table class="w-full bg-white rounded-xl shadow-md">
                    <tbody class="divide-y divide-gray-200">

                        <tr>
                            <td class="font-semibold px-4 py-3 text-gray-700 w-1/2">Principal Amount (A)</td>
                            <td id="principal" class="text-right px-4 py-3 text-gray-900 w-1/2"></td>
                        </tr>

                        <tr>
                            <td class="font-semibold px-4 py-3 text-gray-700">Interest Earned (B)</td>
                            <td id="interest_earned" class="text-right px-4 py-3 text-gray-900"></td>
                        </tr>

                        <tr>
                            <td class="font-semibold px-4 py-3 text-gray-700">TDS Deducted (C)</td>
                            <td id="tds_deducted" class="text-right px-4 py-3 text-gray-900"></td>
                        </tr>

                        <tr>
                            <td class="font-semibold px-4 py-3 text-gray-700">Net Interest Earned (D = B - C)</td>
                            <td id="net_interest" class="text-right px-4 py-3 text-gray-900"></td>
                        </tr>

                        <tr>
                            <td class="font-semibold px-4 py-3 text-gray-700">Maturity Bonus Amount (E)</td>
                            <td id="maturity_bonus" class="text-right px-4 py-3 text-gray-900"></td>
                        </tr>

                        <tr>
                            <td class="font-semibold px-4 py-3 text-gray-700">Maturity Amount (A + D + E)</td>
                            <td id="maturity_amount" class="text-right px-4 py-3 font-bold text-green-600"></td>
                        </tr>

                        <tr>
                            <td class="font-semibold px-4 py-3 text-gray-700">Maturity Date</td>
                            <td id="maturity_date" class="text-right px-4 py-3 text-gray-900"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <!-- <div id="year1" class="tabcontent">
        <div class="overflow-x-auto">
            <table class="w-full min-w-max bg-white  rounded-xl shadow-md">
                <thead class="bg-blue-600 text-white text-sm">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold">PERIOD</th>
                        <th class="px-4 py-2 text-center font-semibold">DAYS</th>
                        <th class="px-4 py-2 text-center font-semibold">PRINCIPAL</th>
                        <th class="px-4 py-2 text-center font-semibold">INTEREST <br>(A)</th>
                        <th class="px-4 py-2 text-center font-semibold">TDS <br>(B)</th>
                        <th class="px-4 py-2 text-center font-semibold">NET INTEREST <br>(A - B)</th>
                        <th class="px-4 py-2 text-center font-semibold">NET INTEREST <br>on DUE DATE</th>
                        <th class="px-4 py-2 text-center font-semibold">PRINCIPAL AT EOY</th>
                        <th class="px-4 py-2 text-center font-semibold">DUE BY</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <tr class="border-b">
                        <td class="px-4 py-2 text-gray-900">28/08/2025 - 27/09/2025</td>
                        <td class="px-4 py-2 text-center">31</td>
                        <td class="px-4 py-2 text-center">100000</td>
                        <td class="px-4 py-2 text-center">917</td>
                        <td class="px-4 py-2 text-center">0.0</td>
                        <td class="px-4 py-2 text-center">917</td>
                        <td class="px-4 py-2 text-center">917.0</td>
                        <td class="px-4 py-2 text-center"></td>
                        <td class="px-4 py-2 text-center">28/09/2025</td>
                    </tr>

                </tbody>
            </table>
        </div>


    </div>

    <div id="year2" class="tabcontent">
        <div class="overflow-x-auto">
            <table class="w-full min-w-max  rounded-lg shadow-sm text-center">
                <thead class="bg-blue-600 text-white text-sm">
                    <tr>
                        <th class="px-4 py-2 font-semibold">PERIOD</th>
                        <th class="px-4 py-2 font-semibold">DAYS</th>
                        <th class="px-4 py-2 font-semibold">PRINCIPAL</th>
                        <th class="px-4 py-2 font-semibold">INTEREST <br>(A)</th>
                        <th class="px-4 py-2 font-semibold">TDS <br>(B)</th>
                        <th class="px-4 py-2 font-semibold">NET INTEREST <br>(A - B)</th>
                        <th class="px-4 py-2 font-semibold">NET INTEREST <br>on DUE DATE</th>
                        <th class="px-4 py-2 font-semibold">PRINCIPAL AT EOY</th>
                        <th class="px-4 py-2 font-semibold">DUE BY</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <tr class="border-b">
                        <td class="px-4 py-2">28/08/2026 - 27/09/2026</td>
                        <td class="px-4 py-2">31</td>
                        <td class="px-4 py-2">100000.0</td>
                        <td class="px-4 py-2">917</td>
                        <td class="px-4 py-2">0.0</td>
                        <td class="px-4 py-2">917</td>
                        <td class="px-4 py-2">917.0</td>
                        <td class="px-4 py-2">—</td>
                        <td class="px-4 py-2">28/09/2026</td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div> -->
</div>


@endsection

@push('script')
<script>
    function openTab(evt, tabId) {
        var i, tabcontent, tablinks;

        // Hide all tab contents
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Remove active state from all tab buttons
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the selected tab and mark button active
        document.getElementById(tabId).style.display = "block";
        evt.currentTarget.className += " active";
    }


    function calculateFD() 
    {

      

        let formData = {
            amount: $("#amount").val(),
            open_date: $("#open_date").val(),
            annual_interest_rate: $("#annual_interest_rate").val(),
            interest_payout_type: $("#interest_payout_type").val(),
            tenure_year: $("#tenure_year").val(),
            tenure_month: $("#tenure_month").val(),
            tenure_day: $("#tenure_day").val(),
            bonus: $("#bonus").val(),
            bonus_type: $("#bonus_type").val(),
            tds_deduction: $("input[name='tds_deduction']:checked").val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        $.ajax({
            url: "{{ route('calculate.investment') }}",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    let summary = response.results.original.summary.summary;

                    // Update table values
                    $("#principal").text("INR " + summary.principal);
                    $("#interest_earned").text("INR " + summary.interest_earned);
                    $("#tds_deducted").text("INR " + summary.tds_deducted);
                    $("#net_interest").text("INR " + summary.net_interest);
                    $("#maturity_bonus").text("INR " + summary.maturity_bonus);
                    $("#maturity_amount").text("INR " + summary.maturity_amount);
                    $("#maturity_date").text(summary.maturity_date);


                     if(summary.principal != "0.00") {
                        $("#summaryBox").show();
                     }
 
                } else {
                    $("#result").html(`<div class="alert alert-danger">Something went wrong.</div>`);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                $("#result").html(`<div class="alert alert-danger">Server error, please try again.</div>`);
            }
        });
    }

    function numberToWords(n) {
        const a = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten",
            "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen"
        ];
        const b = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];

        if (n < 20) return a[n];
        if (n < 100) return b[Math.floor(n / 10)] + (n % 10 ? " " + a[n % 10] : "");
        if (n < 1000) return a[Math.floor(n / 100)] + " Hundred " + (n % 100 ? numberToWords(n % 100) : "");
        if (n < 100000) return numberToWords(Math.floor(n / 1000)) + " Thousand " + (n % 1000 ? numberToWords(n % 1000) : "");
        if (n < 10000000) return numberToWords(Math.floor(n / 100000)) + " Lakh " + (n % 100000 ? numberToWords(n % 100000) : "");
        return numberToWords(Math.floor(n / 10000000)) + " Crore " + (n % 10000000 ? numberToWords(n % 10000000) : "");
    }

    function updateAmountInWords() {
        const amount = parseInt($("#amount").val(), 10);
        $("#amount-in-words").text(!isNaN(amount) && amount >= 0 ? numberToWords(amount) : '');
    }
</script>
@endpush