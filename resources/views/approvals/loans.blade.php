@extends('layout.main')
@section('content')
    <style>
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

    <div class="main-inner">

        <div class="col-span-12 box lg:col-span-12">
            <div class="  flex justify-end mb-5">
                <a href="{{ route('approvals_history') }}" class=" btn-primary uppercase rounded-10 ">
                    approvals history
                </a>
            </div>
            <div class="pb-4 overflow-x-auto lg:pb-6">
                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    BRANCH
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    MEMBER
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    A/C TYPE
                                </div>
                            </th>


                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    APPLICATION NO.
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    AMT. REQUESTED
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    CALCULATED APPROVAL
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    APPROVED AMT.
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    STATUS
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    REMARKS
                                </div>
                            </th>


                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    ACTIONS
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                        <tr class="border-b dark:border-bg3">
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1  uppercase">
                                    {{ $application->branch->branch_name ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 Capitalize">
                                    <span class="text-primary">
                                        {{ $application->member->member_info_first_name ?? 'N/A' }}
                                    </span>
                                </div>
                            </td>

                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center  gap-1">
                                    -
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center  gap-1">
                                <a href="{{ route('gold-loan.applications.view', $application->id) }}" 
                                class="text-blue-600 hover:underline">
                                    {{ $application->id }}
                                </a>
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                   {{ $application->max_loan_amount }}
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1  uppercase">
                                    {{ $application->maximum_approvable_amount }}
                                </div>
                            </td>

                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    <input type="number" name="" id="" value="{{ $application->approved_loan_amount }}" class="border py-2 bg-secondary/5 rounded-10 px-3">
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('loans.update-status', $application->id) }}" method="POST">
                                    @csrf
                                    <select name="status" class="border rounded px-2 py-1">
                                        <option value="">Select</option>
                                        <option value="1" {{ $application->status == 1 ? 'selected' : '' }}>Approve</option>
                                        <option value="0" {{ $application->status == 0 ? 'selected' : '' }}>Not Approve</option>
                                    </select>
                                
                            </td>
                              <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                  <textarea name="" id="" class="border py-1 bg-secondary/5 rounded-10 px-3" placeholder="Enter Remarks"></textarea>
                                </div>
                            </td>

                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                               <button type="submit" style="color:black"
                                    class="bg-green-600 text-white px-3 py-1 rounded ml-2 hover:bg-green-700">
                                    DONE
                                </button>
                            </form>
                            </td>
                        </tr>
                         @endforeach
                    </tbody>
                </table>
            </div>
        </div>




@endsection