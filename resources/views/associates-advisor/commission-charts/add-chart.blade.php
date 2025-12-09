@extends('layout.main')

@section('content')

@php
    // detect edit mode
    $isEdit = isset($chart);
@endphp

<div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">

    <h1 class="text-2xl font-bold mb-4">
        {{ $isEdit ? 'Edit RD Commission Chart' : 'Add RD Commission Chart' }}
    </h1>

    <form action="{{ $isEdit ? route('associates-advisor.commission-charts.update', $chart->id) : route('associates-advisor.commission-charts.store') }}"
          method="POST">

        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- LEFT SIDE --}}
            <div class="md:col-span-2">

                {{-- Chart Type --}}
                <div class="mb-4">
                    <label class="font-medium">Chart Type</label>
                    <select id="chartType" name="chart_type" class="w-full border px-3 py-2 rounded">
                        <option value="rd" {{ old('chart_type', $chart->chart_type ?? '')=='rd'?'selected':'' }}>RD</option>
                        <option value="fd" {{ old('chart_type', $chart->chart_type ?? '')=='fd'?'selected':'' }}>FD</option>
                        <option value="mis" {{ old('chart_type', $chart->chart_type ?? '')=='mis'?'selected':'' }}>MIS</option>
                        <option value="dd" {{ old('chart_type', $chart->chart_type ?? '')=='dd'?'selected':'' }}>Daily Deposit</option>
                    </select>
                </div>

                {{-- Payout Type --}}
                <div class="mb-4">
                    <label class="font-medium">Payout Type</label>
                    <select id="payoutType" name="payout_type" class="w-full border px-3 py-2 rounded">
                        <option value="">Select</option>
                        <option value="mlm"  {{ old('payout_type',$chart->payout_type ?? '')=='mlm'?'selected':'' }}>MLM</option>
                        <option value="flat" {{ old('payout_type',$chart->payout_type ?? '')=='flat'?'selected':'' }}>FLAT</option>
                        <option value="flat_no_team_comm" {{ old('payout_type',$chart->payout_type ?? '')=='flat_no_team_comm'?'selected':'' }}>FLAT (No Team Commission)</option>
                    </select>
                </div>

                {{-- Chart Name --}}
                <div class="mb-4">
                    <label class="font-medium">Chart Name</label>
                    <input type="text"
                        name="chart_name"
                        class="w-full border px-3 py-2 rounded"
                        value="{{ old('chart_name', $chart->chart_name ?? '') }}"
                        required>
                </div>

                {{-- Commission Type --}}
                <div class="mb-4">
                    <label class="font-medium">Commission Type</label>
                    <select name="commission_type" class="w-full border px-3 py-2 rounded">
                        <option value="percent" {{ old('commission_type',$chart->commission_type ?? '')=='percent'?'selected':'' }}>Percent</option>
                        <option value="inr"     {{ old('commission_type',$chart->commission_type ?? '')=='inr'?'selected':'' }}>INR</option>
                    </select>
                </div>

                {{-- Tenure --}}
                <div class="mb-4">
                    <label class="font-medium">Tenure (Months)</label>
                    <input type="number"
                        name="tenure_months"
                        min="1" max="99"
                        class="tenure-input w-full border px-3 py-2 rounded"
                        value="{{ old('tenure_months', $chart->tenure_months ?? 6) }}">
                </div>


                {{-- RD TABLE --}}
                <table class="w-full border text-sm commission-table">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2 w-48">Rank</th>
                            <th class="p-2">Months</th>
                        </tr>
                    </thead>

                    <tbody id="rankRows">

                        @foreach($rankData as $rankNo => $rankName)
                        @php
                            $rowValues = $isEdit ? ($rankValues[$rankName][0] ?? []) : [];
                        @endphp

                        <tr class="border-b rank-row" data-rank="{{ $rankNo }}">
                            <td class="p-2 font-medium">{{ $rankName }}</td>
                            <td class="p-2">
                                <div class="flex gap-2 month-inputs"
                                     data-values='@json($rowValues)'>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>

                    {{-- TOTAL ROW --}}
                    <tfoot>
    <tr id="totalRow" class="bg-yellow-100 font-bold">
        <td class="p-2">TOTAL</td>
        <td class="p-2">
            <div class="flex gap-2 total-months"></div>
        </td>
    </tr>

    <tr id="collectionRow" class="bg-blue-100 font-bold">
        <td class="p-2">COLLECTION CHARGE</td>
        <td class="p-2">
            <div class="flex gap-2 collection-months"
     data-values='@json($chart->rank_month_values["Collection Charge"][0] ?? [])'>
</div>

        </td>
    </tr>
</tfoot>

                </table>

                <button class="mt-5 bg-blue-600 text-white px-6 py-2 rounded">
                    {{ $isEdit ? 'Update Chart' : 'Save Chart' }}
                </button>

            </div>


            {{-- RIGHT SIDE INFO BOXES --}}
            <div>

                {{-- MLM --}}
                <div id="mlmInfoBox" class="hidden p-4 border rounded bg-blue-50">
                    <h3 class="font-bold text-lg mb-2">MLM Payout Type</h3>
                    <p class="text-sm mb-3">
                        MLM payout is a multi-level payout system where each level gets percentage based on downline sales.
                    </p>
                </div>

                {{-- FLAT --}}
                <div id="flatInfoBox" class="hidden p-4 border rounded bg-green-50">
                    <h3 class="font-bold text-lg mb-2">Flat Payout Type</h3>
                    <p class="text-sm mb-3">
                        In Flat payout, everyone in the team gets the same commission.
                    </p>
                </div>

                {{-- FLAT NO TEAM --}}
                <div id="flatNoTeamInfoBox" class="hidden p-4 border rounded bg-red-50">
                    <h3 class="font-bold text-lg mb-2">Flat No Team Commission</h3>
                    <p class="text-sm mb-3">
                        Only the associate who opens the account gets incentive.
                    </p>
                </div>

            </div>

        </div>

    </form>

</div>


{{-- ========== JS ========== --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {

    const tenureInput = document.querySelector(".tenure-input");

    function regenerateMonthInputs() 
    {

        let tenure = parseInt(tenureInput.value) || 1;
        tenure = Math.min(Math.max(tenure, 1), 99);

        document.querySelectorAll(".rank-row").forEach(row => {
            const container = row.querySelector(".month-inputs");
            const rankNo = row.dataset.rank;

            let oldValues = {};
            try {
                oldValues = JSON.parse(container.dataset.values || "{}");
            } catch(e){}

            container.innerHTML = "";

            for (let m = 1; m <= tenure; m++) {
                const val = oldValues[m] ?? "";

                container.innerHTML += `
                    <input type="number"
                        data-month="${m}"
                        class="month-input border p-1 w-20 rounded text-center"
                        name="rank[${rankNo}][${m}]"
                        value="${val}"
                        placeholder="${m}">
                `;
            }
        });

        // TOTAL ROW
        const totalBox = document.querySelector(".total-months");
        totalBox.innerHTML = "";

        for (let m = 1; m <= tenure; m++) {
            totalBox.innerHTML += `
                <input type="number"
                    data-month-total="${m}"
                    class="border p-1 w-20 rounded bg-yellow-50 font-bold text-center"
                    readonly>
            `;
        }

        // COLLECTION ROW — add this block RIGHT HERE
        const collectionBox = document.querySelector(".collection-months");

        let oldCollection = {};
        try { oldCollection = JSON.parse(collectionBox.dataset.values || "{}"); } catch(e){}

        collectionBox.innerHTML = "";

        for (let m = 1; m <= tenure; m++) 
        {

            const val = oldCollection[m] ?? "";

            collectionBox.innerHTML += `
                <input type="number"
                    data-month-collection="${m}"
                    class="border p-1 w-20 rounded bg-blue-50 font-bold text-center"
                    name="collection[${m}]"
                    value="${val}"
                    placeholder="${m}">
            `;
        }

        attachTotalCalculator();
    }

    // TOTAL CALC
    function attachTotalCalculator() {
        document.querySelectorAll(".month-input").forEach(inp => {
            inp.addEventListener("input", calculateTotals);
        });
        calculateTotals();
    }

    function calculateTotals() {
        const tenure = parseInt(tenureInput.value) || 1;

        for (let month = 1; month <= tenure; month++) {
            let sum = 0;
            document.querySelectorAll(`input[data-month="${month}"]`)
                .forEach(inp => {
                    sum += parseFloat(inp.value) || 0;
                });

            const totalInput = document.querySelector(`input[data-month-total="${month}"]`);
            if (totalInput) totalInput.value = sum;
        }
    }

    regenerateMonthInputs();
    tenureInput.addEventListener("input", regenerateMonthInputs);

    // INFO BOXES
    const chartType = document.getElementById("chartType");
    const payoutType = document.getElementById("payoutType");

    const mlm = document.getElementById("mlmInfoBox");
    const flat = document.getElementById("flatInfoBox");
    const flatNoTeam = document.getElementById("flatNoTeamInfoBox");

    function toggleBoxes() {
        mlm.classList.add("hidden");
        flat.classList.add("hidden");
        flatNoTeam.classList.add("hidden");

        if (chartType.value !== "rd") return;

        if (payoutType.value === "mlm") mlm.classList.remove("hidden");
        if (payoutType.value === "flat") flat.classList.remove("hidden");
        if (payoutType.value === "flat_no_team_comm") flatNoTeam.classList.remove("hidden");
    }

    payoutType.addEventListener("change", toggleBoxes);
    chartType.addEventListener("change", toggleBoxes);
    toggleBoxes();
});
</script>

@endsection
