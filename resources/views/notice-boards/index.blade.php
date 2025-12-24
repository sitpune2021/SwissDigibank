@extends('layout.main')

@section('content')
    <div class="main-inner">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
            <h2 class="h2">Notice Board </h2>
            <a class="btn-primary flex items-center gap-2" href="{{ route('notice-boards.create') }}">
                Add
            </a>
        </div>


        @if(session('success'))
            <div class="">
                <div class="w-44 mb-5 flex justify-end">
                    <x-alert />
                </div>
                {{-- {{ session('success') }} --}}
            </div>
        @endif


        <!-- Table -->

        <div class="pb-4 box overflow-x-auto rounded-t-lg bg-white lg:pb-6">
            <table class="w-full border border-n30 rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3 text-sm font-semibold">
                        <th class="px-6 py-3 text-center">TITLE</th>
                        <th class="px-6 py-3 text-center">IMAGE/ FILE</th>
                        <th class="px-6 py-3 text-center">START DATE</th>
                        <th class="px-6 py-3 text-center">END DATE</th>
                        <th class="px-6 py-3 text-center">APP TYPE</th>
                        <th class="px-6 py-3 text-center">CREATED BY</th>
                        <th class="px-6 py-3 text-center">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>

                <tbody>
                    @forelse($notices as $notice)
                        <tr class="border-t">
                            <td class="px-6 py-4 text-center">{{ $notice->notice_title }}</td>
                            <td class="px-6 py-4 text-center">
                                {{-- <a href="{{ asset($notice->images) }}" class="text-secondary ">View</a> --}}
                                     <p>-</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ \Carbon\Carbon::parse($notice->start_date)->format('d-m-Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ \Carbon\Carbon::parse($notice->end_date)->format('d-m-Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $notice->app_type }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $notice->user ? $notice->user->fname . ' ' . $notice->user->lname : 'N/A' }}
                            </td>
                            <td class="px-6 py-2">
                                @php
                                    $encodedId = base64_encode($notice->id);
                                @endphp
                                <div class="flex justify-center">
                                    <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                        <ul class="horiz-option popover-content">
                                            <li>
                                                <a href="{{ route('notice-boards.show', ['notice_board' => $encodedId]) }}"
                                                    class="single-option">View</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('notice-boards.edit', ['notice_board' => $encodedId]) }}"
                                                    class="single-option">Edit</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="border border-gray-300 px-4 py-2 text-center">No notices found.</td>
                        </tr>
                    @endforelse


                </tbody>

            </table>

            <!-- Overlay -->
            <div id="modal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50">

                <!-- Modal Box -->
                <div class="bg-white w-56 max-w-md rounded-xl shadow-lg p-6 relative">

                    <!-- Close Button -->
                    <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                        ✕
                    </button>

                    <!-- Title -->
                    <h2 class="text-xl font-semibold mb-4">
                        Tailwind Popup
                    </h2>

                    <!-- Content -->
                    <p class="text-gray-600 mb-6">
                        This is a simple Tailwind CSS popup modal.
                    </p>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3">
                        <button onclick="closeModal()" class="px-4 py-2 border rounded hover:bg-gray-100">
                            Cancel
                        </button>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Confirm
                        </button>
                    </div>
                </div>
            </div>


        </div>


        <script>
            // popup for image
            function openModal() {
                document.getElementById('modal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('modal').classList.add('hidden');
            }
        </script>

@endsection