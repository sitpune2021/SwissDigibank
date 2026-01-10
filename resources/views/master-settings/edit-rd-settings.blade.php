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
                Master Settings - RD
            </h1>
        </div>
    </div>
    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <!-- Left: Details -->
        <div class=" w-full  overflow-hidden">
            <div class="box dark:bg-bg3 border-gray-200 shadow-md rounded-lg">


                <div class=" mt-3 overflow-x-auto">
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
                <div class=" mt-3 overflow-x-auto">
                    <div class="mb-4 ">
                        <label for="" class="block font-medium mb-2">
                            Hold Account After
                        </label>
                        <select id="" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <option value="">Please Select</option>
                            <option value="5">5 Installment DUE / OVERDUE</option>
                            <option value="10">10 Installment DUE / OVERDUE</option>
                            <option value="15">15 Installment DUE / OVERDUE</option>
                            <option value="20">20 Installment DUE / OVERDUE</option>
                            <option value="25">25 Installment DUE / OVERDUE</option>
                            <option value="30">30 Installment DUE / OVERDUE</option>
                            <option value="35">35 Installment DUE / OVERDUE</option>
                            <option value="40">40 Installment DUE / OVERDUE</option>
                            <option value="45">45 Installment DUE / OVERDUE</option>
                            <option value="50">50 Installment DUE / OVERDUE</option>
                        </select>

                    </div>
                </div>
                <div class=" mt-3 overflow-x-auto">
                    <div class="mb-4 ">
                        <label for="" class="block font-medium mb-2">
                            Mark Installment Canceled

                        </label>
                        <select id="" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <option value="">Please Select</option>
                            <option value="1">1 Installment DUE / OVERDUE</option>
                            <option value="2">2 Installment DUE / OVERDUE</option>
                            <option value="3">3 Installment DUE / OVERDUE</option>
                            <option value="4">4 Installment DUE / OVERDUE</option>
                            <option value="5">5 Installment DUE / OVERDUE</option>
                            <option value="6">6 Installment DUE / OVERDUE</option>
                            <option value="7">7 Installment DUE / OVERDUE</option>
                            <option value="8">8 Installment DUE / OVERDUE</option>
                            <option value="9">9 Installment DUE / OVERDUE</option>
                            <option value="10">10 Installment DUE / OVERDUE</option>
                            <option value="11">11 Installment DUE / OVERDUE</option>
                            <option value="12">12 Installment DUE / OVERDUE</option>
                            <option value="13">13 Installment DUE / OVERDUE</option>
                            <option value="14">14 Installment DUE / OVERDUE</option>
                            <option value="15">15 Installment DUE / OVERDUE</option>
                            <option value="16">16 Installment DUE / OVERDUE</option>
                            <option value="17">17 Installment DUE / OVERDUE</option>
                            <option value="18">18 Installment DUE / OVERDUE</option>
                            <option value="19">19 Installment DUE / OVERDUE</option>
                            <option value="20">20 Installment DUE / OVERDUE</option>
                            <option value="21">21 Installment DUE / OVERDUE</option>
                            <option value="22">22 Installment DUE / OVERDUE</option>
                            <option value="23">23 Installment DUE / OVERDUE</option>
                            <option value="24">24 Installment DUE / OVERDUE</option>
                            <option value="25">25 Installment DUE / OVERDUE</option>
                        </select>

                    </div>
                </div>
                <div class=" mt-3 overflow-x-auto">
                    <div class="mb-4 ">
                        <label for="" class="block font-medium mb-2">
                            Maximum Installment Collected

                        </label>
                        <select id="" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <option value="">Please Select</option>
                            <option value="1">1 installments</option>
                            <option value="2">2 installments</option>
                            <option value="3">3 installments</option>
                            <option value="4">4 installments</option>
                            <option value="5">5 installments</option>
                            <option value="6">6 installments</option>
                            <option value="7">7 installments</option>
                            <option value="8">8 installments</option>
                            <option value="9">9 installments</option>
                            <option value="10">10 installments</option>
                            <option value="11">11 installments</option>
                            <option value="12">12 installments</option>
                            <option value="13">13 installments</option>
                            <option value="14">14 installments</option>
                            <option value="15">15 installments</option>
                            <option value="16">16 installments</option>
                            <option value="17">17 installments</option>
                            <option value="18">18 installments</option>
                            <option value="19">19 installments</option>
                            <option value="20">20 installments</option>
                        </select>

                    </div>
                </div>
                <div class=" mt-3 overflow-x-auto">
                    <div class="mb-4 ">
                        <label for="" class="block font-medium mb-2">
                            Penalty Charges
                        </label>
                        <div class="flex gap-3">
                            <select id="" name=""
                                class="w-28 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                                <option value="">%</option>
                                <option class="uppercase" value="">Fixed</option>
                            </select>
                            <input type="text" name="" id=""
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="Enter Penalty">
                        </div>



                    </div>
                </div>
                <div class=" mt-3 overflow-x-auto">
                    <div class="mb-4 ">
                        <label for="" class="block font-medium mb-2">
                            Penalty Grace Period
                        </label>
                        <select id="" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <option value="">Select Grace Period after which installment marked overdue</option>
                            <option value="1">1 days</option>
                            <option value="2">2 days</option>
                            <option value="3">3 days</option>
                            <option value="4">4 days</option>
                            <option value="5">5 days</option>
                            <option value="6">6 days</option>
                            <option value="7">7 days</option>
                            <option value="8">8 days</option>
                            <option value="9">9 days</option>
                            <option value="10">10 days</option>
                            <option value="11">11 days</option>
                            <option value="12">12 days</option>
                            <option value="13">13 days</option>
                            <option value="14">14 days</option>
                            <option value="15">15 days</option>
                            <option value="16">16 days</option>
                            <option value="17">17 days</option>
                            <option value="18">18 days</option>
                            <option value="19">19 days</option>
                            <option value="20">20 days</option>
                            <option value="21">21 days</option>
                            <option value="22">22 days</option>
                            <option value="23">23 days</option>
                            <option value="24">24 days</option>
                            <option value="25">25 days</option>
                            <option value="26">26 days</option>
                            <option value="27">27 days</option>
                            <option value="28">28 days</option>
                            <option value="29">29 days</option>
                            <option value="30">30 days</option>
                        </select>

                    </div>
                </div>
                <div class=" mt-3 overflow-x-auto">
                    <div class="mb-4 ">
                        <label for="" class="block font-medium mb-2">
                            Collection in Multiple's of Installment Amount
                        </label>
                        <div class="flex gap-2 items-center">
                            <input type="radio" name="" id="">
                            <p>Yes</p>
                            <input type="radio" name="" id="">
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