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
                    ASSOCIATE/ ADVISOR - GAYATRI DEVI
                </h3>
            </div>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">

            <!-- Left: Details -->
            <div class=" w-full  overflow-hidden ">
                <!--SMS SETTINGS-->
                <div class="box dark:bg-bg3 border-gray-200 shadow-md rounded-lg">
                    <!-- Header -->
                    <div class="px-4 py-3">
                        <h3 class="text-lg border-b font-semibold text-black uppercase"> Photo</h3>
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
                                change photo
                            </button>

                        </div>
                    </div>

                </div>

                <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">

                    <div class="border-b flex items-center bg-secondary/5 justify-between px-4 py-2 rounded-10 ">
                        <h3 class="text-lg font-semibold text-black  uppercase">
                            Commission Amount
                        </h3>

                    </div>
                    <!-- Body -->
                    <div class="p-4" id="">
                        <div class="overflow-x-auto text-center mt-5">
                            <div class="w-full overflow-x-auto">
                                <table class="w-full text-sm text-left border-collapse whitespace-nowrap">
                                    <tbody class="divide-y divide-gray-200">
                                        <tr class="border-b">
                                            <td class="font-semibold uppercase px-4 py-2 w-1/3">Total Earned</td>
                                            <td class="px-4 py-2">
                                                ₹ 0.00
                                            </td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold uppercase px-4 py-2">
                                                Total Withdrawn
                                            </td>
                                            <td class="px-4 py-2 capitalize ">
                                                ₹ 0.00
                                            </td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold uppercase px-4 py-2">
                                                Balance
                                            </td>
                                            <td class="px-4 py-2 capitalize  ">
                                                ₹ 0.00
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="border-b flex items-center bg-secondary/5 justify-between px-4 py-2 rounded-10 ">
                        <h3 class="text-lg font-semibold text-black  uppercase">
                            Transaction Info
                        </h3>
                        <div class="">
                            <button type="button" class="p-1 rounded transition" onclick="toggleSection(this, 'tinfo')">
                                <span class="toggle-icon text-lg font-bold">−</span>
                            </button>
                        </div>
                    </div>
                    <!-- Body -->
                    <div class="p-4" id="tinfo">
                        <div class="overflow-x-auto">
                            <p class="capitalize">No Transaction Found</p>
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
                                        <a href="#" class=" p-2 rounded-10 text-sm btn-primary uppercase">
                                            Link Saving Account
                                        </a>

                                        <a href="#" class=" p-2 rounded-10 text-sm btn-warning uppercase">
                                            id card
                                        </a>
                                        <a href="#" class=" p-2 rounded-10 text-sm btn-primary">
                                            {{-- print --}}
                                            <i class="las la-print"></i>
                                        </a>
                                        <a href="{{ route('associate.edit', $associate->id) }}" 
                                            class="p-2 rounded-10 text-sm btn-primary">
                                                <i class="las la-pencil-alt"></i>
                                        </a>
                                        <a href="#" class=" p-2 rounded-10 text-sm btn-secondary uppercase">
                                            <i class="las la-sync"></i>
                                        </a>
                                        <a href="#" class=" p-2 rounded-10 text-sm btn-secondary uppercase">
                                            <i class="las la-lock"></i>
                                        </a>
                                        <a href="#" class=" p-2 rounded-10 text-sm btn-secondary uppercase">
                                            <i class="las la-sign-out-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2 w-1/3">Employee Profile</td>
                                <td class="px-4 py-2">
                                    <a href="" class="  capitalize text-primary">
                                        {{ $associate->first_name }} {{ $associate->last_name }}
                                    </a>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Supervisor
                                </td>
                                <td class="px-4 py-2 capitalize ">
                                    <a href="" class="  capitalize text-primary">
                                        {{ $associate->supervisor ? $associate->supervisor->first_name.' '.$associate->supervisor->last_name : '—' }}
                                    </a>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Rank
                                </td>
                                <td class="px-4 py-2 capitalize  ">
                                    - C DIRECTOR
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">Code</td>
                                <td class="px-4 py-2 capitalize">{{ $associate->code }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">
                                    User Name (LOGIN)
                                </td>
                                <td class="px-4 py-2 capitalize">
                                    {{ $associate->username }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Name
                                </td>
                                <td class="px-4 py-2 uppercase">
                                    {{ $associate->first_name }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Date Of Birth
                                </td>
                                <td class="px-4 py-2 capitalize">
                                    {{ $associate->dob ? $associate->dob->format('d-m-Y') : '' }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Enrollment Date
                                </td>
                                <td class="px-4 py-2 capitalize">
                                    {{ $associate->enrollment_date ? $associate->enrollment_date->format('d-m-Y') : '' }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Father Name
                                </td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Husband/ Wife Name
                                </td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Email
                                </td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Contact No.
                                </td>
                                <td class="px-4 py-2 capitalize">
                                    {{ $associate->phone }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Address
                                </td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Aadhaar No.
                                </td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Pan No.
                                </td>
                                <td class="px-4 py-2 capitalize"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Branches
                                </td>
                                <td class="px-4 py-2 capitalize">
                                    MAVLI
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Roles
                                </td>
                                <td class="px-4 py-2 capitalize text-primary">

                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Active
                                </td>
                                <td class="px-4 py-2 capitalize">
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
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Account Login Locked
                                </td>
                                <td class="px-4 py-2 capitalize">
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
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Login on Holidays
                                </td>
                                <td class="px-4 py-2 capitalize">
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
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                    Search All Accounts (Yes) / Only Assigned (No)	
                                </td>
                                <td class="px-4 py-2 capitalize">
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
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                   Access Type	
                                </td>
                                <td class="px-4 py-2 capitalize">
                                    Admin app
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                   Collection Limit	
                                </td>
                                <td class="px-4 py-2 capitalize">
                                    0.00
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">
                                   Back Date Entry Allowed Days	
                                </td>
                                <td class="px-4 py-2 capitalize">
                                    365 Days
                                </td>
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


                        </tbody>
                    </table>
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