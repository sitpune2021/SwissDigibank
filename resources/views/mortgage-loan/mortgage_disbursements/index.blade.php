@extends('layout.main')

@section('content')
<div class="main-inner">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
        <h1 class=" flex text-xl block font-semibold">
            PROPERTY/ MORTGAGE LOAN DISBURSEMENT
        </h1>
    </div>



    <div class="col-span-12 box lg:col-span-12">
        <div class="pb-4 overflow-x-auto lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                APPLICATION NO.
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                APPLICATION DATE
                            </div>
                        </th>


                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                CUSTOMER NO
                            </div>
                        </th>

                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                CUSTOMER NAME
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                BRANCH
                            </div>
                        </th>

                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                SCHEME
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                APPROVED AMT. 
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                STATUS
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                ACTIONS
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>

                    <tr class="border-b dark:border-bg3">
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 Capitalize">
                                100136
                            </div>
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                18/09/2025
                            </div>
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Demo-123
                            </div>
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                shreepad page
                            </div>
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                barkagoan
                            </div>
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                ecure home scheme
                            </div>
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                200,000.00
                            </div>
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                               APPROVED
                            </div>
                        </td>

                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex justify-center">
                                <div class="relative">
                                    <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                    <ul class="horiz-option popover-content">
                                        <li><a href="#" class="single-option">DISBURSE LOAN</a></li>
                                        <li><a href="#" class="single-option">CANCEL LOAN</a></li>
                                    </ul>

                                    {{-- @include('partials._vertical-options', [
                                       'id' =>base64_encode($director->id),
                                        'viewRoute' => 'director.show',
                                        'editRoute' => 'director.edit'
                                        ]) --}}
                                </div>
                            </div>
                        </td>
                    </tr>

                </tbody>

            </table>
        </div>


    </div>
    @endsection