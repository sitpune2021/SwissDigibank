@extends('layout.main')

@section('content')
    <div class="main-inner">


        <!-- Header -->
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 ">
            <div class="flex items-start flex-col gap-2">
                <h1 class="text-xl font-semibold uppercase">ISSUE NEW PASSBOOK</h1>
                <p class="text-gray-500 text-start  ">
                    <a href="" class="text-gray-500">Passbooks</a> >
                    <a href="#" class="text-gray-500">New</a>
                </p>
            </div>
        </div>


      
        <form method="" action="" class=" bg-white dark:bg-bg3 rounded-lg p-5 shadow-md">
           
            <div class=" justify-between  ">
                <div class="w-full  box overflow-hidden flex flex-col gap-5 dark:bg-bg3 lg:flex-row">
                <!-- Account Type -->
                <div class="col-span-1 md:col-span-1   w-full ">
                    <label for="accountType" class="block mb-4 font-medium md:text-lg">
                        Account Type <span class="text-red-500">*</span>
                    </label>
                    <select id="accountType" name="account_type"
                        class="w-full px-3 py-2 text-sm border bg-secondary/5  dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                        <option value="SavingAccount">Saving</option>
                        <option value="">FD/ MIS</option>
                        <option value="">RD</option>
                        <option value="">DD</option>
                        <option selected="selected" value="">Gold Loan</option>
                        <option value="">Property Loan</option>
                        <option value="">Deposit Loan</option>
                        <option value="">Business / Other Loan</option>
                        <option value="">Personal Loan</option>
                        <option value="">Daily / Weekly Loan</option>
                        <option value="">Vehicle Loan</option>
                    </select>
                    
                </div>


                <!-- Account No -->
                <div id="accountNoWrapper" class="w-full col-span-2 md:col-span-1   ">
                    <label class="block mb-4 font-medium md:text-lg">
                        Account No <span class="text-red-500">*</span>
                    </label>
                    <select id="accountNo" name="account_no"
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">

                        <option value="">Select Account</option>

                    </select>

                </div>
    </div>
    <div class="w-full  box overflow-hidden flex flex-col gap-5 dark:bg-bg3 lg:flex-row">
                <!-- Passbook Issue Date -->
                <div id="issueDateWrapper" class=" w-full col-span-2 md:col-span-1  ">
                    <label class="block mb-4 font-medium md:text-lg">
                        Passbook Issue Date <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="date_pass" name="issue_date" class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 
                           border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3 pr-10">
                   
                </div>

                <!-- Passbook No -->
                <div id="passbookNoWrapper" class=" w-full col-span-2 md:col-span-1   ">
                    <label class="block mb-4 font-medium md:text-lg">
                        Passbook No <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="passbook_no" placeholder="Enter Passbook Number"
                        value="" class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 
                           border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                   
                </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div id="actionButtons" class="flex items-center justify-center gap-4 mt-6">
                <button id="addPassbookBtn" class="btn-primary" type="submit">ADD PASSBOOK</button>


                <button class="btn-outline" type="button">
                    Back
                </button>

            </div>
        </form>

      
        <!-- Datepicker CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

        <!-- Datepicker JS -->
        <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>



        <!-- Datepicker Initialization -->
        <script>
            //start
            const dateInput = document.getElementById('date_pass');

            if (dateInput) {
                // Initialize datepicker
                const picker = new Datepicker(dateInput, {
                    autohide: true,
                    format: 'dd-mm-yyyy', // Format: day-month-year
                    maxDate: new Date(), // Disable future dates
                });

                // Set today's date as default
                const today = new Date();
                const formattedDate = today.toLocaleDateString('en-GB').split('/').join('-');
                dateInput.value = formattedDate;

                // Open calendar on icon click
                const calendarIcon = document.querySelector('.la-calendar');
                if (calendarIcon) {
                    calendarIcon.addEventListener('click', () => picker.show());
                }
            }
            //end
        </script>

    </div>
@endsection