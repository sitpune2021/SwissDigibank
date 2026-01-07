@extends('layout.main')

@section('content')
<style>
  .width-right {
    width: 70%;
  }

  .width-left {
    width: 30%;
  }

  @media (max-width: 1024px) {

    .width-right,
    .width-left {
      width: 100% !important;
    }
  }
</style>
<div class="main-inner">
  <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
    <div class="flex items-start flex-col gap-2">
      <h1 class="px-5 text-lg uppercase font-semibold">Add Comment - MIS Account - {{ $misaccount->id }}</h1>
    </div>
  </div>
  <div class="flex flex-col lg:flex-row gap-6 p-4">

    <div class="width-right bg-white  dark:bg-gray-800 shadow-md rounded-2xl p-6">
      <div class="overflow-x-auto">
        <table class="w-full border-collapse text-start text-lg">
          <thead>
            <tr class="bg-secondary/5 dark:bg-gray-700 text-black">
              <th class="px-4 py-2 font-semibold text-start">DATE</th>
              <th class="px-4 py-2 font-semibold text-start">COMMENT BY</th>
              <th class="px-4 py-2 font-semibold text-start">COMMENT</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($misaccount->comments as $c)
            <tr class="border-b text-center border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
              <td class="px-4 py-2 text-start">{{ $c->date }}</td>
              <td class="px-4 py-2 text-start">{{ $c->commented_by }}</td>
              <td class="px-4 py-2 text-start">{{ $c->comment }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="3" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                No Comments Found
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>

      </div>
    </div>

    <!-- Right Section: Add Comment Form -->
    <div class="width-left bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6">
      <form action="{{ route('mis.storeComment',$misaccount->id) }}" method="POST">
        @csrf

        <!-- Hidden MIS Account ID -->
        <input type="hidden" name="misaccount_id" value="{{ $misaccount->id }}">

        <!-- (Optional) Logged-in user ID -->
        <input type="hidden" name="commented_by" value="{{ auth()->user()->id ?? null }}">

        <!-- Comment Field -->
        <div class="flex flex-col">
          <label for="comment_message" class="mb-2  font-medium text-gray-700  dark:text-gray-300">
            Comment <span class="text-red-500">*</span>
          </label>

          <textarea id="comment_message" name="comment"
            placeholder="Write Your Comment Here..."
            rows="4"
            class="w-full  p-3 border rounded-lg resize-none
                 bg-gray-50 dark:bg-gray-900
                 border-gray-300 dark:border-gray-600
                 text-gray-900 dark:text-gray-200
                 focus:ring-2 focus:ring-green-500 focus:border-green-500"></textarea>
        </div>

        <!-- Buttons -->
        <div class="flex justify-center mt-4 gap-4">
          <button type="submit"
            class="btn-primary ">
            SAVE
          </button>
          <button href=""
            class="btn-outline uppercase">
            BACk
          </button>
        </div>
      </form>
    </div>
  </div>


</div>


@endsection