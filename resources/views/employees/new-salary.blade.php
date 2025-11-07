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
                   Employee - zyyy - New Salary
                </h3>
                
            </div>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <!-- Left: Details -->
            <div class=" w-full  overflow-hidden">
                <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                    <form action="">
                        <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                              PF No 
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " style="text-transform: uppercase;"
                                placeholder="Enter PF No " >
                            
                        </div>
                     <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                             UAN No 
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " style="text-transform: uppercase;"
                                placeholder="Enter UAN No " >
                            
                        </div>
                        <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                             ESIC No   
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " style="text-transform: uppercase;"
                                placeholder="Enter ESIC No " >
                            
                        </div>
                        <div class="text-center font-semibold mb-2">
                            <span class="border-b">
                                    MONTHLY SALARY
                            </span> 
                        </div>
                        <div class="col-span-2 md:col-span-1 mb-4">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                               Start Date 
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id="date"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="DD/MM/YYYY">

                        </div>
                         <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                             Basic Salary  
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id="basicSalary"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " 
                                placeholder="Enter Basic Salary" >
                            <x-number-to-word for="basicSalary"/>
                        </div>
                         <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                          HRA 
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " 
                                placeholder="Enter HRA  " >
                            
                        </div>
                          <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                         Education Allowance
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " 
                                placeholder="Enter Education Allowance " >
                            
                        </div>
                        <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                       LTA 
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " 
                                placeholder="Enter LTA " >
                            
                        </div>
                        <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                       Telephone Reimbursement
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " 
                                placeholder="Enter Telephone Reimbursement " >
                            
                        </div>
                         <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                      Fuel Charges 
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " 
                                placeholder="Enter Fuel Charges  " >
                            
                        </div>
                         <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                      Driver Charges
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " 
                                placeholder="Enter Driver Charges " >
                            
                        </div>
                         <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                    Helper Allowance 
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " 
                                placeholder="Enter Helper Allowance " >
                            
                        </div>
                         <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                   Special Allowance
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " 
                                placeholder="Enter Special Allowance " >
                            
                        </div>
                          <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                   Variable Amount
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " 
                                placeholder="Enter Variable Amount" >
                            
                        </div>
                          <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                  Gross Salary (A) 
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " 
                                placeholder="Enter Gross Salary (A) " readonly>
                            
                        </div>
                        <div class="text-center font-semibold text-lg">
                            <span class="border-b ">TOTAL DEDUCTIONS</span>
                        </div>
                          <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                  Employee PF 
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " 
                                placeholder="Enter Employee PF" >
                            
                        </div>
                         <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                 Employer PF 
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " 
                                placeholder="Enter Employer PF " >
                            
                        </div>
                         <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Gratuity 
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " 
                                placeholder="Enter Gratuity " >
                            
                        </div>
                         <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                ESIC Employee   
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " 
                                placeholder="Enter ESIC Employee  " >
                            
                        </div>
                        <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                               ESIC Employer 
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " 
                                placeholder="Enter ESIC Employer" >
                            
                        </div>
                        <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                               Total Deduction (B)
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "  readonly
                                placeholder="Enter ESIC Employer" >
                            
                        </div>
                        <div class="col-span-2 md:col-span-1  mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                              Net Salary (A - B)
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "  readonly >
                            
                        </div>
                        
                        <!-- Buttons -->
                        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                            <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                           Add Salary
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
                                   
                    <div class="overflow-x-auto p-4 ">
                        <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                            <tbody>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 w-1/3 uppercase">Member Profile	</td>
                                    <td class="px-3 py-2 text-primary">	DEMO-04287 - kuldeeeeeeep</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">
                                        Designation
                                    </td>
                                    <td class="px-3 py-2">
                                        weer
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">
                                       Employee Code
                                    </td>
                                    <td class="px-3 py-2"> 
                                        MINL0015
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">
                                        Name
                                    </td>
                                    <td class="px-3 py-2">zyyy</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">
                                     Date Of Birth
                                    </td>
                                    <td class="px-3 py-2"> 
                                    	29-09-2025
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">
                                       Joining Date
                                    </td>
                                    <td class="px-3 py-2">
                                        29-09-2025
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">
                                      Father Name
                                    </td>
                                    <td class="px-3 py-2">
                                        dfg
                                    </td>
                                </tr>
                                 <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">
                                     Contact No.
                                    </td>
                                    <td class="px-3 py-2">
                                        1234567890
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">
                                     Address
                                    </td>
                                    <td class="px-3 py-2">
                                        
                                    </td>
                                </tr>
                                  <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">
                                     Monthly Salary
                                    </td>
                                    <td class="px-3 py-2">
                                       	₹ 
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">
                                    Nominee Name
                                    </td>
                                    <td class="px-3 py-2">
                                       	
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