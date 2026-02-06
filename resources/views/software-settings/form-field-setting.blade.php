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
            <h1 class="text-lg uppercase font-semibold">Software Form Fields Settings</h1>

        </div>
    </div>


  <div class="box">
    <div class="text-lg font-semibold border-b">
        MEMBER FORM FIELDS - ON / OFF
    </div>
      <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 mt-4  gap-4 xxxl:gap-6">

        <div class="col-span-2 md:col-span-1 ">
            <div class="flex items-center  justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                    MOBILE NO VERIFICATION 
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
         <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between  gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                    LAST NAME PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
        <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                    FATHER NAME PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
         <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                    MOTHER NAME PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
        <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                   UNIQUE MOBILE NO
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
         <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                   MARITAL STATUS PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
        <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                   RELIGION PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
         <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                   
                </label>
                <label class="inline-flex items-center cursor-pointer">
                                    
                </label>

            </div>
        </div>
        <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                   EMAIL PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
         <div class="col-span-2 md:col-span-1">
            <div class="flex items-center gap-2  justify-between space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                    ADDRESS LINE 1 PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
        <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                  WARD PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
         <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                   PANCHAYAT PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
        <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                   AREA PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
         <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                   CITY PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
        <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                  PINCODE PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
         <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                    ADDHAR NO PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
        <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                   AADHAR NO UNIQUE DISABLE
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
         <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                    PAN NO PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
        <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                    PAN NO UNIQUE DISABLE
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
         <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                    NOMINEE NAME PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
        <div class="col-span-2 md:col-span-1">
            <div class="flex items-center gap-2 justify-between space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                   NOMINEE RELATION PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
         <div class="col-span-2 md:col-span-1">
            <div class="flex items-center  justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                   NOMINEE MOBILE NO PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
        <div class="col-span-2 md:col-span-1">
            <div class="flex items-center  justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                     MEMBER NOMINEE DOB PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
         <div class="col-span-2 md:col-span-1">
            <div class="flex items-center gap-2 justify-between space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                   MEMBER PHOTO PRESENT FOR KYC
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
        <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                    MEMBER ID PROOF PRESENT FOR KYC
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
         <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                    MEMBER ID PROOF BACK PAGE PRESENT FOR KYC
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
        <div class="col-span-2 md:col-span-1">
            <div class="flex items-center  justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                    MEMBER ADDRESS PROOF PRESENT FOR KYC
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
         <div class="col-span-2 md:col-span-1">
            <div class="flex items-center  justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                 MEMBER ADDRESS PROOF BACK PAGE PRESENT FOR KYC
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
        <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                   MEMBER PAN CARD PRESENT FOR KYC
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
         <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                    MEMBER SIGNATURE PRESENT FOR KYC
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
        <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                  ENABLE MEMBER ADDRESS STATE SELECTION
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
         <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                    ENABLE MEMBER ADDRESS PERMANENT STATE SELECTION
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
        <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                   OCCUPATION PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
        <div class="col-span-2 md:col-span-1">
            <div class="flex items-center justify-between gap-2 space-x-2">
                
               

            </div>
        </div>


    </div>
  </div>
   <div class="mt-5 box">
    <div class="text-lg font-semibold border-b">
        ASSOCIATE FORM FIELDS - ON / OFF
    </div>
      <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 mt-4  gap-4 xxxl:gap-6">

        <div class="col-span-2 md:col-span-1 ">
            <div class="flex items-center  justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                   ASSCOCIATE/ ADVISOR/ STAFF 
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                    
                </label>

            </div>
        </div>
         


    </div>
  </div>
  <div class="mt-5 box">
    <div class="text-lg font-semibold border-b">
        LOAN APPLICATION FIELDS - ON / OFF
    </div>
      <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 mt-4  gap-4 xxxl:gap-6">

        <div class="col-span-2 md:col-span-1 ">
            <div class="flex items-center  justify-between gap-2 space-x-2">
                <label for="" class="text-base font-semibold cursor-pointer mb-0">
                  LOAN DOCUMENT VIDEO PRESENT
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                    <div class="relative">
                        <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                        </div>
                        <div
                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                        </div>
                    </div>
                </label>
            </div>
        </div>
    </div>
  </div>




    <script>
        document.addEventListener('DOMContentLoaded', function () {
                const interestButton = document.getElementById('interestButton');
                const interestMenu = document.getElementById('interestMenu');
                const interestArrow = document.getElementById('interestArrow');

                // Toggle menu on button click
                interestButton.addEventListener('click', function (e) {
                    e.stopPropagation(); // Prevent click from closing immediately

                    interestMenu.classList.toggle('hidden');
                    interestArrow.classList.toggle('rotate-180');
                });

                // Close menu when clicking outside
                document.addEventListener('click', function (e) {
                    if (!interestMenu.classList.contains('hidden')) {
                        interestMenu.classList.add('hidden');
                        interestArrow.classList.remove('rotate-180');
                    }
                });
            });
    </script>
    <script>
        // Label update on toggle
            document.querySelectorAll('.slider-toggle').forEach(toggle => {
                toggle.addEventListener('change', function () {
                    const label = document.getElementById(this.dataset.labelId);
                    label.textContent = this.checked ? 'ON' : 'OFF';
                });

                // Initialize label on page load
                toggle.dispatchEvent(new Event('change'));
            });
    </script>

    @endsection