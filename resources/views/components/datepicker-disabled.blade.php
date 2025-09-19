<div>
    <label class="block mb-2 font-medium md:text-lg">
        {{ $label ?? 'Date' }} <span class="text-red-500">*</span>
    </label>
    <div class="relative">
        <input
            type="text"
            id="{{ $inputId ?? 'date_pass' }}"
            name="{{ $name ?? 'issue_date' }}"
            value="{{ $value ?? '' }}"
            class="datepicker-field w-full px-3 py-2.5 block text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3 pr-10"
            readonly
        />
        {{-- Optional calendar icon --}}
        {{-- <i class="la la-calendar absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer block"></i> --}}
    </div>
    @error($name ?? 'issue_date')
        <span class="text-error text-sm">{{ $message }}</span>
    @enderror
</div>
<!-- Datepicker CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

<!-- Datepicker JS -->
<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.datepicker-field').forEach(function(dateInput) {
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

