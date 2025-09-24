@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <h3 class="h2">USER</h3>
        <a class="btn-primary" href="{{route('users.create')}}">
            Add
        </a>
    </div>

    <!-- Latest Transactions -->
    <div class="box col-span-12 lg:col-span-6">
        <x-searchbox />
        <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
            <x-alert />
        </div>
        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                USER NAME
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px]" data-sortable="false">EMAIL</th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                CONTACT
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[130px] cursor-pointer">
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
                    <tr>
                        <td class="px-6 py-4">{{ $user->fname . ' ' . $user->lname ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">{{ $user->mobile ?? 'N/A' }}</td>
                        <!-- <td class="px-6 py-4">{{ $user->user_active ?? 'N/A' }}</td> -->
                        <td class="px-6 py-4">
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
    </div>
    <x-pagination :paginator="$users" />
</div>
@endsection