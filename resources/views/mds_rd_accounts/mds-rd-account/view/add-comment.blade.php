@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                Add Comment - RD Account
            </h1>
        </div>
    </div>

    <!-- Success Message Display -->
    @if (session('success'))
    <div class="alert alert-success mb-4 p-3 bg-green-100 text-green-800 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-6 p-4">
        <!-- Left Section: Comments Table -->
        <div class="flex-1 bg-white w-full dark:bg-bg3 shadow-md rounded-10 p-6">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-start text-lg">
                    <thead class="text-start">
                        <tr class="bg-secondary/5 dark:bg-bg3 text-start text-black">
                            <th class="px-4 py-2 font-semibold uppercase text-start">DATE</th>
                            <th class="px-4 py-2 font-semibold uppercase text-start">COMMENT BY</th>
                            <th class="px-4 py-2 font-semibold uppercase text-start">COMMENT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rdAccount->comments as $comment)
                        <tr
                            class="border-b text-center border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <!-- Date -->
                            <td class="px-4 py-2 text-start">
                                {{ $comment->date ? \Carbon\Carbon::parse($comment->date)->format('d-m-Y') : '-' }}
                            </td>

                            <!-- Comment By -->
                            <td class="px-4 py-2 text-start">
                                {{ $comment->user->name ?? 'User Deleted' }}
                            </td>

                            <!-- Comment -->
                            <td class="px-4 py-2 text-start">
                                {{ $comment->comment }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-500">No comments found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Section: Add Comment Form -->
        <div class="w-full lg:w-1/3 bg-white dark:bg-bg3 shadow-md rounded-10 p-6">
            <form action="{{ route('rd.storeComment', $rdAccount->id) }}" method="POST" class="flex flex-col gap-4">
                @csrf

                <!-- Hidden mis_id (or select it dynamically) -->
                <input type="hidden" name="rd_account_id" value="{{ $rdAccount->id ?? old('rd_account_id') }}">

                <!-- Comment Field -->
                <div class="flex flex-col">
                    <label for="comment_message" class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Comment <span class="text-red-500">*</span>
                    </label>
                    <textarea id="comment_message" name="comment" placeholder="Write Your Comment Here..." rows="4"
                        class="w-full p-3 border rounded-lg resize-none
                            bg-gray-50 dark:bg-gray-900
                            border-gray-300 dark:border-gray-600
                            text-gray-900 dark:text-gray-200
                            focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('comment') }}</textarea>
                </div>

                <!-- Buttons -->
                <div class="flex justify-center gap-4">
                    <button type="submit" class="btn-primary transition" data-confirm="Are you sure to add comment?">
                        SAVE
                    </button>
                    <a href="{{ route('rd-accounts.show', $rdAccount->id ) }}" class="btn-outline transition">
                        Back
                    </a>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection