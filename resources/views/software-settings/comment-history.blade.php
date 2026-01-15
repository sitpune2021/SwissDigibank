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

    .backdrop {
        backdrop-filter: blur(1px);
        -webkit-backdrop-filter: blur(1px);
        background-color: rgba(0, 0, 0, 0.1);


    }

    .toggle-switch {
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        user-select: none;
    }

    .toggle-switch input {
        display: none;
    }

    /* Track */
    .slider {
        position: relative;
        width: 56px;
        height: 32px;
        background-color: #9ca3af;
        /* gray */
        border-radius: 999px;
        transition: background-color 0.3s ease;
    }

    /* Thumb */
    .slider::before {
        content: "";
        position: absolute;
        top: 4px;
        left: 4px;
        width: 24px;
        height: 24px;
        background-color: #fff;
        border-radius: 50%;
        transition: transform 0.3s ease;
    }

    /* Checked state */
    .toggle-switch input:checked+.slider {
        background-color: #228cc5;
        /* primary */
    }

    .toggle-switch input:checked+.slider::before {
        transform: translateX(24px);
    }

    /* Label text */
    .label-text {
        margin-left: 10px;
        font-size: 14px;
        color: #374151;
    }
</style>

@section('content')
<div class="main-inner">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
        <h3 class=" flex text-lg  uppercase font-semibold">
          Comment History
        </h3>

    </div>
    @if(session('success'))
    <div class="">
        <div class="w-44 mb-5 flex justify-end">
            <x-alert />
        </div>
        {{-- {{ session('success') }} --}}
    </div>
    @endif

     <div class="grid grid-cols-2 md:grid-cols-3 gap-6   md-4">
         <div class="col-span-2 md:col-span-1 box dark:bg-bg3 rounded-10 p-6">
            <div class="mb-4">
                {{-- <label for="" class="block font-medium mb-2">Mobile No <span class="text-red-500">*</span></label> --}}
                <input type="text" id="" name="" placeholder="DD/MM/YYYY"
                    class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
            </div>
           
             <div class="mb-4 flex gap-5 justify-center">
                <button class="btn-primary uppercase ">
                   <i class="las la-search"></i>
                    Search
                </button>
                {{-- <button class="btn-warning uppercase ">Clear Form</button> --}}

            </div>
            </div>
        </div>
    <div class="col-span-12 box mt-5 lg:col-span-12">
        <div class="text-end ">
            <a href="#" class="btn-error text-sm uppercase rounded-10 py-1 px-2">
                <i class="las la-download"></i>
                DOWNLOAD XLS
            </a>
        </div>
        <div class="pb-4 overflow-x-auto lg:pb-6">

            <table class="w-full mt-5 whitespace-nowrap select-all-table" id="">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer ">
                            <div class="flex items-center gap-1 uppercase">
                                DATE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                ACCOUNT TYPE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                ACCOUNT
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                               COMMENT BY
                            </div>
                        </th>

                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                               COMMENT
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                               ACTION
                            </div>
                        </th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">12-12-2025</td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">RdAccount</td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">DD00045</td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">NISHA SWAPNIL THAKARE</td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">DD ACCOUNT OPENING</td>
                       
                        
                        {{-- ACTIONS --}}
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex justify-center">
                                <div class="relative">
                                    <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                    <ul class="horiz-option popover-content">
                                        <li>
                                            <a href="
                                            {{-- {{ route('notice-boards.edit', base64_encode($notice->id)) }} --}}
                                             " class="single-option uppercase">Delete</a>
                                        </li>
                                    
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

<script>
    document.getElementById('smsToggle').addEventListener('change', function () {
    console.log(this.checked ? 'SMS Enabled' : 'SMS Disabled');
});
</script>

@endsection