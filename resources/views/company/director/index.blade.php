@extends('layout.main')

@section('page-title', 'DIRECTOR')
@section('action-button')
<a class="btn-primary" href="{{ route('director.create') }}">
    Add
</a>
@endsection

@section('content')
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
                            DESIGNATION
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            MEMBER
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            NAME
                        </div>
                    </th>
                    <th class="text-start !py-5 min-w-[100px] cursor-pointer">
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
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
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
                <tr>
                    <td class="px-6 py-4">{{ $director->designation ?? 'N/A' }}</td>
                    <!-- {{-- <td class="px-6 py-4">{{ $director->member?->member_info_first_name ?? 'N/A' }}</td> --}} -->
                    <td class="py-3 px-6">
                        @if ($director->member)
                        <a href="{{ $director?->member?->id ? route('member.show', $director->member->id) : '#' }}"
                            class="text-primary hover:underline">
                            {{ $director->member?->member_info_first_name ??''}}
                        </a>
                        @else
                        N/A
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ $director?->id ? route('director.show', base64_encode($director->id)) : '#' }}" class="text-primary hover:underline">
                            {{ $director?->director_name ?? '' }}
                        </a>
                    </td>
                    <td class="px-6 py-4">{{ $director?->din_no??'' }}</td>
                    <td class="px-6 py-4">{{ $director->appointment_date?->format('d-m-Y') ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $director->resignation_date?->format('d-m-Y') ?? 'N/A' }}</td>
                    <!-- <td class="px-6 py-4">{{ $director->authorized_signatory ? 'Yes' : 'No' }}</td> -->
                    <td class="py-2">
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
    <x-pagination :paginator="$directors" />
</div>
@endsection