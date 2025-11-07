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
                    New Commission Payout
                </h3>

            </div>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <!-- Left: Details -->
            <div class=" w-full  overflow-hidden">
                <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                    <form action="">
                      
                        <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                               Associate/ Advisor 
                                <span class="text-red-500">*</span>
                            </label>

                            <select name="" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                                <option value="">
                                    Select Associate/Advisor
                                </option>
                            </select>
                        </div>
                        <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                             Type  
                                <span class="text-red-500">*</span>
                            </label>

                            <select name="" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                                <option value="">
                                    Ralease (Debit / Handover To Associate)
                                </option>
                                <option value="">
                                    Credit (Credit To Associate   Earnings)
                                </option>
                            </select>
                        </div>
                        <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                            Date
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" name="" id="" placeholder="DD/MM/YYYY"
                                class="datepicker-field w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                        </div>
                         <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                              Amount
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" name="" id="amount" placeholder="Enter Amount"
                                class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                                <x-number-to-word for="amount"/>
                        </div>
                        <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                              TDS
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" name="" id="tds" placeholder="0"
                                class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                                   <x-number-to-word for="tds"/>
                        </div>
                         <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                              Net Amount
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" name="" id="tds" placeholder="0"
                                class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " readonly>
                                   <x-number-to-word for="tds"/>
                        </div>
                          <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                              Remarks (if any)
                            </label>

                            <textarea type="number" name="" id="tds" placeholder="Enter Remarks (if any)"
                                class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " ></textarea>   
                        </div>
                          <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                             Pay Mode 
                                <span class="text-red-500">*</span>
                            </label>
                             <div class="flex gap-4">
                                <label for="" class="flex gap-2">
                                    <input type="radio" name="pay_mode" id="" checked>
                                    Cash
                                </label>
                                 <label for="" class="flex gap-2">
                                    <input type="radio" name="pay_mode" id="">
                                     Online Tr. 
                                </label>  
                                <label for="" class="flex gap-2">
                                    <input type="radio" name="pay_mode" id="">
                                     Cheque 
                                </label> 
                                <label for="" class="flex gap-2">
                                    <input type="radio" name="pay_mode" id="">
                                      Saving Ac.
                                </label>    
                             </div>
                              
                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                            <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                               Save
                            </button>

                            <button class="btn-outline uppercase justify-center" type="reset">
                                <a href="#"> BACK</a>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!--Rigth: Do Not Remove it -->
            <div class=" w-full  overflow-hidden">
                <!--  Do Not Remove it -->
            </div>

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

@endsection