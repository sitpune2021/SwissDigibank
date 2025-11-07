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
                    ROMITA MUKHERJEE
                </h3>
                <p class="text-xs text-gray-500">
                    Employee
                </p>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">

            <a href="" class="btn-primary uppercase px-2 py-2 rounded-10 ">
                View Transactions
            </a>

            <a href="" class="btn-error  uppercase px-2 py-2 rounded-10 ">
                Pay Salary
            </a>
            <a href="" class="btn-warning  uppercase px-2 py-2 rounded-10 ">
                Salary Settlement
            </a>

        </div>



        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">

            <!-- Left: Details -->
            <div class=" w-full  overflow-hidden ">
                <!--SMS SETTINGS-->
                <div class="box dark:bg-bg3 border-gray-200 shadow-md rounded-lg">
                    <!-- Header -->
                    <div class="px-4 py-3">
                        <h3 class="text-lg border-b font-semibold text-black uppercase"> Employee Photo</h3>
                    </div>
                    <div class="p-4 overflow-x-auto">
                        <div class="flex justify-center">
                            <div class="bg-secondary/5 flex items-center justify-center text-gray-500 font-semibold rounded-10"
                                style="width: 150px ; height: 150px;">
                                150 X 150
                            </div>
                        </div>
                        <div class="flex justify-center gap-3 mt-7">
                            <button class="btn-warning rounded-10 uppercase">
                                <i class="las la-pencil-alt"></i>
                                change
                            </button>
                            <button class="btn-primary rounded-10 uppercase">webcam</button>
                        </div>
                    </div>

                </div>

                <!-- SALARY DETAILS-->
                <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">

                    <div class="border-b flex items-center bg-secondary/5 justify-between px-4 py-2 rounded-10 ">
                        <h3 class="text-lg font-semibold text-black  uppercase">
                            SALARY DETAILS
                        </h3>
                        <div class="">
                            <button class="btn-primary rounded-10 px-2 py-1 uppercase">
                                +New Salary
                            </button>
                            <button type="button" class="p-1 rounded transition" {{--
                                onclick="toggleSection(this, 'salaryDetails')">
                                <span class="toggle-icon text-lg font-bold">−</span> --}}
                            </button>
                        </div>
                    </div>
                    <!-- Body -->
                    <div class="p-4" id="">
                        <div class="overflow-x-auto text-center mt-5">
                            <div class="w-full overflow-x-auto">
                                <table class="w-full  rounded-lg text-sm">
                                    <thead class="bg-secondary/5">
                                        <tr>
                                            <th class="px-3 py-2 text-start">SALARY</th>
                                            <th class="px-3 py-2 text-start">START DATE</th>
                                            <th class="px-3 py-2 text-start">ACTIVE</th>
                                            <th class="px-3 py-2 text-start">ACTIONS</th>

                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-200">
                                        <tr class="border-b">
                                            <td class="px-3 py-2">
                                                650000.0
                                            </td>
                                            <td class="px-3 py-2">
                                                01-10-2025
                                            </td>
                                            <td class=" py-2 text-center">
                                                <span
                                                    class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-1 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 uppercase">
                                                    YES
                                                </span>
                                                <span
                                                    class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-1 text-center text-xs  mt-2 text-error dark:border-n500 dark:bg-bg3 xxl:w-16 uppercase">
                                                    NO
                                                </span>
                                            </td>
                                            <td class="px-3 py-2 text-center">
                                                <div class="flex gap-2">
                                                    <div class="btn-primary p-1 rounded-10 border-primary">
                                                        <i class="las la-eye"></i>
                                                    </div>
                                                    <div class="btn-warning  p-1 rounded-10  border-warning">
                                                        <i class="las la-pencil-alt"></i>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>


                <!--USER ASSOCIATE DETAILS-->
                <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">

                    <div class="border-b flex items-center bg-secondary/5 justify-between px-4 py-2 rounded-10 ">
                        <h3 class="text-lg font-semibold text-black  uppercase">
                            USER ASSOCIATE DETAILS

                        </h3>
                        <div class="">
                            <button type="button" class="p-1 rounded transition" {{--
                                onclick="toggleSection(this, 'goldLoanAppInfo')">
                                <span class="toggle-icon text-lg font-bold">−</span --}}>
                            </button>
                        </div>
                    </div>
                    <!-- Body -->
                    <div class="overflow-x-auto mt-5 " id="goldLoanAppInfo">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full  rounded-lg text-sm">
                                <thead class="bg-secondary/5">
                                    <tr>
                                        <th class="px-3 py-2 text-start uppercase">NAME</th>

                                        <th class="px-3 py-2 text-start uppercase">ACTIVE</th>
                                        <th class="px-3 py-2 text-start uppercase">ACTIONS</th>

                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    <tr class="border-b">
                                        <td class="px-3 py-2 text-start">
                                            650000.0
                                        </td>

                                        <td class=" py-2 text-start">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-1 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 uppercase">
                                                YES
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-1 text-center text-xs  mt-2 text-error dark:border-n500 dark:bg-bg3 xxl:w-16 uppercase">
                                                NO
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 text-start">
                                            <div class="btn-primary p-1 rounded-10 border-primary">
                                                <i class="las la-calendar"></i>

                                            </div>


                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Settings -->
            <div class=" w-full  overflow-hidden">
                <div class="overflow-x-auto box rounded-lg dark:bg-bg3 p-2 bg-white shadow-md">

                    <table class="w-full text-sm text-left border-collapse whitespace-nowrap">
                        <tbody class="divide-y divide-gray-200">
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2 w-1/3" colspan="2">
                                    <div class="flex justify-start gap-2  p-3">
                                        <a href="#" class=" p-2 rounded-10 text-sm btn-error uppercase">
                                            Discard Employee
                                        </a>

                                        <a href="#" class=" p-2 rounded-10 text-sm btn-warning uppercase">
                                            id card
                                        </a>
                                        <a href="#" class=" p-2 text-sm btn-primary">
                                            {{-- print --}}
                                            <i class="las la-print"></i>
                                        </a>

                                        <a href="#" class=" p-2 rounded-10 text-sm btn-secondary uppercase">
                                            Appointment Letter
                                        </a>
                                        <a href="#" class=" p-2 text-sm btn-primary">
                                            <i class="las la-pencil-alt"></i>
                                        </a>

                                    </div>
                                </td>

                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2 w-1/3">Joining Date</td>
                                <td class="px-4 py-2">
                                    <a href="" class="  capitalize hover:underline">
                                        22-10-2025
                                    </a>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Leaving Date</td>
                                <td class="px-4 py-2 capitalize "></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Member Profile</td>
                                <td class="px-4 py-2 capitalize text-primary ">
                                    DEMO-04287 - kuldeeeeeeep
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">Branch</td>
                                <td class="px-4 py-2 capitalize">sharanpur</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Designation</td>
                                <td class="px-4 py-2 capitalize"> </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Employee Code</td>
                                <td class="px-4 py-2 uppercase"> MINL0012 </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Name</td>
                                <td class="px-4 py-2 capitalize">manoj</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Gender</td>
                                <td class="px-4 py-2 capitalize">Male</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Date Of Birth</td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Blood Group</td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Father Name</td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Email</td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Contact No.</td>
                                <td class="px-4 py-2 capitalize">7878676745</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Address</td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Aadhaar No.</td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Pan No.</td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Accounting Ledger
                                </td>
                                <td class="px-4 py-2 capitalize text-primary">
                                    Loan Paid A/C - Loan Paid A/C
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Monthly Salary
                                </td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Nominee Name
                                </td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Nominee Relation
                                </td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Nominee Address
                                </td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Bank Name
                                </td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Bank A/c Holder's Name
                                </td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Bank A/c No
                                </td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    IFSC Code
                                </td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Location
                                </td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>


                        </tbody>
                    </table>
                </div>

                <!--documents-->
                <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="border-b flex items-center bg-secondary/5 justify-between px-4 py-2 rounded-10 ">
                        <h3 class="text-lg font-semibold text-black  uppercase">
                            Documents

                        </h3>

                        <div class="">
                            <a href="#" class="btn-primary p-1 pointer">
                                <i class="las la-upload y"></i>
                            </a>

                            <button type="button" class="p-1 rounded transition" onclick="toggleSection(this, 'Documents')">
                                <span class="toggle-icon text-lg font-bold">−</span>
                            </button>
                        </div>
                    </div>
                    <!-- Body -->
                    <div class="p-4" id="Documents">
                        <div class="overflow-x-auto">
                            <p class="capitalize">No documents found</p>
                            <table class="w-full text-md  whitesapce-nowrap mt-3">
                                <thead class="bg-gray-100  text-start">
                                    <tr class="text-start">
                                        <th class="px-2 py-2 font-semibold text-start text-gray-700 uppercase">
                                            Name</th>
                                        <th class="px-2 py-2 font-semibold text-start text-gray-700 uppercase"> URL</th>
                                        <th class="px-2 py-2 font-semibold text-start text-gray-700 uppercase"> Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t border-b">
                                        <td class="px-2 py-2 text-gray-800 capitalize"> xyz</td>
                                        <td class="px-2 py-2 text-gray-800 capitalize">No Document Present</td>

                                        <td class="px-2 py-2 text-error capitalize">
                                            <a href="" class="btn-error p-1">
                                                <i class="las la-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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

@endsection