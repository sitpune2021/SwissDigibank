
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="flex items-center justify-center min-h-screen py-10 bg-orange-500">

    <div class="w-full max-w-3xl rounded-lg">

        <div class="max-w-3xl mx-auto overflow-hidden bg-white shadow-lg">

            <div class="flex items-center justify-between px-4 py-2 text-dark" style="background-color:#DCDCDC; ">
                <h1 class="text-lg font-bold">{{ $headers['title'] }}</h1>
                <img src="{{ asset('assets/images/SBC_LOGO.png') }}" alt="SBC Logo" class="h-10">
            </div>

            <div class="p-6 text-sm border-b border-gray-300">
                <table class="w-full border-collapse">
                    <tbody>
                        <tr class="text-xs">
                            <td class="pr-2 font-semibold">{{ $headers['customer_id'] }}</td>
                            <td class="pr-4">:</td>
                            <td class="pr-10">{{ $shareholding->customer_id }}</td>

                            <td class="pr-2 font-semibold">{{ $headers['date'] }}</td>
                            <td class="pr-4">:</td>
                            <td>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">{{ $headers['customer_name'] }}</td>
                            <td>:</td>
                            <td>{{ $shareholding->members->member_info_first_name }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">{{ $headers['share_allotment_date'] }}</td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::parse($shareholding->created_at)->format('d/m/Y')}}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">{{ $headers['share_range'] }}</td>
                            <td>:</td>
                            <td>{{ $shareholding->from_share_no }} - {{ $shareholding->to_share_no }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">{{ $headers['total_shares'] }}</td>
                            <td>:</td>
                            <td>{{ $shareholding->shares }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">{{ $headers['nominal_value'] }}</td>
                            <td>:</td>
                            <td>{{ $shareholding->face_value }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">{{ $headers['total_value'] }}</td>
                            <td>:</td>
                            <td>{{ $shareholding->total_consideration }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">{{ $headers['date_of_transfer'] }}</td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::parse($shareholding->transfer_date)->format('d/m/Y')}}</td>
                        <tr>
                            <td class="font-bold">TERMS AND CONDITIONS</td>
                            <td>:</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <div class="flex gap-4 px-4 py-2 text-sm font-bold text-dark bg-orange-500"
                style="background-color:#DCDCDC; ">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            </div>

        </div>
        <div class="max-w-3xl mx-auto mt-4 font-sans bg-white shadow-lg">

            <div class="flex items-center justify-between px-4 py-2 text-dark " style="background-color:#DCDCDC;">
                <div class="text-lg font-bold">{{ $headers['title'] }}</div>
                <img src="{{ asset('assets/images/SBC_LOGO.png') }}" alt="SBC Logo" class="h-10">
            </div>

            <div class="p-4">
                <h6 class="mb-2 font-semibold">CONDITIONS -</h6>
                <ol class="pl-5 space-y-1 text-sm leading-relaxed list-decimal">
                    <li>This is a Term Deposit Advice and no lien can be marked on this document.</li>
                    <li>Tax deduction at source may be applicable as per Income Tax rules.</li>
                    <li>Non-submission of PAN by depositor(s) may attract higher rate of TDS, as applicable.</li>
                    <li>In case of Form 15 G / H being submitted to the Bank, PAN number mentioned on form should match
                        with Bank records.</li>
                    <li>In case of premature withdrawal, interest will be paid at the rate prevailing on the date of
                        receipt from the tenure deposit or at the contracted rate, whichever is lower post deducting
                        applicable penal charge for premature withdrawal.</li>
                    <li>Repayment / renewal instructions of deposit shall be effected as per the maturity instructions
                        recorded with the Bank at the time of booking Term Deposit.</li>
                    <li>In absence of maturity instructions, the Term Deposit will be renewed automatically without
                        notice.</li>
                    <li>Any liability to the Bank for the same tenure and at the interest rate prevailing on the date of
                        renewal.</li>
                    <li>Any change of maturity instructions need to be intimated to the Bank minimum 7 days prior to the
                        maturity of the deposit.</li>
                    <li>Any communications to the Bank should consist of the Term Deposit number or customer id.</li>
                    <li>Any change of address should be communicated to the Bank along with address proof document for
                        the new address.</li>
                    <li>The calculation of interest is basis 365 days in a year for deposits booked in a non-leap year
                        and 366 days in a leap year.</li>
                    <li>This Term Deposit is governed by the terms and conditions of the Bank.</li>
                </ol>
            </div>

            <!-- Footer Info -->
            <div class="p-2 text-xs text-center border-t border-gray-300">
                Any discrepancy in this advice should be brought to the notice of SBC Global Branch immediately.
            </div>

            <!-- Contact Section -->
            <div class="flex flex-wrap items-center justify-around gap-3 p-3 text-xs text-center bg-gray-100">
                <div>
                    <strong>Call us at</strong><br>1800 202 6261
                </div>
                <div>
                    <strong>Website</strong><br>
                    <a href="https://www.sbcglobal.co.in" target="_blank"
                        class="text-black no-underline">www.sbcglobal.co.in</a>
                </div>
                <div>
                    <strong>Support</strong><br>
                    <a href="mailto:customercare@sbcglobal.co.in"
                        class="text-black no-underline">customercare@sbcglobal.co.in</a>
                </div>
                <div>
                    <strong>Write to us</strong><br>Reg. Office Address
                </div>
                <div>
                    <strong>Follow us on</strong><br>Facebook / Twitter / LinkedIn
                </div>
            </div>

            <!-- Address Bar -->
            <div class="px-3 py-1 text-xs text-center text-dark bg-orange-500" style="background-color:#DCDCDC;">
                HEAD OFFICE - SBC Global Tower, 2nd Floor Chandabai Plot, Near Bus Stand Shegaon, 444203 TQ. Shegaon,
                Dist Buldhana, Maharashtra
            </div>
        </div>
    </div>
</div>
