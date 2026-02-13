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
            <h3 class=" flex text-lg block  uppercase  font-bold">
                LEDGER GROUPS
            </h3>
            <a href="{{ route('ledger-group.create') }}" class=" block flex btn-primary uppercase text-lg">
                add 
                <!-- group -->
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

                    <div class="w-full overflow-x-auto rounded-10 shadow bg-white dark:bg-bg3">

                        <table class="w-full whitespace-nowrap text-sm text-left">

                            {{-- HEADER --}}
                            <thead class="bg-gray-100 dark:bg-bg2 sticky top-0 z-10">
                                <tr class="text-sm bg-secondary/5 uppercase tracking-wider text-gray-600 dark:text-gray-300">

                                    <th class=" text-start px-6 py-4">Name</th>
                                    <th class="text-start px-6 py-4">System Name</th>
                                    <th class="text-start px-6 py-4">Type</th>
                                    <th class="text-start px-6 py-4 text-center">System Group</th>
                                    <th class="text-start px-6 py-4 text-right">Accounts</th>
                                    <th class="text-start px-5 py-4 ">Balance</th>
                                    <th class="text-start px-6 py-4 text-center">Actions</th>

                                </tr>
                            </thead>

                            {{-- BODY --}}
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                                @foreach($all as $row)
                                <tr class="hover:bg-gray-50 border-b dark:hover:bg-bg2 transition ">

                                    {{-- NAME --}}
                                    <td class="px-6 py-4 text-sm ">
                                        <a href="{{ route('ledger-group.ledgers', $row->id) }}" class="text-primary text-sm">
                                            {{ $row->display_name }}
                                        </a>
                                    </td>

                                    {{-- SYSTEM NAME --}}
                                    <td class="px-6 py-4 text-sm ">
                                        {{ $row->system_name }}
                                    </td>

                                    {{-- TYPE --}}
                                    <td class="px-6 py-4 text-sm">
                                        <span class=" py-1 rounded-full  ">
                                            {{ $row->type }}
                                        </span>
                                    </td>

                                    {{-- SYSTEM GROUP --}}
                                    <td class="px-6 py-4 text-sm text-center">
                                        @if($row->is_system_group)
                                            <span  class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                Yes
                                            </span>
                                        @else
                                            <span  class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                No
                                            </span>
                                        @endif
                                    </td>

                                    {{-- ACCOUNTS --}}
                                    <td class="px-6 py-4 text-sm">
                                        <span class="px-2">
                                            {{ $row->accounts }}
                                        </span>
                                    </td>

                                    {{-- BALANCE --}}
                                    <td class="px-6 py-4 text-sm  text-primary">
                                        <span class="px-1">
                                            ₹ {{ number_format($row->balance, 2) }}
                                        </span>
                                    </td>

                                    {{-- ACTION --}}
                                    <td class="px-6 py-4 text-center flex gap-2 justify-center">

                                    <div class="flex justify-center">
                                    <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                        <ul class="horiz-option popover-content">
                                            <li>
                                              <a href=""
                                        class="single-option uppercase ">
                                           Edit
                                        </a>
                                            </li>
                                             <li>
                                                
                                        {{-- Delete --}}
                                        <form action="{{ route('ledger-group.destroy',$row->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure to delete this group and all ledgers?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="single-option uppercase" >
                                             Delete
                                            </button>

                                        </form>
                                            </li>

                                        </ul>
                                        {{-- @include('partials._vertical-options', [
                                        /* 'id' =>base64_encode($director->id),
                                        'viewRoute' => 'director.show',
                                        'editRoute' => 'director.edit'*/
                                        ]) --}}
                                    </div>
                                </div>
                                        <!-- {{-- Edit --}}
                                        <a href=""
                                        class="btn-primary p-2">
                                            <i class="las la-edit"> </i>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('ledger-group.destroy',$row->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure to delete this group and all ledgers?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="btn-error p-2" >
                                              <i class="las la-trash"></i>
                                            </button>

                                        </form> -->

                                    </td>

                                </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

                <!-- Tab 2 -->
                <div id="tab2" class="tab-pane hidden">

                    <div class="w-full overflow-x-auto rounded-10 shadow bg-white dark:bg-bg3">

                        <table class="w-full whitespace-nowrap text-sm text-left">

                            {{-- HEADER --}}
                            <thead class="bg-gray-100 dark:bg-bg2 sticky top-0 z-10">
                                <tr class="text-sm bg-secondary/5 uppercase tracking-wider text-gray-600 dark:text-gray-300">

                                    <th class="text-start px-6 py-4">Name</th>
                                    <th class="text-start px-6 py-4">System Name</th>
                                    <th class="text-start px-6 py-4">Type</th>
                                    <th class="text-start px-6 py-4 ">System Group</th>
                                    <th class="text-start px-6 py-4 ">Accounts</th>
                                    <th class="text-start px-6 py-4 ">Balance</th>
                                    <th class="text-start px-6 py-4 ">Actions</th>

                                </tr>
                            </thead>

                            {{-- BODY --}}
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                                @foreach($assets as $row)
                                <tr class="hover:bg-gray-50 border-b dark:hover:bg-bg2 transition">

                                    {{-- NAME --}}
                                    <td class="px-6 py-4 ">
                                        <a href="{{ route('ledger-group.ledgers', $row->id) }}" class="text-sm   text-primary">
                                            {{ $row->display_name }}
                                        </a>
                                    </td>

                                    {{-- SYSTEM NAME --}}
                                    <td class="px-6 py-4 text-sm  ">
                                        {{ $row->system_name }}
                                    </td>

                                    {{-- TYPE --}}
                                    <td class="px-6 py-4 text-sm ">
                                        <span class=" ">
                                            {{ $row->type }}
                                        </span>
                                    </td>

                                    {{-- SYSTEM GROUP --}}
                                    <td class="px-6 py-4 text-sm  text-center">
                                        @if($row->is_system_group)
                                            <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                Yes
                                            </span>
                                        @else
                                            <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                No
                                            </span>
                                        @endif
                                    </td>

                                    {{-- ACCOUNTS --}}
                                    <td class="px-6 py-4 text-sm  text-right ">
                                      <span class="px-2">
                                          {{ $row->accounts }}
                                      </span>
                                    </td>

                                    {{-- BALANCE --}}
                                    <td class="px-6 py-4 text-sm  text-right text-primary">
                                        ₹ {{ number_format($row->balance, 2) }}
                                    </td>


                                    {{-- ACTION --}}
                                    <td class="px-6 py-4 text-sm  text-center flex gap-2 justify-center">

                                     <div class="flex justify-center">
                                    <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                        <ul class="horiz-option popover-content">
                                            <li>
                                              <a href=""
                                        class="single-option uppercase ">
                                           Edit
                                        </a>
                                            </li>
                                             <li>
                                                
                                        {{-- Delete --}}
                                       <form action="{{ route('ledger-group.destroy',$row->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure to delete this group and all ledgers?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="single-option uppercase" >
                                             Delete
                                            </button>

                                        </form>
                                            </li>

                                        </ul>
                                        {{-- @include('partials._vertical-options', [
                                        /* 'id' =>base64_encode($director->id),
                                        'viewRoute' => 'director.show',
                                        'editRoute' => 'director.edit'*/
                                        ]) --}}
                                    </div>
                                </div>
                                        <!-- {{-- Edit --}}
                                        <a href=""
                                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm btn-primary">
                                            Edit
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('ledger-group.destroy',$row->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure to delete this group and all ledgers?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm btn-warning">
                                                Delete
                                            </button>

                                        </form> -->

                                    </td>

                                </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

                <!-- Tab 3 -->
                <div id="tab3" class="tab-pane hidden">

                    <div class="w-full overflow-x-auto rounded-10 shadow bg-white dark:bg-bg3">

                        <table class="w-full whitespace-nowrap text-sm text-left">

                            {{-- HEADER --}}
                            <thead class="bg-gray-100 dark:bg-bg2 sticky top-0 z-10">
                                <tr class="text-sm bg-secondary/5 uppercase tracking-wider text-gray-600 dark:text-gray-300">

                                    <th class="text-start px-6 py-4">Name</th>
                                    <th class="text-start px-6 py-4">System Name</th>
                                    <th class="text-start px-6 py-4">Type</th>
                                    <th class="text-start px-6 py-4 ">System Group</th>
                                    <th class="text-start px-6 py-4 ">Accounts</th>
                                    <th class="text-start px-6 py-4 ">Balance</th>
                                    <th class="text-start px-6 py-4 ">Actions</th>

                                </tr>
                            </thead>

                            {{-- BODY --}}
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                                @foreach($liabilities as $row)
                                <tr class="hover:bg-gray-50 border-b dark:hover:bg-bg2 transition">

                                    {{-- NAME --}}
                                    <td class="px-6 py-4 ">
                                        <a href="{{ route('ledger-group.ledgers', $row->id) }}" class="text-sm   text-primary">
                                            {{ $row->display_name }} 
                                        </a>
                                    </td>

                                    {{-- SYSTEM NAME --}}
                                    <td class="px-6 py-4 text-sm">
                                        {{ $row->system_name }}
                                    </td>

                                    {{-- TYPE --}}
                                   <td class="px-6 py-4 text-sm ">
                                        <span class="text-sm ">
                                            {{ $row->type }}
                                        </span>
                                    </td>

                                    {{-- SYSTEM GROUP --}}
                                    <td class="px-6 py-4 text-sm  text-center">
                                        @if($row->is_system_group)
                                            <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                Yes
                                            </span>
                                        @else
                                            <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                No
                                            </span>
                                        @endif
                                    </td>

                                    {{-- ACCOUNTS --}}
                                    <td class="px-6 py-4 ">
                                      <span class="px-2">
                                          {{ $row->accounts }}
                                      </span>
                                    </td>

                                    {{-- BALANCE --}}
                                    <td class="px-6 py-4 text-primary">
                                      <span class="px-2">
                                          ₹ {{ number_format($row->balance, 2) }}
                                      </span>
                                    </td>

                                     {{-- ACTION --}}
                                    <td class="px-6 py-4 text-center flex gap-2 justify-center">
                                     <div class="flex justify-center">
                                    <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                        <ul class="horiz-option popover-content">
                                            <li>
                                              <a href=""
                                        class="single-option uppercase ">
                                           Edit
                                        </a>
                                            </li>
                                             <li>
                                                
                                        {{-- Delete --}}
                                        <form action="{{ route('ledger-group.destroy',$row->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure to delete this group and all ledgers?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="single-option uppercase" >
                                             Delete
                                            </button>

                                        </form>
                                            </li>

                                        </ul>
                                        {{-- @include('partials._vertical-options', [
                                        /* 'id' =>base64_encode($director->id),
                                        'viewRoute' => 'director.show',
                                        'editRoute' => 'director.edit'*/
                                        ]) --}}
                                    </div>
                                </div>
                                        {{-- Edit --}}
                                        <!-- <a href=""
                                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm btn-primary">
                                            Edit
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('ledger-group.destroy',$row->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure to delete this group and all ledgers?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm btn-warning">
                                                Delete
                                            </button>

                                        </form> -->

                                    </td>

                                </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

                <!-- Tab 4 -->
                <div id="tab4" class="tab-pane hidden">

                       <div class="w-full overflow-x-auto rounded-10 shadow bg-white dark:bg-bg3">

                        <table class="w-full whitespace-nowrap text-sm text-left">

                            {{-- HEADER --}}
                            <thead class="bg-gray-100 dark:bg-bg2 sticky top-0 z-10">
                                <tr class="text-sm bg-secondary/5 uppercase tracking-wider text-gray-600 dark:text-gray-300">

                                    <th class="text-start px-6 py-4">Name</th>
                                    <th class="text-start px-6 py-4">System Name</th>
                                    <th class="text-start px-6 py-4">Type</th>
                                    <th class="text-start px-6 py-4">System Group</th>
                                    <th class="text-start px-6 py-4 ">Accounts</th>
                                    <th class="text-start px-6 py-4 ">Balance</th>
                                    <th class="text-start px-6 py-4 ">Actions</th>

                                </tr>
                            </thead>

                            {{-- BODY --}}
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                                @foreach($equity as $row)
                                <tr class="hover:bg-gray-50 border-b dark:hover:bg-bg2 transition">

                                    {{-- NAME --}}
                                    <td class="px-6 py-4 ">
                                        <a href="{{ route('ledger-group.ledgers', $row->id) }}" class="text-sm   text-primary">
                                            {{ $row->display_name }}
                                        </a>
                                    </td>

                                    {{-- SYSTEM NAME --}}
                                    <td class="px-6 py-4 ">
                                      <span class="px-2 text-sm">
                                          {{ $row->system_name }}
                                      </span>
                                    </td>

                                    {{-- TYPE --}}
                                    <td class="px-6 py-4">
                                        <span class="px-1 text-sm ">
                                            {{ $row->type }}
                                        </span>
                                    </td>

                                    {{-- SYSTEM GROUP --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($row->is_system_group)
                                             <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                Yes
                                            </span>
                                        @else
                                            <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                No
                                            </span>
                                        @endif
                                    </td>

                                    {{-- ACCOUNTS --}}
                                    <td class="px-6 py-4 ">
                                        <span class="px-2 text-sm">
                                        {{ $row->accounts }}
                                        </span>
                                    </td>

                                    {{-- BALANCE --}}
                                    <td class="px-6 py-4  text-green-600">
                                        <span class="px-2 text-sm">
                                            ₹ {{ number_format($row->balance, 2) }}
                                        </span>
                                    </td>

                                     {{-- ACTION --}}
                                    <td class="px-6 py-4 text-center flex gap-2 justify-center">

                                    <div class="flex justify-center">
                                    <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                        <ul class="horiz-option popover-content">
                                            <li>
                                              <a href=""
                                        class="single-option uppercase ">
                                           Edit
                                        </a>
                                            </li>
                                             <li>
                                                
                                        {{-- Delete --}}
                                        <form action="{{ route('ledger-group.destroy',$row->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure to delete this group and all ledgers?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="single-option uppercase" >
                                             Delete
                                            </button>

                                        </form>
                                            </li>

                                        </ul>
                                        {{-- @include('partials._vertical-options', [
                                        /* 'id' =>base64_encode($director->id),
                                        'viewRoute' => 'director.show',
                                        'editRoute' => 'director.edit'*/
                                        ]) --}}
                                    </div>
                                </div>
                                        {{-- Edit --}}
                                        <!-- <a href=""
                                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm btn-primary">
                                            Edit
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('ledger-group.destroy',$row->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure to delete this group and all ledgers?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm btn-warning">
                                                Delete
                                            </button> 
                                        </form>
                                        -->


                                    </td>

                                </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

                <!-- Tab 5 -->
                <div id="tab5" class="tab-pane hidden">

                 <div class="w-full overflow-x-auto rounded-10 shadow bg-white dark:bg-bg3">

                        <table class="w-full whitespace-nowrap text-sm text-left">

                            {{-- HEADER --}}
                            <thead class="bg-gray-100 dark:bg-bg2 sticky top-0 z-10">
                                <tr class="text-sm bg-secondary/5 uppercase tracking-wider text-gray-600 dark:text-gray-300">

                                   <th class="text-start px-6 py-4">Name</th>
                                    <th class="text-start px-6 py-4">System Name</th>
                                    <th class="text-start px-6 py-4">Type</th>
                                    <th class="text-start px-6 py-4">System Group</th>
                                    <th class="text-start px-6 py-4 ">Accounts</th>
                                    <th class="text-start px-6 py-4 ">Balance</th>
                                    <th class="text-start px-6 py-4 ">Actions</th>

                                </tr>
                            </thead>

                            {{-- BODY --}}
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                                @foreach($expenses as $row)
                                 <tr class="hover:bg-gray-50 border-b dark:hover:bg-bg2 transition">

                                    {{-- NAME --}}
                                    <td class="px-6 py-4 ">
                                        <a href="{{ route('ledger-group.ledgers', $row->id) }}" class="text-sm   text-primary">
                                            {{ $row->display_name }}
                                        </a>
                                    </td>

                                    {{-- SYSTEM NAME --}}
                                     <td class="px-6 py-4 ">
                                      <span class="px-2 text-sm">
                                        {{ $row->system_name }}
                                      </span>
                                    </td>

                                    {{-- TYPE --}}
                                    <td class="px-6 py-4">
                                        <span class="px-1 text-sm ">
                                            {{ $row->type }}
                                        </span>
                                    </td>

                                    {{-- SYSTEM GROUP --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($row->is_system_group)
                                            <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                Yes
                                            </span>
                                        @else
                                            <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                No
                                            </span>
                                        @endif
                                    </td>

                                    {{-- ACCOUNTS --}}
                                    <td class="px-6 py-4 ">
                                        <span class="px-2 text-sm">
                                             {{ $row->accounts }}
                                        </span>     
                                    </td>

                                    {{-- BALANCE --}}
                                    <td class="px-6 py-4  text-primary">
                                        <span class="px-2 text-sm">
                                            ₹ {{ number_format($row->balance, 2) }}
                                        </span>   
                                    </td>

                                     {{-- ACTION --}}
                                    <td class="px-6 py-4 text-center flex gap-2 justify-center">

                                    <div class="flex justify-center">
                                    <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                        <ul class="horiz-option popover-content">
                                            <li>
                                              <a href=""
                                        class="single-option uppercase ">
                                           Edit
                                        </a>
                                            </li>
                                             <li>
                                                  {{-- Delete --}}
                                        <form action="{{ route('ledger-group.destroy',$row->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure to delete this group and all ledgers?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="single-option uppercase" >
                                             Delete
                                            </button>

                                        </form>
                                            </li>

                                        </ul>
                                        {{-- @include('partials._vertical-options', [
                                        /* 'id' =>base64_encode($director->id),
                                        'viewRoute' => 'director.show',
                                        'editRoute' => 'director.edit'*/
                                        ]) --}}
                                    </div>
                                </div>

                                        {{-- Edit --}}
                                        <!-- <a href=""
                                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm btn-primary">
                                            Edit
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('ledger-group.destroy',$row->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure to delete this group and all ledgers?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm btn-warning">
                                                Delete
                                            </button>

                                        </form> -->

                                    </td>

                                </tr>
                                @endforeach

                            </tbody>

                        </table>
                        
                    </div>

                </div>

                <!-- Tab 6 -->
                <div id="tab6" class="tab-pane hidden">

                    
                 <div class="w-full overflow-x-auto rounded-10 shadow bg-white dark:bg-bg3">

                        <table class="w-full whitespace-nowrap text-sm text-left">

                            {{-- HEADER --}}
                            <thead class="bg-gray-100 dark:bg-bg2 sticky top-0 z-10">
                                <tr class="text-sm bg-secondary/5 uppercase tracking-wider text-gray-600 dark:text-gray-300">

                                   <th class="text-start px-6 py-4">Name</th>
                                    <th class="text-start px-6 py-4">System Name</th>
                                    <th class="text-start px-6 py-4">Type</th>
                                    <th class="text-start px-6 py-4">System Group</th>
                                    <th class="text-start px-6 py-4 ">Accounts</th>
                                    <th class="text-start px-6 py-4 ">Balance</th>
                                    <th class="text-start px-6 py-4 ">Actions</th>
                                </tr>
                            </thead>

                            {{-- BODY --}}
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                                @foreach($revenue as $row)
                              <tr class="hover:bg-gray-50 border-b dark:hover:bg-bg2 transition">

                                    {{-- NAME --}}
                                    <td class="px-6 py-4 ">
                                        <a href="{{ route('ledger-group.ledgers', $row->id) }}" class="text-sm   text-primary">
                                            {{ $row->display_name }}
                                        </a>
                                    </td>

                                    {{-- SYSTEM NAME --}}
                                 <td class="px-6 py-4 ">
                                      <span class="px-2 text-sm">
                                        {{ $row->system_name }}
                                      </span> 
                                    </td>

                                    {{-- TYPE --}}
                                     <td class="px-6 py-4">
                                        <span class="px-1 text-sm ">
                                            {{ $row->type }}
                                        </span>
                                    </td>

                                    {{-- SYSTEM GROUP --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($row->is_system_group)
                                             <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                Yes
                                            </span>
                                        @else
                                            <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                No
                                            </span>
                                        @endif
                                    </td>

                                   {{-- ACCOUNTS --}}
                                     <td class="px-6 py-4 ">
                                        <span class="px-2 text-sm">
                                             {{ $row->accounts }}
                                        </span>     
                                    </td>

                                    {{-- BALANCE --}}
                                    <td class="px-6 py-4  text-primary">
                                        <span class="px-2 text-sm">
                                              ₹ {{ number_format($row->balance, 2) }}
                                        </span>
                                    </td>

                                    {{-- ACTION --}}
                                    <td class="px-6 py-4 text-center flex gap-2 justify-center">
                                    
                                    <div class="flex justify-center">
                                    <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                        <ul class="horiz-option popover-content">
                                            <li>
                                              <a href=""
                                        class="single-option uppercase ">
                                           Edit
                                        </a>
                                            </li>
                                             <li>
                                                  {{-- Delete --}}
                                             <form action="{{ route('ledger-group.destroy',$row->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure to delete this group and all ledgers?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="single-option uppercase" >
                                             Delete
                                            </button>

                                        </form>
                                            </li>

                                        </ul>
                                        {{-- @include('partials._vertical-options', [
                                        /* 'id' =>base64_encode($director->id),
                                        'viewRoute' => 'director.show',
                                        'editRoute' => 'director.edit'*/
                                        ]) --}}
                                    </div>
                                </div>
                                        <!-- {{-- Edit --}}
                                        <a href=""
                                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm btn-primary">
                                            Edit
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('ledger-group.destroy',$row->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure to delete this group and all ledgers?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm btn-warning">
                                                Delete
                                            </button>

                                        </form> -->

                                    </td>

                                </tr>
                                @endforeach

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