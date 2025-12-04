@extends('layout.main')

@section('content')
<div class="main-inner">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
        <h2 class="h2">Passbook</h2>
        <a class="btn-primary flex items-center gap-2" href="{{ route('passbook.create-passbook') }}">
            Add
        </a>
    </div>

    <!-- Table -->

    <div class="pb-4 box overflow-x-auto rounded-t-lg bg-white lg:pb-6">
        <table class="w-full border border-n30 rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-secondary/5 dark:bg-bg3 text-sm font-semibold">
                    <th class="px-6 py-3 text-center">PASSBOOK NO</th>
                    <th class="px-6 py-3 text-center">ACCOUNT</th>
                    <th class="px-6 py-3 text-center">ISSUE DATE</th>
                    <th class="px-6 py-3 text-center">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                
            <tbody>
                @forelse($passbooks as $passbook)
                <tr class="border-t">
                    <td class="px-6 py-4 text-center">{{ $passbook->passbook_no }}</td>
                    <td class="px-6 py-4 text-center">{{ $passbook->account_no }} ({{ $passbook->account_type }})</td>
                    <td class="px-6 py-4 text-center">{{ \Carbon\Carbon::parse($passbook->issue_date)->format('d-m-Y') }}</td>
                    <td class="px-6 py-2">
                        <div class="flex justify-center">
                            <div class="relative">
                                <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                <ul class="horiz-option popover-content">
                                    <li>
                                        <a href="{{ route('passbook.show', $passbook->id) }}" class="single-option">View</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-6 text-center text-gray-500">No passbooks found.</td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>
    @endsection