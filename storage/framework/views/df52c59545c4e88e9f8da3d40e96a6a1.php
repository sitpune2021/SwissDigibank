<?php $__env->startSection('content'); ?>
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 30px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 30px;
        text-align: center;
        line-height: 30px;
        font-size: 12px;
        font-weight: bold;
        color: white;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #4CAF50;
    }

    input:checked+.slider:before {
        transform: translateX(30px);
    }

    .slider .switch-on,
    .slider .switch-off {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slider .switch-on {
        left: 0;
    }

    .slider .switch-off {
        right: 0;
    }
</style>
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <h3 class="h2">Add Promoter</h3>
    </div>
    <?php if(session('success')): ?>
    <div id="success-alert" style="background-color: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
        <strong>Success:</strong> <?php echo e(session('success')); ?>

        <span onclick="document.getElementById('success-alert').style.display='none';" style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #155724;">&times;</span>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div id="error-alert" style="background-color: #f8d7da; border: 1px solid #dc3545; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
        <strong>Error:</strong> <?php echo e(session('error')); ?>

        <span onclick="document.getElementById('error-alert').style.display='none';" style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #721c24;">&times;</span>
    </div>
    <?php endif; ?>

    <div class="box mb-4 xxxl:mb-6">
        <form action="<?php echo e(route('add.promotor')); ?>" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
            <?php echo csrf_field(); ?>

            <div class="flex items-start gap-4">
                <label for="branch" class="w-48 text-sm font-medium">Branch<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <select name="branch" id="branchDropdown" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                        <option value="">Select Branch</option>
                    </select>
                    <?php $__errorArgs = ['branch'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="enrollment_date" class="w-48 text-sm font-medium">Enrollment Date<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <div class="relative bg-secondary/5 py-3 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl">
                        <input name="enrollment_date" id="date2" class="border-none" placeholder="Select Date" class="w-full text-sm border px-3 py-2" autocomplete="off" />
                        <i
                            class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                    </div>
                    <?php $__errorArgs = ['enrollment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
                <h3 class="h2">Promoter's Info</h3>
            </div> <br>
            <div class="flex items-start gap-4">
                <label for="title" class="w-48 text-sm font-medium">Title<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <div class="flex gap-4">
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="title" value="MD" <?php echo e(old('title') == 'MD' ? 'checked' : ''); ?>>
                            <span>MD</span>
                        </label>
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="title" value="Mr" <?php echo e(old('title') == 'Mr' ? 'checked' : ''); ?>>
                            <span>Mr</span>
                        </label>
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="title" value="Ms" <?php echo e(old('title') == 'Ms' ? 'checked' : ''); ?>>
                            <span>Ms</span>
                        </label>
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="title" value="Mrs" <?php echo e(old('title') == 'Mrs' ? 'checked' : ''); ?>>
                            <span>Mrs</span>
                        </label>
                    </div>
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="gender" class="w-48 text-sm font-medium">Gender<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <div class="flex gap-4">
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="gender" value="Male" <?php echo e(old('title') == 'Male' ? 'checked' : ''); ?>>
                            <span>Male</span>
                        </label>
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="gender" value="Female" <?php echo e(old('title') == 'Female' ? 'checked' : ''); ?>>
                            <span>Female</span>
                        </label>
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="gender" value="Other" <?php echo e(old('title') == 'Other' ? 'checked' : ''); ?>>
                            <span>Other</span>
                        </label>
                    </div>
                    <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="first_name" class="w-48 text-sm font-medium">First Name<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="first_name" id="first_name" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter IFSC code" value="">
                    <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="middle_name" class="w-48 text-sm font-medium mt-2">Middle Name<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input name="middle_name" id="middle_name" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter address line 1">
                    <?php $__errorArgs = ['middle_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="lastname" class="w-48 text-sm font-medium">Last Name </label>
                <div class="w-full">
                    <input type="text" name="lastname" id="lastname" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter address line 2" value="" >
                    <?php $__errorArgs = ['lastname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="dob" class="w-48 text-sm font-medium">Date of Birth<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <div class="relative bg-secondary/5 py-3 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl">
                        <input name="dob" id="date" class="border-none" placeholder="Select Date" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" autocomplete="off" />
                        <i
                            class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                    </div>
                    <?php $__errorArgs = ['dob'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="occupation" class="w-48 text-sm font-medium">Occupation<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="occupation" id="occupation" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter occupation" value="">
                    <?php $__errorArgs = ['occupation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="father_name" class="w-48 text-sm font-medium">Father Name<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="father_name" id="father_name" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter father name" value="">
                    <?php $__errorArgs = ['father_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="mother_name" class="w-48 text-sm font-medium">Mother Name<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="mother_name" id="mother_name" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter mother name" value="">
                    <?php $__errorArgs = ['mother_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="mariatal_status" class="w-48 text-sm font-medium">Marital Status</label>
                <div class="w-full">
                    <select name="mariatal_status" id="mariatal_status" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                        <option value="">Select Mariatal Status</option>
                    </select>
                    <?php $__errorArgs = ['mariatal_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="member_religion" class="w-48 text-sm font-medium">Member Religion</label>
                <div class="w-full">
                    <select name="member_religion" id="member_religion" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                        <option value="">Select Member Religion</option>
                    </select>
                    <?php $__errorArgs = ['member_religion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="spouse" class="w-48 text-sm font-medium">Husband/ Wife Name</label>
                <div class="w-full">
                    <input type="text" name="spouse" id="spouse" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter Spouse" value="">
                    <?php $__errorArgs = ['spouse'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="landline_no" class="w-48 text-sm font-medium">Landline No.</label>
                <div class="w-full">
                    <input type="text" name="landline_no" id="landline_no" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter branch landline no" value="">
                    <?php $__errorArgs = ['landline_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="email" class="w-48 text-sm font-medium">Email</label>
                <div class="w-full">
                    <input type="text" name="email" id="email" placeholder="Enter Email" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="mobile_no" class="w-48 text-sm font-medium">Mobile No.<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="mobile_no" id="mobile_no" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter mobile no" value="<?php echo e(old('mobile_no')); ?>">
                    <?php $__errorArgs = ['mobile_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div><br>
            <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
                <h3 class="h2">Promoter's KYC</h3>
            </div>
            <div class="flex items-start gap-4">
                <label for="aadhaar_no" class="w-48 text-sm font-medium">Aadhaar No.</label>
                <div class="w-full">
                    <input type="text" name="aadhaar_no" id="aadhaar_no" placeholder="Enter Aadhaar No" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="<?php echo e(old('gst_no')); ?>">
                    <?php $__errorArgs = ['aadhaar_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <label for="voter_no" class="w-48 text-sm font-medium">Voter ID No.</label>
                <div class="w-full">
                    <input type="text" name="voter_no" id="voter_no" placeholder="Enter Voter ID No" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="<?php echo e(old('gst_no')); ?>">
                    <?php $__errorArgs = ['voter_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="pan_no" class="w-48 text-sm font-medium">PAN No.</label>
                <div class="w-full">
                    <input type="text" name="pan_no" id="pan_no" placeholder="Enter PAN No" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="<?php echo e(old('pan_no')); ?>">
                    <?php $__errorArgs = ['pan_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="ration_no" class="w-48 text-sm font-medium">Ration Card No.</label>
                <div class="w-full">
                    <input type="text" name="ration_no" id="ration_no" placeholder="Enter Ration Card No" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="<?php echo e(old('pan_no')); ?>">
                    <?php $__errorArgs = ['ration_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="meter_no" class="w-48 text-sm font-medium">Meter No.</label>
                <div class="w-full">
                    <input type="text" name="meter_no" id="meter_no" placeholder="Enter Meter No." class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="<?php echo e(old('pan_no')); ?>">
                    <?php $__errorArgs = ['meter_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="ci_no" class="w-48 text-sm font-medium">CI No.</label>
                <div class="w-full">
                    <input type="text" name="ci_no" id="ci_no" placeholder="Enter CI No." class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="<?php echo e(old('pan_no')); ?>">
                    <?php $__errorArgs = ['ci_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="ci_relation" class="w-48 text-sm font-medium">CI Relation.</label>
                <div class="w-full">
                    <input type="text" name="ci_relation" id="ci_relation" placeholder="Enter CI Relation." class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="<?php echo e(old('pan_no')); ?>">
                    <?php $__errorArgs = ['ci_relation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="dl_no" class="w-48 text-sm font-medium">DL No.</label>
                <div class="w-full">
                    <input type="text" name="dl_no" id="dl_no" placeholder="Enter DL No." class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="<?php echo e(old('pan_no')); ?>">
                    <?php $__errorArgs = ['dl_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <br>
            <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
                <h3 class="h2">Nominee Info</h3>
            </div> <br>

            <div class="flex items-start gap-4">
                <label for="nomine_name" class="w-48 text-sm font-medium">Nominee Name</label>
                <div class="w-full">
                    <input type="text" name="nomine_name" id="nomine_name" placeholder="Enter Nominee Name" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="<?php echo e(old('pan_no')); ?>">
                    <?php $__errorArgs = ['nomine_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="nomine_relation" class="w-48 text-sm font-medium">Nominee Relation</label>
                <div class="w-full">
                    <input type="text" name="nomine_relation" id="nomine_relation" placeholder="Enter Nominee Relation" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="<?php echo e(old('pan_no')); ?>">
                    <?php $__errorArgs = ['nomine_relation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="nomine_mobile" class="w-48 text-sm font-medium">Nominee Mobile No.</label>
                <div class="w-full">
                    <input type="text" name="nomine_mobile" id="nomine_mobile" placeholder="Enter Nominee Mobile" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="<?php echo e(old('pan_no')); ?>">
                    <?php $__errorArgs = ['nomine_mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="nomine_aadhar" class="w-48 text-sm font-medium">Nominee Aadhar No.</label>
                <div class="w-full">
                    <input type="text" name="nomine_aadhar" id="nomine_aadhar" placeholder="Enter Nominee Aadhar No." class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="<?php echo e(old('pan_no')); ?>" >
                    <?php $__errorArgs = ['nomine_aadhar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="nomine_voter" class="w-48 text-sm font-medium">Nominee Voter ID No.</label>
                <div class="w-full">
                    <input type="text" name="nomine_voter" id="nomine_voter" placeholder="Enter Nominee Voter ID No." class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="<?php echo e(old('pan_no')); ?>">
                    <?php $__errorArgs = ['nomine_voter'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="nomine_pan" class="w-48 text-sm font-medium">Nominee Pan No.</label>
                <div class="w-full">
                    <input type="text" name="nomine_pan" id="nomine_pan" placeholder="Enter Nominee Pan No." class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="<?php echo e(old('pan_no')); ?>">
                    <?php $__errorArgs = ['nomine_pan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="nomine_address" class="w-48 text-sm font-medium">Nominee Address</label>
                <div class="w-full">
                    <input type="text" name="nomine_address" id="nomine_address" placeholder="Enter Nominee Address" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="">
                    <?php $__errorArgs = ['nomine_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div> <br>
            <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
                <h3 class="h2">Extra Settings</h3>
            </div> <br>
            <div class="flex items-start gap-4">
                <label for="sms" class="w-48 text-sm font-medium">SMS</label>
                <label class="switch">
                    <input type="hidden" name="sms" value="0">
                    <input type="checkbox" name="sms" id="sms" value="1" <?php echo e(old('sms') ? 'checked' : ''); ?>>
                    <div class="slider round">
                        <span class="switch-on">ON</span>
                        <span class="switch-off">OFF</span>
                    </div>
                </label>
            </div>

            <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                <button class="btn-primary" type="submit">
                    Save Promotor
                </button>
                <button class="btn-outline" type="reset" onclick="window.location.href='<?php echo e(route(`ManagePromotor`)); ?>'">
                    Back
                </button>
                <button class="btn-outline" type="reset">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    setTimeout(function() {
        var successAlert = document.getElementById('success-alert');
        var errorAlert = document.getElementById('error-alert');
        if (successAlert) successAlert.style.display = 'none';
        if (errorAlert) errorAlert.style.display = 'none';
    }, 5000);
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "<?php echo e(url('/get-branches')); ?>",
            type: "GET",
            success: function(response) {
                $.each(response, function(key, branch) {
                    $('#branchDropdown').append(`<option value="${branch.id}">${branch.branch_name}</option>`);
                });
            },
            error: function() {
                alert('Failed to fetch branches.');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "<?php echo e(url('/get-marital-statuses')); ?>",
            type: 'GET',
            success: function(response) {
                $.each(response, function(index, status) {
                    $('#mariatal_status').append(`<option value="${status.id}">${status.status}</option>`);
                });
            },
            error: function() {
                alert('Failed to load marital statuses.');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "<?php echo e(url('/get-religion-statuses')); ?>",
            type: 'GET',
            success: function(response) {
                $.each(response, function(index, status) {
                    $('#member_religion').append(`<option value="${status.id}">${status.name}</option>`);
                });
            },
            error: function() {
                alert('Failed to load marital statuses.');
            }
        });
    });
</script>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views\add-promoter.blade.php ENDPATH**/ ?>