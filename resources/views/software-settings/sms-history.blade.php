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
            SMS History
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
                <label for="" class="block font-medium mb-2">Mobile No <span class="text-red-500">*</span></label>
                <input type="text" id="" name="" placeholder="Mobile No"
                    class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
            </div>
            <div class="mb-4">
                <label for="" class="block font-medium mb-2">Status <span class="text-red-500">*</span></label>
                <select id="branch_id" name="branch_id"
                    class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                    <option value="">Select Status Type</option>
                    <option value="">Yes</option>
                    <option value="">No</option>
                </select>

            </div>
            <div class="mb-4 flex gap-5 justify-center">
                <button class="btn-primary uppercase ">
                    <i class="las la-search"></i>
                    Search
                </button>
                <button class="btn-warning uppercase ">Clear Form</button>

            </div>
        </div>
    </div>
    <div class="col-span-12 box mt-5 lg:col-span-12">
        <div class="pb-4 overflow-x-auto lg:pb-6">

            <table class="w-full mt-5  select-all-table" id="">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer ">
                            <div class="flex items-center gap-1 uppercase">
                                MESSAGE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                MOB NO
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                SMS TYPE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                TIME
                            </div>
                        </th>

                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                SUCCESS
                            </div>
                        </th>

                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            Dear Customer, your Account S05768 has been credited with INR 15,000.00 on 7-Jan-26. The
                            Available Balance is INR 31,510.00. SBC GLOBAL
                            (static)
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            9021107260   (static)
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            sms   (static)
                        </td>
                        <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            12-12-2025   (static)
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