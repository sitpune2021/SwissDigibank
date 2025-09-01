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
            // ----- set today's date -----
            const dateInput = document.getElementById("date2");
            const today = new Date();
            dateInput.value = today.toLocaleDateString("en-GB"); // dd/mm/yyyy

            // ----- element refs -----
            const els = {
                manualCheckbox: document.getElementById('manualCheckbox'),
                scheme: document.getElementById('scheme'),
                frequency: document.getElementById('frequency'),
                compInterval: document.getElementById('compInterval'),
                interestRate: document.getElementById('interestRate'),
                tenureText: document.getElementById('tenureText'),
                tenureNumber: document.getElementById('tenureNumber'),
                bonusSelect: document.getElementById('bonusSelect'),
                bonusInput: document.getElementById('bonusInput'),
                schemeInfo: document.getElementById('schemeInfo'),
                schemeContent: document.getElementById('schemeContent'),
                toggleButton: document.getElementById('toggleButton'),
                calculateBtn: document.getElementById('calculateBtn'),
                resultSection: document.getElementById('resultSection'),
                amount: document.getElementById('amount'),
                tenureType: document.getElementById('tenure_type'),
            };

            // ----- scheme info -----
            let isOpen = true;

            function toggleSchemeInfo() {
                const {
                    schemeContent,
                    toggleButton
                } = els;
                schemeContent.style.maxHeight = isOpen ? '0' : '1000px';
                schemeContent.style.opacity = isOpen ? '0' : '1';
                toggleButton.textContent = isOpen ? '+' : '-';
                isOpen = !isOpen;
            }
            els.toggleButton.addEventListener('click', toggleSchemeInfo);

            els.scheme.addEventListener('change', function() {
                const {
                    schemeInfo,
                    schemeContent,
                    toggleButton
                } = els;
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

            // ----- manual toggle -----
            els.manualCheckbox.addEventListener('change', () => {
                const disabled = !els.manualCheckbox.checked;
                [
                    els.scheme, els.frequency, els.compInterval,
                    els.interestRate, els.tenureText, els.tenureNumber,
                    els.bonusSelect, els.bonusInput
                ].forEach(el => el.disabled = disabled && el !== els.scheme);
            });
            els.manualCheckbox.dispatchEvent(new Event('change'));

            // ----- auto change tenure_type based on frequency -----
            els.frequency.addEventListener('change', function() {
                let freq = this.value.toUpperCase();
                if (freq === "DAILY") {
                    els.tenureType.value = "DAYS";
                } else if (freq === "WEEKLY") {
                    els.tenureType.value = "WEEKS";
                } else if (freq === "BI_WEEKLY") {
                    els.tenureType.value = "WEEKS"; // still in weeks
                } else if (freq === "MONTHLY") {
                    els.tenureType.value = "MONTHS";
                } else if (freq === "QUARTERLY") {
                    els.tenureType.value = "MONTHS"; // quarters → months
                } else if (freq === "HALF-YEARLY") {
                    els.tenureType.value = "MONTHS"; // half-year → months
                } else if (freq === "YEARLY") {
                    els.tenureType.value = "MONTHS";
                }
            });


            // ----- helpers -----
            const toNum = v =>
                typeof v === "number" ? v :
                typeof v === "string" ? (parseFloat(v.replace(/,/g, "").replace(/[^\d.]/g, "")) || 0) : 0;

            const formatINR = n => n.toLocaleString("en-IN", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            // ----- RD calculation -----
            function calcRD({
                amount,
                frequency,
                tenureUnit,
                tenureValue,
                interestRate,
                compInterval,
                bonusRate
            }) {
                const amt = parseFloat(amount) || 0;
                const freq = (frequency || "DAILY").toUpperCase().trim();
                const unit = (tenureUnit || "MONTHS").toUpperCase().trim();
                const tVal = parseInt(tenureValue) || 0;
                const rate = (parseFloat(interestRate) || 0) / 100;
                const bonusPct = parseFloat(bonusRate) || 0;
                const comp = (compInterval || "MONTHLY").toUpperCase().trim();

                // ---- deposits calculation ----
                let deposits = 0;
                if (freq === "DAILY" && unit === "DAYS") deposits = tVal;

                const totalDeposit = amt * deposits;

                // ---- compounding months ----
                const compMonths = {
                    MONTHLY: 1,
                    QUARTERLY: 3,
                    "HALF-YEARLY": 6,
                    YEARLY: 12
                } [comp] || 1;

                let maturity = 0;
                let interestEarned = 0;
                if (unit === "DAYS") {
                    // ---- Daily RD/DD logic ----
                    for (let i = 0; i < deposits; i++) {
                        let daysLeft = tVal - i; // e.g. 29, 28 ... 1
                        // rate is already decimal (0.10 for 10%)
                        let effInterest = amt * rate * (daysLeft / 365);

                        maturity += amt + effInterest;
                        interestEarned += effInterest;
                    }
                } else {
                    // ---- Existing monthly compounding logic ----
                    for (let i = 1; i <= deposits; i++) {
                        const monthsLeft = months - (i - 1) * (months / deposits);
                        const n = monthsLeft / compMonths;
                        const effRate = Math.pow(1 + rate / (12 / compMonths), n);
                        maturity += amt * effRate;
                    }

                    interestEarned = maturity - totalDeposit;
                }

                const bonus = totalDeposit * (bonusPct / 100);
                const maturityFinal = maturity + bonus;

                return {
                    totalDeposit: totalDeposit.toFixed(2),
                    interestEarned: interestEarned.toFixed(2), // <-- gives 129.00
                    bonus: bonus.toFixed(2),
                    maturity: maturityFinal.toFixed(2)
                };
            }

            // ----- calculate button -----
            els.calculateBtn.addEventListener("click", () => {
                const out = calcRD({
                    amount: els.amount.value,
                    frequency: els.frequency.value,
                    tenureUnit: els.tenureType.value,
                    tenureValue: els.tenureNumber.value,
                    interestRate: els.interestRate.value,
                    compInterval: els.compInterval.value,
                    bonusRate: els.bonusInput.value
                });

                const rows = els.resultSection.querySelectorAll("tr td:nth-child(2)");
                [out.totalDeposit, out.interestEarned, out.bonus, out.maturity]
                .forEach((val, i) => rows[i].textContent = formatINR(val));

                els.resultSection.classList.remove("hidden");
            });
        });
    </script>
@endpush
