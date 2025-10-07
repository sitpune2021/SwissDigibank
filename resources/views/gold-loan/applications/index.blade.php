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
    @foreach($applications as $application)
        <tr class="border-b dark:border-bg3">
          
            <!-- Application No. -->
           <td class="text-start !py-5 px-6">
                <a href="{{ route('gold-loan.applications.view', $application->id) }}" 
                class="text-blue-600 hover:underline">
                    {{ $application->id }}
                </a>
            </td>

            <!-- Application Date -->
            <td class="text-start !py-5 px-6">
                {{ \Carbon\Carbon::parse($application->application_date)->format('d/m/Y') }}
            </td>

            <!-- Member No -->
            <td class="text-start !py-5 px-6">
                <a href="{{ url('members/member/' . $application->member_id) }}" 
                class="text-blue-600 hover:underline">
                    {{ $application->member_id??'' }}
                </a>
            </td>


            <!-- Member Name (अगर relation है तो member->name, अभी के लिए member_id ही दिखा रहा हूँ) -->
            <td class="text-start !py-5 px-6">
                {{ $application->member->member_info_first_name ?? 'N/A' }}
            </td>

            <!-- Branch -->
            <td class="text-start !py-5 px-6">
                {{ $application->branch->branch_name ?? 'N/A' }}
            </td>

            <!-- Scheme -->
            <td class="text-start !py-5 px-6">
                {{ $application->scheme->scheme_name ?? 'N/A' }}
            </td>

            <!-- Principal Amount -->
            <td class="text-start !py-5 px-6">
                {{ number_format($application->net_loan_amount, 2) }}
            </td>

            <!-- Status -->
            <td class="text-start !py-5 px-6">
                {{ $application->credited ?? 'PENDING' }}
            </td>

            <!-- Actions -->
            <td class="text-start !py-5 px-6">
                <div class="flex justify-center">
                    <div class="relative">
                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                        <ul class="horiz-option popover-content">
                            <li><a href="{{ route('gold-loan.applications.view', $application->id) }}" class="single-option capitalize">View</a></li>
                            <li><a href="{{ route('gold-loan.applications.edit', $application->id) }}" class="single-option capitalize">Edit</a></li>
                        </ul>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
</tbody>


                </table>
            </div>


        </div>
@endsection