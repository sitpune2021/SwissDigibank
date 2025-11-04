@extends('layout.main')

@section('content')
<div class="main-inner">
    <a href="{{route('accounts.other.charges',$charges->id ?? '')}}" class="btn-primary rounded-10 px-2 py-2 mb-4">
        DEBIT OTHER CHARGES
    </a>

    <!-- <a href=""
            class="btn-warning rounded-10 px-2 py-2 mb-4">
            CLEAR DUES
        </a> -->
    {{-- Table --}}
    <div class="col-span-12 box lg:col-span-6">
        <x-searchbox />

        <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
            <x-alert />
        </div>

        <div class="pb-4 overflow-x-auto lg:pb-6">
            <table class="w-full border border-n30 rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3 text-sm font-semibold">
                        <th class="px-6 py-3 text-center uppercase">Date</th>
                        <th class="px-6 py-3 text-center uppercase">Charge Type</th>
                        <th class="px-6 py-3 text-center uppercase">Amount</th>
                        <th class="px-6 py-3 text-center uppercase">Remarks</th>
                        <th class="px-6 py-3 text-center uppercase">Status</th>
                        <th class="px-6 py-3 text-center uppercase">Created at</th>
                        <th class="px-6 py-3 text-center uppercase">Updated at</th>
                        <th class="px-6 py-3 text-center uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($charges->savingOtherCharges as $charge)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3 text-center">
                            {{ $charge->charge_date ? \Carbon\Carbon::parse($charge->charge_date)->format('d-m-Y') : '' }}
                        </td>
                        <td class="px-6 py-3 text-center">{{ $charge->charge_type ?? '' }}</td>
                        <td class="px-6 py-3 text-center">{{ number_format($charge->amount ?? 0, 2) }}</td>
                        <td class="px-6 py-3 text-center">{{ $charge->remarks ?? '' }}</td>
                        <td class="px-6 py-3 text-center">
                            @if(($charge->status ?? 0) == 1)
                            <span class="text-green-600 font-semibold">Active</span>
                            @else
                            <span class="text-red-600 font-semibold">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-center">{{ $charge->created_at ? \Carbon\Carbon::parse($charge->created_at)->format('d-m-Y H:i') : '' }}</td>
                        <td class="px-6 py-3 text-center">{{ $charge->updated_at ? \Carbon\Carbon::parse($charge->updated_at)->format('d-m-Y H:i') : '' }}</td>
                    </tr>
                    @endforeach
                
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection