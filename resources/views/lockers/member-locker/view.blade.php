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
               Member Locker - kuldeeeeeeep
            </h3>
        </div>
        <div class="">
            <a href="" class="btn-primary rounded-10 py-2 uppercase">
                RELEASE
            </a>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

            <div class=" col-span-2 box md:col-span-1 ">
                <div class="mb-3 flex justify-end">
                </div>
                <table class="w-full  divide-y divide-gray-200 rounded-lg ">
                    <tbody class="divide-y divide-gray-100">
                        <tr class="border-b">
                            <td class="font-semibold uppercase text-lg text-gray-700 px-4 py-2 w-1/3">Locker No</td>
                            <td class="px-4 py-2 text-gray-600">2222</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold uppercase text-lg text-gray-700 px-4 py-2">Locker Name</td>
                            <td class="px-4 py-2 text-gray-600">Aaaa</td>
                        </tr>
                         <tr class="border-b">
                            <td class="font-semibold uppercase text-lg text-gray-700 px-4 py-2">Member Name	</td>
                            <td class="px-4 py-2 text-gray-600">ABC XYZ</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold uppercase text-lg text-gray-700 px-4 py-2">Locker Charge</td>
                            <td class="px-4 py-2 text-gray-600">222.0</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold uppercase text-lg text-gray-700 px-4 py-2">Assigned Date</td>
                            <td class="px-4 py-2 text-gray-600">10-10-2024</td>
                        </tr>
                         <tr class="border-b">
                            <td class="font-semibold uppercase text-lg text-gray-700 px-4 py-2">Release Date</td>
                            <td class="px-4 py-2 text-gray-600">10-10-2024</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold uppercase text-lg text-gray-700 px-4 py-2">Locker Assigned	</td>
                            <td class="px-4 py-2">
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
            <div class=" col-span-2  md:col-span-1 "></div>
        </div>

@endsection