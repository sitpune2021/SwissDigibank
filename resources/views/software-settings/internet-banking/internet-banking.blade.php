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
          Internet Banking Settings

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
 <div class="box">
    <div class="text-end">
        <a href="{{ route('software-settings.internet-banking.internet-edit') }}" class="btn-primary p-2">
            <i class="las la-pencil-alt"></i>
        </a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-5 border-b py-2 xxxl:gap-6">
        <p  class="col-span-2 md:col-span-1 text-lg  font-semibold">Default Internet Banking Active</p>
          <p  class="col-span-2 flex md:col-span-1">
           
                                    <span
                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                Yes
                            </span>
                             <span
                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                No
                            </span>
                               
          </p>
           
    </div>
    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-5 border-b py-1 xxxl:gap-6">
        <p  class="col-span-2 md:col-span-1 text-lg uppercase font-semibold">
        Permissions
        </p>
         
    </div>
    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-5  xxxl:gap-6">
        <div  class="col-span-2 md:col-span-1 flr  py-3 rounded-10 px-3 bg-secondary/5 text-lg uppercase font-semibold">
       <div class="flex items-center justify-between">
        <div class=""> Member Net Banking Settings</div>
        <div class="">
            <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
         </div>
       </div>
        </div>
           
    </div>
     <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                      Show Share Holding Details
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                     Show Saving Accounts
                    </label>
                </div>
            </div><div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                   Open New Saving Accounts
                    </label>
                </div>
            </div><div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                    Show RD/ DD Accounts

                    </label>
                </div>
            </div><div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                     Open New RD/ DD Accounts
                    </label>
                </div>
            </div><div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                    Close RD/ DD Accounts

                    </label>
                </div>
            </div><div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                    Show FD Accounts
                    </label>
                </div>
            </div><div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                      Open New FD/ MIS Accounts

                    </label>
                </div>
            </div><div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                     Close FD/ MIS Accounts
                    </label>
                </div>
            </div><div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                     Show Gold Loan Accounts

                    </label>
                </div>
            </div><div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                     Show Property Loan Accounts
                    </label>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                      Show Deposit Loan Accounts

                    </label>
                </div>
            </div><div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                      Show Other/ Business Loan Accounts
                    </label>
                </div>
            </div><div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                     Show Vehicle Loan Accounts

                    </label>
                </div>
            </div><div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                     Show Personal Loan Accounts
                    </label>
                </div>
            </div><div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                     Show Fixed Loan Accounts

                    </label>
                </div>
            </div><div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                   Show CC Limit Accounts
                    </label>
                </div>
            </div><div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                    Deposit Amount CC Limit Accounts from Saving Ac

                    </label>
                </div>
            </div><div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="" name="" value=""
                        class="item-checkbox form-checkbox h-5 w-5 text-primary">
                    <label for="" class="text-base font-semibold cursor-pointer mb-0">
                    Withdrawal Amount CC Limit Accounts to Saving Ac

                    </label>
                </div>
            </div>
         
            

        </div>
 </div>


@endsection