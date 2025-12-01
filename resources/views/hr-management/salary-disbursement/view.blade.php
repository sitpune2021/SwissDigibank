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
                    Salary Disbursements - MINL0011
                </h3>

            </div>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between  gap-5">
            <div class=" w-full  overflow-hidden ">
                <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">
                    <div class="">
                        <!-- Header Buttons -->
                        <div class="mb-5">

                            <div class="flex gap-2 justify-end">
                                <!-- Print Button -->
                                <a href="" class=" btn-primary rounded-10 py-2 px-3 ">
                                    <i class="las la-print "></i>
                                    PRINT
                                </a>

                                <!-- Delete Button -->
                                <a href="" class="btn-error rounded-10 py-2 px-3 ">
                                    <i class="las la-trash-alt "></i>
                                </a>
                            </div>
                        </div>

                        <!-- Salary Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full whitespace-nowrap rounded-lg ">
                                <tbody class="divide-y divide-gray-100">
                                    <tr class="border-b">
                                        <td class="font-semibold px-4 py-2 text-gray-700 uppercase">Salary Paid</td>
                                        <td class="px-4 py-2 text-gray-800">₹ 13,545.00</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold px-4 py-2 text-gray-700 uppercase">Salary Month</td>
                                        <td class="px-4 py-2 text-gray-800">October 2025</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold px-4 py-2 text-gray-700 uppercase">Working Days</td>
                                        <td class="px-4 py-2 text-gray-800">26.0 days</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold px-4 py-2 text-gray-700 uppercase">Reference ID</td>
                                        <td class="px-4 py-2 text-gray-800">SDDBE002A4</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold px-4 py-2 text-gray-700 uppercase">Transaction Status</td>
                                        <td class="px-4 py-2 text-gray-800">Approved</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold px-4 py-2 text-gray-700 uppercase">Payable Date</td>
                                        <td class="px-4 py-2 text-gray-800">31-10-2025</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold px-4 py-2 text-gray-700 uppercase">Transaction Date</td>
                                        <td class="px-4 py-2 text-gray-800">31-10-2025</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold px-4 py-2 text-gray-700 uppercase">UAN No</td>
                                        <td class="px-4 py-2 text-gray-800">0</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold px-4 py-2 text-gray-700 uppercase">PF No</td>
                                        <td class="px-4 py-2 text-gray-800">0</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold px-4 py-2 text-gray-700 uppercase">ESIC No</td>
                                        <td class="px-4 py-2 text-gray-800">0</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold px-4 py-2 text-gray-700 uppercase">Payment Mode</td>
                                        <td class="px-4 py-2 text-gray-800">System</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold px-4 py-2 text-gray-700 uppercase">Remarks</td>
                                        <td class="px-4 py-2 text-gray-800">—</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold px-4 py-2 text-gray-700 uppercase">Created At</td>
                                        <td class="px-4 py-2 text-gray-800">03-11-2025 </td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold px-4 py-2 text-gray-700 uppercase">Updated At</td>
                                        <td class="px-4 py-2 text-gray-800">03-11-2025 </td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold px-4 py-2 text-gray-700 uppercase">Is Accounted</td>
                                        <td class="px-4 py-2">
                                            <div class="flex items-center gap-1">
                                                <span
                                                    class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                    Yes
                                                </span>
                                                <span
                                                    class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                    No
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">
                    <div class="">
                        <p class="text-xl font-bold border-b">
                            BANK ACCOUNT INFO
                        </p>
                        <!-- Salary Table -->
                        <div class="overflow-x-auto mt-5">
                            <table class="w-full whitespace-nowrap rounded-lg ">
                                <tbody class="divide-y divide-gray-100">
                                    <tr class="border-b">
                                        <td class="font-semibold px-4 py-2 text-gray-700 uppercase">Bank Name </td>
                                        <td class="px-4 py-2 text-gray-800"></td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold px-4 py-2 text-gray-700 uppercase">Bank A/c Holder's Name
                                        </td>
                                        <td class="px-4 py-2 text-gray-800"></td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold px-4 py-2 text-gray-700 uppercase">Bank A/c No </td>
                                        <td class="px-4 py-2 text-gray-800"></td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold px-4 py-2 text-gray-700 uppercase">IFSC Code</td>
                                        <td class="px-4 py-2 text-gray-800"></td>
                                    </tr>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right: Settings -->
            <div class=" w-full mt-3 overflow-hidden">
                <div class="overflow-x-auto box rounded-lg dark:bg-bg3 p-2 bg-white shadow-md">
                    <table class="w-full text-sm text-left border-collapse whitespace-nowrap">
                        <tbody class="divide-y divide-gray-200">
                            <tr class="border-b">
                                <td class="font-semibold text-center uppercase px-4 py-2 w-1/3" colspan="2">
                                    SALARY DETAILS
                                </td>

                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2 w-1/3">
                                    Basic Salary
                                </td>
                                <td class="px-4 py-2">
                                    8,387.00
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    HRA
                                </td>
                                <td class="px-4 py-2 capitalize ">
                                    1,258.00
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Education Allowance
                                </td>
                                <td class="px-4 py-2  ">
                                    419.00
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">LTA </td>
                                <td class="px-4 py-2 capitalize">84.00</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Telephone Reimbursement </td>
                                <td class="px-4 py-2 capitalize">251.00 </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Fuel Charges
                                </td>
                                <td class="px-4 py-2 uppercase"> 419.00 </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Driver Charges
                                </td>
                                <td class="px-4 py-2 capitalize">
                                    127.00
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Helper Allowance
                                </td>
                                <td class="px-4 py-2 capitalize">126.00</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Special Allowance
                                </td>
                                <td class="px-4 py-2 capitalize">
                                    755.00
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Variable Amount
                                </td>
                                <td class="px-4 py-2 capitalize">5,032.00</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Gross Salary
                                </td>
                                <td class="px-4 py-2 capitalize">
                                    16,858.00
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase text-center px-4 py-2" colspan="2">DEDUCTION DETAILS</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Employee PF
                                </td>
                                <td class="px-4 py-2 capitalize">1,006.00</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Employer PF
                                </td>
                                <td class="px-4 py-2 capitalize">
                                    1,006.00
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Gratuity
                                </td>
                                <td class="px-4 py-2 capitalize">
                                    126.00
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    ESIC Employee
                                </td>
                                <td class="px-4 py-2 capitalize">
                                    588.00
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    ESIC Employer
                                </td>
                                <td class="px-4 py-2 capitalize ">
                                    587.00
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    TDS
                                </td>
                                <td class="px-4 py-2 capitalize">
                                    0.00
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Professional Tax
                                </td>
                                <td class="px-4 py-2 capitalize">
                                    0.00
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Rounding Off
                                </td>
                                <td class="px-4 py-2 capitalize">
                                    0.0
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Total Deduction
                                </td>
                                <td class="px-4 py-2 capitalize">
                                    3,313.00
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2 text-center" colspan="2">
                                    NET PAYABLE
                                </td>

                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Net Salary
                                </td>
                                <td class="px-4 py-2 capitalize">
                                    Net Salary
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="box w-full max-w-4xl bg-white  rounded-lg shadow-md mt-5 overflow-hidden">
            <!-- Header -->
            <div class="box-header flex justify-between items-center bg-secondary/5 rounded-10 px-4 py-3">
                <h3 class="text-lg font-semibold">SALARY TRANSACTION AUDIT TRAIL</h3>
                <button type="button" class="" data-widget="collapse">
                    <i class="las la-plus "></i>
                </button>
            </div>

            <!-- Body -->
            <div class="box-body bg-white px-4 py-3 transition-all duration-300 ease-in-out">
                <div class="overflow-x-auto">
                    <table class="w-full rounded-10 ">
                        <thead class="bg-gray-100">
                            <tr class="text-gray-700 border-b text-center">
                                <th class="py-2 px-3  text-center font-semibold">Creator</th>
                                <th class="py-2 px-3  text-center font-semibold">Event</th>
                                <th class="py-2 px-3  text-center font-semibold">Created On</th>
                                <th class="py-2 px-3  text-center font-semibold">Change Logs</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example Row -->
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-3  text-center"></td>
                                <td class="py-2 px-3  text-center"></td>
                                <td class="py-2 px-3  text-center"></td>
                                <td class="py-2 px-3  text-center"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>







    <script>
        function toggleDropdown(id) {
            document.getElementById(id).classList.toggle("hidden");
        }

        // Close dropdown if clicked outside
        window.addEventListener("click", function (e) {
            const dropdown = document.getElementById("printDropdown");
            if (!e.target.closest("button") && !e.target.closest("#printDropdown")) {
                dropdown.classList.add("hidden");
            }
        });
    </script>





    <script>

        function openDatePicker() {
            document.getElementById('date').click();
        }
        // <!-- collapsed logic + - button-->

        function toggleSection(button, sectionId) {
            const section = document.getElementById(sectionId);
            const icon = button.querySelector('.toggle-icon');

            section.classList.toggle('hidden');
            icon.textContent = section.classList.contains('hidden') ? '+' : '−';
        }

    </script>

    {{-- SALARY TRANSACTION AUDIT TRAIL --}}
    <script>
        // Collapse/expand toggle SALARY TRANSACTION AUDIT TRAIL
        document.addEventListener("DOMContentLoaded", () => {
            const toggleButtons = document.querySelectorAll("[data-widget='collapse']");
            toggleButtons.forEach(btn => {
                btn.addEventListener("click", () => {
                    const boxBody = btn.closest(".box").querySelector(".box-body");
                    const icon = btn.querySelector("i");

                    boxBody.classList.toggle("hidden");
                    icon.classList.toggle("fa-plus");
                    icon.classList.toggle("fa-minus");
                });
            });
        });
    </script>

@endsection