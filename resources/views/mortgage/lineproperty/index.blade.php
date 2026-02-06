@extends('layout.main')
@section('content')
<div class="main-inner">
    <h3 class="text-lg mb-3 font-semibold">LOAN ITEMS REPORT</h3>

    <div class="box overflow-x-auto">
        <div class="flex justify-end">
            <a href="{{ route('mortgage.lineproperty.export') }}" class="btn-primary rounded-10 text-sm  py-2 px-2  mb-3 uppercase">
                        <i class="las la-download"></i>
                        Download XLS
             </a>
        </div>
        <div class="">
            <table class="w-full border-collapse   text-sm">
            <thead class="bg-secondary/5 ">
                <tr class="text-center">
                    <th class=" p-2 text-start ">LOAN APPLICATION NO</th>
                    <th class=" p-2 text-start ">LOAN APPLICATION STATUS</th>
                    <th class=" p-2 text-start ">LOAN ACCOUNT NO	</th>
                    <th class=" p-2 text-start ">LOAN ACCOUNT STATUS</th>
                    <th class=" p-2 text-start ">PROPERTY TYPE</th>
                    <th class=" p-2 text-start ">EXPECTED VALUE</th>
                    <th class=" p-2 text-start ">REGISTERED</th>
                </tr>
            </thead>
            <tbody>
    @forelse($applications as $application)
        <tr class="text-center border-b">
            <td class="p-2 text-start"><a href="{{ route('mortgage.applications.view', $application->id) }}" 
                class="text-green-600 hover:underline">
                    {{-- {{ $application->id }} --}}
                    {{ str_pad($application->id, 10, '0', STR_PAD_LEFT) }}
                </a></td>
            <td class="p-2 text-start">
                @if($application->status == 0)
                    Draft
                @elseif($application->status == 1)
                    Approved
                @elseif($application->status == 2)
                    Disbursed
                @else
                    DisApprove
                @endif
            </td>
            <td class="p-2 text-start">{{ $application->id }}</td>
            <td class="p-2 text-start">
                @if($application->status == 2)
                    <span class="text-green-600 font-semibold">Active</span>
                @else
                    <span class="text-red-600 font-semibold">Inactive</span>
                @endif
            </td>
            <td class="p-2 text-start">
                {{ $application->properties->pluck('property_type')->implode(', ') ?: '-' }}
            </td>
            <td class="p-2 text-start">₹ </td>
            <td class="p-2 text-start">
                <span
                    class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                    Yes
                </span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center text-gray-500 py-4">No loan applications found.</td>
        </tr>
    @endforelse
</tbody>

        </table>
        </div>
        <!-- Pagination Links -->
            <div class="mt-4">
                <x-pagination :paginator="$applications" />
            </div>
    </div>

</div>
@endsection