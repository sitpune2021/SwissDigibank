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
                    DD Account - DDA{{ $ddaccount->id }} - Unlink Saving Account
                </h3>
            </div>
        </div>
        <form action="" method="POST">
            @csrf
            <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
                <div class=" w-full  overflow-hidden ">
                    <div class="box dark:bg-bg3 border-gray-200 shadow-md rounded-lg">
                        <div class=" py-3">
                            <h3 class="text-lg border-b font-semibold text-black uppercase">
                                Saving Account - <a href="" class="text-primary text-lg">{{ $ddaccount->id }}</a> is
                                linked for Auto Debit DD Installment.
                            </h3>
                        </div>
                        <div class=" overflow-x-auto">

                            <div class="col-span-2 md:col-span-1 mt-3">
                                <div for="" class="md:text-lg text-xl  font-bold block mb-3 uppercase">
                                    Confirm to unlink saving account.
                                </div>

                            </div>

                            <div class="flex justify-center gap-3 mt-7">
                                <form action="{{ route('ddsaccounts.storeLinkSavingAcc', $ddaccount->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="saving_account_id" value="">
                                    <button type="submit" class="btn-primary uppercase">
                                        Unlink Saving Account
                                    </button>
                                </form>

                                <a href="{{ route('ddsaccounts.show', $ddaccount->id) }}" class="btn-outline uppercase">
                                    Back
                                </a>


                            </div>
                        </div>

                    </div>
                </div>

                <div id="" class=" w-full    ">
                    <div class="toggle-box box">
                        <div
                            class=" bg-secondary/5 rounded-t-lg px-4 py-3 flex items-center justify-between cursor-pointer toggle-header">
                            <h3 class="text-lg uppercase font-semibold">DD Info</h3>
                            <i class="las la-minus text-xl toggle-icon"></i>
                        </div>

                        <div class=" rounded-b-lg overflow-hidden  toggle-content">
                            <div class="p-4">
                                <table class="w-full whitespace-nowrap text-sm">
                                    <tbody class="divide-y divide-gray-200">
                                        <tr class="py-2 border-b">
                                            <td class="font-semibold uppercase py-2 w-40">customer</td>
                                            <td class="py-2">
                                                {{ ($ddaccount->member?->member_no ??
                                                    ($ddaccount->member?->id ? str_pad($ddaccount->member->id, 6, '0', STR_PAD_LEFT) : '')) .
                                                    ' - ' .
                                                    ($ddaccount->member?->member_info_first_name ?? 'N/A') .
                                                    ' - ' .
                                                    ($ddaccount->member?->member_info_last_name ?? '') }}
                                            </td>
                                        </tr>

                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">DD No.</td>
                                            <td class="py-2">{{ $ddaccount->dd_no ?? 'N/A' }}</td>
                                        </tr>

                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">Scheme</td>
                                            <td class="py-2">{{ $ddaccount->scheme->scheme_name ?? 'N/A' }}</td>
                                        </tr>

                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">Tenure</td>
                                            <td class="py-2">{{ $ddaccount->total_installments ?? 'N/A' }}</td>
                                        </tr>

                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">Frequency</td>
                                            <td class="py-2">{{ $ddaccount->rd_dd_frequency ?? 'N/A' }}</td>
                                        </tr>

                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">Principal Amt.</td>
                                            <td class="py-2">{{ $ddaccount->dd_amount ?? 'N/A' }}</td>
                                        </tr>

                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">Amount Received</td>
                                            <td class="py-2">{{ $ddaccount->balance ?? 'N/A' }}</td>
                                        </tr>

                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">Balance Available</td>
                                            <td class="py-2">
                                                {{ optional($ddaccount->transactions->last())->balance_available }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </form>
        <script>
            document.querySelectorAll('.toggle-box').forEach(box => {
                const header = box.querySelector('.toggle-header');
                const content = box.querySelector('.toggle-content');
                const icon = box.querySelector('.toggle-icon');

                header.addEventListener('click', () => {
                    content.classList.toggle('hidden');

                    // Change icon
                    if (content.classList.contains('hidden')) {
                        icon.classList.remove('la-minus');
                        icon.classList.add('la-plus');
                    } else {
                        icon.classList.remove('la-plus');
                        icon.classList.add('la-minus');
                    }
                });
            });
        </script>
        <script>
            function toggleDropdown(id) {
                document.getElementById(id).classList.toggle("hidden");
            }

            window.addEventListener("click", function(e) {
                const dropdown = document.getElementById("printDropdown");
                if (!e.target.closest("button") && !e.target.closest("#printDropdown")) {
                    dropdown.classList.add("hidden");
                }
            });
        </script>

        <script>
            const accountRadios = document.querySelectorAll('input[name="Account_type"]');
            const jointSection = document.getElementById('jointSection');

            accountRadios.forEach(radio => {
                radio.addEventListener('change', () => {
                    if (radio.value === 'joint') {
                        jointSection.style.display = 'block';
                    } else {
                        jointSection.style.display = 'none';
                    }
                });
            });
        </script>
    @endsection
