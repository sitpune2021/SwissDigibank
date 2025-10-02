@extends('layout.main')
@section('content')

<style>
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

<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col  gap-2">
            <h1 class="text-xl font-semibold">NEW GOLD LOAN APPLICATION</h1>
            <p class="text-gray-500">
                <a href="" class="text-gray-500  capitalize text-sm">New Gold Loan Application </a> >
                <a href="" class="text-gray-500 capitalize text-sm"> New</a>
            </p>

        </div>

    </div>
    <div class="box">
        <div class="flex flex-col lg:flex-row mb-3 gap-4 ">
            <div class=" rounded-10 flex-1 bg-primary/5 p-2">
                <div class="w-full col-span-12  px-3 py-1 rounded-10 lg:col-span-12">
                    <form class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6" action="" method="">

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                Application Date
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id="date" name=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="DD/MM/YYYY ">

                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                Member
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                placeholder="Enter Scheme Code">
                                <option value="">Search Member No or Name</option>
                            </select>


                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                1st Co-Applicant Member

                            </label>

                            <select
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                placeholder="Enter Scheme Code">
                                <option value="">Search Member No or Name</option>
                            </select>

                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                2nd Co-Applicant Member

                            </label>

                            <select
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                placeholder="Enter Scheme Code">
                                <option value="">Search Member No or Name</option>
                            </select>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                Branch
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                placeholder="Enter Scheme Code">
                                <option value="">select Branch </option>
                            </select>

                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                Advisor/ Staff

                            </label>

                            <select
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                placeholder="Enter Scheme Code">
                                <option value="">select Advisor/ Staff </option>
                            </select>

                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                Guarantor 1
                            </label>

                            <select
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                placeholder="Enter Scheme Code">
                                <option value="">Search Member No or Name </option>
                            </select>


                        </div>
                        <div class="col-span-2 md:col-span-1">

                            <div class="col-sm-7">
                                <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                    Guarantor 2
                                </label>

                                <select
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                    placeholder="Enter Scheme Code">
                                    <option value="">Search Member No or Name </option>
                                </select>

                            </div>

                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <div class="col-sm-7">
                                <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                    Guarantor 3
                                </label>

                                <select
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                    placeholder="Enter Scheme Code">
                                    <option value="">Search Member No or Name </option>
                                </select>

                            </div>
                        </div>


                        <div class="col-span-2 md:col-span-1">
                            <div class="col-sm-7">
                                <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                    Guarantor 4
                                </label>

                                <select
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                    placeholder="Enter Scheme Code">
                                    <option value="">Search Member No or Name </option>
                                </select>

                            </div>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <div class="col-sm-7">
                                <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                    Scheme
                                    <span class="text-error">*</span>
                                </label>

                                <select
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                    placeholder="Enter Scheme Code">
                                    <option value="">Select Scheme </option>
                                </select>

                            </div>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            {{-- do not remove div --}}
                        </div>


                        <div class="col-span-2 md:col-span-1">

                            <div class="col-sm-7">
                                <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                    Tenure Type
                                    <span class="text-error">*</span>
                                </label>
                                <div class="flex">
                                    <label class="flex items-center gap-2 space-x-2 p-2">
                                        <input type="radio" name="tenure_type" id="" value="days"
                                            class="text-green-600 focus:ring-green-500">
                                        <span class="text-gray-70 capitalize">DAYS</span>
                                    </label>
                                    <label class="flex items-center gap-2 space-x-2 p-2">
                                        <input type="radio" name="tenure_type" id="" value="weeks"
                                            class="text-green-600 focus:ring-green-500">
                                        <span class="text-gray-70 capitalize">WEEKS</span>
                                    </label>
                                    <label class="flex items-center gap-2 space-x-2 p-2">
                                        <input type="radio" name="tenure_type" id="" value="months"
                                            class="text-green-600 focus:ring-green-500" checked>
                                        <span class="text-gray-70 capitalize">MONTHS</span>
                                    </label>
                                </div>
                           </div>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                Tenure
                                <span id="tenureLabel" class="text-black uppercase">( MONTHS )</span>
                                <span class="text-error">*</span>
                            </label>

                            <input type="number" id="" name=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Please Enter Tenure ">

                        </div>

                       <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                EMI Collection
                                <span class="text-error">* </span>
                            </label>

                            <select
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                placeholder="Enter Scheme Code">
                                <option value="">Please Select </option>
                            </select>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                Credit Period ( EMI Grace Period ) ( Days )
                                <span class="text-error">*</span>
                            </label>

                            <input type="number" id="" name=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0">
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                Loan Amount (₹)
                                <span class="text-error">*</span>
                            </label>

                            <input type="number" id="" name=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0">
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                Insurance Amount (₹)
                                <span class="text-error">*</span>
                            </label>

                            <input type="number" id="" name=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Insurance Amount (₹)">
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                Net Loan Amount (₹)
                                <span class="text-error">*</span>
                            </label>

                            <input type="number" id="" name=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0">
                        </div>
                        <div class="col-span-2 md:col-span-1 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                Purpose of Loan
                                <span class="text-error">*</span>
                            </label>

                            <input type="text" id="" name=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Purpose of Loan">
                        </div>
                </div>
                <div class="col-span-12  lg:col-span-12 mb-5">
                    <hr>
                    <label for="" class="md:text-lg font-medium block mt-3 mb-4 uppercase">
                        Credit Score Details

                    </label>
                    <div class="w-full overflow-x-auto">
                        <table class="w-full  rounded-lg whitespace-nowrap" id="cibilTable">
                            <thead class="bg-secondary/5 whitespace-nowrap">
                                <tr class="bg-gray-100">
                                    <th class="text-center px-2 py-2 md:px-4 md:py-2 uppercase text-sm md:text-base">
                                        Cibil Type
                                    </th>
                                    <th class="text-center px-2 py-2 md:px-4 md:py-2 uppercase text-sm md:text-base">
                                        Cibil Score
                                    </th>
                                    <th class="text-center  px-2 py-2 md:px-4 md:py-2 uppercase text-sm md:text-base">
                                        Report Date
                                    </th>
                                    <th class="text-center px-2 py-2 md:px-4 md:py-2 uppercase text-sm md:text-base">
                                        Upload File
                                    </th>
                                    <th class=" px-2 py-2 md:px-4 md:py-2"></th>
                                </tr>
                            </thead>

                            <tbody id="cibilBody" class="bg-gray-100 whitespace-nowrap">
                                {{-- Credit Score Details Table --}}
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <button type="button" id="addRow" class="btn-primary rounded-10 px-4 py-2">
                            + Add New Score
                        </button>
                    </div>
                    {{--calculator checkbox- --}}
                    <x-checkbox-calculator id="manualEntry" name="manual_entry" label="Collect Principal Amount as EMI"
                        sublabel="(Check this if you want to collect principal amount as EMIs.)" />

                </div>
                <div class="col-span-12  lg:col-span-12 ">
                    <hr>
                    <label for="" class="md:text-lg font-medium block mt-3 mb-4 uppercase">
                        Collect Advance Processing Fee
                    </label>
                    <div class="w-full overflow-x-auto bg-secondary/5 rounded-10 p-3">

                        <div class="w-full">
                            <div class="flex  flex-row justify-around items-center gap-3">
                                <!-- Label -->
                                <label for="" class="text-sm block font-medium text-gray-700 dark:text-gray-200 uppercase">
                                    Total Processing Fee :
                                </label>


                                <input type="text" name="" id="" readonly placeholder="0"
                                    class="w-64 rounded-10 block border dark:bg-bg3 px-3 py-2 text-sm " />
                            </div>
                        </div>

                        <label for="" class="md:text-lg font-medium block mt-3 mb-4 uppercase">
                            Collect Processing Fee :
                        </label>
                        <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                            <tbody>
                                <!-- Column Labels -->
                                <tr class="">
                                    <th class="text-center px-3 py-2 uppercase">Value</th>
                                    <th class="text-center px-3 py-2 uppercase">GST (%)</th>
                                    <th class="text-center px-3 py-2 uppercase">SGST</th>
                                    <th class="text-center px-3 py-2 uppercase">CGST</th>
                                    <th class="text-center px-3 py-2 uppercase">IGST</th>
                                    <th class="text-center px-3 py-2 uppercase">Total</th>
                                </tr>

                                <!-- Input Row -->
                                <tr class="">
                                    <!-- Value -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" value="0" readonly
                                            class="w-full px-2 py-2 text-center  rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- GST (%) -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" value="18.0" readonly
                                            class="w-full px-2 py-2 text-center  rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- SGST -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" value="0" readonly
                                            class="w-full px-2 py-2 text-center  rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- CGST -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" value="0" readonly
                                            class="w-full px-2 py-2 text-center  rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- IGST -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" value="0" readonly
                                            class="w-full px-2 py-2 text-center  rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- Total -->
                                    <td class="px-2 py-2">
                                        <input type="number" name="" id="" placeholder="0"
                                            class="w-full px-2 py-2 text-center  rounded-10 text-sm md:text-base" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <x-paymode :amount="$misaccount->amount ?? ''" {{-- :banks="$banks" --}} :showSaving="false"
                            id="amount" :readonly="false" :amountClass="true" :bgColor="false" :hiddenheading="true" />

                        <p for="" class=" text-error text-sm block mt-3 mb-4">
                            Note: If you wish to collect processing fee at the time of disbursement, then enter 0. Fees
                            will be calculated accordingly.
                        </p>
                    </div>

                </div>


            </div>




            <div class="flex-2 col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6 min-w-[300px]">
                {{--memberBox info --}}
                <div id="memberBox" class="w-full">
                    <div class="flex justify-between items-center bg-secondary/5  rounded-10 px-4 py-3 dark:bg-bg3 uppercase">
                        <h3 class="text-base capitalize font-semibold md:text-lg">
                            Member Info

                        </h3>
                        <button type="button" class="p-1 rounded transition"
                            onclick="toggleSection(this, 'memberInfoBody')">
                            <span class="toggle-icon text-lg font-bold">−</span>
                        </button>

                    </div>
                    <div id="memberInfoBody" class="px-4 py-3">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                    <tr class="border-b">
                                        <td class="font-semibold py-2 pr-4 uppercase">Member Name</td>
                                        <td class="py-2 capitalize">Demo</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold py-2 pr-4 uppercase">Mobile No</td>
                                        <td class="py-2">5555555555</td>
                                    </tr>
                                    <tr class="">
                                        <td class="font-semibold py-2 pr-4 uppercase">Address</td>
                                        <td class="py-2">Madhya Pradesh</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                {{--schemeBox info --}}
                <div id="schemeBox" class=" mt-5">
                    <div class="flex justify-between items-center bg-secondary/5 rounded-10 px-4 py-3 dark:bg-bg3">
                        <h3 class="text-base font-semibold md:text-lg uppercase">Scheme Info

                        </h3>
                        <button type="button" class="p-1 rounded transition"
                            onclick="toggleSection(this, 'schemeInfoBody')">
                            <span class="toggle-icon text-lg font-bold">−</span>
                        </button>

                    </div>


                    <div id="schemeInfoBody" class="px-4 py-3">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                    <tr class="border-b">
                                        <td class="font-semibold py-2 pr-4 uppercase">Scheme Code</td>
                                        <td class="py-2">SSY17</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold py-2 pr-4 uppercase">Scheme Name</td>
                                        <td class="py-2">Suvarna shree yojana no emi</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold py-2 pr-4 uppercase">Max Tenure</td>
                                        <td class="py-2">12 Months</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold py-2 pr-4 uppercase">Maximum Loan Amount</td>
                                        <td class="py-2">₹ 100,000.00</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold py-2 pr-4 uppercase">Maximum Loan Limit Against Security</td>
                                        <td class="py-2">80.0 %</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold py-2 pr-4 uppercase">Minimum Loan Amount</td>
                                        <td class="py-2">₹ 10,000.00</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold py-2 pr-4 uppercase">Annual Interest Rate</td>
                                        <td class="py-2">20.0 %</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold py-2 pr-4 uppercase">Interest Type</td>
                                        <td class="py-2">No Emi</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold py-2 pr-4 uppercase">Credit Period</td>
                                        <td class="py-2">1 Days</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold py-2 pr-4 uppercase">Active</td>
                                        <td class="py-2">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold py-2 pr-4 uppercase">Fore Closure Charges</td>
                                        <td class="py-2">₹</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full overflow-x-auto mt-5">
            <table class="w-full rounded-10 whitespace-nowrap text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-center px-2 py-2 bg-secondary/5">#</th>
                        <th class="text-center px-2 py-2 bg-secondary/5 uppercase">Item Type <span class="text-red-500">*</span>
                        </th>
                        <th class="text-center px-2 py-2 bg-secondary/5 uppercase">Item Name <span class="text-red-500">*</span>
                        </th>
                        <th class="text-center px-2 py-2 bg-secondary/5 uppercase">No of Item <span class="text-red-500">*</span>
                        </th>
                        <th class="text-center px-2 py-2 bg-secondary/5 uppercase">Value per Gram (A) (₹) <span
                                class="text-red-500">*</span></th>
                        <th class="text-center px-2 py-2 bg-secondary/5 uppercase">Gross Weight (gm) <span
                                class="text-red-500">*</span></th>
                        <th class="text-center px-2 py-2 bg-secondary/5 uppercase">Net Weight (B) (gm) <span
                                class="text-red-500">*</span></th>
                        <th class="text-center px-2 py-2 bg-secondary/5 uppercase">Tunch (C) (%)<span
                                class="text-red-500">*</span></th>
                        <th class="text-center px-2 py-2 bg-secondary/5 uppercase">
                            Fine Weight *(D = C% of B) (gm)
                            <span class="text-red-500">*</span>
                        </th>
                        <th class="text-center px-2 py-2 bg-secondary/5 uppercase">Total Value (A * D)(₹)</th>
                        <th class="text-center px-2 py-2 bg-secondary/5 uppercase">Item Image</th>
                        <th class="px-2 py-2 bg-secondary/5"></th>
                    </tr>
                </thead>

                <tbody id="itemsBody" class="wihtespace-nowrap">
                    <!-- Rows will be inserted here -->
                </tbody>

                <tfoot class="bg-gray-100 border">
                    <tr>
                        <td colspan="7" class="text-center font-semibold border px-2 py-2 ">TOTAL</td>
                        <td class="px-2 py-2 ">
                            {{-- <input type="text" class="w-full  rounded px-2 py-1 text-center bg-secondary/5" disabled> --}}
                        </td>
                        <td class="px-2 py-2 ">
                            {{-- <input type="text" class="w-full  rounded px-2 py-1 text-center bg-secondary/5" disabled> --}}
                        </td>
                        <td class="px-2 py-2 ">
                            <input type="number" readonly class="w-full border rounded-10 px-2 py-1 text-center bg-secondary/5"
                                placeholder="0">
                        </td>
                        <td colspan="2" class=" pe-2">
                            {{-- <input type="number" readonly class="w-full  rounded px-2 py-1 text-center bg-secondary/5"> --}}
                        </td>
                    </tr>
                </tfoot>
            </table>

        </div>
        <div class="mt-3">
            <button type="button" id="addRowBtn" class="btn-primary rounded-10 px-4 py-2">
                + Add Gold Items
            </button>
        </div>

        <!-- Buttons -->
        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
            <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                Calculate
            </button>

            <button class="btn-outline uppercase justify-center" type="reset">
                <a href="{{route('rdschemes.index')}}"> BAck</a>
            </button>
        </div>
    </div>
    </form>
</div>









<script>
    // =====logic for dynamic cibil rows=====

    const cibilBody = document.getElementById("cibilBody");
    const addRowBtn = document.getElementById("addRow");

    // Template for new row
    function newRow() {
        return `
                   <tr class="nested-fields border-b">
                                                    <!-- Cibil Type -->
                           <td class="px-2 py-2 " style="width:230px;">
                            <select name="cibil_type[]" required
                                    class="w-full text-center dark:bg-bg3  rounded-10 px-2 py-2 text-sm md:text-base border bg-secondary/5" >
                                                        <option value="transunion">TransUnion</option>
                                                        <option value="equifax">Equifax</option>
                                                        <option value="experian">Experian</option>
                                                        <option value="crif_highmark">Crif Highmark</option>
                                                      </select>
                            </td>

                                                    <!-- Cibil Score -->
                                                    <td class="px-2 py-2 ">
                                                      <input type="number" name="cibil_score[]" placeholder="Enter CIBIL Score"
                                                        class="w-full text-center dark:bg-bg3  rounded-10 px-2 py-2 text-sm md:text-base border bg-secondary/5" required/>
                                                    </td>

                                                    <!-- Report Date -->
                                                    <td class="px-2 py-2  relative">
                                                      <input type="text" id="date2" name="report_date[]"  placeholder="DD/MM/YYYY"
                                                        class="w-full text-center dark:bg-bg3  rounded-10 px-2 py-2 text-sm md:text-base border bg-secondary/5" required/>
                                                    </td>

                                                    <!-- Upload File -->
                                                    <td class="px-2 py-2 ">
                                                      <input type="file" name="report_file[]"
                                                        class="w-full text-center dark:bg-bg3  rounded-10 px-2 py-2 text-sm md:text-base border bg-secondary/5"/>
                                                    </td>

                                                    <!-- Remove button -->
                                                    <td class="px-2 py-2 md:px-4 md:py-2  text-center">
                                                      <button type="button" class="removeRow text-red-500 hover:text-red-700">
                                                        <i class="las la-times" aria-hidden="true"></i>
                                                      </button>
                                                    </td>
                                                  </tr>
                                                `;
    }

    // Add row
    addRowBtn.addEventListener("click", () => {


        cibilBody.insertAdjacentHTML("beforeend", newRow());
    });

    // Remove row (event delegation)
    cibilBody.addEventListener("click", function(e) {
        if (e.target.closest(".removeRow")) {
            e.target.closest("tr").remove();
        }
    });




    //== Add Gold Items== 

    document.addEventListener("DOMContentLoaded", function() {
        const tbody = document.getElementById("itemsBody");
        const addRowBtn = document.getElementById("addRowBtn");

        function updateRowNumbers() {
            [...tbody.querySelectorAll("tr")].forEach((row, index) => {
                row.querySelector("td").textContent = index + 1;
            });
        }

        function createRow() {
            const row = document.createElement("tr");
            row.innerHTML = `
                              <td class="text-center px-2 py-2">1</td>
                              <td class="px-2 py-2 ">
                                <select class="w-full rounded px-2 py-2 rounded-10 border  bg-secondary/5 text-sm " style="width:150px;">
                                  <option>Gold Jewelery</option>
                                  <option>Gold Coin</option>
                                  <option>Gold Biscuit</option>
                                  <option>Silver Jewelery</option>
                                  <option>Silver Coin</option>
                                  <option>Silver Biscuit</option>
                                  <option>Platinum</option>
                                  <option>Diamond</option>
                                  <option>Stone</option>
                                </select>
                              </td>
                              <td class="px-2 py-2" >
                                <input type="text" placeholder="Enter Item Name" class="w-full bg-secondary/5 rounded px-2 py-2 rounded-10 border text-center text-sm">
                              </td>
                              <td class="px-2 py-2" >
                                <input type="number" placeholder="No of Items" class="w-full bg-secondary/5 rounded px-2 py-2 rounded-10 border text-center text-sm">
                              </td>
                              <td class="px-2 py-2">
                                <input type="number" placeholder="Value per Gram"  class="w-full bg-secondary/5 rounded px-2 py-2 rounded-10 border text-center text-sm">
                              </td>
                              <td class="px-2 py-2">
                                <input type="number" placeholder="Gross Weight"  class="w-full rounded px-2 py-2 rounded-10 border bg-secondary/5 text-center text-sm">
                              </td>
                              <td class="px-2 py-2">
                                <input type="number" placeholder="Net Weight"  class="w-full bg-secondary/5 rounded px-2 py-2 rounded-10 border text-center text-sm">
                              </td>
                              <td class="px-2 py-2">
                                <input type="number" placeholder="Tunch %"  class="w-full rounded bg-secondary/5 px-2 py-2 rounded-10 border text-center text-sm">
                              </td>
                              <td class="px-2 py-2">
                                <input type="number" placeholder="Fine Weight" readonly class="w-full rounded px-2 py-2 rounded-10 border bg-secondary/5 text-center text-sm bg-gray-100">
                              </td>
                              <td class="px-2 py-2">
                                <input type="number" placeholder="Total Value" readonly class="w-full rounded px-2 py-2 rounded-10 border bg-secondary/5 text-center text-sm bg-gray-100">
                              </td>
                              <td class="px-2 py-2">
                                <div class="flex gap-2 justify-center">
                                  <label class="cursor-pointer text-yellow-600">


                                  </label>

                                </div>
                              </td>
                              <td class="px-2 py-2 text-center">
                               <div class="flex ">
                                    <div class="relative">
                                    <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                    </div>
                                  <button type="button" class="text-red-500 removeRowBtn"><i class="las la-times"></i></button>
                                </div>
                              </td>
                            `;
            return row;
        }

        // Add Row
        addRowBtn.addEventListener("click", function() {
            tbody.appendChild(createRow());
            updateRowNumbers();
        });

        // Remove Row (Event Delegation)
        tbody.addEventListener("click", function(e) {
            if (e.target.closest(".removeRowBtn")) {
                e.target.closest("tr").remove();
                updateRowNumbers();
            }
        });
    });



    // <!-- collapsed logic + - button-->

    function toggleSection(button, sectionId) {
        const section = document.getElementById(sectionId);
        const icon = button.querySelector('.toggle-icon');

        section.classList.toggle('hidden');
        icon.textContent = section.classList.contains('hidden') ? '+' : '−';
    }


    //=== Grab all radios in Tenure Type ===
    const radios = document.querySelectorAll('input[name="tenure_type"]');
    const label = document.getElementById('tenureLabel');

    radios.forEach(radio => {
        radio.addEventListener('change', () => {
            label.textContent = `( ${radio.value} )`;
        });
    });
</script>
@endsection