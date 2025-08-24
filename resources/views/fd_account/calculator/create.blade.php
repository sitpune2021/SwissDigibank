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

                {{-- <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4">
                        <span>Senior Citizen <span class="text-red-500">*</span></span>
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="senior_citizen" required class="w-4 h-4">
                        <label for="senior_citizen" class="text-sm">Yes</label>
                    </div>
                </div> --}}


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
    // --------- read inputs ----------
    const amount = parseFloat(document.getElementById("amount").value) || 0;
    const annualRate = parseFloat(document.getElementById("annual_interest_rate").value) || 0;
    const openDate = new Date(document.getElementById("open_date").value);
    const tenureYears = parseInt(document.getElementById("tenure_year").value) || 0;
    const tenureMonths = parseInt(document.getElementById("tenure_month").value) || 0;
    const tenureDays = parseInt(document.getElementById("tenure_day").value) || 0;
    const bonusType = document.getElementById("bonus_type").value;
    const bonusValue = parseFloat(document.getElementById("bonus").value) || 0;
    const tds = document.querySelector("input[name='tds_deduction']:checked").value === "1";
    const payoutType = document.getElementById("interest_payout_type").value; // e.g. QUARTERLY or CUMULATIVE_QUARTERLY

    // ---------- helpers ----------
    const DAYMS = 24*60*60*1000;

    function fmt(n) {
        // tidy money: remove trailing zeros (e.g., 25.00 -> 25, 25.60 -> 25.6)
        if (Math.abs(n) < 0.0000001) return "0";
        const s = n.toFixed(2);
        return s.replace(/\.?0+$/,'');
    }
    function dateISO(d) { return new Date(d.getFullYear(), d.getMonth(), d.getDate()); }
    function addDays(d, num) { const x = new Date(d); x.setDate(x.getDate()+num); return x; }
    function addMonthsMinusOneDay(d, m) {
        const x = new Date(d);
        x.setMonth(x.getMonth()+m);
        x.setDate(x.getDate()-1);
        return x;
    }
    function addYearsMinusOneDay(d, y) {
        const x = new Date(d);
        x.setFullYear(x.getFullYear()+y);
        x.setDate(x.getDate()-1);
        return x;
    }
    function daysInclusive(a,b) { return Math.floor((dateISO(b)-dateISO(a))/DAYMS)+1; }
    function ddmmyyyy(d) {
        const dd = String(d.getDate()).padStart(2,'0');
        const mm = String(d.getMonth()+1).padStart(2,'0');
        const yy = d.getFullYear();
        return `${dd}/${mm}/${yy}`;
    }
    function fyEndFor(date) {
        // FY in India: 1 Apr – 31 Mar. If month >= Apr (3), fy end = 31 Mar next year; else same year.
        const y = date.getFullYear();
        const fyEndYear = (date.getMonth() >= 3) ? y+1 : y;
        return new Date(fyEndYear, 2, 31); // 31-Mar
    }
    function freqInfo(pt) {
        // maps payout type to (#periods per year, cumulative flag)
        switch(pt){
            case "MONTHLY": return {perYear:12, cumulative:false};
            case "QUARTERLY": return {perYear:4, cumulative:false};
            case "HALF_YEARLY": return {perYear:2, cumulative:false};
            case "YEARLY": return {perYear:1, cumulative:false};

            case "CUMULATIVE_MONTHLY": return {perYear:12, cumulative:true};
            case "CUMULATIVE_QUARTERLY": return {perYear:4, cumulative:true};
            case "CUMULATIVE_HALF_YEARLY": return {perYear:2, cumulative:true};
            case "CUMULATIVE_YEARLY": return {perYear:1, cumulative:true};
            default: return {perYear:4, cumulative:false}; // safe default = QUARTERLY
        }
    }

    // ---------- maturity date ----------
    let maturityDate = new Date(openDate);
    maturityDate.setFullYear(maturityDate.getFullYear()+tenureYears);
    maturityDate.setMonth(maturityDate.getMonth()+tenureMonths);
    maturityDate.setDate(maturityDate.getDate()+tenureDays);
    const maturityDueBy = maturityDate; // “Due By” shown as this date when last payout ends the day before

    // ---------- schedule core (period-first, then FY split) ----------
    const {perYear, cumulative} = freqInfo(payoutType);
    const periodMonths = (12 / perYear);
    const periodRate = annualRate / perYear; // e.g. 10%/4 = 2.5% per quarter

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
                    <th class="border px-2 py-1">Net Interest on DUE DATE</th>
                    <th class="border px-2 py-1">Principal at EOY</th>
                    <th class="border px-2 py-1">Due By</th>
                </tr>
            </thead>
            <tbody>
    `;

    let periodStart = new Date(openDate);
    let principal = amount;
    let totalInterest = 0, totalTDS = 0;

    // we iterate payout periods (e.g., each quarter)
    while (periodStart < maturityDate) {
        // Period end is start + periodMonths - 1 day, but never past maturity-1 day
        let nominalPeriodEnd = addMonthsMinusOneDay(periodStart, periodMonths);
        let lastWorkingDay = addDays(maturityDate, -1); // payouts end day before maturity
        let periodEnd = nominalPeriodEnd > lastWorkingDay ? lastWorkingDay : nominalPeriodEnd;

        // If somehow start already beyond lastWorkingDay, break
        if (periodStart > lastWorkingDay) break;

        // Per-period (full) interest at fixed period rate, not day-count (matches your examples)
        const principalShown = principal; // shown in all segments within this payout
        const periodDays = daysInclusive(periodStart, periodEnd);
        const periodInterest = principalShown * (periodRate/100);
        const periodTDS = tds ? periodInterest * 0.10 : 0;
        const periodNet = periodInterest - periodTDS;

        // Split this payout period at FY boundary/boundaries
        let segStart = new Date(periodStart);
        while (segStart <= periodEnd) {
            const fyEnd = fyEndFor(segStart);
            let segEnd = fyEnd < periodEnd ? fyEnd : periodEnd;
            const segDays = daysInclusive(segStart, segEnd);

            // Allocate this segment's share from the full payout period amount
            const share = segDays / periodDays;
            const segInterest = periodInterest * share;
            const segTDS = tds ? segInterest * 0.10 : 0;
            const segNet = segInterest - segTDS;

            totalInterest += segInterest;
            totalTDS += segTDS;

            // Only the last segment of the payout shows:
            // - Net Interest on DUE DATE = full period net
            // - Principal at EOY (for cumulative) = principal + full period net
            // - Due By (for non-cumulative every payout; for cumulative only at maturity)
            const isLastSegmentOfPeriod = (segEnd.getTime() === periodEnd.getTime());
            const willShowDueBy = isLastSegmentOfPeriod && (!cumulative || (addDays(segEnd,1).getTime() === maturityDueBy.getTime()));
            const dueByStr = willShowDueBy ? ddmmyyyy(addDays(segEnd,1)) : "";

            const netOnDueDateStr = isLastSegmentOfPeriod ? fmt(periodNet) : "";
            const principalEOYStr = (isLastSegmentOfPeriod && cumulative) ? fmt(principal + periodNet) : "";

            schedulerHtml += `
                <tr>
                    <td class="border px-2 py-1">${ddmmyyyy(segStart)} - ${ddmmyyyy(segEnd)}</td>
                    <td class="border px-2 py-1">${segDays}</td>
                    <td class="border px-2 py-1">${fmt(principalShown)}</td>
                    <td class="border px-2 py-1">${segInterest.toFixed(0)}</td>
                    <td class="border px-2 py-1">${fmt(segTDS)}</td>
                    <td class="border px-2 py-1">${fmt(segNet)}</td>
                    <td class="border px-2 py-1">${netOnDueDateStr}</td>
                    <td class="border px-2 py-1">${principalEOYStr}</td>
                    <td class="border px-2 py-1">${dueByStr}</td>
                </tr>
            `;

            segStart = addDays(segEnd, 1);
        }

        // Apply compounding at the payout boundary (only for cumulative types)
        if (cumulative) {
            principal += periodNet;
        }
        // Move to next payout period
        periodStart = addDays(periodEnd, 1);
    }

    schedulerHtml += "</tbody></table>";

    // ---------- bonus & maturity ----------
    const bonusAmt = (bonusType === "%") ? (amount * (bonusValue/100)) : bonusValue;
    const totalNetInterest = totalInterest - totalTDS;
    const maturityAmount = cumulative
        ? (principal + bonusAmt)                    // principal already includes compounded net interest
        : (amount + totalNetInterest + bonusAmt);   // principal unchanged + all net interest

    // ---------- summary ----------
    const summaryHtml = `
        <h3 class="text-lg font-semibold mb-2">Maturity Summary</h3>
        <table class="table-auto border w-full text-sm">
            <tr><td>Principal Amount (A)</td><td>₹ ${fmt(amount)}</td></tr>
            <tr><td>Interest Earned (B)</td><td>₹ ${fmt(totalInterest)}</td></tr>
            <tr><td>TDS Deducted (C)</td><td>₹ ${fmt(totalTDS)}</td></tr>
            <tr><td>Net Interest Earned (D = B - C)</td><td>₹ ${fmt(totalNetInterest)}</td></tr>
            <tr><td>Maturity Bonus Amount (E)</td><td>₹ ${fmt(bonusAmt)}</td></tr>
            <tr><td><b>Maturity Amount (A + D + E)</b></td><td><b>₹ ${fmt(maturityAmount)}</b></td></tr>
            <tr><td>Maturity Date</td><td>${ddmmyyyy(maturityDate)}</td></tr>
        </table>
    `;

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
 
