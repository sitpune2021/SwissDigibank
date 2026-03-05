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
                    LOAN INFO
                </h3>

            </div>
        </div>


        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between  gap-5">
            <div class=" w-full box overflow-hidden ">
                <div class="w-full">
                    <table class="w-full">
                        <tr class="border-b py-2">
                            <td class="py-2 uppercase font-semibold">Member No :</td>
                            <td>
                                <a href="" class="text-primary">
                                    <span id="modalMember"></span>
                                </a>
                            </td>
                        </tr>

                        <tr class="border-b">
                            <td class="py-2 uppercase font-semibold">Account Type :</td>
                            <td><span id="modalLoanType"></span></td>
                        </tr>

                        <tr class="border-b">
                            <td class="py-2 uppercase font-semibold">Account No :</td>
                            <td>
                                <a href="" class="text-primary">
                                    <span id="modalLoanId"></span>
                                </a>
                            </td>
                        </tr>

                        <tr class="border-b">
                            <td class="py-2 uppercase font-semibold">Inst Due :</td>
                            <td><span id="modalInstDue"></span></td>
                        </tr>

                        <tr class="border-b">
                            <td class="py-2 uppercase font-semibold">Due Date :</td>
                            <td><span id="modalDueDate"></span></td>
                        </tr>

                        <tr class="border-b">
                            <td class="py-2 uppercase font-semibold">Saving Bal :</td>
                            <td>-</td>
                        </tr>

                        <tr class="border-b">
                            <td class="py-2 uppercase font-semibold">Amt to Collect :</td>
                            <td><span id="modalAmount"></span></td>
                        </tr>
                    </table>
                    <div class="text-center uppercase mt-6 font-semibold">
                        Last Credit Transaction Info
                    </div>
                    <div class="">
                        <table class="w-full   text-sm">
                            <tbody>
                                <!-- Column Titles -->
                                <tr class="bg-gray-50 border-b">
                                    <td class="py-2 px-3 uppercase font-semibold">Trans Id</td>
                                    <td class="py-2 px-3 uppercase font-semibold">T Date</td>
                                    <td class="py-2 px-3 uppercase font-semibold">Pay Mode</td>
                                    <td class="py-2 px-3 uppercase font-semibold ">Amount</td>
                                    <td class="py-2 px-3 uppercase font-semibold">Status</td>
                                </tr>

                                <!-- Data Row -->
                                <tr class="border-b">
                                    <td class="py-2 px-3 ">DD6491</td>
                                    <td class="py-2 px-3 ">13-07-2022 </td>
                                    <td class="py-2 px-3 ">Cash</td>
                                    <td class="py-2 px-3 ">1500.0</td>
                                    <td class="py-2 px-3 ">
                                        APPROVED
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
                <form method="POST" action="{{ route('loan.save.comment') }}">
                    @csrf
                    <input type="hidden" name="loan_id" value="{{ $loan_id ?? '' }}">
                    <input type="hidden" name="loan_type" value="{{ $loan_type ?? '' }}">
                    <div class="col-span-2 md:col-span-1 mt-5 mb-3">
                        <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                            Add New Comment
                            <span class="text-red-500">*</span>
                        </label>
                        <textarea name="comment" placeholder="Write Your Comment Here..."
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                        <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                            Save
                        </button>

                        <button class="btn-outline uppercase justify-center" type="reset">
                            <a href="#"> BACK</a>
                        </button>

                    </div>
                </form>
                @if (isset($comments) && count($comments) > 0)
                    <div class="mt-8">
                        <div class="text-center uppercase font-semibold mb-3">
                            Comment History
                        </div>

                        <table class="w-full text-sm">
                            <tr class="bg-gray-50 border-b">
                                <td class="py-2 px-3 uppercase font-semibold">Comment</td>
                                <td class="py-2 px-3 uppercase font-semibold">Comment By</td>
                                <td class="py-2 px-3 uppercase font-semibold">Date</td>
                            </tr>

                            @foreach ($comments as $c)
                                <tr class="border-b">
                                    <td class="py-2 px-3">{{ $c->comment }}</td>
                                    <td class="py-2 px-3">{{ $c->comment_by }}</td>
                                    <td class="py-2 px-3">{{ date('d-m-Y H:i', strtotime($c->created_at)) }}</td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                @endif
            </div>

            <!-- Right: Settings -->
            <div class=" w-full overflow-hidden">
                <div id="" class="hidden "> </div>
            </div>

        </div>

    </div>



    <script>
        const select = document.getElementById("employeeSelect");
        const infoBox = document.getElementById("employeeInfo");

        select.addEventListener("change", () => {
            if (select.value) {
                infoBox.classList.remove("hidden");
                infoBox.classList.add("grid");
            } else {
                infoBox.classList.add("hidden");
            }
        });
    </script>
    <script>
        const employeeSelect = document.getElementById("employeeSelect");
        const employeeBox = document.getElementById("employeeBox");

        employeeSelect.addEventListener("change", () => {
            if (employeeSelect.value) {
                employeeBox.classList.remove("hidden"); // show div
            } else {
                employeeBox.classList.add("hidden"); // hide div
            }
        });
    </script>

    <!-- Pay Salary Checkbox -->
    <script>
        const checkbox = document.getElementById("showPayMode");
        const payModeSection = document.getElementById("payModeSection");
        const feeModeRadios = document.querySelectorAll("input[name='fee_mode']");
        const bankFields = document.getElementById("bankDropdownWrapper");
        const onlineFields = document.getElementById("onlineFields");
        const savingAc = document.getElementById("savingAc");

        // ✅ Show/hide entire section when checkbox is toggled
        checkbox.addEventListener("change", () => {
            payModeSection.classList.toggle("hidden", !checkbox.checked);
        });

        // ✅ Show/hide bank or online fields based on selected pay mode
        feeModeRadios.forEach((radio) => {
            radio.addEventListener("change", () => {
                if (radio.value === "cheque") {
                    bankFields.classList.remove("hidden");
                    onlineFields.classList.add("hidden");
                } else if (radio.value === "online") {
                    onlineFields.classList.remove("hidden");
                    bankFields.classList.add("hidden");
                } else if (radio.value === "saving") {
                    savingAc.classList.remove("hidden");
                    bankFields.classList.add("hidden");
                } else {
                    bankFields.classList.add("hidden");
                    onlineFields.classList.add("hidden");
                }
            });
        });
    </script>
    <!-- pay mode -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const radios = document.querySelectorAll('input[name="fee_mode"]');
            const bankDropdownWrapper = document.getElementById("bankDropdownWrapper");
            const onlineFields = document.getElementById("onlineFields");

            radios.forEach(radio => {
                radio.addEventListener("change", () => {
                    bankDropdownWrapper.classList.add("hidden");
                    onlineFields.classList.add("hidden");

                    if (radio.value === "cheque" && radio.checked) {
                        bankDropdownWrapper.classList.remove("hidden");
                    }
                    if (radio.value === "online" && radio.checked) {
                        onlineFields.classList.remove("hidden");
                    }
                });
            });

            // Default dates
            let today = new Date().toISOString().split('T')[0];
            document.getElementById("cheque_date").value = today;
            document.getElementById("transfer_date").value = today;
        });
    </script>

    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

    <!-- Datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <script>
       function openLoanModal(memberNo, memberName, loanType, loanId, instDue, dueDate, amount) {

    document.getElementById('loanModal').classList.remove('hidden');

    document.getElementById('modalMember').innerHTML = memberNo + " - " + memberName;
    document.getElementById('modalLoanType').innerHTML = loanType;
    document.getElementById('modalLoanId').innerHTML = loanId;
    document.getElementById('modalInstDue').innerHTML = instDue;
    document.getElementById('modalDueDate').innerHTML = dueDate;
    document.getElementById('modalAmount').innerHTML = amount;

    document.getElementById('modalLoanIdInput').value = loanId;
    document.getElementById('modalLoanTypeInput').value = loanType;

    fetch('/loan/comments/' + loanType + '/' + loanId)
        .then(res => res.json())
        .then(data => {

            let html = '';

            if (data.length === 0) {
                html = '<tr><td colspan="3" class="text-center">No Comments</td></tr>';
            } else {

                data.forEach(c => {

                    html += `
                    <tr>
                        <td class="py-2 px-3">${c.comment}</td>
                        <td class="py-2 px-3">${c.comment_by ?? '-'}</td>
                        <td class="py-2 px-3">${new Date(c.created_at).toLocaleString()}</td>
                    </tr>
                    `;

                });

            }

            document.getElementById('commentHistory').innerHTML = html;

        });
}
    </script>
@endsection
