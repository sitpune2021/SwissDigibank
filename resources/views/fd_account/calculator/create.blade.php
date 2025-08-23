@extends('layout.main')
@section('page-title', 'FD/ MIS Calculator')

@section('content')
    <div class="main-inner">
        {{-- Success Alert --}}
        @if (session('success'))
            <div id="success-alert"
                style="background-color: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
                <strong>Success:</strong> {{ session('success') }}
                <span onclick="document.getElementById('success-alert').style.display='none';"
                    style="position: absolute; top: 5px; right: 10px; cursor: pointer;">&times;</span>
            </div>
        @endif

        {{-- Error Alert --}}
        @if (session('error'))
            <div id="error-alert"
                style="background-color: #f8d7da; border: 1px solid #dc3545; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
                <strong>Error:</strong> {{ session('error') }}
                <span onclick="document.getElementById('error-alert').style.display='none';"
                    style="position: absolute; top: 5px; right: 10px; cursor: pointer;">&times;</span>
            </div>
        @endif

        <div class="box mb-4 xxxl:mb-6">
            <form id="companyForm" class="grid grid-cols-2 gap-4 xxxl:gap-6"
                onsubmit="event.preventDefault(); calculateFD();">

                {{-- Open Date --}}
                <div class="col-span-2 md:col-span-1">
                    <label for="open_date" class="md:text-lg font-medium block mb-4">Open Date <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="open_date" id="open_date"
                        value="{{ \Carbon\Carbon::today()->toDateString() }}"
                        class="w-full text-sm border rounded px-3 py-2">
                </div>

                {{-- Amount --}}
                <div class="col-span-2 md:col-span-1">
                    <label for="amount" class="md:text-lg font-medium block mb-4">Amount ( ₹ ) <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="amount" id="amount" class="w-full text-sm border rounded px-3 py-2"
                        placeholder="Enter amount" oninput="calculateFD()">
                    <div id="amount-in-words" class="text-xs text-red-500 mt-1"></div>
                </div>

                {{-- Interest Payout Type --}}
                <div class="col-span-2 md:col-span-1">
                    <label for="interest_payout_type" class="md:text-lg font-medium block mb-4">Interest Payout Type <span
                            class="text-red-500">*</span></label>
                    <select name="interest_payout_type" id="interest_payout_type"
                        class="w-full text-sm border rounded px-3 py-2" onchange="calculateFD()">
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
                    <label for="annual_interest_rate" class="md:text-lg font-medium block mb-4">Annual Interest Rate (%)
                        <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="annual_interest_rate" id="annual_interest_rate"
                        class="w-full text-sm border rounded px-3 py-2" placeholder="Enter Rate" oninput="calculateFD()">
                </div>

                {{-- Tenure --}}
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4">Tenure Period <span
                            class="text-red-500">*</span></label>
                    <div class="flex gap-3">
                        <input type="number" id="tenure_year" placeholder="Year"
                            class="w-1/2 text-sm border rounded px-1 py-1" oninput="calculateFD()">
                        <input type="number" id="tenure_month" placeholder="Month"
                            class="w-1/2 text-sm border rounded px-1 py-1" oninput="calculateFD()">
                        <input type="number" id="tenure_day" placeholder="Days"
                            class="w-1/2 text-sm border rounded px-1 py-1" oninput="calculateFD()">
                    </div>
                </div>

                {{-- Bonus --}}
                <div class="col-span-2 md:col-span-1">
                    <label for="bonus" class="md:text-lg font-medium block mb-4">Bonus <span
                            class="text-red-500">*</span></label>
                    <div class="flex gap-3 items-center">
                        <select id="bonus_type" class="w-1/3 text-sm border rounded px-2 py-1" onchange="calculateFD()"
                            required>
                            <option value="%">%</option>
                            <option value="fixed">Fixed</option>
                        </select>
                        <input type="number" id="bonus" step="0.01" placeholder="Bonus"
                            class="w-full text-sm border rounded px-2 py-1" oninput="calculateFD()" required>
                    </div>
                </div>


                {{-- TDS Deduction --}}
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4">TDS Deduction</label>
                    <div class="flex gap-4">
                        <label><input type="radio" name="tds_deduction" value="1" onchange="calculateFD()">
                            Yes</label>
                        <label><input type="radio" name="tds_deduction" value="0" checked
                                onchange="calculateFD()">
                            No</label>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4">
                        <span>Senior Citizen <span class="text-red-500">*</span></span>
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="senior_citizen" required class="w-4 h-4">
                        <label for="senior_citizen" class="text-sm">Yes</label>
                    </div>
                </div>


                {{-- Submit --}}
                <div class="col-span-2 mt-4">
                    <button type="submit" class="btn-primary px-4 py-2 bg-blue-600 text-white rounded">Calculate</button>
                </div>
            </form>
            <div id="summary" class="mt-8 hidden p-4 border rounded bg-white shadow"></div>
            <div id="result" class="mt-4 p-4 border rounded"></div>
            <div id="output"></div>

            <div id="schedule" class="mt-8 hidden p-4 border rounded bg-white shadow"></div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection

@push('script')
    <script>
        function calculateFD() {
            const amount = parseFloat(document.getElementById("amount").value) || 0;
            const annualRate = parseFloat(document.getElementById("annual_interest_rate").value) || 0;
            const openDate = new Date(document.getElementById("open_date").value);
            const tenureYears = parseInt(document.getElementById("tenure_year").value) || 0;
            const tenureMonths = parseInt(document.getElementById("tenure_month").value) || 0;
            const tenureDays = parseInt(document.getElementById("tenure_day").value) || 0;
            const bonusType = document.getElementById("bonus_type").value;
            const bonusValue = parseFloat(document.getElementById("bonus").value) || 0;
            const tds = document.querySelector("input[name='tds_deduction']:checked").value === "1";
            const payoutType = document.getElementById("interest_payout_type").value;

            // maturity date
            let maturityDate = new Date(openDate);
            maturityDate.setFullYear(maturityDate.getFullYear() + tenureYears);
            maturityDate.setMonth(maturityDate.getMonth() + tenureMonths);
            maturityDate.setDate(maturityDate.getDate() + tenureDays);

            // interest earned (simple interest for now)
            const totalMonths = tenureYears * 12 + tenureMonths + tenureDays / 30;
            const interestEarned = (amount * annualRate * (totalMonths / 12)) / 100;

            // TDS
            const tdsDeducted = tds ? interestEarned * 0.1 : 0; // 10% TDS
            const netInterest = interestEarned - tdsDeducted;

            // bonus
            let bonusAmt = 0;
            if (bonusType === "%") {
                bonusAmt = (amount * bonusValue) / 100;
            } else {
                bonusAmt = bonusValue;
            }

            // maturity
            const maturityAmount = amount + netInterest + bonusAmt;
            // summary
            const summaryHtml = `
        <h3 class="text-lg font-semibold mb-2">Maturity Summary</h3>
        <table class="table-auto border w-full text-sm">
            <tr><td>Principal Amount (A)</td><td>₹ ${amount.toFixed(2)}</td></tr>
            <tr><td>Interest Earned (B)</td><td>₹ ${interestEarned.toFixed(2)}</td></tr>
            <tr><td>TDS Deducted (C)</td><td>₹ ${tdsDeducted.toFixed(2)}</td></tr>
            <tr><td>Net Interest Earned (D = B - C)</td><td>₹ ${netInterest.toFixed(2)}</td></tr>
            <tr><td>Maturity Bonus Amount (E)</td><td>₹ ${bonusAmt.toFixed(2)}</td></tr>
            <tr><td><b>Maturity Amount (A + D + E)</b></td><td><b>₹ ${maturityAmount.toFixed(2)}</b></td></tr>
            <tr><td>Maturity Date</td><td>${maturityDate.toLocaleDateString()}</td></tr>
        </table>
    `;

            // -------- Financial Year–wise Schedule --------
            let schedulerHtml = `
    <h3 class="text-lg font-semibold mb-2 mt-6">Year-wise Schedule</h3>
    <table class="table-auto border w-full text-sm">
        <thead>
            <tr>
                <th class="border px-2 py-1">Period</th>
                <th class="border px-2 py-1">Days</th>
                <th class="border px-2 py-1">Principal (A)</th>
                <th class="border px-2 py-1">Interest</th>
                <th class="border px-2 py-1">TDS (B)</th>
                <th class="border px-2 py-1">Net Interest (A - B)</th>
                <th class="border px-2 py-1">Net Interest on Due Date</th>
                <th class="border px-2 py-1">Principal EOY</th>
                <th class="border px-2 py-1">Due By</th>
            </tr>
        </thead>
        <tbody>
    `;

            let start = new Date(openDate);
            let end = new Date(maturityDate);
            let principalEOY = amount;
            let cumulativeNetInterest = 0;

            // helper: get next payout date based on payout type
            function getNextPayoutDate(date, maturityDate, payoutType) {
                let next = new Date(date);
                switch (payoutType) {
                    case "CUMULATIVE_YEARLY":
                    case "YEARLY":
                        next.setFullYear(next.getFullYear() + 1);
                        break;
                    case "CUMULATIVE_HALF_YEARLY":
                    case "HALF_YEARLY":
                        next.setMonth(next.getMonth() + 6);
                        break;
                    case "CUMULATIVE_QUARTERLY":
                    case "QUARTERLY":
                        next.setMonth(next.getMonth() + 3);
                        break;
                    case "CUMULATIVE_MONTHLY":
                    case "MONTHLY":
                        next.setMonth(next.getMonth() + 1);
                        break;
                    default:
                        next.setFullYear(next.getFullYear() + 1); // fallback yearly
                }
                // don’t cross maturity
                if (next > maturityDate) return new Date(maturityDate);
                return next;
            }

            // Loop until maturity
            while (start < end) {
                // 1st period: StartDate → 31st March (same FY)
                let fyEnd = new Date(start.getFullYear() + (start.getMonth() >= 3 ? 1 : 0), 2, 31);
                if (fyEnd > end) fyEnd = new Date(end); // don’t cross maturity

                let days1 = Math.floor((fyEnd - start) / (1000 * 60 * 60 * 24)) + 1;
                let interest1 = (principalEOY * annualRate * (days1 / 365)) / 100;
                let tds1 = tds ? interest1 * 0.1 : 0;
                let net1 = interest1 - tds1;
                cumulativeNetInterest += net1;

                schedulerHtml += `
            <tr>
                <td class="border px-2 py-1">${start.toLocaleDateString()} - ${fyEnd.toLocaleDateString()}</td>
                <td class="border px-2 py-1">${days1}</td>
                <td class="border px-2 py-1">${principalEOY}</td>
                <td class="border px-2 py-1">${interest1.toFixed(0)}</td>
                <td class="border px-2 py-1">${tds1.toFixed(1)}</td>
                <td class="border px-2 py-1">${net1.toFixed(0)}</td>
                <td class="border px-2 py-1"></td>
                <td class="border px-2 py-1"></td>
                <td class="border px-2 py-1"></td>
            </tr>
        `;

                // 2nd part: FY start → Next payout (depends on payoutType)
                let fyStart = new Date(start);
                fyStart.setDate(fyStart.getDate() + 1);
                let secondEnd = getNextPayoutDate(fyStart, end, payoutType);

                if (fyStart <= secondEnd) {
                    let days2 = Math.floor((secondEnd - fyStart) / (1000 * 60 * 60 * 24)) + 1;
                    let interest2 = (principalEOY * annualRate * (days2 / 365)) / 100;
                    let tds2 = tds ? interest2 * 0.1 : 0;
                    let net2 = interest2 - tds2;
                    cumulativeNetInterest += net2;
                    let dueDate = new Date(secondEnd);
                    dueDate.setDate(dueDate.getDate() + 1);

                    schedulerHtml += `
                <tr>
                    <td class="border px-2 py-1">${fyStart.toLocaleDateString()} - ${secondEnd.toLocaleDateString()}</td>
                    <td class="border px-2 py-1">${days2}</td>
                    <td class="border px-2 py-1">${principalEOY}</td>
                    <td class="border px-2 py-1">${interest2.toFixed(0)}</td>
                    <td class="border px-2 py-1">${tds2.toFixed(1)}</td>
                    <td class="border px-2 py-1">${net2.toFixed(0)}</td>
                    <td class="border px-2 py-1">${cumulativeNetInterest.toFixed(0)}</td>
                    <td class="border px-2 py-1">${principalEOY}</td>
                    <td class="border px-2 py-1">${dueDate.toLocaleDateString()}</td>
                </tr>
            `;
                    start = new Date(secondEnd);
                    start.setDate(start.getDate() + 1);
                } else {
                    break;
                }
            }

            schedulerHtml += "</tbody></table>";

            // render
            document.getElementById("output").innerHTML =
                "<div class='mb-6'>" + summaryHtml + "</div>" +
                "<div>" + schedulerHtml + "</div>";
        }
    </script>

    <script>
        function numberToWords(n) {
            const a = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten",
                "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen"
            ];
            const b = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];

            if (n < 20) return a[n];
            if (n < 100) return b[Math.floor(n / 10)] + (n % 10 ? " " + a[n % 10] : "");
            if (n < 1000) return a[Math.floor(n / 100)] + " Hundred " + (n % 100 ? numberToWords(n % 100) : "");
            if (n < 100000) return numberToWords(Math.floor(n / 1000)) + " Thousand " + (n % 1000 ? numberToWords(n %
                1000) : "");
            if (n < 10000000) return numberToWords(Math.floor(n / 100000)) + " Lakh " + (n % 100000 ? numberToWords(n %
                100000) : "");
            return numberToWords(Math.floor(n / 10000000)) + " Crore " + (n % 10000000 ? numberToWords(n % 10000000) : "");
        }

        function updateAmountInWords() {
            const amountInput = document.getElementById('amount');
            const amountInWordsDiv = document.getElementById('amount-in-words');

            const amount = parseInt(amountInput.value, 10);
            if (!isNaN(amount) && amount >= 0) {
                amountInWordsDiv.textContent = numberToWords(amount);
            } else {
                amountInWordsDiv.textContent = '';
            }
        }
        document.getElementById('amount').addEventListener('input', updateAmountInWords);
    </script>
@endpush
