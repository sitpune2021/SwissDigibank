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

    <script>
        document.getElementById("calculateBtn").addEventListener("click", function(e) {
            e.preventDefault();

            let amount = parseFloat(document.getElementById("amount").value) || 0;
            let interestRate = parseFloat(document.getElementById("interestRate").value) || 0;
            let tenure = parseFloat(document.getElementById("tenureNumber").value) || 0;
            let bonusType = document.getElementById("bonusSelect").value;
            let bonusValue = parseFloat(document.getElementById("bonusInput").value) || 0;

            // Total Deposit
            let totalDeposit = amount * tenure;

            // ✅ Simple Interest Calculation (like NIDHI)
            let timeInYears = tenure / 365;
            let interestEarned = (totalDeposit * interestRate * timeInYears) / 100;

            // Bonus calculation
            let bonus = 0;
            if (bonusType === "(%)") {
                bonus = (totalDeposit * bonusValue) / 100;
            } else if (bonusType === "FIXED") {
                bonus = bonusValue;
            }

            // Final maturity amount
            let maturity = totalDeposit + interestEarned + bonus;

            // ✅ Show output
            document.querySelector("#resultSection").classList.remove("hidden");
            let rows = document.querySelectorAll("#resultSection tbody tr td:nth-child(2)");
            rows[0].innerText = totalDeposit.toFixed(2);
            rows[1].innerText = interestEarned.toFixed(2);
            rows[2].innerText = bonus.toFixed(2);
            rows[3].innerText = maturity.toFixed(2);
        });
    </script>
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
        function calculateRDMaturity(userDeposit, userTenureDays, userInterestRate, userBonusRate) {
            const dailyDeposit = userDeposit; // User input daily deposit
            const tenureDays = userTenureDays; // User input tenure in days
            const annualInterestRate = userInterestRate / 100; // Convert % to decimal
            const bonusRate = userBonusRate / 100; // Convert % to decimal
            const compoundingMonthsPerYear = 12;
            const monthlyRate = annualInterestRate / compoundingMonthsPerYear;

            let totalDeposit = 0;
            let totalInterest = 0;

            for (let day = 0; day < tenureDays; day++) {
                const daysRemaining = tenureDays - day;
                const monthsRemaining = daysRemaining / 30; // Approximate months remaining
                const interest = dailyDeposit * (Math.pow(1 + monthlyRate, monthsRemaining) - 1);

                totalInterest += interest;
                totalDeposit += dailyDeposit;
            }

            const bonus = totalDeposit * bonusRate;
            const maturity = totalDeposit + totalInterest + bonus;

            return {
                totalDeposit: totalDeposit.toFixed(2),
                interestEarned: totalInterest.toFixed(2),
                bonus: bonus.toFixed(2),
                maturityAmount: maturity.toFixed(2)
            };
        }

        // Example usage (replace with user inputs dynamically)
        const userInput = {
            deposit: 2000,
            tenureDays: 30,
            interestRate: 10, // in percent
            bonusRate: 10 // in percent
        };

        const result = calculateRDMaturity(userInput.deposit, userInput.tenureDays, userInput.interestRate, userInput
            .bonusRate);
        console.log(result);
    </script>
@endsection
