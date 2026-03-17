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
                EDIT LEDGER - Agent Registration Fee
            </h3>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <!-- Left: Details -->
            <div class=" w-full overflow-x-auto   overflow-hidden">
                <div class="overflow-x-auto box rounded-lg dark:bg-bg3 p-2 bg-white shadow-md">
                    <div class="min-w-full p-4">
                       <form action="{{ route('ledger.update', $ledger->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                            
                            <div>
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase">
                                    Ledger Type
                                    <span class="text-red-500">*</span>
                                </label>
                                {{-- Type --}}
                                <select name="type" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    <option value="Asset" {{ $ledger->type=='Asset'?'selected':'' }}>Asset</option>
                                    <option value="Liability" {{ $ledger->type=='Liability'?'selected':'' }}>Liability</option>
                                </select>
                            </div>
                            <div>
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Ledger Group <span class="text-red-500">*</span>
                                </label>                               
                                <select name="group_id" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}"
                                            {{ $ledger->group_id == $group->id ? 'selected' : '' }}>
                                            {{ $group->display_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Display Name
                                    <span class="text-red-500">*</span>
                                </label>
                                {{-- Display Name --}}
                                <input type="text" name="display_name" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                    value="{{ old('display_name', $ledger->display_name) }}">
                                @error('display_name')
                                    <p class="text-red-500">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-primary mt-1">
                                    (e.g. Accumulated Depreciation - Vehicles)
                                </p>
                            </div>

                             {{-- System Name --}}
                            <div>
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    System Name
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="" name="system_name"  value="{{ old('system_name', $ledger->system_name) }}"
                                     placeholder="Enter Ledger Name"
                                     class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"  />                              
                                    @error('system_name')
                                        <p class="text-red-500">{{ $message }}</p>
                                    @enderror
                                     <p class="text-xs text-primary mt-1">
                                    (e.g. Accumulated Depreciation - Vehicles)
                                </p>
                            </div>

                            <!-- Code -->
                            <!-- <div>
                               <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Code 
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="" name=""
                                   readonly  placeholder="Enter Code"
                                   class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize" />
                                <p class="text-xs text-primary mt-1">
                                    (e.g. 501, XYZ)
                                </p>
                            </div> -->

                            <!-- Risk Percent -->
                            <!-- <div id="risk-col">
                               <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Risk Percent (%) 
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="number"  id=""
                                    name="" placeholder="Enter Risk Percent"
                                   class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize" />
                                <p class="text-xs text-primary mt-1">(e.g. 0 to 200)</p>
                            </div> -->

                            <div>
                                <label class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Is Bank Account
                                </label>

                                <div class="flex gap-6">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="is_bank_acc" value="1"
                                            {{ old('is_bank_acc', $ledger->is_bank_acc) == 1 ? 'checked' : '' }}>
                                        <span>Yes</span>
                                    </label>

                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="is_bank_acc" value="0"
                                            {{ old('is_bank_acc', $ledger->is_bank_acc) == 0 ? 'checked' : '' }}>
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>

                            
                            <div>
                                <label class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Show In Day Book
                                </label>

                                <div class="flex gap-6">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="show_in_day" value="1"
                                            {{ old('show_in_day', $ledger->show_in_day) == 1 ? 'checked' : '' }}>
                                        <span>Yes</span>
                                    </label>

                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="show_in_day" value="0"
                                            {{ old('show_in_day', $ledger->show_in_day) == 0 ? 'checked' : '' }}>
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex flex-wrap gap-3 justify-center pt-4">
                                <button type="submit"
                                    class="btn-primary uppercase">
                                    UPDATE ACCOUNT
                                </button>
                                <a href=""
                                    class="btn-outline uppercase">
                                    BAck
                                </a>
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