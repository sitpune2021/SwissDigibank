@extends('layout.main')
<style>
    input[type="checkbox"] {
        width: 28px;
        height: 28px;
        accent-color: green;
    }

    input[type="checkbox"]:checked {
        background-color: green;
        border: none;
    }
</style>

@section('content')
    <div class="main-inner">
        <h2 class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">RD / DD Calculator</h2>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 p-6 min-h-screen">
            <!-- Calculator Section -->
            <div class="col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6">

                <div class="space-y-4">
                    <!-- Scheme -->
                    <div>
                        <label class="font-medium block mb-2">
                            Scheme <span class="text-red-500">*</span>
                        </label>
                        <select id="scheme" required
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Scheme</option>
                            <option value="001">001 JEWELLERS - Rj</option>
                        </select>
                    </div>

                    <!-- Enter Values Manually -->
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="manualCheckbox" class="w-7 h-7 cursor-pointer">
                        <span class="text-sm text-gray-700">Enter Values Manually</span>
                    </div>

                    <!-- Open Date -->
                    <div>
                        <label class="font-medium block mb-2">Open Date<span class="text-red-500">*</span></label>
                        <input type="text" id="date2" placeholder="dd/mm/yyyy"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    </div>

                    <!-- RD / DD Amount -->
                    <div>
                        <label class="font-medium block mb-2">RD / DD Amount <span class="text-red-500">*</span></label>
                        <input type="number" id="amount"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter amount">
                    </div>

                    <!-- Frequency -->
                    <div>
                        <label class="font-medium block mb-2">RD / DD Frequency <span class="text-red-500">*</span></label>
                        <select id="frequency"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option>Select RD / DD Frequency </option>
                            <option>DAILY</option>
                            <option>WEEKLY</option>
                            <option>BI_WEEKLY</option>
                            <option>MONTHLY</option>
                            <option>QUARTERLY</option>
                            <option>HALF-YEARLY</option>
                            <option>YEARLY</option>
                        </select>
                    </div>

                    <!-- Interest Compounding -->
                    <div>
                        <label class="font-medium block mb-2">Interest Comp. Interval <span
                                class="text-red-500">*</span></label>
                        <select id="compInterval"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option>Select Intervel Compounding</option>
                            <option>MONTHLY</option>
                            <option>QUARTERLY</option>
                            <option>HALF-YEARLY</option>
                            <option>YEARLY</option>
                        </select>
                    </div>

                    <!-- Interest Rate -->
                    <div>
                        <label class="font-medium block mb-2">Interest Rate <span class="text-red-500">*</span></label>
                        <input type="number" id="interestRate"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Interest Rate">
                    </div>

                    <!-- Tenure -->
                    <div>
                        <label class="font-medium block mb-2">Tenure of RD / DD <span class="text-red-500">*</span></label>
                        <div class="flex gap-1">
                            <input type="text" id="tenure_type" name="tenure_type" value="DAYS"
                                class="w-full text-sm bg-primary/5 dark:bg-bg3 border 
                                border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Tenure" readonly="readonly">
                            <input type="number" id="tenureNumber"
                                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter tenure of RD/ DD">
                        </div>
                    </div>

                    <!-- Bonus -->
                    <div>
                        <label class="font-medium block mb-2">Bonus<span class="text-red-500">*</span></label>
                        <div class="flex gap-2">
                            <select id="bonusSelect" required
                                class="w-auto text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                <option value="%">(%)</option>
                                <option value="fixed">FIXED</option>
                            </select>
                            <input type="text" id="bonusInput" required
                                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Bonus">
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-center col-span-2 gap-4 mt-2 md:gap-6">
                        <button id="calculateBtn" class="btn-primary" type="submit">Calculate</button>
                        <button class="btn-outline" type="button">Back</button>
                    </div>
                </div>

                <!-- Hidden Result Section -->
                <div id="resultSection" class="hidden">
                    <table class="w-full border-separate border-spacing-y-2 border-t mt-6">
                        <tbody>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Total Deposit </td>
                                <td class="text-gray-700 px-4 py-2 border-b">234.00</td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Interest Earned</td>
                                <td class="text-gray-700 px-4 py-2 border-b">85.00</td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Bonus</td>
                                <td class="text-gray-700 px-4 py-2 border-b">0.00</td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Maturity</td>
                                <td class="text-gray-700 px-4 py-2 border-b">450.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div id="schemeInfo" class=" box hidden col-span-2 md:col-span-1 dark:bg-bg3 rounded-10">
                <div class="mt-6">
                    <!-- Header -->
                    <div
                        class=" bg-Secondary/5 text-black font-semibold px-4 py-2 rounded-10 flex justify-between items-center cursor-pointer">
                        <span>Scheme Info</span>
                        <button id="toggleButton" class="text-white text-xl font-bold focus:outline-none">-</button>
                    </div>

                    <!-- Collapsible Table -->
                    <div id="schemeContent"
                        class="bg-white dark:bg-bg rounded-10 shadow overflow-hidden transition-all duration-500"
                        style="max-height: 1000px; opacity: 1;">
                        <div class="p-6 bg-white dark:bg-bg3 rounded-lg shadow-md">
                            <table class="min-w-full border-separate border-spacing-y-2">
                                <tbody>
                                    <tr>
                                        <td class="font-medium px-4 py-2 border-b">Scheme Code</td>
                                        <td class="text-gray-700 px-4 py-2 border-b">001 JEWELLERS</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium px-4 py-2 border-b">Scheme Name</td>
                                        <td class="text-gray-700 px-4 py-2 border-b">Rj</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium px-4 py-2 border-b">Deposit Frequency</td>
                                        <td class="text-gray-700 px-4 py-2 border-b">MONTHLY</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium px-4 py-2 border-b">Min. Amount</td>
                                        <td class="text-gray-700 px-4 py-2 border-b">5,000.00</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium px-4 py-2 border-b">Minimum Lock in Period</td>
                                        <td class="text-gray-700 px-4 py-2 border-b">6 Months</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium px-4 py-2 border-b">Interest (%)</td>
                                        <td class="text-gray-700 px-4 py-2 border-b">7.15 %</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium px-4 py-2 border-b">Interest Comp. Interval</td>
                                        <td class="text-gray-700 px-4 py-2 border-b">QUARTERLY</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium px-4 py-2 border-b">Interest Lock in Period</td>
                                        <td class="text-gray-700 px-4 py-2 border-b">0 Months</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium px-4 py-2 border-b">Tenure of RD</td>
                                        <td class="text-gray-700 px-4 py-2 border-b">60 MONTHS</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium px-4 py-2 border-b">Cancellation Charges</td>
                                        <td class="text-gray-700 px-4 py-2 border-b">2.00 %</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium px-4 py-2 border-b">Penal Charges (%)</td>
                                        <td class="text-gray-700 px-4 py-2 border-b">2.00 %</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium px-4 py-2 border-b">Bonus Rate</td>
                                        <td class="text-gray-700 px-4 py-2 border-b">2.50 %</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium px-4 py-2 border-b">Penalty Charges (After Grace Period)
                                        </td>
                                        <td class="text-gray-700 px-4 py-2 border-b">2.0 %</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium px-4 py-2 border-b">Active</td>
                                        <td class="px-4 py-2 border-b">
                                            <span
                                                class="px-3 py-1 text-xs font-semibold text-white bg-green-500 rounded-full">Yes</span>
                                        </td>
                                    </tr>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dateInput = document.getElementById("date2");
            const today = new Date();
            const day = String(today.getDate()).padStart(2, '0');
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
            const year = today.getFullYear();

            dateInput.value = `${day}/${month}/${year}`;
        });
    </script>
    <script>
        const manualCheckbox = document.getElementById('manualCheckbox');
        const scheme = document.getElementById('scheme');
        const frequency = document.getElementById('frequency');
        const compInterval = document.getElementById('compInterval');
        const interestRate = document.getElementById('interestRate');
        const tenureText = document.getElementById('tenureText');
        const tenureNumber = document.getElementById('tenureNumber');
        const bonusSelect = document.getElementById('bonusSelect');
        const bonusInput = document.getElementById('bonusInput');

        const schemeInfo = document.getElementById('schemeInfo');
        const schemeContent = document.getElementById('schemeContent');
        const toggleButton = document.getElementById('toggleButton');

        const calculateBtn = document.getElementById('calculateBtn');
        const resultSection = document.getElementById('resultSection');

        // Hide scheme info initially
        schemeInfo.classList.add('hidden');

        // Handle manual checkbox toggle
        manualCheckbox.addEventListener('change', () => {
            if (manualCheckbox.checked) {
                scheme.disabled = true;
                frequency.disabled = false;
                compInterval.disabled = false;
                interestRate.disabled = false;
                tenureText.disabled = false;
                tenureNumber.disabled = false;
                bonusSelect.disabled = false;
                bonusInput.disabled = false;
            } else {
                scheme.disabled = false;
                frequency.disabled = true;
                compInterval.disabled = true;
                interestRate.disabled = true;
                tenureText.disabled = true;
                tenureNumber.disabled = true;
                bonusSelect.disabled = true;
                bonusInput.disabled = true;
            }
        });
        manualCheckbox.dispatchEvent(new Event('change'));

        // Toggle collapse button for scheme info
        let isOpen = true;

        function toggleSchemeInfo() {
            if (isOpen) {
                schemeContent.style.maxHeight = '0';
                schemeContent.style.opacity = '0';
                toggleButton.textContent = '+';
            } else {
                schemeContent.style.maxHeight = '1000px';
                schemeContent.style.opacity = '1';
                toggleButton.textContent = '-';
            }
            isOpen = !isOpen;
        }
        toggleButton.addEventListener('click', toggleSchemeInfo);

        // Show or hide scheme info based on dropdown selection
        scheme.addEventListener('change', function() {
            if (this.value) {
                schemeInfo.classList.remove('hidden');
                schemeContent.style.maxHeight = '1000px';
                schemeContent.style.opacity = '1';
                toggleButton.textContent = '-';
                isOpen = true;
            } else {
                schemeInfo.classList.add('hidden');
                schemeContent.style.maxHeight = '0';
                schemeContent.style.opacity = '0';
                toggleButton.textContent = '+';
                isOpen = false;
            }
        });


        calculateBtn.addEventListener('click', () => {
            resultSection.classList.remove('hidden'); // Show the hidden div
        });
    </script>

    <script>
        // ----- helpers -----
        function toNum(v) {
            if (typeof v === "number") return v;
            if (typeof v === "string") {
                const n = parseFloat(v.replace(/,/g, "").replace(/[^\d.]/g, ""));
                return isNaN(n) ? 0 : n;
            }
            return 0;
        }

        function formatINR(n) {
            return n.toLocaleString("en-IN", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // ----- core logic -----
        function calcRD({
            amount,
            frequency,
            tenureUnit,
            tenureValue,
            interestRate,
            compInterval,
            bonusRate
        }) {
            const amt = toNum(amount);
            const freq = (frequency || "DAILY").toUpperCase().trim();
            const unit = (tenureUnit || "MONTHS").toUpperCase().trim();
            const tVal = parseInt(toNum(tenureValue)) || 0;
            const rate = toNum(interestRate) || 0;
            const bonusPct = toNum(bonusRate) || 0;
            const comp = (compInterval || "MONTHLY").toUpperCase().trim();

            // ---- deposits calculation ----
            let deposits = 0;
            if (freq === "DAILY") {
                if (unit === "DAYS") deposits = tVal;
                else if (unit === "WEEKS") deposits = (tVal * 7) / 30;
                else if (unit === "MONTHS") deposits = tVal * 30;
                else if (unit === "YEARS") deposits = tVal * 365;
            } else if (freq === "WEEKLY") {
                if (unit === "DAYS") deposits = tVal;
                else if (unit === "WEEKS") deposits = tVal;
                else if (unit === "MONTHS") deposits = tVal * 4;
                else if (unit === "YEARS") deposits = tVal * 52;

            } else if (freq === "BI_WEEKLY") {
                if (unit === "DAYS")
                    deposits = Math.floor(tVal / 2);
                else if (unit === "WEEKS")
                    deposits = Math.floor(tVal / 2);
                else if (unit === "MONTHS")
                    deposits = tVal * 2;
                else if (unit === "YEARS")
                    deposits = tVal * 26;
            } else if (freq === "MONTHLY") {
                if (unit === "DAYS") deposits = Math.floor(tVal / 30);
                else if (unit === "WEEKS") deposits = Math.floor(tVal / 4);
                else if (unit === "MONTHS") deposits = tVal;
                else if (unit === "YEARS") deposits = tVal * 12;
            } else if (freq === "QUARTERLY") {
                if (unit === "MONTHS") deposits = Math.floor(tVal / 3);
                else if (unit === "YEARS") deposits = tVal * 4;
            } else if (freq === "HALF-YEARLY") {
                if (unit === "MONTHS") deposits = Math.floor(tVal / 6);
                else if (unit === "YEARS") deposits = tVal * 2;
            } else if (freq === "YEARLY") {
                if (unit === "MONTHS") deposits = Math.floor(tVal / 12);
                else if (unit === "YEARS") deposits = tVal;
            }

            const totalDeposit = amt * deposits;

            // ---- compounding months ----
            let compMonths = 1;
            if (comp === "MONTHLY") compMonths = 1;
            else if (comp === "QUARTERLY") compMonths = 3;
            else if (comp === "HALF-YEARLY") compMonths = 6;
            else if (comp === "YEARLY") compMonths = 12;

            const r = rate / 100;

            // ---- Interest Calculation ----
            // total tenure in months
            let months = 0;
            if (unit === "DAYS") months = tVal / 30.437;
            else if (unit === "WEEKS") months = tVal / 4.345; 
            else if (unit === "MONTHS") months = tVal;
            else if (unit === "YEARS") months = tVal * 12;

            let maturity = 0;
            for (let i = 1; i <= deposits; i++) {
                let monthsLeft = months - (i - 1) * (months / deposits);
                let n = monthsLeft / compMonths;
                let effRate = Math.pow(1 + r / (12 / compMonths), n);
                maturity += amt * effRate;
            }

            const interestEarned = maturity - totalDeposit;
            const bonus = totalDeposit * (bonusPct / 100);
            const maturityFinal = totalDeposit  + interestEarned+ bonus;

            return {
                totalDeposit,
                interestEarned,
                bonus,
                maturity: maturityFinal
            };
        }

        // ----- DOM wrapper -----
        document.getElementById("calculateBtn").addEventListener("click", () => {
            const out = calcRD({
                amount: document.getElementById("amount").value,
                frequency: document.getElementById("frequency").value,
                tenureUnit: document.getElementById("tenure_type").value,
                tenureValue: document.getElementById("tenureNumber").value,
                interestRate: document.getElementById("interestRate").value,
                compInterval: document.getElementById("compInterval").value,
                bonusRate: document.getElementById("bonusInput").value
            });

            document.querySelector("#resultSection tr:nth-child(1) td:nth-child(2)").textContent = formatINR(out
                .totalDeposit);
            document.querySelector("#resultSection tr:nth-child(2) td:nth-child(2)").textContent = formatINR(out
                .interestEarned);
            document.querySelector("#resultSection tr:nth-child(3) td:nth-child(2)").textContent = formatINR(out
                .bonus);
            document.querySelector("#resultSection tr:nth-child(4) td:nth-child(2)").textContent = formatINR(out
                .maturity);

            document.getElementById("resultSection").classList.remove("hidden");
        });
    </script>
@endpush
