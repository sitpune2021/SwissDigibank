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
            GOLD / SILVER LOAN CALCULATOR
          </h1>
        </div>
      </div>
    </div>


    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 p-6 min-h-screen">
      <div class="col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6">
        
        <form action="{{ route('gold-loan.calculator.calculate') }}" method="POST" target="_blank" class="space-y-6">
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

            <!-- Max Tenure -->
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
                <label><input type="radio" name="interest_type" value="reducing_emi"> Reducing EMI</label>
                <label><input type="radio" name="interest_type" value="flat_emi"> Flat EMI</label>
                <label><input type="radio" name="interest_type" value="flat_advanced"> Flat Advanced</label>
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
          <div class="w-full mt-4">
            <label class="block font-medium mb-2">Tenure (MONTHS) <span class="text-red-500">*</span></label>
            <input type="number" name="tenure_months" id="tenure_months" class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3" placeholder="Enter tenure in months">
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

          <!-- Interest Type -->
          <!-- <input type="hidden" name="interest_type" id="interest_type" value="flat"> -->

          {{--calculator checkbox- --}}
          <x-checkbox-calculator id="manualEntry" name="manual_entry"
            label="Check this if you want to divide loan EMIs in ratio."
            sublabel="(ex. 80% Principal amount in first 60 EMIs & rest 20% in next 40 EMIs of total 100 EMIs)" />
         
           <!-- Buttons -->
          <div class="flex justify-center gap-4 pt-6">
            <button type="submit" class="btn-primary">CALCULATE</button>
            <a href="{{ route('gold-loan.schemes.index') }}" class="btn-outline">Back</a>
          </div>

        </form>

      </div>

      
      <!--Scheme Info Table-->
      <div id="schemeBox" class="mt-5 hidden">
        <div class="flex justify-between items-center bg-secondary/5 rounded-10 px-4 py-3 dark:bg-bg3">
          <h3 class="text-base font-semibold md:text-lg uppercase">Scheme Info</h3>
          <button type="button" class="p-1 rounded transition" onclick="toggleSection(this, 'schemeInfoBody')">
            <span class="toggle-icon text-lg font-bold">−</span>
          </button>
        </div>

        <div id="schemeInfoBody" class="px-4 py-3">
          <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
              <tbody>
                <tr><td class="font-semibold py-2 pr-4 uppercase">Scheme Code</td><td class="py-2" id="schemeCode">-</td></tr>
                <tr><td class="font-semibold py-2 pr-4 uppercase">Scheme Name</td><td class="py-2" id="schemeName">-</td></tr>
                <tr><td class="font-semibold py-2 pr-4 uppercase">Max Tenure</td><td class="py-2" id="schemeTenure">-</td></tr>
                <tr><td class="font-semibold py-2 pr-4 uppercase">Maximum Loan Amount</td><td class="py-2" id="schemeMax">-</td></tr>
                <tr><td class="font-semibold py-2 pr-4 uppercase">Maximum Loan Limit Against Security</td><td class="py-2" id="schemeLimit">-</td></tr>
                <tr><td class="font-semibold py-2 pr-4 uppercase">Minimum Loan Amount</td><td class="py-2" id="schemeMin">-</td></tr>
                <tr><td class="font-semibold py-2 pr-4 uppercase">Annual Interest Rate</td><td class="py-2" id="schemeInterest">-</td></tr>
                <tr><td class="font-semibold py-2 pr-4 uppercase">Interest Type</td><td class="py-2" id="schemeType">-</td></tr>
                <tr><td class="font-semibold py-2 pr-4 uppercase">Active</td><td class="py-2" id="schemeActive">-</td></tr>
                <tr><td class="font-semibold py-2 pr-4 uppercase">Fore Closure Charges</td><td class="py-2" id="schemeCharge">-</td></tr>
                <tr class="border-b border-gray-200">
                  <td class="font-semibold px-3 py-2 uppercase">Stamp Duty Fee</td>
                  <td class="px-3 py-2"><span id="schemeStamp">-</span> %</td>
                </tr>
                <tr class="border-b border-gray-200">
                  <td class="font-semibold px-3 py-2 uppercase">Insurance Charges</td>
                  <td class="px-3 py-2"><span id="schemeInsurance">-</span> %</td>
                </tr>
                <tr class="border-b border-gray-200">
                  <td class="font-semibold px-3 py-2 uppercase">Processing Fee</td>
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

<!-- Show Scheme Info -->
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


@endsection