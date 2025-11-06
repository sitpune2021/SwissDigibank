@extends('layout.main')
@section('content')
<div class="p-6 bg-white shadow rounded-lg">
  <h2 class="text-xl font-bold mb-4 text-gray-700"><center>Calculator Result</center></h2>

  <div class="overflow-x-auto">
    <table class="w-full text-sm border border-gray-400 rounded-lg">
      <tbody>
        <tr>
          <td class="font-semibold py-2 px-3 w-1/4 border border-gray-300">Disburse Date</td>
          <td class="py-2 px-3 w-1/4 border border-gray-300">{{ $disburse_date->format('d/m/Y') }}</td>
          <td class="font-semibold py-2 px-3 w-1/4 border border-gray-300">Loan Amount</td>
          <td class="py-2 px-3 w-1/4 border border-gray-300">₹ {{ number_format($loan,2) }}</td>
        </tr>

        <tr>
          <td class="font-semibold py-2 px-3 border border-gray-300">Interest Type</td>
          <td class="py-2 px-3 border border-gray-300">{{ ucfirst($interest_type) }}</td>
          <td class="font-semibold py-2 px-3 border border-gray-300">Processing Charges</td>
          <td class="py-2 px-3 border border-gray-300">₹ {{ number_format($processing_incl_gst,2) }} (Incl. 18% GST)</td>
        </tr>

        <tr>
          <td class="font-semibold py-2 px-3 border border-gray-300">EMI Payout</td>
          <td class="py-2 px-3 border border-gray-300">{{ strtoupper($payout) }}</td>
          <td class="font-semibold py-2 px-3 border border-gray-300">Insurance Charges</td>
          <td class="py-2 px-3 border border-gray-300">₹ {{ number_format($insurance_amount,2) }} (Incl. 0% GST)</td>
        </tr>

        <tr>
          <td class="font-semibold py-2 px-3 border border-gray-300">EMI Count</td>
          <td class="py-2 px-3 border border-gray-300">{{ $installments }}</td>
          <td class="font-semibold py-2 px-3 border border-gray-300">Stamp Duty</td>
          <td class="py-2 px-3 border border-gray-300">₹ {{ number_format($stamp_incl_gst,2) }} (Incl. 18% GST)</td>
        </tr>

        <tr>
          <td class="font-semibold py-2 px-3 border border-gray-300">Tenure</td>
          <td class="py-2 px-3 border border-gray-300">{{ $tenure_months }} MONTHS</td>
          <td class="font-semibold py-2 px-3 border border-gray-300">Total Interest</td>
          <td class="py-2 px-3 border border-gray-300">₹ {{ number_format($total_interest,2) }}</td>
        </tr>

        <tr>
          <td class="font-semibold py-2 px-3 border border-gray-300">Interest Rate (Annually)</td>
          <td class="py-2 px-3 border border-gray-300">{{ $annual_rate }} %</td>
          <td class="font-semibold py-2 px-3 border border-gray-300">Total Payable (EMIs)</td>
          <td class="py-2 px-3 border border-gray-300">₹ {{ number_format($total_emi_paid,2) }}</td>
        </tr>

        <!-- <tr class="bg-gray-50 font-semibold">
          <td class="py-2 px-3 border border-gray-300"> </td>
          <td class="py-2 px-3 border border-gray-300"> </td>
          <td class="py-2 px-3 text-gray-800 border border-gray-300">Grand Total Payable</td>
          <td class="py-2 px-3 text-green-700 font-bold border border-gray-300">₹ {{ number_format($grand_total_payable,2) }}</td>
        </tr> -->
      </tbody>
    </table>
  </div>

</div>

  <h3 class="text-lg font-semibold mt-6 mb-2"><center>EMI CHART</center></h3>
  <div class="overflow-auto">

    <table class="w-full table-auto text-sm border border-gray-300 border-collapse">

        <thead>
            <tr class="bg-gray-100 border border-gray-300">
                <th class="p-2 border border-gray-300">EMI NO</th>
                <th class="p-2 border border-gray-300">EMI DATE</th>
                <th class="p-2 border border-gray-300">DUE DATE</th>
                <th class="p-2 border border-gray-300">PRINCIPAL (A)</th>
                <th class="p-2 border border-gray-300">INTEREST (B)</th>
                <th class="p-2 border border-gray-300">CHARGES PER EMI (C)</th>
                <th class="p-2 border border-gray-300">EMI (A+B+C)</th>
                <th class="p-2 border border-gray-300">BAL. PRINCIPAL</th>
            </tr>
        </thead>

        <tr class="bg-gray-50 font-semibold border border-gray-300">
            <td colspan="7" class="p-2 text-right border border-gray-300"></td>
            <td class="p-2 text-right text-green-600 border border-gray-300">
                ₹ {{ number_format($loan, 2) }}
            </td>
        </tr>

        <tbody>
            @foreach($schedule as $row)
            <tr class="border border-gray-300">
                <td class="p-2 text-center border border-gray-300">{{ $row['no'] }}</td>
                 <td class="p-2 text-center border border-gray-300">
                    {{ !empty($row['emi_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $row['emi_date'])->format('d-m-Y') : '-' }}
                </td>
                <td class="p-2 text-center border border-gray-300">
                    {{ !empty($row['due_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $row['due_date'])->format('d-m-Y') : '-' }}
                </td>
                <td class="p-2 text-right border border-gray-300">₹ {{ number_format($row['principal'],2) }}</td>
                <td class="p-2 text-right border border-gray-300">{{ $row['interest'] !== null ? '₹ '.number_format($row['interest'],2) : '' }}</td>
                <td class="p-2 text-right border border-gray-300">{{ $row['charges'] !== null ? '₹ '.number_format($row['charges'],2) : '' }}</td>
                <td class="p-2 text-right border border-gray-300">{{ $row['emi'] !== null ? '₹ '.number_format($row['emi'],2) : '' }}</td>
                <td class="p-2 text-right border border-gray-300">{{ $row['balance'] !== null ? '₹ '.number_format($row['balance'],2) : '' }}</td>
            </tr>
            @endforeach
        </tbody>

        <tr class="bg-blue-600 text-white font-bold border border-gray-300">
            <td colspan="3" class="p-2 text-right uppercase tracking-wide border border-gray-300">TOTAL</td>
            <!-- <td class="p-2 text-right border border-gray-300">₹ {{ number_format($total_principal, 2) }}</td> -->
             <td></td>
            <td class="p-2 text-right border border-gray-300">{{ $total_interest > 0 ? '₹ '.number_format($total_interest,2) : '' }}</td>
            <td class="p-2 text-center border border-gray-300">-</td>
            <td class="p-2 text-right border border-gray-300">{{ $total_emi_paid > 0 ? '₹ '.number_format($total_emi_paid,2) : '' }}</td>
            <td class="p-2 text-center border border-gray-300">-</td>
        </tr>

    </table>

  </div>
</div>
@endsection
