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
                                Branch
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Minor Name
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Member
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Father Name
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Enrollment Date
                            </div>
                        </th>
                        {{-- <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Status
                                </div>
                            </th> --}}
                        <th class="text-center !py-5" data-sortable="false">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($minors as $index => $minor)
                    <tr class="border-b dark:border-bg3">

                        <td class="px-6 py-4">{{ $minor->member->branch->branch_name ?? 'N/A' }}</td>

                        <td class="px-6 py-4">{{ $minor->first_name ?? 'N/A' }}</td>

                        <td class="px-6 py-4">
                            @if ($minor->member)
                            <a href="{{ $minor->member?->id ? route('member.show', $minor->member->id) : '#' }}" 
                                class="text-primary hover:underline">
                                DEMO-{{ $minor->member->member_info_first_name ?? 'N/A' }}
                            </a>
                            @else
                            N/A
                            @endif
                        </td>

                        <td class="px-6 py-4">{{ $minor->father_name ?? 'N/A' }}</td>

                        <td class="px-6 py-4">
                            {{ $minor->enrollment_date }}
                        </td>
                        <td class="py-2 px-6">
                            <div class="flex justify-center">
                                @include('partials._vertical-options', [
                                'id' => $minor->id,
                                'viewRoute' => 'minor.show',
                                'editRoute' => 'minor.edit',
                                ])
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>

                {{-- <tbody>
                @foreach ($minorss as $index => $minors)
                    <tr>
                        <td class="px-6 py-4">{{ $index + 1 }}</td> <!-- Sr No -->
                <td class="px-6 py-4">{{ $minors->branch->name ?? 'N/A' }}</td>
                <!-- Assuming branch relationship -->
                <td class="px-6 py-4">{{ $minors->name ?? 'N/A' }}</td> <!-- Minor Name -->
                <td class="px-6 py-4">{{ $minors->member->member_info_first_name ?? 'N/A' }}</td> <!-- Member -->
                <td class="px-6 py-4">{{ $minors->father_name ?? 'N/A' }}</td> <!-- Father Name -->
                <td class="px-6 py-4">{{ $minors->enrollment_date ?  $minors->enrollment_date->format('D M d Y') : 'N/A' }}</td>
                <td class="py-3 px-6">
                    <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-700">
                        Active
                    </span>
                </td>
                <td class="text-center py-3">
                    <a href="{{ route('member.show', $item->id) }}"
                        class="text-blue-600 hover:underline">View</a> |
                    <a href="{{ route('member.edit', $item->id) }}"
                        class="text-yellow-600 hover:underline">Edit</a>

                    </tr>
                    @endforeach
                    </tbody> --}}
            </table>
        </div>
    </div>

</div>
@endsection