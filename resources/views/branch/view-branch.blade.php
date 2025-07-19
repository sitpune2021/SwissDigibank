@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <h3 class="h2">View Branch</h3>
    </div>
    @if (session('success'))
    <div id="success-alert" style="background-color: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
        <strong>Success:</strong> {{ session('success') }}
        <span onclick="document.getElementById('success-alert').style.display='none';" style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #155724;">&times;</span>
    </div>
    @endif

    @if (session('error'))
    <div id="error-alert" style="background-color: #f8d7da; border: 1px solid #dc3545; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
        <strong>Error:</strong> {{ session('error') }}
        <span onclick="document.getElementById('error-alert').style.display='none';" style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #721c24;">&times;</span>
    </div>
    @endif

    <div class="box mb-4 xxxl:mb-6">
        <form action="" method="" class="grid grid-cols-2 gap-4 xxxl:gap-6">
            @csrf

            <div class="col-span-2 md:col-span-1">
                <label for="company_website" class="md:text-lg font-medium block mb-4">Branch Name<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="branch_name" id="branch_name"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        value="{{ $branch->branch_name }}" disabled>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="company_name" class="md:text-lg font-medium block mb-4">Branch Code<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="branch_code" id="branch_code"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        value="{{ $branch->branch_code }}" disabled>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="open_date" class="md:text-lg font-medium block mb-4">Open Date<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <!-- <div class="relative bg-secondary/5 py-3 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10"> -->
                        <input name="text" id="date2" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" value="{{ \Carbon\Carbon::parse($branch->open_date)->format('d-m-Y') }}" autocomplete="off" disabled/>
                    <!-- </div> -->
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="short_name" class="md:text-lg font-medium block mb-4">IFSC Code<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="ifsc_code" id="ifsc_code" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" value="{{ $branch->ifsc_code }}" disabled>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="address_line1" class="md:text-lg font-medium block mb-4">Address Line 1<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input name="address_line1" id="address_line1" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" value="{{ $branch->address_line1 }}" disabled>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="address_line2" class="md:text-lg font-medium block mb-4">Address Line 2</label>
                <div class="w-full">
                    <input type="text" name="address_line2" id="address_line2" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" value="{{ $branch->address_line2 }}" disabled>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="city" class="md:text-lg font-medium block mb-4">City<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="city" id="city" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" value="{{ $branch->city }}" disabled>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="state" class="md:text-lg font-medium block mb-4">State<span class="text-red-500">*</span></label>
                <div class="w-full">
                      <input type="text" name="state" id="state" value="{{ $branch->stateData->name }}" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" disabled>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="pincode" class="md:text-lg font-medium block mb-4">Pincode<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" value="{{ $branch->pincode }}" disabled class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="country" class="md:text-lg font-medium block mb-4">Country<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="country" id="country" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" value="{{ $branch->country }}" disabled>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="contact_email" class="md:text-lg font-medium block mb-4">Contact Email</label>
                <div class="w-full">
                    <input type="email" name="contact_email" id="contact_email" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" value="{{ $branch->contact_email }}" disabled>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="mobile_no" class="md:text-lg font-medium block mb-4">Contact No.</label>
                <div class="w-full">
                    <input type="text" name="mobile_no" id="mobile_no" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" value="{{ $branch->mobile_no }}" disabled>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="landline_no" class="md:text-lg font-medium block mb-4">Landline No.</label>
                <div class="w-full">
                    <input type="text" name="landline_no" id="landline_no" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" value="{{ $branch->landline_no }}" disabled>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="gst_no" class="md:text-lg font-medium block mb-4">GST No.</label>
                <div class="w-full">
                    <input type="text" name="gst_no" id="gst_no" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" value="{{ $branch->gst_no }}" disabled>
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="disable_recharge" class="md:text-lg font-medium block mb-4">Disable Recharge / Bill Payment Service<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" value="{{ ucfirst($branch->disable_recharge) }}" disabled class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="disable_neft" class="md:text-lg font-medium block mb-4">Disable NEFT/ IMPS / WITHIN Transfer Service<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" value="{{ ucfirst($branch->disable_neft) }}" disabled class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                </div>
            </div>

            <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                <button class="btn-outline" type="button" onclick="history.back()">
                    Back
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script>
    setTimeout(function() {
        var successAlert = document.getElementById('success-alert');
        var errorAlert = document.getElementById('error-alert');
        if (successAlert) successAlert.style.display = 'none';
        if (errorAlert) errorAlert.style.display = 'none';
    }, 5000);
</script> -->

<script>
    $(document).ready(function() {
        $.ajax({
            url: '/api/states',
            type: 'GET',
            dataType: 'json',
            success: function(states) {
                let select = $('#stateDropdown');
                select.empty();
                select.append('<option value="">Select State</option>');

                $.each(states, function(index, state) {
                    select.append('<option value="' + state.id + '">' + state.name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching states:', error);
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: '/api/states',
            type: 'GET',
            dataType: 'json',
            success: function(states) {
                let select = $('#incorporation_state');
                select.empty();
                select.append('<option value="">Select State</option>');

                $.each(states, function(index, state) {
                    select.append('<option value="' + state.id + '">' + state.name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching states:', error);
            }
        });
    });
</script>