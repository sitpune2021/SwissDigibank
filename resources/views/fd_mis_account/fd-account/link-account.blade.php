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
                    FD Account -{{ $fdAccount->id }} - Link Saving Account (Auto credit FD interest to saving account)
                </h3>
            </div>
        </div>
        <form action="{{ route('fd-accounts.storeLinkSavingAcc', $fdAccount->id) }}" method="POST">
            @csrf
            <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
                <div class=" w-full  overflow-hidden ">
                    <div class="box dark:bg-bg3 border-gray-200 shadow-md rounded-lg">
                        <div class=" py-3">
                            <h3 class="text-lg border-b font-semibold text-black uppercase">
                                Link member's saving account to FD for auto credit interest to saving account.
                            </h3>
                        </div>
                        <div class=" overflow-x-auto">

                            <div class="col-span-2 md:col-span-1 mt-3">
                                <label for="" class="md:text-lg font-medium block mb-3 uppercase">
                                    Select Saving Account
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="flex gap-3 items-center">
                                    <select name="saving_account_id"
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3">

                                        <option value="">Select Saving Account</option>

                                        @foreach ($savingAccounts as $acc)
                                            <option value="{{ $acc->id }}" @selected($fdAccount->saving_account_id == $acc->id)>
                                                {{ $acc->account_no }}
                                                ({{ $acc->firm_name ??
                                                    trim(
                                                        ($acc->members?->member_info_first_name ?? '') .
                                                            ' ' .
                                                            ($acc->members?->member_info_middle_name ?? '') .
                                                            ' ' .
                                                            ($acc->members?->member_info_last_name ?? ''),
                                                    ) }})
                                                (Bal. {{ number_format($balances[$acc->id] ?? 0, 2) }})
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="flex justify-center gap-3 mt-7">
                                <button class="btn-primary  uppercase">
                                    Link Account
                                </button>
                                <button class="btn-outline  uppercase">
                                    back
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                <div id="" class=" w-full   ">
                    <div class="toggle-box box">
                        <div
                            class=" bg-secondary/5 rounded-t-lg px-4 py-3 flex items-center justify-between cursor-pointer toggle-header">
                            <h3 class="text-lg uppercase font-semibold">FD Info</h3>
                            <i class="las la-minus text-xl toggle-icon"></i>
                        </div>

                        <div class=" rounded-b-lg overflow-hidden  toggle-content">
                            <div class="p-4">
                                <table class="w-full whitespace-nowrap text-sm">
                                    <tbody class="divide-y divide-gray-200">
                                        <tr class="py-2 border-b">
                                            <td class="font-semibold uppercase py-2 w-40">customer</td>
                                            <td class="py-2">
                                                <a href="{{ $fdAccount?->member?->id ? route('member.show', $fdAccount->member->id) : '#' }}"
                                                    class="text-primary hover:underline">
                                                    {{ $fdAccount->member?->member_no ??
                                                        ($fdAccount->member?->id ? str_pad($fdAccount->member->id, 5, '0', STR_PAD_LEFT) : 'N/A') }}
                                                    -
                                                    {{ $fdAccount->member?->member_info_first_name }}
                                                    {{ $fdAccount->member?->member_info_last_name }}
                                                </a>
                                            </td>

                                        </tr>

                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">Open Date</td>
                                            <td class="py-2">
                                                {{ $fdAccount->open_date ? \Carbon\Carbon::parse($fdAccount->open_date)->format('d-m-Y') : '' }}
                                            </td>
                                        </tr>

                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">Maturity Date</td>
                                            <td class="py-2">
                                                {{ $fdAccount->open_date ? \Carbon\Carbon::parse($fdAccount->maturity_date)->format('d-m-Y') : '' }}
                                            </td>
                                        </tr>

                                        <tr class="border-b">
                                            <td class="font-semibold  uppercase py-2">Status </td>
                                            <td class="py-2 text-primary">{{ $fdAccount->active == 1 ? 'Active' : 'Inactive' }}</td>
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
