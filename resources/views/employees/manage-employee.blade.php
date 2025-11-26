@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <h4 class="h2">EMPLOYEES </h4>
        <a class="btn-primary uppercase" href="{{route('employee.create')}}">
            Add
        </a>
    </div>

    <!-- Latest Transactions -->
    <div class="box col-span-12 lg:col-span-6">
        <x-searchbox />
        <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
            <x-alert />
        </div>
        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                EMPLOYEE CODE
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px]" data-sortable="false">NAME</th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                DESIGNATION
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                EMAIL
                            </div>
                        </th>
                        <th class="text-start !py-5 cursor-pointer">
                            <div class="flex items-center gap-1">
                                JOINING DATE
                            </div>
                        </th>
                        <th class="text-start !py-5 cursor-pointer">
                            <div class="flex items-center gap-1">
                                LEAVING DATE
                            </div>
                        </th>
                        <th class="text-center !py-5" data-sortable="false">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $s=0;
                    @endphp
                    @forelse($employees as $employee)
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="py-5 px-6">
                            <a href="{{route('employee.show', base64_encode($employee->id))}}" class="text-primary underline hover:text-primary/80">
                              EMP- {{ $employee->id ?? '' }}
                            </a>
                        </td>
                        <td class="py-5 px-6">
                            <div>
                                <p class="font-medium mb-1"> {{ $employee->name??'' }}</p>
                            </div>
                        </td>
                        <td class="py-5 px-6">{{ $employee->designation??'' }}</td>
                        <td class="py-5 px-6">{{ $employee->email??'' }}</td>
                        <td class="py-5 px-6">
                            {{ \Carbon\Carbon::parse($employee->joining_date)->format('d-m-Y')??'' }}
                        </td>
                        <td class="py-5 px-6">
                        </td>
                        <td class="py-2 px-6">
                            <div class="flex justify-center">
                                @include('partials._vertical-options', [
                                'id' => base64_encode($employee->id),
                                'viewRoute' => 'employee.show',
                                'editRoute' => 'employee.edit'
                                ])

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-gray-500">No record found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <x-pagination :paginator="$employees" />
</div>
@endsection