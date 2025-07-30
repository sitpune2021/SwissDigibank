@extends('layout.main')
@section('page-title', 'Promoters')
@section('action-button')
    <a class="btn-primary" href="{{ route('promotor.create') }}">
        <i class=" md:text-lg"></i>
        Add
    </a>
@endsection

@section('content')
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
                <form method="GET" action="{{ route('promotor.index') }}"
                    class="relative flex items-center gap-2 bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xl:max-w-[319px]">
                    <input type="text" id="transaction-search" name="search" placeholder="Search"
                        value="{{ request('search') }}"
                        class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                    <button type="submit"
                        class="w-7 h-7 bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                        <i class="las la-search text-lg"></i>
                    </button>
                    @if (request('search'))
                        <a href="{{ route('promotor.index') }}"
                            class="w-7 h-7 bg-grey-500 hover:bg-grey-900 text-dark rounded-full flex items-center justify-center transition duration-200"
                            title="Clear Search">
                            <i class="las la-times text-lg"></i>
                        </a>
                    @endif
                </form>
            </div>
        </div>
        @if (session('success'))
            <div id="success-alert"
                style="background-color: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
                <strong>Success:</strong> {{ session('success') }}
                <span onclick="document.getElementById('success-alert').style.display='none';"
                    style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #155724;">&times;</span>
            </div>
        @endif

        @if (session('error'))
            <div id="error-alert"
                style="background-color: #f8d7da; border: 1px solid #dc3545; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
                <strong>Error:</strong> {{ session('error') }}
                <span onclick="document.getElementById('error-alert').style.display='none';"
                    style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #721c24;">&times;</span>
            </div>
        @endif
        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead class="custom-thead">
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Sr No
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Member No
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Name
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px]" data-sortable="false">Gender</th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Senior CTZ.
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Enrollment Date
                            </div>
                        </th>
                        <th class="text-start !py-5 cursor-pointer">
                            <div class="flex items-center gap-1">
                                KYC Status
                            </div>
                        </th>
                        <th class="text-center !py-5" data-sortable="false">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($promotors as $promotor)
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <td class="py-5 px-6">
                                {{ ($promotors->currentPage() - 1) * $promotors->perPage() + $loop->iteration }}
                            </td>
                            <td class="py-5 px-6">
                                <a href="{{ route('promotor.show', base64_encode($promotor->id)) }}"
                                    class="text-blue-500 hover:underline">
                                    DEMO-{{ $promotor->folio_no }}
                                </a>
                            </td>
                            <td class="py-5 px-6">
                                <div>
                                    <p class="font-medium mb-1">{{ $promotor->first_name }}</p>
                                </div>
                            </td>
                            <td class="py-5 px-6">{{ $promotor->gender }}</td>
                            <td class="py-2">
                                @if ($promotor->is_senior == 'Yes')
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                        Yes
                                    </span>
                                @else
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16">
                                        {{ $promotor->is_senior }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-5 px-6">{{ $promotor->enrollment_date->format('D d M Y') }}</td>
                            <td class="py-2">
                                {{-- @if ($promotor->kyc->kyc_status == 'completed')
                            <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                {{$promotor->kyc->kyc_status}}
                            </span>
                            @else
                            <span
                                class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16">
                                {{$promotor->kyc->kyc_status}}
                            </span>
                            @endif --}}
                            </td>
                            <td class="py-2 px-6">
                                <div class="flex justify-center">
                                    @include('partials._vertical-options', [
                                        'id' => base64_encode($promotor->id),
                                        'viewRoute' => 'promotor.show',
                                        'editRoute' => 'promotor.edit',
                                    ])
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($promotors->lastPage() > 1)
            <div class="flex col-span-12 gap-4 sm:justify-between justify-center items-center flex-wrap">
                <ul class="flex gap-2 md:gap-3 flex-wrap md:font-semibold items-center">

                    {{-- Previous Page Link --}}
                    @if ($promotors->onFirstPage())
                        <li>
                            <button
                                class="border md:w-10 md:h-10 w-8 h-8 flex items-center justify-center rounded-full text-gray-400 border-gray-300"
                                disabled>
                                <i class="las la-angle-left text-lg"></i>
                            </button>
                        </li>
                    @else
                        <li>
                            <a href="{{ $promotors->previousPageUrl() }}"
                                class="hover:bg-primary text-primary rtl:rotate-180 hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                                <i class="las la-angle-left text-lg"></i>
                            </a>
                        </li>
                    @endif

                    {{-- Page Number Links --}}
                    @for ($i = 1; $i <= $promotors->lastPage(); $i++)
                        @if ($i == $promotors->currentPage())
                            <li>
                                <button
                                    class="hover:bg-primary text-n0 bg-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                                    {{ $i }}
                                </button>
                            </li>
                        @else
                            <li>
                                <a href="{{ $promotors->url($i) }}"
                                    class="hover:bg-primary text-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                                    {{ $i }}
                                </a>
                            </li>
                        @endif
                    @endfor

                    {{-- Next Page Link --}}
                    @if ($promotors->hasMorePages())
                        <li>
                            <a href="{{ $promotors->nextPageUrl() }}"
                                class="hover:bg-primary text-primary hover:text-n0 rtl:rotate-180 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                                <i class="las la-angle-right text-lg"></i>
                            </a>
                        </li>
                    @else
                        <li>
                            <button
                                class="border md:w-10 md:h-10 w-8 h-8 flex items-center justify-center rounded-full text-gray-400 border-gray-300"
                                disabled>
                                <i class="las la-angle-right text-lg"></i>
                            </button>
                        </li>
                    @endif
                </ul>
            </div>
        @endif
    </div>
@endsection
