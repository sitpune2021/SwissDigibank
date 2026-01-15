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
</style>

@section('content')
<div class="main-inner">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
        <h3 class=" flex text-lg  uppercase font-semibold">
            Set Members / Accounts Sequence No Series
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
        <div class=" bg-warning text-white  py-4 px-3 rounded-10 mb-3">
            <p class="text-lg font-semibold capitalize">You can set sequence for members and accounts for the very first time. After
                that the sequence will be auto incremental.</p>
        </div>

        <div class="flex gap-3 w-full">
            <div class="text-end" style="width: 50%;">
                <p class="text-lg font-semibold">TEST</p>
                <p class="mt-3">Prefix</p>
                <p class="mt-3">The prefix helps you personalize your <br> account no for your company. For example at
                    hubco we use ‘TEST’.</p>
            </div>
            <div class="" style="width: 50%;">
                <p class="text-lg font-semibold">00001</p>
                <p class="mt-3">No.</p>
                <p class="mt-3">
                    This is the starting no. of the member. You can set a custom one or start from zero.
                </p>
            </div>
        </div>
        <div class="pb-4 mt-5 overflow-x-auto lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="">
                <thead>
                    <tr class="border-b dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer ">
                            <div class="flex items-center gap-1 uppercase">
                                ACCOUNT TYPE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                PREFIX
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                START NO
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                START NO DIGITS
                            </div>
                        </th>

                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">

                            </div>
                        </th>

                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>Member No.</p>
                            <p>ex. TEST00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. TEST</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. 1</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. 5 digit no (00001)</p>
                        </td>
                        <td class="py-2 px-6">
                          
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>Saving Ac No.</p>
                            <p>ex. SAV050001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. SAV</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. 50001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. 6 digit no (050001)</p>
                        </td>
                        <td class="py-2 px-6">

                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>FD No.</p>
                            <p>ex. FD00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. FD</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. 1</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>
                                ex. 5 digit no (00001)
                            </p>
                        </td>
                        <td class="py-2 px-6">

                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>MIS No.</p>
                            <p>ex. MIS00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. MIS</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. 1</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. 5 digit no (MIS00001)</p>
                        </td>
                        <td class="py-2 px-6">

                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>RD No.</p>
                            <p>ex. RD00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. RD</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. 1</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. 5 digit no (RD00001)</p>
                        </td>
                        <td class="py-2 px-6">

                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>DD No.</p>
                            <p>ex. DD00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. DDS</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. 1</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. 5 digit no (DDA00001)</p>
                        </td>
                        <td class="py-2 px-6">

                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>Gold Loan App No.</p>
                            <p>ex. GDLAPP00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">

                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>Gold Loan Ac No.</p>
                            <p>ex. GDL00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">

                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>Property Loan App No.</p>
                            <p>ex. PLAPP00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">

                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>Property Loan Ac No.</p>
                            <p>ex. PR00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">

                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>Deposit Loan App No.</p>
                            <p>ex. DLAPP00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">

                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>Deposit Loan Ac No.</p>
                            <p>ex. DL00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">

                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>Other Loan App No.</p>
                            <p>ex. OLAPP00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">

                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>Other Loan Ac No.</p>
                            <p>ex. OL00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">

                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>Personal Loan App No.</p>
                            <p>ex. PERLPP00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id="" placeholder="Prefix"
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""  placeholder="Start No"
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id="" placeholder="No of Digits"
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">

                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>Personal Loan Ac No.</p>
                            <p>ex. OL00001</p>
                        </td>
                         <td class="py-2 px-6">
                            <input type="text" name="" id="" placeholder="Prefix"
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""  placeholder="Start No"
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id="" placeholder="No of Digits"
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">

                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>Daily / Weekly Loan App No.</p>
                            <p>ex. FLAPP00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">

                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>Daily / Weekly Loan Ac No.</p>
                            <p>ex. FL00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">

                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>Vehicle Loan App No.</p>
                            <p>ex. VLAPP00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id="" placeholder="Prefix"
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id="" placeholder="Start No"
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id="" placeholder="No of Digits"
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <button class="btn-primary rounded-10 uppercase py-2">
                                save
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>Vehicle Loan Ac No.</p>
                            <p>ex. PR00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id="" placeholder="Prefix"
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id="" placeholder="Start No"
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id="" placeholder="No of Digits"
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <button class="btn-primary rounded-10 uppercase py-2">
                                save
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>CC Limit App No.</p>
                            <p>ex. CCLAPP00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id="" placeholder="Prefix"
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id="" placeholder="Start No"
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id="" placeholder="No of Digits"
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <button class="btn-primary rounded-10 uppercase py-2">
                                save
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>CC Limit Ac No.</p>
                            <p>ex. CCL00001</p>
                        </td>
                      <td class="py-2 px-6">
                            <input type="text" name="" id="" placeholder="Prefix"
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id="" placeholder="Start No"
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id="" placeholder="No of Digits"
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">

                        </td>
                        <td class="py-2 px-6">
                            <button class="btn-primary rounded-10 uppercase py-2">
                                save
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>Associate Code</p>
                            <p>ex. AGT00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. AGT</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. 50001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. 6 digit no (050001)</p>
                        </td>
                        <td class="py-2 px-6">

                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-6">
                            <p>Employee Code</p>
                            <p>ex. EMP00001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. EMP</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32  border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. 50001</p>
                        </td>
                        <td class="py-2 px-6">
                            <input type="text" name="" id=""
                                class="w-32 border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <p>ex. 6 digit no (050001)</p>
                        </td>
                        <td class="py-2 px-6">

                        </td>
                    </tr>
                </tbody>


            </table>

        </div>


    </div>
</div>


@endsection