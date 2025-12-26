@extends('layout.main')

@section('content')

    <style>
        input[type="checkbox"] {
            width: 28px;
            height: 28px;
            accent-color: green;
            /* For modern browsers */
        }

        /* Fallback for browsers without accent-color support */
        input[type="checkbox"]:checked {
            background-color: green;
            border: none;
        }

        input[type="radio"] {
            width: 24px;
            height: 24px;
            accent-color: green;
            /* Modern browser support */
        }
    </style>

    <div class="main-inner">

        <div class=" flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col  gap-2">
                <div class="flex items-center gap-3">
                    <h1 class="text-lg font-semibold uppercase">
                       Comments
                    </h1>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-2 md:grid-cols-3 gap-6   md-4">
            <div class="col-span-2 md:col-span-1 box  dark:bg-bg3 rounded-2xl ">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap select-all-table " id="">

                        <thead>
                            <tr class="bg-secondary/5 dark:bg-bg3">
                                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-start gap-1">
                                        GROUP NAME
                                    </div>
                                </th>
                                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-start gap-1">
                                        COMMENT BY
                                    </div>
                                </th>

                                <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                    <div class="flex items-start gap-1">
                                        COMMENT
                                    </div>
                                </th>

                            </tr>
                        </thead>

                        <tbody>
                            @forelse($comments as $comment)
                                <tr class="border-b">
                                    <!-- Date -->
                                    <td class="text-left !py-5 px-6 min-w-[100px]">
                                        {{ $comment->created_at->format('d-m-Y') }}
                                    </td>

                                    <!-- Comment By -->
                                    <td class="text-left !py-5 px-6 min-w-[100px]">
                                        {{ $comment->user->fname ?? 'N/A' }}
                                    </td>

                                    <!-- Comment -->
                                    <td class="text-left !py-5 px-6 min-w-[130px]">
                                        {{ $comment->comment }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-6 text-gray-500">
                                        No comments available.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>


                    </table>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1 box dark:bg-bg3 rounded-2xl">
                <form action="{{ route('groups.comments.store', base64_encode($group->id)) }}" method="POST">
                    @csrf

                    <div class="mt-6">
                        <label class="md:text-lg font-medium block mb-4 uppercase">
                            Comment <span class="text-red-500">*</span>
                        </label>

                        <textarea name="comment" placeholder="Write Your Comment Here..."
                            class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 py-3"
                            required>{{ old('comment') }}</textarea>

                        @error('comment')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-center gap-3 mt-6">
                        <button type="submit" class="btn-primary uppercase">
                            Save
                        </button>

                        <a href="{{ route('groups.show',base64_encode($group->id))  }}" class="btn-outline uppercase">
                            Back
                        </a>
                    </div>
                </form>
            </div>

        </div>

    </div>
    </div>






@endsection