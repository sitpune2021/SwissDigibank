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
                LEDGER GROUPS
            </h3>
            <a href="" class=" block flex btn-primary uppercase ">
                add group

            </a>

        </div>
        <div>
            <form>
                <div class="flex justify-center box gap-3">
                    <div class="">
                        <select id="" name=""
                            class="w-64 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                            <option selected>ALL</option>

                        </select>
                    </div>

                    <div class="">
                        <button type="submit" class="btn-warning rounded-10  ">
                            GET
                        </button>
                    </div>
                </div>

            </form>
        </div>


        <div class="col-span-12 box lg:col-span-12">
            <div class="border-b border-gray-200 mb-4">
                <ul id="tabs" class="flex flex-wrap -mb-px text-sm font-medium text-center">
                    <li class="me-2">
                        <button data-tab="tab1" class="tab-link inline-block p-4 border-b-2 border-transparent text-lg">
                            ALL
                        </button>
                    </li>
                    <li class="me-2">
                        <button data-tab="tab2" class="tab-link inline-block p-4 border-b-2 border-transparent text-lg">
                            ASSETS
                        </button>
                    </li>
                    <li class="me-2">
                        <button data-tab="tab3" class="tab-link inline-block p-4 border-b-2 border-transparent text-lg">
                            LIABILITIES
                        </button>
                    </li>
                    <li class="me-2">
                        <button data-tab="tab4" class="tab-link inline-block p-4 border-b-2 border-transparent text-lg">
                            EQUITY
                        </button>
                    </li>
                    <li class="me-2">
                        <button data-tab="tab5" class="tab-link inline-block p-4 border-b-2 border-transparent text-lg">
                            EXPENSES
                        </button>
                    </li>
                    <li class="me-2">
                        <button data-tab="tab6" class="tab-link inline-block p-4 border-b-2 border-transparent text-lg">
                            REVENUE
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Tabs Content -->
            <div class="tab-content p-4">
                <!-- Tab 1 -->
                <div id="tab1" class="tab-pane block">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse whitespace-nowrap text-sm">
                            <thead>
                                <tr class="bg-secondary/5 dark:bg-bg3">
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            NAME
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            System NAME
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            type
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                        <div class="flex  text-lg  uppercase items-center gap-1">
                                            SYSTEM GROUP
                                        </div>
                                    </th>

                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            ACCOUNTS
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            BALANCE
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
                                            <a href="" class="text-primary">
                                                THEKA BILL
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1 Capitalize">
                                            THEKA BILL
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Expense
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
                                            1
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            0.00
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

                <!-- Tab 2 -->
                <div id="tab2" class="tab-pane hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse whitespace-nowrap text-sm">
                            <thead>
                                <tr class="bg-secondary/5 dark:bg-bg3">
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            NAME
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            System NAME
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            type
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                        <div class="flex  text-lg  uppercase items-center gap-1">
                                            SYSTEM GROUP
                                        </div>
                                    </th>

                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            ACCOUNTS
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            BALANCE
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
                                            <a href="" class="text-primary">
                                                CASH & CASH EQUIVALENT
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1 Capitalize">
                                            CASH AND CASH EQUIVALENT
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Asset
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
                                            1
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            0.00
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

                <!-- Tab 3 -->
                <div id="tab3" class="tab-pane hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse whitespace-nowrap text-sm">
                            <thead>
                                <tr class="bg-secondary/5 dark:bg-bg3">
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            NAME
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            System NAME
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            type
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                        <div class="flex  text-lg  uppercase items-center gap-1">
                                            SYSTEM GROUP
                                        </div>
                                    </th>

                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            ACCOUNTS
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            BALANCE
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
                                            <a href="" class="text-primary">
                                                CURRENT LIABILITY
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1 Capitalize">
                                            CURRENT LIABILITY
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Liability
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
                                            1
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            0.00
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

                <!-- Tab 4 -->
                <div id="tab4" class="tab-pane hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse whitespace-nowrap text-sm">
                            <thead>
                                <tr class="bg-secondary/5 dark:bg-bg3">
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            NAME
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            System NAME
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            type
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                        <div class="flex  text-lg  uppercase items-center gap-1">
                                            SYSTEM GROUP
                                        </div>
                                    </th>

                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            ACCOUNTS
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            BALANCE
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
                                            <a href="" class="text-primary">
                                                SHAREHOLDER'S FUND
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1 Capitalize">
                                            SHAREHOLDER FUND
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Equity
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
                                            1
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            0.00
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

                <!-- Tab 5 -->
                <div id="tab5" class="tab-pane hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse whitespace-nowrap text-sm">
                            <thead>
                                <tr class="bg-secondary/5 dark:bg-bg3">
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            NAME
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            System NAME
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            type
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                        <div class="flex  text-lg  uppercase items-center gap-1">
                                            SYSTEM GROUP
                                        </div>
                                    </th>

                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            ACCOUNTS
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            BALANCE
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
                                            <a href="" class="text-primary">
                                                FINANCE COST
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1 Capitalize">
                                            FINANCE COST
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Expense
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
                                            1
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            0.00
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

                <!-- Tab 6 -->
                <div id="tab6" class="tab-pane hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse whitespace-nowrap text-sm">
                            <thead>
                                <tr class="bg-secondary/5 dark:bg-bg3">
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            NAME
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            System NAME
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            type
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                        <div class="flex  text-lg  uppercase items-center gap-1">
                                            SYSTEM GROUP
                                        </div>
                                    </th>

                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            ACCOUNTS
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            BALANCE
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
                                            <a href="" class="text-primary">
                                                REVENUE FROM OPERATIONS
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1 Capitalize">
                                            REVENUE FROM OPERATIONS
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Revenue
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
                                            1
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            0.00
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


        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const tabs = document.querySelectorAll('.tab-link');
                const tabPanes = document.querySelectorAll('.tab-pane');

                // ✅ Set the first tab active by default
                if (tabs.length > 0 && tabPanes.length > 0) {
                    tabs.forEach(t => t.classList.remove('active', 'text-primary', 'border-primary'));
                    tabPanes.forEach(p => p.classList.add('hidden'));

                    tabs[0].classList.add('active', 'text-primary', 'border-primary');
                    tabPanes[0].classList.remove('hidden');
                }

                // ✅ Tab switching logic
                tabs.forEach(tab => {
                    tab.addEventListener('click', (e) => {
                        e.preventDefault();

                        // Remove active state from all tabs & hide all panes
                        tabs.forEach(t => t.classList.remove('active', 'text-primary', 'border-primary'));
                        tabPanes.forEach(p => p.classList.add('hidden'));

                        // Activate clicked tab and show its pane
                        tab.classList.add('active', 'text-primary', 'border-primary');
                        const targetPane = document.getElementById(tab.dataset.tab);
                        if (targetPane) targetPane.classList.remove('hidden');
                    });
                });
            });
        </script>



@endsection