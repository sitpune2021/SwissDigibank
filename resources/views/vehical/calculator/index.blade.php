@extends('layout.main')

@section('content')


<style>
  input[type="checkbox"] {
    width: 28px;
    height: 28px;
    accent-color: green;
    /* For modern browsers */
  }

  /* Fallback for browsers without accent-color support */
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

  <div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
      <div class="flex items-start flex-col  gap-2">
        <div class="flex items-center gap-3">
          <h1 class="text-xl font-semibold capitalize">
            VEHICAL LOAN CALCULATOR
          </h1>
        </div>
      </div>
    </div>


    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 p-6 min-h-screen">
      <div class="col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6">
        <form id="loanForm" action="{{ route('vehical.calculator.calculate') }}" method="POST" target="_blank" class="space-y-6">
          @csrf

          <!-- Scheme -->
          <div class="mb-4">
            <label for="" class="block font-medium mb-2">Scheme <span class="text-red-500">*</span></label>
            <select id="scheme_id" name="scheme_id"
              class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
              <option value="">Select Scheme</option>
              @foreach($scheme as $item)
                <option 
                  value="{{ $item->id }}"
                  data-code="{{ $item->scheme_code }}"
                  data-name="{{ $item->scheme_name }}"
                  data-tenure="{{ $item->tenure }}"
                  data-max="{{ $item->max_loan_amount }}"
                  data-limit="{{ $item->max_loan_limit }}"
                  data-min="{{ $item->min_loan_amount }}"
                  data-interest="{{ $item->annual_interest_rate }}"
                  data-type="{{ $item->gold_loan_setting }}"
                  data-active="{{ $item->is_active ? 'Yes' : 'No' }}"
                  data-charge="{{ $item->foreclosure_charges }}"
                  {{-- unique attributes for each --}}
                  data-processing="{{ $item->processing_fee }}"
                  data-stamp="{{ $item->stamp_duty_charge }}"
                  data-insurance="{{ $item->insurance_fee }}"
                >
                  {{ $item->scheme_name }}
                </option>
              @endforeach
            </select>
          </div>

        
          <!-- Auto-fill Annual Interest -->
          <input type="hidden" id="annual_interest_rate" name="annual_interest_rate">


          <!-- CHECKBOX: MANUAL ENTRY -->
          <div class="mt-4">
            <label class="flex items-center space-x-2">
              <input type="checkbox" id="manualEntry"
                class="rounded-10 border-gray-300 text-primary focus:ring-blue-500">
              <span class="p-2">Enter Values Manually</span>
            </label>
          </div>

          <!-- MANUAL ENTRY FIELDS -->
          <div id="manualFields" class="hidden bg-secondary/5 rounded-10 p-3 mt-3 dark:bg-bg3">
            <div class="grid grid-cols-2 gap-4">

            
              <!-- Max Tenure Dropdown -->
                <div class="col-span-2">
                    <label class="md:text-lg font-medium block mb-2">Max. Tenure *</label>
                    <select name="max_tenure" id="max_tenure" 
                        class="w-full bg-white border rounded px-3 py-2">
                        <option value="">Select Tenure</option>
                        @for ($i = 1; $i <= 15; $i++)
                            <option value="{{ $i * 12 }}">{{ $i }} Year</option>
                            <option value="{{ ($i * 12) + 6 }}">{{ $i }}.5 Year</option>
                        @endfor
                    </select>
                </div>

                <!-- Maximum Loan Limit -->
                <div class="col-span-2">
                  <label class="md:text-lg font-medium block mb-2">Maximum Loan Limit (%)</label>
                  <select name="manual_max_loan_limit" id="manual_max_loan_limit"
                    class="w-full bg-white border rounded px-3 py-2">
                    <option value="">Please Select</option>
                    <option value="50">50%</option>
                    <option value="60">60%</option>
                    <option value="70">70%</option>
                    <option value="80">80%</option>
                    <option value="90">90%</option>
                    <option value="95">95%</option>
                  </select>
                </div>

                <!-- Interest Type -->
                <div class="col-span-2">
                    <label class="md:text-lg font-medium block mb-2">Interest Type *</label>
                    <div class="flex gap-4">
                      <label>
                          <input type="radio" name="interest_type" value="flat_emi"> Flat EMI
                      </label>

                      <label>
                          <input type="radio" name="interest_type" value="reducing"> Reducing EMI
                      </label>

                      <label>
                          <input type="radio" name="interest_type" value="flat_advanced"> Flat Advanced
                      </label>
                    </div>  
                </div>

                <!-- Annual Interest Rate -->
                <div class="col-span-2">
                  <label class="md:text-lg font-medium block mb-2">Annual Interest Rate (%) *</label>
                  <input type="number" name="manual_interest_rate" id="manual_interest_rate"
                    class="w-full bg-white border rounded px-3 py-2"
                    placeholder="Interest Rate">
                </div>

                <!-- Processing Fee -->
                <div class="col-span-2">
                  <label class="md:text-lg font-medium block mb-2">Processing Fee</label>
                  <div class="flex">
                    <select name="manual_processing_fee_type" class="border rounded-l px-2">
                      <option value="percent">%</option>
                      <option value="fixed">Fixed</option>
                    </select>
                    <input type="number" name="manual_processing_fee"
                      class="w-full bg-white border rounded-r px-3 py-2"
                      placeholder="0.00">
                  </div>
                </div>

                <!-- Stamp Duty -->
                <div class="col-span-2">
                  <label class="md:text-lg font-medium block mb-2">Stamp Duty</label>
                  <input type="number" name="manual_stamp"
                    class="w-full bg-white border rounded px-3 py-2"
                    placeholder="In % of Loan">
                </div>

                <!-- Insurance -->
                <div class="col-span-2">
                  <label class="md:text-lg font-medium block mb-2">Insurance Charge</label>
                  <input type="number" name="manual_insurance"
                    class="w-full bg-white border rounded px-3 py-2"
                    placeholder="In % of Loan">
                </div>

                <!-- Fore Closure -->
                <div class="col-span-2">
                  <label class="md:text-lg font-medium block mb-2">Fore Closure Charges</label>
                  <input type="number" name="manual_preclosure"
                    class="w-full bg-white border rounded px-3 py-2"
                    placeholder="In %">
                </div>

                <!-- Per EMI Charges Section -->
                <div class="col-span-2 bg-blue-50 p-3 rounded">

                    <h3 class="font-semibold text-blue-700 mb-3">Per EMI Charges (Optional)</h3>

                    <div class="grid grid-cols-2 gap-3">

                        <!-- SMS Charges -->
                        <div>
                            <label class="block text-sm font-medium mb-1">SMS Charges (%)</label>
                            <input type="number" name="sms_charge" min="0" 
                                class="w-full border rounded px-3 py-2"
                                placeholder="Enter SMS Fee %">
                        </div>

                        <!-- Fuel Charges -->
                        <div>
                            <label class="block text-sm font-medium mb-1">Fuel Charges (%)</label>
                            <input type="number" name="fuel_charge" min="0" 
                                class="w-full border rounded px-3 py-2"
                                placeholder="Enter Fuel Charges %">
                        </div>

                        <!-- Stationary Charges -->
                        <div>
                            <label class="block text-sm font-medium mb-1">Stationary (%)</label>
                            <input type="number" name="stationary_charge" min="0" 
                                class="w-full border rounded px-3 py-2"
                                placeholder="Enter Stationary Charges %">
                        </div>

                        <!-- Maintenance Charges -->
                        <div>
                            <label class="block text-sm font-medium mb-1">Maintenance (%)</label>
                            <input type="number" name="maintenance_charge" min="0" 
                                class="w-full border rounded px-3 py-2"
                                placeholder="Enter Maintenance Charges %">
                        </div>

                        <!-- Collection Charges -->
                        <div>
                            <label class="block text-sm font-medium mb-1">Collection (%)</label>
                            <input type="number" name="collection_charge" min="0"
                                class="w-full border rounded px-3 py-2"
                                placeholder="Enter Collection Charges %">
                        </div>

                    </div>
                </div>

          </div>
          </div>

          <!-- Tenure Type -->
          <div class="w-full mt-4">
            <label class="block font-medium mb-2">Tenure Type <span class="text-red-500">*</span></label>
            <div class="flex flex-wrap gap-4">
              <label class="flex items-center gap-2">
                <input type="radio" name="tenure_type" value="DAYS" class="text-blue-600"> <span>DAYS</span>
              </label>
              <label class="flex items-center gap-2">
                <input type="radio" name="tenure_type" value="WEEKS" class="text-blue-600"> <span>WEEKS</span>
              </label>
              <label class="flex items-center gap-2">
                <input type="radio" name="tenure_type" value="MONTHS" class="text-blue-600" checked> <span>MONTHS</span>
              </label>
            </div>
          </div>

          <!-- Tenure (MONTHS) -->
          <div class="w-full mt-4 ">
          <div class="mb-2">
            <label id="tenureLabel" class="font-medium text-gray-700 uppercase">
              Tenure ( MONTHS )        
            </label>
            <span class="text-error">*</span>
          </div>
          <div class="flex flex-wrap gap-4">
            <input type="number" name="tenure_months" id="tenure_months" class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5            dark:bg-bg3 " placeholder="Please Enter Tenure">
          </div>
          </div>


          <!-- EMI Payout -->
          <div class="mt-4">
            <label class="block font-medium mb-2">EMI Payout <span class="text-red-500">*</span></label>
            <select name="payout" id="payout" required class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
              <option value="">Select EMI Payout</option>
              <option value="monthly">Monthly</option>
              <option value="half-yearly">Half-Yearly</option>
              <option value="quarterly">Quarterly</option>
              <option value="yearly">Yearly</option>
            </select>
          </div>

          <!-- Requested Loan Amount -->
          <div class="w-full mt-4">
            <label class="block font-medium mb-2">Requested Loan Amount (₹) <span class="text-red-500">*</span></label>
            <input type="number" name="loan_amount" id="request_loan_amount" class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3" placeholder="Enter loan amount">
            <x-number-to-word for="request_loan_amount" />
          </div>


          <input type="hidden" name="ratio_enabled" id="ratio_enabled" value="No">
          <input type="hidden" name="ratio_first_emi" id="ratio_first_emi" value="">
          <input type="hidden" name="ratio_first_percentage" id="ratio_first_percentage" value="">


          <div id="interestOptions" style="display:none; margin-top:10px;">

              <!-- Checkbox 1 -->
              <label class="flex gap-2" id="chk_emi_box">
                  <input type="checkbox" name="option_interest_emi" id="option_interest_emi" value="1">
                  <span id="chk_emi_text">Collect Interest as EMI & Principal after tenure</span>
              </label>

              <!-- Checkbox 2 -->
              <label class="flex gap-2 mt-2" id="chk_first_box">
                  <input type="checkbox" name="option_interest_first" id="option_interest_first" value="1">
                  Collect Interest as EMIs First & then after Principal as EMIs
              </label>

          </div>

          <!-- REDUCING EMI SPECIAL CHECKBOX -->
          <label class="flex gap-2 mt-3" id="reduce_ratio_box" style="display:none;">
              <input type="checkbox" id="divide_emi_ratio" value="1">
              Check this if you want to divide loan EMIs in ratio.
          </label>

          <!-- RATIO FIELDS -->
          <div id="ratioFields" style="display:none; margin-top:10px;">

              <!-- EMI Ratio -->
              <label class="block mb-2 font-semibold">EMI Ratio <span id="emi_total_text"></span> </label>

              <div class="flex gap-3">
                  <input type="number" id="emi_ratio_1" class="w-1/3 border p-2" min="1">
                  <input type="number" id="emi_ratio_2" class="w-1/3 border p-2 bg-gray-100" readonly>
              </div>

              <!-- Loan Amount Ratio -->
              <label class="block mt-4 mb-2 font-semibold">Loan Amount % Ratio</label>

              <div class="flex gap-3">
                  <input type="number" id="amt_ratio_1" class="w-1/3 border p-2" min="1" max="100">
                  <input type="number" id="amt_ratio_2" class="w-1/3 border p-2 bg-gray-100" readonly>
              </div>

          </div>

         
           <!-- Buttons -->
          <div class="flex justify-center gap-4 pt-6">
            <button type="submit" class="btn-primary">CALCULATE</button>
            <a href="" class="btn-outline">Back</a>
          </div>
        </form>
      </div>
      
      <!--Scheme Info Table-->
      <div id="schemeBox" class="mt-5 hidden">
        <div class="flex justify-between items-center bg-secondary/5 rounded-10 px-4 py-3 dark:bg-bg3">
          <h3 class="text-base font-semibold md:text-lg">Scheme Info</h3>
          <button type="button" class="p-1 rounded transition" onclick="toggleSection(this, 'schemeInfoBody')">
            <span class="toggle-icon text-lg font-bold">−</span>
          </button>
        </div>

        <div id="schemeInfoBody" class="px-4 py-3">
          <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
              <tbody>
                <tr><td class="font-semibold py-2 pr-4">Scheme Code</td><td class="py-2" id="schemeCode">-</td></tr>
                <tr><td class="font-semibold py-2 pr-4">Scheme Name</td><td class="py-2" id="schemeName">-</td></tr>
                <tr><td class="font-semibold py-2 pr-4">Max Tenure</td><td class="py-2" id="schemeTenure">-</td></tr>
                <tr><td class="font-semibold py-2 pr-4">Maximum Loan Amount</td><td class="py-2" id="schemeMax">-</td></tr>
                <tr><td class="font-semibold py-2 pr-4">Maximum Loan Limit Against Security</td><td class="py-2" id="schemeLimit">-</td></tr>
                <tr><td class="font-semibold py-2 pr-4">Minimum Loan Amount</td><td class="py-2" id="schemeMin">-</td></tr>
                <tr><td class="font-semibold py-2 pr-4">Annual Interest Rate</td><td class="py-2" id="schemeInterest">-</td></tr>
                <tr><td class="font-semibold py-2 pr-4">Interest Type</td><td class="py-2" id="schemeType">-</td></tr>
                <tr><td class="font-semibold py-2 pr-4">Active</td><td class="py-2" id="schemeActive">-</td></tr>
                <tr><td class="font-semibold py-2 pr-4">Fore Closure Charges</td><td class="py-2" id="schemeCharge">-</td></tr>
                <tr class="border-b border-gray-200">
                  <td class="font-semibold px-3 py-2">Stamp Duty Fee</td>
                  <td class="px-3 py-2"><span id="schemeStamp">-</span> %</td>
                </tr>
                <tr class="border-b border-gray-200">
                  <td class="font-semibold px-3 py-2">Insurance Charges</td>
                  <td class="px-3 py-2"><span id="schemeInsurance">-</span> %</td>
                </tr>
                <tr class="border-b border-gray-200">
                  <td class="font-semibold px-3 py-2">Processing Fee</td>
                  <td class="px-3 py-2"><span id="schemeProcessing">-</span> ₹</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>


<!-- checkbox show when scheme select -->
<script>
  document.addEventListener("DOMContentLoaded", function () {

    const schemeSelect = document.getElementById("scheme_id");

    const interestOptions = document.getElementById("interestOptions");
    const chkEmiBox = document.getElementById("chk_emi_box");
    const chkFirstBox = document.getElementById("chk_first_box");
    const chkEmiText = document.getElementById("chk_emi_text");

    const reduceBox = document.getElementById("reduce_ratio_box");
    const ratioFields = document.getElementById("ratioFields");

    const emi1 = document.getElementById("emi_ratio_1");
    const emi2 = document.getElementById("emi_ratio_2");

    const amt1 = document.getElementById("amt_ratio_1");
    const amt2 = document.getElementById("amt_ratio_2");

    const chkDivide = document.getElementById("divide_emi_ratio");
    const emiTotalText = document.getElementById("emi_total_text");
    const tenureInput = document.getElementById("tenure_months");  // <-- ADD THIS LINE


    let totalEmi = 0;

    // ------------------------------------------------
    // 1) MANUAL RADIO INTEREST TYPE LOGIC
    // ------------------------------------------------
    function manualInterestTypeCheck() {
        let selected = document.querySelector('input[name="interest_type"]:checked');
        if (!selected) return;

        // no_emi → hide everything
        if (selected.value === "no_emi") {
            interestOptions.style.display = "none";
        }
    }

    document.querySelectorAll('input[name="interest_type"]').forEach(radio => {
        radio.addEventListener("change", manualInterestTypeCheck);
    });

    manualInterestTypeCheck();

    // ------------------------------------------------
      // MANUAL ENTRY → Interest Type Radio Logic (FINAL FIXED)
    // ------------------------------------------------
    document.querySelectorAll('input[name="interest_type"]').forEach(radio => {
        radio.addEventListener("change", function () {

            let v = this.value.toLowerCase();

            // RESET first
            reduceBox.style.display = "none";

            // 1️⃣ Flat EMI → show both checkbox
            if (v === "flat_emi") {
                interestOptions.style.display = "block";
                chkEmiBox.style.display = "flex";
                chkFirstBox.style.display = "flex";
                chkEmiText.innerText = "Collect Interest as EMI & Principal after tenure";
            }

            // 2️⃣ Flat Advanced Interest → only ONE checkbox
            else if (v === "flat_advanced" || v === "flat_advanced_interest") {
                interestOptions.style.display = "block";
                chkEmiBox.style.display = "flex";
                chkFirstBox.style.display = "none";

                chkEmiText.innerText = "Collect Principal Amount as EMI";
            }

            // 3️⃣ Reducing EMI
            else if (v === "reducing" || v === "reducing_emi") {
                interestOptions.style.display = "none";
                chkEmiBox.style.display = "none";
                chkFirstBox.style.display = "none";
                reduceBox.style.display = "flex";
            }

            // 4️⃣ No EMI → hide all
            else {
                interestOptions.style.display = "none";
                chkEmiBox.style.display = "none";
                chkFirstBox.style.display = "none";
            }
        });
    });

    // ------------------------------------------------
      // 2) SCHEME SELECT → checkbox logic
    // ------------------------------------------------
    schemeSelect.addEventListener("change", function () {

        let selected = this.options[this.selectedIndex];
        let type = (selected.dataset.type || "").toLowerCase();

        // Total EMI
        totalEmi = parseInt(selected.dataset.tenure || 0);
        emiTotalText.innerText = `(Total EMI : ${totalEmi})`;

        // CASE: flat_emd / reducing_emi / flat_advanced_interest
        if (type === "flat_emi" || type === "flat_advanced_interest") {
            interestOptions.style.display = "block";

            if (type === "flat_advanced_interest") {
                chkEmiText.innerText = "Collect Principal Amount as EMI";
                chkEmiBox.style.display = "flex";
                chkFirstBox.style.display = "none";
            } else {
                chkEmiText.innerText = "Collect Interest as EMI & Principal after tenure";
                chkEmiBox.style.display = "flex";
                chkFirstBox.style.display = "flex";
            }
        }

        // CASE: no EMI
        else {
            interestOptions.style.display = "none";
            document.getElementById("option_interest_emi").checked = false;
            document.getElementById("option_interest_first").checked = false;
        }

        // ------------------------------------------------
        // 3) Reducing EMI → Ratio options
        // ------------------------------------------------
        if (type === "reducing_emi") {
            reduceBox.style.display = "flex";
        } else {
            reduceBox.style.display = "none";
            ratioFields.style.display = "none";
            chkDivide.checked = false;
        }
    });

    // ------------------------------------------------
      // MANUAL TENURE → UPDATE TOTAL EMI FOR RATIO CALC
    // ------------------------------------------------
    tenureInput.addEventListener("input", function () {

        if (!this.value || this.value <= 0) {
            totalEmi = 0;
            emiTotalText.innerText = "";
            return;
        }

        // Set new total EMI according to manual tenure input
        totalEmi = parseInt(this.value);
        emiTotalText.innerText = `(Total EMI : ${totalEmi})`;

        // Auto-update EMI Ratio 2
        let v = parseInt(emi1.value || 0);

        if (v > totalEmi) {
            emi1.value = totalEmi;
            v = totalEmi;
        }

        emi2.value = totalEmi - v;
    });


    // ------------------------------------------------
    // RATIO CHECKBOX → OPEN FIELDS
    // ------------------------------------------------
    chkDivide.addEventListener("change", function () {
        ratioFields.style.display = this.checked ? "block" : "none";
    });


    // ------------------------------------------------
    // EMI Ratio Auto
    // ------------------------------------------------
    emi1.addEventListener("input", function () {
        let v = parseInt(this.value || 0);

        if (v > totalEmi) {
            this.value = totalEmi;
            v = totalEmi;
        }
        emi2.value = totalEmi - v;
    });


    // ------------------------------------------------
    // Amount Ratio Auto
    // ------------------------------------------------
    amt1.addEventListener("input", function () {
        let v = parseInt(this.value || 0);

        if (v > 100) {
            this.value = 100;
            v = 100;
        }
        amt2.value = 100 - v;
    });

});
</script>

<!-- reducig emi check box result show o result page -->
<script>
  document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("loanForm");   // ← YAHA PAKKA Sahi ID

    const chkDivide = document.getElementById("divide_emi_ratio");
    const emi1 = document.getElementById("emi_ratio_1");
    const amt1 = document.getElementById("amt_ratio_1");

    form.addEventListener("submit", function () {

        // Ratio Enabled
        document.getElementById("ratio_enabled").value =
            chkDivide.checked ? "Yes" : "No";

        // First EMI
        document.getElementById("ratio_first_emi").value =
            emi1.value || "";

        // Percentage
        document.getElementById("ratio_first_percentage").value =
            amt1.value || "";
    });

});
</script>

<script>
  // this script for get scheme details 
document.getElementById('scheme_id').addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    document.getElementById('annual_interest_rate').value = selected.dataset.interest || 0;
});
</script>

<script>
  // this script use for manually entry
document.getElementById('manualEntry').addEventListener('change', function () {
  const isManual = this.checked;
  document.getElementById('manualFields').classList.toggle('hidden', !isManual);
  document.getElementById('schemeSection').classList.toggle('hidden', isManual);
  document.getElementById('scheme_id').value = isManual ? '' : document.getElementById('scheme_id').value;
});
</script>

<script>
  // this script use for get scheme details info
  document.addEventListener("DOMContentLoaded", function () {
    const schemeSelect = document.getElementById("scheme_id");
    const schemeBox = document.getElementById("schemeBox");

    const schemeCode = document.getElementById("schemeCode");
    const schemeName = document.getElementById("schemeName");
    const schemeTenure = document.getElementById("schemeTenure");
    const schemeMax = document.getElementById("schemeMax");
    const schemeLimit = document.getElementById("schemeLimit");
    const schemeMin = document.getElementById("schemeMin");
    const schemeInterest = document.getElementById("schemeInterest");
    const schemeType = document.getElementById("schemeType");
    const schemeActive = document.getElementById("schemeActive");
    const schemeCharge = document.getElementById("schemeCharge");

    const schemeStamp = document.getElementById("schemeStamp");
    const schemeInsurance = document.getElementById("schemeInsurance");
    const schemeProcessing = document.getElementById("schemeProcessing");

    schemeSelect.addEventListener("change", function () {
      const selectedOption = this.options[this.selectedIndex];

      if (this.value) {
        schemeCode.textContent = selectedOption.dataset.code || "-";
        schemeName.textContent = selectedOption.dataset.name || "-";
        schemeTenure.textContent = selectedOption.dataset.tenure || "-";
        schemeMax.textContent = selectedOption.dataset.max || "-";
        schemeLimit.textContent = selectedOption.dataset.limit || "-";
        schemeMin.textContent = selectedOption.dataset.min || "-";
        schemeInterest.textContent = selectedOption.dataset.interest || "-";
        schemeType.textContent = selectedOption.dataset.type || "-";
        schemeActive.textContent = selectedOption.dataset.active || "-";
        schemeCharge.textContent = selectedOption.dataset.charge || "-";

        // New Fields
        schemeStamp.textContent = selectedOption.dataset.stamp || "-";
        schemeInsurance.textContent = selectedOption.dataset.insurance || "-";
        schemeProcessing.textContent = selectedOption.dataset.processing || "-";

        schemeBox.classList.remove("hidden");
      } else {
        schemeBox.classList.add("hidden");
      }
    });
  });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const manualEntryCheckbox = document.getElementById('manualEntry');
    const schemeDropdown = document.getElementById('scheme_id');

    manualEntryCheckbox.addEventListener('change', function () {
        if (this.checked) {
            schemeDropdown.disabled = true;
            schemeDropdown.classList.add('opacity-50', 'cursor-not-allowed');
            schemeDropdown.value = ''; // optional: clear selected value
        } else {
            schemeDropdown.disabled = false;
            schemeDropdown.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    });
});
</script>

<script>
  // <!-- collapsed logic + - button-->
        function toggleSection(button, sectionId) {
            const section = document.getElementById(sectionId);
            const icon = button.querySelector('.toggle-icon');
 
            section.classList.toggle('hidden');
            icon.textContent = section.classList.contains('hidden') ? '+' : '−';
        }
</script>

<!-- manual & scheme drop down hide and show -->
<script>
  document.addEventListener("DOMContentLoaded", function () {

    const schemeDropdown = document.getElementById("scheme_id");
    const manualEntry = document.getElementById("manualEntry");
    const manualFields = document.getElementById("manualFields");
    const schemeBox = document.getElementById("schemeBox");

    function resetSchemeSelection() {
        schemeDropdown.value = "";
        schemeBox.classList.add("hidden");
    }

    // When Manual Entry Checked
    manualEntry.addEventListener("change", function () {
        const isChecked = this.checked;

        // Manual Fields toggle
        manualFields.classList.toggle("hidden", !isChecked);

        if (isChecked) {
            // Reset scheme selection only
            resetSchemeSelection();
        }
    });

    // When Scheme Selected
    schemeDropdown.addEventListener("change", function () {
        if (this.value !== "") {
            // Manual uncheck + hide manual fields
            manualFields.classList.add("hidden");
            manualEntry.checked = false;

            // Show Scheme Details Box
            schemeBox.classList.remove("hidden");
        } else {
            schemeBox.classList.add("hidden");
        }
    });

});
</script>

<!-- validation for max loan & Request loan -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const schemeSelect = document.getElementById("scheme_id");
    const requestLoanInput = document.getElementById("request_loan_amount");
    const tenureInput = document.getElementById("tenure_months");
    const form = requestLoanInput.closest("form");
    const submitBtn = form.querySelector('[type="submit"]');

    // Create error message elements
    const loanError = document.createElement("p");
    loanError.classList.add("text-red-500", "text-sm", "mt-1");
    requestLoanInput.insertAdjacentElement("afterend", loanError);

    const tenureError = document.createElement("p");
    tenureError.classList.add("text-red-500", "text-sm", "mt-1");
    tenureInput.insertAdjacentElement("afterend", tenureError);

    let maxLoanAmount = null;
    let maxTenure = null;

    // When user selects a scheme
    schemeSelect.addEventListener("change", function () {
        const selectedOption = this.options[this.selectedIndex];
        maxLoanAmount = parseFloat(selectedOption.dataset.max) || null;
        maxTenure = parseFloat(selectedOption.dataset.tenure) || null;

        // Reset values and messages
        loanError.textContent = "";
        tenureError.textContent = "";
        requestLoanInput.value = "";
        tenureInput.value = "";
        submitBtn.disabled = false;
        submitBtn.classList.remove("opacity-50", "cursor-not-allowed");
    });

    // Validation function
    function validateForm() {
        const loanEntered = parseFloat(requestLoanInput.value);
        const tenureEntered = parseFloat(tenureInput.value);
        let valid = true;

        // Loan amount validation
        if (maxLoanAmount && loanEntered > maxLoanAmount) {
            loanError.textContent = `⚠️ Requested amount cannot exceed ₹${maxLoanAmount.toLocaleString()}`;
            valid = false;
        } else {
            loanError.textContent = "";
        }

        // Tenure validation
        if (maxTenure && tenureEntered > maxTenure) {
            tenureError.textContent = `⚠️ Tenure cannot exceed ${maxTenure} months`;
            valid = false;
        } else {
            if (!tenureError.textContent || tenureEntered <= maxTenure) {
                tenureError.textContent = "";
            }
        }

        // Toggle submit button
        if (!valid) {
            submitBtn.disabled = true;
            submitBtn.classList.add("opacity-50", "cursor-not-allowed");
        } else {
            submitBtn.disabled = false;
            submitBtn.classList.remove("opacity-50", "cursor-not-allowed");
        }
    }

    // Listen to input changes
    requestLoanInput.addEventListener("input", validateForm);
    tenureInput.addEventListener("input", validateForm);

    // Prevent form submit if invalid
    form.addEventListener("submit", function (e) {
        if (submitBtn.disabled) {
            e.preventDefault();
        }
    });
});
</script>

<script>
  document.querySelectorAll('input[name="tenure_type"]').forEach(radio => {
      radio.addEventListener('change', function () {
        const label = document.getElementById('tenureLabel');
        label.textContent = `Tenure ( ${this.value} )`;
      });
    }); 
</script>

@endsection