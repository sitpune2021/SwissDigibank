@extends('layout.main')

{{-- @section('content') --}}
@section('page-title',
isset($form15g15h) && $form15g15h->member
? ($form15g15h->member->member_info_first_name ?? '') . ' ' .
($form15g15h->member->member_info_last_name ?? '') . ' - ' .
($form15g15h->financial_year ?? '')
: 'Add member'
)
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@section('content')
<div class="main-inner">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6 lg:mb-8">
        <h5 class="font-bold text-gray-800 h2">Form 15G/ 15H</h5>
    </div>
    <div class="flex items-center justify-between px-4 py-2 border-b bg-gray-50">
        <!-- Member Name -->
        <span class="text-sm font-semibold text-blue-600"></span>

        <!-- Icons -->
        <div class="flex gap-2">

            <a href="{{ route('form15g15h.edit', $form15g15h->id) }}"
                class="class=" btn btn-default btn-xs title="Print">
                <i class="fa fa-pencil" aria-hidden="true"></i>
            </a>
            <form action="{{ route('form15g15h.destroy', $form15g15h->id) }}" method="POST"
                onsubmit="return confirm('Are you sure to delete Form 15G/ 15H?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="class=" btn btn-danger btn-xs
                    title="Delete">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Remaining Transaction Details Table -->
    <table class="w-full text-sm text-left border-t border-gray-300">
        <tbody>
            {{-- <tr>
                    <td class="px-4 py-2 font-semibold border-b bg-gray-50">Member</td>
                    <td class="px-4 py-2 border-b">
                        {{ $form15g15h->member->member_info_first_name }}
            {{ $form15g15h->member->member_info_last_name }}
            </td>
            </tr> --}}
            <tr>
                <td class="px-4 py-2 font-semibold border-b bg-gray-50">Member</td>
                <td class="px-4 py-2 border-b">
                    <a href="{{ $form15g15h->member?->id ? route('member.show', $form15g15h->member->id) : '' }}" class="text-blue-600 underline">
                        {{ $form15g15h->member?->member_info_first_name ?? '' }}
                        {{ $form15g15h->member?->member_info_last_name ?? '' }}
                    </a>
                </td>
            </tr>

            <tr>
                <td class="px-4 py-2 font-semibold border-b bg-gray-50">Financial Year</td>
                <td class="px-4 py-2 border-b"> {{ $form15g15h->financial_year }}
                </td>
            </tr>
            <tr>
                <td class="px-4 py-2 font-semibold border-b bg-gray-50">Created at</td>
                <td class="px-4 py-2 border-b">{{ $form15g15h->created_at }}</td>
            </tr>
            <tr>
                <td class="px-4 py-2 font-semibold border-b bg-gray-50">Updated at</td>
                <td class="px-4 py-2 border-b">{{ $form15g15h->updated_at }}</td>
            </tr>

            <tr>
                <td class="px-4 py-2 font-semibold border-b bg-gray-50">Form 15G/ 15H</td>
                <td class="px-4 py-2 border-b">
                    @if (!empty($form15g15h['form_15_upload']))
                    @php
                    $fileUrl = asset('storage/' . $form15g15h['form_15_upload']);
                    @endphp
                    <a href="{{ $fileUrl }}" target="_blank" rel="noopener noreferrer"
                        class="text-blue-600 underline"> View
                    </a>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>

</div>
@endsection