@extends('layout.main')
@section('page-title', 'BRANCHES')
@section('action-button')
<a class="btn-primary uppercase btns-add-index" href="{{ route('branch.create') }}">
    Add
</a>
@endsection
<style>
    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    /* Container for the toggle background */
    .blocks {
        width: 56px;
        /* 14 * 4px */
        height: 32px;
        /* 8 * 4px */
        border-radius: 9999px;
        /* Fully rounded */
        background-color: #9CA3AF;
        /* Tailwind gray-400 default */
        transition: background-color 0.3s ease;
    }

    /* The small white dot */
    .dot {
        position: absolute;
        top: 4px;
        /* 1 * 4px */
        left: 4px;
        /* 1 * 4px */
        width: 24px;
        /* 6 * 4px */
        height: 24px;
        /* 6 * 4px */
        background-color: white;
        border-radius: 9999px;
        transition: transform 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
    }

    /* When the checkbox is checked, change bg color */
    input[type="checkbox"].slider-toggle:checked+div .blocks {
        background-color: #228cc5;
        /* Tailwind green-500 */
    }

    /* Move the dot to right when checked */
    input[type="checkbox"].slider-toggle:checked+div .dot {
        transform: translateX(24px);
        /* 6 * 4px */
    }
</style>

@section('content')
<div class="col-span-12 box lg:col-span-6">
    <x-searchbox />
    @include('fields.errormessage')
    <div class="pb-4 overflow-x-auto lg:pb-6">
        <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
            <thead class="custom-thead">
                <tr class="bg-secondary/5 dark:bg-bg3">
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-start justify-start gap-1">
                            BRANCH NAME
                        </div>
                    </th>
                    <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                        <div class="flex items-center justify-center gap-1">
                            BRANCH CODE
                        </div>
                    </th>
                    <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                        <div class="flex items-center justify-center gap-1">
                            CITY
                        </div>
                    </th>
                    <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                        <div class="flex items-center justify-center gap-1">
                            STATE
                        </div>
                    </th>
                    <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                        <div class="flex items-center justify-center gap-1">
                            OPENING DATE
                        </div>
                    </th>
                    <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                        <div class="flex items-center justify-center gap-1  text-center">
                            CUSTOMERS
                        </div>
                    </th>
                    <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                        <div class="   flex items-center justify-center gap-1">
                            IS ACTIVE
                        </div>
                    </th>
                    <th class="text-center justify-center !py-5" data-sortable="false">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($branches as $branch)
                <tr class=" dark:even:bg-bg3  border-b">
                    <td class="px-4 py-5 text-start">
                        <div class="px-4">
                            <a href="{{ $branch?->id ? route('branch.show', base64_encode($branch->id)) : '#' }}"
                                class="text-primary hover:underline">
                                <p class="mb-1 font-medium">{{ $branch?->branch_name ?? '' }}</p>
                            </a>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-start">
                        {{ $branch?->branch_code ?? '' }}
                    </td>
                    <td class="px-6 py-5 text-center">{{ $branch?->city ?? '' }}</td>
                    <td class="px-6 py-5 text-center">{{ $branch->State?->name ?? '' }}</td>
                    <td class="px-6 py-5 text-center">
                        {{ $branch->open_date ? \Carbon\Carbon::parse($branch->open_date)->format('d-m-Y') : '' }}

                    </td>
                    <td class="px-7 py-5 text-center">{{ $branch->Member->count() }}</td>
                    <td class="px-6 py-5  text-center">
                        {{-- @if ($branch->active == 'Yes')
                        <span
                            class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2  text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            Yes
                        </span>
                        @else
                        <span
                            class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            {{ $branch->active }}

                        </span>
                        @endif --}}

                        <div class="p-4 overflow-x-auto">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox"
                                        class=" sr-only slider-toggle"
                                        data-id="{{ $branch->id }}"
                                        {{ $branch->active === 'Yes' ? 'checked' : '' }}>
                                    {{-- <input type="checkbox"
                                        class="sr-only slider-toggle"
                                        data-id="{{ $branch->id }}"
                                        {{ $branch->active === 'Yes' ? 'checked' : '' }}> --}}
                                    
                                    <div class="relative">
                                        <div class="blocks"></div>
                                        <div class="dot"></div>
                                    </div>
                            </label>
                        </div>
                    </td>
                    <td class="px-6 py-2  text-center">
                        <div class="flex justify-center">
                            @include('partials._vertical-options', [
                            'id' => base64_encode($branch->id),
                            'viewRoute' => 'branch.show',
                            'editRoute' => 'branch.edit',
                            'deleteRoute' => 'branch.destroy'
                            ])
                        </div>
                    </td>
                    
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-4 text-gray-500">No record found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($branches->lastPage() > 1)
    <div class="flex flex-wrap items-center justify-center col-span-12 gap-4 sm:justify-between">
        <ul class="flex flex-wrap items-center gap-2 md:gap-3 md:font-semibold">

            {{-- Previous Page Link --}}
            @if ($branches->onFirstPage())
            <li>
                <button
                    class="flex items-center justify-center w-8 h-8 text-gray-400 border border-gray-300 rounded-full md:w-10 md:h-10"
                    disabled>
                    <i class="text-lg las la-angle-left"></i>
                </button>
            </li>
            @else
            <li>
                <a href="{{ $branches->previousPageUrl() }}"
                    class="flex items-center justify-center w-8 h-8 duration-300 border rounded-full hover:bg-primary text-primary rtl:rotate-180 hover:text-n0 md:w-10 md:h-10 border-primary">
                    <i class="text-lg las la-angle-left"></i>
                </a>
            </li>
            @endif

            {{-- Page Number Links --}}
            @for ($i = 1; $i <= $branches->lastPage(); $i++)
                @if ($i == $branches->currentPage())
                <li>
                    <button
                        class="flex items-center justify-center w-8 h-8 duration-300 border rounded-full hover:bg-primary text-n0 bg-primary hover:text-n0 md:w-10 md:h-10 border-primary">
                        {{ $i }}
                    </button>
                </li>
                @else
                <li>
                    <a href="{{ $branches->url($i) }}"
                        class="flex items-center justify-center w-8 h-8 duration-300 border rounded-full hover:bg-primary text-primary hover:text-n0 md:w-10 md:h-10 border-primary">
                        {{ $i }}
                    </a>
                </li>
                @endif
                @endfor

                {{-- Next Page Link --}}
                @if ($branches->hasMorePages())
                <li>
                    <a href="{{ $branches->nextPageUrl() }}"
                        class="flex items-center justify-center w-8 h-8 duration-300 border rounded-full hover:bg-primary text-primary hover:text-n0 rtl:rotate-180 md:w-10 md:h-10 border-primary">
                        <i class="text-lg las la-angle-right"></i>
                    </a>
                </li>
                @else
                <li>
                    <button
                        class="flex items-center justify-center w-8 h-8 text-gray-400 border border-gray-300 rounded-full md:w-10 md:h-10"
                        disabled>
                        <i class="text-lg las la-angle-right"></i>
                    </button>
                </li>
                @endif

        </ul>
    </div>
    @endif
</div>

<script>
document.addEventListener('change', function(e){

    if(!e.target.classList.contains('slider-toggle')) return;

    let checkbox = e.target;
    let id = checkbox.dataset.id;

    fetch("{{ route('branch.toggle.status') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ id:id })
    })
    .then(res => res.json())
    .then(res => {
        if(!res.success){
            checkbox.checked = !checkbox.checked;
            alert("Update failed");
        }
    })
    .catch(err => {
        checkbox.checked = !checkbox.checked;
        alert("Server error");
    });

});
</script>

{{-- <script>
    // Label update on toggle
            document.querySelectorAll('.slider-toggle').forEach(toggle => {
                toggle.addEventListener('change', function () {
                    const label = document.getElementById(this.dataset.labelId);
                    label.textContent = this.checked ? 'ON' : 'OFF';
                });

                // Initialize label on page load
                toggle.dispatchEvent(new Event('change'));
            });
</script> --}}
@endsection