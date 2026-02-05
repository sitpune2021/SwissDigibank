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
               Release Locker
            </h3>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

            <div class=" col-span-2 box md:col-span-1 ">
                
                <form action="{{ route('lockers.locker-list.release.store', $locker->id) }}" method="POST">
                    @csrf

                    <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                        <label class="md:text-lg font-medium block mb-2 uppercase">
                        End Date <span class="text-red-500">*</span>
                        </label>

                        <input type="text" name="end_date" id="dates" placeholder="DD/MM/YYYY"
                            class="datepicker-field scheme-select w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        
                        @error('end_date')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-center gap-3">
                        <button class="btn-primary uppercase">Release Locker</button>
                        <a href="{{ route('lockers.locker-list.index') }}" class="btn-outline uppercase">Back</a>
                    </div>

                </form>

            </div>

            <div class=" col-span-2 box md:col-span-1 ">
                <div class="bg-secondary/5 rounded-10  px-5 py-3">
                    <h3 class="text-lg font-semibold uppercase tracking-wide">
                      Member Locker Info
                    </h3>
                </div>
                <div class="bg-white dark:bg-gray-900">
                    <div class="overflow-x-auto whitespace-nowrap">
                    <table class="w-full  text-sm md:text-base">
                        <tbody class="divide-y divide-gray-200">
                            <tr class="bg-gray-50 border-b ">
                                <td class="font-semibold uppercase p-3 w-1/2">Locker No</td>
                                <td class="p-3">{{ $locker->locker_no }}</td>
                            </tr>
                            <tr class="bg-gray-50 uppercase border-b ">
                                <td class="font-semibold p-3">Locker Name</td>
                                <td class="p-3">{{ $locker->locker_name }}</td>
                            </tr>
                            <tr class="bg-gray-50 uppercase border-b ">
                                <td class="font-semibold p-3">Member Name</td>
                                <td class="p-3">{{ $notReleasedName }}</td>
                            </tr>
                            <tr class="bg-gray-50 uppercase border-b ">
                                <td class="font-semibold p-3">Locker Charge	</td>
                                <td class="p-3">{{ number_format($locker->monthly_charges, 2) }}</td>
                            </tr>
                            <tr class="bg-gray-50 border-b ">
                                <td class="font-semibold uppercase p-3">
                                    Assigned Date	
                                </td>
                                <td class="p-3">{{ $notReleasedAssignDate }}</td>
                            </tr>
                            <tr class="bg-gray-50 border-b ">
                                <td class="font-semibold uppercase p-3">
                                    Release Date	
                                </td>
                                <td class="p-3">{{ $notReleasedReleaseDate }}</td>
                            </tr>
                             <tr class="bg-gray-50 border-b ">
                                <td class="font-semibold uppercase p-3">
                                    Locker Assigned		
                                </td>
                               <td class="text-start !py-5 px-6">
                                    @if($locker->assigned == 1)
                                        <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary">
                                            Yes
                                        </span>
                                    @else
                                        <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error">
                                            No
                                        </span>
                                    @endif
                                </td>       
                            </tr>
                            
                        </tbody>
                    </table>
                    </div>
                </div>  
            </div>
        </div>


<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css"
/>

<!-- Datepicker JS -->
<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".datepicker-field").forEach(function (dateInput) {
        const today = new Date();
        const picker = new Datepicker(dateInput, {
            autohide: true,
            format: "dd-mm-yyyy",
            minDate: today, // Prevent selecting earlier dates
            maxDate: today, // Prevent selecting future dates
        });

        // Set today's date if empty
        if (!dateInput.value) {
            const formattedDate = today
                .toLocaleDateString("en-GB")
                .split("/")
                .join("-");
            dateInput.value = formattedDate;
        }

        // Calendar icon click opens picker
        const calendarIcon = dateInput.parentElement.querySelector(".la-calendar");
        if (calendarIcon) {
            calendarIcon.addEventListener("click", () => picker.show());
        }
    });
});
</script>


@endsection