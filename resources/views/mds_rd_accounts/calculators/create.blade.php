@extends('layout.main')
@section('content')

<head>
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
</head>
<div class="main-inner">
    <h4 class="flex flex-wrap items-center text-lg justify-between gap-4 mb-6 lg:mb-8">RD / DD CALCULATOR</h4>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mt-5 min-h-screen">
        
        <!-- Calculator Section -->
        <div class="col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6">

            <div class="space-y-4">
                <!-- Scheme -->
                <div>
                    <label class="font-medium block mb-2 uppercase">
                        Scheme <span class="text-red-500">*</span>
                    </label>
                    <select id="scheme" name="scheme_code" required
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">Select Scheme</option>
                        @foreach($schemes as $scheme)
                        <option value="{{ $scheme->scheme_code }}">
                            {{ $scheme->scheme_code }} - {{ $scheme->scheme_name }}
                        </option>
                        @endforeach
                    </select>
                </div>


                <!-- Enter Values Manually -->
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="manualCheckbox" class="w-7 h-7 cursor-pointer">
                    <span class="text-sm text-gray-700">Enter Values Manually</span>
                </div>

                <!-- Open Date -->
                <div>
                    <label class="font-medium block mb-2 uppercase">Open Date<span class="text-red-500">*</span></label>
                    <input type="text" id="date2" placeholder="dd/mm/yyyy"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                </div>

                <!-- RD / DD Amount -->
                <div>
                    <label class="font-medium block mb-2 uppercase">RD / DD Amount <span class="text-red-500">*</span></label>
                    <input type="number" id="amount"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter amount">
                </div>

                <!-- Frequency -->
                <div>
                    <label class="font-medium block mb-2 uppercase">RD / DD Frequency <span class="text-red-500">*</span></label>
                    <select id="frequency"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
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
                    <label class="font-medium block mb-2 uppercase">Interest Comp. Interval <span
                            class="text-red-500">*</span></label>
                    <select id="compInterval"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option>Select Intervel Compounding</option>
                        <option>MONTHLY</option>
                        <option>QUARTERLY</option>
                        <option>HALF-YEARLY</option>
                        <option>YEARLY</option>
                    </select>
                </div>

                <!-- Interest Rate -->
                <div>
                    <label class="font-medium block mb-2 uppercase">Interest Rate <span class="text-red-500">*</span></label>
                    <input type="number" id="interestRate"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter Interest Rate">
                </div>

                <!-- Tenure -->
                <div>
                    <label class="font-medium block mb-2 uppercase">Tenure of RD / DD <span class="text-red-500">*</span></label>
                    <div class="flex gap-1">
                        <input type="text" id="tenure_type" name="tenure_type" value="DAYS"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border 
                                border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Tenure" readonly="readonly">
                        <input type="number" id="tenureNumber"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter tenure of RD/ DD">
                    </div>
                </div>

                <!-- Bonus -->
                <div>
                    <label class="font-medium block mb-2 uppercase">Bonus<span class="text-red-500">*</span></label>
                    <div class="flex gap-2">
                        <select id="bonusSelect" required
                            class="w-auto text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="%">(%)</option>
                            <option value="fixed">FIXED</option>
                        </select>
                        <input type="text" id="bonusInput" required
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Bonus">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-center col-span-2 gap-4 mt-5 md:gap-6">
                    <button id="calculateBtn" class="btn-primary uppercase" type="submit">Calculate</button>
                    <button class="btn-outline uppercase" type="button">Back</button>
                </div>
            </div>

            <!-- Hidden Result Section -->
            <div id="resultSection" class="hidden">
                <table class="w-full border-separate border-spacing-y-2 border-t mt-6">
                    <tbody>
                        <tr>
                            <td class="font-medium px-4 py-2 border-b uppercase">Total Deposit </td>
                            <td class="text-gray-700 px-4 py-2 border-b">234.00</td>
                        </tr>
                        <tr>
                            <td class="font-medium px-4 py-2 border-b uppercase">Interest Earned</td>
                            <td class="text-gray-700 px-4 py-2 border-b">85.00</td>
                        </tr>
                        <tr>
                            <td class="font-medium px-4 py-2 border-b uppercase">Bonus</td>
                            <td class="text-gray-700 px-4 py-2 border-b">0.00</td>
                        </tr>
                        <tr>
                            <td class="font-medium px-4 py-2 border-b uppercase">Maturity</td>
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
                    class="  bg-Secondary/5 text-black font-semibold px-4 py-2 rounded-10 flex text-lg justify-between items-center cursor-pointer uppercase">
                    Scheme Info
                    <button id="toggleButton" class="text-white text-xl font-bold focus:outline-none">-</button>
                </div>
                   <div class="">
                    <hr>
                   </div>
                <!-- Collapsible Table -->
                <div id="schemeContent"
                    class="bg-white dark:bg-bg rounded-10 shadow overflow-hidden transition-all duration-500 hidden">
                    <div class="p-6 bg-white dark:bg-bg3 rounded-lg shadow-md">
                        <table class="min-w-full border-separate border-spacing-y-2">
                            <tbody>
                                <tr>
                                    <td class="font-medium px-4 py-2 border-b uppercase">Scheme Code</td>
                                    <td id="sc_code" class="text-gray-700 px-4 py-2 border-b"></td>
                                </tr>
                                <tr>
                                    <td class="font-medium px-4 py-2 border-b uppercase">Scheme Name</td>
                                    <td id="sc_name" class="text-gray-700 px-4 py-2 border-b"></td>
                                </tr>
                                <tr>
                                    <td class="font-medium px-4 py-2 border-b uppercase">Deposit Frequency</td>
                                    <td id="deposit_frequency" class="text-gray-700 px-4 py-2 border-b"></td>
                                </tr>
                                <tr>
                                    <td class="font-medium px-4 py-2 border-b uppercase">Min. Amount</td>
                                    <td id="min_rd_dd_amount" class="text-gray-700 px-4 py-2 border-b"></td>
                                </tr>
                                <tr>
                                    <td class="font-medium px-4 py-2 border-b uppercase">Minimum Lock in Period</td>
                                    <td id="lock_in_period" class="text-gray-700 px-4 py-2 border-b"></td>
                                </tr>
                                <tr>
                                    <td class="font-medium px-4 py-2 border-b uppercase">Interest (%)</td>
                                    <td id="anuual_interest_rate" class="text-gray-700 px-4 py-2 border-b"></td>
                                </tr>
                                <tr>
                                    <td class="font-medium px-4 py-2 border-b uppercase">Interest Comp. Interval</td>
                                    <td id="interest_compounding_interval" class="text-gray-700 px-4 py-2 border-b"></td>
                                </tr>
                                <tr>
                                    <td class="font-medium px-4 py-2 border-b uppercase">Tenure of RD</td>
                                    <td id="tenure_of_rd" class="text-gray-700 px-4 py-2 border-b"></td>
                                </tr>
                                <tr>
                                    <td class="font-medium px-4 py-2 border-b uppercase">Cancellation Charges</td>
                                    <td id="cancellation_charges_value" class="text-gray-700 px-4 py-2 border-b"></td>
                                </tr>
                                <tr>
                                    <td class="font-medium px-4 py-2 border-b uppercase">Penal Charges (%)</td>
                                    <td id="penal_charges" class="text-gray-700 px-4 py-2 border-b"></td>
                                </tr>
                                <tr>
                                    <td class="font-medium px-4 py-2 border-b uppercase">Bonus Rate</td>
                                    <td id="bonus_rate" class="text-gray-700 px-4 py-2 border-b"></td>
                                </tr>
                                <tr>
                                    <td class="font-medium px-4 py-2 border-b uppercase">Penalty Charges (After Grace Period)</td>
                                    <td id="penalty_charges_value" class="text-gray-700 px-4 py-2 border-b"></td>
                                </tr>
                                <tr>
                                    <td class="font-medium px-4 py-2 border-b uppercase">Active</td>
                                    <td class="px-4 py-2 border-b">
                                        <span id="is_active" class="px-3 py-1  rounded-full"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

                        // ----- scheme info fetch -----
                        els.scheme.addEventListener('change', function() {
                            const schemeCode = this.value;
                            if (schemeCode) {
                                fetch(`/rd-schemes/${schemeCode}`)
                                    .then(res => res.json())
                                    .then(res => {
                                        if (res.status) {
                                            const s = res.data;

                                            els.schemeInfo.classList.remove('hidden');
                                            els.schemeContent.classList.remove('hidden');

                                            // Table values
                                            document.querySelector('#sc_code').textContent = s.scheme_code;
                                            document.querySelector('#sc_name').textContent = s.scheme_name;
                                            document.querySelector('#deposit_frequency').textContent = s.deposit_frequency;
                                            document.querySelector('#min_rd_dd_amount').textContent = s.min_rd_dd_amount;
                                            document.querySelector('#lock_in_period').textContent = s.lock_in_period;
                                            document.querySelector('#anuual_interest_rate').textContent = s.anuual_interest_rate + ' %';
                                            document.querySelector('#interest_compounding_interval').textContent = s.interest_compounding_interval;
                                            //  YAHAN PE ADD KARNA HAI
                                            if (s.rd_dd_frequency) {
                                                const freq = s.rd_dd_frequency.trim().toUpperCase();
                                                const freqDropdown = document.querySelector('#frequency');
                                                if (freqDropdown) {
                                                    for (let i = 0; i < freqDropdown.options.length; i++) {
                                                        if (freqDropdown.options[i].value.toUpperCase() === freq) {
                                                            freqDropdown.selectedIndex = i;
                                                            break;
                                                        }
                                                    }
                                                }
                                            }

                                            document.querySelector('#tenure_of_rd').textContent =
                                            s.tenure_of_rd_dd_value + " " + s.tenure_of_rd_dd_type;

                                            // Tenure Auto Fill (Correct Way)
                                            if (s.tenure_of_rd_dd_value && s.tenure_of_rd_dd_type) {

                                                els.tenureNumber.value = s.tenure_of_rd_dd_value;

                                                const type = s.tenure_of_rd_dd_type.trim().toUpperCase();

                                                if (type.startsWith("DAY")) {
                                                    els.tenureType.value = "DAYS";
                                                } else if (type.startsWith("MONTH")) {
                                                    els.tenureType.value = "MONTHS";
                                                } else if (type.startsWith("WEEK")) {
                                                    els.tenureType.value = "WEEKS";
                                                } else if (type.startsWith("YEAR")) {
                                                    els.tenureType.value = "YEARS";
                                                } else {
                                                    els.tenureType.value = type;
                                                }

                                            }

                                            document.querySelector('#cancellation_charges_value').textContent = s.cancellation_charges_value + ' %';
                                            document.querySelector('#penal_charges').textContent = s.penal_charges + ' %';
                                            document.querySelector('#bonus_rate').textContent = s.bonus_rate + ' %';
                                            document.querySelector('#penalty_charges_value').textContent = s.penalty_charges_value + ' %';

                                            // Active badge
                                            const activeEl = document.querySelector('#is_active');
                                            if (s.is_active) {
                                                activeEl.textContent = 'Yes';
                                                activeEl.classList.add('block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 ');
                                                activeEl.classList.remove('block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16');
                                            } else {
                                                activeEl.textContent = 'No';
                                                activeEl.classList.add('text-black');
                                                activeEl.classList.remove('text-black');
                                            }

                                            //  Input fields auto-fill
                                            els.interestRate.value = s.anuual_interest_rate || '';

                                            // Dropdown me value set karte waqt case mismatch avoid karo
                                            els.compInterval.value = (s.interest_compounding_interval || 'MONTHLY').trim().toUpperCase();
                                            // -------- FIX: auto-enable inputs when scheme is selected --------
                                            [
                                                els.frequency, els.compInterval, els.interestRate,
                                                els.tenureText, els.tenureNumber,
                                                els.bonusSelect, els.bonusInput
                                            ].forEach(el => el.disabled = false);

                                        }
                                    });
                            } else {
                                els.schemeInfo.classList.add('hidden');
                                els.schemeContent.classList.add('hidden');
                                document.querySelector('#schemeContent').classList.add('hidden');
                                document.querySelector('#frequency').selectedIndex = 0; // reset dropdown
                                // reset input fields bhi
                                els.interestRate.value = '';
                                els.compInterval.value = 'MONTHLY'; // default

                                els.tenureNumber.value = '';
                                els.tenureType.value = 'DAYS'; // default


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
                            const freq = (frequency || "MONTHLY").toUpperCase().trim();
                            const unit = (tenureUnit || "MONTHS").toUpperCase().trim();
                            const tVal = parseInt(tenureValue) || 0;
                            const rate = (parseFloat(interestRate) || 0) / 100;
                            const bonusPct = parseFloat(bonusRate) || 0;
                            const comp = (compInterval || "MONTHLY").toUpperCase().trim();

                            // ---- convert tenure to months ----
                            let months = 0;
                            if (unit === "DAYS") months = tVal / 30; // approx
                            else if (unit === "WEEKS") months = tVal / 4; // approx
                            else if (unit === "MONTHS") months = tVal;
                            else if (unit === "YEARS") months = tVal * 12;

                            // ---- number of deposits ----
                            let deposits = 0;
                            if (freq === "DAILY") deposits = months * 30;
                            else if (freq === "WEEKLY") deposits = months * 4;
                            else if (freq === "BI_WEEKLY") deposits = months * 2;
                            else if (freq === "MONTHLY") deposits = months;
                            else if (freq === "QUARTERLY") deposits = months / 3;
                            else if (freq === "HALF-YEARLY") deposits = months / 6;
                            else if (freq === "YEARLY") deposits = months / 12;

                            deposits = Math.floor(deposits);

                            const totalDeposit = amt * deposits;

                            // ---- compounding months ----
                            const compMonths = {
                                MONTHLY: 1,
                                QUARTERLY: 3,
                                "HALF-YEARLY": 6,
                                YEARLY: 12
                            } [comp] || 1;

                            // ---- maturity & interest ----
                            let maturity = 0;
                            for (let i = 1; i <= deposits; i++) {
                                const monthsLeft = months - (i - 1) * (months / deposits);
                                const n = monthsLeft / compMonths;
                                const effRate = Math.pow(1 + rate / (12 / compMonths), n);
                                maturity += amt * effRate;
                            }

                            const interestEarned = maturity - totalDeposit;
                            const bonus = totalDeposit * (bonusPct / 100);
                            const maturityFinal = maturity + bonus;

                            return {
                                totalDeposit: totalDeposit.toFixed(2),
                                interestEarned: interestEarned.toFixed(2),
                                bonus: bonus.toFixed(2),
                                maturity: maturityFinal.toFixed(2)
                            };
                        }
                        // ----- calculate button click -----
                        els.calculateBtn.addEventListener('click', function(e) {
                            e.preventDefault();

                            const values = {
                                amount: els.amount.value,
                                frequency: els.frequency.value,
                                tenureUnit: els.tenureType.value,
                                tenureValue: els.tenureNumber.value,
                                interestRate: els.interestRate.value,
                                compInterval: els.compInterval.value,
                                bonusRate: els.bonusInput.value || 0,
                            };

                            const result = calcRD(values);

                            // Result section show karo
                            els.resultSection.classList.remove('hidden');

                            // Update result table
                            const rows = els.resultSection.querySelectorAll('tbody tr td:last-child');
                            rows[0].textContent = result.totalDeposit;
                            rows[1].textContent = result.interestEarned;
                            rows[2].textContent = result.bonus;
                            rows[3].textContent = result.maturity;
                        });


                    });
                </script>
                @endpush