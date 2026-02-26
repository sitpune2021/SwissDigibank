@extends('layout.main')

@section('content')

<style>
    .tab-panel {
        display: none;
    }

    .tab-panel.active {
        display: block;
    }
</style>

@php use Illuminate\Support\Str; @endphp

 <div class="box col-span-12 lg:col-span-6">

        <div class="mb-6 pb-6 bb-dashed flex justify-between items-center">
            <h3 class="h3">SHOW ROLE / PERMISSION</h3>
                <ol class="breadcrumb flex text-sm text-gray-600 mt-1 space-x-1">
                </ol>
            <hr class="my-2 border-gray-300" />
        </div>

        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
            <div class="col-span-2 md:col-span-1">
                <label for="name" class="mb-4 md:text-lg font-medium block">
                    ROLE NAME
                </label>

                <select name="role_id"
                    class="w-full border rounded px-3 py-2"
                    {{ ($readOnly ?? false) ? 'disabled' : '' }}>

                    <option value="">Select Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}"
                            {{ ($rolePermission->role_id ?? '') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-2 md:col-span-1 md:grid-cols-2 lg:grid-cols-3">
                <label for="role_position" class="mb-4 md:text-lg font-medium block">
                    ROLE POSITION/ WEIGHT-AGE
                </label>
                <input type="text"
                    name="role_position"
                    value="{{ $rolePermission->role_position ?? '' }}"
                    class="w-full text-sm bg-secondary/5 border rounded px-3 py-2"
                    {{ ($readOnly ?? false) ? 'readonly' : '' }}
                />
            </div>

            <div class="col-span-2 md:col-span-1 md:grid-cols-2 lg:grid-cols-3">
                <label for="permission_type" class="uppercase md:text-lg font-medium block mb-4">
                    Permission Type
                    <span class="text-error">*</span>
                </label>
                <div class="flex">
                    <label class="flex items-center gap-2 space-x-2 p-2">
                        <input type="radio"
                            name="permission_type"
                            value="admin"
                            {{ ($rolePermission->permission_type ?? '') == 'admin' ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}
                        >
                        <span class="text-gray-70 capitalize">Admin Type</span>
                    </label>
                    <label class="flex items-center gap-2 space-x-2 p-2">
                        <input type="radio"
                            name="permission_type"
                            value="agent"
                            {{ ($rolePermission->permission_type ?? '') == 'agent' ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}
                        >
                        <span class="text-gray-70 capitalize">Agent Type</span>
                    </label>
                    <label class="flex items-center gap-2 space-x-2 p-2">
                        <input type="radio"
                            name="permission_type"
                            value="both"
                            {{ ($rolePermission->permission_type ?? '') == 'both' ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}
                        >
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
                        <input type="radio"
                            name="active"
                            value="Yes"
                            {{ ($rolePermission->active ?? '') == 'Yes' ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}
                        >
                        <span class="text-gray-70 capitalize">Yes</span>
                    </label>
                    <label class="flex items-center gap-2 space-x-2 p-2">
                        <input type="radio"
                            name="active"
                            value="No"
                            {{ ($rolePermission->active ?? '') == 'No' ? 'checked' : '' }}
                            {{ ($readOnly ?? false) ? 'disabled' : '' }}
                        >
                        <span class="text-gray-70 capitalize">No</span>
                    </label>
                </div>
            </div>

        </div>

            <h3>VIEW ROLE PERMISSION</h3>

            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">

                <div class="col-span-2 md:col-span-6 md:grid-cols-2 lg:grid-cols-3  ">
                    <div class="main-inner ">
                        <button id="menuToggleBtn" type="button"
                            class="md:hidden flex items-center gap-2 min-w-max py-2 px-3 relative z-[3] rounded-lg bg-primary text-n0 chatbtn">
                            <i class="las la-bars"></i> <span>Menu</span>
                        </button>
                        <div class="flex  flex-col relative gap-4 xxl:gap-6 max-md:mt-3 tabs ">
                            <div id="chat-sidebar"
                                class="max-md:box md:bg-transparent duration-500 max-md:w-[280px] max-md:max-h-[600px]
                                 max-md:overflow-y-auto max-md:rounded-xl max-md:absolute ltr:max-md:left-0 rtl:max-md:right-0 z-[3] max-md:bg-n0 max-md:dark:bg-bg4
                               max-md:top-0 md:col-span-5 xl:col-span-4 max-md:min-w-[300px] chathide overflow-x-auto">
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
                                                        <button type="button" class="tab-link" data-target="{{ $item['id'] ?? Str::slug($item['title']) }}">
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
                                
                                <div class="bb-dashed border-secondary/20 mb-4 pb-4 lg:mb-6 lg:pb-6">                    
                                   
                                    <!---------------------Dashboard------------------------>

                                    @include('roles.checkboxes.dashboard')
                                
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

                                    @include('roles.checkboxes.business-loan')
                                    
                                    <!--------------------CC LIMIT------------------------>
                                      
                                    @include('roles.checkboxes.cc-limit')

                                    <!--------------------VEHICLE LOAN------------------------>
                                    
                                    @include('roles.checkboxes.vehicle-loan')
                                    
                                    <!--------------------PERSONAL LOAN------------------------>
                                    
                                    @include('roles.checkboxes.personal-loan')

                                    <!--------------------DAILY WEEKLY LOAN------------------------>
                                    
                                    @include('roles.checkboxes.dailyweekly-loan')
                                    
                                    <!---------------------APPROVALS------------------------>

                                    @include('roles.checkboxes.approvals')

                                    <!---------------------PASSBOOKS------------------------>
                                    @include('roles.checkboxes.passbook')

                                    <!---------------------PRINT DOCUMENTS------------------------>
                                    <div class="tab-panel hidden collection-center">
                                        @include('roles.checkboxes.print-documents')
                                    </div>

                                    <!---------------------ADVISORS------------------------>
                                    @include('roles.checkboxes.advisors')

                                    <!--------------------REPORTS------------------------>
                                    @include('roles.checkboxes.reports')

                                    <!--------------------HR MANAGEMENT------------------------>
                                    @include('roles.checkboxes.hr-management')

                                    <!--------------------SOFTWARE SETTINGS------------------------>
                                    @include('roles.checkboxes.software-settings')

                                    <!--------------------	ACCOUNTING------------------------>
                                    @include('roles.checkboxes.accounting')

                                    <!--------------------LOCKERS------------------------>
                                    @include('roles.checkboxes.lockers')

                                    <!--------------------	NOTICE BOARD------------------------>
                                    @include('roles.checkboxes.notice-board')
                                    
                                    <!---------------------PAYMENT COLLECTIONS	------------------------>
                                    @include('roles.checkboxes.payment-col')

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        const buttons = document.querySelectorAll(".tab-link");
        const panels = document.querySelectorAll(".tab-panel");

        // Sab hide karo
        panels.forEach(panel => panel.classList.remove("active"));

        // Default first show
        if (buttons.length > 0) {
            const firstTarget = buttons[0].dataset.target;
            const firstPanel = document.getElementById(firstTarget);
            if (firstPanel) {
                firstPanel.classList.add("active");
            }
        }

        buttons.forEach(button => {
            button.addEventListener("click", function () {

                const target = this.dataset.target;

                panels.forEach(panel => panel.classList.remove("active"));

                const selected = document.getElementById(target);

                if (selected) {
                    selected.classList.add("active");
                }
            });
        });

    });
</script>


@endsection