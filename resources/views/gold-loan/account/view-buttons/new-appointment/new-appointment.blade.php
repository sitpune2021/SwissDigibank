@extends('layout.main')
@section('content')
    <div class="main-inner">
        <div class="mb-4 flex flex-wrap items-center justify-between gap-4 lg:mb-4">
            <div class="flex items-start flex-col gap-2">
                <h3 class="uppercase font-semibold">Gold Loan - 00063 - New Appointment</h3>
                <p class="text-gray-500">
                    <a href="#" class="text-gray-500 text-sm">Gold Loan</a> >
                    <a href="#" class="text-gray-500 text-sm">00063 </a>>
                    <a href="#" class="text-gray-500 text-sm"> New Appointment </a>
                </p>
            </div>
        </div>
        <div class="flex flex-col  dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <div class=" w-full  box overflow-hidden">
                <div class="">
                    <h3> APPOINTMENT INFO</h3>
                </div>
                <hr>
                <form action="">
                    <div class="col-span-2 md:col-span-1 mt-5 mb-2 ">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                            Associate/ Staff/ User
                            <span class="text-red-500">*</span>
                        </label>
 
                        <select name="" id="" placeholder="0.0"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Advisor/ Staff</option>
 
                        </select>
 
 
 
                    </div>
                    <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                            Subject
                            <span class="text-red-500">*</span>
                        </label>
 
                        <input type="text" name="" id="" placeholder="Enter Subject Here"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
 
 
                    </div>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-2">
                            Description
                            <span class="text-red-500">*</span>
                        </label>
                        <textarea name="" id=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Description Here"></textarea>
 
                    </div>
 
                    <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                            Meeting Date & Time <span class="text-error"> * </span>
                        </label>
                        <div class="flex gap-3">
                            <input type="text" name="datepicker-appointment"
                                class="datepicker-appointment w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
 
                            <div class="relative w-48">
                                <input type="time"  placeholder="HH:MM"
                                    class="timepicker-appointment w-24 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            </div>
                        </div>
                    </div>
 
                    <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                            Appointment Settings
 
                        </label>
                        <div class="flex gap-3">
 
                            <table class="w-full  rounded-lg ">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Repeat Value
                                        </th>
                                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Repeat Type
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="">
                                        <td class="px-4 py-2 text-center">
                                            <input type="text" name="repeat_count" id="repeat_count" placeholder="0.0"
                                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <select name="repeat_type" id="repeat_type"
                                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                                <option value="">Select Type</option>
                                                <option value="" >MONTHLY</option>
                                                <option value="">QAURTERLY</option>
                                                <option value="">HALF_YEARLY</option>
                                                <option value="">YEARLY</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
 
 
                        </div>
 
 
                    </div>
 
                    <div class="col-span-2 md:col-span-1 mt-8 mb-2">
                        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                            <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                                Submit
                            </button>
 
 
                        </div>
                    </div>
                </form>
            </div>
 
 
            <div class=" w-full  overflow-hidden">
 
            </div>
 
        </div>
 
    </div>
 
 
    <script>
        function toggleSection(button) {
            const section = button.closest('.box').querySelector('.overflow-x-auto');
            const icon = button.querySelector('.toggle-icon');
            section.classList.toggle('hidden');
            icon.textContent = section.classList.contains('hidden') ? '+' : '−';
        }
    </script>
 
    <!-- Datepicker CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">
 
<!-- Datepicker JS -->
<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
 
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.datepicker-appointment').forEach(function(dateInput) {
            const today = new Date();
            const yesterday = new Date();
            yesterday.setDate(today.getDate() - 1);
 
            const formattedToday = today.toLocaleDateString('en-GB').split('/').join('-');
            const formattedYesterday = yesterday.toLocaleDateString('en-GB').split('/').join('-');
 
            // Default fill today's date
            dateInput.value = formattedToday;
 
            // Init datepicker
            const picker = new Datepicker(dateInput, {
                autohide: true,
                format: 'dd-mm-yyyy',
 
            });
 
            // Correct way: listen on parent of input
            dateInput.parentElement.addEventListener('changeDate', function(e) {
                const selected = e.detail.date; // <-- get selected date
                const selectedFormatted = selected.toLocaleDateString('en-GB').split('/').join('-');
                const note = document.getElementById("noteMessage");
 
                if (selectedFormatted === formattedYesterday) {
                    note.classList.remove("hidden");
                } else {
                    note.classList.add("hidden");
                }
            });
        });
    });
</script>
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
 
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
 
<script>
    document.addEventListener("DOMContentLoaded", function () {
        flatpickr(".timepicker-appointment", {
            enableTime: true,
            noCalendar: true,         
            dateFormat: "h:i K",      
            time_24hr: false,       
            defaultDate: new Date(), 
        });
    });
</script>
 
 
 
@endsection