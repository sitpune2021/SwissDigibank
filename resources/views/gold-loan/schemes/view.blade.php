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

<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col  gap-2">
            <div class="flex items-center gap-3">
                <h1 class="text-xl font-semibold capitalize">
                    Suvarna shree yojana no emi
                </h1>
                <p class="text-gray-500 text-sm font-semibold">
                    Gold Loan Scheme
                </p>
            </div>
            <p class="text-gray-500">
                <a href="" class="text-gray-500 text-sm">Gold Loan Schemes </a> >
                <a href="" class="text-gray-500 text-sm">Suvarna shree yojana no emi</a>
            </p>

        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">
        <div class="box col-span-2 md:col-span-1">
            <!-- Edit Button -->
            <div class="flex justify-end mb-4">
                <a href="#" class="btn-primary px-2 py-2 ">
                    <i class="las la-pencil-alt"></i>
                </a>
            </div>

            <!-- Responsive Table -->
            <div class="overflow-x-auto">
                <table class="w-full  text-sm md:text-base">
                    <tbody class="divide-y divide-gray-200">
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3 w-1/2">Scheme Code</td>
                            <td class="p-3">SSY17</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Scheme Name</td>
                            <td class="p-3">Suvarna shree yojana no emi</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Tenure</td>
                            <td class="p-3">12 Months</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Maximum Loan Amount</td>
                            <td class="p-3">₹ 100,000.00</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Maximum Loan Limit Against Deposit</td>
                            <td class="p-3">80.0 %</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Minimum Loan Amount</td>
                            <td class="p-3">₹ 10,000.00</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Annual Interest Rate</td>
                            <td class="p-3">20.0 %</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Interest Type</td>
                            <td class="p-3">No Emi</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Active</td>
                            <td class="p-3">
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">Yes</span>
                            </td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Fore Closure Charges</td>
                            <td class="p-3">₹</td>
                        </tr>
                        <tr class="bg-gray-50 border-b">
                            <td class="font-semibold p-3 flex items-center">
                                Overdue Interest Rate (%)
                                {{-- <i class="las la-info-circle"></i> --}}
                                </span>
                            </td>
                            <td class="p-3">1.00 % of TYPE_1</td>
                        </tr>
                        <tr class="bg-gray-50 border-b">
                            <td class="font-semibold p-3">SMS Charges per EMI</td>
                            <td class="p-3">0.0 ₹</td>
                        </tr>
                        <tr class="bg-gray-50 border-b">
                            <td class="font-semibold p-3">Fuel Charges per EMI</td>
                            <td class="p-3">0.0 ₹</td>
                        </tr>
                        <tr class="bg-gray-50 border-b">
                            <td class="font-semibold p-3">Stationary Charges per EMI</td>
                            <td class="p-3">0.0 ₹</td>
                        </tr>
                        <tr class="bg-gray-50 border-b">
                            <td class="font-semibold p-3">Maintenance Charges per EMI</td>
                            <td class="p-3">0.0 ₹</td>
                        </tr>
                        <tr class="bg-gray-50 border-b">
                            <td class="font-semibold p-3">Collection Charges per EMI</td>
                            <td class="p-3">0.0 ₹</td>
                        </tr>
                        <tr class="bg-gray-50 border-b">
                            <td class="font-semibold p-3">Credit Period</td>
                            <td class="p-3">1 Days</td>
                        </tr>
                        <tr class="bg-gray-50 border-b">
                            <td class="font-semibold p-3">Created at</td>
                            <td class="p-3">17/09/2025 12:29</td>
                        </tr>
                        <tr class="bg-gray-50 border-b">
                            <td class="font-semibold p-3">Updated at</td>
                            <td class="p-3">17/09/2025 12:29</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box col-span-2 md:col-span-1 ">
            <div class="flex items-center gap-3">
                <h1 class="text-lg capitalize">
                    INTEREST CHART
                </h1>
                <p class="text-gray-500 text-sm font-semibold">
                    Charge Floating Interest Rate per Slab
                </p>
                <span
                    class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">Yes</span>
            </div>
            <hr class="mb-3 mt-2">
            <div class=" tableWidth mt-2 px-4">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-secondary/5 text-sm  text-black">
                            <tr class="">
                                <th colspan="2" class="text-center py-3 ">DAYS</th>
                                <th rowspan="2" class="text-center">PENAL INTEREST
                                    <br> RATE (%) (MONTHLY)
                                </th>
                                <th rowspan="2" class="text-center py-3 ">
                                    ANNUAL INTEREST
                                    RATE (%)

                                </th>

                            </tr>
                            <tr class="">
                                <th class="text-center ">FROM </th>
                                <th class="text-center  ">TO</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm text-center">
                            <tr class="bg-gray-50 border-b  ">
                                <td class="px-4 py-2 text-sm ">1</td>
                                <td class="px-4 py-2 text-sm">30</td>
                                <td class="px-4 py-2 text-sm">0 %</td>
                                <td class="px-4 py-2 text-sm">20 %</td>
                            </tr>
                            <tr class="bg-gray-50 border-b ">
                                <td class="px-4 py-2 text-sm">31</td>
                                <td class="px-4 py-2 text-sm">60</td>
                                <td class="px-4 py-2 text-sm">0 %</td>
                                <td class="px-4 py-2 text-sm">20 %</td>
                            </tr>
                            <tr class="bg-gray-50 border-b ">
                                <td class="px-4 py-2 text-sm">61</td>
                                <td class="px-4 py-2 text-sm">90</td>
                                <td class="px-4 py-2 text-sm">0 %</td>
                                <td class="px-4 py-2 text-sm">20 %</td>
                            </tr>
                            <tr class="bg-gray-50 border-b ">
                                <td class="px-4 py-2 text-sm">91</td>
                                <td class="px-4 py-2 text-sm">120</td>
                                <td class="px-4 py-2 text-sm">0 %</td>
                                <td class="px-4 py-2 text-sm">20 %</td>
                            </tr>
                            <tr class="bg-gray-50 border-b ">
                                <td class="px-4 py-2 text-sm">121</td>
                                <td class="px-4 py-2 text-sm">150</td>
                                <td class="px-4 py-2 text-sm">0 %</td>
                                <td class="px-4 py-2 text-sm">20 %</td>
                            </tr>
                            <tr class="bg-gray-50 border-b ">
                                <td class="px-4 py-2 text-sm">151</td>
                                <td class="px-4 py-2 text-sm">180</td>
                                <td class="px-4 py-2 text-sm">0 %</td>
                                <td class="px-4 py-2 text-sm">20 %</td>
                            </tr>
                            <tr class="bg-gray-50 border-b ">
                                <td class="px-4 py-2 text-sm">181</td>
                                <td class="px-4 py-2 text-sm">210</td>
                                <td class="px-4 py-2 text-sm">0 %</td>
                                <td class="px-4 py-2 text-sm">20 %</td>
                            </tr>
                            <tr class="bg-gray-50 border-b ">
                                <td class="px-4 py-2 text-sm">211</td>
                                <td class="px-4 py-2 text-sm">240</td>
                                <td class="px-4 py-2 text-sm">0 %</td>
                                <td class="px-4 py-2 text-sm">20 %</td>
                            </tr>
                            <tr class="bg-gray-50 border-b ">
                                <td class="px-4 py-2 text-sm">241</td>
                                <td class="px-4 py-2 text-sm">270</td>
                                <td class="px-4 py-2 text-sm">0 %</td>
                                <td class="px-4 py-2 text-sm">20 %</td>
                            </tr>
                            <tr class="bg-gray-50 border-b ">
                                <td class="px-4 py-2 text-sm">271</td>
                                <td class="px-4 py-2 text-sm">300</td>
                                <td class="px-4 py-2 text-sm">0 %</td>
                                <td class="px-4 py-2 text-sm">20 %</td>
                            </tr>
                            <tr class="bg-gray-50 border-b ">
                                <td class="px-4 py-2 text-sm">301</td>
                                <td class="px-4 py-2 text-sm">330</td>
                                <td class="px-4 py-2 text-sm">0 %</td>
                                <td class="px-4 py-2 text-sm">20 %</td>
                            </tr>
                            <tr class="bg-gray-50 border-b ">
                                <td class="px-4 py-2 text-sm">331</td>
                                <td class="px-4 py-2 text-sm">365</td>
                                <td class="px-4 py-2 text-sm">0 %</td>
                                <td class="px-4 py-2 text-sm">20 %</td>
                            </tr>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

    <div class="w-full mt-5">
        <!-- Card -->
        <div class="box shadow-md rounded-10">
            <!-- Header -->
            <div class="flex items-center justify-between px-4 py-3 dark:bg-bg3 bg-secondary/5 rounded-10 ">
                <h3 class="text-lg font-semibold text-gray-800">GOLD LOAN SETTING AUDIT TRAIL</h3>
                <button type="button" class="p-1 rounded transition" onclick="toggleSection(this, 'auditTrail')">
                    <span class="toggle-icon text-lg font-bold">−</span>
                </button>
            </div>

            <!-- Body -->
            <div class="p-4" id="auditTrail">
                <div class="overflow-x-auto">
                    <table class="w-full  text-sm md:text-base">
                        <thead class="bg-gray-100">
                            <tr class="text-start">
                                <th class="px-4 py-2 text-start">Creator</th>
                                <th class="px-4 py-2 text-start">Event</th>
                                <th class="px-4 py-2 text-start ">Created On</th>
                                <th class="px-4 py-2 text-start">Change Logs</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="text-start">
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>



<script>
    // <!-- collapsed logic + - button-->

    function toggleSection(button, sectionId) {
        const section = document.getElementById(sectionId);
        const icon = button.querySelector('.toggle-icon');

        section.classList.toggle('hidden');
        icon.textContent = section.classList.contains('hidden') ? '+' : '−';
    }
</script>
@endsection