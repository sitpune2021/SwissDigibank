@extends('layout.main')

@section('content')

<style>
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

    input[type="radio"] {
        width: 24px;
        height: 24px;
        accent-color: green;
        /* Modern browser support */
    }
</style>

<div class="main-inner">

    <div class=" flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col  gap-2">
            <div class="flex items-center gap-3">
                <h1 class="text-lg font-semibold uppercase">
                   VL013
                </h1>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-2 md:grid-cols-3 gap-6  min-h-screen md-4">
        <div class="col-span-2 md:col-span-1  dark:bg-bg3 rounded-2xl ">
            <div class="w-full md:w-2/3">
                <div class="box rounded-lg shadow-sm">

                    <!-- Header -->
                    <div class="flex items-center justify-between px-5 py-4 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">
                            Text SMS Setting
                        </h3>

                        <a href="{{ route('software-settings.edit-sms-setting') }}" 
                            class="btn-primary p-2">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>

                    <!-- Body -->
                    <div class="p-5 overflow-x-auto">
                        <table class="w-full  whitespace-nowrap overflow-x-auto border-collapse">
                            <tbody class="divide-y">

                                <tr class="border-b">
                                    <td class="w-[35%] font-semibold text-gray-700 py-3">
                                        Name
                                    </td>
                                    <td class="py-3 px-3 text-gray-800">
                                        Vehicle Loan EMI PAID (static)
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold text-gray-700 py-3">
                                        Code
                                    </td>
                                    <td class="py-3 px-3 text-gray-800">
                                        VL013 (static)
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold text-gray-700 py-3">
                                        Message Template
                                    </td>
                                    <td class="py-3 px-3 text-gray-800">
                                        Dear Customer, EMI of Rs. @amount_1 towards Loan a/c no
                                        @account_number_1 is PAID. @sms_signature (static)
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold  text-gray-700 py-3">
                                        Message Template <br>
                                        
                                    ( For Approval from <br> your DLT Partner )
                                        
                                    </td>
                                    <td class="py-3 px-3 text-gray-800">
                                        Dear Customer, EMI of Rs. {#var#} towards Loan a/c no {#var#}
                                        is PAID. HUBERP (static)
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold text-gray-700 py-3">
                                        Your Entity ID
                                    </td>
                                    <td class="py-3 px-3 text-gray-800">
                                        (static)
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold text-gray-700 py-3">
                                        Your Sender ID
                                    </td>
                                    <td class="py-3 px-3 text-gray-800">
                                        (static)
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold text-gray-700 py-3">
                                        Your Signature
                                    </td>
                                    <td class="py-3 px-3 text-gray-800">
                                        (static)
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold text-gray-700 py-3">
                                        Your Template ID
                                    </td>
                                    <td class="py-3 px-3 text-gray-800">
                                        (static)
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-3 text-gray-700 py-3">
                                        Active
                                    </td>
                                    <td class="py-3">
                                       <div class="flex items-center gap-1">
                                    <span
                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                Yes
                            </span>
                             <span
                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                No
                            </span>
                                </div>
                                         (static)
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
        <div class="col-span-2 md:col-span-1  dark:bg-bg3 rounded-2xl ">

            <div class="box">
                <div class="text-lg border-b py-2">
                    Enter Mobile No to Test the SMS Configuration / Delivery
                </div>

                <div class="overflow-x-auto mt-3">
                    <div class="mb-4">
                        <label for="" class="block font-medium mb-2">
                            Mobile No
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-4">
                            <input type="numer" id="" name="" value="+91"
                                class="w-28 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="Display Name">
                            <input type="number" id="" name=""
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="Enter Mobile No">
                        </div>
                        <div class="mt-5 text-center">
                            <button class="uppercase btn-primary rounded-10">Send Test SmS</button>
                        </div>
                    </div>
                    @error('branch_id')
                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>
    </div>
</div>
</div>






@endsection