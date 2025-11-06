@extends('layout.main')
@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3 lg:mb-5">
            <h4 class="h2">Form 15G/ 15H</h4>
        </div>
        <div class="box col-span-12 lg:col-span-6">
            <x-searchbox />
            <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
                <x-alert />
            </div>

            <div class="overflow-x-auto pb-4 lg:pb-6">
                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    CUSTOMER
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    FY
                                </div>
                            </th>
                            <th class="text-center !py-5 uppercase" data-sortable="false">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($form15g15hs as $index => $item)
                            <tr class="border-b dark:border-bg3">
                                <td class="py-3 px-6">
                                    @if ($item->member)
                                        <a href="{{ route('member.show', $item?->member?->id ?? '') }}"
                                            class="text-primary hover:underline">
                                            {{ $item->member?->member_no ?? ($item->member?->id ? str_pad($item->member->id, 6, '0', STR_PAD_LEFT) : '') }}-
                                            {{ $item->member?->member_info_first_name ?? '' }}
                                        </a>
                                    @else
                                        <a href="{{ route('promotor.show', base64_encode($item?->promotor?->id ?? '')) }}"
                                            class="text-primary hover:underline">
                                            {{ $item->promotor?->first_name ?? '' }}
                                        </a>
                                    @endif
                                </td>
                                <td class="py-3 px-6">
                                    {{ $item?->financial_year ?? '' }}
                                </td>
                                <td class="py-2 px-6">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options', [
                                            'id' => $item->id,
                                            'viewRoute' => 'form15g15h.show',
                                            'editRoute' => 'form15g15h.edit',
                                        ])
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <x-pagination :paginator="$form15g15hs" />
        </div>
    </div>
@endsection
