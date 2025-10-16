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
            <h3 class="uppercase font-semibold">
                Gold Loan - 00462 - Link Saving Account for Auto Debit EMI
            </h3>
            <p class="text-gray-500">
                <a href="#" class="text-gray-500 text-sm">Gold Loans </a> >
                <a href="#" class="text-gray-500 text-sm">00460 </a>>
                <a href="#" class="text-gray-500 text-sm">
                    Link Saving Account
                </a>
            </p>
        </div>
    </div>


    <div class="flex flex-col  dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
         <div class=" w-full  box overflow-hidden">

             <div class="col-span-2 md:col-span-1 mb-4">
            <p class="uppercase text-lg font-bold"> Link member saving account to loan for auto debit EMI on due date
            </p>
            </div>

            <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                           Select Saving Account 
                            <span class="text-red-500">*</span>
                        </label>

                        <select name="" id="" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">Select Saving Account</option>
                        </select>
                       

                    </div>
             
                 <div class="col-span-2 md:col-span-1 mt-8 mb-2">
                     <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                        <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                          Link Account
                        </button>

                        <button class="btn-outline uppercase justify-center" type="reset">
                            <a href="#"> BACK</a>
                        </button>
                    </div>
                 </div>


         </div>
          <div class=" w-full  overflow-hidden">
            <!--  Application Info -->
            <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg">
                <!-- Header -->
                <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-10">
                    <h3 class="text-black uppercase font-semibold text-lg">Gold Loan Account Info</h3>

                    <!-- Toggle Button -->
                    <button class="p-1 rounded transition" onclick="toggleSection(this)">
                        <span class="toggle-icon text-lg font-bold">+</span>
                    </button>

                </div>

                <!-- Content (Initially Hidden) -->
                <div class="overflow-x-auto p-4 hidden">
                    <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2 w-1/3">Loan No.</td>
                                <td class="px-3 py-2"> 00462</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Member</td>
                                <td class="px-3 py-2">DEMO-04439 - ajinkya muli</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Co-Applicant Member</td>
                                <td class="px-3 py-2"> DEMO-04391 - sam butler</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Open Date</td>
                                <td class="px-3 py-2">29/09/2025</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Scheme</td>
                                <td class="px-3 py-2"> Suvarna shree yojana flat advanced deduction</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Loan Amount</td>
                                <td class="px-3 py-2">₹ 51,000.00</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Current Debt</td>
                                <td class="px-3 py-2">(51,000.00)</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Annual Interest Rate</td>
                                <td class="px-3 py-2">
                                    15.0 %
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Interest Type</td>
                                <td class="px-3 py-2">
                                   Flat Advanced Interest Deduction
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Tenure</td>
                                <td class="px-3 py-2">
                                   12 MONTHS
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Status</td>
                                <td class="px-3 py-2">
                                    <span
                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                ACTIVE
                            </span>
                                </td>
                            </tr>
                         
                        </tbody>
                    </table>

                </div>
            </div>

            <!--Member Info-->
            <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">

                <div
                    class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer">
                    <h3 class="text-lg font-semibold uppercase">
                        Member Info
                    </h3>
                    <div class="">

                        <button type="button" class="p-1 rounded transition"
                            onclick="toggleSection(this)">
                            <span class="toggle-icon text-lg font-bold">+</span>
                        </button>
                    </div>
                </div>

                <!-- Body -->
                <div class="overflow-x-auto p-4 hidden">
                   <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2 w-1/3">Member</td>
                                <td class="px-3 py-2">DEMO-04439 - ajinkya muli</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Branch	</td>
                                <td class="px-3 py-2">dhayari</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">DOB</td>
                                <td class="px-3 py-2">5 Sep 1990</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">
                                    Gender
                                </td>
                                <td class="px-3 py-2">
                                    male
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">
                                    Father Name

                                </td>
                                <td class="px-3 py-2"> </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">
                                  Occupation
                                </td>
                                <td class="px-3 py-2"> </td>
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