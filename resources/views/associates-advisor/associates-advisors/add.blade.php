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
            <div class="flex items-center flex-col  gap-2">
                <h3 class="text-xl uppercase font-semibold">
                    New Associate/ Advisor
                </h3>

            </div>

        </div>

        <div class="col-span-12 box lg:col-span-12">

            <form class="">
                <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

                    <div class="col-span-2 md:col-span-1">
                        <label for="scheme_name" class="md:text-lg uppercase font-medium block mb-4">
                            Associate Employee Profile (if any)

                        </label>
                        <select name="" id=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                            <option value=""> Select Employee Profile of this New Associate</option>
                        </select>
                    </div>
                    <div class="col-span-2 md:col-span-1"></div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block uppercase mb-4">
                            Associate Rank
                        </label>
                        <select name="" id=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                            <option value=""> Select Rank</option>
                        </select>
                        <p class="text-primary mt-2 text-sm">
                            (select this if you want commission payout for agent)
                        </p>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium uppercase block mb-4">
                            Associate Supervisor
                        </label>
                        <select name="" id=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                            <option value=""> Select Supervisor</option>
                        </select>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="anuual_interest_rate" class="md:text-lg font-medium block mb-4 uppercase">
                            Enrollment Date
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="" name=""
                            class="datepicker-field w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                            placeholder="DD/MM/YYYY">

                    </div>

                    <div class="col-span-2 md:col-span-1"></div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                            First Name
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="col-sm-7">
                            <div class="flex items-center gap-2">
                                <input type="text" id="" name=""
                                    class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Enter First Name">
                            </div>
                        </div>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                            Last Name
                        </label>
                        <div class="col-sm-7">
                            <div class="flex items-center gap-2">
                                <input type="text" id="" name=""
                                    class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Enter Last Name">
                            </div>
                        </div>
                    </div>


                    <div class="col-span-2 md:col-span-1">
                        <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                            Login User Name <span class="text-red-500">*</span>
                        </label>
                        <div class="col-sm-7">
                            <div class="flex items-center gap-2">
                                <input type="text" id="" name=""
                                    class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Enter User Name">
                            </div>
                        </div>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                            Email
                        </label>
                        <div class="col-sm-7">
                            <div class="flex items-center gap-2">
                                <input type="email" id="" name=""
                                    class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Enter User Name">
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                            Mobile No <span class="text-red-500">*</span>
                        </label>
                        <div class="col-sm-7">
                            <div class="flex items-center gap-2">
                                <input type="text" name="" id="" value="+91" disabled
                                    class="w-20 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">
                                <input type="number" id="" name=""
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Enter Mobile No ">
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                            Date of Birth
                        </label>
                        <div class="col-sm-7">
                            <div class="flex items-center gap-2">
                                <input type="text" id="date" name=""
                                    class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="DD/MM/YYYY">
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                            Father Name
                        </label>
                        <div class="col-sm-7">
                            <div class="flex items-center gap-2">
                                <input type="text" id="" name=""
                                    class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Enter Father Name">
                            </div>
                        </div>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                            Husband/ Wife Name
                        </label>
                        <div class="col-sm-7">
                            <div class="flex items-center gap-2">
                                <input type="text" id="" name=""
                                    class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Enter Husband/ Wife Name">
                            </div>
                        </div>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                            PAN No
                        </label>
                        <div class="col-sm-7">
                            <div class="flex items-center gap-2">
                                <input type="text" id="" name="" style="text-transform: uppercase"
                                    class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Enter Husband/ Wife Name">
                            </div>
                        </div>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                            Aadhaar No
                        </label>
                        <div class="col-sm-7">
                            <div class="flex items-center gap-2">
                                <input type="number" id="" name=""
                                    class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Enter Husband/ Wife Name">
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                            Address
                        </label>
                        <div class="col-sm-7">
                            <div class="flex items-center gap-2">
                                <textarea type="number" id="" name=""
                                    class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Enter Address"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-2 md:col-span-1"></div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                            Back Date Entry Days
                            <span class="text-error">*</span>
                        </label>
                        <div class="col-sm-7">
                            <div class="flex items-center gap-2">
                                <input type="number" id="" name=""
                                    class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="0">
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1"></div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                            Permissions / Roles
                            {{-- <span class="text-error">*</span> --}}
                        </label>
                        <div class="col-sm-7">
                            <div class="flex items-center gap-2">
                                <input type="number" id="" name=""
                                    class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Select Role">
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                            Branch
                            <span class="text-error">*</span>
                        </label>
                        <div class="col-sm-7">
                            <div class="flex items-center gap-2">
                                <select id="" name=""
                                    class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="">
                                    <option value="">Select Branch</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4">
                            Access Type
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="access-type" value="">
                                <span>Admin App</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="access-type" value="">
                                <span> Agent App </span>
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="radio" name="access-type" value="">
                                <span> Both App</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1"></div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4">
                            Login on Holidays
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="Login" value="">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="Login" value="">
                                <span> No </span>
                            </label>

                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4">
                            Searchable Accounts
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="sa" value="">
                                <span> Yes - All </span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="sa" value="">
                                <span> No - Only Assigned</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1 mb-6">
                        <label for="" class="md:text-lg font-medium block mb-4">
                            Active
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="active" value="">
                                <span> Yes </span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="active" value="">
                                <span> No </span>
                            </label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="mt-5">
                    <P class="text-center text-xl uppercase font-semibold">
                        Nominee Info
                    </P>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6 ">
                    <div class="col-span-2 md:col-span-1">
                        <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                            Nominee Name
                        </label>
                        <div class="col-sm-7">
                            <div class="flex items-center gap-2">
                                <input type="text" id="" name=""
                                    class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Enter Nominee Name ">

                            </div>
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                            Nominee Relation
                        </label>
                        <div class="col-sm-7">
                            <div class="flex items-center gap-2">
                                <select id="" name=""
                                    class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                                    <option value="">Select Relation </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1 ">
                        <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                            Nominee Address
                        </label>
                        <div class="col-sm-7">
                            <div class="flex items-center gap-2">
                                <textarea id="" name=""
                                    class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Enter Nominee Address"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Buttons -->
                <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                    <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                      ADD ASSSOCIATE/ ADVISORS
                    </button>

                    <button class="btn-outline uppercase justify-center" type="reset">
                        <a href=""> BACK</a>
                    </button>
                     <button class="btn-warning uppercase justify-center" type="reset">
                        <a href=""> RESET</a>
                    </button>
                </div>

            </form>
        </div>
    </div>


    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

    <!-- Datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const datepickers = document.querySelectorAll('.datepicker-field');
            const today = new Date();

            datepickers.forEach(function (dateInput) {
                // Initialize the datepicker with maxDate = today
                const picker = new Datepicker(dateInput, {
                    autohide: true,
                    format: 'dd-mm-yyyy',
                    maxDate: today,
                });

                // Format today's date as dd-mm-yyyy
                const formattedDate = today.toLocaleDateString('en-GB').split('/').join('-');
                dateInput.value = formattedDate; // Set today's date by default

                // Optional: If there’s a calendar icon nearby, open picker on click
                const calendarIcon = dateInput.parentElement.querySelector('.la-calendar');
                if (calendarIcon) {
                    calendarIcon.addEventListener('click', () => picker.show());
                }
            });
        });
    </script>

@endsection