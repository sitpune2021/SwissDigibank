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
                    zyyy
                </h3>
                 <p class="text-xs text-gray-500 uppercase">
                    Employee
                 </p>
            </div>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <!-- Left: Details -->
            <div class=" w-full  overflow-hidden">
                <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                    <div class="text-xl font-semibold uppercase border-b">
                        SALARY SETTLEMENT (CREDIT/ DEBIT)

                    </div>
                    <form action="">
                        <div class="col-span-2 md:col-span-1 mt-3 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Employee
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                placeholder="Enter Employee" readonly>
                            
                        </div>
                    
                        <div class="col-span-2 md:col-span-1 mb-4">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Transaction Date
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id="date"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="DD/MM/YYYY">

                        </div>
                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                             Transaction Type 
                                <span class="text-red-500">*</span>
                            </label>

                            <select type="number" id="amount"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Salary Amount">
                                <option value="">Select Transaction Type</option>
                                <option value="credit">Credit</option>
                                <option value="debit">Debit</option>
                            </select>

                        </div>
                       <div class="col-span-2 md:col-span-1 ">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Amount
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id="amounts"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Salary Amount">
                            <x-number-to-word for="amounts"/>

                        </div>
                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                             Remarks 
                             <span class="text-error">*</span>
                            </label>

                            <textarea  id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Remarks (if any)"></textarea>
                           
                        </div>
                        <!-- Buttons -->
                        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                            <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                              SETTLEMENT
                            </button>

                            <button class="btn-outline uppercase justify-center" type="reset">
                                <a href="#"> BACK</a>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Left: Details -->
            <div class=" w-full  overflow-hidden">
                <!--  Application Info -->
                <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg">
                    <!-- Header -->
                    <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-10">
                        <h3 class="text-black font-semibold uppercase text-lg">
                            EMPLOYEE INFO
                        </h3>
                    </div>                   
                    <div class="overflow-x-auto p-4 ">
                        <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                            <tbody>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 w-1/3 uppercase">Branch</td>
                                    <td class="px-3 py-2">Kalyanadurgam</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Name</td>
                                    <td class="px-3 py-2">zyyy</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">
                                        Code
                                    </td>
                                    <td class="px-3 py-2"> 
                                        MINL0015
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">
                                        Joining Date
                                    </td>
                                    <td class="px-3 py-2">10-10-2025</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">
                                      Available Balance
                                    </td>
                                    <td class="px-3 py-2"> 
                                    0.00
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">
                                        Leaving Date
                                    </td>
                                    <td class="px-3 py-2">
                                        -
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>

                    </div>
                </div>

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