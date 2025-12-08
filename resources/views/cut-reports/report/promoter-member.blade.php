@extends('layout.main')
@section('content')
    <style>
        .breadcrumb {
            list-style: none;
            display: flex;
            padding: 0;
            margin-bottom: 1rem;
            font-size: 14px;
        }

        .breadcrumb li+li::before {
            content: "/";
            padding: 0 8px;
            color: #888;
        }

        .breadcrumb li a {
            text-decoration: none;
            color: #007bff;
        }

        .breadcrumb li.active {
            color: #555;
        }

        .custom-thead {
            background-color: #e6f4ea;
            color: #14532d;
        }

        .custom-thead th {
            font-weight: 600;
            border-bottom: 1px solid #ccc;
        }

        @media (prefers-color-scheme: dark) {
            .custom-thead {
                background-color: #14532d;
                color: #d1fae5;
            }
        }

        .bg-greens {
            background-color: #14532d;
        }
    </style>
    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-xl block  uppercase font-semibold">
           Report - Promoters/ Members
            </h3>

        </div>
        <div class="box mb-5 mt-5 ">
            <div class="flex justify-between" id="toggleBtn">
                <p class="font-semibold uppercase text-lg">
                    Search Box

                </p>
                <button class="text-2xl cursor-pointer">
                    <i id="toggleIcon" class="las la-plus"></i>
                </button>
            </div>
            <hr class="mt-3">
            <div id="toggleContent" class="mt-4">
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-5 w-full mt-4">
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-1 uppercase">Branch  </label>
                        <select id="" name=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3 ">
                           <option value="" class="uppercase">ALL </option>
                        </select>
                    </div>
                    
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-1 uppercase">
                            	Customer No
                        </label>
                        <input type="text" id="" name=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3 pl "
                            placeholder="Search Customer No">
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-1 uppercase">Customer First Name </label>
                        <input type="text" id="" name=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3 pl "
                            placeholder="Search Customer's First No">
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-1 uppercase">Customer Last Name </label>
                        <input type="text" id="" name=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3 pl "
                            placeholder="Search Customer's Last No">
                    </div>
                 
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-1 uppercase">Account No </label>
                        <input type="number" id="" name=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3 pl "
                            placeholder="Search Account No">
                    </div>
                    
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-1 uppercase">
                          Customer Mobile No  
                        </label>
                        <input type="text" id="" name=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3 pl "
                            placeholder="Search Mobile No">
                    </div>
                   
                </div>
                <div class="mt-5 flex justify-center gap-4 text-center">
                    <button class="btn-primary  px-1 flex justify-center py-2 text-sm uppercase">
                        Search
                    </button>
                    <button class="btn-warning  px-1 flex justify-center py-2 text-sm uppercase">
                        Clear Form
                    </button>
                </div>
            </div>
        </div>

        <div class="col-span-12 box lg:col-span-12">
            <div class="mb-5 flex justify-end gap-2 flex-col md:flex-row lg:flex-row">
                
                <a href="" class="btn-error rounded-10 px-1 flex justify-center py-2 text-sm uppercase">
                    <i class="las la-download"></i>
                   Request for Report
                </a>
            </div>

            <div class="pb-4 overflow-x-auto lg:pb-6">

                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                 MEMBER NO.		
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center uppercase gap-1">
                                   	MEMBER NAME
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                 BRANCH	
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                  KYC STATUS
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                   ENROLLMENT DATE	
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                  STATUS
                                </div>
                            </th>                          
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b dark:border-bg3">
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1  uppercase">
                                  DEMO-02033
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 Capitalize">
                                RUDHRA CHANDRA KIRAN
                                </div>
                            </td>

                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center  gap-1">
                                   SAHARANPUR
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center t gap-1">
                                    PENDING
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                             17-06-2022
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                 Active		
                                </div>
                            </td>
                                                 
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
       
        <script>
            const btn = document.getElementById("toggleBtn");
            const content = document.getElementById("toggleContent");
            const icon = document.getElementById("toggleIcon");

            btn.addEventListener("click", () => {
                content.classList.toggle("hidden");

                // Toggle icon
                if (content.classList.contains("hidden")) {
                    icon.classList.remove("la-minus");
                    icon.classList.add("la-plus");
                } else {
                    icon.classList.remove("la-plus");
                    icon.classList.add("la-minus");
                }
            });
        </script>
@endsection