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
</style>
@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <!-- <h2 class="h2">Manage share-holdings</h2> -->
        <h1 class="text-xl font-semibold">Share holdings</h1>
        <a class="btn-primary" href="{{ route('shareholding.transfer.form') }}">
            Add
        </a>
    </div>


    <!-- Latest Transactions -->

    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>
    <div class="overflow-x-auto pb-4 lg:pb-6">
        <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
            <thead>
                <tr class="bg-secondary/5 dark:bg-bg3">
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">Branch</div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">Transferor</div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">Transferee</div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">Share<br>Range</div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">Total<br>Shares<br>Held</div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">Nominal<br>Val.</div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">Total<br>Share<br>Val.</div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">Allotment<br>Date</div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">Transfer<br>Date</div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">Cert. No</div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">Surrendered</div>
                    </th>
                    <th class="text-center !py-5" data-sortable="false">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shareholdings as $shareholding)
                <tr>
                    <td class="px-6 py-5">{{ $shareholding->members->branch->branch_name ?? '-' }}</td>
                    <td class="px-6 py-5">{{ $shareholding->shareholdings->promotor->first_name ?? '-' }}</td>
                    <td class="px-6 py-5">{{ $shareholding->members->member_info_first_name ?? '-' }}</td>
                    <td class="px-6 py-5">{{ $shareholding->from_share_no.'-'. $shareholding->to_share_no ?? '-' }}</td>
                    <td class="px-6 py-5">{{ $shareholding->shares ?? '-' }}</td>
                    <td class="px-6 py-5">{{ $shareholding->face_value ?? '-' }}</td>
                    <td class="px-6 py-5">{{ $shareholding->total_consideration ?? '-' }}</td>
                    <td class="px-6 py-5">{{ \Carbon\Carbon::parse($shareholding->allotment_date)->format('D M d Y') ?? '-' }}</td>
                    <td class="px-6 py-5">{{ \Carbon\Carbon::parse($shareholding->transfer_date)->format('D M d Y') ?? '-' }}</td>
                    <td class="px-6 py-5">{{ $shareholding->certificate_number ?? '-' }}</td>
                    <td class="px-6 py-5">{{ $shareholding->is_surrendered ? 'Yes' : 'No' }}</td>
                    <td class="px-6 py-5 text-center">
                        <div class="flex justify-center">
                            @include('partials._vertical-options', [
                            'id' => $shareholding->id,
                            'viewRoute' => 'shares-transfer.show',
                            'printRoute' => 'shares-transfer.print',
                            ])

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <x-pagination :paginator="$shareholdings" />
</div>

@endsection