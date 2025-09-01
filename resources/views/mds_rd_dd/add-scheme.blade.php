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
            <h1 class="text-xl font-semibold">New RD/ DD Scheme</h1>
            <p class="text-gray-500">
                <a href="#" class="text-gray-500">RD/ DD Scheme</a> >
                <a href="#" class="text-gray-500"> New</a>
            </p>

        </div>

    </div>

    <div class="col-span-12 box lg:col-span-12">

        <form class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">
            <div class="col-span-2 md:col-span-1">
                <label for="" class="md:text-lg font-medium block mb-4">
                    Scheme Name
                    <span class="text-red-500">*</span>
                </label>

                <input type="text" id="" name=""
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Scheme Name " value="">
            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="" class="md:text-lg font-medium block mb-4">
                    Scheme Code
                    <span class="text-red-500">*</span>
                </label>

                <input type="text" id="" name=""
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Scheme Code" value="">
            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="city" class="md:text-lg font-medium block mb-4">
                    Min. RD/ DD Amount
                    <span class="text-red-500">*</span>
                </label>

                <input type="text" id="" name=""
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Min Opening Amount" value="">
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="frequency" class="md:text-lg font-medium block mb-4">
                    RD/ DD Frequency
                    <span class="text-red-500">*</span>
                </label>

                <select id="frequency" name="frequency"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    <option value="">Select frequency</option>
                    <option value="daily">DAILY</option>
                    <option value="weekly">WEEKLY</option>
                    <option value="bi_weekly">BI_WEEKLY</option>
                    <option value="monthly">MONTHLY</option>
                    <option value="quarterly">QUARTERLY</option>
                    <option value="half_yearly">HALF_YEARLY</option>
                    <option value="yearly">YEARLY</option>
                </select>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="interet-rate" class="md:text-lg font-medium block mb-4">
                    Anuual Interest Rate(%)
                    <span class="text-red-500">*</span>
                </label>

                <input type="number" id="interes-rate" name=""
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Anuual Interest Rate(%) " value="">
            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="sr-citizen-interest-rate" class="md:text-lg font-medium block mb-4">
                    Sr. Citizen Add-on Interest Rate (%)
                    <span class="text-red-500">*</span>
                </label>

                <input type="number" id="sr-citizen-interest-rate" name="sr-citizen-interest-rate"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="0.0" value="Freedonia">
            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="bonus-rate" class="md:text-lg font-medium block mb-4">
                    Bonus Rate
                    <span class="text-red-500">*</span>
                </label>
                <div class="col-sm-7">
                    <div class="flex items-center gap-2">

                        <!-- Left Select -->
                        <select name="bonus-rate-type" id="bonus-rate-type round-10"
                            class="w-20 text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">
                            <option value="percentage">%</option>
                            <option value="fixed">FIXED</option>
                        </select>

                        <!-- Main Input -->
                        <input type="number" id="bonus-rate" name="bonus-rate"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" placeholder="0.0" value="">

                        <!-- Info Toggle 
                        <button type="button" onclick="alert('This is your bonus rate information')"
                            class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 p-2 hover:bg-primary/10">
                            <i class="las la-info-circle text-lg text-gray-500"></i>
                        </button> -->

                    </div>
                </div>

            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="interest-compounding-interval" class="md:text-lg font-medium block mb-4">
                    Interest Compounding Interval
                    <span class="text-red-500">*</span>
                </label>

                <select id="frequency" name="frequency"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    <option value="">Select frequency</option>
                    <option value="monthly">MONTHLY</option>
                    <option value="quarterly">QUARTERLY</option>
                    <option value="half_yearly">HALF_YEARLY</option>
                    <option value="yearly">YEARLY</option>
                </select>
            </div>


            <div class="col-span-2 md:col-span-1">
                <label for="interest-compounding-interval" class="md:text-lg font-medium block mb-4">
                    RD/ DD Lock In Period <span class="text-red-500">*</span>
                </label>

                <select id="rd-dd-lock-in-period" name="rd_dd_lock_in_period"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    <option value="">Select RD/ DD Lock In Period</option>
                    <option value="0">0 months</option>
                    <option value="3">3 months</option>
                    <option value="6">6 months</option>
                    <option value="9">9 months</option>
                    <option value="12">12 months</option>
                    <option value="15">15 months</option>
                    <option value="18">18 months</option>
                    <option value="21">21 months</option>
                    <option value="24">24 months</option>
                    <option value="27">27 months</option>
                    <option value="30">30 months</option>
                    <option value="33">33 months</option>
                    <option value="36">36 months</option>
                    <option value="39">39 months</option>
                    <option value="42">42 months</option>
                    <option value="45">45 months</option>
                    <option value="48">48 months</option>
                    <option value="51">51 months</option>
                    <option value="54">54 months</option>
                    <option value="57">57 months</option>
                    <option value="60">60 months</option>
                </select>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="interest-lock-in-period" class="md:text-lg font-medium block mb-4">
                    Interest Lock In Period <span class="text-red-500">*</span>
                </label>

                <select id="interest-lock-in-period" name="interest_lock_in_period"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    <option value="">Select Interest Lock In Period</option>
                    <option value="0">0 months</option>
                    <option value="3">3 months</option>
                    <option value="6">6 months</option>
                    <option value="9">9 months</option>
                    <option value="12">12 months</option>
                    <option value="15">15 months</option>
                    <option value="18">18 months</option>
                    <option value="21">21 months</option>
                    <option value="24">24 months</option>
                    <option value="27">27 months</option>
                    <option value="30">30 months</option>
                    <option value="33">33 months</option>
                    <option value="36">36 months</option>
                    <option value="39">39 months</option>
                    <option value="42">42 months</option>
                    <option value="45">45 months</option>
                    <option value="48">48 months</option>
                    <option value="51">51 months</option>
                    <option value="54">54 months</option>
                    <option value="57">57 months</option>
                    <option value="60">60 months</option>
                </select>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="tenure" class="md:text-lg font-medium block mb-4">
                    Tenure of RD/ DD
                    <span class="text-red-500">*</span>
                </label>
                <div class="col-sm-7">
                    <div class="flex items-center gap-2">


                        <select name="tenure-type" id="tenure-type" class="w-20 text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">
                            <option value="days">DAYS</option>
                            <option value="weeks">WEEKS</option>
                            <option value="months">MONTHS</option>
                        </select>

                        <input type="number" id="tenure" name="tenure"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" placeholder="Enter Tenure of RD/ DD" value="">

                        <!-- 
                        <button type="button" onclick="alert('This is your bonus rate information')"
                            class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 p-2 hover:bg-primary/10">
                            <i class="las la-info-circle text-lg text-gray-500"></i>
                        </button> -->
                    </div>
                </div>
            </div>

            <div class="col-span-2">
                <p name="tenure-info" class="text-blue-500"><strong>10.0 % TDS</strong> will be deducted, if the Interest exceeds ₹ 40,000.00 per annum.</p>
            </div>



            <div class="col-span-2 md:col-span-1">
                <label for="bonus-rate" class="md:text-lg font-medium block mb-4">
                    Cancellation Charges
                </label>
                <div class="col-sm-7">
                    <div class="flex items-center gap-2">
                        <select name="cancellation-charges-type" id="cancellation-charges-type"
                            class="w-20 text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">
                            <option value="percentage">%</option>
                            <option value="fixed">FIXED</option>
                        </select>

                        <input type="number" id="cancellation-charges" name="cancellation-charges"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" placeholder="Enter Cancellation Charges" value="">

                        <!-- <button type="button" onclick="alert('This is your bonus rate information')"
                                    class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 p-2 hover:bg-primary/10">
                                    <i class="las la-info-circle text-lg text-gray-500"></i>
                                </button> -->
                    </div>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="Stationary-charges" class="md:text-lg font-medium block mb-4">
                    Stationary Charges
                </label>

                <input type="number" id="Stationary-charges" name="stationary-charges"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="0.0" value="">
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="penalty-charges" class="md:text-lg font-medium block mb-4">
                    Penalty Charges
                </label>
                <div class="col-sm-7">
                    <div class="flex items-center gap-2">
                        <select name="penalty-charges-type" id="penalty-charges-type"
                            class="w-20 text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">
                            <option value="percentage">%</option>
                            <option value="fixed">FIXED</option>
                        </select>

                        <input type="number" id="bonus-rate" name="bonus-rate"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" placeholder="Enter Penalty Charges" value="">
                    </div>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="penalty-charges" class="md:text-lg font-medium block mb-4">
                    Penalty Charges (%)
                    <span class="text-red-500">*</span>
                </label>
                <select id="" name="penalty-chargers"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    <option value="0.0">0.0%</option>
                    <option value="0.5">0.5%</option>
                    <option value="1">1%</option>
                    <option value="1.5">1.5%</option>
                    <option value="2">2%</option>
                    <option value="3">3%</option>
                    <option value="4">4%</option>
                    <option value="5">5%</option>
                </select>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="contact_email" class="md:text-lg font-medium block mb-4">
                    App Type
                    <span class="text-red-500">*</span>
                </label>
                <div class="flex flex-row pt-3 mt-5 gap-6">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" class="w-6 h-6 accent-green-500">
                        <span>Admin</span>
                    </label>

                    <label class="flex items-center gap-3">
                        <input type="checkbox" class="w-6 h-6 accent-green-500">
                        <span>Associate</span>
                    </label>

                    <label class="flex items-center gap-3">
                        <input type="checkbox" class="w-6 h-6 accent-green-500">
                        <span>Member</span>
                    </label>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="contact_email" class="md:text-lg font-medium block mb-4">
                    Active
                    <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center gap-6">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="answer" value="yes">
                        <span>Yes</span>
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="radio" name="answer" value="no">
                        <span>No</span>
                    </label>
                </div>
                          
            </div>
        </form>

        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
            <button type="submit"
                class="bg-green-500 p-2 border border-green-500 text-white uppercase rounded  sm:w-auto">
                SAVE SCHEME
            </button>

            <button type="submit"
                class="bg-red-500 p-2 border border-red-500 text-white uppercase rounded  sm:w-auto">
                Cancel
            </button>
        </div>
    </div>
    @endsection