@extends('layout.main')
@section('content')
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

        .bg-greens {
            background-color: #14532d;
        }
    </style>
    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-lg   uppercase font-semibold">
              Report - Loan Accrued Interest Report
            </h3>

        </div>
        <!-- custom date picker -->
        {{-- <div class="box ">
            <p class="border-b uppercase text-lg font-semibold">Share Transfer Date <span class="text-error">*</span></p>
            <form action="
            {{ route('share.transfer.history.report') }}
             " method="GET">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6 rounded-xl">

                    <div class="w-full mt-4 col-span-1 md:col-span-1  dark:bg-bg3">
                        <label class="block font-medium uppercase mb-2">Date From <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="from_date" name="from_date" placeholder="DD/MM/YYYY" autocomplete="off"
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                    </div>

                    <div class="w-full mt-4 col-span-1 md:col-span-1  dark:bg-bg3">
                        <label class="block font-medium uppercase mb-2">Date To <span class="text-red-500">*</span></label>
                        <input type="text" id="to_date" name="to_date" placeholder="DD/MM/YYYY" autocomplete="off"
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                    </div>
                </div>
                <div class="w-full mt-4 flex flex-wrap gap-2">
                    <button type="button" data-range="6m"
                        class="px-3 py-2 border text-sm  rounded-10 btn-primary hover:bg-gray-200 uppercase">Last 6
                        Months</button>
                    <button type="button" data-range="3m"
                        class="px-3 py-2 border text-sm  rounded-10 btn-primary hover:bg-gray-200 uppercase">Last 3
                        Months</button>
                    <button type="button" data-range="1w"
                        class="px-3 py-2 border text-sm  rounded-10 btn-primary hover:bg-gray-200 uppercase">Last 1
                        Week</button>
                    <button type="button" data-range="1d"
                        class="px-3 py-2 border text-sm  rounded-10 btn-primary hover:bg-gray-200 uppercase">Last 1
                        Day</button>
                    <button type="button" data-range="custom"
                        class="px-3 py-2 border text-sm  rounded-10 btn-primary hover:bg-gray-200 uppercase">Custom</button>
                </div>
                <div class="mt-3 text-center">

                    <button class="btn-primary py-2 mt-5  text-sm uppercase">
                        <i class="las la-search"></i>
                        List Share Transfer
                    </button>
                </div>

            </form>
        </div> --}}

        <div class="col-span-12 box lg:col-span-12 mt-5">
            <x-searchbox />
            <div class="mb-5 flex justify-end gap-2 flex-col md:flex-row lg:flex-row">

                <a href="" class="btn-primary rounded-10 px-2 flex justify-center py-2 text-sm uppercase">
                    <i class="las la-print"></i>
                    Print
                </a>
                {{-- <a href="" class="btn-error rounded-10 px-2 flex justify-center py-2 text-sm uppercase">
                    <i class="las la-download"></i>
                    Download CSV
                </a> --}}
            </div>

            <div class="pb-4 overflow-x-auto lg:pb-6">
                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    REPORT NAME
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center uppercase gap-1">
                                    REPORT TYPE
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    REQUESTED BY
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    REQUESTED DATE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    STATUS
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    DOWNLOAD LINK
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    REMARKS
                                </div>
                            </th>

                        </tr>
                    </thead>

                    <tbody>
                        <tr class="border-b dark:border-bg3">
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1  uppercase">
                                   deposit Balance Report (static)
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1  uppercase">
                                 Balance Report   (static)
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1  uppercase">
                                   NISHA SWAPNIL THAKARE(static)
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1  uppercase">
                                     16-02-2026 (static)
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1  uppercase">
                                  <span class="text-primary">
                                    COMPLETED
                                 </span> (static)
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1  uppercase">
                                   <span class="btn-error rounded-10 text-sm px-2">
                                 <i class="las la-download"></i>  Download
                                 </span>
                                    (static)
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1  uppercase">
                                    (static)
                                </div>
                            </td>
                          
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-5">
                {{-- <x-pagination :paginator="$shareTransfers" /> --}}
            </div>
        </div>

        <script>
            const btn = document.getElementById("toggleBtn");
            const content = document.getElementById("toggleContent");
            const icon = document.getElementById("toggleIcon");

            btn.addEventListener("click", () => {
                content.classList.toggle("hidden");

                // Toggle icon
                if (content.classList.contains("hidden")) {
                    icon.classList.remove("la-minus");
                    icon.classList.add("la-plus");
                } else {
                    icon.classList.remove("la-plus");
                    icon.classList.add("la-minus");
                }
            });
        </script>
        <!-- JS -->

        <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
        <script>
            const fromElem = document.getElementById("from_date");
            const toElem = document.getElementById("to_date");

            let isCustomMode = false;
            let fromSelected = null;

            // Initialize pickers
            const fromPicker = new Datepicker(fromElem, {
                autohide: true,
                format: "dd-mm-yyyy"
            });
            const toPicker = new Datepicker(toElem, {
                autohide: true,
                format: "dd-mm-yyyy"
            });

            // Reset pickers
            function resetPickers() {
                fromPicker.setDate(null);
                toPicker.setDate(null);
                fromPicker.setOptions({
                    minDate: null,
                    maxDate: null
                });
                toPicker.setOptions({
                    minDate: null,
                    maxDate: null,
                    beforeShowDay: null
                });
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
                toPicker.setOptions({
                    minDate: fromSelected,
                    maxDate: calculateMaxTo(fromSelected)
                });

                // Highlight the range
                highlightToRange(fromSelected);
            });

            // To Date focus → show only 6 months after From, capped by today
            toElem.addEventListener("focus", () => {
                if (!isCustomMode || !fromSelected) return;
                toPicker.setOptions({
                    minDate: fromSelected,
                    maxDate: calculateMaxTo(fromSelected)
                });
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
                        fromPicker.setOptions({
                            minDate: null,
                            maxDate: null
                        });
                        toPicker.setOptions({
                            minDate: null,
                            maxDate: null,
                            beforeShowDay: null
                        });
                        return;
                    }

                    const today = new Date();
                    let startDate = new Date();
                    if (range === "6m") startDate.setMonth(startDate.getMonth() - 6);
                    if (range === "3m") startDate.setMonth(startDate.getMonth() - 3);
                    if (range === "1w") startDate.setDate(startDate.getDate() - 7);
                    if (range === "1d") startDate.setDate(startDate.getDate() - 1);

                    isCustomMode = false;
                    fromPicker.setOptions({
                        minDate: startDate,
                        maxDate: today
                    });
                    fromPicker.setDate(startDate);
                    toPicker.setOptions({
                        minDate: startDate,
                        maxDate: today
                    });
                    toPicker.setDate(today);
                });
            });
        </script>
@endsection