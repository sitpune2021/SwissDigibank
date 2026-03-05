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

                    <div class="mb-3">
                        <label for="scheme_id" class="form-label block font-medium mb-2 uppercase">
                            FD Scheme
                            <span class="text-error">*</span>
                        </label>
                        <select name="scheme_id" id="scheme_id" class="form-select w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5 dark:bg-bg3 ">
                            <option value="">-- Select Scheme --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label  flex items-center gap-3 font-medium mb-2 uppercase">

                            <input type="checkbox" id="manual_entry_toggle" class="form-select w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5 dark:bg-bg3 ">
                            <span class="block">Enter Values Manually</span>
                        </label>
                    </div>
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
                        <label class="font-medium uppercase mb-2 block">Tenure Type *</label>
                        <div class="flex gap-4 mb-3">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="tenure_type" value="days">
                                <span>Days</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="tenure_type" value="months" checked>
                                <span>Months</span>
                            </label>
                        </div>

                        <label class="font-medium uppercase mb-2 block">Tenure of FD / MIS *</label>
                        <input type="number" id="tenure_value"
                            placeholder="Enter Tenure"
                            class="w-full border rounded-10 px-3 py-3 text-sm">
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

                                <tr>
                                    <td class="font-semibold px-4 py-2 uppercase">Lock In Period</td>
                                    <td class="px-4 py-2">
                                        <span id="d_lock_in"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="font-semibold px-4 py-2 uppercase">Interest Lock</td>
                                    <td class="px-4 py-2">
                                        <span id="d_interest_lock"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="font-semibold px-4 py-2 uppercase">Bonus</td>
                                    <td class="px-4 py-2">
                                        <span id="d_bonus"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="font-semibold px-4 py-2 uppercase">Penal Charge</td>
                                    <td class="px-4 py-2">
                                        <span id="d_penal"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="font-semibold px-4 py-2 uppercase">Cancellation Charge</td>
                                    <td class="px-4 py-2">
                                        <span id="d_cancel"></span>
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

            <h3 class="mt-5 uppercase">FD/ MIS Payout Information</h3>

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
    document.addEventListener("DOMContentLoaded", function() {

        const manualToggle = document.getElementById("manual_entry_toggle");
        const schemeDropdown = document.getElementById("scheme_id");

        const manualFields = [
            "amount",
            "interest_payout_type",
            "annual_interest_rate",
            "tenure_year",
            "tenure_month",
            "tenure_day",
            "bonus_type",
            "bonus"
        ];

        function toggleMode() {

            if (manualToggle.checked) {
                // Manual Mode ON
                schemeDropdown.disabled = true;

                manualFields.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.disabled = false;
                });

            } else {
                // Scheme Mode ON
                schemeDropdown.disabled = false;

                manualFields.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.disabled = true;
                });
            }
        }

        // Default state
        manualToggle.checked = false;
        toggleMode();

        manualToggle.addEventListener("change", toggleMode);

    });

    // *************************************************************************
    //console.log(summary);
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


    function calculateFD() {
        let tenureValue = parseFloat($("#tenure_value").val()) || 0;

        let tenureType = $("input[name='tenure_type']:checked").val();

        let tenure_year = 0;
        let tenure_month = 0;
        let tenure_day = 0;

        if (tenureType === "months") {
            tenure_month = tenureValue;
        } else {
            tenure_day = tenureValue;
        }

        let formData = {
            amount: $("#amount").val() || 0,
            open_date: $("#open_date").val(),
            annual_interest_rate: $("#annual_interest_rate").val() || 0,
            interest_payout_type: $("#interest_payout_type").val(),
            tenure_year: tenure_year,
            tenure_month: tenure_month,
            tenure_day: tenure_day,
            bonus: $("#bonus").val() || 0,
            bonus_type: $("#bonus_type").val() || 0,
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
                            principal: 0,
                            interest: 0,
                            tds: 0,
                            netInterest: 0,
                            bonus: 0,
                            maturityAmount: 0,
                            maturityDate: ""
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


                        response.results.details.forEach(function(yearData, index) {

                            // =========================
                            // FINAL ACCUMULATION ✅
                            // =========================
                            if (index === 0) {
                                final.principal = parseFloat(yearData.principal) || 0;
                            }

                            final.interest += parseFloat(yearData.interestEarned) || 0;
                            final.tds += parseFloat(yearData.tds) || 0;
                            final.netInterest += parseFloat(yearData.netInterest) || 0;
                            final.bonus += parseFloat(yearData.bonus) || 0;
                            final.maturityAmount = parseFloat(yearData.maturity) || 0;
                            final.maturityDate = formatDateDMY(yearData.date);

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

                    // Smooth scroll to tabs
                    $('html, body').animate({
                        scrollTop: $("#accordion").offset().top - 80
                    }, 600);
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch("{{ route('fd.schemes.fetch') }}")
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    let dropdown = document.getElementById("scheme_id");
                    result.data.forEach(function(scheme) {
                        let opt = document.createElement("option");
                        opt.value = scheme.id;
                        opt.textContent = scheme.scheme_name;
                        dropdown.appendChild(opt);
                    });
                }
            })
            .catch(err => console.error(err));
    });

    let currentSlabs = [];

    function detectSlab(slabs, totalDays) {
        for (let i = 0; i < slabs.length; i++) {
            if (totalDays >= slabs[i].day_from &&
                totalDays <= slabs[i].day_to) {
                return slabs[i];
            }
        }
        return null;
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Scheme Change
        document.getElementById("scheme_id").addEventListener("change", function() {

            let schemeId = this.value;
            if (!schemeId) {
                document.getElementById("scheme-details").style.display = "none";
                currentSlabs = [];
                return;
            }

            fetch("{{ route('fd.scheme.details', ':id') }}".replace(':id', schemeId))
                .then(response => response.json())
                .then(result => {

                    if (!result.success) return;

                    let scheme = result.scheme;
                    currentSlabs = result.slabs ?? [];
                    console.log("Loaded Slabs:", currentSlabs);

                    document.getElementById("d_scheme_code").textContent = scheme.scheme_code ?? '-';
                    document.getElementById("d_scheme_name").textContent = scheme.scheme_name ?? '-';
                    document.getElementById("d_min_amount").textContent =
                        parseFloat(scheme.min_amount ?? 0).toFixed(2) + " INR";

                    document.getElementById("scheme-details").style.display = "block";

                    document.getElementById("amount").value = scheme.min_amount ?? '';

                    // Default tenure set if scheme has fixed tenure
                    if (scheme.tenure) {
                        document.getElementById("tenure_value").value = scheme.tenure;
                    }

                    // If no fixed tenure (As per slab), set first slab max days as default
                    if (!scheme.tenure && currentSlabs.length > 0) {

                        let firstSlab = currentSlabs[0];

                        // convert slab days to months approx
                        let months = Math.round(firstSlab.day_to / 30.44);

                        document.getElementById("tenure_value").value = months;
                    }

                // Trigger slab detection automatically
                setTimeout(function() {

                    let tenureValue = parseInt(document.getElementById("tenure_value").value) || 0;
                    let tenureType = document.querySelector("input[name='tenure_type']:checked").value;

                    let totalDays;

                    if (tenureType === "months") {
                        totalDays = Math.round(tenureValue * 30.44);
                    } else {
                        totalDays = tenureValue;
                    }

                    let slab = detectSlab(currentSlabs, totalDays);

                        if (slab) {

                            document.getElementById("annual_interest_rate").value = slab.interest_rate;
                            document.getElementById("d_interest_rate").textContent = slab.interest_rate + " %";

                            if (slab.payout_type) {

                                let payoutSelect = document.getElementById("interest_payout_type");

                                let payout = slab.payout_type
                                    .toString()
                                    .trim()
                                    .replace(/\s+/g, '_')
                                    .toUpperCase();

                                console.log("DB payout:", slab.payout_type);
                                console.log("Converted payout:", payout);

                                payoutSelect.value = payout;
                            }

                        }

                    }, 200);

                    // Tenure
                    document.getElementById("d_tenure").textContent =
                        scheme.tenure ? scheme.tenure + " Months" : "As per Slab";

                    // Lock In
                    document.getElementById("d_lock_in").textContent =
                        scheme.lock_in_period ? scheme.lock_in_period + " Months" : "-";

                    // Interest Lock
                    document.getElementById("d_interest_lock").textContent =
                        scheme.interest_lock_in ? scheme.interest_lock_in + " Months" : "-";

                    // Bonus
                    document.getElementById("d_bonus").textContent =
                        scheme.bonus_rate ? scheme.bonus_rate + " " + scheme.bonus_type : "-";

                    // Penal Charge
                    document.getElementById("d_penal").textContent =
                        scheme.penal_charge ? scheme.penal_charge + " %" : "-";

                    // Cancellation Charge
                    document.getElementById("d_cancel").textContent =
                        scheme.cancellation_charge ? scheme.cancellation_charge + " " + scheme.cancellation_type : "-";
                });
        });

        // Tenure Input Listener (Only Once)
        document.getElementById("tenure_value").addEventListener("input", function() {
        if (!currentSlabs.length) return;

            let tenureValue = parseInt(this.value) || 0;
            let tenureType = document.querySelector("input[name='tenure_type']:checked").value;

            let totalDays;

            if (tenureType === "months") {
                totalDays = Math.round(tenureValue * 30.44);
            } else {
                totalDays = tenureValue;
            }

            let slab = detectSlab(currentSlabs, totalDays);

            if (slab) {

                // Interest Rate Fill
                document.getElementById("annual_interest_rate").value = slab.interest_rate;
                document.getElementById("d_interest_rate").textContent = slab.interest_rate + " %";

                if (slab.payout_type) {

                    let payoutSelect = document.getElementById("interest_payout_type");

                    let payout = slab.payout_type
                        .toString()
                        .trim()
                        .replace(/\s+/g, '_')
                        .toUpperCase();

                    payoutSelect.value = payout;
                }

            } else {

                document.getElementById("annual_interest_rate").value = "";
                document.getElementById("d_interest_rate").textContent = "N/A";
            }
        });

    });
</script>

@endpush