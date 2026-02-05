@extends('layout.main')

<style>
    .breadcrumb {
        list-style: none;
        display: flex;
        padding: 0;
        margin-bottom: 1rem;
        font-size: 14px;
    }

    .breadcrumb li+li::before {
        content: "/";
        padding: 0 8px;
        color: #888;
    }

    .breadcrumb li a {
        text-decoration: none;
        color: #007bff;
    }

    .breadcrumb li.active {
        color: #555;
    }

    .custom-thead {
        background-color: #e6f4ea;
        color: #14532d;
    }

    .custom-thead th {
        font-weight: 600;
        border-bottom: 1px solid #ccc;
    }

    @media (prefers-color-scheme: dark) {
        .custom-thead {
            background-color: #14532d;
            color: #d1fae5;
        }
    }

    .bg-greens {
        background-color: #14532d;
    }
</style>

@section('content')

<div class="main-inner">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-lg block  uppercase  font-bold">
                Add New Locker
            </h3>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

            <div class=" col-span-2 box md:col-span-1 ">

                <form action="{{ $locker ? route('lockers.locker-list.update', $locker->id) : route('lockers.locker-list.store') }}" method="POST">
                    @csrf

                    <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                        <label class="md:text-lg font-medium block mb-2 uppercase">Branch <span class="text-red-500">*</span></label>

                        <select name="branch_id" id="branch_id" class="scheme-select w-full text-sm bg-secondary/5 border rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Branch</option>
                            @foreach($branch as $b)
                                <option value="{{ $b->id }}" {{ $locker && $locker->branch_id == $b->id ? 'selected' : '' }}>
                                    {{ $b->branch_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                        <label class="md:text-lg font-medium block mb-2 uppercase">Locker No <span class="text-red-500">*</span></label>
                        <input type="text" name="locker_no" value="{{ $locker->locker_no ?? '' }}"
                            class="w-full text-sm bg-secondary/5 border rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Locker No">
                        @error('locker_no') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                        <label class="md:text-lg font-medium block mb-2 uppercase">Locker Name <span class="text-red-500">*</span></label>
                        <input type="text" name="locker_name" value="{{ $locker->locker_name ?? '' }}"
                            class="w-full text-sm bg-secondary/5 border rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Locker Name">
                        @error('locker_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                        <label class="md:text-lg font-medium block mb-2 uppercase">Charges (Monthly) <span class="text-red-500">*</span></label>
                        <input type="number" name="monthly_charges" value="{{ $locker->monthly_charges ?? '' }}"
                            class="w-full text-sm bg-secondary/5 border rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Locker Charges">
                        @error('monthly_charges') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                        <div class="flex justify-center gap-3 mt-5">
                            <div>
                                <button class="btn-primary uppercase" type="submit">
                                    {{ $locker ? 'Update Locker' : 'Add Locker' }}
                                </button>
                            </div>

                            <div>
                                <a href="{{ route('lockers.locker-list.index') }}" class="btn-outline uppercase">BACK</a>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        
        </div>


@endsection