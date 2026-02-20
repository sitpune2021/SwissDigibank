@extends('layout.main')

@section('content')

<div class="container mx-auto px-4 py-6">

    <div class="flex justify-between items-center mb-4 print:hidden">
    <h2 class="text-xl font-bold">Day Book</h2>

   <div class="text-end mb-3 no-print">
        <button onclick="printBalanceSheet()" class="btn btn-dark  btn-primary">
            <i class="fa fa-print"></i> Print
        </button>
    </div>
</div>


    <form method="GET" class="mb-6 flex flex-wrap gap-3 items-center">

        <input type="date" name="date" value="{{ $date }}" 
            class="border rounded px-3 py-2">

        <select name="branch_id" class="border rounded px-3 py-2">
            <option value="">All Branch</option>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}" 
                    {{ $branchId == $branch->id ? 'selected' : '' }}>
                    {{ $branch->branch_name }}
                </option>
            @endforeach
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Filter
        </button>
    </form>


    <div class="w-full">

        <div class="flex flex-col lg:flex-row gap-6" id="printArea">

            {{-- OPENING --}}
            <div class="flex-1 bg-white shadow rounded-xl p-5 border">
                <h4 class="text-lg font-semibold mb-4">
                    OPENING ({{ \Carbon\Carbon::parse($date)->format('d/m/Y') }})
                </h4>

                @foreach($openingData as $ledger)
                    <div class="flex justify-between mb-2">
                        <span>{{ $ledger['name'] }}</span>
                        <span>₹ {{ number_format($ledger['amount'],2) }}</span>
                    </div>
                @endforeach
            </div>


            {{-- CURRENT / CLOSING --}}
            <div class="flex-1 bg-white shadow rounded-xl p-5 border">
                <h4 class="text-lg font-semibold mb-4">
                    CURRENT / CLOSING ({{ \Carbon\Carbon::parse($date)->format('d/m/Y') }})
                </h4>

                @foreach($closingData as $ledger)
                    <div class="flex justify-between mb-2">
                        <span>{{ $ledger['name'] }}</span>
                        <span>₹ {{ number_format($ledger['amount'],2) }}</span>
                    </div>
                @endforeach
            </div>


            {{-- DAY TRANSACTIONS --}}
            <div class="flex-1 bg-white shadow rounded-xl p-5 border">
                <h4 class="text-lg font-semibold mb-4">
                    DAY TRANSACTIONS
                </h4>

                @foreach($dayTxnData as $ledger)
                    <div class="flex justify-between mb-2">
                        <span>{{ $ledger['name'] }}</span>
                        <span>₹ {{ number_format($ledger['amount'],2) }}</span>
                    </div>
                @endforeach
            </div>

        </div>

    </div>


</div>

<script>
function printBalanceSheet() {

    var printContents = document.getElementById('printArea').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
    location.reload();
}
</script>

@endsection
