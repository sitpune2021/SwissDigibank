@extends('layout.main')
@section('content')
<div class="p-6 bg-white shadow rounded-lg">
  <h2 class="text-xl font-bold mb-4 text-gray-700">Calculator Result</h2>

  <div class="overflow-x-auto">
    <table class="w-full text-sm border border-gray-200 rounded-lg">
      <tbody class="divide-y divide-gray-200">
        <tr>
          <td class="font-semibold py-2 px-3 w-1/4">Disburse Date</td>
          <!-- <td class="py-2 px-3 w-1/4">{{ $disburse_date->format('d/m/Y') }}</td> -->
           <td class="py-2 px-3 w-1/4">{{ $disburse_date->format('d-m-Y') }}</td>
          <td class="font-semibold py-2 px-3 w-1/4">Loan Amount</td>
          <td class="py-2 px-3 w-1/4">₹ {{ number_format($loan,2) }}</td>
        </tr>
        <tr>
          <td class="font-semibold py-2 px-3">Interest Type</td>
          <td class="py-2 px-3">{{ ucfirst($interest_type) }}</td>
          <td class="font-semibold py-2 px-3">Processing Charges</td>
          <td class="py-2 px-3">₹ {{ number_format($processing_incl_gst,2) }} (Incl. 18% GST)</td>
        </tr>
        <tr>
          <td class="font-semibold py-2 px-3">EMI Payout</td>
          <td class="py-2 px-3">{{ strtoupper($payout) }}</td>
          <td class="font-semibold py-2 px-3">Insurance Charges</td>
          <td class="py-2 px-3">₹ {{ number_format($insurance_amount,2) }} (Incl. 0% GST)</td>
        </tr>
        <tr>
          <td class="font-semibold py-2 px-3">EMI Count</td>
          <td class="py-2 px-3">{{ $installments }}</td>
          <td class="font-semibold py-2 px-3">Stamp Duty</td>
          <td class="py-2 px-3">₹ {{ number_format($stamp_incl_gst,2) }} (Incl. 18% GST)</td>
        </tr>
        <tr>
          <td class="font-semibold py-2 px-3">Tenure</td>
          <td class="py-2 px-3">{{ $tenure_months }} MONTHS</td>
          <td class="font-semibold py-2 px-3">Total Interest</td>
          <td class="py-2 px-3">₹ {{ number_format($total_interest,2) }}</td>
        </tr>
        <tr>
          <td class="font-semibold py-2 px-3">Interest Rate (Annually)</td>
          <td class="py-2 px-3">{{ $annual_rate }} %</td>
          <td class="font-semibold py-2 px-3">Total Payable (EMIs)</td>
          <td class="py-2 px-3">₹ {{ number_format($total_emi_paid,2) }}</td>
        </tr>
        <tr class="bg-gray-50 font-semibold">
          <td class="py-2 px-3 text-gray-700"> </td>
          <td class="py-2 px-3"> </td>
          <!-- <td class="py-2 px-3 text-gray-700">Grand Total Payable</td>
          <td class="py-2 px-3 text-green-700 font-bold">₹ {{ number_format($grand_total_payable,2) }}</td> -->
        </tr>
      </tbody>
    </table>
  </div>
</div>

  <h3 class="text-lg font-semibold mt-6 mb-2">EMI CHART</h3>
  <div class="overflow-auto">
    <table class="w-full table-auto text-sm border-collapse">
      <thead>
        <tr class="bg-gray-100">
          <th class="p-2">EMI NO</th>
          <th class="p-2">EMI DATE</th>
          <th class="p-2">DUE DATE</th>
          <th class="p-2">PRINCIPAL (A)</th>
          <th class="p-2">INTEREST (B)</th>
          <th class="p-2">CHARGES PER EMI (C)</th>
          <th class="p-2">EMI (A+B+C)</th>
          <th class="p-2">BAL. PRINCIPAL</th>
        </tr>
      </thead>
      <tbody>
        @foreach($schedule as $row)
          <tr>
            <td class="p-2 text-center">{{ $row['no'] }}</td>
            <!-- <td class="p-2 text-center">{{ $row['emi_date'] }}</td> -->
            <td class="p-2 text-center">
                {{ \Carbon\Carbon::createFromFormat('d/m/Y', $row['emi_date'])->format('d-m-Y') }}
            </td>
            <!-- <td class="p-2 text-center">{{ $row['due_date'] }}</td> -->
            <td class="p-2 text-center">
                {{ \Carbon\Carbon::createFromFormat('d/m/Y', $row['due_date'])->format('d-m-Y') }}
            </td>
            <td class="p-2 text-right">₹ {{ number_format($row['principal'],2) }}</td>
            <td class="p-2 text-right">₹ {{ number_format($row['interest'],2) }}</td>
            <td class="p-2 text-right">₹ {{ number_format($row['charges'],2) }}</td>
            <td class="p-2 text-right">₹ {{ number_format($row['emi'],2) }}</td>
            <td class="p-2 text-right">₹ {{ number_format($row['balance'],2) }}</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
            <tr class="bg-gray-200 font-bold">
                <td colspan="4" class="p-2 text-center">TOTAL</td>
                <td class="p-2 text-right">₹ {{ number_format($total_interest_paid, 2) }}</td>
                <td class="p-2 text-right">₹ {{ number_format($total_charges_paid, 2) }}</td>
                <td class="p-2 text-right">₹ {{ number_format($total_emi_paid, 2) }}</td>
                <td class="p-2 text-right">₹ 0.00</td>
            </tr>
        </tfoot>
    </table>
  </div>
</div>
@endsection
