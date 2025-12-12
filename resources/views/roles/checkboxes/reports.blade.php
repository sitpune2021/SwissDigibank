@php
    $reports = [
        ['key' => 'admin_reports_members', 'label' => 'Download Members CSV File'],
        ['key' => 'admin_reports_share_holdings', 'label' => 'Download Share Holdings CSV File'],
        ['key' => 'admin_reports_share_transfer_histories', 'label' => 'Download Share Transfer Histories CSV File'],
        ['key' => 'admin_reports_saving_accounts', 'label' => 'Download Saving Accounts CSV File'],
        ['key' => 'admin_reports_fd_accounts', 'label' => 'Download FD Account CSV File'],
        ['key' => 'admin_reports_mis_accounts', 'label' => 'Download MIS Account CSV File'],
        ['key' => 'admin_reports_rd_accounts', 'label' => 'Download RD Account CSV File'],
        ['key' => 'admin_reports_dd_accounts', 'label' => 'Download DD Account CSV File'],
        ['key' => 'admin_reports_gold_loan_accounts', 'label' => 'Download Gold Loan CSV File'],
        ['key' => 'admin_reports_property_loan_accounts', 'label' => 'Download Property Loan CSV File'],
        ['key' => 'admin_reports_deposit_loan_accounts', 'label' => 'Download Deposit Loan CSV File'],
        ['key' => 'admin_reports_other_loan_accounts', 'label' => 'Download Other Loan CSV File'],
        ['key' => 'admin_reports_personal_loan_accounts', 'label' => 'Download Personal Loan CSV File'],
        ['key' => 'admin_reports_fixed_loan_accounts', 'label' => 'Download Fixed Loan CSV File'],
        ['key' => 'admin_reports_vehicle_loan_accounts', 'label' => 'Download Vehicle Loan CSV File'],
        ['key' => 'admin_reports_cc_limit_accounts', 'label' => 'Download CC/OD Limit A/C CSV File'],
        ['key' => 'admin_reports_combo_accounts', 'label' => 'Download Combo A/C CSV File'],
        ['key' => 'admin_reports_emis', 'label' => 'Download EMI CSV File'],
        ['key' => 'admin_reports_rd_installments', 'label' => 'Download RD Installments CSV File'],
        ['key' => 'admin_reports_transactions', 'label' => 'Download Transactions CSV File'],
        ['key' => 'admin_reports_deposits_balance_report', 'label' => 'Download Deposit Balance Report'],
        ['key' => 'admin_reports_loan_balance_report', 'label' => 'Download Loan Balance Report'],
        ['key' => 'admin_reports_loan_accrued_interest_report', 'label' => 'Download Loan Accrued Interest Report'],
        ['key' => 'admin_reports_groups_report', 'label' => 'Download Groups Report'],
        ['key' => 'admin_reports_tds_report', 'label' => 'Download Interest & TDS Report'],
        ['key' => 'admin_reports_attendance_report', 'label' => 'Download Attendance Report'],
        ['key' => 'admin_reports_loan_accounts', 'label' => 'Download Loan Reports'],
        ['key' => 'admin_reports_loan_portfolio_report', 'label' => 'Download Loan Portfolio Reports'],
        ['key' => 'admin_reports_loan_collection_report', 'label' => 'Download Loan Collection Reports'],
    ];
@endphp
<div class="tab-panel hidden">
    <!----Reports----->
    <div class="payload-section">
        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Reports</div>
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">
                    <input type="checkbox" id="check_all_dashboard"
                        class="check-all form-checkbox h-5 w-5 text-primary">
                    <label for="check_all" class="text-base font-semibold cursor-pointer mb-0">
                        Check
                        All
                    </label>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">

            @foreach ($reports as $rep)
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 space-x-2">

                    <input type="checkbox" id="permission_{{ $rep['key'] }}" name="permissions[{{ $rep['key'] }}]"
                        value="{{ $rep['key'] }}" class="item-checkbox form-checkbox h-5 w-5 text-primary">

                    <label for="permission_{{ $rep['key'] }}" class="text-base font-semibold cursor-pointer mb-0">
                        {{ $rep['label'] }}
                    </label>

                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>