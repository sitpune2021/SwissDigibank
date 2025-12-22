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

    {{-- Alerts --}}
    {{-- @if (session('success'))
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
    @endif --}}
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
                                   
                <input type="checkbox" id="" class="form-select w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5 dark:bg-bg3 ">
                <span class="block">Enter Values Manually</span>
                </label>
            </div>

            {{-- Open Date --}}
            <div class="mt-4">
                <label for="open_date" class="font-medium flex items-center space-x-2 uppercase  mb-2">Open Date <span class="text-red-500">*</span></label>
                <input type="date" id="open_date" value="{{ \Carbon\Carbon::today()->toDateString() }}"
                    class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5 dark:bg-bg3 ">
            </div>

            {{-- Amount --}}
            <div class="mt-4">
                <label for="amount" class="font-medium flex items-center space-x-2 uppercase  mb-2">Amount (₹) <span class="text-red-500">*</span></label>
                <input type="number" id="amount" placeholder="Enter amount"
                    class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5 dark:bg-bg3 " oninput="updateAmountInWords();">
                     <!-- <input type="number" id="amount" placeholder="Enter amount"
                    class="w-full border rounded px-3 py-2" oninput="updateAmountInWords(); calculateFD();"> -->
                
                <div id="amount-in-words" class="text-xs text-red-500 mt-1"></div>
            </div>

            {{-- Interest Payout Type --}}
            <div class="mt-4">
                <label for="interest_payout_type" class="font-medium flex items-center space-x-2 uppercase  mb-2">Interest Payout Type <span class="text-red-500">*</span></label>
                <!-- <select id="interest_payout_type" class="w-full border rounded px-3 py-2" onchange="calculateFD()"> -->
                <select id="interest_payout_type" class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5 dark:bg-bg3">
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
            <div class="mt-4">
                <label for="annual_interest_rate" class="font-medium flex items-center space-x-2 uppercase  mb-2">Annual Interest Rate (%) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" id="annual_interest_rate"
                    class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5 dark:bg-bg3" placeholder="Enter Rate">
            </div>

            {{-- Tenure --}}
            <div class="mt-4">
                <label class="font-medium flex items-center space-x-2 uppercase  mb-2">Tenure Period <span class="text-red-500">*</span></label>
                <div class="flex gap-3">
                    <input type="number" id="tenure_year" placeholder="Year" class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5 dark:bg-bg3" >
                    <input type="number" id="tenure_month" placeholder="Month" class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5 dark:bg-bg3">
                    <input type="number" id="tenure_day" placeholder="Days" class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5 dark:bg-bg3" >
                </div>
            </div>

            {{-- Bonus --}}
            <div class="mt-4">
                <label for="bonus" class="font-medium flex items-center space-x-2 uppercase  mb-2">Bonus</label>
                <div class="flex gap-3">
                    <select id="bonus_type" class="w-24  border rounded-10 px-3 py-3  text-sm bg-secondary/5 dark:bg-bg3" >
                        <option value="%">%</option>
                        <option value="fixed">Fixed</option>
                    </select>
                    <input type="number" id="bonus" step="0.01" placeholder="Bonus"
                        class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5 dark:bg-bg3">
                </div>
            </div>

            {{-- TDS Deduction --}}
            <div class="mt-4">
                <label class="font-medium flex items-center space-x-2 uppercase  mb-2">TDS Deduction</label>
                <div class="flex gap-4 items-center">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="tds_deduction" value="1" onchange="calculateFD()">
                         <span class="block">Yes</span>
                        </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="tds_deduction" value="0" checked onchange="calculateFD()">
                        <span class="block">No</span>
                        </label>
                </div>
            </div>

            {{-- Submit --}}
            <div class=" mt-5 text-center">
                <button type="submit" class="btn-primary px-4 py-2 uppercase ">Calculate</button>
            </div>
        </form>

      

        </div>

        <div class="">
              
        <div id="result" class="  col-span-2 md:col-span-1  dark:bg-bg3 rounded-2xl ">
            <div id="scheme-details" class="p-3 mt-3 box  rounded-10 bg-gray-50" style="display:none;">
                {{-- <p><strong>Scheme Code:</strong> <span id="d_scheme_code"></span></p> --}}
                {{-- <p><strong>Scheme Name:</strong> <span id="d_scheme_name"></span></p> --}}
                {{-- <p><strong>Tenure:</strong> <span id="d_tenure"></span></p> --}}
                {{-- <p><strong>Minimum Amount:</strong> <span id="d_min_amount"></span></p> --}}
                {{-- <p><strong>Annual Interest Rate (%):</strong> <span id="d_interest_rate"></span></p> --}}

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
    <!--Tabs-->
<div id="accordion" style="display:none;" class="box">
    <h3 class="mt-5 uppercase">Tabs</h3>
    <div class="tab mt-5 flex gap-2" id="tabButtons">
        <!-- JS tabs injected here-->
        <button class="tablinks active font-semibold px-4 py-2 uppercase" onclick="openTab(event, 'finalpayment')">Final Payment</button>
    </div>

    <!-- Default Final Payment tab content -->
    <div id="finalpayment" class="tabcontent w-full" style="display:block;">
        <table class="w-full ">
            <tbody class="divide-y divide-gray-200">
                <tr class="border-b">
                    <td class="font-semibold px-4 py-2 uppercase">Principal Amount (A)</td>
                    <td id="principal" class="px-4 py-2 capitalize"></td>
                </tr>
                <tr class="border-b">
                    <td class="font-semibold px-4 py-2 uppercase">Interest Earned (B)</td>
                    <td id="interest_earned" class="px-4 py-2 capitalize"></td>
                </tr>
                <tr class="border-b">
                    <td class="font-semibold px-4 py-2 uppercase">TDS Deducted (C)</td>
                    <td id="tds_deducted" class="px-4 py-2 capitalize"></td>
                </tr>
                <tr class="border-b">
                    <td class="font-semibold px-4 py-2 uppercase">Net Interest Earned (D = B - C)</td>
                    <td id="net_interest" class="px-4 py-2 capitalize"></td>
                </tr>
                <tr class="border-b">
                    <td class="font-semibold px-4 py-2 uppercase">Maturity Bonus Amount (E)</td>
                    <td id="maturity_bonus" class="px-4 py-2 capitalize"></td>
                </tr>
                <tr class="border-b">
                    <td class="font-semibold px-4 py-2 uppercase">Maturity Amount (A + D + E)</td>
                    <td id="maturity_amount" class="px-4 py-2 capitalize"></td>
                </tr>
                <tr class="">
                    <td class="font-semibold px-4 py-2 uppercase">Maturity Date</td>
                    <td id="maturity_date" class="px-4 py-2 capitalize"></td>
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
document.addEventListener("DOMContentLoaded", function () {
    fetch("{{ route('fd.schemes.fetch') }}")
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                let dropdown = document.getElementById("scheme_id");
                result.data.forEach(function (scheme) {
                    let opt = document.createElement("option");
                    opt.value = scheme.id;
                    opt.textContent = scheme.scheme_name;
                    dropdown.appendChild(opt);
                });
            }
        })
        .catch(err => console.error(err));
});

document.getElementById("scheme_id").addEventListener("change", function () {
    let schemeId = this.value;

    if (schemeId) {
        fetch(`/fetch-scheme/${schemeId}`)
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    let s = result.data;
                    document.getElementById("d_scheme_code").textContent = s.scheme_code;
                    document.getElementById("d_scheme_name").textContent = s.scheme_name;
                    document.getElementById("d_tenure").textContent = s.tenure + " MONTHS";
                    document.getElementById("d_min_amount").textContent = s.min_amount + " INR";
                    document.getElementById("d_interest_rate").textContent = s.annual_interest_rate + " %";

                    document.getElementById("scheme-details").style.display = "block";

                    // Auto-fill भी कर सकते हो
                    document.getElementById("annual_interest_rate").value = s.annual_interest_rate;
                    document.getElementById("tenure_month").value = s.tenure;
                    document.getElementById("amount").value = s.min_amount;
                     // Auto select payout type
                    let payoutSelect = document.getElementById("interest_payout_type");
                    if (s.tenure == 6) {
                        payoutSelect.value = "HALF_YEARLY";
                    } else if (s.tenure == 12) {
                        payoutSelect.value = "YEARLY";
                    } else {
                        payoutSelect.value = ""; // default
                    }

                } else {
                    document.getElementById("scheme-details").style.display = "none";
                }
            })
            .catch(err => console.error(err));
    } else {
        document.getElementById("scheme-details").style.display = "none";
    }
});

</script>
<script>
    console.log(summary);
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
                    $("#maturity_date").text(summary.maturity_date);

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

                    response.results.details.forEach(function(yearData, index) 
                    {
                        // Tab button
                        $("#tabButtons").append(`
                            <button class="tablinks yearlyTabBtn" onclick="openTab(event, 'year${yearData.year}')">
                                Year ${yearData.year}
                            </button>
                        `);

                        // Tab content
                        $("#accordion").append(`
                            <div id="year${yearData.year}" class="tabcontent yearlyTabContent w-full" style="display:none;">
                                <table class="w-full">
                                    <tbody class="divide-y divide-gray-200">
                                        <tr class="border-b">
                                            <td class="font-semibold px-4 py-2 uppercase">Principal Amount (A)</td>
                                            <td  class="px-4 py-2 capitalize">INR ${parseFloat(yearData.principal).toFixed(2)}</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold px-4 py-2 uppercase">Interest Earned (B)</td>
                                            <td class="px-4 py-2 capitalize">INR ${parseFloat(yearData.interestEarned).toFixed(2)}</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold px-4 py-2 uppercase">TDS Deducted (C)</td>
                                            <td class="px-4 py-2 capitalize" >INR ${parseFloat(yearData.tds).toFixed(2)}
                                             </td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold px-4 py-2 uppercase">Net Interest (D = B - C)</td>
                                            <td class="px-4 py-2 capitalize">INR ${parseFloat(yearData.netInterest).toFixed(2)}</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td  class="font-semibold px-4 py-2 uppercase">Maturity Bonus (E)</td>
                                            <td class="px-4 py-2 capitalize">INR ${parseFloat(yearData.bonus).toFixed(2)}</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td  class="font-semibold px-4 py-2 uppercase">Maturity Amount (A + D + E)</td>
                                            <td class="px-4 py-2 capitalize">INR ${parseFloat(yearData.maturity).toFixed(2)}</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold px-4 py-2 uppercase">Maturity Date</td>
                                            <td class="px-4 py-2 capitalize">${yearData.date}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        `);

                        // Final calculation के लिए accumulate करो
                        if (index === 0) 
                        {
                            final.principal = parseFloat(yearData.principal) || 0;
                        }
                        final.interest += parseFloat(yearData.interestEarned) || 0;
                        final.tds += parseFloat(yearData.tds) || 0;
                        final.netInterest += parseFloat(yearData.netInterest) || 0;
                        final.bonus += parseFloat(yearData.bonus) || 0;
                        final.maturityAmount = parseFloat(yearData.maturity) || 0; // overwrite last year
                        final.maturityDate = yearData.date;
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

@endpush