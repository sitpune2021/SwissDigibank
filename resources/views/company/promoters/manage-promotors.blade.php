@extends('layout.main')
@extends('layout.tablestyle')

@section('page-title')

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

    <!-- LEFT SIDE -->
    <div class="flex items-center gap-3 min-w-0">

        <!-- ICON -->
        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl
            flex items-center justify-center shrink-0 shadow-lg"
            style="
                background: linear-gradient(135deg,#2563eb,#06b6d4,#0ea5e9);
                min-width:44px;
                min-height:44px;
            ">

            <i class="las la-users text-white text-xl sm:text-2xl leading-none"></i>

        </div>

        <!-- TITLE -->
        <div class="min-w-0">

            <h2 class="text-lg sm:text-xl lg:text-2xl
                font-extrabold uppercase tracking-wide
                text-gray-800 leading-tight truncate">

                Promoters Management

            </h2>

            <p class="text-[11px] sm:text-sm text-gray-500 font-medium mt-1">

                Manage promoters details, shares & records

            </p>

        </div>

    </div>

    <!-- RIGHT BADGE -->
    <div class="hidden md:flex items-center gap-2
        px-4 py-2 rounded-xl
        bg-gradient-to-r from-slate-100 to-slate-50
        border border-slate-200 shadow-sm">

        <span class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></span>

        <span class="text-xs font-bold uppercase tracking-wider text-slate-600">

            Banking Panel

        </span>

    </div>

</div>

@endsection

@php
    $permissions = auth()->user()->rolePermission->permissions ?? [];
    $isSuperAdmin = auth()->user()->role_id == 1;
@endphp

@section('action-button')
    @if($isSuperAdmin || in_array('promotor.create', $permissions))
        <a href="{{ route('promotor.create') }}"
            class="inline-flex items-center gap-2
            px-4 sm:px-5 py-2.5
            rounded-xl text-xs sm:text-sm font-bold uppercase
            shadow-lg transition-all duration-300 hover:scale-105"
            style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">

            <span>Add Promoter</span>
        </a>
    @endif
@endsection


@section('content')

<div class="box col-span-12 lg:col-span-6 bank-page-animate">

    <div class="mb-3">
        <x-searchbox />
    </div>

    <!-- TABLE -->
    <div class="table-wrapper w-full overflow-x-auto rounded-2xl border border-gray-200 bg-white shadow-sm table-premium">

        <table class="w-full" id="transactionTable1">

            <!-- TABLE HEAD -->
            <thead class="bg-gradient-to-r from-slate-100 via-white to-slate-100 border-b border-gray-200">

                <tr class="text-[11px] sm:text-xs lg:text-sm uppercase tracking-wider font-bold text-black">

                    <!-- SR NO -->
                    <th class="px-3 sm:px-5 py-4 text-center min-w-[90px]">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-hashtag text-sm sm:text-base text-black"></i>
                            </div>

                            <span class="text-black whitespace-nowrap">SR NO</span>

                        </div>

                    </th>

                    <!-- PROMOTER -->
                    <th class="px-3 sm:px-5 py-4 text-left whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">

                                <i class="las la-user text-primary text-sm sm:text-base"></i>

                            </div>

                            <span>Promoter Name</span>

                        </div>

                    </th>

                    <!-- GENDER -->
                    <th class="px-3 sm:px-5 py-4 text-center whitespace-nowrap">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-pink-100 flex items-center justify-center shrink-0">

                                <i class="las la-venus-mars text-pink-600 text-sm sm:text-base"></i>

                            </div>

                            <span>Gender</span>

                        </div>

                    </th>

                    <!-- SENIOR -->
                    <th class="px-3 sm:px-5 py-4 text-center whitespace-nowrap">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-yellow-100 flex items-center justify-center shrink-0">

                                <i class="las la-user-shield text-yellow-600 text-sm sm:text-base"></i>

                            </div>

                            <span>Senior Citizen</span>

                        </div>

                    </th>

                    <!-- ENROLLMENT -->
                    <th class="px-3 sm:px-5 py-4 text-center whitespace-nowrap">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">

                                <i class="las la-calendar text-blue-600 text-sm sm:text-base"></i>

                            </div>

                            <span>Enrollment Date</span>

                        </div>

                    </th>

                    <!-- KYC -->
                    <th class="px-3 sm:px-5 py-4 text-center whitespace-nowrap">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-green-100 flex items-center justify-center shrink-0">

                                <i class="las la-id-card text-green-600 text-sm sm:text-base"></i>

                            </div>

                            <span>KYC Status</span>

                        </div>

                    </th>

                    <!-- ACTION -->
                    <th class="px-3 sm:px-5 py-4 text-center whitespace-nowrap">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">

                                <i class="las la-cogs text-gray-700 text-sm sm:text-base"></i>

                            </div>

                            <span>Actions</span>

                        </div>

                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($promotors as $promotor)

                <tr class="table-row border-b border-gray-100"
                    style="animation-delay:{{ $loop->index * 0.05 }}s">

                    <!-- SR NO -->
                    <td class="px-6 py-5 text-center font-semibold text-gray-700">

                        {{ $loop->iteration }}

                    </td>

                    <!-- NAME -->
                    <td class="px-5 py-4" data-label="Promoter">

                        <div class="flex items-center gap-3">

                            <!-- NAME + CUSTOMER NO IN SINGLE LINE -->
                            <div class="flex flex-col">

                                <a href="{{ route('promotor.show', base64_encode($promotor->id)) }}"
                                    class="font-semibold text-primary hover:underline text-sm sm:text-base">

                                    {{ trim(implode(' ', array_filter([
                                        $promotor->first_name,
                                        $promotor->middle_name,
                                        $promotor->last_name
                                    ]))) }}

                                    <span class="text-gray-500 font-medium ml-2">
                                        | Customer No: {{ $promotor->folio_no }}
                                    </span>

                                </a>

                            </div>

                        </div>

                    </td>

                    <!-- GENDER -->
                    <td class="px-5 py-4 text-center"
                        data-label="Gender">

                        {{ $promotor->gender ?? '-' }}

                    </td>

                    <!-- SENIOR -->
                    <td class="px-5 py-4 text-center"
                        data-label="Senior Citizen">

                        @if(($promotor->is_senior ?? '') === 'Yes')

                        <span class="px-4 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary">
                            Yes
                        </span>

                        @else

                        <span class="px-4 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600">
                            No
                        </span>

                        @endif

                    </td>

                    <!-- ENROLLMENT -->
                    <td class="px-5 py-4 text-center"
                        data-label="Enrollment Date">

                        {{ $promotor->enrollment_date ? \Carbon\Carbon::parse($promotor->enrollment_date)->format('d-m-Y') : '-' }}

                    </td>

                    <!-- KYC -->
                    <td class="px-5 py-4 text-center"
                        data-label="KYC Status">

                        @if(optional($promotor->kyc)->kyc_status == 'completed')

                        <span class="uppercase text-primary font-semibold">
                            Completed
                        </span>

                        @else

                        <span class="uppercase text-warning font-semibold">
                            {{ optional($promotor->kyc)->kyc_status ?? 'Pending' }}
                        </span>

                        @endif

                    </td>

                    <!-- ACTION -->
                    <td class="px-5 py-4 text-center align-middle"
                        data-label="Actions">

                        <div class="flex items-center justify-center gap-2 action-group">

                            <!-- VIEW -->
                            @if($isSuperAdmin || in_array('promotor.show', $permissions))
                            <a href="{{ route('promotor.show', base64_encode($promotor->id)) }}"
                                class="action-btn action-view">

                                <i class="las la-eye"></i>
                                <span>VIEW</span>

                            </a>
                            @endif

                            <!-- EDIT -->
                            @if($isSuperAdmin || in_array('promotor.edit', $permissions))
                            <a href="{{ route('promotor.edit', base64_encode($promotor->id)) }}"
                                class="action-btn action-edit">

                                <i class="las la-edit"></i>
                                <span>EDIT</span>

                            </a>
                            @endif

                            <!-- DELETE -->
                            @if(in_array('promotor.destroy', $permissions))
                            <form action="{{ route('promotor.destroy', base64_encode($promotor->id)) }}"
                                method="POST"
                                class="delete-form"
                                onsubmit="return confirm('Delete this promoter?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="action-btn action-delete">

                                    <i class="las la-trash"></i>
                                    <span>DELETE</span>

                                </button>

                            </form>
                            @endif

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6"
                        class="py-10 text-center text-gray-500">

                        No promoter records found.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <!-- PAGINATION -->
    <div class="mt-5">
        <x-pagination :paginator="$promotors"/>
    </div>

</div>

@endsection