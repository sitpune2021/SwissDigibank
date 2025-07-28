<?php $__env->startSection('content'); ?>

<div class="main-inner">

    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">

        <h3 class="h2">New Employee</h3>

    </div>

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
        <form id="companyForm" action="<?php echo e(isset($employee) ? ($show ?? false ? '#' : route('employee.update', base64_encode($employee->id))) : route('AddEmployee')); ?>" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
            <?php echo csrf_field(); ?>
            <?php if(isset($employee) && empty($show)): ?>
            <?php echo method_field('PUT'); ?>
            <?php endif; ?>
            <?php $isView = !empty($show); ?>
            <div class="col-span-2 md:col-span-1">
                <label for="member" class="md:text-lg font-medium block mb-4">Link Member Profile
                    <input type="hidden" id="selectedMemberId" value="<?php echo e(isset($employee) ? $employee->member_id : ''); ?>">
                    <?php if(isset($isView) && $isView): ?>
                    
                    <input type="text" value="<?php echo e($employee->members->first_name ?? 'N/A'); ?>" <?php if($isView): ?> disabled <?php endif; ?>
                        class="w-full text-sm bg-gray-100 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    <?php else: ?>

                    <select name="member" id="memberDropdown" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" <?php if($isView): ?> disabled <?php endif; ?>>
                        <option value="">Select Member</option>
                        <!-- Dynamic options here -->
                    </select>

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
                    <?php endif; ?>

            </div>

            <div class="col-span-2 md:col-span-1">

                <label for="branch" class="md:text-lg font-medium block mb-4">Branch<span

                        class="text-red-500">*</span></label>

                <!-- <select name="branch" id="branchDropdown"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

                    <option value="">Select</option>

                </select> -->
                <input type="hidden" id="selectedBranchId" value="<?php echo e(isset($employee) ? $employee->branch_id : ''); ?>">
                <?php if(isset($isView) && $isView): ?>
                
                <input type="text" value="<?php echo e($employee->branches->branch_name ?? 'N/A'); ?>" <?php if($isView): ?> disabled <?php endif; ?>
                    class="w-full text-sm bg-gray-100 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                <?php else: ?>
                <select name="branch" id="branchDropdown" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" <?php if($isView): ?> disabled <?php endif; ?>>
                    <option value="">Select</option>
                    <!-- Dynamic options here -->
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
                <?php endif; ?>
            </div>

            <div class="col-span-2 md:col-span-1">

                <label for="joining_date" class="md:text-lg font-medium block mb-4">Joining Date<span

                        class="text-red-500">*</span></label>

                <div class="relative">

                    <!-- <input name="joining_date" id="date2" class="border-none" placeholder="DD/MM/YYYY" value="<?php echo e(old('joining_date')); ?>"

                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" autocomplete="off" /> -->
                    <input name="joining_date" id="date2" type="text" placeholder="DD/MM/YYYY"
                        value="<?php echo e(old('joining_date', $employee->joining_date ?? '')); ?>"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" autocomplete="off" <?php if($isView): ?> disabled <?php endif; ?>>
                    <i

                        class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>

                </div>

                <?php $__errorArgs = ['joining_date'];
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

            <div class="col-span-2 md:col-span-1">

                <label for="name" class="md:text-lg font-medium block mb-4">Designation</span></label>

                <input type="text" name="designation" id="designation" placeholder="Enter Designation like 'Executive'"
                    value="<?php echo e(old('designation', $employee->designation ?? '')); ?>" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" <?php if($isView): ?> disabled <?php endif; ?>>

                <?php $__errorArgs = ['designation'];
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


            <div class="col-span-2 md:col-span-1">

                <label for="name" class="md:text-lg font-medium block mb-4">Name</span><span

                        class="text-red-500">*</span></label>

                <!-- <input type="text" name="email" value="<?php echo e(old('email')); ?>" id="email"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    placeholder="Enter Email" value=""> -->

                <input type="text" name="name" id="name" placeholder="Enter Name"
                    value="<?php echo e(old('name', $employee->name ?? '')); ?>" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" <?php if($isView): ?> disabled <?php endif; ?>>

                <?php $__errorArgs = ['name'];
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

            <div class="col-span-2 md:col-span-1">
                <label for="gender" class="md:text-lg font-medium block mb-4">
                    Gender <span class="text-red-500">*</span>
                </label>

                <label class="mr-4">
                    <!-- <input type="radio" name="gender" value="male" <?php echo e(old('gender') == 'male' ? 'checked' : ''); ?>> -->
                    <input type="radio" name="gender" value="male" <?php echo e(old('gender', $employee->gender ?? '') == 'male' ? 'checked' : ''); ?> <?php if($isView): ?> disabled <?php endif; ?>> Male
                    <!-- Male -->
                </label>

                <label>
                    <!-- <input type="radio" name="gender" value="female" <?php echo e(old('gender') == 'female' ? 'checked' : ''); ?>> -->
                    <input type="radio" name="gender" value="female" <?php echo e(old('gender', $employee->gender ?? '') == 'female' ? 'checked' : ''); ?> <?php if($isView): ?> disabled <?php endif; ?>> Female
                    <!-- Female -->
                </label>

                <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-red-500 text-xs block mt-2"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>


            <div class="col-span-2 md:col-span-1">

                <label for="dob" class="md:text-lg font-medium block mb-4">Date of Birth<span

                        class="text-red-500">*</span></label>

                <div class="relative">

                    <!-- <input name="dob" id="date" class="border-none" placeholder="DD/MM/YYYY" value="<?php echo e(old('dob')); ?>" -->
                    <input name="dob" id="date" type="text" placeholder="DD/MM/YYYY"
                        value="<?php echo e(old('dob', $employee->dob ?? '')); ?>" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" autocomplete="off" <?php if($isView): ?> disabled <?php endif; ?>>

                    <!-- class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" autocomplete="off" /> -->

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

            <div class="col-span-2 md:col-span-1">

                <label for="email" class="md:text-lg font-medium block mb-4">Email</span></label>

                <!-- <input type="text" name="email" value="<?php echo e(old('email')); ?>" id="email"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    placeholder="Enter Email" value=""> -->

                <input type="text" name="email" id="email" value="<?php echo e(old('email', $employee->email ?? '')); ?>" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" <?php if($isView): ?> disabled <?php endif; ?>>

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



            <div class="col-span-2 md:col-span-1">

                <label for="mobile_no" class="md:text-lg font-medium block mb-4">Mobile No.<span

                        class="text-red-500">*</span></label>

                <!-- <input type="text" name="mobile_no" id="mobile_no" value="<?php echo e(old('mobile_no')); ?>"

                    placeholder="Enter Mobile No."

                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    value=""> -->
                <input type="text" name="mobile_no" id="mobile_no" value="<?php echo e(old('mobile_no', $employee->mobile_no ?? '')); ?>" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" <?php if($isView): ?> disabled <?php endif; ?>>

                <?php $__errorArgs = ['mobile_no'];
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

            <div class="col-span-2 md:col-span-1">

                <label for="address" class="md:text-lg font-medium block mb-4">Address</label>

                <input type="text" name="address" id="address" placeholder="Enter Address"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    value="<?php echo e(old('address', $employee->address ?? '')); ?>" <?php if($isView): ?> disabled <?php endif; ?>>

                <?php $__errorArgs = ['address'];
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

            <div class="col-span-2 md:col-span-1">

                <label for="father_name" class="md:text-lg font-medium block mb-4">Father Name</label>

                <input type="text" name="father_name" id="father_name" placeholder="Enter Father Name"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    value="<?php echo e(old('father_name', $employee->father_name ?? '')); ?>" <?php if($isView): ?> disabled <?php endif; ?>>

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

            <div class="col-span-2 md:col-span-1">

                <label for="pan_no" class="md:text-lg font-medium block mb-4">PAN No.</label>

                <input type="text" name="pan_no" id="pan_no" placeholder="Enter PAN No"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    value="<?php echo e(old('pan_no', $employee->pan_no ?? '')); ?>" <?php if($isView): ?> disabled <?php endif; ?>>

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

            <div class="col-span-2 md:col-span-1">

                <label for="aadhar_no" class="md:text-lg font-medium block mb-4">Aadhaar No.</label>

                <input type="text" name="aadhar_no" id="aadhar_no" placeholder="Enter Aadhar No"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    value="<?php echo e(old('aadhar_no', $employee->aadhar_no ?? '')); ?>" <?php if($isView): ?> disabled <?php endif; ?>>

                <?php $__errorArgs = ['aadhar_no'];
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

            <div class="col-span-2 md:col-span-1">

                <label for="blood_group" class="md:text-lg font-medium block mb-4">Blood Group</label>
                <input type="hidden" id="selectedBloodId" value="<?php echo e(isset($employee) ? $employee->blood_group : ''); ?>">
                <?php if(isset($isView) && $isView): ?>
                
                <input type="text" value="<?php echo e($employee->bloodgroups->group ?? 'N/A'); ?>" <?php if($isView): ?> disabled <?php endif; ?>
                    class="w-full text-sm bg-gray-100 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                <?php else: ?>
                <select name="blood_group" id="bloodGroupDropdown"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

                    <option value="">Select Blood Group</option>

                </select>

                <?php $__errorArgs = ['blood_group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>

                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php endif; ?>

            </div>

            <div class="col-span-2 md:col-span-1">

                <label for="monthly_salary" class="md:text-lg font-medium block mb-4">Monthly Salary</label>

                <input type="number" name="monthly_salary" id="monthly_salary" placeholder="Enter Monthly Salary"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    value="<?php echo e(old('monthly_salary', $employee->monthly_salary ?? '')); ?>" <?php if($isView): ?> disabled <?php endif; ?>>

                <?php $__errorArgs = ['monthly_salary'];
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

            <div class="col-span-2 md:col-span-1">

                <label for="location" class="md:text-lg font-medium block mb-4">Location</label>

                <input type="text" name="location" id="location" placeholder="Enter Location"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    value="<?php echo e(old('location', $employee->location ?? '')); ?>" <?php if($isView): ?> disabled <?php endif; ?>>

                <?php $__errorArgs = ['location'];
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
            <h4>Bank Info</h4> <br>
            <div class="col-span-2 md:col-span-1">

                <label for="account_holder" class="md:text-lg font-medium block mb-4">Bank A/c Holder's Name</label>

                <input type="text" name="account_holder" id="account_holder" placeholder="Enter Account Holder"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    value="<?php echo e(old('account_holder', $employee->account_holder ?? '')); ?>" <?php if($isView): ?> disabled <?php endif; ?>>

                <?php $__errorArgs = ['account_holder'];
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

            <div class="col-span-2 md:col-span-1">

                <label for="bank_name" class="md:text-lg font-medium block mb-4">Bank Name</label>
                <?php if(isset($isView) && $isView): ?>
                
                <input type="text" value="<?php echo e($employee->bankname->name ?? 'N/A'); ?>" <?php if($isView): ?> disabled <?php endif; ?>
                    class="w-full text-sm bg-gray-100 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                <?php else: ?>
                <select name="bank_name" id="bankDropdown"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border rounded-10 border-n30 dark:border-n500 px-3 md:px-6 py-2 md:py-3">

                    <option value="">Select Bank</option>

                </select>

                <?php $__errorArgs = ['bank_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>

                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php endif; ?>
            </div>

            <div class="col-span-2 md:col-span-1">

                <label for="account_no" class="md:text-lg font-medium block mb-4">Bank Account No</label>

                <input type="number" name="account_no" id="account_holder" placeholder="Enter Bank A/C No"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    value="<?php echo e(old('account_no', $employee->account_no ?? '')); ?>" <?php if($isView): ?> disabled <?php endif; ?>>

                <?php $__errorArgs = ['account_no'];
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

            <div class="col-span-2 md:col-span-1">

                <label for="ifsc" class="md:text-lg font-medium block mb-4">Bank IFSC</label>

                <input type="text" name="ifsc" id="ifsc" placeholder="Enter IFSC Code"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    value="<?php echo e(old('ifsc', $employee->ifsc ?? '')); ?>" <?php if($isView): ?> disabled <?php endif; ?>>

                <?php $__errorArgs = ['ifsc'];
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

            <h4>Nominee Info</h4><br>

            <div class="col-span-2 md:col-span-1">

                <label for="nominee_name" class="md:text-lg font-medium block mb-4">Nominee Name</label>

                <input type="text" name="nominee_name" id="nominee_name" placeholder="Enter Nominee Name"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    value="<?php echo e(old('nominee_name', $employee->nominee_name ?? '')); ?>" <?php if($isView): ?> disabled <?php endif; ?>>

                <?php $__errorArgs = ['nominee_name'];
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

            <div class="col-span-2 md:col-span-1">

                <label for="nominee_relation" class="md:text-lg font-medium block mb-4">Nominee Relation</label>
                <input type="hidden" id="selectedRelationId" value="<?php echo e(isset($employee) ? $employee->nominee_relation  : ''); ?>">

                <?php if(isset($isView) && $isView): ?>
                
                <input type="text" value="<?php echo e($employee->nominee_relations->relation ?? 'N/A'); ?>" <?php if($isView): ?> disabled <?php endif; ?>
                    class="w-full text-sm bg-gray-100 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                <?php else: ?>
                <select name="nominee_relation" id="nomineeDropdown"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 rounded-10 border border-n30 dark:border-n500 px-3 md:px-6 py-2 md:py-3">

                    <option value="">Select Relation</option>

                </select>

                <?php $__errorArgs = ['nominee_relation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>

                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php endif; ?>

            </div>

            <div class="col-span-2 md:col-span-1">

                <label for="nominee_address" class="md:text-lg font-medium block mb-4">Nominee Address</label>

                <input type="text" name="nominee_address" id="nominee_address" placeholder="Enter Nominee Address"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    value="<?php echo e(old('nominee_address', $employee->nominee_address ?? '')); ?>" <?php if($isView): ?> disabled <?php endif; ?>>

                <?php $__errorArgs = ['nominee_address'];
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
            <br>

            <h4>Link With Software Accounting</h4><br>

            <div class="col-span-2 md:col-span-1">

                <label for="nominee_address" class="md:text-lg font-medium block mb-4">Auto Generate Payable Ledger</label>

                <input type="checkbox" name="auto_generate" id="auto_generate_checkbox"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    value="true" style="height: 17px; width: 17px; margin: 0px; margin-top: -2px; vertical-align: middle;" <?php echo e((!empty($employee) && $employee->auto_generate) ? 'checked' : ''); ?>

                    <?php echo e((!empty($isView) && $isView) ? 'disabled' : ''); ?>>

                <span class="ft-600 co-red" id="ledger_note" style="color: red;">( Check this for auto generate )</span>

                <?php $__errorArgs = ['nominee_address'];
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

            <div class="col-span-2 md:col-span-1">
                <input type="hidden" id="selectedledgerId" value="<?php echo e(isset($employee) ? $employee->payable_ledger : ''); ?>">


                <label for="payable_ledger" class="md:text-lg font-medium block mb-4">Linked Accounting Payable Ledger</label>
                <?php if(isset($isView) && $isView): ?>
                <input type="text" value="<?php echo e($employee?->payableLedgers?->name ?? 'N/A'); ?>" <?php if($isView): ?> disabled <?php endif; ?>
                    class="w-full text-sm bg-gray-100 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                <?php else: ?>
                <select name="payable_ledger" id="payableDropdown"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

                    <option value="">Select Accounting Payable Ledger</option>

                </select>

                <?php $__errorArgs = ['payable_ledger'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>

                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php endif; ?>
            </div>

            <div class="col-span-2 md:col-span-1">

                <label for="expense_ledger" class="md:text-lg font-medium block mb-4">Linked Accounting Expense Ledger</label>
                <?php if(isset($isView) && $isView): ?>
                <input type="text" value="<?php echo e($employee->payableExpenses?->name ?? 'N/A'); ?>" <?php if($isView): ?> disabled <?php endif; ?>
                    class="w-full text-sm bg-gray-100 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                <?php else: ?>
                <select name="expense_ledger" id="expenseDropdown"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

                    <option value="">Select Accounting Expense Ledger</option>

                </select>

                <?php $__errorArgs = ['expense_ledger'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                <span class="text-red-500 text-xs ml-52 block"><?php echo e($message); ?></span>

                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php endif; ?>
            </div>
    </div>

    <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
        <?php if(empty($isView)): ?>
        <button class="btn-primary" type="submit">

            <!-- Save Employee -->
            <?php echo e(isset($employee) ? 'Update Employee' : 'Add Employee'); ?>


        </button>
        <?php endif; ?>
        <button class="btn-outline" type="reset"
            onclick="window.location.href='<?php echo e(route('ManageEmployee')); ?>'">Back</button>
        <?php if(!isset($employee)): ?>
        <button class="btn-outline" type="reset" onclick="document.getElementById('companyForm').reset();">
            Reset
        </button>
        <?php endif; ?>
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

<script>
    $(document).ready(function() {
        const selectedId = $('#selectedMemberId').val();
        $.ajax({
            url: "<?php echo e(url('/get-promoters')); ?>",
            type: 'GET',
            success: function(response) {
                let dropdown = $('#memberDropdown');
                dropdown.empty();
                dropdown.append('<option value="">Select Member</option>');
                $.each(response, function(index, member) {
                    let selected = (selectedId == member.id) ? 'selected' : '';
                    dropdown.append(
                        `<option value="${member.id}" ${selected}>${member.member_no} - ${member.first_name}</option>`
                    );
                });
            },
            error: function() {
                alert('Failed to load members and promoers.');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        const selectedBranchId = $('#selectedBranchId').val();
        $.ajax({
            url: "<?php echo e(url('/get-branches')); ?>",
            type: "GET",
            success: function(response) {
                let dropdown = $('#branchDropdown');
                dropdown.empty();
                dropdown.append('<option value="">Select Branch</option>');

                $.each(response, function(index, branch) {
                    let selected = (selectedBranchId == branch.id) ? 'selected' : '';
                    dropdown.append(
                        `<option value="${branch.id}" ${selected}>${branch.branch_code} - ${branch.branch_name}</option>`
                    );
                });
            },
            error: function() {
                alert('Failed to fetch branches.');
            }
        });
    });
</script>
<script>
    const selectedRelationId = $('#selectedRelationId').val();
    $(document).ready(function() {
        $.ajax({
            url: "<?php echo e(url('/get-relation')); ?>",
            type: "GET",
            // success: function(response) {
            //     $.each(response, function(key, relation) {
            //         $('#nomineeDropdown').append(`<option value="${relation.id}">${relation.relation}</option>`);
            //     });
            // },
            success: function(response) {
                let dropdown = $('#nomineeDropdown');
                dropdown.empty();
                dropdown.append('<option value="">Select Relationship</option>');

                $.each(response, function(index, relation) {
                    let selected = (selectedRelationId == relation.id.toString()) ? 'selected' : '';
                    dropdown.append(`<option value="${relation.id}" ${selected}>${relation.relation}</option>`);
                });
            },
            error: function() {
                alert('Failed to fetch relations.');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        const selectedId = $('#selectedBankId').val();
        $.ajax({
            url: "<?php echo e(url('/get-bank')); ?>",
            type: "GET",
            success: function(response) {
                $.each(response, function(key, bank) {
                    $('#bankDropdown').append(`<option value="${bank.id}">${bank.name}</option>`);
                });
                console.log(response.id);
            },
            error: function() {
                alert('Failed to fetch banks.');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        const selectedId = $('#selectedexpenseId').val();
        $.ajax({
            url: "<?php echo e(url('/get-payable-expense')); ?>",
            type: "GET",
            success: function(response) {
                $.each(response, function(key, expense) {
                    $('#expenseDropdown').append(`<option value="${expense.id}">${expense.name}</option>`);
                });
            },
            error: function() {
                alert('Failed to fetch banks.');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        const selectedledgerId = $('#selectedledgerId').val();
        $.ajax({
            url: "<?php echo e(url('/get-payable-ledger')); ?>",
            type: "GET",
            success: function(response) {
                let dropdown = $('#payableDropdown');
                dropdown.empty();
                dropdown.append('<option value="">Select Accounting Payable Ledger</option>');
                console.log("Selected ID:", selectedledgerId);
                console.log(response);

                $.each(response, function(key, ledger) {
                    // let selected = (selectedledgerId == ledger.id) ? 'selected' : '';
                    let selected = (selectedledgerId.toString() === ledger.id.toString()) ? 'selected' : '';
                    dropdown.append(`<option value="${ledger.id}" ${selected}>${ledger.name}</option>`);
                });
            },
            error: function() {
                alert('Failed to fetch banks.');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        const selectedBloodId = $('#selectedBloodId').val();
        $.ajax({
            url: "<?php echo e(url('/get-blood-group')); ?>",
            type: "GET",
            success: function(response) {
                let dropdown = $('#bloodGroupDropdown');
                dropdown.empty();
                dropdown.append('<option value="">Select Blood Group</option>');

                $.each(response, function(index, blood) {
                    let selected = (selectedBloodId == blood.id.toString()) ? 'selected' : '';
                    dropdown.append(
                        `<option value="${blood.id}" ${selected}>${blood.group}</option>`
                    );
                });
            },
            error: function() {
                alert('Failed to fetch banks.');
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const checkbox = document.getElementById("auto_generate_checkbox");
        const ledgerDropdown = document.getElementById("payableDropdown");

        // Function to toggle ledger dropdown based on checkbox state
        function toggleLedgerDropdown() {
            if (checkbox.checked) {
                ledgerDropdown.disabled = true;
            } else {
                ledgerDropdown.disabled = false;
            }
        }
        toggleLedgerDropdown();

        checkbox.addEventListener("change", toggleLedgerDropdown);
    });
</script>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views\employees\add-employee.blade.php ENDPATH**/ ?>