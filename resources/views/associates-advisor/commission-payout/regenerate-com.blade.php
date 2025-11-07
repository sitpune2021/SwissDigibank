@extends('layout.main')
@section('content')
    <div class="main-inner">

        <head>
            <style>
                input[type="radio"] {
                    width: 24px;
                    height: 24px;
                    accent-color: green;
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
            </style>
        </head>

        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-center flex-row gap-2">
                <h3 class="text-xl font-semibold uppercase">
                    Commission Payouts - Regenerate
                </h3>

            </div>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <!-- Left: Details -->
            <div class=" w-full  overflow-hidden">
                <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                    <div class="">
                        <p class="font-semibold text-lg uppercase">
                            Regenerate commission for a particular account with in particular dates.

                        </p>

                    </div>
                    <form action="">

                        <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Account Type
                                <span class="text-red-500">*</span>
                            </label>

                            <select name="" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                                <option value="">
                                    Select Account Type
                                </option>
                                <option>DD</option>
                                <option>MDS / RD</option>
                                <option>FD</option>
                                <option>MIS</option>
                                <option>Saving</option>
                            </select>
                        </div>
                        <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Account No
                                <span class="text-red-500">*</span>
                            </label>

                            <select name="" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                                <option value="">
                                    Select Account No or Member No or Member Name
                                </option>

                            </select>
                        </div>

                        <div class="w-full mt-4">
                            <label class="block font-medium mb-2">Date From <span class="text-red-500">*</span></label>
                            <input type="text" id="from_date" placeholder="DD/MM/YYYY" autocomplete="off"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                        </div>

                        <div class="w-full mt-4">
                            <label class="block font-medium mb-2">Date To <span class="text-red-500">*</span></label>
                            <input type="text" id="to_date" placeholder="DD/MM/YYYY" autocomplete="off"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                        </div>

                        <div class="w-full mt-4 flex flex-wrap gap-2">
                            <button type="button" data-range="6m"
                                class="px-3 py-2 border  rounded-10 btn-primary hover:bg-gray-200">Last 6 Months</button>
                            <button type="button" data-range="3m"
                                class="px-3 py-2 border  rounded-10 btn-primary hover:bg-gray-200">Last 3 Months</button>
                            <button type="button" data-range="1w"
                                class="px-3 py-2 border rounded-10 btn-primary hover:bg-gray-200">Last 1 Week</button>
                            <button type="button" data-range="1d"
                                class="px-3 py-2 border  rounded-10 btn-primary hover:bg-gray-200">Last 1 Day</button>
                            <button type="button" data-range="custom"
                                class="px-3 py-2 border  rounded-10 btn-primary hover:bg-gray-200">Custom</button>
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
                    </form>
                </div>
            </div>

            <!--Rigth: Do Not Remove it -->
            <div class=" w-full  overflow-hidden">
                <!--  Do Not Remove it -->
            </div>

        </div>
        <div class="box  ">
            <div class="bg-warning rounded-10 text-white p-3">
                <p class="mb-3 uppercase font-semibold">
                    <i class="las la-exclamation-triangle"></i>
                    Info !!
                </p>
                <div class="font-semibold">
                    Generating commission will delete all the commission (self/ team/ coll. charge) for that account in the
                    selected
                    time period above & no data will be recovered once it is done. Then the commission will generated for
                    that time
                    period.
                </div>

                <p class="mt-3 font-semibold"> Don't select big date range, it will slow down system.</p>
            </div>
        </div>

    </div>

    {{-- 6,3, 1week and 1day datepicker script --}}
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <script>
        const fromElem = document.getElementById("from_date");
        const toElem = document.getElementById("to_date");

        let isCustomMode = false;
        let fromSelected = null;

        // Initialize pickers
        const fromPicker = new Datepicker(fromElem, { autohide: true, format: "dd-mm-yyyy" });
        const toPicker = new Datepicker(toElem, { autohide: true, format: "dd-mm-yyyy" });

        // Reset pickers
        function resetPickers() {
            fromPicker.setDate(null);
            toPicker.setDate(null);
            fromPicker.setOptions({ minDate: null, maxDate: null });
            toPicker.setOptions({ minDate: null, maxDate: null, beforeShowDay: null });
            fromSelected = null;
        }

        // Calculate To max date (6 months after From, capped by today)
        function calculateMaxTo(fromDate) {
            const maxTo = new Date(fromDate);
            maxTo.setMonth(maxTo.getMonth() + 6);
            const today = new Date();
            return maxTo > today ? today : maxTo;
        }

        // Highlight only the 6-month range in To calendar
        function highlightToRange(fromDate) {
            const maxTo = calculateMaxTo(fromDate);
            toPicker.setOptions({
                beforeShowDay: function (date) {
                    return (date >= fromDate && date <= maxTo) ? true : false;
                }
            });
        }

        // From Date change
        fromElem.addEventListener("changeDate", e => {
            if (!isCustomMode) return;
            fromSelected = e.date;
            if (!fromSelected) return;

            // Reset To Date
            toPicker.setDate(null);

            // Set To Date min/max
            toPicker.setOptions({ minDate: fromSelected, maxDate: calculateMaxTo(fromSelected) });

            // Highlight the range
            highlightToRange(fromSelected);
        });

        // To Date focus → show only 6 months after From, capped by today
        toElem.addEventListener("focus", () => {
            if (!isCustomMode || !fromSelected) return;
            toPicker.setOptions({ minDate: fromSelected, maxDate: calculateMaxTo(fromSelected) });
            highlightToRange(fromSelected);
        });

        // To Date change → cannot be smaller than From
        toElem.addEventListener("changeDate", e => {
            if (!isCustomMode) return;
            const toSelected = e.date;
            if (!toSelected || !fromSelected) return;
            if (toSelected < fromSelected) toPicker.setDate(null);
        });

        // Quick-select buttons
        document.querySelectorAll("button[data-range]").forEach(btn => {
            btn.addEventListener("click", () => {
                const range = btn.getAttribute("data-range");
                isCustomMode = (range === "custom");
                console.log("hiii");

                if (isCustomMode) {
                    resetPickers();
                    fromPicker.setOptions({ minDate: null, maxDate: null });
                    toPicker.setOptions({ minDate: null, maxDate: null, beforeShowDay: null });
                    return;
                }

                const today = new Date();
                let startDate = new Date();
                if (range === "6m") startDate.setMonth(startDate.getMonth() - 6);
                if (range === "3m") startDate.setMonth(startDate.getMonth() - 3);
                if (range === "1w") startDate.setDate(startDate.getDate() - 7);
                if (range === "1d") startDate.setDate(startDate.getDate() - 1);

                isCustomMode = false;
                fromPicker.setOptions({ minDate: startDate, maxDate: today });
                fromPicker.setDate(startDate);
                toPicker.setOptions({ minDate: startDate, maxDate: today });
                toPicker.setDate(today);
            });
        });
    </script>
@endsection