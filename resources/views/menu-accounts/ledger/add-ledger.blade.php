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
            <h3 class="flex text-lg block  uppercase font-semibold">
                ADD LEDGER
            </h3>
        </div>

         <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">

      <div class=" w-full overflow-x-auto   overflow-hidden">
                <div class="overflow-x-auto box rounded-lg dark:bg-bg3 p-2 bg-white shadow-md">
                    <div class="min-w-full p-4">

                        {{-- FORM START --}}
                        <form action="{{ route('ledger.store') }}" method="POST" class="space-y-8">
                            @csrf

                            {{-- GRID --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                {{-- Ledger Type --}}
                                <div>
                                    <label class="block text-sm font-semibold mb-2 uppercase">
                                        Ledger Type <span class="text-red-500">*</span>
                                    </label>

                                    <select name="type" 
                                        class="w-full border rounded-10 px-3 py-2  text-sm bg-secondary/5  dark:bg-bg3">
                                        <option value="">Select Type</option>
                                        <option value="Asset">Asset</option>
                                        <option value="Liability">Liability</option>
                                        <option value="Equity">Equity</option>
                                        <option value="Expense">Expense</option>
                                        <option value="Revenue">Revenue</option>
                                    </select>
                                </div>


                                {{-- Ledger Group --}}
                                <div>
                                    <label class="block text-sm font-semibold mb-2 uppercase">
                                        Ledger Group <span class="text-red-500">*</span>
                                    </label>

                                    <select name="group_id" id="group_id" 
                                        class="w-full border rounded-10 px-3 py-2  text-sm bg-secondary/5  dark:bg-bg3">

                                        <option value="">Select Group</option>

                                    </select>

                                </div>


                                {{-- Display Name --}}
                                <div>
                                    <label class="block text-sm font-semibold mb-2 uppercase">
                                        Display Name <span class="text-red-500">*</span>
                                    </label>

                                    <input type="text" name="display_name" 
                                        placeholder="Enter Ledger Display Name"
                                        class="w-full border rounded-10 px-3 py-2  text-sm bg-secondary/5  dark:bg-bg3">
                                </div>


                                {{-- System Name --}}
                                <div>
                                    <label class="block text-sm font-semibold mb-2 uppercase">
                                        System Name <span class="text-red-500">*</span>
                                    </label>

                                    <input type="text" name="system_name" 
                                        placeholder="Enter System Name"
                                        class="w-full border rounded-10 px-3 py-2  text-sm bg-secondary/5  dark:bg-bg3">
                                </div>


                                {{-- Code --}}
                                <div>
                                    <label class="block text-sm font-semibold mb-2 uppercase">
                                        Code <span class="text-red-500">*</span>
                                    </label>

                                    <input type="text" name="code" 
                                        style="text-transform: uppercase"
                                        placeholder="Ex: 501"
                                        class="w-full border rounded-10 px-3 py-2  text-sm bg-secondary/5  dark:bg-bg3">
                                </div>


                                {{-- Empty space for alignment --}}
                                <div></div>


                                {{-- ===== RADIO SECTION ===== --}}
                                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8">

                                    {{-- Is Bank Account --}}
                                    <div>
                                        <label class="block text-sm font-semibold mb-3 uppercase">
                                            Is Bank Account
                                        </label>

                                        <div class="flex gap-2 ">

                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="is_bank_acc" value="1"
                                                    class="h-4 w-4 text-indigo-600">
                                                <span>Yes</span>
                                            </label>

                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="is_bank_acc" value="0" checked
                                                    class="h-4 w-4 text-indigo-600">
                                                <span>No</span>
                                            </label>

                                        </div>
                                    </div>


                                    {{-- Show In Day Book --}}
                                    <div class="mt-4">
                                        <label class="block text-sm font-semibold mb-3 uppercase">
                                            Show In Day Book
                                        </label>

                                        <div class="flex gap-2">

                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="show_in_day" value="1"
                                                    class="h-4 w-4 text-indigo-600">
                                                <span>Yes</span>
                                            </label>

                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="show_in_day" value="0" checked
                                                    class="h-4 w-4 text-indigo-600">
                                                <span>No</span>
                                            </label>

                                        </div>
                                    </div>

                                </div>

                            </div>
                            {{-- GRID END --}}



                            {{-- BUTTONS --}}
                            <div class="flex justify-center gap-4 pt-6 mt-5">

                                <button type="submit"
                                    class="  uppercase btn-primary">
                                    Add Account
                                </button>

                                <a href="{{ route('ledger.index') }}"
                                    class="uppercase btn-outline">
                                    Back
                                </a>

                            </div>

                        </form>
                        {{-- FORM END --}}

                    </div>
                </div>
            </div>
            <div class="w-full overflow-x-auto   overflow-hidden"></div>

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


<script>
document.querySelector('select[name="type"]').addEventListener('change', function () {

    let type = this.value;
    let groupSelect = document.getElementById('group_id');

    groupSelect.innerHTML = '<option value="">Loading...</option>';

    if (!type) {
        groupSelect.innerHTML = '<option value="">Select Group</option>';
        return;
    }

    fetch("{{ route('ledger.groups.by.type', '') }}/" + type)
        .then(res => res.json())
        .then(data => {

            groupSelect.innerHTML = '<option value="">Select Group</option>';

            data.forEach(group => {
                groupSelect.innerHTML += `<option value="${group.id}">${group.display_name}</option>`;
            });

        })
        .catch(err => {
            console.error(err);
            groupSelect.innerHTML = '<option value="">Error loading groups</option>';
        });
});
</script>



@endsection