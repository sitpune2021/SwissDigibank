@extends('layout.main')

@section('content')

    <head>
        <style>
            input[type="radio"] {
                width: 24px;
                height: 24px;
                accent-color: green;
                /* Modern browser support */
            }
        </style>
    </head>
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col gap-2">
                <h3 class="text-xl font-semibold uppercase">Transaction - SD934C1D25</h3>

            </div>
        </div>
        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <!-- Left: Details -->
            <div class="w-full overflow-hidden">
                <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg  overflow-x-auto p-4 ">
                    <div class="flex justify-end gap-2">
                        <button class="btn-primary p-1">
                            <i class="las la-print"></i>
                        </button>
                        <button class="btn-error p-1">
                            <i class="las la-trash"></i>
                        </button>
                    </div>
                    <table class="w-full whitespace-nowrap text-sm text-left ">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr>
                                <td class="font-semibold px-4 py-2 w-1/3 uppercase">Salary Paid</td>
                                <td class="px-4 py-2 ">
                                    ₹ 2,322.00
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Salary Month</td>
                                <td class="px-4 py-2">August 2025</td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Working Days</td>
                                <td class="px-4 py-2">6.0 days</td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Reference Id</td>
                                <td class="px-4 py-2">
                                    SD934C1D25
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Transaction Status</td>
                                <td class="px-4 py-2 capitalized">
                                    Approved
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Payable Date</td>
                                <td class="px-4 py-2">10-10-2025 </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase ">Transaction Date</td>
                                <td class="px-4 py-2">
                                    10-10-2025
                                    
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Payable Date</td>
                                <td class="px-4 py-2">10-10-2025</td>
                            </tr>
                            <tr class="border-t"> 
                                <td class="font-semibold px-4 py-2 uppercase">UAN No</td>
                                <td class="px-4 py-2">0</td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">PF No</td>
                                <td class="px-4 py-2">0 </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">ESIC No</td>
                                <td class="px-4 py-2">0 </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Payment Mode</td>
                                <td class="px-4 py-2">	Cash</td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Remarks</td>
                                <td class="px-4 py-2">	Salary ( August 2025 ) paid via Cash.</td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Created at</td>
                                <td class="px-4 py-2">	10-10-2025</td>
                            </tr>
                             <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Updated at</td>
                                <td class="px-4 py-2">	10-10-2025</td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">Is Accounted</td>
                                <td class="px-4 py-2">
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                       Yes
                                    </span>
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                       No
                                    </span>
                                </td>
                            </tr>

                            
                        </tbody>
                    </table>
                </div>
                <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                    
                    <table class="w-full whitespace-nowrap text-sm text-left ">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr>
                                <td class="font-semibold px-4 text-lg py-2 w-1/3 uppercase border-b bg-secondary/5" colspan="2">
                                  BANK ACCOUNT INFO
                                </td>
                               
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 w-1/3 uppercase">
                                  Bank Name
                                </td>
                                <td class="px-4 py-2 ">
                                  
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">
                                   Bank A/c Holder's Name
                                </td>
                                <td class="px-4 py-2">
                                    
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">
                                    Bank A/c No
                                </td>
                                <td class="px-4 py-2">
                                    
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="font-semibold px-4 py-2 uppercase">
                                    IFSC Code
                                </td>
                                <td class="px-4 py-2">
                                   
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-full">
                <!--  SALARY DETAILS -->
                <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg">
                    <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-10">
                        <h3 class="text-black font-semibold text-lg uppercase"> SALARY DETAILS</h3>
                    </div>

                    <div class="overflow-x-auto p-4 ">
                        <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                            <tbody>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 w-1/3 uppercase" >Basic Salary</td>
                                    <td class="px-3 py-2">0.00</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 w-1/3 uppercase">HRA</td>
                                    <td class="px-3 py-2">0.00</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Education Allowance</td>
                                    <td class="px-3 py-2">0.00</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">LTA</td>
                                    <td class="px-3 py-2"> 0.00</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Telephone Reimbursement</td>
                                    <td class="px-3 py-2">0.00</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Fuel Charges</td>
                                    <td class="px-3 py-2"> 0.00</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Driver Charges</td>
                                    <td class="px-3 py-2">0.00</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Helper Allowance</td>
                                    <td class="px-3 py-2">0.00</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Special Allowance</td>
                                    <td class="px-3 py-2">
                                       0.00
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Variable Amount</td>
                                    <td class="px-3 py-2">
                                       0.00
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Gross Salary</td>
                                    <td class="px-3 py-2">
                                      2,322.00
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase text-center" colspan="2">DEDUCTION DETAILS</td>
                                    
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Employee PF</td>
                                    <td class="px-3 py-2">
                                       0.00
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Employer PF</td>
                                    <td class="px-3 py-2">
                                       0.00
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Gratuity</td>
                                    <td class="px-3 py-2">
                                        0.00
                                    </td>
                                </tr>
                                <tr  class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">ESIC Employee</td>
                                    <td class="px-3 py-2">
                                       0.00
                                    </td>
                                </tr>
                                 <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">ESIC Employer	</td>
                                    <td class="px-3 py-2">
                                       0.00
                                    </td>
                                </tr>
                                <tr  class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">TDS</td>
                                    <td class="px-3 py-2">
                                       0.00
                                    </td>
                                </tr>
                                 
                                <tr  class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Professional Tax</td>
                                    <td class="px-3 py-2">
                                       0.00
                                    </td>
                                </tr>
                                <tr  class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Rounding Off</td>
                                    <td class="px-3 py-2">
                                       0.00
                                    </td>
                                </tr>
                                 <tr  class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Total Deduction</td>
                                    <td class="px-3 py-2">
                                       0.00
                                    </td>
                                </tr>
                                 <tr  class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 text-center uppercase" colspan="2">
                                        NET PAYABLE
                                    </td>
                                    
                                </tr>
                                <tr  class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Net Salary</td>
                                    <td class="px-3 py-2">
                                       2,322.00
                                    </td>
                                </tr>
 
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>

         <div class="w-full mt-5">
            <!-- Card -->
            <div class="box shadow-md rounded-10">
                <!-- Header -->
                <div class="flex items-center justify-between px-4 py-3 dark:bg-bg3 bg-secondary/5 rounded-10 ">
                    <h3 class="text-lg font-semibold text-gray-800">SALARY TRANSACTION AUDIT TRAIL</h3>
                    <button type="button" class="p-1 rounded transition" onclick="toggleSection(this, 'auditTrail')">
                        <span class="toggle-icon text-lg font-bold">−</span>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-4" id="auditTrail">
                    <div class="overflow-x-auto">
                        <table class="w-full  text-sm md:text-base">
                            <thead class="bg-gray-100">
                                <tr class="text-start">
                                    <th class="px-4 py-2 text-start">Creator</th>
                                    <th class="px-4 py-2 text-start">Event</th>
                                    <th class="px-4 py-2 text-start ">Created On</th>
                                    <th class="px-4 py-2 text-start">Change Logs</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr class="text-start">
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- collapsed logic + - button-->
    <script>
        function toggleSection(button) {
            const section = button.closest('.box').querySelector('.overflow-x-auto');
            const icon = button.querySelector('.toggle-icon');
            section.classList.toggle('hidden');
            icon.textContent = section.classList.contains('hidden') ? '+' : '−';
        }
    </script>
@endsection