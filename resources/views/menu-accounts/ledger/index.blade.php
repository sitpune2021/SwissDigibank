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
               LEDGER ACCOUNTS 
            </h3>
            <div class="flex flex-col md:flex-row  lg:flex-row gap-3">
                <a href="{{ route('ledger.add-ledger') }}" class="rounded-10 block flex btn-primary justify-center text-sm uppercase ">
                add LEDGER
                </a>
                <a href="" class=" block flex btn-warning  justify-center uppercase text-sm rounded-10" >
                  <i class="las la-upload"></i>
                    update bulk risk %
                </a>
            </div>
        </div>

        @if(session('success'))

            {{-- //alert msg --}}
            <div class="w-44 mb-5 flex justify-end">
                <x-alert />
            </div>        

        @endif      

        <div>
            <form>
                <div class="flex justify-center box gap-3">
                    <div class="">
                       <select name="branch_id" class="w-64 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                            <option value="">ALL BRANCH</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}"
                                    {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->branch_name }}
                                </option>
                            @endforeach
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

                                    <th class="text-start px-5 py-3 ">Code</th>
                                    <th class="text-start px-5 py-3 ">Name</th>
                                    <th class="text-start px-5 py-3 ">System Name</th>
                                    <th class="text-start px-5 py-3 ">Group</th>
                                    <th class="text-start px-5 py-3 ">Type</th>
                                    <th class="text-start px-5 py-3 text-ceter">System A/C</th>
                                    <th class="text-start px-5 py-3  ">Balance</th>
                                    <th class="text-start px-5 py-3  ">Actions</th>

                                </tr>
                            </thead>

                            {{-- BODY --}}
                            <tbody class="divide-y divide-gray-200 bg-white">

                                @forelse($ledgers as $ledger)
                                    <tr class="hover:bg-gray-50 border-b transition">

                                        <td class="px-5 py-3 text-sm">
                                            {{ $ledger->code }}
                                        </td>

                                        <td class="px-6 py-3 ">
                                            <a class="text-primary uppercase text-sm" href="{{ route('ledger.view', $ledger->id) }}">
                                                {{ $ledger->display_name }}
                                            </a>
                                        </td>

                                        <td class="px-5 py-3">
                                            <span class=" text-sm uppercase">
                                                 {{ $ledger->system_name }}
                                            </span>
                                           
                                        </td>

                                        <td class="px-5 py-3 text-sm">
                                            {{ $ledger->group->display_name ?? '-' }}
                                        </td>

                                        {{-- Type Badge --}}
                                        <td class="px-5 py-3">
                                            <span class=" py-1 text-sm ">
                                                {{ $ledger->type }}
                                            </span>
                                        </td>

                                        {{-- Yes/No Badge --}}
                                        <td class="px-3 py-3">
                                            @if($ledger->is_bank_acc)
                                                <span class="block w-28 rounded-[30px] border  border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                Yes
                                            </span>
                                        @else
                                            <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                No
                                            </span>
                                            @endif
                                        </td>

                                        {{-- Balance --}}
                                        <td class="px-5 py-3">
                                        
                                        <span class="text-sm px-2">
                                             ₹ {{ number_format($ledger->balance ?? 0, 2) }}
                                        </span>

                                        </td>

                                        {{-- Action Button --}}
                                        <td class="px-5 py-3 text-center">
                                            
                                    <div class="flex justify-center">
                                    <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                        <ul class="horiz-option popover-content">
                                            <li>
                                                <a href="{{ route('ledger.edit', $ledger->id) }}"
                                                    class="single-option uppercase">
                                                    Edit
                                                </a>
                                            </li>

                                            <li>
                                                <form action="{{ route('ledger.delete', $ledger->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this ledger?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="single-option text-red-500 uppercase">
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
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-6 text-gray-400">
                                            No records found
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>

                    </div>
                </div>

                <!-- Tab 2 -->
                <div id="tab2" class="tab-pane hidden">
                        {{-- Table --}}
                        <div class="w-full overflow-x-auto rounded-10 shadow bg-white dark:bg-bg3">

                        <table class="w-full whitespace-nowrap text-sm text-left">

                            {{-- HEADER --}}
                            <thead class="bg-gray-100 dark:bg-bg2 sticky top-0 z-10">
                                <tr class="text-sm bg-secondary/5 uppercase tracking-wider text-gray-600 dark:text-gray-300">

                                    <th class="text-start px-5 py-3 ">Code</th>
                                    <th class="text-start px-5 py-3 ">Name</th>
                                    <th class="text-start px-5 py-3 ">System Name</th>
                                    <th class="text-start px-5 py-3 ">Group</th>
                                    <th class="text-start px-5 py-3 ">Type</th>
                                    <th class="text-start px-5 py-3 text-ceter">System A/C</th>
                                    <th class="text-start px-5 py-3  ">Balance</th>
                                    <th class="text-start px-5 py-3  ">Actions</th>

                                    </tr>
                                </thead>

                                {{-- Body --}}
                                <tbody class="divide-y">

                                @foreach($ledgers->where('type','Asset') as $ledger)
                                    <tr class="hover:bg-gray-50 transition">

                                        <td class="px-4 py-3 text-sm">
                                            {{ $ledger->code }}
                                        </td>

                                        <td class="px-5 py-3 ">
                                            <a class="text-primary uppercase text-sm" href="{{ route('ledger.view', $ledger->id) }}">
                                                {{ $ledger->display_name }}
                                            </a>
                                        </td>

                                        <td class="px-5 py-3 uppercase text-sm">
                                            {{ $ledger->system_name }}
                                        </td>

                                        <td class="px-6 py-3 text-sm">
                                            {{ $ledger->group->display_name ?? '-' }}
                                        </td>

                                        {{-- Type Badge --}}
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 text-sm">
                                                {{ $ledger->type }}
                                            </span>
                                        </td>

                                        {{-- Bank Yes/No Badge --}}
                                        <td class="px-3 py-3">
                                            @if($ledger->is_bank_acc)
                                                 <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                Yes
                                            </span>
                                        @else
                                            <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                No
                                            </span>
                                        @endif
                                        </td>

                                        {{-- Balance --}}
                                        <td class="px-4 py-3">
                                            <span class="text-sm px-2">
                                                  ₹ {{ number_format($ledger->balance ?? 0, 2) }}
                                            </span>
                                          
                                        </td>

                                        {{-- Action --}}
                                        <td class="px-4 py-3 text-center">

                                            
                                    <div class="flex justify-center">
                                    <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                       
                                        <ul class="horiz-option popover-content">
                                            <li>
                                                <a href="{{ route('ledger.edit', $ledger->id) }}"
                                                    class="single-option uppercase">
                                                    Edit
                                                </a>
                                            </li>

                                            <li>
                                                <form action="{{ route('ledger.delete', $ledger->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this ledger?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="single-option text-red-500 uppercase">
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

                                        </td>

                                    </tr>
                                @endforeach

                                </tbody>

                            </table>

                        </div>
                </div>

                <!-- Tab 3 -->
                <div id="tab3" class="tab-pane hidden">
                    <div class="">

                        {{-- Table --}}
                        <div class="w-full overflow-x-auto rounded-10 shadow bg-white dark:bg-bg3">

                            <table class="w-full whitespace-nowrap text-sm text-left">

                            {{-- HEADER --}}
                            <thead class="bg-gray-100 dark:bg-bg2 sticky top-0 z-10">
                                <tr class="text-sm bg-secondary/5 uppercase tracking-wider text-gray-600 dark:text-gray-300">

                                        <th class="text-start px-4 py-3">Code</th>
                                        <th class="text-start px-4 py-3">Name</th>
                                        <th class="text-start px-4 py-3">System Name</th>
                                        <th class="text-start px-4 py-3">Group</th>
                                        <th class="text-start px-4 py-3">Type</th>
                                        <th class=" px-6 py-3 text-start">Bank A/C</th>
                                        <th class="text-start px-4 py-3">Balance</th>
                                        <th class="text-start px-4 py-3 ">Action</th>
                                    </tr>
                                </thead>

                                {{-- Body --}}
                                <tbody class="divide-y">

                                @foreach($ledgers->where('type','Liability') as $ledger)
                                    <tr class="hover:bg-gray-50 border-b transition">

                                        <td class="px-4 py-3 text-sm">
                                            {{ $ledger->code }}
                                        </td>

                                        <td class="px-5 py-3 ">
                                            <a class="text-primary text-sm uppercase" href="{{ route('ledger.view', $ledger->id) }}">
                                                {{ $ledger->display_name }}
                                            </a>
                                        </td>

                                        <td class="px-4 py-3 text-sm uppercase">
                                            {{ $ledger->system_name }}
                                        </td>

                                        <td class="px-4 py-3 text-sm">
                                            {{ $ledger->group->display_name ?? '-' }}
                                        </td>

                                        {{-- Type Badge --}}
                                        <td class="px-4 py-3 ">
                                            <span class="text-sm">
                                                {{ $ledger->type }}
                                            </span>
                                        </td>

                                        {{-- Bank Yes/No Badge --}}
                                        <td class="px-2 py-3">
                                            @if($ledger->is_bank_acc)
                                                <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                Yes
                                            </span>
                                        @else
                                            <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                No
                                            </span>
                                                @endif
                                        </td>

                                        {{-- Balance --}}
                                        <td class="px-6 py-3 text-sm ">
                                            ₹ {{ number_format($ledger->balance ?? 0, 2) }}
                                        </td>

                                        {{-- Action --}}
                                        <td class="px-4 py-3 text-center">                                        
                                    
                                    <div class="flex justify-center">
                                    <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                        
                                        <ul class="horiz-option popover-content">
                                            <li>
                                                <a href="{{ route('ledger.edit', $ledger->id) }}"
                                                    class="single-option uppercase">
                                                    Edit
                                                </a>
                                            </li>

                                            <li>
                                                <form action="{{ route('ledger.delete', $ledger->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this ledger?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="single-option text-red-500 uppercase">
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

                                        </td>

                                    </tr>
                                @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>
                </div>

                <!-- Tab 4 -->
                <div id="tab4" class="tab-pane hidden">
                    {{-- Table --}}
                                        
                 <div class="w-full overflow-x-auto rounded-10 shadow bg-white dark:bg-bg3">

                        <table class="w-full whitespace-nowrap text-sm text-left">

                            {{-- HEADER --}}
                            <thead class="bg-gray-100 dark:bg-bg2 sticky top-0 z-10">
                                <tr class="text-sm bg-secondary/5 uppercase tracking-wider text-gray-600 dark:text-gray-300">

                                    <th class="text-start px-4 py-3">Code</th>
                                    <th class="text-start px-4 py-3">Name</th>
                                    <th class="text-start px-4 py-3">System Name</th>
                                    <th class="text-start px-4 py-3">Group</th>
                                    <th class="text-start px-4 py-3">Type</th>
                                    <th class="text-start px-4 py-3">Bank A/C</th>
                                    <th class="text-start px-4 py-3">Balance</th>
                                    <th class="text-start px-4 py-3 ">Action</th>
                                </tr>
                            </thead>

                            {{-- Body --}}
                            <tbody class="divide-y">

                            @foreach($ledgers->where('type','Equity') as $ledger)
                                <tr class="hover:bg-gray-50 border-b transition">

                                    <td class="px-4 py-3 text-sm">
                                        {{ $ledger->code }}
                                    </td>

                                    <td class="px-5 py-3">
                                        <a class="text-primary uppercase text-sm" href="{{ route('ledger.view', $ledger->id) }}">
                                            {{ $ledger->display_name }}
                                        </a>
                                    </td>

                                    <td class="px-5 py-3 uppercase text-sm">
                                        {{ $ledger->system_name }}
                                    </td>

                                    <td class="px-5 py-3 text-sm">
                                        {{ $ledger->group->display_name ?? '-' }}
                                    </td>

                                    {{-- Type Badge --}}
                                    <td class="px-4 py-3">
                                        <span class=" text-sm ">
                                            {{ $ledger->type }}
                                        </span>
                                    </td>

                                    {{-- Bank Yes/No Badge --}}
                                    <td class="px-1 py-3">
                                        @if($ledger->is_bank_acc)
                                          <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                Yes
                                            </span>
                                        @else
                                            <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                No
                                            </span>
                                         @endif
                                    </td>

                                    {{-- Balance --}}
                                    <td class="px-5 py-3 text-sm">
                                        ₹ {{ number_format($ledger->balance ?? 0, 2) }}
                                    </td>

                                    {{-- Action --}}
                                    <td class="px-4 py-3 text-center">

                                        
                                    <div class="flex justify-center">
                                    <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                       
                                        <ul class="horiz-option popover-content">
                                            <li>
                                                <a href="{{ route('ledger.edit', $ledger->id) }}"
                                                    class="single-option uppercase">
                                                    Edit
                                                </a>
                                            </li>

                                            <li>
                                                <form action="{{ route('ledger.delete', $ledger->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this ledger?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="single-option text-red-500 uppercase">
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

                                    <th class="text-start px-4 py-3">Code</th>
                                    <th class="text-start px-4 py-3">Name</th>
                                    <th class="text-start px-4 py-3">System Name</th>
                                    <th class="text-start px-4 py-3">Group</th>
                                    <th class="text-start px-4 py-3">Type</th>
                                    <th class="text-start px-4 py-3">Bank A/C</th>
                                    <th class="text-start px-4 py-3">Balance</th>
                                    <th class="text-start px-4 py-3 ">Action</th>
                                </tr>
                            </thead>

                            {{-- Body --}}
                            <tbody class="divide-y">

                            @foreach($ledgers->where('type','Expense') as $ledger)
                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-4 py-3 text-sm">
                                        {{ $ledger->code }}
                                    </td>

                                    <td class="px-5 py-3 ">
                                        <a class="text-primary text-sm uppercase" href="{{ route('ledger.view', $ledger->id) }}">
                                            {{ $ledger->display_name }}
                                        </a>
                                    </td>

                                    <td class="px-4 py-3 text-sm uppercase">
                                        {{ $ledger->system_name }}
                                    </td>

                                    <td class="px-4 py-3 text-sm">
                                        {{ $ledger->group->display_name ?? '-' }}
                                    </td>

                                    {{-- Type Badge --}}
                                    <td class="px-4 py-3">
                                        <span class=" px-2 text-sm ">
                                            {{ $ledger->type }}
                                        </span>
                                    </td>

                                    {{-- Bank Yes/No Badge --}}
                                    <td class="px-1 py-3">
                                        @if($ledger->is_bank_acc)
                                           <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                Yes
                                            </span>
                                        @else
                                            <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                No
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Balance --}}
                                    <td class="px-5 py-3 text-sm ">
                                        ₹ {{ number_format($ledger->balance ?? 0, 2) }}
                                    </td>

                                    {{-- Action --}}
                                    <td class="px-4 py-3 text-center">

                                          <div class="flex justify-center">
                                    <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                        
                                        <ul class="horiz-option popover-content">
                                            <li>
                                                <a href="{{ route('ledger.edit', $ledger->id) }}"
                                                    class="single-option uppercase">
                                                    Edit
                                                </a>
                                            </li>

                                            <li>
                                                <form action="{{ route('ledger.delete', $ledger->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this ledger?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="single-option text-red-500 uppercase">
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

                                    </td>

                                </tr>
                            @endforeach

                            </tbody>

                        </table>

                    </div>
                </div>

                <!-- Tab 6 -->
                <div id="tab6" class="tab-pane hidden">
                     {{-- Table --}}
                   <div class="w-full overflow-x-auto rounded-10 shadow bg-white dark:bg-bg3">

                        <table class="w-full whitespace-nowrap text-sm text-left">

                            {{-- HEADER --}}
                            <thead class="bg-gray-100 dark:bg-bg2 sticky top-0 z-10">
                                <tr class="text-sm bg-secondary/5 uppercase tracking-wider text-gray-600 dark:text-gray-300">

                                    <th class="text-start px-4 py-3">Code</th>
                                    <th class="text-start px-4 py-3">Name</th>
                                    <th class="text-start px-4 py-3">System Name</th>
                                    <th class="text-start px-4 py-3">Group</th>
                                    <th class="text-start px-4 py-3">Type</th>
                                    <th class="text-start px-4 py-3">Bank A/C</th>
                                    <th class="text-start px-4 py-3">Balance</th>
                                    <th class="text-start px-4 py-3 ">Action</th>
                                </tr>
                            </thead>

                            {{-- Body --}}
                            <tbody class="divide-y">

                            @foreach($ledgers->where('type','Revenue') as $ledger)
                                <tr class="hover:bg-gray-50 border-b transition">

                                    <td class="px-4 py-3 text-sm">
                                        {{ $ledger->code }}
                                    </td>

                                   <td class="px-5 py-3 ">
                                        <a class="text-primary uppercase text-sm" href="{{ route('ledger.view', $ledger->id) }}">
                                            {{ $ledger->display_name }}
                                        </a>
                                    </td>

                                    <td class="px-5 py-3  text-sm uppercase">
                                        {{ $ledger->system_name }}
                                    </td>

                                    <td class="px-5 py-3  text-sm uppercase">
                                        {{ $ledger->group->display_name ?? '-' }}
                                    </td>

                                    {{-- Type Badge --}}
                                    <td class="px-4 py-3">
                                        <span class="text-sm ">
                                            {{ $ledger->type }}
                                        </span>
                                    </td>

                                    {{-- Bank Yes/No Badge --}}
                                    <td class="px-1 py-3">
                                        @if($ledger->is_bank_acc)
                                           <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                Yes
                                            </span>
                                        @else
                                            <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                No
                                            </span>
                                         @endif
                                    </td>

                                    {{-- Balance --}}
                                    <td class="px-5 py-3  text-sm">
                                        ₹ {{ number_format($ledger->balance ?? 0, 2) }}
                                    </td>

                                    {{-- Action --}}
                                    <td class="px-4 py-3 text-center">

                                         <div class="flex justify-center">
                                    <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                        
                                        <ul class="horiz-option popover-content">
                                            <li>
                                                <a href="{{ route('ledger.edit', $ledger->id) }}"
                                                    class="single-option uppercase">
                                                    Edit
                                                </a>
                                            </li>

                                            <li>
                                                <form action="{{ route('ledger.delete', $ledger->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this ledger?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="single-option text-red-500 uppercase">
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

                // Set the first tab active by default
                if (tabs.length > 0 && tabPanes.length > 0) {
                    tabs.forEach(t => t.classList.remove('active', 'text-primary', 'border-primary'));
                    tabPanes.forEach(p => p.classList.add('hidden'));

                    tabs[0].classList.add('active', 'text-primary', 'border-primary');
                    tabPanes[0].classList.remove('hidden');
                }

                // Tab switching logic
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