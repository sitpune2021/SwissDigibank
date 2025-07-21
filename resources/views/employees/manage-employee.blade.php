@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <h2 class="h2">Employees </h2>
        <a class="btn-primary" href="{{route('CreateEmployee')}}">
            <i class="las la-plus-circle text-base md:text-lg"></i>
            Add
        </a>
    </div>

    <!-- Latest Transactions -->
    <div class="box col-span-12 lg:col-span-6">
        <x-searchbox :action="route('ManageEmployee')" />
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
                                <p class="font-medium mb-1"> {{ $employee->name }}</p>
                            </div>
                        </td>
                        <td class="py-5 px-6">{{ $employee->designation }}</td>
                        <td class="py-5 px-6">{{ $employee->email }}</td>
                        <td class="py-5 px-6">{{ $employee->joining_date }}</td>
                        <td class="py-5 px-6">
                        </td>
                        <td class="py-2 px-6">
                            <div class="flex justify-center">
                                @include('partials._vertical-options', [
                                'id' => base64_encode($employee->id),
                                'viewRoute' => 'employee.view',
                                'editRoute' => 'employee.edit'
                                ])

                            </div>
                        </td>
                        <!-- <td class="py-5 px-6">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('employee.view', $employee->id) }}" class="border-green-500 text-green-500 hover:bg-green-500 hover:text-white rounded-full transition duration-150"><i class="las la-eye"></i></a>
                                <a href="{{ route('employee.edit', $employee->id) }}" class="border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white rounded-full transition duration-150"><i class="las la-edit"></i></a>
                              
                            </div>
                        </td> -->

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection