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

    .tableWidth {
        width: 90%;
        margin: auto;
    }

    .bg-yellow {
        background-color: #e17100;
    }
</style>

@section('content')
    <div class="main-inner">
        
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-center flex-row gap-2">
                <h3 class="text-xl uppercase font-semibold">
                    {{ $distributor->distributor_name }}
                </h3>
                <p class="text-xs text-gray-500">
                    Vehicle Lona Distributor
                </p>
            </div>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">

            <!-- Left: Details -->
            <div class=" w-full  overflow-hidden ">
                <div class="overflow-x-auto box rounded-lg dark:bg-bg3 p-2 bg-white shadow-md">

                    <table class="w-full text-sm text-left border-collapse whitespace-nowrap">
                        
                        <tbody class="divide-y divide-gray-200">

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2 w-1/3" colspan="2">
                                    <div class="flex justify-end gap-2 p-3">
                                        <a href="{{ route('edit', $distributor->id) }}" class="p-2 text-sm rounded-10 btn-primary">
                                            <i class="las la-pencil-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2 w-1/3">Distributor Code</td>
                                <td class="px-4 py-2">{{ $distributor->distributor_code ?? '-' }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Distributor Name</td>
                                <td class="px-4 py-2 capitalize">{{ $distributor->distributor_name ?? '-' }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Active</td>
                                <td class="px-4 py-2 capitalize">
                                    <div class="flex items-center gap-1">
                                        @if($distributor->active == 1)
                                            <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary">
                                                Yes
                                            </span>
                                        @else
                                            <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error">
                                                No
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Distribution Type</td>
                                <td class="px-4 py-2 capitalize">{{ $distributor->distributor_type ?? '-' }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Contact No</td>
                                <td class="px-4 py-2">{{ $distributor->contact_no ?? '-' }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Email</td>
                                <td class="px-4 py-2 uppercase">{{ $distributor->email ?? '-' }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Address</td>
                                <td class="px-4 py-2 capitalize">{{ $distributor->address ?? '-' }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">City</td>
                                <td class="px-4 py-2 capitalize">{{ $distributor->city ?? '-' }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">State</td>
                                <td class="px-4 py-2 capitalize">{{ $distributor->state ?? '-' }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Country</td>
                                <td class="px-4 py-2 capitalize">{{ $distributor->country ?? '-' }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Pincode</td>
                                <td class="px-4 py-2">{{ $distributor->pincode ?? '-' }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">GST No</td>
                                <td class="px-4 py-2">{{ $distributor->gst_no ?? '-' }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">License No</td>
                                <td class="px-4 py-2">{{ $distributor->license_no ?? '-' }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Created At</td>
                                <td class="px-4 py-2">{{ $distributor->created_at ? $distributor->created_at->format('d-m-Y') : '-' }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Updated At</td>
                                <td class="px-4 py-2">{{ $distributor->updated_at ? $distributor->updated_at->format('d-m-Y') : '-' }}</td>
                            </tr>

                        </tbody>

                    </table>

                </div>
            </div>

            <!-- Right: Settings -->
            <div class=" w-full  overflow-hidden"> </div>
        </div>

        <div class="box mt-5 overflow-hidden">
            <!-- Header -->
            <div class="flex items-center rounded-10 justify-between bg-secondary/5 px-4 py-3">
                <h3 class="text-lg font-semibold uppercase">Dealer Audit Trail</h3>
                <button type="button" class=" hover:text-gray-200 transition" onclick="toggleAuditTrail()">
                    <i class="las la-minus"></i>
                </button>
            </div>

            <!-- Body -->
            <div id="auditTrailBody" class="p-4 overflow-x-auto">
                <table class="w-full border-collapse text-sm md:text-base">
                    <thead class="bg-gray-100 border-b border-gray-300">
                        <tr>
                            <th class="text-left font-semibold py-2 px-2 md:px-3">Creator</th>
                            <th class="text-left font-semibold py-2 px-2 md:px-3">Event</th>
                            <th class="text-left font-semibold py-2 px-2 md:px-3">Created On</th>
                            <th class="text-left font-semibold py-2 px-2 md:px-3">Change Logs</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <!-- Example Row -->
                        <!-- You can loop through your audit data here -->
                        <!-- <tr>
              <td class="py-2 px-2 md:px-3">Admin</td>
              <td class="py-2 px-2 md:px-3">Updated Dealer</td>
              <td class="py-2 px-2 md:px-3">02/11/2024 23:31</td>
              <td class="py-2 px-2 md:px-3">Changed status from inactive to active</td>
            </tr> -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Optional collapse script -->
        <script>
            function toggleAuditTrail() {
                const body = document.getElementById("auditTrailBody");
                body.classList.toggle("hidden");
            }
        </script>
        <script>
            function toggleDropdown(id) {
                document.getElementById(id).classList.toggle("hidden");
            }

            // Close dropdown if clicked outside
            window.addEventListener("click", function (e) {
                const dropdown = document.getElementById("printDropdown");
                if (!e.target.closest("button") && !e.target.closest("#printDropdown")) {
                    dropdown.classList.add("hidden");
                }
            });
        </script>





        <script>

            function openDatePicker() {
                document.getElementById('date').click();
            }
            // <!-- collapsed logic + - button-->

            function toggleSection(button, sectionId) {
                const section = document.getElementById(sectionId);
                const icon = button.querySelector('.toggle-icon');

                section.classList.toggle('hidden');
                icon.textContent = section.classList.contains('hidden') ? '+' : '−';
            }

        </script>

@endsection