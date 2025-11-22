@extends('layout.main')
@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <!-- <h2 class="h2">Manage share-holdings</h2> -->
            <h3 class="text-xl font-semibold">SHARE HOLDINGS</h3>
            <a class="btn-primary" href="{{ route('shareholding.transfer.form') }}">
                ADD
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
                            <div class="flex items-center gap-1">BRANCH</div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">TRANSFEROR</div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">TRANSFEREE</div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">SHARE<br>RANGE</div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">TOTAL<br>SHARES<br>HELD</div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">NOMINAL<br>VAL.</div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">TOTAL<br>SHARE<br>VAL.</div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">ALLOTMENT<br>DATE</div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">TRANSFER<br>DATE</div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">CERT. NO</div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">SURRENDERED</div>
                        </th>
                        <th class="text-center !py-5" data-sortable="false">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shareholdings as $shareholding)
                        <tr>
                            <td class="px-6 py-5">{{ $shareholding->members->branch->branch_name ?? '-' }}</td>
                            <td class="px-6 py-5">{{ $shareholding->promotor->first_name ?? '-' }}</td>
                            <td class="px-6 py-5">
                                {{ optional($shareholding->members)->member_no ??
                                    (optional($shareholding->members)->id ? str_pad($shareholding->members->id, 6, '0', STR_PAD_LEFT) : '-') }}-
                                {{ optional($shareholding->members)->member_info_first_name ?? '-' }}
                            </td>

                            <td class="px-6 py-5">
                                {{ $shareholding->from_share_no . '-' . $shareholding->to_share_no ?? '-' }}
                            </td>
                            <td class="px-6 py-5">{{ $shareholding->shares ?? '-' }}</td>
                            <td class="px-6 py-5">{{ $shareholding->face_value ?? '-' }}</td>
                            <td class="px-6 py-5">{{ $shareholding->total_consideration ?? '-' }}</td>
                            <td class="px-6 py-5">
                                {{ \Carbon\Carbon::parse($shareholding->allotment_date)->format('d-m-Y') ?? '-' }}</td>
                            <td class="px-6 py-5">
                                {{ \Carbon\Carbon::parse($shareholding->transfer_date)->format('d-m-Y') ?? '-' }}</td>
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
