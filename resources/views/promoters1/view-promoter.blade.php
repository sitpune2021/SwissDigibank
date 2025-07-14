@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <h3 class="h2">View Promoter</h3>
    </div>
    <div>
        <a href="" class="btn-secondary" style="padding: 4px 8px; font-size: 12px;">
            <i class="las la-print text-base md:text-lg" style="font-size: 14px;"></i>DOWNLOAD 15G/ 15H
        </a>
        <a href="" class="btn-primary" style="padding: 4px 8px; font-size: 12px;">
            <i class="las la-plus text-base md:text-lg" style="font-size: 14px;"></i>Upload 15G/ 15H
        </a>
        <a href="" class="btn-warning" style="padding: 4px 8px; font-size: 12px;">
            <i class="las la-eye text-base md:text-lg" style="font-size: 14px;"></i>
            View Transaction
        </a>
        <a href="{{ route('promotor.edit',$promoter->id) }}" class="btn-primary" style="padding: 4px 8px; font-size: 12px;">
            <i class="las la-edit text-base md:text-lg" style="font-size: 14px;"></i>
        </a>
    </div>
    <div class="box mb-4 xxxl:mb-6">
        <form action="" method="" class="grid grid-cols-2 gap-4 xxxl:gap-6">
            @csrf

            <div class="flex items-start gap-4">
                <label for="company_website" class="w-48 text-sm font-medium"></label>
                <div class="w-full">
                    <!-- <input type="text" name="company_name" id="company_name"
                        class="w-full text-sm border rounded px-3 py-2"
                        value="" disabled> -->

                    <h3>{{ $promoter->member_no }} - {{ $promoter->first_name }}</h3>
                </div>
            </div>
             <br>
            <div class="flex items-start gap-4">
                <label for="company_name" class="w-48 text-sm font-medium">Enrollment Date<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="company_name" id="company_name"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                        value="{{ $promoter->enrollment_date }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="short_name" class="w-48 text-sm font-medium">Name<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="short_name" id="short_name" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $promoter->first_name }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="dob" class="w-48 text-sm font-medium mt-2">DOB<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="dob" id="dob" rows="3" value="{{ $promoter->date_of_birth }}" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" disabled>

                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="address_line1" class="w-48 text-sm font-medium">Age<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="address_line1" id="address_line1" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{$age}}">
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="address_line2" class="w-48 text-sm font-medium">Senior Citizen</label>
                <div class="w-full">
                    <input type="text" name="address_line2" id="address_line2" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $isSeniorCitizen }}">
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="gender" class="w-48 text-sm font-medium">Gender<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="gender" id="gender" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $promoter->gender }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="state" class="w-48 text-sm font-medium">Folio No.<span class="text-red-500">*</span></label>

                <div class="w-full">
                    <input type="text" name="state" id="state" value="" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="pincode" class="w-48 text-sm font-medium">Father Name<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="pincode" id="pincode" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $promoter->father_name }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="country" class="w-48 text-sm font-medium">Mother Name<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="country" id="country" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $promoter->mother_name }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="mobile_no" class="w-48 text-sm font-medium">Marital Status<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="mobile_no" id="mobile_no" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $promoter->MaritalStatus?->status ?? 'N/A' }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="landline_no" class="w-48 text-sm font-medium">Religion</label>
                <div class="w-full">
                    <input type="text" name="landline_no" id="landline_no" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $promoter->Religion?->name ?? 'N/A' }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="contact_email" class="w-48 text-sm font-medium">Spouse Name<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="email" name="contact_email" id="contact_email" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $promoter?->husband_wife_name ?? 'N/A' }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="cin_no" class="w-48 text-sm font-medium">Occupation<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="cin_no" id="cin_no" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $promoter->occupation }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="pan_no" class="w-48 text-sm font-medium">Form 15G/ 15H Uploaded
                    (FY 2025 - 2026)</label>
                <div class="w-full">
                    <input type="text" name="pan_no" id="pan_no" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="" disabled>
                </div>
            </div>

            <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                <button class="btn-outline" onclick="history.back()" type="button">
                    Back
                </button>
            </div>
        </form>
    </div>
</div>
@endsection