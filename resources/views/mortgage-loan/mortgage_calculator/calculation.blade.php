@extends('layout.main')
@section('content')


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
        <tr class="border">
          <td class="px-4 py-2  border font-medium uppercase">Disburse Date</td>
          <td class="px-4 py-2 border">19/09/2025</td>
          <td class="px-4 py-2 border font-medium uppercase">Loan Amount</td>
          <td class="px-4 py-2 border">₹20,000.00</td>
        </tr>

        <tr class="border">
          <td class="px-4 py-2 border font-medium uppercase">Interest Type</td>
          <td class="px-4 py-2 border">No Emi</td>
          <td class="px-4 py-2 border font-medium uppercase">Processing Charges</td>
          <td class="px-4 py-2 border">0 (Incl. 18.0 % GST)</td>
        </tr>

        <tr class="border">
          <td class="px-4 py-2 border font-medium uppercase">Insurance Charges</td>
          <td class="px-4 py-2 border">0 (Incl. 18.0 % GST)</td>
          <td class="px-4 py-2 border font-medium uppercase">Stamp Duty</td>
          <td class="px-4 py-2 border">0 (Incl. 18.0 % GST)</td>
        </tr>

        <tr class="border">
          <td class="px-4 py-2 border font-medium uppercase">EMI Payout</td>
          <td class="px-4 py-2 border">MONTHLY</td>
          <td class="px-4 py-2 border font-medium uppercase">EMI Count</td>
          <td class="px-4 py-2 border">12</td>
        </tr>

        <tr class="border">
          <td class="px-4 py-2 border font-medium uppercase">Tenure</td>
          <td class="px-4 py-2 border">12 MONTHS</td>
          <td class="px-4 py-2 border font-medium uppercase">Interest Rate (Annually)</td>
          <td class="px-4 py-2 border">20.0 %</td>
        </tr>

        <tr class="border">
          <td class="px-4 py-2 border font-medium uppercase">Loan In Ratio</td>
          <td class="px-4 py-2 border">yes No</td>

        </tr>

        <tr  class="border" >
          <td class="px-4 py-2 font-medium uppercase">
            First 5 EMIs will Recover 80 % of loan amount.
          </td>
           <td class="px-4 py-2 border-r"></td>

          <td class="px-4 py-2 font-medium uppercase">
            Remaining 7 EMIs will Recover 20 % of loan amount.
          </td>
        </tr>

      </tbody>
    </table>
  </div>


  <div class="overflow-x-auto box  mt-5">
    <table class="w-full divide-y divide-gray-300">
      <thead class="">
        <tr class="bg-secondary/5 text-black ">
          <th colspan="8" class="text-center rounded-10 px-4 py-2 text-lg font-semibold uppercase">
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