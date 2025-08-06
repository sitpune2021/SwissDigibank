@extends('layout.main')
@section('content')
<div class="main-inner">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
        <h2 class="h2">Approvals - Share Transfers</h2>
    </div>

    <!-- Latest Transactions -->
    <div class="col-span-12 box lg:col-span-6">
        <x-searchbox />

        <div class="pb-4 overflow-x-auto lg:pb-6">
            <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
                <x-alert />
            </div>
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead class="custom-thead">
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Branch
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Member
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Date of Transfer
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Business Type
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                No of Shares
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Status
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Remarks
                            </div>
                        </th>
                        <th class="text-center justify-center !py-5" data-sortable="false">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($share_transfers as $share_transfer)
                    <form action="{{ route('share_transfer.approve', $share_transfer->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="share_transfer_id" value="{{ $share_transfer->id }}">
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <td class="py-5 px-6">{{ $share_transfer->shareholdings?->promotors?->branch?->branch_name ??'' }}</td>
                            <td class="py-5 px-6">{{ $share_transfer->members?->member_info_first_name ?? ''}}</td>
                            <td class="py-5 px-6">{{ $share_transfer?->transfer_date ?? ''}}</td>
                            <td class="py-5 px-6">{{ $share_transfer?->business_type ??'' }}</td>
                            <td class="py-5 px-6">{{ $share_transfer?->shares ?? '' }}</td>
                            <td class="py-5 px-6">
                                <select name="status" id="status">
                                    <option value="">Select Status</option>
                                    <option value="approved">Approve</option>
                                    <option value="not approve">Not Approve</option>
                                </select>
                            </td>
                            <td class="py-5 px-6">
                                <textarea name="remarks" id="remarks-1" placeholder="Enter Remarks"></textarea>
                            </td>
                            <td class="py-2 px-6">
                                <input
                                    type="submit"
                                    name="commit"
                                    value="Done"
                                    onclick="return confirm('Are you sure')"
                                    class="text-white font-semibold py-2 px-4 rounded shadow-sm transition duration-200 cursor-pointer"
                                    style="background-color:green;">
                            </td>
                    </form>
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
    <x-pagination :paginator="$share_transfers" />
</div>
@endsection