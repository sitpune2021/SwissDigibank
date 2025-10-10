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

        <div class="mb-4 flex flex-wrap items-center justify-between gap-4 lg:mb-4">
            <div class="flex items-start flex-col gap-2">
                <div class="flex items-center gap-2">
                    <h3 class="uppercase font-semibold">
                        Gold Loan - 00462
                    </h3>
                    <p class="text-gray-500 uppercase text-sm">
                        Clear Due
                    </p>
                </div>
                <p class="text-gray-500">
                    <a href="#" class="text-gray-500 text-sm">Gold Loans </a> >
                    <a href="#" class="text-gray-500 text-sm">00460 </a>>
                   
                    <a href="#" class="text-gray-500 text-sm">
                       Clear Due
                    </a>
                </p>
            </div>
        </div>


        <div class="flex flex-col  dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <div class=" w-full  box overflow-hidden">
                <div class="">
                    <h3>CHARGES - CLEAR DUES</h3>
                </div>
                <hr class="mt-3">
           <form action="">
              <div class="col-span-2 md:col-span-1 mt-5 mb-2 ">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                       Due Amount 
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="number" name="" id="" placeholder="0.0"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" readonly>
                       


                </div>
                <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                        Waived Amount
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="number" name="" id="" placeholder="0.0"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">


                </div>
                <div class="col-span-2 md:col-span-1 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mb-2">
                       Charges / Penalty Due 
                        <span class="text-red-500">*</span>
                    </label>
                    <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                        <tbody>
                            <!-- Column Labels -->
                            <tr class="">
                                <th class="text-center px-3 py-1 ">Amount</th>
                                <th class="text-center px-3 py-1 ">GST Rate (%) </th>
                                <th class="text-center px-3 py-1 ">Total Amount</th>

                            </tr>

                            <!-- Input Row -->
                            <tr class="">

                                <td class="px-2 py-2 ">
                                    <input type="text" name="" id="" placeholder="0" readonly
                                        class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                </td>


                                <td class="px-2 py-2 ">
                                    <input type="text" name="" id="" placeholder="0" readonly
                                        class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                </td>


                                <td class="px-2 py-2 ">
                                    <input type="text" name="" id="" placeholder="0"
                                        class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                </td>


                            </tr>
                        </tbody>
                    </table>

                </div>
                 <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                      Rounding Off 
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="number" name="" id="" placeholder="0.0"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" readonly>


                </div>
                 <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                    Net Amount 
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="number" name="" id="" placeholder="0.0"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" readonly>


                </div>
                <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                        Remarks (if any)

                    </label>

                    <textarea name="" id=""
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter Remarks (if any)"></textarea>


                </div>
                 <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                   Transaction Date
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="text" name="" id="date" placeholder="DD/MM/YYYY"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" readonly>


                </div>
                <x-paymode :mode_2="$misaccount->amount ?? '' " :showSaving="true" id="amount" :readonly="false"
                        :amountClass="true" :bgColor="false" :hiddenheading="false" :checkedDefault="'cash'"
                        groupName="disburse_Mode_two" :rdShowing="false" />

                <div class="col-span-2 md:col-span-1 mt-8 mb-2">
                    <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                        <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                            Debit
                        </button>

                        <button class="btn-outline uppercase justify-center" type="reset">
                            <a href="#"> BACK</a>
                        </button>
                    </div>
                </div>
             </form>
            </div>


            <div class=" w-full  overflow-hidden">
              
            </div>

        </div>

    </div>

    <script>
        function toggleSection(button) {
            const section = button.closest('.box').querySelector('.overflow-x-auto');
            const icon = button.querySelector('.toggle-icon');
            section.classList.toggle('hidden');
            icon.textContent = section.classList.contains('hidden') ? '+' : '−';
        }
    </script>
@endsection