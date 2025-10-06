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
                        Other Charges
                    </p>
                </div>
                <p class="text-gray-500">
                    <a href="#" class="text-gray-500 text-sm">Gold Loans </a> >
                    <a href="#" class="text-gray-500 text-sm">00460 </a>>
                    <a href="#" class="text-gray-500 text-sm">Other Charges </a>>

                    <a href="#" class="text-gray-500 text-sm">
                        Debit Charges
                    </a>
                </p>
            </div>
        </div>


        <div class="flex flex-col  dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <div class=" w-full  box overflow-hidden">
                <form action="">
                    <div class="col-span-2 md:col-span-1 mt-5 mb-2 ">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                            Charge Type
                            <span class="text-red-500">*</span>
                        </label>

                        <select name="" id="" placeholder="0.0"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            readonly>
                            <option value="">Select Type</option>
                            <option value="sms_charges">Sms Charges</option>
                            <option value="cheque_bounce_charges">Cheque Bounce Charges</option>
                            <option value="passbook_charges">Passbook Charges</option>
                            <option value="other_charges">Other Charges</option>
                            <option value="maintenance_charges">Maintenance Charges</option>
                            <option value="collection_charges">Collection Charges</option>
                            <option value="notice_charges">Notice Charges</option>
                            <option value="service_charges">Service Charges</option>
                            <option value="insurance_fee">Insurance Fee</option>
                            <option value="processing_charges">Processing Charges</option>
                            <option value="cancellation_charges">Cancellation Charges</option>
                            <option value="gst">Gst</option>
                            <option value="visit_charges">Visit Charges</option>
                            <option value="fitness_fee">Fitness Fee</option>
                        </select>



                    </div>
                    <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                           Transaction Date
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text" name="" id="date" placeholder="DD/MM/YYYY"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">


                    </div>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-2">
                            Charges 
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
                            Remarks (if any)

                        </label>

                        <textarea name="" id=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Remarks (if any)"></textarea>


                    </div>
                 
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