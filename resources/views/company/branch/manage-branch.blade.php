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

@section('content')

<div class="col-span-12 box lg:col-span-6">

    <div class="mb-2">
        <x-searchbox />
    </div>

    @include('fields.errormessage')

    <div class="mt-2 overflow-x-auto">

        <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">

            <thead class="bg-gray-100 dark:bg-bg3 sticky top-0" style="background-color: bisque;">
                <tr class="text-gray-700 dark:text-gray-200 text-sm font-semibold uppercase tracking-wider">

                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-start justify-start gap-1">
                            BRANCH NAME
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
                            OPENED ON
                        </div>
                    </th>
                    <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                        <div class="flex items-center justify-center gap-1  text-center">
                            CUSTOMERS
                        </div>
                    </th>
                    <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                        <div class="   flex items-center justify-center gap-1">
                            Status
                        </div>
                    </th>
                    <th class="text-center justify-center !py-5" data-sortable="false">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($branches as $branch)
                <tr class="table-row dark:even:bg-bg3 border-b hover:bg-gray-50 dark:hover:bg-bg3"
                    style="animation-delay: {{ $loop->index * 0.05 }}s">

                    <td class="px-6 py-4 text-left">

                        <div class="flex items-center gap-3">

                        <div class="w-9 h-9 flex items-center justify-center bg-primary/10 rounded-lg">
                        <i class="las la-building text-primary"></i>
                        </div>

                        <div>
                        <a href="{{ $branch?->id ? route('branch.show', base64_encode($branch->id)) : '#' }}"
                        class="font-semibold text-primary hover:underline">
                        {{ $branch?->branch_name ?? '' }}
                        </a>

                        <p class="text-xs text-gray-500">
                        Branch Code: {{ $branch?->branch_code ?? '' }}
                        </p>
                        </div>

                        </div>

                    </td>
                   
                    <td class="px-6 py-5 text-center">{{ $branch?->city ?? '' }}</td>

                    <td class="px-6 py-5 text-center">{{ $branch->State?->name ?? '' }}</td>

                    <td class="px-6 py-5 text-center">

                        {{ $branch->open_date ? \Carbon\Carbon::parse($branch->open_date)->format('d-m-Y') : '' }}

                    </td>

                    <td class="px-6 py-4 text-center">

                        <span class="px-3 py-1 text-sm font-medium bg-blue-100 text-blue-700 rounded-full">
                        {{ $branch->Member->count() }}
                        </span>

                    </td>

                    <td class="px-6 py-4 text-center">

                        <div class="flex justify-center">

                        <label class="inline-flex items-center cursor-pointer">

                        <input type="checkbox"
                        class="sr-only slider-toggle"
                        data-id="{{ $branch->id }}"
                        {{ $branch->active === 'Yes' ? 'checked' : '' }}>

                        <div class="relative">
                        <div class="blocks"></div>
                        <div class="dot"></div>
                        </div>

                        </label>

                        </div>

                    </td>

                    <td class="px-6 py-2  text-left">
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

    <div class="mt-4">
        <x-pagination :paginator="$branches"/>
    </div>

</div>


<script>
    document.addEventListener('change', function(e)
    {

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

@endsection