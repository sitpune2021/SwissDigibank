@extends('layout.main')
@section('page-title', 'DIRECTORS')

@section('action-button')
<a class="btn-primary" href="{{ route('director.create') }}" style="background: linear-gradient(90deg, #e1d315, #e30f0f) !important; color: black;">
    ADD DIRECTOR
</a>
@endsection

<style>

@keyframes fadeRow{
0%{
opacity:0;
transform:translateY(10px);
}
100%{
opacity:1;
transform:translateY(0);
}
}

.table-row{
animation:fadeRow .4s ease forwards;
}

/* hover animation */

.table-row:hover{
transform:scale(1.01);
box-shadow:0 4px 12px rgba(0,0,0,0.08);
transition:all .25s ease;
}

</style>

@section('content')

<div class="box col-span-12 lg:col-span-6">

    <x-searchbox />
    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>

    <div class="overflow-x-auto pb-4 lg:pb-6">

        <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">

            <thead class="bg-gray-100 dark:bg-bg3 sticky top-0" style="background-color: bisque;">
                <tr class="text-gray-700 dark:text-gray-200 text-sm font-semibold uppercase tracking-wider">

                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            CUSTOMER NAME
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            DESIGNATION
                        </div>
                    </th>                   
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            NAME
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            DIN
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            APPOINTMENT DATE
                        </div>
                    </th>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            RESIGNATION DATE
                        </div>
                    </th>
                    <th class="text-start !py-5 px-3 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            AUTHORIZED<br>SIGNATORY
                        </div>
                    </th>
                    </th>
                    <th class="text-center !py-5" data-sortable="false">ACTION</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($directors as $index => $director)
                <tr class="table-row dark:even:bg-bg3 border-b hover:bg-gray-50 dark:hover:bg-bg3"
                    style="animation-delay: {{ $loop->index * 0.05 }}s">
                    
                    <!-- {{-- <td class="px-6 py-4">{{ $director->member?->member_info_first_name ?? 'N/A' }}</td> --}} -->
                    <td class="px-4 py-3">
                        @if ($director->member)
                        <div class="flex items-center gap-2">

                            <div class="w-9 h-9 flex items-center justify-center bg-blue-100 rounded-full">
                                <i class="las la-user text-blue-600"></i>
                            </div>

                            <div>
                                <a href="{{ route('member.show', $director->member->id) }}"
                                class="text-green-600 font-medium hover:underline">
                                    {{ $director->member->member_info_first_name }} {{ $director->member->member_info_last_name }}
                                </a>
                            </div>

                        </div>
                        @else
                        N/A
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $director->designation ?? 'N/A' }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ $director?->id ? route('director.show', base64_encode($director->id)) : '#' }}" class="text-primary  hover:underline">
                            {{ $director?->director_name ?? '' }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-1">
                             {{ $director?->din_no??'' }}
                        </span>
                       
                    </td>
                    <td class="px-6 py-4">
                    <span class="px-2">
                        {{ $director->appointment_date?->format('d-m-Y') ?? 'N/A' }}
                    </span>
                    </td>
                    <td class="px-6 py-4">
                       <span class="px-2">
                         {{ $director->resignation_date?->format('d-m-Y') ?? 'N/A' }}
                       </span>
                    </td>
                    <!-- <td class="px-6 py-4">{{ $director->authorized_signatory ? 'Yes' : 'No' }}</td> -->
                    <td class="py-2 px-6">
                        @if ($director->authorized_signatory == 'Yes')
                        <span
                            class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                            Yes
                        </span>
                        @else
                        <span
                            class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16">
                            {{ $director->authorized_signatory }}
                        </span>
                        @endif
                    </td>
                    <td class="py-2 px-6">
                        <div class="flex justify-center">
                            @include('partials._vertical-options', [
                            'id' => base64_encode($director->id),
                            'viewRoute' => 'director.show',
                            'editRoute' => 'director.edit',
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

    <div class="mt-4">
        <x-pagination :paginator="$directors"/>
    </div>

</div>
@endsection