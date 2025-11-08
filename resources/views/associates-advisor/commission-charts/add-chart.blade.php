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
        <form action="">
            <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">
                <div class="box col-span-2 md:col-span-1">
                    <div class=" dark:bg-bg3  mb-4 ">


                        <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Chart Type
                                <span class="text-red-500">*</span>
                            </label>

                            <select name="" id="schemeSelect"
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

                            <input type="text" name="" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                placeholder="Enter Name">

                        </div>
                        <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Payout Type
                                <span class="text-red-500">*</span>
                            </label>

                            <select
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

                            <select
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
                            <input type="number"
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
                                    <a href="#"> BACK</a>
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
                    <div id="rd" class="tab hidden p-4 bg-gray-100 rounded-10 mt-4">
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
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="1" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Field Head Officer" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="2" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="field officer " disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="3" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Relationship ManageR" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="4" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Relationship Manager" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="5" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Area Relationship Manager" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="6" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Regional Relationship MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="7" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="8" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD ASSOSIATE" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="9" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="FIELD EXCUTIVE" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="10" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                       <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="11" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="FIELD ORGANIZER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                        <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="12" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="field associate" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                       <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="13" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="14" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ADVISER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="15" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="16" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="DEL OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="17" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ASST DEV OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                       <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="18" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="19" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ASST SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="20" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="C DIRECTOR" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="#" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] bg-secondary/5  cursor-pointer">
                                            <input type="text" value="TOTAL" disabled class="invoice_input  text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center text-start py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="#" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] bg-secondary/5 cursor-pointer">
                                            <input type="text" value="COLLECTION CHARGE" disabled
                                                class="invoice_input text-center" />
                                        </td>
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
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="1" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Field Head Officer" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="2" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="field officer " disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="3" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Relationship ManageR" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="4" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Relationship Manager" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="5" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Area Relationship Manager" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="6" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Regional Relationship MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="7" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="8" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD ASSOSIATE" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="9" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="FIELD EXCUTIVE" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="10" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                       <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="11" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="FIELD ORGANIZER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                        <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="12" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="field associate" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                       <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="13" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="14" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ADVISER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="15" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="16" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="DEL OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="17" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ASST DEV OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                       <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="18" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="19" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ASST SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="20" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="C DIRECTOR" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>

                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="#" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] bg-secondary/5  cursor-pointer">
                                            <input type="text" value="TOTAL" disabled class="invoice_input  text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center text-start py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="#" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] bg-secondary/5 cursor-pointer">
                                            <input type="text" value="COLLECTION CHARGE" disabled
                                                class="invoice_input text-center" />
                                        </td>
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
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="1" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Field Head Officer" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="2" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="field officer " disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="3" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Relationship ManageR" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="4" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Relationship Manager" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="5" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Area Relationship Manager" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="6" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Regional Relationship MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="7" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="8" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD ASSOSIATE" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="9" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="FIELD EXCUTIVE" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="10" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                       <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="11" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="FIELD ORGANIZER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                        <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="12" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="field associate" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                       <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="13" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="14" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ADVISER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="15" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="16" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="DEL OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="17" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ASST DEV OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                       <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="18" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="19" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ASST SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="20" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="C DIRECTOR" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>

                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="#" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] bg-secondary/5  cursor-pointer">
                                            <input type="text" value="TOTAL" disabled class="invoice_input  text-center" />
                                        </td>
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
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="2" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="field officer " disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="3" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Relationship ManageR" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="4" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Relationship Manager" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="5" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Area Relationship Manager" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="6" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Regional Relationship MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="7" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="8" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD ASSOSIATE" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="9" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="FIELD EXCUTIVE" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="10" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                       <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="11" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="FIELD ORGANIZER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                        <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="12" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="field associate" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                       <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="13" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="14" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ADVISER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="15" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="16" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="DEL OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="17" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ASST DEV OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                       <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="18" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="19" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ASST SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="20" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="C DIRECTOR" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="1" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Field Head Officer" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>

                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="#" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] bg-secondary/5  cursor-pointer">
                                            <input type="text" value="TOTAL" disabled class="invoice_input  text-center" />
                                        </td>
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
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="2" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="field officer " disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="3" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Relationship ManageR" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="4" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Relationship Manager" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="5" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Area Relationship Manager" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="6" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Regional Relationship MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="7" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="8" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD ASSOSIATE" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="9" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="FIELD EXCUTIVE" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="10" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                       <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="11" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="FIELD ORGANIZER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                        <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="12" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="field associate" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                       <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="13" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="14" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ADVISER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="15" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="16" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="DEL OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="17" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ASST DEV OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                       <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="18" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="19" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ASST SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="20" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="C DIRECTOR" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="1" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Field Head Officer" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>

                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="#" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] bg-secondary/5  cursor-pointer">
                                            <input type="text" value="TOTAL" disabled class="invoice_input  text-center" />
                                        </td>
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
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="1" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Field Head Officer" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="2" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="field officer " disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="3" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Relationship ManageR" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="4" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Relationship Manager" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="5" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Area Relationship Manager" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="6" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Regional Relationship MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="7" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="8" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD ASSOSIATE" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="9" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="FIELD EXCUTIVE" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="10" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                       <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="11" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="FIELD ORGANIZER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                        <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="12" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="field associate" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                       <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="13" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="14" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ADVISER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="15" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="16" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="DEL OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="17" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ASST DEV OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                       <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="18" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                      <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="19" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ASST SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>
                                     <tr class="months-row border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="20" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="C DIRECTOR" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                    </tr>

                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="#" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] bg-secondary/5  cursor-pointer">
                                            <input type="text" value="TOTAL" disabled class="invoice_input  text-center" />
                                        </td>
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
                                    <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="1" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Field Head Officer" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>
                                     <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="2" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="field officer " disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>
                                       <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="3" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Relationship ManageR " disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>
                                      <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="4" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Relationship Manager " disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>
                                      <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="5" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Area Relationship Manager" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>
                                     <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="6" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="Regional Relationship MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>
                                        <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="7" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>
                                    <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="8" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="FIELD ASSOSIATE" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>
                                       <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="9" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="FIELD EXCUTIVE" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>
                                     <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="10" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>
                                    <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="11" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="FIELD ORGANIZER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>
                                      <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="12" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="field associate" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>
                                      <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="13" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value=" FIELD OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>
                                      <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="14" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ADVISER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>
                                       <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="15" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES MANAGER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>
                                    <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="16" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="DEL OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>
                                      <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="17" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ASST DEV OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>
                                        <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="18" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>
                                       <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="19" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="ASST SALES OFFICER" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>
                                        <tr class=" border-b">
                                        <td
                                            class="text-center  text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="20" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="C DIRECTOR" disabled
                                                class="invoice_input text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px]">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start px-3 border  py-1" />
                                        </td>
                                    </tr>

                                    <tr class="months-row border-b">
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] cursor-pointer bg-secondary/5 ">
                                            <input type="text" value="#" disabled class="invoice_input text-center " />
                                        </td>
                                        <td
                                            class="text-center text-start !py-5 px-6 min-w-[100px] bg-secondary/5  cursor-pointer">
                                            <input type="text" value="TOTAL" disabled class="invoice_input  text-center" />
                                        </td>
                                        <td class="text-center !py-5 px-6 min-w-[100px] ">
                                            <input type="text" placeholder="percent"
                                                class="dynamic-placeholder text-start border  px-3 py-1 " />
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
                            <a href="#"> BACK</a>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    

    {{-- Chart Type --}}
    <script>
        // Chart Type
        document.addEventListener("DOMContentLoaded", () => {
            const tenureInput = document.querySelector(".tenure-input");
            const commissionTypeSelect = document.querySelector(".commission-type");
            const tables = document.querySelectorAll(".commission-table");

            // Default settings
            let currentPlaceholder = commissionTypeSelect.value === "inr" ? "inr" : "percent";
            let defaultTenure = parseInt(tenureInput.value, 10);
            if (isNaN(defaultTenure) || defaultTenure < 1) {
                defaultTenure = 6;
                tenureInput.value = 6;
            }

            // Function to build or update the table
            function updateTable(tenure) {
                tables.forEach((table) => {
                    const header = table.querySelector(".months-header");
                    const rows = table.querySelectorAll(".months-row");
                    const currentMonths = header.querySelectorAll("th.month-th").length;

                    // ADD new month headers + inputs
                    if (tenure > currentMonths) {
                        for (let i = currentMonths + 1; i <= tenure; i++) {
                            const th = document.createElement("th");
                            th.className = "text-start text-lg month-th width-50";
                            th.textContent = `${i} M`;
                            header.appendChild(th);

                            rows.forEach((row) => {
                                const td = document.createElement("td");
                                td.className = "width-50";
                                const input = document.createElement("input");
                                input.type = "text";
                                input.placeholder = currentPlaceholder;
                                input.className = "invoice_input text-center border py-1 px-2 rounded";
                                td.appendChild(input);
                                row.appendChild(td);
                            });
                        }
                    }

                    // REMOVE extra month headers + inputs
                    if (tenure < currentMonths) {
                        for (let i = currentMonths; i > tenure; i--) {
                            header.removeChild(header.lastElementChild);
                            rows.forEach((row) => row.removeChild(row.lastElementChild));
                        }
                    }

                    // UPDATE placeholders of all inputs when type changes
                    const allInputs = table.querySelectorAll(".months-row input");
                    allInputs.forEach((input) => {
                        input.placeholder = currentPlaceholder;
                    });
                });
            }

            // Initialize table with default 6 months
            updateTable(defaultTenure);

            // Update on manual tenure input
            tenureInput.addEventListener("input", () => {
                let tenure = parseInt(tenureInput.value, 10);
                if (isNaN(tenure) || tenure < 0) tenure = 0;
                if (tenure > 99) {
                    tenure = 99;
                    tenureInput.value = 99;
                }
                updateTable(tenure);
            });

            // ✅ Update placeholder for ALL inputs when commission type changes
            commissionTypeSelect.addEventListener("change", () => {
                currentPlaceholder = commissionTypeSelect.value === "inr" ? "inr" : "percent";
                updateTable(parseInt(tenureInput.value, 10) || 6);
            });
        });


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
                // Show div with id = tabKey
                const idTab = document.getElementById(tabKey);
                if (idTab) idTab.classList.remove("hidden");

                // Show div with class = tab-tabKey (like .tab-rd)
                const classTab = document.querySelector(`.tab-content .tab-${tabKey}`);
                if (classTab) classTab.classList.remove("hidden");
            }

            // Initial state
            hideAllTabs();

            // On change
            schemeSelect.addEventListener("change", () => {
                const selected = schemeSelect.selectedOptions[0];
                const tabKey = selected?.dataset.tab;
                hideAllTabs();
                showSelectedTabs(tabKey);
            });
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

    <script>
        document.getElementById("schemeSelect").addEventListener("change", function () {
            const selected = this.value;
            document.querySelectorAll(".tab").forEach(tab => tab.classList.add("hidden")); // hide all
            if (selected) {
                document.getElementById(selected).classList.remove("hidden"); // show selected
            }
        });
    </script>

    <script>
        function toggleSection(button, sectionId) {
            const section = document.getElementById(sectionId);
            const icon = button.querySelector('.toggle-icon');

            section.classList.toggle('hidden');
            icon.textContent = section.classList.contains('hidden') ? '+' : '−';
        }

    </script>

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