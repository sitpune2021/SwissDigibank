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

    .bg-greens {
        background-color: #14532d;
    }
</style>

@section('content')
    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-start gap-3 mb-6 px-4 lg:mb-8">
            <h3 class="flex text-xl block  uppercase font-semibold">
                Multiple Commission Payout
            </h3>

        </div>
        <div class="box mb-5">
            <form action="">
                <div class=" flex gap-3 flex-col lg:flex-row md:flex-row items-center justify-center ">
                    <div class="w-full">
                        <label for="" class="uppercase font-semibold text-lg">
                            Start Date
                        </label>
                        <input type="text" name="" id="date" placeholder="DD/MM/YYYY"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3  mt-2  capitalize">
                    </div>

                    <div class=" w-full">
                        <label for="" class="uppercase font-semibold text-lg">
                            End Date
                        </label>
                        <input type="text" name="" id="" placeholder="DD/MM/YYYY"
                            class="datepicker-field w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3  mt-2  capitalize">
                    </div>
                </div>
                <div class="mt-5 flex justify-center">
                    <button type="submit" class="btn-primary rounded-10 py-2">
                        <i class="las la-search"></i>
                        Search
                    </button>
                </div>
            </form>
        </div>
        <div class="col-span-12 box lg:col-span-12">
            <form action="">
                <div class="pb-4 overflow-x-auto lg:pb-6">
                    <table class="w-full whitespace-nowrap select-all-table" id="">
                        <thead>
                            <tr class="bg-secondary/5 dark:bg-bg3">
                                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex uppercase items-center gap-1">
                                        ASSOCIATE
                                    </div>
                                </th>
                                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex uppercase items-center gap-1">
                                        SAVING A/C
                                    </div>
                                </th>
                                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex uppercase items-center gap-1">
                                        AVL
                                        BALANCE (31-10-2025)
                                    </div>
                                </th>
                                <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                    <div class="flex uppercase items-center gap-1">
                                        EARNING FROM
                                        To 31-10-2025
                                    </div>
                                </th>

                                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex uppercase items-center gap-1">
                                        TDS DEDUCTED
                                    </div>
                                </th>
                                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex uppercase items-center gap-1">
                                        NET AMOUNT RELEASE
                                    </div>
                                </th>
                                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex uppercase text-center gap-1">
                                       <input type="checkbox" id="selectAll" class=" cursor-pointer">
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200 dark:border-gray-700">

                                <td class="p-2">
                                    <input type="text" name="" id="" value=""
                                        class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                        readonly>
                                </td>
                                <td class="p-2">
                                    <input type="text" name="" id="" value=""
                                        class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                        readonly>
                                </td>
                                <td class="p-2">
                                    <input type="text" name="" id="" value=""
                                        class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                        readonly>
                                </td>

                                <td class="p-2">
                                    <input type="text" name="" id="" value=""
                                        class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                        readonly>
                                </td>
                                <td class="p-2">
                                    <input type="number" name="" id="" value=""
                                        class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                </td>
                                <td class="p-2">
                                    <input type="text" name="" id="" value=""
                                        class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                        readonly>
                                </td>
                                 <td class="p-2 text-center">
                                    <input type="checkbox" class="row-checkbox w-4 h-4 cursor-pointer">
                                </td>
                            </tr>
                             <tr class="border-b border-gray-200 dark:border-gray-700">

                                <td class="p-2">
                                    <input type="text" name="" id="" value=""
                                        class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                        readonly>
                                </td>
                                <td class="p-2">
                                    <input type="text" name="" id="" value=""
                                        class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                        readonly>
                                </td>
                                <td class="p-2">
                                    <input type="text" name="" id="" value=""
                                        class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                        readonly>
                                </td>

                                <td class="p-2">
                                    <input type="text" name="" id="" value=""
                                        class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                        readonly>
                                </td>
                                <td class="p-2">
                                    <input type="number" name="" id="" value=""
                                        class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                </td>
                                <td class="p-2">
                                    <input type="text" name="" id="" value=""
                                        class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                        readonly>
                                </td>
                                 <td class="p-2 text-center">
                                    <input type="checkbox" class="row-checkbox w-4 h-4 cursor-pointer">
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
               <div class="pb-4 overflow-x-auto lg:pb-6 mt-5">
                      <table class="w-full whitespace-nowrap select-all-table" id="">
                        <thead>
                            <tr class="bg-secondary/5 dark:bg-bg3">
                                <th class="text-center !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex uppercase text-error items-center gap-1">
                                       TOTAL NO OF ENTRY PROCESS:  0
                                    </div>
                                </th>
                                <th class="text-center !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex uppercase  text-error  items-center gap-1">
                                      TOTAL TDS DEDUCT:  0.00
                                    </div>
                                </th>
                                <th class="text-center !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex uppercase  text-error  items-center gap-1">
                                       TOTAL NET AMOUNT RELEASE:  0.00
                                    </div>
                                </th>
                                
                            </tr>
                        </thead>
                        </table>
                     <p class="text-error text-center mt-5">
                     <span class="font-semibold uppercase">  NOTE: </span> All selected entries will be process on same date(31/10/2025).
                     </p>
                    </div>
                <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                    <button type="button" id="" class="btn-primary uppercase justify-center">
                        Process All
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

                // Set today's date as default value
                const formattedDate = today.toLocaleDateString('en-GB').split('/').join('-');
                dateInput.value = formattedDate;

                // Optional: open picker when calendar icon is clicked
                const calendarIcon = dateInput.parentElement.querySelector('.la-calendar');
                if (calendarIcon) {
                    calendarIcon.addEventListener('click', () => picker.show());
                }
            });
        });
    </script>
    
    
    <script>
document.addEventListener("DOMContentLoaded", function () {
  const selectAll = document.getElementById("selectAll");
  const rowCheckboxes = document.querySelectorAll(".row-checkbox");

  // ✅ When header checkbox is clicked → select/deselect all
  selectAll.addEventListener("change", function () {
    rowCheckboxes.forEach(chk => chk.checked = selectAll.checked);
  });

  // ✅ When individual checkbox is clicked → only toggle that one
  // (no effect on others except header state)
  rowCheckboxes.forEach(chk => {
    chk.addEventListener("change", function () {
      // Update header checkbox state based on total checked
      const allChecked = [...rowCheckboxes].every(c => c.checked);
      selectAll.checked = allChecked;
    });
  });
});
</script>

@endsection