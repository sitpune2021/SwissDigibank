@extends('layout.main')
@section('content')
    <div class="main-inner">
        
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
                <h3 class=" flex text-xl block font-semibold">GOLD LOAN APPLICATIONS</h3>
                <a href="{{route('gold-loan.applications.create')}}" class=" block flex btn-primary capitalize ">add
                </a>

            </div>

      
       <div class="col-span-12 box lg:col-span-12">
            <div class="pb-4 overflow-x-auto lg:pb-6">
                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                   ASSOCIATE
                                </div>
                            </th>
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
                                  MEMBER NO
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                  	MEMBER NAME
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
                                  	PRINCIPAL AMT.
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
                                <div class="flex items-center gap-1 text-secondary uppercase">
                                 
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 Capitalize">
                                    00591
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    18/09/2025
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                  DEMO-04428
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                  shreepad page
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                   Chas Bokaro
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                   Suvarna shree yojana flat advanced interest deduction
                                </div>
                            </td>
                              <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                  100,000.00
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                             DISBURSED
                                </div>
                            </td>

                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex justify-center">
                                    <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                        <ul class="horiz-option popover-content">
                                            <li><a href="" class="single-option capitalize">View</a></li>
                                            <li><a href="" class="single-option capitalize">Edit</a></li>
                                             <li><a href="" class="single-option capitalize">disburse settings</a></li>
                                            
                                        </ul>

                                        {{-- @include('partials._vertical-options', [
                                        /* 'id' =>base64_encode($director->id),
                                        'viewRoute' => 'director.show',
                                        'editRoute' => 'director.edit'*/
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