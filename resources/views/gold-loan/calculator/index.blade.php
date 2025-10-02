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
            GOLD/ SILVER LOAN CALCULATOR
          </h1>
        </div>
      </div>
    </div>


    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 p-6 min-h-screen">
      <div class="col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6">
        <form action="" method="" target="" class="space-y-6">

          <!-- Scheme -->
          <div class="mb-4">
            <label for="" class="block font-medium mb-2 uppercase">Scheme <span class="text-red-500">*</span></label>
            <select id="schemes" name="" 
              class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5 dark:bg-bg3 ">
              <option value="">Select Scheme</option>
              <option value="scheme1">Scheme 1</option>
              <option value="scheme2">Scheme 2</option>
              <option value="scheme3">Scheme 3</option>
            </select>
          </div>

          <!-- Enter values manually -->
          <div class="mt-4">
            <label class="flex items-center space-x-2">
              <input type="checkbox" id="manualEntry" name=""
                class="rounded-10 border-gray-300 text-primary focus:ring-blue-500">
              <span class="p-2">Enter Values Manually</span>
            </label>
          </div>

          <div id="manualFields" class=" hidden bg-secondary/5 rounded-10 p-3 mt-3 dark:bg-bg3">
            <div class="grid grid-cols-2 gap-4 mt-3 xl:mt-3 xxxxxl:gap-6 ">
              <div class="col-span-2 md:col-span-2">
                <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                  Max. Tenure
                </label>

                <div class="flex items-center gap-2">


                  <select name="max_tenure" id="max_tenure"
                    class="w-full text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3">
                    <option value="1">1 Month</option>
                    <option value="3">3 Months</option>
                    <option value="6">6 Months</option>
                    <option value="9">9 Months</option>
                    <option value="12">12 Months</option>
                    <option value="18">18 Months</option>
                    <option value="24">2 Years</option>
                    <option value="36">3 Years</option>
                    <option value="48">4 Years</option>
                    <option value="60">5 Years</option>
                    <option value="72">6 Years</option>
                    <option value="84">7 Years</option>
                    <option value="96">8 Years</option>
                    <option value="108">9 Years</option>
                    <option value="120">10 Years</option>
                    <option value="180">15 Years</option>
                  </select>


                </div>
              </div>
              <div class="col-span-2 md:col-span-2">
                <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                  Maximum Loan Limit (%)
                </label>

                <div class="flex items-center gap-2">
                  <select name="maximum_loan_limit" id="maximum_loan_limit"
                    class="w-full text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3">
                    <option value="">Please Select</option>
                    <option value="30.0">30%</option>
                    <option value="35.0">35%</option>
                    <option value="40.0">40%</option>
                    <option value="45.0">45%</option>
                    <option value="50.0">50%</option>
                    <option value="55.0">55%</option>
                    <option value="60.0">60%</option>
                    <option value="65.0">65%</option>
                    <option value="70.0">70%</option>
                    <option value="75.0">75%</option>
                    <option value="80.0">80%</option>
                    <option value="85.0">85%</option>
                    <option value="90.0">90%</option>
                    <option value="95.0">95%</option>
                    <option value="100.0">100%</option>
                  </select>
                </div>
              </div>
            </div>

            {{--intersetTypeRadio --}}
            <div class="w-full mt-3">
              <div class="mb-4" id="intersetTypeRadio">
                <label class="md:text-lg font-medium block mb-2 uppercase">
                  Interest Type <span class="text-red-600">*</span>
                </label>

                <div class="mt-1 flex flex-wrap gap-3">
                  <!-- Reducing EMI -->
                  <label class="flex items-center gap-2 space-x-2 p-2">
                    <input type="radio" name="gold_loan_setting" id="" class="text-green-600 focus:ring-green-500"
                      data-target="charges-per-emi" checked>
                    <span class="text-gray-70 uppercase">Reducing EMI</span>
                  </label>

                  <!-- Flat EMI -->
                  <label class="flex items-center gap-2 space-x-2 p-2">
                    <input type="radio" name="gold_loan_setting" id="" class="text-green-600 focus:ring-green-500"
                      data-target="charges-per-emi">
                    <span class="text-gray-700 uppercase">Flat EMI</span>
                  </label>

                  <!-- Flat Advanced Interest Deduction -->
                  <label class="flex items-center gap-2 space-x-2 p-2">
                    <input type="radio" name="gold_loan_setting" id="" class="text-green-600 focus:ring-green-500"
                      data-target="charges-per-emi">
                    <span class="text-gray-700 uppercase">Flat Advanced Interest Deduction</span>
                  </label>

                  <!-- No EMI -->
                  <label class="flex items-center gap-2 space-x-2 p-2">
                    <input type="radio" name="gold_loan_setting" id="" class="text-green-600 focus:ring-green-500"
                      data-target="no-emi">
                    <span class="text-gray-700 uppercase">No EMI</span>
                  </label>
                </div>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4  mt-1 xl:mt-1  xxxxxl:gap-6 ">
              <div class="col-span-2 md:col-span-2">
                <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                  Annual Interest Rate (%)
                  <span class="text-red-500">*</span>
                </label>

                <input type="number" id="" name=""
                  class="w-full text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                  placeholder="Enter Annual Interest Rate">
              </div>
              <div class="col-span-2 md:col-span-2">
                <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                  Processing Fee

                </label>

                <div class="flex items-center gap-2">


                  <select name="" id=""
                    class="w-24 text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">

                    <option value="">%</option>
                    <option class="uppercase" value="">Fixed</option>
                  </select>

                  <input type="number" id="" name=""
                    class="w-full text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                    placeholder="Enter Processing Fee ">
                </div>
              </div>
              <div class="col-span-2 md:col-span-2">
                <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                  Stamp Duty Charge
                </label>

                <div class="flex items-center gap-2">
                  <select name="" id=""
                    class="w-24 text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">
                    <option value="">%</option>
                    <option class="uppercase" value="">Fixed</option>

                  </select>

                  <input type="number" id="" name=""
                    class="w-full text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                    placeholder="Enter Stamp Duty Charge ">
                </div>
              </div>

              <div class="col-span-2 md:col-span-2">
                <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                  Insurance Charges
                </label>

                <div class="flex items-center gap-2">

                  <select name="" id=""
                    class="w-24 text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">
                    <option value="">%</option>
                    <option class="uppercase" value="">Fixed</option>

                  </select>


                  <input type="number" id="" name=""
                    class="w-full text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                    placeholder="Enter Insurance Fee ">
                </div>
              </div>


              <div class="col-span-2 md:col-span-2">

                <div class="col-sm-7">
                  <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                    Fore Closure Charges
                  </label>

                  <div class="flex items-center gap-2">

                    <select name="" id=""
                      class="w-24 text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">
                      <option value="">%</option>
                      <option class="uppercase" value="">Fixed</option>

                    </select>


                    <input type="number" id="" name=""
                      class="w-full text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                      placeholder="Enter Fore Closure Charges">
                  </div>

                </div>
              </div>

            </div>
            <div class="w-full my-4">
              <hr class="border-gray-300">
              <h4
                class="text-center font-semibold text-lg sm:text-xl md:text-2xl mt-4 flex items-center justify-center gap-2 uppercase">
                Per EMI Charges

              </h4>

            </div>
            <div class=" md:gap-5 gap-4 w-full  grid grid-cols-2 gap-4 mt-3 xl:mt-4 xxxxxl:gap-6">

              <!-- SMS Charges Block -->
              <div class=" col-span-2 md:col-span-2 ">
                <label class="md:text-lg font-medium mb-2 uppercase">
                  SMS Charges
                </label>

                <div class="flex items-center gap-2 w-full mt-2">
                  <select name="" id=""
                    class="w-24 text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-4 py-2 md:py-3">
                    <option class="uppercase" value="">Fixed</option>
                    <option value="">%</option>
                  </select>
                  <input type="number" name="" id=""
                    class="w-full text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter SMS Charges">
                </div>
              </div>

              <!-- Fuel Charges Block -->
              <div class=" col-span-2 md:col-span-2">
                <label class="md:text-lg font-medium mb-2 uppercase">
                  Fuel Charges
                </label>

                <div class="flex items-center gap-2 w-full mt-2">
                  <select name="" id=""
                    class="w-24 text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-4 py-2 md:py-3">
                    <option class="uppercase" value="">Fixed</option>
                    <option value="">%</option>
                  </select>

                  <input type="number" name="" id=""
                    class="w-full text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Penalty Charges">
                </div>
              </div>

            </div>


            <div class="  md:gap-5 gap-4 w-full  grid grid-cols-2 gap-4 mt-2 xl:mt-4 xxxxxl:gap-6">

              <!-- Stationary Charges Block -->
              <div class="col-span-2 md:col-span-2">
                <label class="md:text-lg font-medium mb-2 uppercase">
                  Stationary Charges
                </label>

                <div class="flex items-center gap-2 w-full mt-2">
                  <select name="" id=""
                    class="w-24 text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-4 py-2 md:py-3">
                    <option class="uppercase" value="">Fixed</option>
                    <option value="">%</option>
                  </select>
                  <input type="number" name="" id=""
                    class="w-full text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Stationary Charges">
                </div>
              </div>

              <!-- Maintenance Charges  Block -->
              <div class="col-span-2 md:col-span-2">
                <label class="md:text-lg font-medium mb-2 uppercase">
                  Maintenance Charges
                </label>

                <div class="flex items-center gap-2 w-full mt-2">
                  <select name="" id=""
                    class="w-24 text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-4 py-2 md:py-3">
                    <option class="uppercase" value="">Fixed</option>
                    <option value="">%</option>
                  </select>

                  <input type="number" name="" id=""
                    class="w-full text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Maintenance Charges">
                </div>
              </div>

            </div>

            <div class="md:gap-5 gap-4 w-full  grid grid-cols-2 gap-4 mt-2 xl:mt-4 xxxxxl:gap-6">

              <!--Collection Charges  #007bffBlock -->
              <div class=" col-span-2 md:col-span-2">
                <label class="md:text-lg font-medium mb-2 uppercase">
                  Collection Charges
                </label>

                <div class="flex items-center gap-2 w-full mt-2">
                  <select name="" id=""
                    class="w-24 text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-4 py-2 md:py-3">
                    <option class="uppercase" value="">Fixed</option>
                    <option value="">%</option>
                  </select>
                  <input type="number" name="" id=""
                    class="w-full text-sm bg-white dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Collection Charges">
                </div>
              </div>

              <!-- Blank  Block (do not remove ) -->
              <div class="col-span-2 md:col-span-2">

              </div>

            </div>
          </div>

          <!-- Enter Tenure Type *-->
          <div class="w-full mt-4 ">
            <label class="block font-medium mb-2 uppercase" for="tenure_type">
              Tenure Type <span class="text-red-500">*</span>
            </label>

            <div class="flex flex-wrap gap-4">

              <label class="flex items-center space-x-2 gap-2">
                <input type="radio" name="tenure_type" value="DAYS" required class="text-blue-600 focus:ring-blue-500">
                <span>DAYS</span>
              </label>

              <label class="flex items-center space-x-2 gap-2">
                <input type="radio" name="tenure_type" value="WEEKS" required class="text-blue-600 focus:ring-blue-500">
                <span>WEEKS</span>
              </label>
              <label class="flex items-center space-x-2 gap-2">
                <input type="radio" name="tenure_type" value="MONTHS" required checked
                  class="text-blue-600 focus:ring-blue-500">
                <span>MONTHS</span>
              </label>
            </div>
          </div>

          <!--  Tenure ( MONTHS ) -->
          <div class="w-full mt-4 ">
            <label class="block font-medium mb-2 uppercase" for="tenure_type">
              Tenure ( MONTHS ) <span class="text-red-500">*</span>
            </label>

            <div class="flex flex-wrap gap-4">

              <input type="number" name="" id="" class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5
                      dark:bg-bg3 " placeholder="Please Enter Tenure">

            </div>
          </div>

          <!-- EMI Payout  -->
          <div class="mt-4">
            <label for="" class="block font-medium mb-2 uppercase">EMI Payout <span class="text-red-500">*</span></label>
            <select id="" name="" required
              class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5 dark:bg-bg3 ">
              <option value="">Select EMI Payout </option>

            </select>
          </div>

          <!--  Requested Loan Amount (₹) -->
          <div class="w-full mt-4 ">
            <label class="block font-medium mb-2 uppercase" for="tenure_type">
              Requested Loan Amount (₹) <span class="text-red-500">*</span>
            </label>

            <div class="flex flex-wrap gap-4">

              <input type="number" name="" id="request_loan_amount"
                class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5 dark:bg-bg3 "
                placeholder="Please Enter Loan Amount">
              <x-number-to-word for="request_loan_amount" />
            </div>
          </div>

          {{--calculator checkbox- --}}
          <x-checkbox-calculator id="manualEntry" name="manual_entry"
            label="Check this if you want to divide loan EMIs in ratio."
            sublabel="(ex. 80% Principal amount in first 60 EMIs & rest 20% in next 40 EMIs of total 100 EMIs)" />

          <!-- Buttons -->
          <div class="flex justify-center gap-4 pt-6">
            <button type="submit" class="btn-primary">
              CALCULATE
            </button>
            <a href="" class="btn-outline">
              Back
            </a>
          </div>
        </form>
      </div>

      <!--Scheme Info Table-->
      <div id="schemeBox" class="hidden col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6">
        <div class="flex bg-secondary/5 items-center justify-between rounded-10 px-4 py-3 dark:bg-bg3">
          <h3 class="text-base font-semibold md:text-lg uppercase" >Scheme Info</h3>
          <button type="button" class="p-1 rounded transition" onclick="toggleSection(this, 'schemeInfoBody')">
            <span class="toggle-icon text-lg font-bold">−</span>
          </button>
        </div>


        <div id="schemeInfoBody" class="w-full px-4 py-3">
          <div class="overflow-x-auto   ">
            <table class=" text-sm text-left whitespace-nowrap ">
              <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                <tr class="border-b">
                  <td class="font-semibold py-2 pr-4 uppercase">Scheme Code</td>
                  <td class="py-2">SSY17</td>
                </tr>
                <tr class="border-b">
                  <td class="font-semibold py-2 pr-4 uppercase">Scheme Name</td>
                  <td class="py-2">Suvarna shree yojana no emi</td>
                </tr>
                <tr class="border-b">
                  <td class="font-semibold py-2 pr-4 uppercase">Max Tenure</td>
                  <td class="py-2">12 Months</td>
                </tr>
                <tr class="border-b">
                  <td class="font-semibold py-2 pr-4 uppercase">Maximum Loan Amount</td>
                  <td class="py-2">₹ 100,000.00</td>
                </tr>
                <tr class="border-b">
                  <td class="font-semibold py-2 pr-4 uppercase">Maximum Loan Limit Against Security</td>
                  <td class="py-2">80.0 %</td>
                </tr>
                <tr class="border-b">
                  <td class="font-semibold py-2 pr-4 uppercase">Minimum Loan Amount</td>
                  <td class="py-2">₹ 10,000.00</td>
                </tr>
                <tr class="border-b">
                  <td class="font-semibold py-2 pr-4 uppercase">Annual Interest Rate</td>
                  <td class="py-2">20.0 %</td>
                </tr>
                <tr class="border-b">
                  <td class="font-semibold py-2 pr-4 uppercase">Interest Type</td>
                  <td class="py-2">No Emi</td>
                </tr>
                <tr class="border-b">
                  <td class="font-semibold py-2 pr-4 uppercase">Credit Period</td>
                  <td class="py-2">1 Days</td>
                </tr>
                <tr class="border-b">
                  <td class="font-semibold py-2 pr-4 uppercase">Active</td>
                  <td class="py-2">
                    <span class="inline-block rounded bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                      Yes
                    </span>
                  </td>
                </tr>
                <tr class="border-b">
                  <td class="font-semibold py-2 pr-4 uppercase">Fore Closure Charges</td>
                  <td class="py-2">₹</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>


  </div>


  <script>
    const schemes = document.getElementById("schemes");
    const manualCheckbox = document.getElementById("manualEntry");
    const manualFields = document.getElementById("manualFields");

    manualCheckbox.addEventListener("change", () => {
      if (manualCheckbox.checked) {
        schemes.disabled = true;
        manualFields.classList.remove("hidden");
      } else {
        schemes.disabled = false;
        manualFields.classList.add("hidden");
      }
    });



    //for select schemes
    // const schemes = document.getElementById("schemes");
    const schemeBox = document.getElementById("schemeBox");

    schemes.addEventListener("change", () => {
      if (schemes.value) {
        schemeBox.classList.remove("hidden");
      } else {
        schemeBox.classList.add("hidden");
      }
    });



            // <!-- collapsed logic + - button-->

            function toggleSection(button, sectionId) {
                const section = document.getElementById(sectionId);
                const icon = button.querySelector('.toggle-icon');

                section.classList.toggle('hidden');
                icon.textContent = section.classList.contains('hidden') ? '+' : '−';
            }

        
  </script>

@endsection