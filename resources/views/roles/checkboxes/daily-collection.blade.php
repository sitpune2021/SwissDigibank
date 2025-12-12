@php
    $dailyColl = [
        ['key' => 'admin_daily_collections_index', 'label' => 'Daily Collection Dashboard'],
        ['key' => 'admin_daily_collections_approvals', 'label' => 'Daily Collection Approvals'],
        ['key' => 'admin_daily_collections_process_entries', 'label' => 'Daily Collection Approvals - Process Entry'],
        ['key' => 'admin_daily_collections_transaction_reports', 'label' => 'Daily Collection Transaction Report'],
        ['key' => 'admin_daily_collections_transaction_reports_destroy', 'label' => 'Daily Collection - Delete Daily Transaction Reports Entry'],
        ['key' => 'admin_daily_collections_reports', 'label' => 'Daily Collection 10 Day Agent Report'],
        ['key' => 'admin_daily_collections_auto_approve', 'label' => 'Daily Collection - Auto Approve'],
        ['key' => 'admin_daily_collections_cash_release', 'label' => 'Daily Collection - Release Cash to Associate'],
        ['key' => 'admin_daily_collections_cash_release_auto_approve', 'label' => 'Daily Collection - Release Cash to Associate - Auto Approve'],
        ['key' => 'admin_daily_collections_cash_deposit', 'label' => 'Daily Collection - Deposit Cash Collected by Associate'],
        ['key' => 'admin_daily_collections_cash_deposit_auto_approve', 'label' => 'Daily Collection - Deposit Cash Collected by Associate - Auto Approve'],
        ['key' => 'admin_daily_collections_destroy_cash_deposit', 'label' => 'Daily Collection - Delete Cash Deposit Approved Entry'],
        ['key' => 'admin_daily_collections_active_associates', 'label' => 'Daily Collection - Active Advisors'],
        ['key' => 'admin_daily_collections_show_location_history', 'label' => 'Daily Collection - Show Active Advisors Location History'],
        ['key' => 'admin_daily_collections_inactive_associate', 'label' => 'Daily Collection - In-Active Advisor'],
        ['key' => 'admin_daily_collections_reports_print', 'label' => 'Print Daily Collection Reports'],
        ['key' => 'admin_day_wise_daily_collections_reports_download', 'label' => 'Download Day Wise Agent Collection Reports'],
        ['key' => 'admin_daily_collections_reports_download', 'label' => 'Download Daily Collection Reports'],
        ['key' => 'admin_daily_collections_associates_collection_limit', 'label' => 'List Associate Collection Limit'],
        ['key' => 'admin_daily_collections_update_collection_limit', 'label' => 'Set / Update Associate Collection Limit'],
    ];
@endphp


<div class="tab-panel hidden">
    <!----Print Documents----->
    <div class="payload-section">

        <div class="mb-3 flex justify-between bg-secondary/5 py-3 px-6 rounded-10">
            <div class="uppercase font-semibold text-lg">Print Documents</div>
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
            @foreach ($dailyColl as $dc)
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-3 space-x-2">

                    <div class="">
                        <input type="checkbox" id="permission_{{ $dc['key'] }}" name="permissions[{{ $dc['key'] }}]"
                            value="{{ $dc['key'] }}" class="item-checkbox form-checkbox h-5 w-5 text-primary ">
                    </div>

                    <label for="permission_{{ $dc['key'] }}" class="text-base font-semibold cursor-pointer mb-0">
                        {{ $dc['label'] }}
                    </label>

                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>