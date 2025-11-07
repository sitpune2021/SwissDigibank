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

    .bg-greens {
        background-color: #14532d;
    }
</style>

@section('content')
    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-xl block  uppercase  font-bold">
                Commission Payouts
            </h3>
        </div>
        <div class="flex flex-col md:flex-row lg:flex-row gap-3 mb-5">
            <div class="">
                <a href="" class="btn-warning uppercase rounded-10 px-3">
                    Release Commission
                </a>
            </div>
            <div class="">
                <a href="" class="btn-primary uppercase rounded-10 px-3">
                    Release Multiple Commission
                </a>
            </div>
            <div class="">
                <a href="" class="btn-secondary uppercase rounded-10 px-3">
                    regenerate Commission
                </a>
            </div>
            <div class="">
                <a href="" class="btn-error uppercase  rounded-10 px-3">
                    remove Commission
                </a>
            </div>
        </div>
        <div class="col-span-12 box lg:col-span-12">
            <div class="w-full flex items-center gap-3 mt-4">
                <select name="" id="" class="w-64 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                    <option value="">
                        Select Associate
                    </option>
                </select>
            </div>

            <form action="">
                <div class="flex flex-col md:flex-row mb-5 mt-5 lg:flex-row">
                    <div class="w-full flex items-center gap-3 mt-4">
                        <label class="block font-medium mb-2">Date From <span class="text-red-500">*</span></label>
                        <input type="text" id="from_date" placeholder="DD/MM/YYYY" autocomplete="off"
                            class=" border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                    </div>
                    <div class="w-full flex items-center gap-6 mt-4">
                        <label class="block font-medium mb-2">Date To <span class="text-red-500">*</span></label>
                        <input type="text" id="to_date" placeholder="DD/MM/YYYY" autocomplete="off"
                            class=" border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                    </div>
                    <div class="w-full flex justify-center gap-6 mt-4">
                        <input type="submit" id="" value="Search" class="rounded-10 btn-primary ">
                    </div>
                </div>
            </form>


            <div class="w-full mt- flex flex-wrap gap-2">
                <button type="button" data-range="6m"
                    class="px-3 py-2 border  rounded-10 btn-primary hover:bg-gray-200">Last 6 Months</button>
                <button type="button" data-range="3m"
                    class="px-3 py-2 border  rounded-10 btn-primary hover:bg-gray-200">Last 3 Months</button>
                <button type="button" data-range="1w" class="px-3 py-2 border rounded-10 btn-primary hover:bg-gray-200">Last
                    1 Week</button>
                <button type="button" data-range="1d"
                    class="px-3 py-2 border  rounded-10 btn-primary hover:bg-gray-200">Last 1 Day</button>
                <button type="button" data-range="custom"
                    class="px-3 py-2 border  rounded-10 btn-primary hover:bg-gray-200">Custom</button>
            </div>
        </div>
        <div class="col-span-12 box mt-5 lg:col-span-12">
            <div class="tab-content p-4">
                <div id="tab1" class="tab-pane block">
                    <div class="flex gap-2 justify-end mb-3">
                        <p class="uppercase font-semibold">Last Updated:</p>
                        <p class="uppercase font-semibold">30-10-2025</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse whitespace-nowrap text-sm">
                            <thead>
                                <tr class="bg-secondary/5 dark:bg-bg3">
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            TOTAL TRANSACTIONS (01-10-2025 to 31-10-2025)
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            TOTAL CREDITS
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            TOTAL DEBITS

                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1 uppercase">
                                        0
                                    </div>
                                </td>
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1 Capitalize">
                                        0.00
                                    </div>
                                </td>
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        0.00
                                    </div>
                                </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="flex gap-3 justify-end mt-5">
                        <select name="" id="" class="w-64 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <option value="">
                                All
                            </option>
                            <option >SELF</option>
                            <option >TEAM</option>
                            <option >COL CHARGE</option>
                        </select>
                        <input type="text" name="" id="" class="w-64 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3" 
                        placeholder="Search Message">
                        <button class="btn-primary p-2 rounded-10">
                          <i class="las la-search"></i>  
                        </button>
                    </div>
                     <div class="overflow-x-auto mt-6">
                        <table class="w-full border-collapse whitespace-nowrap text-sm">
                            <thead>
                                <tr class="bg-secondary/5 dark:bg-bg3">
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            ADVISOR
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                           MESSAGE	
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                           COM TYPE	
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                          DATE	
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                         CR AMT.		
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                        DR AMT.			
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                        CREATED AT			
                                        </div>
                                    </th>
                                     <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                         ACTIONS			
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1 uppercase">
                                        <a href="" class="text-primary">
                                            3212 - arun sh
                                        </a>
                                    </div>
                                </td>
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1 Capitalize">
                                        eeee	
                                    </div>
                                </td>
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                       
                                    </div>
                                </td>
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                       10-10-2025
                                    </div>
                                </td>
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                     
                                    </div>
                                </td>
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                     500.00	
                                    </div>
                                </td>
                                 <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                     12-12-2024
                                    </div>
                                </td>
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                      <div class="flex items-center gap-1">
                                        <div class="relative">
                                            <i
                                                class="las la-ellipsis-v horiz-option-btn  cursor-pointer popover-button"></i>
                                            <ul class="horiz-option popover-content">
                                                <li><a href="" class="single-option uppercase">View</a></li>
                                                <li><a href="" class="single-option uppercase">
                                                      Delete
                                                    </a></li>
                                            </ul>

                                            {{-- @include('partials._vertical-options', [
                                            /* 'id' =>base64_encode($director->id),
                                            'viewRoute' => 'director.show',
                                            'editRoute' => 'director.edit'*/
                                            ]) --}}
                                        </div>
                                    </div>
                                </td>
                               
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-5">
                    <a href="" class="btn-error rounded-10 py-2">
                        <i class="las la-download"></i>
                        Download
                    </a>
                </div>
            </div>

        </div>


        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const tabs = document.querySelectorAll('.tab-link');
                const tabPanes = document.querySelectorAll('.tab-pane');

                // ✅ Set the first tab active by default
                if (tabs.length > 0 && tabPanes.length > 0) {
                    tabs.forEach(t => t.classList.remove('active', 'text-primary', 'border-primary'));
                    tabPanes.forEach(p => p.classList.add('hidden'));

                    tabs[0].classList.add('active', 'text-primary', 'border-primary');
                    tabPanes[0].classList.remove('hidden');
                }

                // ✅ Tab switching logic
                tabs.forEach(tab => {
                    tab.addEventListener('click', (e) => {
                        e.preventDefault();

                        // Remove active state from all tabs & hide all panes
                        tabs.forEach(t => t.classList.remove('active', 'text-primary', 'border-primary'));
                        tabPanes.forEach(p => p.classList.add('hidden'));

                        // Activate clicked tab and show its pane
                        tab.classList.add('active', 'text-primary', 'border-primary');
                        const targetPane = document.getElementById(tab.dataset.tab);
                        if (targetPane) targetPane.classList.remove('hidden');
                    });
                });
            });
        </script>


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