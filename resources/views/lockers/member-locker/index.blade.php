@extends('layout.main')

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

@section('content')
    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-lg   uppercase  font-bold">
            Member Lockers
            </h3>
            
        </div>
        <div class="col-span-12 box lg:col-span-12">
      
            <div class="tab-content p-4">
                <div>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse whitespace-nowrap text-sm">
                            
                            <thead>
                                <tr class="bg-secondary/5 dark:bg-bg3">
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            LOCKER NO.	
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                           LOCKER NAME	
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                          MEMBER NAME		
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                        <div class="flex  text-lg  uppercase items-center gap-1">
                                         ACCOUNT NO		
                                        </div>
                                    </th>
                                     <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                        <div class="flex  text-lg  uppercase items-center gap-1">
                                         ASSIGNED DATE	
                                        </div>
                                    </th>
                                     <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                        <div class="flex  text-lg  uppercase items-center gap-1">
                                        RELEASE DATE	
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                        <div class="flex  text-lg  uppercase items-center gap-1">
                                       ASSIGNED	
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            ACTIONS
                                        </div>
                                    </th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($lockers as $key => $locker)
                                    <tr class="border-b dark:border-bg3">

                                        {{-- Locker No --}}
                                        <td class="px-6 py-3 uppercase ">
                                            {{ $locker->locker_no }}
                                        </td>

                                        {{-- Locker Name --}}
                                        <td class="px-6 py-3  capitalize">
                                            {{ $locker->locker_name }}
                                        </td>

                                        {{-- Member Name --}}
                                        <td class="text-start !py-3 px-6">
                                            <a href="{{ url('members/member/' . $locker->member_no) }}" 
                                            class="text-green-600 hover:underline">
                                                {{ $locker->member_no }} - {{ $locker->member_name }}
                                            </a>
                                        </td>

                                        {{-- Account No --}}
                                        <td class="px-6 py-3 ">
                                            <a href="#" class="text-primary">
                                                {{ $locker->account_no }}
                                            </a>
                                        </td>

                                        {{-- Assigned Date --}}
                                        <td class="px-6 py-3 ">
                                            {{ $locker->assign_on ? \Carbon\Carbon::parse($locker->assign_on)->format('d-m-Y') : '—' }}
                                        </td>

                                        {{-- Release Date --}}
                                        <td class="px-6 py-3 ">
                                            {{ $locker->release_on ? \Carbon\Carbon::parse($locker->release_on)->format('d-m-Y') : '—' }}
                                        </td>

                                        {{-- Assigned --}}
                                        <td class="px-6 py-3 ">
                                            @if ($locker->is_assigned == 'Yes')
                                                <span class="block w-20 rounded-[30px] bg-primary/20 text-primary py-2 text-center">
                                                    Yes
                                                </span>
                                            @else
                                                <span class="block w-20 rounded-[30px] bg-error/20 text-error py-2 text-center">
                                                    No
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Actions --}}
                                        <td class="px-6 py-5 text-sm">
                                            <div class="relative">
                                                <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>

                                                <ul class="horiz-option popover-content">
                                                    <li>
                                                        <a href="{{ route('locker.member-locker.view', ['locker_id' => $locker->id, 'index' => $key]) }}" class="single-option uppercase">
                                                            View
                                                        </a>
                                                    </li>

                                                    @if ($locker->is_assigned == 'Yes')
                                                        <li>
                                                            <a href="{{ route('lockers.locker-list.release-locker', $locker->id) }}" class="single-option uppercase">
                                                                Release
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div> 
            </div>
        </div>
  </div>

    
@endsection