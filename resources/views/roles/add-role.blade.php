@extends('layout.main')
{{-- @php
use App\Models\Menu;
$menuItems = Menu::where('active', 1)->with('submenus')->orderBy('position')->get();
@endphp --}}
@section('page-title', '')

@section('content')
    <style>
        input[type="radio"] {
            width: 24px;
            height: 24px;
            accent-color: green;
            /* Modern browsers */
        }

        input[type="checkbox"] {

            accent-color: green;
            /* Modern browsers */
        }
    </style>


    <div class="box col-span-12 lg:col-span-6">
        <div class="mb-6 pb-6 bb-dashed flex justify-between items-center">
            <h3 class="h3">ADD NEW ROLE / PERMISSION</h3>
            <ol class="breadcrumb flex text-sm text-gray-600 mt-1 space-x-1">
            </ol>
            <hr class="my-2 border-gray-300" />
        </div>

        <form action="{{ route('role_permission.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                <div class="col-span-2 md:col-span-1">
                    <label for="name" class="mb-4 md:text-lg font-medium block">
                        ROLE NAME
                    </label>

                    <select name="role_id"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                        placeholder="Select Role">
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-2 md:col-span-1 md:grid-cols-2 lg:grid-cols-3">
                    <label for="role_position" class="mb-4 md:text-lg font-medium block">
                        ROLE POSITION/ WEIGHT-AGE
                    </label>
                    <input type="text" name="role_position"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter Permission / Role Name" id="role_position" />
                </div>

                <div class="col-span-2 md:col-span-1 md:grid-cols-2 lg:grid-cols-3">
                    <label for="permission_type" class="uppercase md:text-lg font-medium block mb-4">
                        Permission Type
                        <span class="text-error">*</span>
                    </label>
                    <div class="flex">
                        <label class="flex items-center gap-2 space-x-2 p-2">
                            <input type="radio" name="permission_type" value="admin"
                                class="text-green-600 focus:ring-green-500">
                            <span class="text-gray-70 capitalize">Admin Type</span>
                        </label>
                        <label class="flex items-center gap-2 space-x-2 p-2">
                            <input type="radio" name="permission_type" value="agent"
                                class="text-green-600 focus:ring-green-500">
                            <span class="text-gray-70 capitalize">Agent Type</span>
                        </label>
                        <label class="flex items-center gap-2 space-x-2 p-2">
                            <input type="radio" name="permission_type" value="both"
                                class="text-green-600 focus:ring-green-500" checked>
                            <span class="text-gray-70 capitalize">Both Type</span>
                        </label>
                    </div>

                </div>
                <div class="col-span-2 md:col-span-1 md:grid-cols-2 lg:grid-cols-3">
                    <label for="active" class="uppercase md:text-lg font-medium block mb-4">
                        Active
                        <span class="text-error">*</span>
                    </label>
                    <div class="flex">
                        <label class="flex items-center gap-2 space-x-2 p-2">
                            <input type="radio" name="active" value="Yes" class="text-green-600 focus:ring-green-500"
                                checked>
                            <span class="text-gray-70 capitalize">Yes</span>
                        </label>
                        <label class="flex items-center gap-2 space-x-2 p-2">
                            <input type="radio" name="active" value="No" class="text-green-600 focus:ring-green-500">
                            <span class="text-gray-70 capitalize">No</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
                <div class="col-span-2 md:col-span-6 md:grid-cols-2 lg:grid-cols-3">
                    <div class="main-inner">
                        <button id="menuToggleBtn" type="button"
                            class="md:hidden flex items-center gap-2 min-w-max py-2 px-3 relative z-[3] rounded-lg bg-primary text-n0 chatbtn">
                            <i class="las la-bars"></i> <span>Menu</span>
                        </button>
                        <div class="flex  flex-col relative gap-4 xxl:gap-6 max-md:mt-3 tabs">
                            <div id="chat-sidebar"
                                class="max-md:box md:bg-transparent duration-500 max-md:w-[280px] max-md:max-h-[600px]
                                 max-md:overflow-y-auto max-md:rounded-xl max-md:absolute ltr:max-md:left-0 rtl:max-md:right-0 z-[3] max-md:bg-n0 max-md:dark:bg-bg4
                               max-md:top-0 md:col-span-5 xl:col-span-4 max-md:min-w-[300px] chathide">
                                <div class="md:box sticky top-20">
                                    @php
                                        $allMenus = array_merge(
                                            $menuItems1,
                                            $menuItems2,
                                            $menuItems3,
                                            $menuItems4,
                                            $menuItems5,
                                            $menuItems6,
                                            $menuItems7,
                                            $menuItems8,
                                            $menuItems9,
                                            $menuItems10,
                                        );

                                        // Number of columns you want in each row
                                        $columns = 4;

                                        // Chunk array into rows
                                        $rows = array_chunk($allMenus, $columns);
                                    @endphp

                                    <table class="w-full whitespace-nowrap flex gap-3 overflow-x -auto">
                                        @foreach ($rows as $row)
                                            <tr class="">
                                                @foreach ($row as $item)
                                                    <td class="  text-start " style="padding: 5px 20px">
                                                        <button class="tab-link active">
                                                            {{ $item['title'] }}
                                                        </button>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div class="col-span-12 md:col-span-7 xl:col-span-8 box xl:p-8">
                                <!-- <div class="flex justify-between items-center gap-2 bb-dashed pb-4 mb-4 lg:mb-6 lg:pb-6">
                                                         @include('partials._horizontal-options')
                                                       </div> -->
                                <div class="bb-dashed border-secondary/20 mb-4 pb-4 lg:mb-6 lg:pb-6">
                                    <div>
                                        <!---------------------Dashboard------------------------>

                                        @include('roles.checkboxes.dashboard')

                                    </div>

                                    <!---------------------Company Profile------------------------>

                                    @include('roles.checkboxes.company')


                                    <!---------------------User Management------------------------>

                                    @include('roles.checkboxes.user')

                                    <!---------------------COLLECTION CENTERS------------------------>

                                    @include('roles.checkboxes.collection-center')


                                    <!---------------------MEMBER(customer) MANAGEMENT	------------------------>


                                    @include('roles.checkboxes.member-management')
                                    <!---------------------SAVING ACCOUNTS------------------------>
                                    @include('roles.checkboxes.saving-acc')

                                    <!---------------------FIXED DEPOSITS------------------------>
                                    @include('roles.checkboxes.fixed-deposit')
                                    <!---------------------RECURRING DEPOSITS------------------------>
                                    @include('roles.checkboxes.recuring')
                                    <!---------------------GOLD LOAN------------------------>

                                    @include('roles.checkboxes.gold-loan')
                                    <!---------------------PROPERTY LOAN------------------------>

                                    @include('roles.checkboxes.property-loan')
                                    <!---------------------DEPOSIT LOAN------------------------>
                                    @include('roles.checkboxes.deposit-loan')
                                    <!---------------------OTHER LOAN------------------------>
                                    @include('roles.checkboxes.other-loan')
                                    <!---------------------FIXED LOAN------------------------>

                                    @include('roles.checkboxes.fixed-loan')
                                    <!---------------------APPROVALS------------------------>
                                    @include('roles.checkboxes.approvals')
                                    <!---------------------PAYMENT COLLECTIONS	------------------------>
                                    @include('roles.checkboxes.payment-col')
                                    <!---------------------PAYMENT PAYOUTS	------------------------>
                                     @include('roles.checkboxes.payment-payout')
                                    <!---------------------MACHINE COLLECTION------------------------>
                                     @include('roles.checkboxes.machine-col')
                                    <!---------------------PASSBOOKS------------------------>
                                    @include('roles.checkboxes.passbook')
                                    <!---------------------PRINT DOCUMENTS------------------------>
                                    <div class="tab-panel hidden collection-center">
                                        @include('roles.checkboxes.print-documents')
                                    </div>
                                    <!---------------------ADVISORS------------------------>
                                    @include('roles.checkboxes.advisors')
                                    <!---------------------EXTRA SERVICES------------------------>
                                    @include('roles.checkboxes.extra-services')
                                    <!---------------------TRANSFER SETTING------------------------>
                                    @include('roles.checkboxes.transfer-setting')
                                    <!---------------------CASHFREE------------------------>
                                    @include('roles.checkboxes.cashfree')

                                    <!--------------------ICICI------------------------>
                                      @include('roles.checkboxes.icici')
                                    <!--------------------WITHIN BANK TRANSFER	------------------------>
                                   @include('roles.checkboxes.within-bank-trans')
                                    <!--------------------REPORTS------------------------>
                                     @include('roles.checkboxes.reports')
                                    <!--------------------HR MANAGEMENT------------------------>
                                   @include('roles.checkboxes.hr-management')
                                    <!--------------------SOFTWARE SETTINGS------------------------>
                                   @include('roles.checkboxes.software-settings')
                                    <!--------------------WEBSITE------------------------>
                                    @include('roles.checkboxes.website')
                                    <!--------------------	ACCOUNTING------------------------>
                                    @include('roles.checkboxes.accounting')
                                    <!--------------------	SMS SCHEDULER------------------------>
                                     @include('roles.checkboxes.sms-scheduler')
                                    <!--------------------	BUSINESS REPORTS------------------------>
                                      @include('roles.checkboxes.bussiness-report')
                                    <!--------------------DAILY COLLECTION------------------------>
                                     @include('roles.checkboxes.daily-collection')
                                    <!--------------------AGENT APP------------------------>
                                      @include('roles.checkboxes.agent-app')
                                    <!--------------------LOCKERS------------------------>
                                    @include('roles.checkboxes.lockers')
                                    <!--------------------VERIFICATION SUITE------------------------>
                                     @include('roles.checkboxes.verification-suite')
                                    <!--------------------CIBIL REPORT------------------------>
                                      @include('roles.checkboxes.cbil-report')
                                    <!--------------------VIEW LEVEL FIELDS PERMISSIONS------------------------>
                                     @include('roles.checkboxes.view-lavel-field-per')
                                    <!--------------------YESBANK------------------------>
                                    @include('roles.checkboxes.yes-bank')
                                    <!--------------------	NOTICE BOARD------------------------>
                                    @include('roles.checkboxes.notice-board')
                                    <!--------------------DOWNLOAD REPORTS------------------------>
                                    @include('roles.checkboxes.download-reports')
                                    <!--------------------APPOINTMENTS------------------------>
                                    @include('roles.checkboxes.appointment')
                                    <!--------------------INQUIRY------------------------>
                                      @include('roles.checkboxes.inquiry')
                                    <!--------------------ENACH------------------------>
                                     @include('roles.checkboxes.enach')
                                    <!--------------------CC LIMIT------------------------>
                                      @include('roles.checkboxes.cc-limit')
                                    <!--------------------AXISBANK------------------------>
                                     @include('roles.checkboxes.axis-bank')
                                    <!--------------------VEHICLE LOAN------------------------>
                                     @include('roles.checkboxes.vehicle-loan')
                                    <!--------------------PERSONAL LOAN------------------------>
                                    @include('roles.checkboxes.personal-loan')
                                    <!--------------------CKYC REPORTS------------------------>
                                    @include('roles.checkboxes.ckyc')
                                    <!--------------------	PAYLOADS------------------------>
                               @include('roles.checkboxes.payload')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                    <button class="btn-primary" type="submit">
                        Add Role
                    </button>
                    <button class="btn-outline" type="reset">
                        Cancel
                    </button>
                </div>
            </div>
        </form>

    </div>
   <script>
document.addEventListener("DOMContentLoaded", function () {

    // Loop every section
    document.querySelectorAll(".payload-section").forEach(section => {

        // Find the check-all checkbox inside this section
        const checkAll = section.querySelector(".check-all");

        // If section has no check-all, skip
        if (!checkAll) return;

        // Find all child checkboxes (except check-all)
        const items = section.querySelectorAll(".item-checkbox");

        // When Check All is clicked
        checkAll.addEventListener("change", () => {
            items.forEach(cb => cb.checked = checkAll.checked);
        });

        // If any item is manually unchecked/checked → update Check All
        items.forEach(cb => {
            cb.addEventListener("change", () => {
                const allChecked = Array.from(items).every(item => item.checked);
                checkAll.checked = allChecked;
            });
        });

    });

});
</script>
@endsection




