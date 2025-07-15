@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <h2 class="h2">Employees </h2>
        <a class="btn-primary" href="{{route('CreateEmployee')}}">
            <i class="las la-plus-circle text-base md:text-lg"></i>
            Add Employee
        </a>
    </div>

    <!-- Latest Transactions -->
    <div class="box col-span-12 lg:col-span-6">
        <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
            <h4 class="h4">Employees</h4>
            <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                <form
                    class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                    <input type="text" id="transaction-search" placeholder="Search"
                        class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                    <button
                        class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                        <i class="las la-search text-lg"></i>
                    </button>
                </form>
                <!-- <div class="flex items-center gap-3 whitespace-nowrap">
                        <span>Sort By : </span>
                        <select name="sort" class="nc-select green !rounded-3xl">
                            <option value="day">Last 15 Days</option>
                            <option value="week">Last 1 Month</option>
                            <option value="year">Last 6 Month</option>
                        </select>
                    </div> -->
            </div>
        </div>
        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Sr No
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Employee Code
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px]" data-sortable="false">Name</th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Designation
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Email
                            </div>
                        </th>
                        <th class="text-start !py-5 cursor-pointer">
                            <div class="flex items-center gap-1">
                                Joining Date
                            </div>
                        </th>
                        <th class="text-start !py-5 cursor-pointer">
                            <div class="flex items-center gap-1">
                                Leaving Date
                            </div>
                        </th>
                        <th class="text-center !py-5" data-sortable="false">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $s=0;
                    @endphp
                    @foreach($employees as $employee)
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="py-5 px-6">{{$s=$s+1}}</td>
                        <td class="py-5 px-6">
                            <a href="" class="text-blue-500 hover:underline">
                                N/A
                            </a>
                        </td>
                        <td class="py-5 px-6">
                            <div>
                                <p class="font-medium mb-1"> {{ $employee->members->member_info_first_name }}</p>
                            </div>
                        </td>
                        <td class="py-5 px-6">{{ $employee->designation }}</td>
                        <td class="py-5 px-6">{{ $employee->email }}</td>
                        <td class="py-5 px-6">{{ $employee->joining_date }}</td>
                        <td class="py-5 px-6">
                        </td>
                       

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection