@extends('layout.main')

@section('content')

    <style>
        input[type="checkbox"] {
            width: 28px;
            height: 28px;
            accent-color: green;
            /* For modern browsers */
        }

        /* Fallback for browsers without accent-color support */
        input[type="checkbox"]:checked {
            background-color: green;
            border: none;
        }

        input[type="radio"] {
            width: 24px;
            height: 24px;
            accent-color: green;
            /* Modern browser support */
        }
    </style>

    <div class="main-inner">

        <div class=" flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col  gap-2">
                <div class="flex items-center gap-3">
                    <h1 class="text-lg px-6 font-semibold uppercase">
                        UPDATE SOFTWARE ALERTS
                    </h1>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 p-6 min-h-screen md-4">
          
            <div class="col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6">
            <div class=" mb-3 text-lg border-b uppercase font-semibold">
                Update Balance Alerts
            </div>
             <div class=" mb-3 mt-5 text-lg border-b uppercase font-semibold">
               SMS
            </div>
                <form id="" >

                    <!-- Low Balance Alert -->
                    <div class="mb-4">
                        <label for="" class="block font-medium mb-2">
                            Low Balance Alert
                            <p class="text-sm text-error">(set minimum amount for alerts. eg. 5000)</p>
                        </label>
                        <input type="number" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                        
                    </div>
                    @error('branch_id')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Alert Mob No. -->
                    <div class="mb-4">
                        <label for="" class="block font-medium mb-2">
                            Alert Mob No.
                            <p class="text-sm text-error">
                                (enter comma separated mobile numbers eg. 8745123512, 4785632142)
                            </p>
                        </label>
                        <textarea  name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"></textarea>
                        
                    </div>
                    @error('branch_id')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div class=" mb-3 mt-5 text-lg border-b uppercase font-semibold">
              MOBILE RECHARGE
            </div>
            
                    <!-- Alert Mob No. -->
                    <div class="mb-4">
                        <label for="" class="block font-medium mb-2">
                            Low Balance Alert
                            <p class="text-sm text-error">
                                (set minimum amount for alerts.eg.5000)
                            </p>
                        </label>
                        <input type="number"  name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                        
                    </div>
                    @error('branch_id')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                     <!-- Alert Mob No. -->
                    <div class="mb-4">
                        <label for="" class="block font-medium mb-2">
                            Alert Mob No.
                            <p class="text-sm text-error">
                                (enter comma separated mobile numbers eg. 8745123512, 4785632142)
                            </p>
                        </label>
                        <textarea  name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"></textarea>
                        
                    </div>
                    @error('branch_id')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <!-- Buttons -->
                    <div class="flex justify-center mt-8 gap-4 pt-6">
                        <button type="submit" class="btn-primary uppercase">
                            Update
                        </button>
                        <a href="{{ route('software-settings.software-alerts.software-alerts') }}" class="btn-outline uppercase">Back</a>
                    </div>
  
                </form>
            </div>



        </div>
    </div>
    </div>


    <!-- Datepicker CSS -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

    <!-- Datepicker JS -->

    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.datepicker-field').forEach(function (dateInput) {
                const picker = new Datepicker(dateInput, {
                    autohide: true,
                    format: 'dd-mm-yyyy',
                    maxDate: new Date(),
                });

                if (!dateInput.value) {
                    const today = new Date();
                    const formattedDate = today.toLocaleDateString('en-GB').split('/').join('-');
                    dateInput.value = formattedDate;
                }

                const calendarIcon = dateInput.parentElement.querySelector('.la-calendar');
                if (calendarIcon) {
                    calendarIcon.addEventListener('click', () => picker.show());
                }
            });
        });
    </script>


    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

    <!-- Datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const today = new Date();

            document.querySelectorAll('.datepicker-future').forEach(function (input) {
                new Datepicker(input, {
                    autohide: true,
                    format: 'dd-mm-yyyy',
                    startDate: today, // disable past dates
                });

                // ✅ DO NOT override edit value
                if (!input.value) {
                    const dd = String(today.getDate()).padStart(2, '0');
                    const mm = String(today.getMonth() + 1).padStart(2, '0');
                    const yyyy = today.getFullYear();
                    input.value = dd + '-' + mm + '-' + yyyy;
                }
            });
        });
    </script>



@endsection