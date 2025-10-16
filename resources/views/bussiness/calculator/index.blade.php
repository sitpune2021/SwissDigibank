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
            BUSINESS LOAN CALCULATOR
          </h1>
        </div>
      </div>
    </div>


    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 p-6 min-h-screen">
      <div class="col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6">
        <form action="{{ route('bussiness.calculator.calculate') }}" method="POST" target="_blank" class="space-y-6">
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
                  data-charge="{{ $item->fore_closer_charge }}"
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
            <div class="col-span-2">
              <label class="md:text-lg font-medium block mb-4">Max. Tenure</label>
              <select name="max_tenure" id="max_tenure"
                class="w-full text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 py-3">
                <option value="1">1 Month</option>
                <option value="3">3 Months</option>
                <option value="6">6 Months</option>
                <option value="12">1 Year</option>
                <option value="24">2 Years</option>
                <option value="36">3 Years</option>
                <option value="48">4 Years</option>
                <option value="60">5 Years</option>
              </select>
            </div>

            <!-- Annual Interest Rate -->
            <div class="col-span-2">
              <label class="md:text-lg font-medium block mb-4">
                Annual Interest Rate (%) <span class="text-red-500">*</span>
              </label>
              <input type="number" id="manual_interest_rate" name="manual_interest_rate"
                class="w-full text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 py-3"
                placeholder="Enter Annual Interest Rate">
            </div>

            <!-- Processing Fee -->
            <div class="col-span-2">
              <label class="md:text-lg font-medium block mb-4">Processing Fee</label>
              <input type="number" id="manual_processing_fee" name="manual_processing_fee"
                class="w-full text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 py-3"
                placeholder="Enter Processing Fee (₹)">
            </div>

            <!-- Stamp Duty -->
            <div class="col-span-2">
              <label class="md:text-lg font-medium block mb-4">Stamp Duty Charge</label>
              <input type="number" id="manual_stamp" name="manual_stamp"
                class="w-full text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 py-3"
                placeholder="Enter Stamp Duty (%)">
            </div>

            <!-- Insurance -->
            <div class="col-span-2">
              <label class="md:text-lg font-medium block mb-4">Insurance Charge</label>
              <input type="number" id="manual_insurance" name="manual_insurance"
                class="w-full text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 py-3"
                placeholder="Enter Insurance (%)">
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
          <input type="hidden" name="interest_type" id="interest_type" value="flat">


          {{--calculator checkbox- --}}
          <!-- <x-checkbox-calculator id="manualEntry" name="manual_entry"
            label="Check this if you want to divide loan EMIs in ratio."
            sublabel="(ex. 80% Principal amount in first 60 EMIs & rest 20% in next 40 EMIs of total 100 EMIs)" /> -->

         
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



@endsection