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

    input[type="checkbox"] {
        width: 28px;
        height: 28px;
        accent-color: green;
        /* For modern browsers */
    }

    input[type="radio"] {
        width: 28px;
        height: 28px;
        accent-color: green;
        /* For modern browsers */
    }

    .bg-greens {
        background-color: #14532d;
    }
</style>

@section('content')

    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-start gap-3 mb-6 px-4 lg:mb-8">
            <h3 class="flex text-xl block  uppercase font-semibold">
                Add New Rank
            </h3>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <!-- Left: Details -->
            <div class=" w-full overflow-x-auto   overflow-hidden">
                <div class="overflow-x-auto box rounded-lg dark:bg-bg3 p-2 bg-white shadow-md">
                    <div class="min-w-full p-4">

                        <form action="{{ $rank ? route('associates-advisor.rank-structure.update', $rank->id) 
                            : route('associates-advisor.rank-structure.store') }}" 
                            method="POST">
                            @csrf

                            {{-- Rank Name --}}
                            <div>
                                <label class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Rank Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name"
                                    value="{{ old('name', $rank->name ?? '') }}"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                    placeholder="Enter Rank Name">
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Rank Display Position --}}
                            <div>
                                <label class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Rank Display Position <span class="text-red-500">*</span>
                                </label>

                                <select name="display_position"
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Select Display Position</option>

                                    @foreach([16,17,18,19,20] as $pos)
                                        <option value="{{ $pos }}" {{ old('display_position', $rank->display_position ?? '') == $pos ? 'selected' : '' }}>
                                            {{ $pos }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('display_position') 
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                                @enderror
                            </div>

                            {{-- Rank Working Position --}}
                            <div>
                                <label class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Rank Working Position <span class="text-red-500">*</span>
                                </label>

                                <select name="working_position"
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Select Position</option>

                                    @foreach([1,17,18,19,20] as $pos)
                                        <option value="{{ $pos }}"
                                            {{ old('working_position', $rank->working_position ?? '') == $pos ? 'selected' : '' }}>
                                            {{ $pos }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-primary mt-1">
                                    Top Level (1 - Manager) & Bottom (20 - Field Officer)
                                </p>
                                @error('working_position') 
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                                @enderror
                            </div>

                            {{-- Collection Charge Commission --}}
                            <div>
                                <label class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Collection Charge Commission <span class="text-error">*</span>
                                </label>
                                <div class="flex gap-6">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="collection_commission" value="1"
                                            {{ old('collection_commission', $rank->collection_commission ?? 1) == 1 ? 'checked' : '' }}>
                                        <span>Yes</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="collection_commission" value="0"
                                            {{ old('collection_commission', $rank->collection_commission ?? '') == 0 ? 'checked' : '' }}>
                                        <span>No</span>
                                    </label>
                                </div>
                                @error('collection_commission') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Buttons --}}
                            <div class="flex flex-wrap gap-3 justify-center pt-4">
                                <button type="submit" class="btn-primary uppercase">
                                    {{ $rank ? 'UPDATE RANK' : 'ADD RANK' }}
                                </button>
                                <a href="{{ route('associates-advisor.rank-structure.index') }}" class="btn-outline uppercase">Back</a>
                            </div>

                        </form>

                    </div>
                </div>

            </div>

            <!-- Right: Settings -->
            <div class=" w-full overflow-x-auto "></div>
        </div>
    </div>



    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

    <!-- Datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const datepickers = document.querySelectorAll('.datepicker-field');

            datepickers.forEach(function (dateInput, index) {
                // Create the datepicker with maxDate = today
                const picker = new Datepicker(dateInput, {
                    autohide: true,
                    format: 'dd-mm-yyyy',
                    maxDate: new Date(),
                });

                // Determine which default date to set
                let defaultDate;
                const today = new Date();

                if (index === 0) {
                    // First datepicker → first day of this month
                    defaultDate = new Date(today.getFullYear(), today.getMonth(), 1);
                } else {
                    // Second datepicker → today's date
                    defaultDate = today;
                }

                // Format as dd-mm-yyyy
                const formattedDate = defaultDate.toLocaleDateString('en-GB').split('/').join('-');
                dateInput.value = formattedDate;

                // If there’s a calendar icon near the field, make it open the picker
                const calendarIcon = dateInput.parentElement.querySelector('.la-calendar');
                if (calendarIcon) {
                    calendarIcon.addEventListener('click', () => picker.show());
                }
            });
        });
    </script>
@endsection