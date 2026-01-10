@extends('layout.main')
@section('content')
<style>
    input[type="checkbox"] {
        width: 24px !important;
        height: 24px !important;
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

    .tableWidth {
        width: 90%;
        margin: auto;
    }

    .bg-yellow {
        background-color: #e17100;
    }

    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    /* Container for the toggle background */
    .blocks {
        width: 56px;
        /* 14 * 4px */
        height: 32px;
        /* 8 * 4px */
        border-radius: 9999px;
        /* Fully rounded */
        background-color: #9CA3AF;
        /* Tailwind gray-400 default */
        transition: background-color 0.3s ease;
    }

    /* The small white dot */
    .dot {
        position: absolute;
        top: 4px;
        /* 1 * 4px */
        left: 4px;
        /* 1 * 4px */
        width: 24px;
        /* 6 * 4px */
        height: 24px;
        /* 6 * 4px */
        background-color: white;
        border-radius: 9999px;
        transition: transform 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
    }

    /* When the checkbox is checked, change bg color */
    input[type="checkbox"].slider-toggle:checked+div .blocks {
        background-color: #228cc5;
        /* Tailwind green-500 */
    }

    /* Move the dot to right when checked */
    input[type="checkbox"].slider-toggle:checked+div .dot {
        transform: translateX(24px);
        /* 6 * 4px */
    }
</style>
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-4">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-lg uppercase font-semibold">
                Master Settings - Gold Loan
            </h1>
        </div>
    </div>
    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <!-- Left: Details -->
        <div class=" w-full  overflow-hidden">
            <div class="box dark:bg-bg3 border-gray-200 shadow-md rounded-lg">
                <div class=" overflow-x-auto">
                    <div class="mb-4 mt-5">
                        <label for="" class="block font-medium mb-2">
                            Add Collect Adv. Processing fee
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="radio" id="" name="adv-proceesing-fee" class="">
                            <p>Yes </p>
                            <input type="radio" id="" name="adv-proceesing-fee" class="">
                            <p>No</p>
                        </div>

                    </div>
                    <div class="mb-4 mt-5">
                        <label for="" class="block font-medium mb-2">
                            Add Cibil Score Line Item
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="radio" id="" name="cibil_score" class="">
                            <p>Yes </p>
                            <input type="radio" id="" name="cibil_score" class="">
                            <p>No</p>
                        </div>

                    </div>
                    <div class="mt-3 mb-3">
                        <hr>
                    </div>
                </div>
                <div class=" overflow-x-auto">
                    <div class="mb-4 ">
                        <label for="" class="block font-medium mb-2">
                            Number of CIBIL Records Mandatory
                        </label>
                        <select id="" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <option value="">Please Select</option>
                            <option value="">1</option>
                            <option value="">2</option>
                            <option value="">3</option>
                            <option value="">4</option>
                        </select>

                    </div>
                </div>
                <div class=" overflow-x-auto">
                    <div class="mb-4 ">
                        <label for="" class="block font-medium mb-2">
                            Reminder SMS

                        </label>
                        <select id="" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <option value="">Please Select</option>
                            <option value="1">1 days before installment due date</option>
                            <option value="2">2 days before installment due date</option>
                            <option value="3">3 days before installment due date</option>
                            <option value="4">4 days before installment due date</option>
                            <option value="5">5 days before installment due date</option>
                            <option value="6">6 days before installment due date</option>
                            <option value="7">7 days before installment due date</option>
                            <option value="8">8 days before installment due date</option>
                            <option value="9">9 days before installment due date</option>
                            <option value="10">10 days before installment due date</option>
                        </select>


                    </div>
                </div>
                <div class=" overflow-x-auto">
                    <div class="mb-4 ">
                        <label for="" class="block font-medium mb-2">
                            Penalty Charges
                        </label>
                        <div class="flex gap-3">
                            <select id="" name=""
                                class="w-28 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                                <option value="">%</option>
                                <option value="">FIXED</option>
                            </select>

                            <input type="text" id="" name=""
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="Enter Penalty Charges">
                        </div>

                    </div>
                </div>
                <div class=" overflow-x-auto">
                    <div class="mb-4 ">
                        <label for="" class="block font-medium mb-2">
                            Overdue Interest (%)
                        </label>
                        <div class="flex gap-3">
                            <select id="" name=""
                                class="w-28 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                                <option value="">TYPE_1</option>
                                <option value="">TYPE_2</option>
                            </select>

                            <input type="text" id="" name=""
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="Enter Overdue Interest (%)">
                        </div>
                    </div>
                </div>
                <div class=" overflow-x-auto">
                    <div class="mb-4 ">
                        <label for="" class="block font-medium mb-2">
                            NO EMI Interest Slab

                        </label>
                        <input type="number" id="" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                            placeholder="0.0">

                    </div>
                </div>

                <div class=" mt-3 overflow-x-auto">
                    <div class="mb-4 ">
                        <label for="" class="block font-medium mb-2">
                            Documentation Charges
                        </label>
                        <input type="text" id="" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                            placeholder="Documentation Charges">

                    </div>
                </div>
                <div class=" overflow-x-auto">
                    <div class="mb-4 ">
                        <label for="" class="block font-medium mb-2">
                            EMI Bounce Charges (Cheque)
                        </label>
                        <input type="text" id="" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                            placeholder="Enter Bounce Charges ">

                    </div>
                </div>
                <div class=" overflow-x-auto">
                    <div class="mb-4 ">
                        <label for="" class="block font-medium mb-2">
                            EMI Installment Cancellation Charges
                        </label>
                        <input type="text" id="" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                            placeholder="EMI Installment Cancellation Charges">

                    </div>
                </div>
                <div class=" overflow-x-auto">
                    <div class="mb-4 ">
                        <label for="" class="block font-medium mb-2">
                            No Due Certificate Charges
                        </label>
                        <input type="text" id="" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                            placeholder="No Due Certificate Charges">

                    </div>
                </div>

                <div class=" overflow-x-auto">
                    <div class="mb-4 mt-5">
                        <label for="" class="block font-medium mb-2">
                          Debit Other Charges
Directly To Loan Account 
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="radio" id="" name="dbt_oth_cha" class="">
                            <p>Yes </p>
                            <input type="radio" id="" name="dbt_oth_cha" class="">
                            <p>No</p>
                        </div>

                    </div>
                    <div class="mb-4 mt-5">
                        <label for="" class="block font-medium mb-2">
                            Enable Disbursement Settings 
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="radio" id="" name="enb_dis_set" class="">
                            <p>Yes </p>
                            <input type="radio" id="" name="enb_dis_set" class="">
                            <p>No</p>
                        </div>

                    </div>
                    
                </div>
                 <div class=" overflow-x-auto">
                    <div class="mb-4 ">
                        <label for="" class="block font-medium mb-2">
                          Insurance Charges Funded 
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="radio" id="" name="ins_cha_fund" class="">
                            <p>Yes </p>
                            <input type="radio" id="" name="ins_cha_fund" class="">
                            <p>No</p>
                        </div>

                    </div>
                    <div class="mb-4 mt-5">
                        <label for="" class="block font-medium mb-2">
                        Disable Cash Disbursement
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="radio" id="" name="dsb_cash_dis" class="">
                            <p>Yes </p>
                            <input type="radio" id="" name="dsb_cash_dis" class="">
                            <p>No</p>
                        </div>

                    </div>
                    
                </div>




                <div class="flex gap-5 justify-center mt-5">
                    <button class="btn-primary uppercase ">Update</button>
                    <button class="btn-outline uppercase ">Back</button>
                </div>
            </div>

        </div>


        <!-- Right: Settings -->
        <div class=" w-full overflow-hidden "> </div>

    </div>


    @endsection