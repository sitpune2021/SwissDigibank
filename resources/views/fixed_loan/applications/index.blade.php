@extends('layout.main')
@section('content')
    <div class="main-inner">
        
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
                <h3 class=" flex text-lg block font-semibold">FIXED LOAN APPLICATION</h3>
                <a href="{{route('fixed_loan.applications.create')}}" class=" block flex btn-primary uppercase ">add
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
                                    <a href="{{ route('fixed_loan.applications.view', $application->id) }}" 
                                    class="text-green-600 hover:underline">
                                        {{-- {{ $application->id }} --}}
                                        {{ str_pad($application->id, 10, '0', STR_PAD_LEFT) }}
                                    </a>
                                </td>

                                <!-- Application Date -->
                                <td class="text-start !py-5 px-6">
                                    {{ \Carbon\Carbon::make($application->application_date)->format('d-m-Y') }}
                                </td>

                                <!-- Member No -->
                                <td class="text-start !py-5 px-6">
                                    <a href="{{ url('members/member/' . $application->member_id) }}" 
                                    class="text-green-600 hover:underline">
                                        {{ str_pad($application->member_id, 6, '0', STR_PAD_LEFT) }}
                                    </a>
                                </td>


                                <!-- Member Name ( relation member->name, member_id ) -->
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

                            <!-- Status -->
                                <td class="text-start !py-5 px-6">
                                    @if($application->status == 0)
                                        DRAFT
                                    @elseif($application->status == 1)
                                        APPROVED
                                    @elseif($application->status == 2)
                                        DISBURSED
                                    @else
                                        CANCELLED
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="text-start !py-5 px-6">
                                    <div class="flex justify-center">
                                        <div class="relative">
                                            <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                            <ul class="horiz-option popover-content">
                                                <li><a href="{{ route('fixed_loan.applications.view', $application->id) }}" class="single-option uppercase">View</a></li>
                                                @if($application->status != 2 )
                                                <li><a href="{{ route('fixed_loan.applications.edit', $application->id) }}" class="single-option uppercase">Edit</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

                <div class="mt-6">
                    <x-pagination :paginator="$applications" />
                </div>
            </div>

        </div>
@endsection