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
            <h3 class=" flex text-xl block  uppercase  font-bold">
              Lockers 
            </h3>
            <a href="" class=" block flex btn-primary uppercase ">
                add 
            </a>
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

                                <tr class="border-b dark:border-bg3">
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1 uppercase">
                                            2222	
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1 Capitalize">
                                          MY LOCKER - 0063	
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            1500.0	
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                    
                                    
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            <div class="relative">
                                                <i
                                                    class="las la-ellipsis-v horiz-option-btn  cursor-pointer popover-button"></i>
                                                <ul class="horiz-option popover-content">
                                                    <li><a href="" class="single-option uppercase">View</a></li>
                                                    <li><a href="" class="single-option uppercase">Edit</a></li>
                                                     <li><a href="" class="single-option uppercase">Assign</a></li>
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
            </div>
        </div>
  </div>

    
@endsection