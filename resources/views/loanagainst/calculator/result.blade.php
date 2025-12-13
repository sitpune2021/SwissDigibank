@extends('layout.main')
@section('content')
<div class="p-6 bg-white shadow rounded-lg">
  <h2 class="text-xl font-bold mb-4 uppercase text-center text-gray-700">Calculator Result</h2>

  <div class="overflow-x-auto">
    <table class="w-full text-sm border border-gray-400 rounded-lg">
      <tbody>
        <tr>
          <td class="font-semibold uppercase py-2 px-3 w-1/4 border border-gray-300">Disburse Date</td>
          <td class="py-2 px-3 w-1/4 border border-gray-300">{{ $disburse_date->format('d/m/Y') }}</td>
          <td class="font-semibold uppercase py-2 px-3 w-1/4 border border-gray-300">Loan Amount</td>
          <td class="py-2 px-3 w-1/4 border border-gray-300">₹ {{ number_format($loan,2) }}</td>
        </tr>

        <tr>
          <td class="font-semibold uppercase py-2 px-3 border border-gray-300">Interest Type</td>
          <td class="py-2 px-3 border border-gray-300">{{ ucfirst($interest_type) }}</td>
          <td class="font-semibold uppercase py-2 px-3 border border-gray-300">Processing Charges</td>
          <td class="py-2 px-3 border border-gray-300">₹ {{ number_format($processing_fee,2) }} (Incl. 18% GST)</td>
        </tr>

        <tr>
          <td class="font-semibold uppercase py-2 px-3 border border-gray-300">Insurance Charges</td>
          <td class="py-2 px-3 border border-gray-300">₹ {{ number_format($insurance_amount,2) }} (Incl. 0% GST)</td>
          <td class="font-semibold uppercase py-2 px-3 border border-gray-300">Stamp Duty</td>
          <td class="py-2 px-3 border border-gray-300">₹ {{ number_format($stamp_amount,2) }} (Incl. 18% GST)</td>       
        </tr>

        <tr>
          <td class="font-semibold uppercase py-2 px-3 border border-gray-300">EMI Count</td>
          <td class="py-2 px-3 border border-gray-300">{{ $installments }}</td>
          <td class="font-semibold uppercase py-2 px-3 border border-gray-300">EMI Payout</td>
          <td class="py-2 px-3 border border-gray-300">{{ strtoupper($payout) }}</td>        
        </tr>

        <tr>
          <td class="font-semibold uppercase py-2 px-3 border border-gray-300">Tenure</td>
          <td class="py-2 px-3 border border-gray-300">{{ $tenure_display }}</td>
          <td class="font-semibold uppercase py-2 px-3 border border-gray-300">Interest Rate (Annually)</td>
          <td class="py-2 px-3 border border-gray-300">{{ $annual_rate }} %</td>        
        </tr>
        <tr>
        @if ($interest_as_first)
          <td class="font-semibold uppercase py-2 px-3 border border-gray-300">Interest as First EMI</td>
          <td class="py-2 px-3 border border-gray-300">
            {{ $interest_as_first }}
          </td>
        @endif
        @if ($interestType === 'flat_advanced' && $interest_as_emi !== 'Yes')
              <td class="font-semibold uppercase py-2 px-3 border border-gray-300">
                 Interest as First EMI
              </td>
              <td class="py-2 px-3 border border-gray-300">
                  {{ $interest_as_first }}
              </td>
        @endif
        @if ($interest_as_emi)
          <td class="font-semibold uppercase py-2 px-3 border border-gray-300">Interest as EMI</td>
          <td class="py-2 px-3 border border-gray-300">
            {{ $interest_as_emi }}
          </td>
          @endif
        </tr>

        @if($isReducingWithRatio)
          <tr>
              <td colspan="4" class="py-3 px-4 border bg-gray-50">
                  <p class="font-semibold uppercase text-gray-800">Loan In Ratio: Yes</p>
              </td>
          </tr>
          <tr>
              <td>
                  First <strong>{{ $ratioFirstEmi }}</strong> EMIs will recover
                  <strong>{{ $ratioFirstPercentage }}%</strong> amount.
              </td>
              <td></td>
              <td>
                  Remaining <strong>{{ $installments - $ratioFirstEmi }}</strong> EMIs will recover
                  <strong>{{ 100 - $ratioFirstPercentage }}%</strong> amount.
              </td>
              <td></td>
          </tr>
        @endif

      </tbody>
    </table>
  </div>

</div>

  <div class="box mt-3">
    <h3 class="text-lg font-semibold text-center mt-6 mb-2">EMI CHART</h3>
  <div class="overflow-auto">

    <table class="w-full table-auto text-sm border border-gray-300 border-collapse">

        <thead>
            <tr class="bg-gray-100 border border-gray-300">
                <th class="p-2 border border-gray-300 uppercase">EMI NO</th>
                <th class="p-2 border border-gray-300 uppercase">EMI DATE</th>
                <th class="p-2 border border-gray-300 uppercase">DUE DATE</th>
                <th class="p-2 border border-gray-300 uppercase">PRINCIPAL (A)</th>
                <th class="p-2 border border-gray-300 uppercase">INTEREST (B)</th>
                <th class="p-2 border border-gray-300 uppercase">CHARGES PER EMI (C)</th>
                <th class="p-2 border border-gray-300 uppercase">EMI (A+B+C)</th>
                <th class="p-2 border border-gray-300 uppercase">BAL. PRINCIPAL</th>
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

        <tr class="bg-secondary/5 font-bold border border-gray-300">
            <td colspan="3" class="p-2 text-right uppercase tracking-wide border border-gray-300">TOTAL</td>
            <td class="p-2 text-right border border-gray-300">₹ {{ number_format($total_principal, 2) }}</td>
            <td class="p-2 text-right border border-gray-300">{{ $total_interest > 0 ? '₹ '.number_format($total_interest,2) : '' }}</td>
            <td class="p-2 text-center border border-gray-300">-</td>
            <td class="p-2 text-right border border-gray-300">{{ $total_emi_paid > 0 ? '₹ '.number_format($total_emi_paid,2) : '' }}</td>
            <td class="p-2 text-center border border-gray-300">-</td>
        </tr>

    </table>

  </div>
  </div>
</div>
@endsection
