@extends('layout.main')

@section('content')

<div class="main-inner">

    <div class="mb-6 flex flex-wrap px-6 items-center justify-between gap-4 lg:mb-8">
        <h2 class=" uppercase text-lg">USER</h2>
        <a class="btn-primary text-sm" href="{{route('users.create')}}">
            ADD
        </a>
    </div>

    <style>

    @keyframes fadeRow{
    0%{
    opacity:0;
    transform:translateY(10px);
    }
    100%{
    opacity:1;
    transform:translateY(0);
    }
    }

    .table-row{
    animation:fadeRow .4s ease forwards;
    }

    /* hover animation */

    .table-row:hover{
    transform:scale(1.01);
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
    transition:all .25s ease;
    }

    </style>

    <!-- Latest Transactions -->
    <div class="box col-span-12 lg:col-span-6">

        <x-searchbox />

        <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6"
            style="flex-direction: row-reverse;">
            <x-alert />
        </div>

        <div class="overflow-x-auto pb-4 lg:pb-6">

            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">

                <thead class="bg-gray-100 dark:bg-bg3 sticky top-0" style="background-color: bisque;">
                    <tr class="text-gray-700 dark:text-gray-200 text-sm font-semibold uppercase tracking-wider">

                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                USER NAME
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer" data-sortable="false">
                            <div class="flex items-center gap-1">
                                EMAIL
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                CONTACT
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                ACTIVE
                            </div>
                        </th>
                        <!-- <th class="text-start !py-5 cursor-pointer">
                            <div class="flex items-center gap-1">
                                Login On Holidays
                            </div>
                        </th> -->
                        <th class="text-center !py-5" data-sortable="false">ACTION</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $index => $user)
                    <tr class="table-row dark:even:bg-bg3 border-b hover:bg-gray-50 dark:hover:bg-bg3"
                        style="animation-delay: {{ $loop->index * 0.05 }}s">

                        <td class="px-3 py-2">
                            <div class="flex items-center gap-2">

                                <div class="w-8 h-8 flex items-center justify-center bg-blue-100 rounded-full">
                                    <i class="las la-user text-blue-600 text-sm"></i>
                                </div>

                                <span class="font-medium text-green-800">
                                    {{ $user->fname }} {{ $user->lname }}
                                </span>

                            </div>
                        </td>
                        <td class="px-6 py-4  ">{{ $user->email }}</td>
                        <td class="px-6 py-4">{{ $user->mobile ?? 'N/A' }}</td>
                        {{-- <td class="px-6 py-4">{{ $user->user_active ?? 'N/A' }}</td> --}}
                        <td class="px-6 py-4 ">
                            @if ($user->user_active == 1)
                            <span
                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                Yes
                            </span>

                            @elseif ($user->user_active == 0)
                            <span
                                class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16">
                                No
                            </span>
                            @else
                            N/A
                            @endif
                        </td>
                        <td class="py-2 px-6">
                            <div class="flex justify-center">
                                @include('partials._vertical-options', [
                                'id' => base64_encode($user->id),
                                'viewRoute' => 'users.show',
                                'editRoute' => 'users.edit',
                                ])

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

        <div class="mt-3">
            <x-pagination :paginator="$users" />
        </div>

    </div>

</div>

@endsection