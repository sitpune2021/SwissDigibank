@extends('layout.main')

{{-- @section('content') --}}
@section('page-title',
    isset($form15g15h)
    ? $form15g15h->member->member_info_first_name . ' ' . $form15g15h->member->member_info_last_name . ' - ' .
    $form15g15h->financial_year
    : 'Add
    member')
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
                <button class="px-2 py-1 text-xs text-white bg-green-500 rounded hover:bg-gray-300" title="Print">
                    <i class="fas fa-pencil"></i>
                </button>
                <button class="px-2 py-1 text-xs text-white bg-red-500 rounded hover:bg-gray-300" title="Delete">
                    <i class="fas fa-trash-alt"></i>
                </button>
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
                <a href="{{ route('member.show', $form15g15h->member->id) }}" class="text-blue-600 underline">
                    {{ $form15g15h->member->member_info_first_name }}
                    {{ $form15g15h->member->member_info_last_name }}
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
                    </td>
                    @endif
                </tr>
            </tbody>
        </table>
    </div>

    </div>
@endsection
