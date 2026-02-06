@extends('layout.main')

@section('content')
<div class="main-inner">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
        <h2 class="h2 text-lg uppercase">Passbook</h2>
        <a class="btn-primary flex items-center uppercase gap-2" href="{{ route('passbook.create-passbook') }}">
            Add
        </a>
    </div>

    <!-- Table -->
@if(session('success'))
            <div class="">
                <div class="w-44 mb-5 flex justify-end">
                    <x-alert />
                </div>
                {{-- {{ session('success') }} --}}
            </div>
        @endif
    <div class="pb-4 box overflow-x-auto rounded-t-lg bg-white lg:pb-6">
        <table class="w-full border border-n30 rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-secondary/5 dark:bg-bg3  text-sm font-semibold">
                    <th class="px-6 py-3 text-start">PASSBOOK NO</th>
                    <th class="px-6 py-3 text-start">ACCOUNT</th>
                    <th class="px-6 py-3 text-start">ISSUE DATE</th>
                    <th class="px-6 py-3 text-start">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                
            <tbody>
                @forelse($passbooks as $passbook)
                <tr class="border-t">
                    <td class="px-6 py-4 text-start">{{ $passbook->passbook_no }}</td>
                    <td class="px-6 py-4 text-start">
                        <a href="" class="text-primary">
                             {{ $passbook->account_no }} ({{ $passbook->account_type }})
                        </a> 
                    </td>
                    <td class="px-6 py-4 text-start">{{ \Carbon\Carbon::parse($passbook->issue_date)->format('d-m-Y') }}</td>
                    <td class="px-6 py-2">
                        <div class="flex justify-center">
                            <div class="relative">
                                <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                <ul class="horiz-option popover-content">
                                    <li>
                                        <a href="{{ route('passbook.show', $passbook->id) }}" class="single-option uppercase">View</a>
                                    </li>
                                      <li>
                                        <a href="{{ route('passbook.edit', $passbook->id) }}" class="single-option uppercase">Edit</a>
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