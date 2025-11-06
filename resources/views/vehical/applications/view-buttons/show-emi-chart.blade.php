@extends('layout.main')
@section('content')

<style>
    input[type="checkbox"] {
        width: 28px;
        height: 28px;
        accent-color: green;
    }

    input[type="checkbox"]:checked {
        background-color: green;
        border: none;
    }

    input[type="radio"] {
        width: 24px;
        height: 24px;
        accent-color: green;
    }
</style>

<div class="main-inner box">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-2xl font-semibold">
                Vehical Loan - EMI Chart </h1>
        </div>
    </div>
    
   
<div class="container mx-auto p-6">
    <div class="loan-info mb-6 p-4 rounded-lg shadow" style="background-color: #f9fafb;">
    <h2 class="text-lg font-semibold uppercase border-b pb-2 mb-3" style="color:#374151;">
       <center>Loan Information</center> 
    </h2>

    <div class="info-grid ">

       <div class="grid grid-cols-2 border-b border-gray-400">
            <div class="label p-2 font-semibold bg-gray-50 border-r border-gray-400">Disburse Date</div>
            <div class="value p-2">
                {{ \Carbon\Carbon::parse($application->disbursal_date ?? $disburseDate)->format('d/m/Y') }}
            </div>
        </div>

        <div class="grid grid-cols-2 border-b border-gray-400">
            <div class="label p-2 font-semibold bg-gray-50 border-r border-gray-400">Loan Amount</div>
            <div class="value p-2">₹ {{ number_format($loanAmount, 2) }}</div>
        </div>

        <div class="grid grid-cols-2 border-b border-gray-400">
            <div class="label p-2 font-semibold bg-gray-50 border-r border-gray-400">Processing Fee</div>
            <div class="value p-2">₹ {{ number_format($processingFeeInc, 2) }} (Incl. GST)</div>
        </div>

        <div class="grid grid-cols-2 border-b border-gray-400">
            <div class="label p-2 font-semibold bg-gray-50 border-r border-gray-400">Stamp Duty Fee</div>
            <div class="value p-2">₹ {{ number_format($stampDutyInc, 2) }} (Incl. GST)</div>
        </div>

        <div class="grid grid-cols-2 border-b border-gray-400">
            <div class="label p-2 font-semibold bg-gray-50 border-r border-gray-400">Insurance Charges</div>
            <div class="value p-2">₹ {{ number_format($insuranceInc, 2) }} (Incl. GST)</div>
        </div>

        <div class="grid grid-cols-2 border-b border-gray-400">
            <div class="label p-2 font-semibold bg-gray-50 border-r border-gray-400">Interest Type</div>
            <div class="value p-2">
                @php
                    $interestTypeLabel = [
                        'reducing_emi' => 'Reducing EMI',
                        'flat_emi' => 'Flat EMI',
                        'flat_advanced_interest' => 'Flat Advanced Interest',
                        'no_emi' => 'No EMI',
                    ][$application->scheme->gold_loan_setting ?? 'flat_emi'];
                @endphp
                {{ $interestTypeLabel }}
            </div>
        </div>

        <div class="grid grid-cols-2 border-b border-gray-400">
            <div class="label p-2 font-semibold bg-gray-50 border-r border-gray-400">EMI Count</div>
            <div class="value p-2">{{ $tenure }}</div>
        </div>

        <div class="grid grid-cols-2 border-b border-gray-400">
            <div class="label p-2 font-semibold bg-gray-50 border-r border-gray-400">EMI Payout</div>
            <div class="value p-2">{{ ucfirst($periodName) }}</div>
        </div>

        <div class="grid grid-cols-2">
            <div class="label p-2 font-semibold bg-gray-50 border-r border-gray-400">Total Interest</div>
            <div class="value p-2">₹ {{ number_format($totalInterest, 2) }}</div>
        </div>

        <div class="grid grid-cols-2">
            <div class="label p-2 font-semibold bg-gray-50 border-r border-gray-400">Total EMI Amount</div>
            <div class="value p-2">₹ {{ number_format($totalEmi, 2) }}</div>
        </div>

    </div>
</div>

<style>
.info-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px 16px;
}

.label {
    font-weight: 600;
    color: #4b5563;
}

.value {
    font-weight: 700;
    color: #111827;
}

/* Mobile responsive 2 columns */
@media (max-width: 640px) {
    .info-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>


    <div class="mt-6">
        <h3 class="text-lg font-semibold"><center>EMI Chart</center></h3>
        <div class="overflow-x-auto mt-3">
            <table class="min-w-full border-collapse border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-2 py-1">EMI NO</th>
                        <th class="border px-2 py-1">EMI DATE</th>
                        <th class="border px-2 py-1">DUE DATE</th>
                        <th class="border px-2 py-1">PRINCIPAL (A)</th>
                        <th class="border px-2 py-1">INTEREST (B)</th>
                        <th class="border px-2 py-1">CHARGES PER EMI (C)</th>
                        <th class="border px-2 py-1">EMI (A + B + C)</th>
                        <th class="border px-2 py-1">BAL. PRINCIPAL</th>
                    </tr>
                </thead>

                <!-- Ye New Row Yaha Add Karni Thi -->
                <tbody>
                    <tr class="bg-blue-50 font-semibold">
                        <td colspan="7" class="border px-2 py-2 text-right">Starting Balance</td>
                        <td class="border px-2 py-2 text-right">₹ {{ number_format($loanAmount, 2) }}</td>
                    </tr>

                    @foreach($schedule as $row)
                    <tr>
                        <td class="border px-2 py-1 text-center">{{ $row['no'] }}</td>
                        <td class="border px-2 py-1 text-center">{{ $row['emi_date'] }}</td>
                        <td class="border px-2 py-1 text-center">{{ $row['due_date'] }}</td>
                        <td class="border px-2 py-1 text-right">₹ {{ $row['principal'] }}</td>
                        <td class="border px-2 py-1 text-right">₹ {{ $row['interest'] }}</td>
                        <td class="border px-2 py-1 text-right">₹ {{ $row['charges_per_emi'] }}</td>
                        <td class="border px-2 py-1 text-right">₹ {{ $row['emi'] }}</td>
                        <td class="border px-2 py-1 text-right">₹ {{ $row['bal_principal'] }}</td>
                    </tr>
                    @endforeach
                </tbody>

                <tfoot class="font-semibold" style="color: blueviolet;">
                    <tr>
                        <td colspan="3" class="border px-2 py-1 text-right">TOTAL</td>
                        <td class="border px-2 py-1 text-right">{{ number_format($totalPrincipal,2) }}</td>
                        <td class="border px-2 py-1 text-right">{{ number_format($totalInterest,2) }}</td>
                        <td class="border px-2 py-1 text-right">{{ number_format($totalCharges,2) }}</td>
                        <td class="border px-2 py-1 text-right">{{ number_format($totalEmi,2) }}</td>
                        <td class="border px-2 py-1 text-right"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- <div class="mt-6 flex gap-3">
        <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded">Print</button>
        <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-200 rounded">Back</a>
    </div> -->
</div>
@endsection

