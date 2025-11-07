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
                Assign Locker
            </h3>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

            <div class=" col-span-2 box md:col-span-1 ">
                <form action="">
                    <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                        <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                            Member
                            <span class="text-red-500">*</span>
                        </label>

                        <select name="" id="schemeSelect"
                            class=" scheme-select w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                            <option value="" class="opt-default">Select Member</option>

                        </select>
                    </div>
                    <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                        <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                            Enrollment Date
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text" name="" id="date" placeholder="DD/MM/YYYY"
                            class=" scheme-select w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                    </div>
                    <div class="flex justify-center gap-3">
                        <button class="btn-primary uppercase">
                            Assign
                        </button>
                        <a href="" class="btn-outline uppercase">
                            back
                        </a>
                    </div>
                </form>
            </div>
            <div class=" col-span-2 box md:col-span-1 ">
                <div class="bg-secondary/5 rounded-10  px-5 py-3">
                    <h3 class="text-lg font-semibold uppercase tracking-wide">
                        Locker Info

                    </h3>
                </div>
                <div class="bg-white dark:bg-gray-900">
                    <div class="overflow-x-auto whitespace-nowrap">
                        <table class="w-full  text-sm md:text-base">
                        <tbody class="divide-y divide-gray-200">
                            <tr class="bg-gray-50 border-b ">
                                <td class="font-semibold uppercase p-3 w-1/2">Locker No</td>
                                <td class="p-3">2222</td>
                            </tr>
                            <tr class="bg-gray-50 uppercase border-b ">
                                <td class="font-semibold p-3">Locker Name</td>
                                <td class="p-3">Suvarna shree </td>
                            </tr>
                            <tr class="bg-gray-50 uppercase border-b ">
                                <td class="font-semibold p-3">Locker Charge(Monthly)	</td>
                                <td class="p-3">222.0
                             </td>
                            </tr>
                            <tr class="bg-gray-50 border-b ">
                                <td class="font-semibold uppercase p-3">Assigned	</td>
                                <td class="p-3">
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
        </div>

@endsection