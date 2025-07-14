@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <h3 class="h2">Edit Company Profile</h3>
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
        <form action="{{ route('company.update') }}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
            @csrf

            <div class="flex items-start gap-4">
                <label for="company_website" class="w-48 text-sm font-medium">Company Website</label>
                <div class="w-full">
                    <input type="text" name="company_website" id="company_website"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                        value="{{ $company->company_website }}">
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="company_name" class="w-48 text-sm font-medium">Company Name<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="company_name" id="company_name"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                        value="{{ $company->company_name }}">
                </div>
                @error('company_name')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-start gap-4">
                <label for="short_name" class="w-48 text-sm font-medium">Short Name<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="short_name" id="short_name" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->short_name }}" class="flex-1 text-sm border rounded px-3 py-2">
                    @error('short_name')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="about_company" class="w-48 text-sm font-medium mt-2">About Company<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <textarea name="about_company" id="about_company" rows="3"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3 leading-snug align-top resize-none">{{ $company->about_company }}</textarea>
                    @error('about_company')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <h4>Reg. Office Address:</h4><br>
            <div class="flex items-start gap-4">
                <label for="address_line1" class="w-48 text-sm font-medium">Address Line 1<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="address_line1" id="address_line1" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                        value="{{ $company->address_line1 }}">
                    @error('address_line1')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="address_line2" class="w-48 text-sm font-medium">Address Line 2</label>
                <div class="w-full">
                    <input type="text" name="address_line2" id="address_line2" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->address_line2 }}">
                    @error('address_line2')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="city" class="w-48 text-sm font-medium">City<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="city" id="city" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->city }}">
                    @error('city')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="state" class="w-48 text-sm font-medium">State<span class="text-red-500">*</span></label>

                <div class="w-full">
                    <input type="hidden" id="selectedStateId" value="{{ $company->state }}">
                    <select name="state" id="stateDropdown" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                        @foreach($states as $state)
                        <option value="{{ $state->id }}" {{ $company->state == $state->id ? 'selected' : '' }}>
                            {{ $state->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('state')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="pincode" class="w-48 text-sm font-medium">Pincode<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="pincode" id="pincode" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->pincode }}">
                    @error('pincode')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="country" class="w-48 text-sm font-medium">Country<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="country" id="country" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->country }}">
                    @error('country')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="mobile_no" class="w-48 text-sm font-medium">Mobile No.<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="mobile_no" id="mobile_no" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->mobile_no }}">
                    @error('mobile_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="landline_no" class="w-48 text-sm font-medium">Landline No.</label>
                <div class="w-full">
                    <input type="text" name="landline_no" id="landline_no" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->landline_no }}">
                    @error('landline_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="contact_email" class="w-48 text-sm font-medium">Email<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="email" name="contact_email" id="contact_email" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->contact_email }}">
                    @error('contact_email')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="cin_no" class="w-48 text-sm font-medium">CIN No. <span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="cin_no" id="cin_no" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->cin_no }}">
                    @error('cin_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="pan_no" class="w-48 text-sm font-medium">PAN No.</label>
                <div class="w-full">
                    <input type="text" name="pan_no" id="pan_no" value="{{ $company->pan_no }}" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                    @error('pan_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="tan_no" class="w-48 text-sm font-medium">TAN No.</label>
                <div class="w-full">
                    <input type="text" name="tan_no" id="tan_no" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->tan_no }}">
                    @error('tan_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="gst_no" class="w-48 text-sm font-medium">GST No.</label>
                <div class="w-full">
                    <input type="text" name="gst_no" id="gst_no" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->gst_no }}">
                    @error('gst_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="company_category" class="w-48 text-sm font-medium">Company Category <span class="text-red-500">*</span></label>
                <div class="w-full">
                    <select name="company_category" id="company_category" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                        <option value="Limited By Shares" {{ $company->company_category == 'Limited By Shares' ? 'selected' : '' }}>
                            Limited By Shares
                        </option>
                        <option value="Limited By Guarantee" {{ $company->company_category == 'Limited By Guarantee' ? 'selected' : '' }}>
                            Limited By Guarantee
                        </option>
                        <option value="Unlimited Company" {{ $company->company_category == 'Unlimited Company' ? 'selected' : '' }}>
                            Unlimited Company
                        </option>
                    </select>
                    @error('company_category')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="company_class" class="w-48 text-sm font-medium">Company Class<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <select name="company_class" id="company_class" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                        <option value="Public Limited Company" {{ $company->company_class == 'Public Limited Company' ? 'selected' : '' }}>
                            Public Limited Company
                        </option>
                        <option value="Association of Persons" {{ $company->company_class == 'Association of Persons' ? 'selected' : '' }}>
                            Association of Persons
                        </option>
                        <option value="Private Limited Company" {{ $company->company_class == 'Private Limited Company' ? 'selected' : '' }}>
                            Private Limited Company
                        </option>
                        <option value="Partnership Firm" {{ $company->company_class == 'Partnership Firm' ? 'selected' : '' }}>
                            Partnership Firm
                        </option>
                    </select>
                    @error('company_class')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="incorporation_date" class="w-48 text-sm font-medium">Incorporation Date<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <div class="relative bg-secondary/5 py-3 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl">
                        <input name="incorporation_date" id="date2" class="border-none" value="{{ $company->incorporation_date }}" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" autocomplete="off" />
                        <i
                            class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                    </div>
                    @error('incorporation_date')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="incorporation_state" class="w-48 text-sm font-medium">Incorporation State<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="hidden" id="selectedIncorporationStateId" value="{{ $company->incorporation_state }}">
                    <select name="incorporation_state" id="incorporation_state" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                        @foreach($states as $state)
                        <option value="{{ $state->id }}" {{ $company->incorporation_state == $state->id ? 'selected' : '' }}>
                            {{ $state->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('incorporation_state')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="incorporation_country" class="w-48 text-sm font-medium">Incorporation Country<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="incorporation_country" id="incorporation_country" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->incorporation_country }}">
                    @error('incorporation_country')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="authorized_capital" class="w-48 text-sm font-medium">Authorized Capital<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="number" name="authorized_capital" id="authorized_capital" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->authorized_capital }}">
                    @error('authorized_capital')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="paid_up_capital" class="w-48 text-sm font-medium">Paid Up Capital<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="number" name="paid_up_capital" id="paid_up_capital" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->paid_up_capital }}">
                    @error('paid_up_capital')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                <button class="btn-primary" type="submit">
                    Update
                </button>
                <button class="btn-outline" onclick="window.location.href='{{ route('company.view') }}'" type="button">
                    Back
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    setTimeout(function() {
        var successAlert = document.getElementById('success-alert');
        var errorAlert = document.getElementById('error-alert');
        if (successAlert) successAlert.style.display = 'none';
        if (errorAlert) errorAlert.style.display = 'none';
    }, 5000);
</script>
<script>
    $(document).ready(function() {
        let selectedStateId = $('#selectedStateId').val();

        $.ajax({
            url: '/api/states',
            type: 'GET',
            dataType: 'json',
            success: function(states) {
                let select = $('#stateDropdown');
                select.empty();
                select.append('<option value="">Select State</option>');

                $.each(states, function(index, state) {
                    let isSelected = (state.id == selectedStateId) ? 'selected' : '';
                    select.append('<option value="' + state.id + '" ' + isSelected + '>' + state.name + '</option>');
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
        let selectedStateId = $('#selectedIncorporationStateId').val();

        $.ajax({
            url: '/api/states',
            type: 'GET',
            dataType: 'json',
            success: function(states) {
                let select = $('#incorporation_state');
                select.empty();
                select.append('<option value="">Select State</option>');

                $.each(states, function(index, state) {
                    let isSelected = (state.id == selectedStateId) ? 'selected' : '';
                    select.append('<option value="' + state.id + '" ' + isSelected + '>' + state.name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching states:', error);
            }
        });
    });
</script>