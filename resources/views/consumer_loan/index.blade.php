@extends('layout.main')
@section('content')
    <div class="main-inner">
      
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
                <h1 class=" flex text-xl block font-semibold">CONSUMER DURABLE LOAN</h1>
                <a href="" class=" block flex btn-primary uppercase ">Add
                </a>
            </div>  
 
        @if(session('success'))
            <div class="">
                <div class="w-44 mb-5 flex justify-end">
                    <x-alert />
                </div>
                {{-- {{ session('success') }} --}}
            </div>
        @endif
              
        <div class="col-span-12 box lg:col-span-12">
            <div class="pb-4 overflow-x-auto lg:pb-6">

                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center uppercase gap-1">
                                    SCHEME CODE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center uppercase gap-1">
                                    SCHEME NAME
                                </div>
                            </th>
                           
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center uppercase gap-1">
                                    LOAN AMOUNT
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center uppercase gap-1">
                                    No of EMI
                                </div>
                            </th>

                             <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center uppercase gap-1">
                                    EMI AMOUNT
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center uppercase gap-1">
                                    EMI PAYOUT
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center uppercase gap-1">
                                    A. INTEREST RATE (%)
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center uppercase gap-1">
                                    ACTIVE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center uppercase gap-1">
                                    ACTIONS
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                      
                            <tr>
                                <td colspan="8" class="text-center py-5">No Schemes Found</td>
                            </tr>
                       
                    </tbody>
                </table>

                <div class="mt-6">
                    
                </div>
            </div>
        </div>


@endsection