@extends('layout.main')
@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <!-- <div class="flex items-center gap-2"> -->
        <h2 class="h2">Saving / Current Accounts</h2>
        <a class="btn-primary" href="{{ route('create.branch') }}">
            <i class="las la-plus-circle text-base md:text-lg"></i>
            Add
        </a>
        <!-- </div> -->
    </div>

    <!-- Latest Transactions -->
    <div class="box col-span-12 lg:col-span-6">
        <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
            <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2 mb-4">
                <label for="perPage" class="text-sm">Show</label>
                <select name="perPage" id="perPage" onchange="this.form.submit()"
                    class="border rounded px-2 py-1 text-sm">
                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span class="text-sm">entries</span>
            </form>
            <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                <form method="GET" action="{{  route('manage.branch') }}"
                    class="relative flex items-center gap-2 bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xl:max-w-[319px]">
                    <input type="text" id="transaction-search" name="search" placeholder="Search"
                        value="{{ request('search') }}"
                        class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                    <button type="submit"
                        class="w-7 h-7 bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                        <i class="las la-search text-lg"></i>
                    </button>
                    @if (request('search'))
                    <a href="{{  route('manage.branch') }}"
                        class="w-7 h-7 bg-grey-500 hover:bg-grey-900 text-dark rounded-full flex items-center justify-center transition duration-200"
                        title="Clear Search">
                        <i class="las la-times text-lg"></i>
                    </a>
                    @endif
                </form>
            </div>
        </div>
        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
    <thead class="custom-thead">
        <tr class="bg-secondary/5 dark:bg-bg3">
            @php
                $headers = [
                                "Sr No",
                                "Associate",
                                "Group",
                                "Type",
                                "A/c No.",
                                "Member No",
                                "Member Name",
                                "Minor",
                                "Action"
                            ];
            @endphp
            @foreach ($headers as $index => $header)
                <th class="{{ $header === 'Action' ? 'text-center' : 'text-start' }} py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">
                        {{ $header }}
                    </div>
                </th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach($Accounts as $index => $Account)
        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
            {{-- Sr No --}}
            <td class="text-start py-5 px-6">{{ $index + 1 }}</td>

            {{-- Associate (advisor_id) --}}
            <td class="text-start py-5 px-6">{{ $Account->users->fname." ".$Account->users->lname ?? '-' }}</td>

            {{-- Group --}}
            <td class="text-start py-5 px-6">-</td>

            {{-- Type --}}
            <td class="text-start py-5 px-6">{{ $Account->account_type ?? '-' }}</td>

            {{-- A/C NO. --}}
            <td class="text-start py-5 px-6">{{ $Account->account_no ?? '-' }}</td>

            {{-- Member No --}}
            <td class="text-start py-5 px-6">{{ $Account->members->id ?? '-' }}</td>

            {{-- Member Name (you used member_id twice) --}}
            <td class="text-start py-5 px-6">{{ $Account->members->member_info_first_name." ".$Account->members->member_info_last_name ?? '-' }}</td>

            {{-- Minor --}}
            <td class="text-start py-5 px-6">{{ $Account->minor_id ?? '-' }}</td>

            {{-- Action --}}
            <td class="text-center py-5 px-6">
                <div class="flex justify-center">
                    @include('partials._vertical-options', [
                        'id' => base64_encode($Account->id),
                        'viewRoute' => 'accounts.show' // Correct route for view action
                    ])
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

        </div>
       
    </div>
</div>
@endsection
