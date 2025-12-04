@extends('layout.main')

<style>
    .breadcrumb {
        list-style: none;
        display: flex;
        padding: 0;
        margin-bottom: 1rem;
        font-size: 14px;
    }

    .breadcrumb li+li::before {
        content: "/";
        padding: 0 8px;
        color: #888;
    }

    .breadcrumb li a {
        text-decoration: none;
        color: #007bff;
    }

    .breadcrumb li.active {
        color: #555;
    }

    .custom-thead {
        background-color: #e6f4ea;
        color: #14532d;
    }

    .custom-thead th {
        font-weight: 600;
        border-bottom: 1px solid #ccc;
    }

    @media (prefers-color-scheme: dark) {
        .custom-thead {
            background-color: #14532d;
            color: #d1fae5;
        }
    }

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

@section('content')

<style>
.tab.hidden {
    display: block !important;
    visibility: hidden !important;
    height: 0 !important;
    overflow: hidden !important;
}
</style>


    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col  gap-2">
                <div class="flex items-center gap-3">
                    <h3 class="text-xl font-semibold uppercase">
                        New Commission Chart
                    </h3>
                </div>
            </div>
        </div>

        <!-- <form action="{{ route('associates-advisor.commission-charts.store') }}" method="POST">
            @csrf -->

            @if(isset($chart))
                <form action="{{ route('associates-advisor.commission-charts.update', $chart->id) }}" method="POST">
                @method('PUT')
            @else
                <form action="{{ route('associates-advisor.commission-charts.store') }}" method="POST">
            @endif
                @csrf

            <!-- rest of fields -->

            <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">
                <div class="box col-span-2 md:col-span-1">
                    <div class=" dark:bg-bg3  mb-4 ">

                        <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Chart Type
                                <span class="text-red-500">*</span>
                            </label>
                            <select name="chart_type" id="chart_type"
                                class=" scheme-select w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                                <option value="" class="opt-default">Please Select</option>
                                <option value="rd" data-tab="rd" {{ (old('chart_type', $chart->chart_type ?? '') == 'rd') ? 'selected' : '' }} data-tab="rd">Recurring Deposit (RD) (Installment Based Incentive)
                                </option>
                                <option value="dd" data-tab="dd" {{ (old('chart_type', $chart->chart_type ?? '') == 'dd') ? 'selected' : '' }} data-tab="dd">Daily Deposit (DD) (Installment Based Incentive)</option>
                                <option value="fd_one" data-tab="fd_one" {{ (old('chart_type', $chart->chart_type ?? '') == 'fd_one') ? 'selected' : '' }} data-tab="fd_one">Fixed Deposit (FD) (One Time Incentive)</option>
                                <option value="fd_payout" data-tab="fd_payout" {{ (old('chart_type', $chart->chart_type ?? '') == 'fd_payout') ? 'selected' : '' }} data-tab="fd_payout">Fixed Deposit (FD) (Payout Based Incentive)
                                </option>
                                <option value="mis_one" data-tab="mis_one" {{ (old('chart_type', $chart->chart_type ?? '') == 'mis_one') ? 'selected' : '' }} data-tab="mis_one">Monthly Income Scheme (MIS) (One Time Incentive)
                                </option>
                                <option value="mis_payout" data-tab="mis_payout" {{ (old('chart_type', $chart->chart_type ?? '') == 'mis_payout') ? 'selected' : '' }} data-tab="mis_payout">Monthly Income Scheme (MIS) (Payout Based
                                    Incentive)</option>
                                <option value="saving" data-tab="saving" {{ (old('chart_type', $chart->chart_type ?? '') == 'saving') ? 'selected' : '' }} data-tab="saving">Saving Account (Opening Incentive)</option>
                            </select>
                        </div>

                        <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Chart Name
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" name="chart_name" id="chart_name" value="{{ old('chart_name', $chart->chart_name ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                placeholder="Enter Name">
                        </div>

                        <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Payout Type
                                <span class="text-red-500">*</span>
                            </label>

                            <select name="payout_type"
                                class="commission-mode w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                <option value="">Please Select</option>
                                <option value="MLM" {{ old('payout_type', $chart->payout_type ?? '') == 'MLM' ? 'selected' : '' }}>MLM</option>
                                <option value="FLAT" {{ old('payout_type', $chart->payout_type ?? '') == 'FLAT' ? 'selected' : '' }}>FLAT</option>
                                <option value="FLAT_NO_TEAM_COMM" {{ old('payout_type', $chart->payout_type ?? '') == 'FLAT_NO_TEAM_COMM' ? 'selected' : '' }}>FLAT_NO_TEAM_COMM</option>
                            </select>
                        </div>

                        <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Commission Type
                                <span class="text-red-500">*</span>
                            </label>

                            <select name="commission_type" class="commission-type">
                                <option value="percent" {{ old('commission_type', $chart->commission_type ?? '') == 'percent' ? 'selected' : '' }}>(%)</option>
                                <option value="inr" {{ old('commission_type', $chart->commission_type ?? '') == 'inr' ? 'selected' : '' }}>INR</option>
                            </select>
                        </div>

                        <div class="w-full mt-4">
                            <label class="block font-medium uppercase mb-2">
                                Tenure (Months)
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="tenure_months" value="{{ old('tenure_months', $chart->tenure_months ?? 6) }}"
                                class="tenure-input w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="0" min="1" max="99" value="6" />
                        </div>

                        <!-- Buttons -->
                        <div class="flex   min-w-10 sm:flex-row justify-center gap-3 mt-5">
                            <div class="">
                                <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                                    Regenerate Commission
                                </button>
                            </div>

                            <div class="">
                                <button class="btn-outline uppercase justify-center" type="reset">
                                    <a href="{{ route('associates-advisor.commission-charts.index') }}"> BACK</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box col-span-2 md:col-span-1 ">
                    <div class="tab-content mt-4">
                        <div class="tab-content mt-4">
                            <div class="tab tab-rd hidden"></div>
                            <div class="tab tab-dd hidden"></div>
                            <div class="tab tab-fd_one hidden">
                                <strong class="block text-lg font-semibold mb-2">One Time Incentive:</strong>
                                <p class="mb-4 text-gray-700 dark:text-gray-300">
                                    This is per account open or maturity based incentive payout according to commission
                                    chart.
                                </p>
                            </div>
                            <div class="tab tab-fd_payout hidden">
                                <strong class="block text-lg font-semibold mb-2">Payout Based Incentive:</strong>
                                <p class="mb-4 text-gray-700 dark:text-gray-300">
                                    This is per interest payout based incentive payout according to commission chart.
                                </p>
                            </div>
                            <div class="tab tab-mis_one hidden">
                                <strong class="block text-lg font-semibold mb-2">One Time Incentive:</strong>
                                <p class="mb-4 text-gray-700 dark:text-gray-300">
                                    his is per account open or maturity based incentive payout according to commission
                                    chart.
                                </p>
                            </div>
                            <div class="tab tab-mis_payout hidden">
                                <strong class="block text-lg font-semibold mb-2">Payout Based Incentive:</strong>
                                <p class="mb-4 text-gray-700 dark:text-gray-300">
                                    This is per interest payout based incentive payout according to commission chart.
                                </p>
                            </div>
                            <div class="tab tab-saving hidden">
                                <strong class="block text-lg font-semibold mb-2">Account Opening Incentive:</strong>
                                <p class="mb-4 text-gray-700 dark:text-gray-300">
                                    This is one time incentive payout according to commission chart when Saving Account
                                    Open.
                                </p>
                            </div>
                        </div>
                        <div class="tab-panel" data-tab="MLM">
                            <div class="col-span-6 md:col-span-6 space-y-4">
                                <!-- MLM Payout Section -->

                                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg">
                                    <strong class="block text-lg font-semibold mb-2">MLM Payout Type:</strong>
                                    <p class="mb-4 text-gray-700 dark:text-gray-300">
                                        MLM payout is a multi-level payout system in which a level commission pays
                                        distributors a percentage earned from the sales of each level of Associate in their
                                        down-line.
                                    </p>

                                    <strong class="block text-md font-semibold mb-2">For Example:</strong>
                                    <p class="mb-4 text-gray-700 dark:text-gray-300">
                                        Suppose we have 6 Ranks &amp; 3 Associates<br>
                                        <b>A</b> is at Highest Rank 1, &nbsp; <b>B</b> is at Rank 4, &nbsp; <b>C</b> is at
                                        Lowest Rank 6
                                    </p>

                                    <div class="overflow-x-auto">
                                        <table class="min-w-full border border-gray-300 text-center text-sm table-auto">
                                            <tbody>
                                                <tr>
                                                    <!-- Main table -->
                                                    <td class="align-top">
                                                        <table
                                                            class="min-w-full border border-gray-300 table-auto text-center">
                                                            <thead class="bg-gray-100 dark:bg-gray-700">
                                                                <tr>
                                                                    <th class="border px-2 py-1">Rank</th>
                                                                    <th class="border px-2 py-1">Associate</th>
                                                                    <th class="border px-2 py-1">Incentive</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="border px-2 py-1">1</td>
                                                                    <td class="border px-2 py-1">A</td>
                                                                    <td class="border px-2 py-1">1%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="border px-2 py-1">2</td>
                                                                    <td class="border px-2 py-1">---</td>
                                                                    <td class="border px-2 py-1">1%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="border px-2 py-1">3</td>
                                                                    <td class="border px-2 py-1">---</td>
                                                                    <td class="border px-2 py-1">1%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="border px-2 py-1">4</td>
                                                                    <td class="border px-2 py-1">B</td>
                                                                    <td class="border px-2 py-1">1%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="border px-2 py-1">5</td>
                                                                    <td class="border px-2 py-1">---</td>
                                                                    <td class="border px-2 py-1">1%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="border px-2 py-1">6</td>
                                                                    <td class="border px-2 py-1">C</td>
                                                                    <td class="border px-2 py-1">1%</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>

                                                    <!-- Empty cells for spacing -->
                                                    <td class="px-4"></td>

                                                    <!-- Scenarios list -->
                                                    <td class="align-top text-start px-4">
                                                        <ol
                                                            class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                                            <b>There are following scenarios for better understanding:</b>
                                                            <li>
                                                                If <b>C</b> opens the account, <b>C</b> will get <b>1%</b>
                                                                incentive (Only for 6 rank level), <b>B</b> will get
                                                                <b>2%</b> incentive (rank 5 &amp; rank 4), and <b>A</b> will
                                                                get <b>3%</b> incentive (rank 3, rank 2, rank 1).
                                                            </li>
                                                            <li>
                                                                If <b>B</b> opens the account, <b>B</b> will get <b>3%</b>
                                                                incentive (rank 6, 5 &amp; 4 also), and <b>A</b> will get
                                                                <b>3%</b> incentive (rank 3, 2 &amp; 1).
                                                            </li>
                                                            <li>
                                                                If <b>A</b> opens the account, <b>A</b> will get <b>6%</b>
                                                                incentive (rank 6, 5, 4, 3, 2 &amp; 1).
                                                            </li>
                                                        </ol>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="tab-panel hidden" data-tab="FLAT">
                            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg  space-y-4">
                                <!-- Section Heading -->
                                <strong class="block text-lg font-semibold">Flat Payout Type:</strong>
                                <p class="text-gray-700 dark:text-gray-300">
                                    In this payout, only one level of associate will get commission.
                                </p>

                                <strong class="block text-md font-semibold">For Example:</strong>
                                <p class="text-gray-700 dark:text-gray-300 mb-4">
                                    Suppose we have 6 Ranks &amp; 3 Associates<br>
                                    <b>A</b> is at Highest Rank 1, &nbsp; <b>B</b> is at Rank 4, &nbsp; <b>C</b> is at
                                    Lowest Rank 6
                                </p>

                                <div class="overflow-x-auto">
                                    <table class="min-w-full border border-gray-300 table-auto text-center">
                                        <tbody>
                                            <tr>
                                                <!-- Main Table -->
                                                <td class="align-top">
                                                    <table class="min-w-full border border-gray-300 table-auto text-center">
                                                        <thead class="bg-gray-100 dark:bg-gray-700">
                                                            <tr>
                                                                <th class="border px-2 py-1">Rank</th>
                                                                <th class="border px-2 py-1">Associate</th>
                                                                <th class="border px-2 py-1">Incentive</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="border px-2 py-1">1</td>
                                                                <td class="border px-2 py-1">A</td>
                                                                <td class="border px-2 py-1">1%</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="border px-2 py-1">2</td>
                                                                <td class="border px-2 py-1">---</td>
                                                                <td class="border px-2 py-1">1%</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="border px-2 py-1">3</td>
                                                                <td class="border px-2 py-1">---</td>
                                                                <td class="border px-2 py-1">1%</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="border px-2 py-1">4</td>
                                                                <td class="border px-2 py-1">B</td>
                                                                <td class="border px-2 py-1">1%</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="border px-2 py-1">5</td>
                                                                <td class="border px-2 py-1">---</td>
                                                                <td class="border px-2 py-1">1%</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="border px-2 py-1">6</td>
                                                                <td class="border px-2 py-1">C</td>
                                                                <td class="border px-2 py-1">1%</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>

                                                <!-- Empty spacing cell -->
                                                <td class="px-4"></td>

                                                <!-- Scenario list -->
                                                <td class="align-top text-start px-4">
                                                    <ol
                                                        class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                                        <b>There are following scenarios for better understanding:</b>
                                                        <li>
                                                            If <b>C</b> opens the account, <b>C</b> will get <b>1%</b>
                                                            incentive (only for 6 rank level), &amp; C's upper level
                                                            associates <b>B</b> &amp; <b>A</b> will also get <b>1%</b>
                                                            incentive (B rank 4 &amp; A rank 1).
                                                        </li>
                                                        <li>
                                                            If <b>B</b> opens the account, <b>B</b> will get <b>1%</b>
                                                            incentive (rank 4), &amp; <b>A, C</b> will also get <b>1%</b>
                                                            incentive.
                                                        </li>
                                                        <li>
                                                            If any associate (in the team) opens the account, each associate
                                                            will get incentive according to their rank.
                                                        </li>
                                                    </ol>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-panel hidden" data-tab="FLAT_NO_TEAM_COMM">
                            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg  space-y-4">
                                <!-- Section Heading -->
                                <strong class="block text-lg font-semibold">Flat No Team Commission Payout Type:</strong>
                                <p class="text-gray-700 dark:text-gray-300">
                                    Under this payout type, commission will be given only to the same associate, not others.
                                </p>

                                <strong class="block text-md font-semibold">For Example:</strong>
                                <p class="text-gray-700 dark:text-gray-300 mb-4">
                                    Suppose we have 6 Ranks &amp; 3 Associates<br>
                                    <b>A</b> is at Highest Rank 1, &nbsp; <b>B</b> is at Rank 4, &nbsp; <b>C</b> is at
                                    Lowest Rank 6
                                </p>

                                <div class="overflow-x-auto">
                                    <table class="min-w-full border border-gray-300 table-auto text-center">
                                        <tbody>
                                            <tr>
                                                <!-- Main table -->
                                                <td class="align-top">
                                                    <table class="min-w-full border border-gray-300 table-auto text-center">
                                                        <thead class="bg-gray-100 dark:bg-gray-700">
                                                            <tr>
                                                                <th class="border px-2 py-1">Rank</th>
                                                                <th class="border px-2 py-1">Associate</th>
                                                                <th class="border px-2 py-1">Incentive</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="border px-2 py-1">1</td>
                                                                <td class="border px-2 py-1">A</td>
                                                                <td class="border px-2 py-1">1%</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="border px-2 py-1">2</td>
                                                                <td class="border px-2 py-1">---</td>
                                                                <td class="border px-2 py-1">1%</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="border px-2 py-1">3</td>
                                                                <td class="border px-2 py-1">---</td>
                                                                <td class="border px-2 py-1">1%</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="border px-2 py-1">4</td>
                                                                <td class="border px-2 py-1">B</td>
                                                                <td class="border px-2 py-1">1%</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="border px-2 py-1">5</td>
                                                                <td class="border px-2 py-1">---</td>
                                                                <td class="border px-2 py-1">1%</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="border px-2 py-1">6</td>
                                                                <td class="border px-2 py-1">C</td>
                                                                <td class="border px-2 py-1">1%</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>

                                                <!-- Empty spacing cell -->
                                                <td class="px-4"></td>

                                                <!-- Scenario list -->
                                                <td class="align-top text-start px-4">
                                                    <ol
                                                        class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                                        <b>There are following scenarios for better understanding:</b>
                                                        <li>
                                                            If <b>C</b> opens the account, <b>C</b> will get <b>1%</b>
                                                            incentive (only for 6 rank level), &amp; C's upper level
                                                            associates <b>B</b> &amp; <b>A</b> will get <b>0%</b> incentive.
                                                        </li>
                                                        <li>
                                                            If <b>B</b> opens the account, <b>B</b> will get <b>1%</b>
                                                            incentive (rank 4), &amp; <b>A</b> &amp; <b>C</b> will get
                                                            <b>0%</b> incentive.
                                                        </li>
                                                    </ol>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="w-full box mt-5">
                <div class="rounded-10">
                                                    
                    <div id="rd" class="tab p-4 bg-gray-100 rounded-10 mt-4">
                        
                        @php
                        // ensure variables exist
                        // if controller passes $chart, use its tenure_months; otherwise default 6
                         $months = isset($chart) ? (int) $chart->tenure_months : 6;

                        // rankValues might be passed from controller; ensure it's an array
                        $rankValues = $rankValues ?? [];

                        // rankData should be passed from controller; if not, provide fallback
                        $rankData = $rankData ?? [
                            1  => "Field Head Officer",
                            2  => "Field Officer",
                            3  => "Relationship Manager",
                            4  => "Relationship Manager",
                            5  => "Area Relationship Manager",
                            6  => "Regional Relationship Manager",
                            7  => "Field Manager",
                            8  => "Field Associate",
                            9  => "Field Executive",
                            10 => "Sales Officer",
                            11 => "Field Organizer",
                            12 => "Field Associate",
                            13 => "Field Officer",
                            14 => "Adviser",
                            15 => "Sales Manager",
                            16 => "DEL Officer",
                            17 => "Asst Dev Officer",
                            18 => "Sales Officer",
                            19 => "Asst Sales Officer",
                            20 => "C Director",
                            // optionally collection charge can be handled separately
                        ];
                        @endphp

                        <div class="w-full mt-4 overflow-x-auto ">
                            <table class="w-full border-collapse whitespace-nowrap text-sm commission-table">
                                <thead>
                                    <tr class="months-header bg-secondary/5 border-b dark:bg-bg3">
                                        <th class="text-center text-lg !py-5 px-6 min-w-[100px]">#</th>
                                        <th class="text-center text-lg !py-5 px-6 min-w-[200px]">RANK</th>

                                        {{-- Dynamic Month Headings --}}                                       
                                        @for($i = 1; $i <= $months; $i++)
                                            <th class="month-th text-center text-lg !py-5 px-6 min-w-[80px]"> {{ $i }} M </th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($rankData as $id => $title)
                                        @php
                                            // $rankValues is stored as: [ "Rank Name" => [ { month map }, { total } ], ... ]
                                            $rowValues = $rankValues[$title][0] ?? []; // first index is month map
                                        @endphp

                                        <tr class="months-row {{ $id == 21 ? 'collection-charge-row' : '' }}" data-rank="{{ $id }}">
                                            <td>
                                                <input type="text" name="rank_no[{{ $id }}]" value="{{ $id }}" readonly>
                                            </td>

                                            <td>
                                                <input type="text" name="rank_name[{{ $id }}]" value="{{ $title }}" readonly>
                                            </td>

                                            {{-- Month wise inputs --}}
                                            @for($m = 1; $m <= $months; $m++)
                                                <td>
                                                    <input type="number"
                                                        name="rank[{{ $id }}][{{ $m }}]"
                                                        class="month-input border p-2 rounded w-20"
                                                        value="{{ $rowValues[$m] ?? '' }}">
                                                </td>
                                            @endfor
                                        </tr>
                                    @endforeach

                                    {{-- TOTAL ROW --}}
                                    <tr class="months-row total-row bg-green-100 font-bold" data-rank="total">
                                        <td class="px-6 text-center">#</td>
                                        <td class="px-6 text-center">TOTAL</td>

                                        {{-- total placeholders (will be filled by JS) --}}
                                        @for($m = 1; $m <= $months; $m++)
                                            <td><input type="text" readonly name="rank[total][{{ $m }}]" class="px-3 border py-1 bg-gray-200 text-center"></td>
                                        @endfor
                                    </tr>

                                    {{-- COLLECTION CHARGE ROW (if you want to include in UI for RD) --}}
                                    <tr class="months-row collection-row border-b {{ in_array(isset($chart) ? $chart->chart_type : '', ['rd','dd']) ? '' : 'hidden' }}" data-rank="collection_charge">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="CC" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="COLLECTION CHARGE" disabled class="invoice_input text-center">
                                        </td>

                                        @php
                                            $collectionValues = $rankValues['COLLECTION CHARGE'][0] ?? []; // may be stored as this
                                        @endphp

                                        @for($m = 1; $m <= $months; $m++)
                                            <td class="px-6">
                                                <input type="text" name="rank[collection_charge][{{ $m }}]" placeholder="percent" class="px-3 border py-1 text-center" value="{{ $collectionValues[$m] ?? '' }}">
                                            </td>
                                        @endfor
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div id="dd" class="tab hidden p-4 bg-gray-100 rounded-10 mt-4">

                        @php
                            // Safe fallback (ADD mode me chart null hota hai)
                            $months = isset($chart) && isset($chart->tenure_months) ? $chart->tenure_months : 6;
                            $commissionSymbol = isset($chart) && $chart->commission_type === 'inr' ? '₹' : '%';

                            // Auto TOTAL array
                            $autoTotals = array_fill(1, $months, 0);

                            // Old saved values (edit mode only)
                            $existingChart = $existingChart ?? [];
                        @endphp

                        <div class="w-full mt-4 overflow-x-auto">
                            <table class="w-full border-collapse whitespace-nowrap text-sm commission-table">
                                <thead>
                                    <tr class="months-header bg-secondary/5 border-b dark:bg-bg3">
                                        <th class="text-start !py-5 px-6 min-w-[100px]">#</th>
                                        <th class="text-start !py-5 px-6 min-w-[150px]">RANK / MONTHS</th>

                                        {{-- AUTO GENERATE MONTH HEADERS --}}
                                        @for ($m = 1; $m <= $months; $m++)
                                            <th class="text-start !py-5 px-6">M{{ $m }}</th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>

                                    {{-- ALL RANK ROWS --}}
                                    @foreach($rankData as $id => $title)

                                        @php
                                            $rowValues = $existingChart[$id] ?? []; // OLD SAVED VALUES
                                        @endphp

                                        <tr class="months-row {{ $id == 21 ? 'collection-charge-row bg-yellow-100' : '' }}"
                                            data-rank="{{ $id }}">

                                            <td class="px-6">{{ $id }}</td>

                                            <td class="px-6 uppercase">
                                                {{ $title }}
                                            </td>

                                            {{-- MONTH INPUT BOXES --}}
                                            @for ($m = 1; $m <= $months; $m++)
                                                <td class="px-6">
                                                    <input type="number"
                                                        name="rank[{{ $id }}][{{ $m }}]"
                                                        value="{{ $rowValues[$m] ?? '' }}"
                                                        class="month-input border p-2 rounded w-20 text-right">
                                                </td>
                                            @endfor
                                        </tr>

                                    @endforeach

                                    {{-- TOTAL ROW --}}
                                    <tr class="months-row total-row bg-green-100 font-bold" data-rank="total">
                                        <td class="px-6">#</td>
                                        <td class="px-6 uppercase">TOTAL</td>

                                        @for ($m = 1; $m <= $months; $m++)
                                            <td class="px-6 total-col" data-month="{{ $m }}">
                                                0 {{ $commissionSymbol }}
                                            </td>
                                        @endfor
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>


                    <div id="fd_one" class="tab hidden p-4 bg-gray-100 rounded-10 mt-4">

                        @php
                            // Safe fallback (ADD mode me chart null hota hai)
                            $months = isset($chart) && isset($chart->tenure_months) ? $chart->tenure_months : 6;
                            $commissionSymbol = isset($chart) && $chart->commission_type === 'inr' ? '₹' : '%';

                            // Auto TOTAL array
                            $autoTotals = array_fill(1, $months, 0);

                            // Old saved values (edit mode only)
                            $existingChart = $existingChart ?? [];
                        @endphp

                        <div class="w-full mt-4 overflow-x-auto">
                            <table class="w-full border-collapse whitespace-nowrap text-sm commission-table">
                                <thead>
                                    <tr class="months-header bg-secondary/5 border-b dark:bg-bg3">
                                        <th class="text-start !py-5 px-6 min-w-[100px]">#</th>
                                        <th class="text-start !py-5 px-6 min-w-[150px]">RANK / MONTHS</th>

                                        {{-- AUTO MONTH HEADERS --}}
                                        @for ($m = 1; $m <= $months; $m++)
                                            <th class="text-start !py-5 px-6">M{{ $m }}</th>
                                        @endfor
                                    </tr>
                                </thead>

                                <tbody>

                                    {{-- ALL RANK ROWS --}}
                                    @foreach($rankData as $id => $title)

                                        @php
                                            $rowValues = $existingFdOne[$id] ?? [];  // ← FD ONE saved values
                                        @endphp

                                        <tr class="months-row {{ $id == 21 ? 'collection-charge-row bg-yellow-100' : '' }}"
                                            data-rank="{{ $id }}">

                                            <td class="px-6">{{ $id }}</td>

                                            <td class="px-6 uppercase">
                                                {{ $title }}
                                            </td>

                                            {{-- MONTH INPUT BOXES --}}
                                            @for ($m = 1; $m <= $months; $m++)
                                                <td class="px-6">
                                                    <input type="number"
                                                        name="fd_one[{{ $id }}][{{ $m }}]"
                                                        value="{{ $rowValues[$m] ?? '' }}"
                                                        class="month-input border p-2 rounded w-20 text-right">
                                                </td>
                                            @endfor
                                        </tr>

                                    @endforeach

                                    {{-- TOTAL ROW --}}
                                    <tr class="months-row total-row bg-green-100 font-bold" data-rank="total">
                                        <td class="px-6">#</td>
                                        <td class="px-6 uppercase">TOTAL</td>

                                        @for ($m = 1; $m <= $months; $m++)
                                            <td class="px-6 total-col" data-month="{{ $m }}">
                                                0 {{ $commissionSymbol }}
                                            </td>
                                        @endfor
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>


                    <div id="fd_payout" class="tab hidden p-4 bg-gray-100 rounded-10 mt-4">

                        @php
                            // Safe fallback (ADD mode me chart null hota hai)
                            $months = isset($chart) && isset($chart->tenure_months) ? $chart->tenure_months : 6;
                            $commissionSymbol = isset($chart) && $chart->commission_type === 'inr' ? '₹' : '%';

                            // Auto TOTAL array
                            $autoTotals = array_fill(1, $months, 0);

                            // Old saved values (edit mode only)
                            $existingChart = $existingChart ?? [];
                        @endphp

                        <div class="w-full mt-4 overflow-x-auto">
                            <table class="w-full border-collapse whitespace-nowrap text-sm commission-table">
                                <thead>
                                    <tr class="months-header bg-secondary/5 border-b dark:bg-bg3">
                                        <th class="text-start !py-5 px-6 min-w-[100px]">#</th>
                                        <th class="text-start !py-5 px-6 min-w-[150px]">RANK / MONTHS</th>

                                        {{-- Auto Month Columns --}}
                                        @for ($m = 1; $m <= $months; $m++)
                                            <th class="text-start !py-5 px-6 month-th">
                                                M{{ $m }}
                                            </th>
                                        @endfor
                                    </tr>
                                </thead>

                                <tbody>

                                    {{-- All Rank Rows --}}
                                    @foreach($rankData as $id => $title)

                                        @php
                                            $rowValues = $existingFdPayout[$id] ?? [];  
                                        @endphp

                                        <tr class="months-row {{ $id == 21 ? 'collection-charge-row bg-yellow-100' : '' }}"
                                            data-rank="{{ $id }}">

                                            <td class="px-6">{{ $id }}</td>

                                            <td class="px-6 uppercase">
                                                {{ $title }}
                                            </td>

                                            {{-- Dynamic Month Input Boxes --}}
                                            @for ($m = 1; $m <= $months; $m++)
                                                <td>
                                                    <input type="number"
                                                        name="fd_payout[{{ $id }}][{{ $m }}]"
                                                        value="{{ $rowValues[$m] ?? '' }}"
                                                        class="month-input border p-2 rounded w-20 text-right">
                                                </td>
                                            @endfor

                                        </tr>
                                    @endforeach

                                    {{-- TOTAL ROW --}}
                                    <tr class="months-row total-row bg-green-100 font-bold" data-rank="total">
                                        <td class="px-6">#</td>
                                        <td class="px-6 uppercase">TOTAL</td>

                                        @for ($m = 1; $m <= $months; $m++)
                                            <td class="px-6">
                                                <input type="text"
                                                    readonly
                                                    name="fd_payout_total[{{ $m }}]"
                                                    class="font-bold text-center bg-green-100 w-20">
                                            </td>
                                        @endfor
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>


                    <div id="mis_one" class="tab hidden p-4 bg-gray-100 rounded-10 mt-4">

                        @php
                            // Safe fallback (ADD mode me chart null hota hai)
                            $months = isset($chart) && isset($chart->tenure_months) ? $chart->tenure_months : 6;
                            $commissionSymbol = isset($chart) && $chart->commission_type === 'inr' ? '₹' : '%';

                            // Auto TOTAL array
                            $autoTotals = array_fill(1, $months, 0);

                            // Old saved values (edit mode only)
                            $existingChart = $existingChart ?? [];
                            
                        @endphp

                        <div class="w-full mt-4 overflow-x-auto">
                            <table class="w-full border-collapse whitespace-nowrap text-sm commission-table">
                                <thead>
                                    <tr class="months-header bg-secondary/5 border-b dark:bg-bg3">
                                        <th class="text-start !py-5 px-6 min-w-[100px]">#</th>
                                        <th class="text-start !py-5 px-6 min-w-[150px]">RANK / MONTHS</th>

                                        {{-- Auto Month Columns --}}
                                        @for ($m = 1; $m <= $months; $m++)
                                            <th class="text-start !py-5 px-6 month-th">
                                                M{{ $m }}
                                            </th>
                                        @endfor
                                    </tr>
                                </thead>

                                <tbody>

                                    {{-- All Rank Rows --}}
                                    @foreach($rankData as $id => $title)

                                        @php
                                            $rowValues = $existingMisOne[$id] ?? [];  
                                        @endphp

                                        <tr class="months-row {{ $id == 21 ? 'collection-charge-row bg-yellow-100' : '' }}"
                                            data-rank="{{ $id }}">

                                            <td class="px-6">{{ $id }}</td>

                                            <td class="px-6 uppercase">
                                                {{ $title }}
                                            </td>

                                            {{-- Dynamic Month Input Boxes --}}
                                            @for ($m = 1; $m <= $months; $m++)
                                                <td>
                                                    <input type="number"
                                                        name="mis_one[{{ $id }}][{{ $m }}]"
                                                        value="{{ $rowValues[$m] ?? '' }}"
                                                        class="month-input border p-2 rounded w-20 text-right">
                                                </td>
                                            @endfor

                                        </tr>
                                    @endforeach

                                    {{-- TOTAL ROW --}}
                                    <tr class="months-row total-row bg-green-100 font-bold" data-rank="total">
                                        <td class="px-6">#</td>
                                        <td class="px-6 uppercase">TOTAL</td>

                                        @for ($m = 1; $m <= $months; $m++)
                                            <td class="px-6">
                                                <input type="text"
                                                    readonly
                                                    name="mis_one_total[{{ $m }}]"
                                                    class="font-bold text-center bg-green-100 w-20">
                                            </td>
                                        @endfor
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>


                    <div id="mis_payout" class="tab hidden p-4 bg-gray-100 rounded-10 mt-4">

                        @php
                      
                            // Safe fallback (ADD mode me chart null hota hai)
                            $months = isset($chart) && isset($chart->tenure_months) ? $chart->tenure_months : 6;
                            
                            $commissionSymbol = isset($chart) && $chart->commission_type === 'inr' ? '₹' : '%';

                            // Auto TOTAL array
                            $autoTotals = array_fill(1, $months, 0);

                            // Old saved values (edit mode only)
                            $existingChart = $existingChart ?? [];
                        @endphp

                        <div class="w-full mt-4 overflow-x-auto">
                            <table class="w-full border-collapse whitespace-nowrap text-sm commission-table">
                                <thead>
                                    <tr class="months-header bg-secondary/5 border-b dark:bg-bg3">
                                        <th class="text-start !py-5 px-6 min-w-[100px]">#</th>
                                        <th class="text-start !py-5 px-6 min-w-[150px]">RANK / MONTHS</th>

                                        {{-- Auto Month Columns --}}
                                        @for ($m = 1; $m <= $months; $m++)
                                            <th class="text-start !py-5 px-6 month-th">
                                                M{{ $m }}
                                            </th>
                                        @endfor
                                    </tr>
                                </thead>

                                <tbody>

                                    {{-- All Rank Rows --}}
                                    @foreach($rankData as $id => $title)

                                        @php
                                            $rowValues = $existingMisPayout[$id] ?? [];
                                        @endphp

                                        <tr class="months-row {{ $id == 21 ? 'collection-charge-row bg-yellow-100' : '' }}"
                                            data-rank="{{ $id }}">

                                            <td class="px-6">
                                                <input type="text" name="mis_payout_no[{{ $id }}]" value="{{ $id }}" readonly>
                                            </td>

                                            <td class="px-6 uppercase">
                                                <input type="text" name="mis_payout_name[{{ $id }}]"
                                                    value="{{ $title }}" readonly>
                                            </td>

                                            {{-- Dynamic Month Input Boxes --}}
                                            @for ($m = 1; $m <= $months; $m++)
                                                <td>
                                                    <input type="number"
                                                        name="mis_payout_value[{{ $id }}][{{ $m }}]"
                                                        value="{{ $rowValues[$m] ?? '' }}"
                                                        class="month-input border p-2 rounded w-20 text-right">
                                                </td>
                                            @endfor

                                        </tr>

                                    @endforeach

                                    {{-- TOTAL ROW --}}
                                    <tr class="months-row total-row bg-green-100 font-bold" data-rank="total">
                                        <td class="px-6">#</td>
                                        <td class="px-6 uppercase">TOTAL</td>

                                        @for ($m = 1; $m <= $months; $m++)
                                            <td class="px-6">
                                                <input type="text"
                                                    readonly
                                                    name="mis_payout_total[{{ $m }}]"
                                                    class="font-bold text-center bg-green-100 w-20">
                                            </td>
                                        @endfor
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    
                    <div id="saving" class="tab hidden p-4 bg-gray-100 rounded-10 mt-4">
                        <div class="w-full mt-4 overflow-x-auto ">
                             <table class="w-full border-collapse whitespace-nowrap text-sm commission-table">
                                <thead>
                                    <tr class="months-header bg-secondary/5 border-b dark:bg-bg3">
                                        <th class="text-center text-lg text-start !py-5 px-6 min-w-[100px] cursor-pointer">#
                                        </th>
                                        <th
                                            class="text-center text-lg  quantity ft-600 text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                            RANK / MONTHS</th>
                                        <th
                                            class="text-center text-lg  quantity ft-600 text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                            Account Opening Incentive on 1st Transaction</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- 1 -->
                                    <tr class="months-row border-b" data-rank="1">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="1" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="Field Head Officer" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[1][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- 2 -->
                                    <tr class="months-row border-b" data-rank="2">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="2" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="Field Officer" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[2][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- 3 -->
                                    <tr class="months-row border-b" data-rank="3">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="3" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="Relationship Manager" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[3][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- 4 -->
                                    <tr class="months-row border-b" data-rank="4">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="4" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="Relationship Manager" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[4][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- 5 -->
                                    <tr class="months-row border-b" data-rank="5">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="5" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="Area Relationship Manager" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[5][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- 6 -->
                                    <tr class="months-row border-b" data-rank="6">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="6" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="Regional Relationship Manager" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[6][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- 7 -->
                                    <tr class="months-row border-b" data-rank="7">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="7" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="Field Manager" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[7][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- 8 -->
                                    <tr class="months-row border-b" data-rank="8">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="8" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="Field Associate" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[8][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- 9 -->
                                    <tr class="months-row border-b" data-rank="9">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="9" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="Field Executive" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[9][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- 10 -->
                                    <tr class="months-row border-b" data-rank="10">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="10" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="Sales Officer" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[10][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- 11 -->
                                    <tr class="months-row border-b" data-rank="11">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="11" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="Field Organizer" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[11][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- 12 -->
                                    <tr class="months-row border-b" data-rank="12">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="12" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="Field Associate" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[12][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- 13 -->
                                    <tr class="months-row border-b" data-rank="13">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="13" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="Field Officer" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[13][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- 14 -->
                                    <tr class="months-row border-b" data-rank="14">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="14" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="Adviser" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[14][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- 15 -->
                                    <tr class="months-row border-b" data-rank="15">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="15" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="Sales Manager" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[15][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- 16 -->
                                    <tr class="months-row border-b" data-rank="16">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="16" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="DEL Officer" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[16][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- 17 -->
                                    <tr class="months-row border-b" data-rank="17">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="17" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="Asst Dev Officer" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[17][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- 18 -->
                                    <tr class="months-row border-b" data-rank="18">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="18" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="Sales Officer" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[18][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- 19 -->
                                    <tr class="months-row border-b" data-rank="19">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="19" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="Asst Sales Officer" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[19][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- 20 -->
                                    <tr class="months-row border-b" data-rank="20">
                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="20" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="bg-secondary/5 px-6">
                                            <input type="text" value="C Director" disabled class="invoice_input text-center">
                                        </td>

                                        <td class="px-6">
                                            <input type="text" name="rank[20][1]" placeholder="percent" class="dynamic-placeholder px-3 border py-1">
                                        </td>
                                    </tr>

                                    <!-- ✅ SAVING TOTAL ROW -->
                                    <tr class="months-row total-row bg-green-100 font-bold" data-rank="total">
                                        <td class="px-6 text-center">#</td>
                                        <td class="px-6 text-center">TOTAL</td>
                                        <td class="px-6">
                                            <input type="text" name="rank[total][1]" readonly class="px-3 border py-1 bg-gray-200 text-center">
                                        </td>
                                    </tr>                   
                               
                                </tbody>       
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Buttons -->
                <div class="flex   min-w-10 sm:flex-row justify-center gap-3 mt-5">
                    <div class="">
                        <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                            Save
                        </button>
                    </div>

                    <div class="">
                        <button class="btn-outline uppercase justify-center" type="reset">
                            <a href="{{ route('associates-advisor.commission-charts.index') }}"> BACK</a>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>


<!-- Tenure month show dynamically and store -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
    const chartTypeSelect2 = document.getElementById("chart_type");

    function toggleCollectionChargeRows() {
        const allowed = ["rd", "dd"];   // ONLY RD & DD show

        document.querySelectorAll(".collection-charge-row").forEach(row => {
            if (allowed.includes(chartTypeSelect2.value)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    chartTypeSelect2.addEventListener("change", toggleCollectionChargeRows);
    toggleCollectionChargeRows();

    const tenureInput = document.querySelector(".tenure-input");
    const commissionTypeSelect = document.querySelector(".commission-type");
    const tables = document.querySelectorAll(".commission-table");

    let currentPlaceholder = commissionTypeSelect?.value === "inr" ? "inr" : "percent";

    /* --------------------------
       UPDATE TABLE (MAIN ENGINE)
    ---------------------------*/
    function updateTable(tenure) {
        tables.forEach((table) => {

            const header = table.querySelector(".months-header");
            const rows = table.querySelectorAll("tbody tr.months-row:not(.total-row):not(.collection-row)");
            const collectionRow = table.querySelector(".collection-row");
            const totalRow = table.querySelector(".total-row");

            const currentMonths = header.querySelectorAll("th.month-th").length;

            /* --------------------------
               ADD NEW MONTH COLUMNS
            ---------------------------*/
            if (tenure > currentMonths) {

                for (let i = currentMonths + 1; i <= tenure; i++) {

                    // HEADER
                    const th = document.createElement("th");
                    th.className = "text-center text-lg month-th";
                    th.textContent = `${i} M`;
                    header.appendChild(th);

                    // RANK ROWS
                    rows.forEach((row) => {
                        const rank_no = row.dataset.rank;
                        const td = document.createElement("td");

                        const input = document.createElement("input");
                        input.type = "text";
                        input.className = "invoice_input text-center";
                        input.name = `rank[${rank_no}][${i}]`;
                        input.placeholder = currentPlaceholder;

                        td.appendChild(input);
                        row.appendChild(td);
                    });

                    // COLLECTION ROW
                    if (collectionRow) {
                        const td = document.createElement("td");
                        const input = document.createElement("input");
                        input.type = "text";
                        input.placeholder = currentPlaceholder;
                        input.name = `rank[collection_charge][${i}]`;
                        input.className = "invoice_input text-center";
                        td.appendChild(input);
                        collectionRow.appendChild(td);
                    }


                    // TOTAL ROW (ONLY ONCE)
                    if (totalRow) {
                        const td = document.createElement("td");
                        td.innerHTML = `<input type="text" readonly class="font-bold text-center bg-green-100"
                                            name="rank[total][${i}]">`;
                        totalRow.appendChild(td);
                    }


                }
            }

            /* --------------------------
               REMOVE EXTRA MONTH COLUMNS
            ---------------------------*/
            if (tenure < currentMonths) {

                for (let i = currentMonths; i > tenure; i--) {

                    header.removeChild(header.lastElementChild);

                    rows.forEach((row) => row.removeChild(row.lastElementChild));
                   
                    if (collectionRow) collectionRow.removeChild(collectionRow.lastElementChild);
                    if (totalRow) totalRow.removeChild(totalRow.lastElementChild);
                }
            }

        });

        calculateTotals();
    }


    /* --------------------------
       INITIAL LOAD
    ---------------------------*/
    updateTable(parseInt(tenureInput.value, 10) || 1);


    /* --------------------------
       TENURE CHANGE
    ---------------------------*/
    tenureInput.addEventListener("input", () => {
        let tenure = Math.max(1, Math.min(99, parseInt(tenureInput.value, 10)));
        updateTable(tenure);
    });


    /* --------------------------
       COMMISSION TYPE CHANGE
    ---------------------------*/
    commissionTypeSelect?.addEventListener("change", () => {
        currentPlaceholder = commissionTypeSelect.value;
        updateTable(parseInt(tenureInput.value, 10) || 1);
    });


    /* --------------------------
       TOTAL CALCULATION
    ---------------------------*/
    function calculateTotals() {
        tables.forEach((table) => {

            const totalRow = table.querySelector(".total-row");
            if (!totalRow) return;

            const months = table.querySelectorAll("thead th.month-th").length;
            const rows = table.querySelectorAll("tbody tr.months-row:not(.total-row):not(.collection-row)");

            for (let m = 1; m <= months; m++) {

                let sum = 0;
                let hasValue = false;

                rows.forEach((row) => {

                    const input = row.querySelector(`input[name="rank[${row.dataset.rank}][${m}]"]`);

                    if (input && input.value && !isNaN(input.value)) {
                        sum += parseFloat(input.value);
                        hasValue = true;
                    }
                });

                const totalInput = totalRow.querySelector(`input[name="rank[total][${m}]"]`);
                if (totalInput) totalInput.value = hasValue ? sum : "";
            }
        });
    }


    /* --------------------------
       REAL TIME TOTAL UPDATE
    ---------------------------*/
    document.addEventListener("input", (e) => {
        if (e.target.closest(".commission-table") && !e.target.readOnly) {
            calculateTotals();
        }
    });

});
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {

    const schemeSelect = document.querySelector(".scheme-select");

    const idTabs = document.querySelectorAll(".tab[id]");
    const classTabs = document.querySelectorAll(".tab-content .tab");

    function hideAllTabs() {
        idTabs.forEach(t => t.classList.add("hidden"));
        classTabs.forEach(t => t.classList.add("hidden"));
    }

    function showSelectedTabs(tabKey) {
        if (!tabKey) return;

        const idTab = document.getElementById(tabKey);
        if (idTab) idTab.classList.remove("hidden");

        const classTab = document.querySelector(`.tab-content .tab-${tabKey}`);
        if (classTab) classTab.classList.remove("hidden");
    }

    hideAllTabs();
    showSelectedTabs("rd");

    // ✅ When RD/DD changes
    schemeSelect.addEventListener("change", () => {
        const selected = schemeSelect.selectedOptions[0];
        const tabKey = selected?.dataset.tab;

        hideAllTabs();
        showSelectedTabs(tabKey);
    });

});
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {

    const schemeSelect = document.querySelector(".scheme-select");

    function enableOnlyActiveTab(tabId) {
        // Disable ALL inputs
        document.querySelectorAll(".tab input").forEach(i => i.disabled = true);

        // Enable ONLY selected tab inputs
        document.querySelectorAll("#" + tabId + " input").forEach(i => i.disabled = false);
    }

    // ✅ Default open RD
    enableOnlyActiveTab("rd");

    // ✅ When scheme changes (RD/DD)
    schemeSelect.addEventListener("change", () => {
        const selected = schemeSelect.selectedOptions[0];
        const tabKey = selected.dataset.tab;
        enableOnlyActiveTab(tabKey);
    });

});
</script>

<!-- chart_type = saving total -->
<script>
    document.addEventListener("input", function () {

    const savingTab = document.querySelector("#saving");
    if (!savingTab || savingTab.classList.contains("hidden")) return;

    let total = 0;

    savingTab.querySelectorAll("tbody tr[data-rank]:not([data-rank='total']) input[name^='rank']").forEach((input) => {
        let val = parseFloat(input.value);
        if (!isNaN(val)) total += val;
    });

    const totalInput = savingTab.querySelector("input[name='rank[total][1]']");
    if (totalInput) {
        totalInput.value = total;
    }
});
</script>

{{-- Payout Type --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const select = document.querySelector(".commission-mode");
        const tabs = document.querySelectorAll(".tab-panel");

        function showTab(value) {
            tabs.forEach((tab) => {
                if (tab.dataset.tab === value) {
                    tab.style.display = "block";
                } else {
                    tab.style.display = "none";
                }
            });
        }

        // Show default tab if needed
        if (select.value) {
            showTab(select.value);
        }

        // On change
        select.addEventListener("change", () => {
            showTab(select.value);
        });
    });
</script>

<!-- change INR & % as per chart type in tenure month field -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const dropdown = document.querySelector(".commission-type");
        const inputs = document.querySelectorAll(".dynamic-placeholder");

        dropdown.addEventListener("change", () => {
            const value = dropdown.value;
            let placeholderText = "percent";

            if (value === "inr") {
                placeholderText = "inr";
            } else if (value === "percent") {
                placeholderText = "percent";
            }

            inputs.forEach(input => {
                input.placeholder = placeholderText;
            });
        });
    });
</script>


@endsection