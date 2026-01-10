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
                Master Settings - Attendance
            </h1>
        </div>
    </div>
    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <!-- Left: Details -->
        <div class=" w-full  overflow-hidden">
            <div class="box dark:bg-bg3 border-gray-200 shadow-md rounded-lg">
                <!-- Header -->

                <div class=" overflow-x-auto">
                    <div class="mb-4">
                        <label for="" class="block font-medium mb-2">
                            Full Day Duration
                        </label>
                        <select type="text" id="" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                            placeholder="Enter Member App Play Store Url">
                            <option value="">Please Select </option>
                            <option value="">7 Hours</option>
                            <option value="">8 Hours</option>
                            <option value="">9 Hours</option>
                            <option value="">10 Hours</option>
                            <option value="">11 Hours</option>
                            <option value="">12 Hours</option>
                        </select>
                    </div>
                </div>
                <div class=" overflow-x-auto">
                    <div class="mb-4">
                        <label for="" class="block font-medium mb-2">
                            Half Day Duration
                        </label>
                        <select type="text" id="" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                            placeholder="Enter Member App Play Store Url">
                            <option value="">Please Select </option>
                            <option value="">4 Hours</option>
                            <option value="">5 Hours</option>
                            <option value="">6 Hours</option>

                        </select>

                    </div>
                </div>
                <div class=" overflow-x-auto">
                    <div class="mb-4">
                        <label for="" class="block font-medium mb-2">
                            Mark Half Day After (HH:MM)
                        </label>
                        <div class="flex gap-2">
                            <select type="text" id="" name=""
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="Enter Member App Play Store Url">
                                <option value=""> Select Hours</option>
                                <option value="">9 </option>
                                <option value="">10 </option>
                                <option value="">11</option>
                                <option value="">12</option>
                            </select>
                            <select type="text" id="" name=""
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="Enter Member App Play Store Url">
                                <option value="0">0</option>
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                                <option value="30">30</option>
                                <option value="35">35</option>
                                <option value="40">40</option>
                                <option value="45">45</option>
                                <option value="50">50</option>
                                <option value="55">55</option>

                            </select>
                            <select type="text" id="" name=""
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="Enter Member App Play Store Url">
                                <option value="">AM</option>
                                <option value="">PM</option>
                            </select>
                        </div>

                    </div>
                </div>
                 <div class=" overflow-x-auto">
                    <div class="mb-4">
                        <label for="" class="block font-medium mb-2">
                           Disable In Time 
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="radio" name="" id=""> <p> Yes </p>
                              <input type="radio" name="" id=""> <p> No </p>
                        </div>

                    </div>
                </div>
               <div class=" overflow-x-auto">
                    <div class="mb-4">
                        <label for="" class="block font-medium mb-2">
                         Disable Out Time 
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="radio" name="" id=""> <p> Yes </p>
                              <input type="radio" name="" id=""> <p> No </p>
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