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
        <form action="{{ route('associates-advisor.commission-charts.store') }}" method="POST">
            @csrf
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
                                <option value="rd" data-tab="rd">Recurring Deposit (RD) (Installment Based Incentive)
                                </option>
                                <option value="dd" data-tab="dd">Daily Deposit (DD) (Installment Based Incentive)</option>
                                <option value="fd_one" data-tab="fd_one">Fixed Deposit (FD) (One Time Incentive)</option>
                                <option value="fd_payout" data-tab="fd_payout">Fixed Deposit (FD) (Payout Based Incentive)
                                </option>
                                <option value="mis_one" data-tab="mis_one">Monthly Income Scheme (MIS) (One Time Incentive)
                                </option>
                                <option value="mis_payout" data-tab="mis_payout">Monthly Income Scheme (MIS) (Payout Based
                                    Incentive)</option>
                                <option value="saving" data-tab="saving">Saving Account (Opening Incentive)</option>
                            </select>
                        </div>

                        <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Chart Name
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" name="chart_name" id="chart_name"
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
                                <option value="MLM">MLM</option>
                                <option value="FLAT">FLAT</option>
                                <option value="FLAT_NO_TEAM_COMM">FLAT_NO_TEAM_COMM</option>
                            </select>
                        </div>

                        <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Commission Type
                                <span class="text-red-500">*</span>
                            </label>

                            <select name="commission_type"
                                class="commission-type w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                <option value="">Please Select</option>
                                <option value="percent" selected>(%)</option>
                                <option value="inr">INR</option>
                            </select>
                        </div>

                        <div class="w-full mt-4">
                            <label class="block font-medium uppercase mb-2">
                                Tenure (Months)
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="tenure_months"
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
                <div class="  rounded-10">
                    
                    <div id="rd" class="tab p-4 bg-gray-100 rounded-10 mt-4">
                        <div class="w-full mt-4 overflow-x-auto ">
                            <table class="w-full border-collapse whitespace-nowrap text-sm commission-table">
                                <thead>
                                    <tr class="months-header bg-secondary/5 border-b dark:bg-bg3">
                                        <th class="text-center text-lg text-start !py-5 px-6 min-w-[100px] cursor-pointer">#
                                        </th>
                                        <th
                                            class="text-center text-lg  quantity ft-600 text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                            RANK / MONTHS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rankData as $id => $title)
                                    <tr class="months-row" data-rank="{{ $id }}">
                                        <td>
                                            <input type="text" name="rank_no[{{ $id }}]" value="{{ $id }}" readonly>
                                        </td>

                                        <td>
                                            <input type="text" name="rank_name[{{ $id }}]" value="{{ $title }}" readonly>
                                        </td>
                                    </tr>                       
                                    @endforeach
                                    <!-- CORRECT: TOTAL row foreach ke BAAD -->
                                    <tr class="months-row total-row bg-green-100 font-bold" data-rank="total">
                                        <td class="px-6 text-center">#</td>
                                        <td class="px-6 text-center">TOTAL</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="dd" class="tab hidden p-4 bg-gray-100 rounded-10 mt-4">
                        <div class="w-full mt-4 overflow-x-auto ">
                            <table class="w-full border-collapse whitespace-nowrap text-sm commission-table">
                                <thead>
                                    <tr class="months-header bg-secondary/5 border-b dark:bg-bg3">
                                        <th class="text-center text-lg text-start !py-5 px-6 min-w-[100px] cursor-pointer">#
                                        </th>
                                        <th
                                            class="text-center text-lg  quantity ft-600 text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                            RANK / MONTHS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rankData as $id => $title)
                                    <tr class="months-row" data-rank="{{ $id }}">
                                        <td>
                                            <input type="text" name="rank_no[{{ $id }}]" value="{{ $id }}" readonly>
                                        </td>

                                        <td>
                                            <input type="text" name="rank_name[{{ $id }}]" value="{{ $title }}" readonly>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <!-- CORRECT: TOTAL row foreach ke BAAD -->
                                    <tr class="months-row total-row bg-green-100 font-bold" data-rank="total">
                                        <td class="px-6 text-center">#</td>
                                        <td class="px-6 text-center">TOTAL</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="fd_one" class="tab hidden p-4 bg-gray-100 rounded-10 mt-4">
                        <div class="w-full mt-4 overflow-x-auto ">
                            <table class="w-full border-collapse whitespace-nowrap text-sm commission-table">
                                <thead>
                                    <tr class="months-header bg-secondary/5 border-b dark:bg-bg3">
                                        <th class="text-center text-lg text-start !py-5 px-6 min-w-[100px] cursor-pointer">#
                                        </th>
                                        <th
                                            class="text-center text-lg  quantity ft-600 text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                            RANK / MONTHS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rankData as $id => $title)
                                    <tr class="months-row" data-rank="{{ $id }}">
                                        <td>
                                            <input type="text" name="rank_no[{{ $id }}]" value="{{ $id }}" readonly>
                                        </td>

                                        <td>
                                            <input type="text" name="rank_name[{{ $id }}]" value="{{ $title }}" readonly>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <!-- CORRECT: TOTAL row foreach ke BAAD -->
                                    <tr class="months-row total-row bg-green-100 font-bold" data-rank="total">
                                        <td class="px-6 text-center">#</td>
                                        <td class="px-6 text-center">TOTAL</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="fd_payout" class="tab hidden p-4 bg-gray-100 rounded-10 mt-4">
                        <div class="w-full mt-4 overflow-x-auto ">
                            <table class="w-full border-collapse whitespace-nowrap text-sm commission-table">
                                <thead>
                                    <tr class="months-header bg-secondary/5 border-b dark:bg-bg3">
                                        <th class="text-center text-lg text-start !py-5 px-6 min-w-[100px] cursor-pointer">#
                                        </th>
                                        <th
                                            class="text-center text-lg  quantity ft-600 text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                            RANK / MONTHS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rankData as $id => $title)
                                    <tr class="months-row" data-rank="{{ $id }}">
                                        <td>
                                            <input type="text" name="rank_no[{{ $id }}]" value="{{ $id }}" readonly>
                                        </td>

                                        <td>
                                            <input type="text" name="rank_name[{{ $id }}]" value="{{ $title }}" readonly>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <!-- CORRECT: TOTAL row foreach ke BAAD -->
                                    <tr class="months-row total-row bg-green-100 font-bold" data-rank="total">
                                        <td class="px-6 text-center">#</td>
                                        <td class="px-6 text-center">TOTAL</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="mis_one" class="tab hidden p-4 bg-gray-100 rounded-10 mt-4">
                        <div class="w-full mt-4 overflow-x-auto ">
                            <table class="w-full border-collapse whitespace-nowrap text-sm commission-table">
                                <thead>
                                    <tr class="months-header bg-secondary/5 border-b dark:bg-bg3">
                                        <th class="text-center text-lg text-start !py-5 px-6 min-w-[100px] cursor-pointer">#
                                        </th>
                                        <th
                                            class="text-center text-lg  quantity ft-600 text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                            RANK / MONTHS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rankData as $id => $title)
                                    <tr class="months-row" data-rank="{{ $id }}">
                                        <td>
                                            <input type="text" name="rank_no[{{ $id }}]" value="{{ $id }}" readonly>
                                        </td>

                                        <td>
                                            <input type="text" name="rank_name[{{ $id }}]" value="{{ $title }}" readonly>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <!-- CORRECT: TOTAL row foreach ke BAAD -->
                                    <tr class="months-row total-row bg-green-100 font-bold" data-rank="total">
                                        <td class="px-6 text-center">#</td>
                                        <td class="px-6 text-center">TOTAL</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="mis_payout" class="tab hidden p-4 bg-gray-100 rounded-10 mt-4">
                        <div class="w-full mt-4 overflow-x-auto ">
                            <table class="w-full border-collapse whitespace-nowrap text-sm commission-table">
                                <thead>
                                    <tr class="months-header bg-secondary/5 border-b dark:bg-bg3">
                                        <th class="text-center text-lg text-start !py-5 px-6 min-w-[100px] cursor-pointer">#
                                        </th>
                                        <th
                                            class="text-center text-lg  quantity ft-600 text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                            RANK / MONTHS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rankData as $id => $title)
                                    <tr class="months-row" data-rank="{{ $id }}">
                                        <td>
                                            <input type="text" name="rank_no[{{ $id }}]" value="{{ $id }}" readonly>
                                        </td>

                                        <td>
                                            <input type="text" name="rank_name[{{ $id }}]" value="{{ $title }}" readonly>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <!-- CORRECT: TOTAL row foreach ke BAAD -->
                                    <tr class="months-row total-row bg-green-100 font-bold" data-rank="total">
                                        <td class="px-6 text-center">#</td>
                                        <td class="px-6 text-center">TOTAL</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div id="saving" class="tab hidden p-4 bg-gray-100 rounded-10 mt-4">
                        <div class="w-full mt-4 overflow-x-auto ">
                             <table class="w-full border-collapse whitespace-nowrap text-sm ">
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

<!-- Tenure month show dynamically and store     -->
<script>
document.addEventListener("DOMContentLoaded", () => {

    const tenureInput = document.querySelector(".tenure-input");
    const commissionTypeSelect = document.querySelector(".commission-type");
    const tables = document.querySelectorAll(".commission-table");

    let currentPlaceholder = commissionTypeSelect?.value === "inr" ? "inr" : "percent";

    function updateTable(tenure) {
        tables.forEach((table) => {

            const header = table.querySelector(".months-header");
            const rows = table.querySelectorAll("tbody tr.months-row:not(.total-row)");

            const currentMonths = header.querySelectorAll("th.month-th").length;

            // ✅ ADD NEW MONTHS
            if (tenure > currentMonths) {
                for (let i = currentMonths + 1; i <= tenure; i++) {

                    // HEADER
                    const th = document.createElement("th");
                    th.className = "text-center text-lg month-th";
                    th.textContent = `${i} M`;
                    header.appendChild(th);

                    // ROWS
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
                }
            }

            // ✅ REMOVE EXTRA MONTHS
            if (tenure < currentMonths) {
                for (let i = currentMonths; i > tenure; i--) {
                    header.removeChild(header.lastElementChild);
                    rows.forEach((row) => row.removeChild(row.lastElementChild));
                }
            }
        });

        calculateTotals();
    }

    // ✅ INITIAL LOAD
    updateTable(parseInt(tenureInput.value, 10) || 1);

    // ✅ TENURE CHANGE
    tenureInput.addEventListener("input", () => {
        let tenure = Math.max(1, Math.min(99, parseInt(tenureInput.value, 10)));
        updateTable(tenure);
    });

    // ✅ TYPE CHANGE (INR / PERCENT)
    commissionTypeSelect?.addEventListener("change", () => {
        currentPlaceholder = commissionTypeSelect.value === "inr" ? "inr" : "percent";
        updateTable(parseInt(tenureInput.value, 10) || 1);
    });

    // ✅ FIXED — CLEAN TOTALS + CALCULATE AGAIN
    function calculateTotals() {
        tables.forEach((table) => {
            const totalRow = table.querySelector(".total-row");
            if (!totalRow) return;

            const rows = table.querySelectorAll("tbody tr.months-row:not(.total-row)");

            // ✅ REMOVE ALL TD EXCEPT FIRST TWO COLUMNS
            const tds = Array.from(totalRow.children);
            tds.forEach((td, index) => {
                if (index > 1) td.remove();
            });

            // ✅ READ MONTH COUNT FROM HEADER
            const monthHeaders = table.querySelectorAll("thead th.month-th");
            const totalMonths = monthHeaders.length;

            for (let m = 1; m <= totalMonths; m++) {
                let sum = 0;
                let hasValue = false;

                rows.forEach((row) => {
                    const input = row.querySelector(`input[name="rank[${row.dataset.rank}][${m}]"]`);

                    if (input && input.value.trim() !== "" && !isNaN(input.value)) {
                        hasValue = true;
                        sum += parseFloat(input.value);
                    }
                });

                // ✅ CREATE TOTAL CELL
                const td = document.createElement("td");
                td.className = "px-6 text-center font-bold bg-green-100";

                const input = document.createElement("input");
                input.type = "text";
                input.readOnly = true;
                input.value = hasValue ? sum : "";
                input.className = "font-bold text-center bg-green-100";
                input.name = `rank[total][${m}]`;

                td.appendChild(input);
                totalRow.appendChild(td);
            }
        });
    }

    // ✅ REALTIME RECALC
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