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
            Software SMS List
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

    <div class="col-span-12 box lg:col-span-12">
        <div class="text-end ">
            <a href="#" class="btn-primary rounded-10 py-1 px-2">
                <i class="las la-download"></i>
                DOWNLOAD
            </a>
        </div>
        <div class="pb-4 overflow-x-auto lg:pb-6">

            <table class="w-full mt-5 whitespace-nowrap select-all-table" id="">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer ">
                            <div class="flex items-center gap-1 uppercase">
                                CODE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                NAME
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                MESSAGE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                TEMPLATE FOR APPROVAL
                            </div>
                        </th>

                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                WA TEMPLATE FOR APPROVAL
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                YOUR TEMPLATE ID
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                SMS ON / OFF
                            </div>
                        </th>

                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                ACTIONS
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">VL013(static)</td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">Vehicle Loan EMI PAID (static)</td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">Dear Customer, EMI of Rs. @amount_1 towards Loan a/c no @account_number_1 is PAID.
                            @sms_signature (static)
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            Dear Customer, EMI of Rs. {#var#} towards Loan a/c no {#var#} is PAID. HUBERP
                            (static)
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            Dear Customer, EMI of Rs. {#var#} towards Loan a/c no {#var#} is PAID. HUBERP
                             (static)
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">(static)</td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <label class="toggle-switch">
                                <input type="checkbox" id="smsToggle">
                                <span class="slider"></span>
                                {{-- <span class="label-text">SMS</span> --}}
                            </label>
                        </td>
                        {{-- ACTIONS --}}
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex justify-center">
                                <div class="relative">
                                    <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                    <ul class="horiz-option popover-content">
                                        <li>
                                            <a href=" {{ route('software-settings.edit-sms-setting') }}
                                             " class="single-option uppercase">edit</a>
                                        </li>
                                        <li>
                                            <a href=" {{ route('software-settings.view-sms-list') }} "
                                                class="single-option uppercase">view</a>
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