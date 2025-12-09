@extends('layout.main')
@section('content')
<div class="main-inner">
    <h3 class="text-lg mb-5 font-semibold">LOAN AGAINST DEPOSITE REPORT</h3>

   <div class="box">
     <div class="flex justify-end">
            <a href="{{ route('loanagainst.lineproperty.export') }}" class="btn-primary tet-sm rounded-10 uppercase">
                        <i class="las la-download"></i>
                        Download XLS
             </a>
        </div>
     <div class="mt-5 overflow-x-auto">
       
        <table class="w-full border-collapse whitespace-nowrap  text-sm">
            <thead class="bg-secondary/5 ">
                <tr class="text-center">
                    <th class=" p-2 ">LOAN APPLICATION NO</th>
                    <th class=" p-2 ">LOAN APPLICATION STATUS</th>
                    <th class=" p-2 ">LIEN ACCOUNT TYPE</th>
                    <th class=" p-2 ">LOAN ACCOUNT STATUS</th>
                    <th class=" p-2 ">LIEN ACCOUNT STATUS</th>
                    <th class=" p-2 ">LIEN ACCOUNT NUMBER</th>
                    <th class=" p-2 ">LIEN ACCOUNT ASSIGNED</th>
                </tr>
            </thead>
            <tbody>
    @forelse($applications as $application)
        <tr class="text-center border-b">
            <td class="p-2"><a href="{{ route('loanagainst.applications.view', $application->id) }}" 
                class="text-green-600 hover:underline">
                    {{ $application->id }}
                </a></td>
            <td class="p-2">
                @if($application->status == 2)
                    Disbursed
                @elseif($application->status == 3)
                    Disapproved
                @else
                    -
                @endif
            </td>
            <td class="p-2">-</td>
            <td class="p-2">-</td>
            <td class="p-2">-</td>
            <td class="p-2">₹ </td>
            <td class="p-2">
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
        <!-- Pagination Links -->
            <div class="mt-4">
                <x-pagination :paginator="$applications" />
            </div>
    </div>
   </div>

</div>
@endsection