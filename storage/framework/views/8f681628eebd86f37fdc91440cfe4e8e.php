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
        <a href="" class="btn-warning" style="padding: 4px 8px; font-size: 12px;">
            <i class="las la-eye text-base md:text-lg" style="font-size: 14px;"></i>
            View Member
        </a>
        <?php if(session('success')): ?>
            <div id="success-alert"
                style="background-color: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
                <strong>Success:</strong> <?php echo e(session('success')); ?>

                <span onclick="document.getElementById('success-alert').style.display='none';"
                    style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #155724;">&times;</span>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div id="error-alert"
                style="background-color: #f8d7da; border: 1px solid #dc3545; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
                <strong>Error:</strong> <?php echo e(session('error')); ?>

                <span onclick="document.getElementById('error-alert').style.display='none';"
                    style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #721c24;">&times;</span>
            </div>
        <?php endif; ?>

        <div class="box mb-4 xxxl:mb-6">
            <form action="<?php echo e(route('member.show')); ?>" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
                <?php echo csrf_field(); ?>
                <!-- -------------------------------------------------------------------------------------- -->
                <div class="flex items-start gap-4">
                    <label for="membership" class="w-48 text-sm font-medium">Membership Type:<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="membership" id="membership"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Membership Type" value="<?php echo e(old('membership')); ?>">
                        <?php $__errorArgs = ['membership'];
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
                <!-- ------------------------------------------------------------------------------------->
                <div class="flex items-start gap-4">
                    <label for="create" class="w-48 text-sm font-medium">Create on <span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="create" id="create"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter create on" value="<?php echo e(old('create')); ?>">
                        <?php $__errorArgs = ['create'];
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

                <!-------------------------------------------------------------------------->
                <div class="flex items-start gap-4">
                    <label for="create" class="w-48 text-sm font-medium">Created by:<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="create" id="create"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter create by" value="<?php echo e(old('create')); ?>">
                        <?php $__errorArgs = ['create'];
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
                <!-- ------------------------------------------------------- -->
                <div class="flex items-start gap-4">
                    <label for="member" class="w-48 text-sm font-medium">Status<span class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="member" id="member"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Status name" value="<?php echo e(old('member')); ?>">
                        <?php $__errorArgs = ['member'];
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
                <!------------------------------------------------------------------------------------- -->

                <div class="flex items-start gap-4">
                    <label for="branch" class="w-48 text-sm font-medium">Branch:</label>
                    <span class="text-red-500">*</span>

                    <div class="w-full">
                        <input type="text" name="branch" id="branch"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter branch name" value="">
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
                <!-- ------------------------------------------------------------------------------------------------ -->

                <div class="flex items-start gap-4">
                    <label for="Advisor/ Staff" class="w-48 text-sm font-medium">Advisor/ Staff</span></label>
                    <div class="w-full">
                        <input type="text" name="Advisor/ Staff" id="Advisor/ Staff"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Advisor/ Staff" value="<?php echo e(old('Advisor/ Staff')); ?>">
                        <?php $__errorArgs = ['Advisor/ Staff'];
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
                <!-- ------------------------------------------------------------------------------------------------ -->
                <div class="flex items-start gap-4">
                    <label for="Old Member No" class="w-48 text-sm font-medium">Old Member No :<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="Old Member No" id="Old Member No"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Old Member No" value="">
                        <?php $__errorArgs = ['Old Member No'];
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
                <!-- ------------------------------------------------------------------------------------------------ -->
                <!-- Enrollment Date -->
                <div class="flex items-start gap-4">
                    <label for="enrollment_date" class="w-48 text-sm font-medium">Enrollment Date<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="date" name="enrollment_date" id="enrollment_date"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="<?php echo e(old('enrollment_date')); ?>">
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

                <!-- Name -->
                <div class="flex items-start gap-4">
                    <label for="name" class="w-48 text-sm font-medium">Name<span class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="name" id="name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter full name" value="<?php echo e(old('name')); ?>">
                        <?php $__errorArgs = ['name'];
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

                <!-- DOB -->
                <div class="flex items-start gap-4">
                    <label for="dob" class="w-48 text-sm font-medium">DOB<span class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="date" name="dob" id="dob"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="<?php echo e(old('dob')); ?>">
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

                <!-- Age -->
                <div class="flex items-start gap-4">
                    <label for="age" class="w-48 text-sm font-medium">Age<span class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="number" name="age" id="age"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter age" value="<?php echo e(old('age')); ?>">
                        <?php $__errorArgs = ['age'];
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

                <!-- Senior Citizen -->
                <div class="flex items-start gap-4">
                    <label for="senior_citizen" class="w-48 text-sm font-medium">Senior Citizen<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <select name="senior_citizen" id="senior_citizen"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select</option>
                            <option value="Yes" <?php echo e(old('senior_citizen') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
                            <option value="No" <?php echo e(old('senior_citizen') == 'No' ? 'selected' : ''); ?>>No</option>
                        </select>
                        <?php $__errorArgs = ['senior_citizen'];
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

                <!-- Gender -->
                <div class="flex items-start gap-4">
                    <label for="gender" class="w-48 text-sm font-medium">Gender<span class="text-red-500">*</span></label>
                    <div class="w-full">
                        <select name="gender" id="gender"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select</option>
                            <option value="Male" <?php echo e(old('gender') == 'Male' ? 'selected' : ''); ?>>Male</option>
                            <option value="Female" <?php echo e(old('gender') == 'Female' ? 'selected' : ''); ?>>Female</option>
                            <option value="Other" <?php echo e(old('gender') == 'Other' ? 'selected' : ''); ?>>Other</option>
                        </select>
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

                <!-- Folio No. -->
                <div class="flex items-start gap-4">
                    <label for="folio_no" class="w-48 text-sm font-medium">Folio No.<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="folio_no" id="folio_no"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Folio Number" value="<?php echo e(old('folio_no')); ?>">
                        <?php $__errorArgs = ['folio_no'];
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

                <!-- Father Name -->
                <div class="flex items-start gap-4">
                    <label for="father_name" class="w-48 text-sm font-medium">Father Name</label>
                    <div class="w-full">
                        <input type="text" name="father_name" id="father_name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Father's Name" value="<?php echo e(old('father_name')); ?>">
                    </div>
                </div>

                <!-- Mother Name -->
                <div class="flex items-start gap-4">
                    <label for="mother_name" class="w-48 text-sm font-medium">Mother Name</label>
                    <div class="w-full">
                        <input type="text" name="mother_name" id="mother_name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Mother's Name" value="<?php echo e(old('mother_name')); ?>">
                    </div>
                </div>

                <!-- Marital Status -->
                <div class="flex items-start gap-4">
                    <label for="marital_status" class="w-48 text-sm font-medium">Marital Status</label>
                    <div class="w-full">
                        <select name="marital_status" id="marital_status"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select</option>
                            <option value="Single" <?php echo e(old('marital_status') == 'Single' ? 'selected' : ''); ?>>Single</option>
                            <option value="Married" <?php echo e(old('marital_status') == 'Married' ? 'selected' : ''); ?>>Married
                            </option>
                            <option value="Divorced" <?php echo e(old('marital_status') == 'Divorced' ? 'selected' : ''); ?>>Divorced
                            </option>
                            <option value="Widowed" <?php echo e(old('marital_status') == 'Widowed' ? 'selected' : ''); ?>>Widowed
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Religion -->
                <div class="flex items-start gap-4">
                    <label for="religion" class="w-48 text-sm font-medium">Religion</label>
                    <div class="w-full">
                        <input type="text" name="religion" id="religion"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Religion" value="<?php echo e(old('religion')); ?>">
                    </div>
                </div>

                <!-- Qualification -->
                <div class="flex items-start gap-4">
                    <label for="qualification" class="w-48 text-sm font-medium">Qualification<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="qualification" id="qualification"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Qualification" value="<?php echo e(old('qualification')); ?>">
                        <?php $__errorArgs = ['qualification'];
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

                <!-- Husband/Wife Name -->
                <div class="flex items-start gap-4">
                    <label for="spouse_name" class="w-48 text-sm font-medium">Husband/Wife Name<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="spouse_name" id="spouse_name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Spouse Name" value="<?php echo e(old('spouse_name')); ?>">
                        <?php $__errorArgs = ['spouse_name'];
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

                <!-- Husband/Wife D.O.B -->
                <div class="flex items-start gap-4">
                    <label for="spouse_dob" class="w-48 text-sm font-medium">Husband/Wife D.O.B<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="date" name="spouse_dob" id="spouse_dob"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="<?php echo e(old('spouse_dob')); ?>">
                        <?php $__errorArgs = ['spouse_dob'];
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

                <!-- Occupation -->
                <div class="flex items-start gap-4">
                    <label for="occupation" class="w-48 text-sm font-medium">Occupation<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="occupation" id="occupation"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Occupation" value="<?php echo e(old('occupation')); ?>">
                        <?php $__errorArgs = ['occupation'];
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

                <!-- Monthly Income -->
                <div class="flex items-start gap-4">
                    <label for="monthly_income" class="w-48 text-sm font-medium">Monthly Income<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="number" name="monthly_income" id="monthly_income"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Monthly Income" value="<?php echo e(old('monthly_income')); ?>">
                        <?php $__errorArgs = ['monthly_income'];
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

                <!-- Collection Time -->
                <div class="flex items-start gap-4">
                    <label for="collection_time" class="w-48 text-sm font-medium">Collection Time<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="time" name="collection_time" id="collection_time"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="<?php echo e(old('collection_time')); ?>">
                        <?php $__errorArgs = ['collection_time'];
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

                <!-- Form 15G/15H Uploaded -->
                <div class="flex items-start gap-4">
                    <label for="form_15g_15h" class="w-48 text-sm font-medium">Form 15G/15H Uploaded<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <select name="form_15g_15h" id="form_15g_15h"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select</option>
                            <option value="Yes" <?php echo e(old('form_15g_15h') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
                            <option value="No" <?php echo e(old('form_15g_15h') == 'No' ? 'selected' : ''); ?>>No</option>
                        </select>
                        <?php $__errorArgs = ['form_15g_15h'];
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
                <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                    <button class="btn-primary" type="submit">
                        Save Director
                    </button>
                    <button class="btn-outline" type="reset"
                        onclick="window.location.href='<?php echo e(route(`ManagePromotor`)); ?>'">
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

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views\member\show.blade.php ENDPATH**/ ?>