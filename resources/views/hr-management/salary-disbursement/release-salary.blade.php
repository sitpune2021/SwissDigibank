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

    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    /* Container for the toggle background */
    .blocks {
        width: 56px;
        /* 14 * 4px */
        height: 32px;
        /* 8 * 4px */
        border-radius: 9999px;
        /* Fully rounded */
        background-color: #9CA3AF;
        /* Tailwind gray-400 default */
        transition: background-color 0.3s ease;
    }

    /* The small white dot */
    .dot {
        position: absolute;
        top: 4px;
        /* 1 * 4px */
        left: 4px;
        /* 1 * 4px */
        width: 24px;
        /* 6 * 4px */
        height: 24px;
        /* 6 * 4px */
        background-color: white;
        border-radius: 9999px;
        transition: transform 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
    }

    /* When the checkbox is checked, change bg color */
    input[type="checkbox"].slider-toggle:checked+div .blocks {
        background-color: #228cc5;
        /* Tailwind green-500 */
    }

    /* Move the dot to right when checked */
    input[type="checkbox"].slider-toggle:checked+div .dot {
        transform: translateX(24px);
        /* 6 * 4px */
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

    .tableWidth {
        width: 90%;
        margin: auto;
    }

    .bg-yellow {
        background-color: #e17100;
    }
</style>

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-center flex-row gap-2">
                <h3 class="text-xl uppercase font-semibold">
                    Salary Disbursements
                </h3>

            </div>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between  gap-5">
            <div class=" w-full  overflow-hidden ">
                <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                    <form action="">
                        <div class="col-span-2 md:col-span-1 mt-3 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Employee
                                <span class="text-red-500">*</span>
                            </label>

                            <select id="employeeSelect"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                <option value="">Select Employee</option>
                                <option value="emp1">Romita Mukherjee</option>

                            </select>

                        </div>
                        <div class="col-span-2 md:col-span-1 mb-4">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Month/ Year
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="md:items-center mb-2 flex justify-between ">

                                <span class="w-full text-center font-bold  uppercase text-lg md:w-auto">Month</span>
                                <span class="w-full text-center font-bold  uppercase text-lg md:w-auto">Year</span>

                            </div>
                            <div class="flex gap-4 flex-row">
                                <select id="" name=""
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option selected="selected" value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                                <select id="" name=""
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                    <option value="2006">2006</option>
                                    <option value="2007">2007</option>
                                    <option value="2008">2008</option>
                                    <option value="2009">2009</option>
                                    <option value="2010">2010</option>
                                    <option value="2011">2011</option>
                                    <option value="2012">2012</option>
                                    <option value="2013">2013</option>
                                    <option value="2014">2014</option>
                                    <option value="2015">2015</option>
                                    <option value="2016">2016</option>
                                    <option value="2017">2017</option>
                                    <option value="2018">2018</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option selected="selected" value="2025">2025</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-span-2 md:col-span-1 mb-4">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Working Days
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="md:items-center mb-2 flex justify-between ">

                                <span class="w-full text-center font-bold  uppercase text-lg md:w-auto">Days</span>
                                <span class="w-full text-center font-bold  uppercase text-lg md:w-auto">Total Days</span>

                            </div>
                            <div class="flex gap-4 flex-row">
                                <input type="number" id="" name=""
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    placeholder="Enter Days">
                                <input type="number" id="" name="" readonly
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    placeholder="Total Days">
                            </div>
                        </div>

                        <div id="employeeBox" class="col-span-12 box hidden  lg:col-span-12">
                            <div class="col-span-2 md:col-span-1 mb-2">
                                <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                    Basic Salary
                                </label>

                                <div class="flex gap-4 flex-row">
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        readonly placeholder="Basic Salary">
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder="Basic Salary">
                                </div>
                            </div>
                            <div class="col-span-2 md:col-span-1 ">
                                <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                    HRA
                                </label>

                                <div class="flex gap-4 flex-row">
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        readonly>
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder="HRA">
                                </div>
                            </div>
                            <div class="col-span-2 md:col-span-1 ">
                                <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                    Education Allowance
                                </label>

                                <div class="flex gap-4 flex-row">
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        readonly>
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder=" Education Allowance">
                                </div>
                            </div>
                            <div class="col-span-2 md:col-span-1 ">
                                <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                    LTA
                                </label>

                                <div class="flex gap-4 flex-row">
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        readonly>
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder="LTA">
                                </div>
                            </div>
                            <div class="col-span-2 md:col-span-1 ">
                                <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                    Telephone Reimbursement
                                </label>

                                <div class="flex gap-4 flex-row">
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        readonly>
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder=" Telephone Reimbursement">
                                </div>
                            </div>
                            <div class="col-span-2 md:col-span-1 ">
                                <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                    Fuel Charges
                                </label>

                                <div class="flex gap-4 flex-row">
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        readonly>
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder="  Fuel Charges">
                                </div>
                            </div>
                            <div class="col-span-2 md:col-span-1 ">
                                <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                    Driver Charges
                                </label>

                                <div class="flex gap-4 flex-row">
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        readonly>
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder="Driver Charges">
                                </div>
                            </div>
                            <div class="col-span-2 md:col-span-1 ">
                                <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                    Helper Allowance
                                </label>

                                <div class="flex gap-4 flex-row">
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        readonly>
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder=" Helper Allowance">
                                </div>
                            </div>
                            <div class="col-span-2 md:col-span-1 ">
                                <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                    Special Allowance
                                </label>

                                <div class="flex gap-4 flex-row">
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        readonly>
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder=" Special Allowance">
                                </div>
                            </div>
                            <div class="col-span-2 md:col-span-1 ">
                                <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                    Variable Amount
                                </label>

                                <div class="flex gap-4 flex-row">
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        readonly>
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder=" Variable Amount">
                                </div>
                            </div>
                            <div class="col-span-2 md:col-span-1 ">
                                <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                    Gross Salary (A)
                                </label>

                                <div class="flex gap-4 flex-row">
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        readonly>
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder=" Gross Salary (A)">
                                </div>
                            </div>
                            <hr class="mt-5 mb-3">
                            <div class="col-span-2 md:col-span-1 ">
                                <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                    Employee PF
                                </label>

                                <div class="flex gap-4 flex-row">
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        readonly>
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder=" Employee PF">
                                </div>
                            </div>
                            <div class="col-span-2 md:col-span-1 ">
                                <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                    Employer PF
                                </label>

                                <div class="flex gap-4 flex-row">
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        readonly>
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder="Employer PF">
                                </div>
                            </div>
                            <div class="col-span-2 md:col-span-1 ">
                                <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                    Gratuity
                                </label>

                                <div class="flex gap-4 flex-row">
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        readonly>
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder="Gratuity">
                                </div>
                            </div>
                            <div class="col-span-2 md:col-span-1 ">
                                <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                    ESIC Employee
                                </label>

                                <div class="flex gap-4 flex-row">
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        readonly>
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder="ESIC Employee">
                                </div>
                            </div>
                            <div class="col-span-2 md:col-span-1 ">
                                <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                    ESIC Employer
                                </label>

                                <div class="flex gap-4 flex-row">
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        readonly>
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder="  ESIC Employer">
                                </div>
                            </div>
                            <div class="col-span-2 md:col-span-1 ">
                                <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                    Total Deduction (B)
                                </label>

                                <div class="flex gap-4 flex-row">
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        readonly>
                                    <input type="number" id="" name=""
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder=" Total Deduction (B)">
                                </div>
                            </div>

                            <hr class="mt-5 mb-3">

                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Net Salary (A - B)
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Total Amount">
                            <x-number-to-word for="" />
                        </div>
                        <div class="col-span-2 md:col-span-1 ">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Net Amount
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="md:items-center mb-2 flex justify-between ">
                                <span class="w-full text-center font-bold  uppercase text-lg md:w-auto">TDS </span>
                                <span class="w-full text-center font-bold  uppercase text-lg md:w-auto">EPT </span>
                                <span class="w-full text-center font-bold  uppercase text-lg md:w-auto">Rounding</span>
                                <span class="w-full text-center font-bold  uppercase text-lg md:w-auto">Net Payable</span>
                            </div>
                            <div class="flex gap-2">
                                <input type="number" id="amounts"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    placeholder="0">
                                <input type="number" id="amounts"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    placeholder="0">
                                <input type="number" id="amounts"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    readonly placeholder="Rounding Amount">
                                <input type="number" id="amounts"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    readonly placeholder="Net Payable">
                            </div>

                        </div>
                        <div class="col-span-2 md:col-span-1 mb-2 mt-3  ">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Remarks(if any)

                            </label>

                            <textarea id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Remarks (if any)"></textarea>

                        </div>
                        <div class="col-span-2 md:col-span-1 mb-2 mt-3  ">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Payable Date
                                <span class="text-error">*</span>

                            </label>

                            <input type="text" id="date"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="DD/MM/YYYY">

                        </div>
                        <div class="col-span-2 md:col-span-1 mb-2 mt-3  ">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Pay Salary
                            </label>

                            <input type="checkbox" id="showPayMode">

                        </div>
                        <div class="col-span-2 md:col-span-1 mb-2 mt-3  ">
                            <div id="payModeSection"
                                class="hidden w-full max-w-2xl bg-white  rounded-lg ">
                                <label for="" class="md:text-lg font-medium block uppercase">
                                   Release Salary :
                                </label>
                                 <div class="mt-3">
                                        <label class="block text-lg mb-3 font-medium uppercase text-gray-700">
                                           Transaction Date   <span class="text-red-500">*</span>
                                        </label>
                                        <input type="date" id="transfer_date" name="transfer_date" value="
                                            {{-- {{ old('transfer_date', $application->transfer_date ?? '') }} --}}
                                             " class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>
                                    <div class="mt-3">
                                        <label class="block text-lg mb-3 font-medium uppercase text-gray-700">
                                          Payment Amount  <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number" id="" name="" value="
                                            {{-- {{ old('transfer_date', $application->transfer_date ?? '') }} --}}
                                             " class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3" placeholder="Payment Amount">
                                    </div>
                                <!-- Radio Buttons -->
                                <div class="mt-3 flex gap-3">
                                    <!-- Pay Mode -->
                                    <label class="mr-4 flex items-center gap-2">
                                        <input type="radio" name="fee_mode" value="cash" checked {{-- {{ old('fee_mode',
                                            $application->fee_mode ?? '') == 'cash' ? 'checked' : '' }} --}}
                                        > 
                                        <p class="uppercase">Cash</p>
                                    </label>
                                    <label class="mr-4 flex items-center gap-2">
                                        <input type="radio" name="fee_mode" value="cheque" {{-- {{ old('fee_mode',
                                            $application->fee_mode ?? '') == 'cheque' ? 'checked' : '' }} --}}
                                        > <p class="uppercase">Cheque</p>
                                    </label>
                                    <label class="mr-4 flex items-center gap-2">
                                        <input type="radio" name="fee_mode" value="online" {{-- {{ old('fee_mode',
                                            $application->fee_mode ?? '') == 'online' ? 'checked' : '' }} --}}
                                        > <p class="uppercase">Online Tr.</p>
                                    </label>
                                    <label class="mr-4 flex items-center gap-2">
                                        <input type="radio" name="fee_mode" value="saving" {{-- {{ old('fee_mode',
                                            $application->fee_mode ?? '') == 'online' ? 'checked' : '' }} --}}
                                        > <p class="uppercase"> Saving Ac.</p>
                                    </label>
                                </div>

                                <!-- Bank + Cheque Fields -->
                                <div id="bankDropdownWrapper" class="mt-3 hidden ">
                                    <label for="bank_id" class="uppercase block mb-2 text-sm font-medium">Select Bank</label>
                                    <select id="bank_id" name="bank_id"
                                        class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                                        <option value="">-- Select Bank --</option>
                                        {{-- @foreach($banks as $id => $name)
                                        <option value="{{ $id }}" {{ old('bank_id', $application->bank_id ?? '') == $id ?
                                            'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                        @endforeach --}}
                                    </select>

                                    <!-- Cheque No -->
                                    <div class="mt-3">
                                        <label class="uppercase block text-sm font-medium text-gray-700">Cheque No.</label>
                                        <input type="text" name="cheque_no"
                                            class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                            placeholder="Enter Cheque No" value="
                                                {{-- {{ old('cheque_no', $application->cheque_no ?? '') }} --}}
                                                 ">
                                    </div>

                                    <!-- Cheque Date -->
                                    <div class="mt-3">
                                        <label class="uppercase block text-sm font-medium text-gray-700">Cheque Date</label>
                                        <input type="date" id="cheque_date" name="cheque_date" value="
                                            {{-- {{ old('cheque_date', $application->cheque_date ?? '') }} --}}
                                             " class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>
                                </div>

                                <!-- Online Transaction Fields -->
                           <div id="onlineFields" class="space-y-4 hidden">
                                    <div class="mt-3">
                                        <label class="block text-sm uppercase font-medium text-gray-700">
                                            Transfer Date <span class="text-red-500">*</span>
                                        </label>
                                        <input type="date" id="transfer_date" name="transfer_date" value="
                                            {{-- {{ old('transfer_date', $application->transfer_date ?? '') }} --}}
                                             " class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>

                                    <div>
                                        <label class="block text-sm uppercase font-medium text-gray-700">
                                            UTR / Transaction No. <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="utr_no" name="utr_no" placeholder="Enter Transaction No."
                                            value="
                                            {{-- {{ old('utr_no', $application->utr_no ?? '') }} --}}
                                             " class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>

                                    <div>
                                        <label class="uppercase block text-sm font-medium text-gray-700">
                                            Transfer Mode <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex gap-4 mt-2">
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="transfer_mode" value="imps" {{-- {{
                                                    old('transfer_mode', $application->transfer_mode ?? '') == 'imps' ?
                                                'checked' : '' }} --}}
                                                >
                                                <span>IMPS</span>
                                            </label>
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="transfer_mode" value="vpa" {{-- {{
                                                    old('transfer_mode', $application->transfer_mode ?? '') == 'vpa' ?
                                                'checked' : '' }} --}}
                                                >

                                                <span>VPA</span>
                                            </label>
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="transfer_mode" value="neft_rtgs" {{-- {{
                                                    old('transfer_mode', $application->transfer_mode ?? '') == 'neft_rtgs' ?
                                                'checked' : '' }} --}}
                                                >
                                                <span>NEFT/RTGS</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="uppercase block text-sm font-medium text-gray-700">
                                            Credited in Company Account <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex gap-4">
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="credited" value="1" {{-- {{ old('credited')==1
                                                    ? 'checked' : '' }} --}} checked>
                                                <span>Yes</span>
                                            </label>

                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="credited" value="0" {{-- {{ old('credited')==0
                                                    ? 'checked' : '' }} --}}>
                                                <span>No</span>
                                            </label>
                                        </div>
                                    </div>
                                </div> 
                                {{--  Saving Ac. --}}
                           <div id="savingAc" class="space-y-4 hidden">
                                    <div class="mt-3">
                                        <label class="block text-sm uppercase mb-3 font-medium text-gray-700">
                                           Select Saving Account  <span class="text-red-500">*</span>
                                        </label>
                                        <select  id="" name="]" value="" class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                                             <option value="">Select Saving Account</option>
                                             </select>

                                    </div>
                           </div> 
                            </div>

                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                            <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                                Disburse Salary
                            </button>

                            <button class="btn-outline uppercase justify-center" type="reset">
                                <a href="#"> BACK</a>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right: Settings -->
            <div class=" w-full overflow-hidden">
                <div id="employeeInfo" class="hidden grid md:grid-cols-2 gap-4 max-w-4xl mx-auto">

                    <!-- Employee Info Box -->
                      <div class="bg-white border border-blue-300 p-2 rounded-lg shadow-md">
                        <div class="bg-secondary/5  px-4 py-2 rounded-t-lg">
                            <h3 class="text-lg uppercase font-semibold">EMPLOYEE INFO</h3>
                        </div>
                        <div class="p-4">
                            <table class="w-full text-sm">
                                <tbody>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase p-2">Branch</td>
                                        <td>KHANNA</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase p-2">Name</td>
                                        <td>ROMITA MUKHERJEE</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase p-2">Code</td>
                                        <td>MINL0014</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase p-2">Joining Date</td>
                                        <td>1 July 2025</td>
                                    </tr>
                                     <tr class="border-b">
                                        <td class="font-semibold uppercase p-2">
                                            Available Balance
                                        </td>
                                        <td>(4,600.00)</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase p-2">Leaving Date</td>
                                        <td>-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Bank Account Info Box -->
                    <div class="box border border-green-300 rounded-10 shadow-md">
                        <div class="bg-secondary/5  px-4 py-2 rounded-10">
                            <h3 class="text-lg uppercase font-semibold">BANK ACCOUNT INFO</h3>
                        </div>
                        <div class="p-4">
                            <table class="w-full text-sm">
                                <tbody>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase p-2">Bank Name</td>
                                        <td>State Bank of India</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase p-2">Account Holder</td>
                                        <td>ROMITA MUKHERJEE</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase p-2">Account No</td>
                                        <td>12345678901</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase p-2">IFSC Code</td>
                                        <td>SBIN0001234</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <script>
            const select = document.getElementById("employeeSelect");
            const infoBox = document.getElementById("employeeInfo");

            select.addEventListener("change", () => {
                if (select.value) {
                    infoBox.classList.remove("hidden");
                    infoBox.classList.add("grid");
                } else {
                    infoBox.classList.add("hidden");
                }
            });
        </script>
        <script>
            const employeeSelect = document.getElementById("employeeSelect");
            const employeeBox = document.getElementById("employeeBox");

            employeeSelect.addEventListener("change", () => {
                if (employeeSelect.value) {
                    employeeBox.classList.remove("hidden"); // show div
                } else {
                    employeeBox.classList.add("hidden"); // hide div
                }
            });
        </script>

        <!-- Pay Salary Checkbox -->
        <script>
            const checkbox = document.getElementById("showPayMode");
            const payModeSection = document.getElementById("payModeSection");
            const feeModeRadios = document.querySelectorAll("input[name='fee_mode']");
            const bankFields = document.getElementById("bankDropdownWrapper");
            const onlineFields = document.getElementById("onlineFields");
             const savingAc = document.getElementById("savingAc");

            // ✅ Show/hide entire section when checkbox is toggled
            checkbox.addEventListener("change", () => {
                payModeSection.classList.toggle("hidden", !checkbox.checked);
            });

            // ✅ Show/hide bank or online fields based on selected pay mode
            feeModeRadios.forEach((radio) => {
                radio.addEventListener("change", () => {
                    if (radio.value === "cheque") {
                        bankFields.classList.remove("hidden");
                        onlineFields.classList.add("hidden");
                    } else if (radio.value === "online") {
                        onlineFields.classList.remove("hidden");
                        bankFields.classList.add("hidden");
                    }
                    else if (radio.value === "saving") {
                        savingAc.classList.remove("hidden");
                        bankFields.classList.add("hidden");
                    } else {
                        bankFields.classList.add("hidden");
                        onlineFields.classList.add("hidden");
                    }
                });
            });
        </script>
        <!-- pay mode -->
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const radios = document.querySelectorAll('input[name="fee_mode"]');
                const bankDropdownWrapper = document.getElementById("bankDropdownWrapper");
                const onlineFields = document.getElementById("onlineFields");

                radios.forEach(radio => {
                    radio.addEventListener("change", () => {
                        bankDropdownWrapper.classList.add("hidden");
                        onlineFields.classList.add("hidden");

                        if (radio.value === "cheque" && radio.checked) {
                            bankDropdownWrapper.classList.remove("hidden");
                        }
                        if (radio.value === "online" && radio.checked) {
                            onlineFields.classList.remove("hidden");
                        }
                    });
                });

                // Default dates
                let today = new Date().toISOString().split('T')[0];
                document.getElementById("cheque_date").value = today;
                document.getElementById("transfer_date").value = today;
            });
        </script>
@endsection