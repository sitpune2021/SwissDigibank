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


<div class="main-inner ">
  <div class="overflow-x-auto box">
    <table class="w-full  rounded-10 ">
      <!-- Table Head -->
      <thead>
        <tr class="bg-secondary/5 text-black  ">
          <th colspan="4" class="text-center rounded-10 px-4 py-2 text-lg font-semibold">
            CALCULATOR
          </th>
        </tr>
      </thead>

      <!-- Table Body -->
      <tbody class="divide-y divide-gray-200 ">
        <tr class="border-b">
          <td class="px-4 py-2 font-medium">Disburse Date</td>
          <td class="px-4 py-2">19/09/2025</td>
          <td class="px-4 py-2 font-medium">Loan Amount</td>
          <td class="px-4 py-2">₹20,000.00</td>
        </tr>

        <tr class="border-b">
          <td class="px-4 py-2 font-medium">Interest Type</td>
          <td class="px-4 py-2">No Emi</td>
          <td class="px-4 py-2 font-medium">Processing Charges</td>
          <td class="px-4 py-2">0 (Incl. 18.0 % GST)</td>
        </tr>

        <tr class="border-b">
          <td class="px-4 py-2 font-medium">Insurance Charges</td>
          <td class="px-4 py-2">0 (Incl. 18.0 % GST)</td>
          <td class="px-4 py-2 font-medium">Stamp Duty</td>
          <td class="px-4 py-2">0 (Incl. 18.0 % GST)</td>
        </tr>

        <tr class="border-b">
          <td class="px-4 py-2 font-medium">EMI Payout</td>
          <td class="px-4 py-2">MONTHLY</td>
          <td class="px-4 py-2 font-medium">EMI Count</td>
          <td class="px-4 py-2">12</td>
        </tr>

        <tr class="border-b">
          <td class="px-4 py-2 font-medium">Tenure</td>
          <td class="px-4 py-2">12 MONTHS</td>
          <td class="px-4 py-2 font-medium">Interest Rate (Annually)</td>
          <td class="px-4 py-2">20.0 %</td>
        </tr>


      </tbody>
    </table>
  </div>


  <div class="overflow-x-auto box  mt-5">
    <table class="w-full divide-y divide-gray-300">
      <thead class="">
        <tr class="bg-secondary/5 text-black ">
          <th colspan="8" class="text-center rounded-10 px-4 py-2 text-lg font-semibold">
            EMI CHART
          </th>
        </tr>
        <tr class=" text-gray-700 border-b">
          <th class="py-2 px-2 text-center text-sm md:text-base">EMI NO</th>
          <th class="py-2 px-2 text-center text-sm md:text-base">EMI DATE</th>
          <th class="py-2 px-2 text-center text-sm md:text-base">DUE DATE</th>
          <th class="py-2 px-2 text-center text-sm md:text-base">PRINCIPAL (A)</th>
          <th class="py-2 px-2 text-center text-sm md:text-base">INTEREST (B)</th>
          <th class="py-2 px-2 text-center text-sm md:text-base">CHARGES PER EMI (C)</th>
          <th class="py-2 px-2 text-center text-sm md:text-base">EMI (A + B + C)</th>
          <th class="py-2 px-2 text-center text-sm md:text-base">BAL. PRINCIPAL</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-300">
        <tr class="bg-gray-50 border-b">
          <td class="py-2 px-2 text-start text-sm md:text-base"></td>
          <td class="py-2 px-2 text-start text-sm md:text-base"></td>
          <td class="py-2 px-2 text-start text-sm md:text-base"></td>
          <td class="py-2 px-2 text-start text-sm md:text-base"></td>
          <td class="py-2 px-2 text-start text-sm md:text-base"></td>
          <td class="py-2 px-2 text-start text-sm md:text-base"></td>
          <td class="py-2 px-2 text-start text-sm md:text-base"></td>
          <td class="py-2 px-2 text-end text-sm md:text-base">12222.0</td>
        </tr>
        <tr class="border-b">
          <td class="py-2 px-2 text-start">1</td>
          <td class="py-2 px-2 text-start">19/10/2025</td>
          <td class="py-2 px-2 text-start">20/10/2025</td>
          <td class="py-2 px-2 text-end">12222.0</td>
          <td class="py-2 px-2 text-start"></td>
          <td class="py-2 px-2 text-start"></td>
          <td class="py-2 px-2 text-start"></td>
          <td class="py-2 px-2 text-start"></td>
        </tr>
        <tr class="border-b">
          <td class="py-2 px-2 text-start">2</td>
          <td class="py-2 px-2 text-start">19/11/2025</td>
          <td class="py-2 px-2 text-start">20/11/2025</td>
          <td class="py-2 px-2 text-end">12222.0</td>
          <td class="py-2 px-2 text-start"></td>
          <td class="py-2 px-2 text-start"></td>
          <td class="py-2 px-2 text-start"></td>
          <td class="py-2 px-2 text-start"></td>
        </tr>
        <tr class="border-b">
          <td class="py-2 px-2 text-start">3</td>
          <td class="py-2 px-2 text-start">19/12/2025</td>
          <td class="py-2 px-2 text-start">20/12/2025</td>
          <td class="py-2 px-2 text-end">12222.0</td>
          <td class="py-2 px-2 text-start"></td>
          <td class="py-2 px-2 text-start"></td>
          <td class="py-2 px-2 text-start"></td>
          <td class="py-2 px-2 text-start"></td>
        </tr>
        <tr class="border-b">
          <td class="py-2 px-2 text-start">4</td>
          <td class="py-2 px-2 text-start">19/12/2025</td>
          <td class="py-2 px-2 text-start">20/12/2025</td>
          <td class="py-2 px-2 text-end">12222.0</td>
          <td class="py-2 px-2 text-start"></td>
          <td class="py-2 px-2 text-start"></td>
          <td class="py-2 px-2 text-start"></td>
          <td class="py-2 px-2 text-start"></td>
        </tr>

        <tr class="bg-secondary/5 text-black   font-semibold">
          <th colspan="4" class="py-2 px-2  text-start">TOTAL</th>
          <th class="py-2 px-2 text-end">0.0</th>
          <th class="py-2 px-2 text-end">0.0</th>
          <th class="py-2 px-2 text-end">0.0</th>
          <th class="py-2 px-2"></th>
        </tr>
      </tbody>
    </table>
  </div>


</div>




@endsection