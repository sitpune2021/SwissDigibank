<div class="box p-4">
  <p class="mb-2 text-sm text-gray-600">
    From: {{ $fromDate->format('d-m-Y') }} To: {{ $toDate->format('d-m-Y') }}
  </p>

  @php 
dd("hi");
  @endphp
  <div id="printableArea">
    <table class="w-full border border-gray-300 text-sm mt-2">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-2 py-2 border">Date</th>
          <th class="px-2 py-2 border">Particulars</th>
          <th class="px-2 py-2 border">Cheque No</th>
          <th class="px-2 py-2 border text-right">DR Amount</th>
          <th class="px-2 py-2 border text-right">CR Amount</th>
          <th class="px-2 py-2 border text-right">Balance</th>
        </tr>
      </thead>
      <tbody>
        @forelse($transactions as $txn)
        <tr>
          <td class="px-2 py-2 border">{{ $txn->created_at->format('d-m-Y') }}</td>
          <td class="px-2 py-2 border">{{ $txn->description ?? '-' }}</td>
          <td class="px-2 py-2 border">{{ $txn->cheque_no ?? '-' }}</td>
          <td class="px-2 py-2 border text-right">{{ $txn->debit_amount ?? '-' }}</td>
          <td class="px-2 py-2 border text-right">{{ $txn->credit_amount ?? '-' }}</td>
          <td class="px-2 py-2 border text-right">{{ $txn->balance ?? '-' }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-4">No transactions found</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

