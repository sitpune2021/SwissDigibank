@extends('layout.main')
@section('content')
<style>
    input[type="checkbox"] {
        width: 24px !important;
        height: 24px !important;
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
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-4">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-lg uppercase font-semibold">
                Master Settings - Business Type
            </h1>
        </div>
    </div>
    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <!-- Left: Details -->
        <div class=" w-full box  overflow-hidden">
            <form id="" action="" method=""
               class="space-y-6">
              
                <div class="overflow-x-auto">
                    <table class="w-full text-center">
                        <thead class="bg-gray-100">
                            <tr class="bg-secondary/5">
                                <th class=" px-4 py-2">S. NO.</th>
                                <th class=" px-4 py-2">BUSINESS NAME</th>
                                <th class=" px-4 py-2">REMOVE</th>
                            </tr>
                        </thead>

                        <tbody id="nested-fields">
                            <!-- Existing rows example -->
                            <tr id="field-set-3165414" class="border-b">
                                <td class=" px-4 py-2">1</td>

                                <td class=" px-4 py-2">
                                    <input type="text" name=""
                                        placeholder="Enter Business Name"
                                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                                </td>

                                <td class=" px-4 py-2">
                                    <button type="button" onclick="removeField(3165414)"
                                        class="text-red-600 hover:text-red-800 text-xl">
                                        ✕
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Add more -->
                <div class="text-center">
                    <button type="button" onclick="addRow()"
                        class="inline-flex items-center gap-2 font-semibold text-primary">
                        <span class="text-xl">＋</span> ADD 1 MORE
                    </button>
                </div>

                <!-- Actions -->
                <div class="flex justify-center mt-5 gap-4">
                    <button type="submit" class="btn-primary uppercase">
                        UPDATE
                    </button>

                    <a href=""  class="btn-outline uppercase">
                        BACK
                    </a>
                </div>
            </form>
        </div>

        <!-- Right: Settings -->
        <div class=" w-full overflow-hidden "> </div>

    </div>
   <script>
let counter = document.querySelectorAll('#nested-fields tr').length;

function removeField(id) {
    const row = document.getElementById(`field-set-${id}`);
    if (row) {
        row.remove();
        reindexRows();
    }
}

function addRow() {
    counter++;
    const id = Date.now(); // unique key
    const tbody = document.getElementById('nested-fields');

    const tr = document.createElement('tr');
    tr.classList="border-b";
    tr.id = `field-set-${id}`;
    tr.innerHTML = `
        <td class=" px-4 py-2">${counter}</td>

        <td class=" px-4 py-2">
            <input
                type="text"
                name="company_setting[business_type][${id}]"
                placeholder="Enter Business Name"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
            >
        </td>

        <td class=" px-4 py-2">
            <button
                type="button"
                onclick="removeField(${id})"
                class="text-red-600 hover:text-red-800 text-xl"
            >
                ✕
            </button>
        </td>
    `;

    tbody.appendChild(tr);
}

function reindexRows() {
    document.querySelectorAll('#nested-fields tr').forEach((row, index) => {
        row.children[0].textContent = index + 1;
    });
}

function handleSubmit() {
    return confirm('Are you sure you want to update Business Type?');
}
</script>


    @endsection