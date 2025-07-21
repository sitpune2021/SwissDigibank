@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <h2 class="h2">User</h2>
        <a class="btn-primary" href="{{route('CreateUser')}}">
            <i class="las la-plus-circle text-base md:text-lg"></i>
            Add
        </a>
    </div>

    <!-- Latest Transactions -->
    <div class="box col-span-12 lg:col-span-6">
        <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
            <!-- <h4 class="h4">User</h4> -->
            <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                <form
                    class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                    <input type="text" id="transaction-search" placeholder="Search"
                        class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                    <button
                        class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                        <i class="las la-search text-lg"></i>
                    </button>
                </form>
                <!-- <div class="flex items-center gap-3 whitespace-nowrap">
                        <span>Sort By : </span>
                        <select name="sort" class="nc-select green !rounded-3xl">
                            <option value="day">Last 15 Days</option>
                            <option value="week">Last 1 Month</option>
                            <option value="year">Last 6 Month</option>
                        </select>
                    </div> -->
            </div>
        </div>
        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Sr No
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                User Name
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px]" data-sortable="false">Email</th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Contact
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Active
                            </div>
                        </th>
                        <!-- <th class="text-start !py-5 cursor-pointer">
                            <div class="flex items-center gap-1">
                                Login On Holidays
                            </div>
                        </th> -->
                        <th class="text-center !py-5" data-sortable="false">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                    <tr>
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $user->fname . ' ' . $user->lname ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">{{ $user->mobile ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $user->user_active ?? 'N/A' }}</td>
                        <!-- <td class="px-6 py-4">{{ $user->login_on_holidays ?? 'N/A' }}</td> -->
                        <!-- <td class="px-6 py-4 text-center">
                <a href="{{ route('users.show', $user->id) }}" class="text-blue-600 hover:underline">View</a>
            </td> -->
                        <td class="py-2 px-6">
                            <div class="flex justify-center">
                                @include('partials._vertical-options', [
                                'id' => base64_encode($user->id),
                                'viewRoute' => 'user.show',
                                'editRoute' => 'user.edit',
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
</div>
@endsection