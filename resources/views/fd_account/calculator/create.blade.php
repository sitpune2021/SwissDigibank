@extends('layout.main')
{{-- @section('page-title', 'FD/ MIS CALCULATOR') --}}

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

        input[type="checkbox"] {
            width: 28px;
            height: 28px;
            accent-color: green;
            /* For modern browsers */
        }

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
</head>


<div class="main-inner">

   
    <div class="mb-2">
        <h3 class="text-xl font-semibold uppercase">FD/ MIS CALCULATOR</h3>
    </div>

    <div class=" ">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 p-6 min-h-screen">
            <div class="col-span-2 md:col-span-1 box  dark:bg-bg3 rounded-2xl p-6">
                <meta name="csrf-token" content="{{ csrf_token() }}">

                <form id="fdForm" class="space-y-6" onsubmit="event.preventDefault(); calculateFD();">

                    {{-- Open Date --}}
                    <div>
                        <label class="font-medium uppercase mb-2 block">Open Date *</label>
                        <input type="hidden"
                            id="open_date"
                            value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">

                        <input type="text"
                            value="{{ \Carbon\Carbon::today()->format('d-m-Y') }}"
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-gray-100"
                            readonly>
                    </div>

                    {{-- Amount --}}
                    <div>
                        <label class="font-medium uppercase mb-2 block">Amount (₹) *</label>
                        <input type="number" id="amount" placeholder="Enter amount"
                            class="w-full border rounded-10 px-3 py-3 text-sm"
                            oninput="updateAmountInWords();">
                        <div id="amount-in-words" class="text-xs text-red-500 mt-1"></div>
                    </div>

                    {{-- Interest Payout --}}
                    <div>
                        <label class="font-medium uppercase mb-2 block">Interest Payout Type *</label>
                        <select id="interest_payout_type"
                                class="w-full border rounded-10 px-3 py-3 text-sm">
                            <option value="">Select</option>
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

                    {{-- Interest Rate --}}
                    <div>
                        <label class="font-medium uppercase mb-2 block">Annual Interest Rate (%) *</label>
                        <input type="number" step="0.01" id="annual_interest_rate"
                            placeholder="Enter rate"
                            class="w-full border rounded-10 px-3 py-3 text-sm">
                    </div>

                    {{-- Tenure --}}
                    <div>
                        <label class="font-medium uppercase mb-2 block">Tenure Period *</label>
                        <div class="flex gap-3">
                            <input type="number" id="tenure_year" placeholder="Year"
                                class="w-full border rounded-10 px-3 py-3 text-sm">
                            <input type="number" id="tenure_month" placeholder="Month"
                                class="w-full border rounded-10 px-3 py-3 text-sm">
                            <input type="number" id="tenure_day" placeholder="Days"
                                class="w-full border rounded-10 px-3 py-3 text-sm">
                        </div>
                    </div>

                    {{-- Bonus --}}
                    <div>
                        <label class="font-medium uppercase mb-2 block">Bonus</label>
                        <div class="flex gap-3">
                            <select id="bonus_type"
                                    class="w-24 border rounded-10 px-3 py-3 text-sm">
                                <option value="%">%</option>
                                <option value="fixed">Fixed</option>
                            </select>
                            <input type="number" id="bonus" step="0.01"
                                placeholder="Bonus"
                                class="w-full border rounded-10 px-3 py-3 text-sm">
                        </div>
                    </div>

                    {{-- TDS --}}
                    <div>
                        <label class="font-medium uppercase mb-2 block">TDS Deduction</label>
                        <div class="flex gap-4">
                            <label><input type="radio" name="tds_deduction" value="1"> Yes</label>
                            <label><input type="radio" name="tds_deduction" value="0" checked> No</label>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="text-center">
                        <button type="submit"
                                class="btn-primary px-4 py-2 uppercase">
                            Calculate
                        </button>
                    </div>

                </form>    

            </div>

            <div class="">
                
                <div id="result" class="  col-span-2 md:col-span-1  dark:bg-bg3 rounded-2xl ">
                    <div id="scheme-details" class="p-3 mt-3 box  rounded-10 bg-gray-50" style="display:none;">

                        <table class="w-full text-sm text-left border-collapse">
                            <tbody class="divide-y divide-gray-200">
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 w-1/3 uppercase">Scheme Code</td>
                                    <td class="px-4 py-2 text-primary">
                                    <span id="d_scheme_code"></span>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold  px-4 py-2 uppercase">Scheme Name</td>
                                    <td class="px-4 py-2 capitalize  ">
                                        <span id="d_scheme_name"></span>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Tenure</td>
                                    <td class="px-4 py-2 capitalize ">
                                        <span id="d_tenure"></span>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Minimum Amount</td>
                                    <td class="px-4 py-2">
                                        <span id="d_min_amount"></span>
                                    </td>
                                </tr>
                            
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Annual Interest Rate (%)</td>
                                    <td class="px-4 py-2    ">
                                        <span id="d_interest_rate"></span>
                                    </td>
                                </tr>
                                

                            </tbody>
                        </table>

                    </div>
                </div>

            </div>

        </div>


        <!--Tabs-->
        <div id="accordion" style="display:none;" class="box">

            <h3 class="mt-5 uppercase">Tabs</h3>

            <div class="tab mt-5 flex gap-2" id="tabButtons">
                <!-- JS tabs injected here-->
                <button class="tablinks active font-semibold px-4 py-2 uppercase" onclick="openTab(event, 'finalpayment')">Final Payment</button>
            </div>

            <!-- Default Final Payment tab content -->
            <div id="finalpayment" class="tabcontent w-full" style="display:block;">
            
                <table class="w-full text-sm border">
                    <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="font-semibold">Principal Amount (A)</td>
                        <td id="principal"></td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Interest Earned (B)</td>
                        <td id="interest_earned"></td>
                    </tr>
                    <tr>
                        <td class="font-semibold">TDS Deducted (C)</td>
                        <td id="tds_deducted"></td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Net Interest Earned (D = B - C)</td>
                        <td id="net_interest"></td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Maturity Bonus Amount (E)</td>
                        <td id="maturity_bonus"></td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Maturity Amount (A + D + E)</td>
                        <td id="maturity_amount"></td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Maturity Date</td>
                        <td id="maturity_date"></td>
                    </tr>
                    </tbody>
                </table>

            </div>

        </div>

    </div>
    
</div>

@endsection

@push('script')

<script>
    //console.log(summary);
    function openTab(evt, tabId) 
    {
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
           success: function(response) 
           {
                if (response.success) 
                {
                    let summary = response.results.summary;

                    // --- पहले summary update करो
                    $("#principal").text("INR " + parseFloat(summary.principal).toFixed(2));
                    $("#interest_earned").text("INR " + parseFloat(summary.interest_earned).toFixed(2));
                    $("#tds_deducted").text("INR " + parseFloat(summary.tds_deducted).toFixed(2));
                    $("#net_interest").text("INR " + parseFloat(summary.net_interest).toFixed(2));
                    $("#maturity_bonus").text("INR " + parseFloat(summary.maturity_bonus).toFixed(2));
                    $("#maturity_amount").text("INR " + parseFloat(summary.maturity_amount).toFixed(2));
                    $("#maturity_date").text(formatDateDMY(summary.maturity_date));

                    // पुराने yearly tabs साफ करो
                    $(".yearlyTabBtn").remove();
                    $(".yearlyTabContent").remove();

                    // --- अब yearly breakdown add करो
                    if (response.results.details && response.results.details.length > 0) {
                    let final = {
                        principal: 0, interest: 0, tds: 0,
                        netInterest: 0, bonus: 0,
                        maturityAmount: 0, maturityDate: ""
                    };
let rows = '';

if (response.results.periods && response.results.periods.length > 0) {
    response.results.periods.forEach(p => {
        rows += `
        <tr class="border-b">
            <td>${formatDateWithDash(p.period)}</td>
            <td>${p.days}</td>
            <td>${parseFloat(p.principal).toFixed(2)}</td>
            <td>${parseFloat(p.interest).toFixed(2)}</td>
            <td>${parseFloat(p.tds).toFixed(2)}</td>
            <td>${parseFloat(p.net_interest).toFixed(2)}</td>
            <td>${p.net_interest_due ? parseFloat(p.net_interest_due).toFixed(2) : ''}</td>
            <td>${p.principal_at_eoy ?? ''}</td>
            <td>${formatDateWithDash(p.due_by)}</td>
        </tr>`;
    });
}


response.results.details.forEach(function (yearData, index) {

    // =========================
    // FINAL ACCUMULATION ✅
    // =========================
    if (index === 0) {
        final.principal = parseFloat(yearData.principal) || 0;
    }

    final.interest       += parseFloat(yearData.interestEarned) || 0;
    final.tds            += parseFloat(yearData.tds) || 0;
    final.netInterest    += parseFloat(yearData.netInterest) || 0;
    final.bonus          += parseFloat(yearData.bonus) || 0;
    final.maturityAmount  = parseFloat(yearData.maturity) || 0;
    final.maturityDate    = formatDateDMY(yearData.date);

    // =========================
    // YEAR TAB BUTTON
    // =========================
    $("#tabButtons").append(`
        <button class="tablinks yearlyTabBtn"
            onclick="openTab(event, 'year_${yearData.year}')">
            ${yearData.year} Year
        </button>
    `);

    // =========================
    // YEAR ROWS (FILTER)
    // =========================
    let yearRows = '';

    if (response.results.periods && response.results.periods.length > 0) {
        response.results.periods
            .filter(p => parseInt(p.fd_year) === parseInt(yearData.year))
            .forEach(p => {
                yearRows += `
                <tr class="border-b">
                    <td>${formatDateWithDash(p.period)}</td>
                    <td>${p.days}</td>
                    <td>${parseFloat(p.principal).toFixed(2)}</td>
                    <td>${parseFloat(p.interest).toFixed(2)}</td>
                    <td>${parseFloat(p.tds).toFixed(2)}</td>
                    <td>${parseFloat(p.net_interest).toFixed(2)}</td>
                    <td>${p.net_interest_due !== null ? parseFloat(p.net_interest_due).toFixed(2) : ''}</td>
                    <td>${p.principal_at_eoy ?? ''}</td>
                    <td>${formatDateWithDash(p.due_by)}</td>
                </tr>`;
            });
    }

    // =========================
    // YEAR TAB CONTENT
    // =========================
    $("#accordion").append(`
        <div id="year_${yearData.year}" class="tabcontent yearlyTabContent">
            <table class="w-full text-sm border mt-3">
                <thead class="bg-gray-100">
                    <tr>
                        <th>Period</th>
                        <th>Days</th>
                        <th>Principal</th>
                        <th>Interest</th>
                        <th>TDS</th>
                        <th>Net Interest</th>
                        <th>Net Interest on Due Date</th>
                        <th>Principal @ EOY</th>
                        <th>Due Date</th>
                    </tr>
                        </thead>
                        <tbody>
                            ${yearRows || `<tr><td colspan="8" class="text-center">No Data</td></tr>`}
                        </tbody>
                    </table>
                </div>
            `);

        });




                        // Final Payment tab को overwrite करो yearly से
                        $("#principal").text("INR " + final.principal.toFixed(2));
                        $("#interest_earned").text("INR " + final.interest.toFixed(2));
                        $("#tds_deducted").text("INR " + final.tds.toFixed(2));
                        $("#net_interest").text("INR " + final.netInterest.toFixed(2));
                        $("#maturity_bonus").text("INR " + final.bonus.toFixed(2));
                        $("#maturity_amount").text("INR " + final.maturityAmount.toFixed(2));
                        $("#maturity_date").text(final.maturityDate);
                    }

                    // अब calculation दिखाओ
                    $("#accordion").show();

                } 
                else 
                {
                    $("#result").html(`<div class="alert alert-danger">Something went wrong.</div>`);
                }
            },

            error: function(xhr) {
                console.error(xhr.responseText);
                $("#result").html(`<div class="alert alert-danger">Server error, please try again.</div>`);
            }
        });
    }

    function numberToWords(n) 
    {
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

    function updateAmountInWords() 
    {
        const amount = parseInt($("#amount").val(), 10);
        $("#amount-in-words").text(!isNaN(amount) && amount >= 0 ? numberToWords(amount) : '');
    }



</script>

<!-- date fomate show d-m-y -->
<script>
   function formatDateDMY(dateStr) {
    if (!dateStr) return '';

    // Case 1: YYYY-MM-DD
    if (dateStr.includes('-')) {
        const [y, m, d] = dateStr.split('-');
        if (y.length === 4) {
            return `${d}-${m}-${y}`;
        }
    }

    // Case 2: DD/MM/YYYY
    if (dateStr.includes('/')) {
        const [d, m, y] = dateStr.split('/');
        return `${d}-${m}-${y}`;
    }

    return dateStr;
}

</script>

<script>
    function formatDateWithDash(dateStr) {
    if (!dateStr) return '';

    // agar period jaisa ho: "14/12/2025 - 14/01/2026"
    if (dateStr.includes('-')) {
        return dateStr.split('-').map(part => {
            return part.trim().replaceAll('/', '-');
        }).join(' - ');
    }

    // normal single date
    return dateStr.replaceAll('/', '-');
}

</script>

@endpush