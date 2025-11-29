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

    @if(session('success'))     
            <div class="flex justify-end">
                <div 
                        id="successMessage" 
                        class="flex    mt-4 bg-primary/20 border border-primary text-primary text-center px-4 py-3 rounded-lg shadow-md transition-opacity duration-500 ease-in-out"
                    style="width: 50%;" >
                        {{ session('success') }}
                </div>
            </div>

        <script>
            // Auto hide after 30 seconds (30000 ms)
            setTimeout(() => {
                const msg = document.getElementById('successMessage');
                if (msg) {
                    msg.style.opacity = '0';
                    setTimeout(() => msg.remove(), 500); // smooth fade-out
                }
            }, 30000);
        </script>
    @endif


    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-xl block  uppercase  font-bold">
              Lockers 
            </h3>
            <a href="{{ route('lockers.locker-list.add') }}" class=" block flex btn-primary uppercase ">
                add 
            </a>
        </div>

        <div class="col-span-12 box lg:col-span-12">
      
                <div class="tab-content p-4">
                
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
                                           LOCKER CHARGES (Monthly)	
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
                                @forelse($lockers as $row)
                                    <tr class="border-b dark:border-bg3">
                                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                            <div class="flex items-center gap-1 uppercase">
                                                {{ $row->locker_no }}
                                            </div>
                                        </td>
                                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                            <div class="flex items-center gap-1 Capitalize">
                                            {{ $row->locker_name }}
                                            </div>
                                        </td>
                                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                            <div class="flex items-center gap-1">
                                                {{ number_format($row->monthly_charges, 2) }}
                                            </div>
                                        </td>
                                        <td class="text-start !py-5 px-6">
                                            @if($row->assigned == 1)
                                                <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary">
                                                    Yes
                                                </span>
                                            @else
                                                <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error">
                                                    No
                                                </span>
                                            @endif
                                        </td>                                                                           
                                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                            <div class="flex items-center gap-1">
                                                <div class="relative">
                                                    <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>

                                                    <ul class="horiz-option popover-content">

                                                        {{-- Always show View --}}
                                                        <li><a href="{{ route('lockers.locker-list.view', $row->id) }}" class="single-option uppercase">View</a></li>

                                                        @if($row->assigned == 0)
                                                            {{-- Assigned = No → Show Edit + Assign --}}
                                                            <li>
                                                                <a href="{{ route('lockers.locker-list.edit', $row->id) }}" class="single-option uppercase">Edit</a>
                                                            </li>
                                                            <li><a href="{{ route('lockers.locker-list.assign-locker', $row->id) }}" class="single-option uppercase">Assign</a></li>
                                                        @else
                                                            {{-- Assigned = Yes → Show Release only --}}
                                                            <li><a href="{{ route('lockers.locker-list.release-locker', $row->id) }}" class="single-option uppercase">Release</a></li>
                                                        @endif

                                                    </ul>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-red-500">
                                            No lockers found!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                 
                </div>
        </div>

    </div>

    
@endsection