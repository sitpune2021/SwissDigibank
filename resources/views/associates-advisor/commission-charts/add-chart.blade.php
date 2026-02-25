@extends('layout.main')

@section('content')

    @php
        // detect edit mode
        $isEdit = isset($chart);
    @endphp

    <h1 class="text-lg uppercase font-semibold mb-4">
        {{ $isEdit ? 'Edit RD Commission Chart' : 'Add RD Commission Chart' }}
    </h1>
    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <form
            action="{{ $isEdit ? route('associates-advisor.commission-charts.update', $chart->id) : route('associates-advisor.commission-charts.store') }}"
            method="POST">

            @csrf
            @if($isEdit) @method('PUT') @endif

            <div class="grid grid-cols-2 md:grid-cols-3 gap-6  md-4">

                {{-- LEFT SIDE --}}
                <div class="col-span-2 md:col-span-1  dark:bg-bg3 rounded-2xl">

                    {{-- Chart Type --}}
                    <div class="mb-4">
                        <label class="font-medium">Chart Type</label>
                        <select id="chartType" name="chart_type"
                            class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3">
                            <option value="rd" {{ old('chart_type', $chart->chart_type ?? '') == 'rd' ? 'selected' : '' }}>RD
                            </option>
                            <option value="fd" {{ old('chart_type', $chart->chart_type ?? '') == 'fd' ? 'selected' : '' }}>FD
                            </option>
                            <option value="mis" {{ old('chart_type', $chart->chart_type ?? '') == 'mis' ? 'selected' : '' }}>
                                MIS
                            </option>
                            <option value="dd" {{ old('chart_type', $chart->chart_type ?? '') == 'dd' ? 'selected' : '' }}>
                                Daily
                                Deposit</option>
                        </select>
                    </div>

                    {{-- Payout Type --}}
                    <div class="mb-4">
                        <label class="font-medium">Payout Type</label>
                        <select id="payoutType" name="payout_type"
                            class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3">
                            <option value="">Select</option>
                            <option value="mlm" {{ old('payout_type', $chart->payout_type ?? '') == 'mlm' ? 'selected' : '' }}>MLM
                            </option>
                            <option value="flat" {{ old('payout_type', $chart->payout_type ?? '') == 'flat' ? 'selected' : '' }}>
                                FLAT</option>
                            <option value="flat_no_team_comm" {{ old('payout_type', $chart->payout_type ?? '') == 'flat_no_team_comm' ? 'selected' : '' }}>FLAT (No Team Commission)</option>
                        </select>
                    </div>

                    {{-- Chart Name --}}
                    <div class="mb-4">
                        <label class="font-medium">Chart Name</label>
                        <input type="text" name="chart_name"
                            class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3"
                            value="{{ old('chart_name', $chart->chart_name ?? '') }}" required>
                    </div>

                    {{-- Commission Type --}}
                    <div class="mb-4">
                        <label class="font-medium">Commission Type</label>
                        <select name="commission_type"
                            class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3">
                            <option value="percent" {{ old('commission_type', $chart->commission_type ?? '') == 'percent' ? 'selected' : '' }}>Percent</option>
                            <option value="inr" {{ old('commission_type', $chart->commission_type ?? '') == 'inr' ? 'selected' : '' }}>INR</option>
                        </select>
                    </div>

                    {{-- Tenure --}}
                    <div class="mb-4">
                        <label class="font-medium">Tenure (Months)</label>
                        <input type="number" name="tenure_months" min="1" max="99"
                            class="tenure-input w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3"
                            value="{{ old('tenure_months', $chart->tenure_months ?? 6) }}">
                    </div>




                </div>


                {{-- RIGHT SIDE INFO BOXES --}}
                <div class="col-span-2 md:col-span-1  dark:bg-bg3 rounded-2xl">

                    {{-- MLM --}}
                    <div id="mlmInfoBox" class="hidden p-4 border rounded bg-blue-50">
                        <strong class="block font-semibold">
                            MLM Payout Type:
                        </strong>

                        <p class="text-gray-700">
                            MLM payout is a multi-level payout system in which, a level commission pays distributors a
                            percentage earned from the sales of each level of Associate in their down-line.
                        </p>

                        <strong class="block font-semibold">For Example:</strong>

                        <p class="text-sm">
                            Suppose we have 6 Ranks & 3 Associate
                        </p>

                        <p class="text-sm">
                            <b>A</b> is at Highest Rank 1,
                            <b class="ml-2">B</b> is at Rank 4,
                            <b class="ml-2">C</b> is at Lowest Rank 6
                        </p>

                        <div class="flex flex-col md:flex-row gap-6">

                            <!-- Table -->
                            <div class="overflow-x-auto">
                                <table class="min-w-[250px] border border-gray-300 text-center text-sm">
                                    <thead class="bg-gray-100">
                                        <tr class="bg-secondary/5">
                                            <th class="border px-3 py-2">Rank</th>
                                            <th class="border px-3 py-2">Associate</th>
                                            <th class="border px-3 py-2">Incentive</th>
                                        </tr>
                                    </thead>

                                    <tbody class="[&>tr:nth-child(even)]:bg-gray-50">
                                        <tr>
                                            <td class="border px-3 py-2">1</td>
                                            <td class="border px-3 py-2">A</td>
                                            <td class="border px-3 py-2">1%</td>
                                        </tr>
                                        <tr>
                                            <td class="border px-3 py-2">2</td>
                                            <td class="border px-3 py-2">---</td>
                                            <td class="border px-3 py-2">1%</td>
                                        </tr>
                                        <tr>
                                            <td class="border px-3 py-2">3</td>
                                            <td class="border px-3 py-2">---</td>
                                            <td class="border px-3 py-2">1%</td>
                                        </tr>
                                        <tr>
                                            <td class="border px-3 py-2">4</td>
                                            <td class="border px-3 py-2">B</td>
                                            <td class="border px-3 py-2">1%</td>
                                        </tr>
                                        <tr>
                                            <td class="border px-3 py-2">5</td>
                                            <td class="border px-3 py-2">---</td>
                                            <td class="border px-3 py-2">1%</td>
                                        </tr>
                                        <tr>
                                            <td class="border px-3 py-2">6</td>
                                            <td class="border px-3 py-2">C</td>
                                            <td class="border px-3 py-2">1%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Explanation -->
                            <div class="text-sm space-y-2">
                                <p class="font-semibold">
                                    There are following scenarios for better understanding -
                                </p>

                                <ol class="list-decimal ml-5 space-y-2">
                                    <li>
                                        If <b>C</b> open the account. Then <b>C</b> will get <b>1%</b>
                                        incentive (Only for 6 rank level) & C's upper level associate
                                        <b>B</b> will get <b>2%</b> incentive (rank 5 & rank 4) &
                                        <b>A</b> will also get <b>3%</b> incentive (rank 3, rank 2, rank 1).
                                    </li>

                                    <li>
                                        If <b>B</b> open the account. Then <b>B</b> will get <b>3%</b>
                                        incentive (rank 6, rank 5 & rank 4 also) &
                                        <b>A</b> will get <b>3%</b> incentive (rank 3, rank 2, rank 1).
                                    </li>

                                    <li>
                                        If <b>A</b> open the account. Then <b>A</b> will get <b>6%</b>
                                        incentive (rank 6, 5, 4, 3, 2 & 1).
                                    </li>
                                </ol>
                            </div>

                        </div>

                    </div>

                    {{-- FLAT --}}
                    <div id="flatInfoBox" class="hidden p-4 border rounded bg-green-50">
                        <strong class="block font-semibold">
                            Flat Payout Type:
                        </strong>

                        <p class="text-gray-700">
                            In this payout only one level of associate will get commission.
                        </p>

                        <strong class="block font-semibold">For Example:</strong>

                        <p class="text-sm">
                            Suppose we have 6 Ranks & 3 Associate
                        </p>

                        <p class="text-sm">
                            <b>A</b> is at Highest Rank 1,
                            <b class="ml-2">B</b> is at Rank 4,
                            <b class="ml-2">C</b> is at Lowest Rank 6
                        </p>

                        <div class="flex flex-col md:flex-row gap-6">

                            <!-- Table -->
                            <div class="overflow-x-auto">
                                <table class="min-w-[250px] border border-gray-300 text-center text-sm">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="border px-3 py-2">Rank</th>
                                            <th class="border px-3 py-2">Associate</th>
                                            <th class="border px-3 py-2">Incentive</th>
                                        </tr>
                                    </thead>

                                    <tbody class="[&>tr:nth-child(even)]:bg-gray-50">
                                        <tr>
                                            <td class="border px-3 py-2">1</td>
                                            <td class="border px-3 py-2">A</td>
                                            <td class="border px-3 py-2">1%</td>
                                        </tr>
                                        <tr>
                                            <td class="border px-3 py-2">2</td>
                                            <td class="border px-3 py-2">---</td>
                                            <td class="border px-3 py-2">1%</td>
                                        </tr>
                                        <tr>
                                            <td class="border px-3 py-2">3</td>
                                            <td class="border px-3 py-2">---</td>
                                            <td class="border px-3 py-2">1%</td>
                                        </tr>
                                        <tr>
                                            <td class="border px-3 py-2">4</td>
                                            <td class="border px-3 py-2">B</td>
                                            <td class="border px-3 py-2">1%</td>
                                        </tr>
                                        <tr>
                                            <td class="border px-3 py-2">5</td>
                                            <td class="border px-3 py-2">---</td>
                                            <td class="border px-3 py-2">1%</td>
                                        </tr>
                                        <tr>
                                            <td class="border px-3 py-2">6</td>
                                            <td class="border px-3 py-2">C</td>
                                            <td class="border px-3 py-2">1%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Explanation -->
                            <div class="text-sm space-y-2">
                                <p class="font-semibold">
                                    There are following scenarios for better understanding -
                                </p>

                                <ol class="list-decimal ml-5 space-y-2" type="1">
                                    <li>
                                        If <b>C</b> open the account. Then <b>C</b> will get <b>1%</b>
                                        incentive (Only for 6 rank level) & C's upper level associate
                                        <b>B</b> & <b>A</b> will also get <b>1%</b> incentive
                                        (B rank 4 & A rank 1).
                                    </li>

                                    <li>
                                        If <b>B</b> open the account. Then <b>B</b> will get <b>1%</b>
                                        incentive (rank 4) & <b>A, C</b> will also get <b>1%</b>
                                        incentive.
                                    </li>

                                    <li>
                                        If any associate (in the team) open the account, each associate
                                        will get incentive according to the rank.
                                    </li>
                                </ol>
                            </div>

                        </div>
                    </div>

                    {{-- FLAT NO TEAM --}}
                    <div id="flatNoTeamInfoBox" class="hidden p-4 border rounded bg-red-50">
                        <strong class="block font-semibold">
                            Flat No Team Commission Payout Type:
                        </strong>

                        <p class="text-gray-700">
                            Under this payout type commission will give only same associate not others.
                        </p>

                        <strong class="block font-semibold">For Example:</strong>

                        <p class="text-sm">
                            Suppose we have 6 Ranks & 3 Associate
                        </p>

                        <p class="text-sm">
                            <b>A</b> is at Highest Rank 1,
                            <b class="ml-2">B</b> is at Rank 4,
                            <b class="ml-2">C</b> is at Lowest Rank 6
                        </p>

                        <div class="flex flex-col md:flex-row gap-6">

                            <!-- Table -->
                            <div class="overflow-x-auto">
                                <table class="min-w-[250px] border border-gray-300 text-center text-sm">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="border px-3 py-2">Rank</th>
                                            <th class="border px-3 py-2">Associate</th>
                                            <th class="border px-3 py-2">Incentive</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border px-3 py-2">1</td>
                                            <td class="border px-3 py-2">A</td>
                                            <td class="border px-3 py-2">1%</td>
                                        </tr>
                                        <tr>
                                            <td class="border px-3 py-2">2</td>
                                            <td class="border px-3 py-2">---</td>
                                            <td class="border px-3 py-2">1%</td>
                                        </tr>
                                        <tr>
                                            <td class="border px-3 py-2">3</td>
                                            <td class="border px-3 py-2">---</td>
                                            <td class="border px-3 py-2">1%</td>
                                        </tr>
                                        <tr>
                                            <td class="border px-3 py-2">4</td>
                                            <td class="border px-3 py-2">B</td>
                                            <td class="border px-3 py-2">1%</td>
                                        </tr>
                                        <tr>
                                            <td class="border px-3 py-2">5</td>
                                            <td class="border px-3 py-2">---</td>
                                            <td class="border px-3 py-2">1%</td>
                                        </tr>
                                        <tr>
                                            <td class="border px-3 py-2">6</td>
                                            <td class="border px-3 py-2">C</td>
                                            <td class="border px-3 py-2">1%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Explanation -->
                            <div class="text-sm space-y-2">
                                <p class="font-semibold">
                                    There are following scenarios for better understanding:
                                </p>

                                <ol class="list-decimal ml-5 space-y-2">
                                    <li>
                                        If <b>C</b> open the account. Then <b>C</b> will get <b>1%</b>
                                        incentive (Only for 6 rank level) & C's upper level associate
                                        <b>B</b> & <b>A</b> will get <b>0%</b> incentive.
                                    </li>

                                    <li>
                                        If <b>B</b> open the account. Then <b>B</b> will get <b>1%</b>
                                        incentive (rank 4). <b>A</b> & <b>C</b> will get <b>0%</b> incentive.
                                    </li>
                                </ol>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

            <div class=" overflow-x-auto mb-4 mt-5 ">
                <table class="w-full overflow-x-auto mb-4  commission-table">
                    <thead>
                        <tr class="bg-secondary/5">
                            <th class="py-3 text-start uppercase px-3">Rank</th>
                            <th class="py-3 text-center uppercase px-3">Months</th>
                        </tr>
                    </thead>

                    <tbody id="rankRows">

                        @foreach($rankData as $rankNo => $rankName)
                            @php
                                $rowValues = $isEdit ? ($rankValues[$rankName][0] ?? []) : [];
                            @endphp

                            <tr class="border-b rank-row" data-rank="{{ $rankNo }}">
                                <td class="p-2 font-medium uppercase">{{ $rankName }}</td>
                                <td class="p-2">
                                    <div class="flex gap-2 month-inputs" data-values='@json($rowValues)'>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>

                    {{-- TOTAL ROW --}}
                    <tfoot>
                        <tr id="totalRow" class="bg-yellow-100 font-bold">
                            <td class="p-2 font-semibold">TOTAL</td>
                            <td class="p-2 ">
                                <div class="flex gap-2 total-months font-semibold"></div>
                            </td>
                        </tr>

                        <tr id="collectionRow" class="bg-blue-100 font-bold">
                            <td class="p-2 font-semibold">COLLECTION CHARGE</td>
                            <td class="p-2">
                                <div class="flex gap-2 collection-months"
                                    data-values='@json($chart->rank_month_values["Collection Charge"][0] ?? [])'>
                                </div>

                            </td>
                        </tr>
                    </tfoot>

                </table>


            </div>
            <button class="mt-5 mb-3 btn-primary px-6 py-2  uppercase">
                {{ $isEdit ? 'Update Chart' : 'Save Chart' }}
            </button>
            {{-- RD TABLE --}}


        </form>

    </div>


    {{-- ========== JS ========== --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const tenureInput = document.querySelector(".tenure-input");

            function regenerateMonthInputs() {

                let tenure = parseInt(tenureInput.value) || 1;
                tenure = Math.min(Math.max(tenure, 1), 99);

                document.querySelectorAll(".rank-row").forEach(row => {
                    const container = row.querySelector(".month-inputs");
                    const rankNo = row.dataset.rank;

                    let oldValues = {};
                    try {
                        oldValues = JSON.parse(container.dataset.values || "{}");
                    } catch (e) { }

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
                try { oldCollection = JSON.parse(collectionBox.dataset.values || "{}"); } catch (e) { }

                collectionBox.innerHTML = "";

                for (let m = 1; m <= tenure; m++) {

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