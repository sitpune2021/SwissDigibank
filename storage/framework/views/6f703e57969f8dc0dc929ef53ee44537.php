<?php $__env->startSection('content'); ?>
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <!-- <h3 class="h2">Add User</h3> -->
        <h3 class="h2"> <?php echo isset($show) && $show ? $user->fname : (isset($user) ? 'Edit User' : 'New User'); ?></h3>
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
        <form id="companyForm" action="<?php echo e(isset($user) ? ($show ?? false ? '#' : route('user.update', base64_encode($user->id))) : route('CreateUser')); ?>" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
            <?php echo csrf_field(); ?>
            <?php if(isset($user) && empty($show)): ?>
            <?php echo method_field('PUT'); ?>
            <?php endif; ?>
            <?php $isView = !empty($show); ?>
            <div class="col-span-2 md:col-span-1">
                <label for="rate" class="md:text-lg font-medium block mb-4">Employee
                    <select name="employee" id="employeeDropdown" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" <?php if($isView): ?> disabled <?php endif; ?>>
                        <option value="">Select Employee</option>
                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($emp->id); ?>" <?php echo e(old('employee', isset($user) && $user->emp_id == $emp->id? 'selected' : '' )); ?>>
                            <?php echo e($emp->name); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>
                <?php $__errorArgs = ['employee'];
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

            <div class="col-span-2 md:col-span-1"></div>

            <div class="col-span-2 md:col-span-1">
                <label for="designation" class="md:text-lg font-medium block mb-4">Designation</label>
                <input type="text" name="designation" id="designation" value="<?php echo e(old('designation', $user->designation ?? '')); ?>"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" placeholder="Enter Designation like 'Executive'"
                    <?php if($isView): ?> disabled <?php endif; ?>>
                <?php $__errorArgs = ['designation'];
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
                <label for="user_name" class="md:text-lg font-medium block mb-4">Login User Name <span class="text-red-500">*</span></label>
                <input type="text" name="user_name" id="user_name" value="<?php echo e(old('user_name', $user->username ?? '')); ?>"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter User Name" <?php if($isView): ?> disabled <?php endif; ?>>
                <?php $__errorArgs = ['user_name'];
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
                <label for="first_name" class="md:text-lg font-medium block mb-4">First Name<span class="text-red-500">*</span></label>
                <input name="first_name" id="first_name" value="<?php echo e(old('first_name', $user->fname ?? '')); ?>"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter First Name" <?php if($isView): ?> disabled <?php endif; ?>>
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

            <div class="col-span-2 md:col-span-1">
                <label for="last_name" class="md:text-lg font-medium block mb-4">Last Name</label>
                <input type="text" name="last_name" id="last_name" value="<?php echo e(old('last_name', $user->lname ?? '')); ?>" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Last Name" <?php if($isView): ?> disabled <?php endif; ?>>
                <?php $__errorArgs = ['last_name'];
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
                <label for="email" class="md:text-lg font-medium block mb-4">Email</label>
                <input type="text" name="email" value="<?php echo e(old('email', $user->email ?? '')); ?>"
                    id="email" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Email" <?php if($isView): ?> disabled <?php endif; ?>>
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
                <label for="mobile_no" class="md:text-lg font-medium block mb-4">Mobile No.<span class="text-red-500">*</span></label>
                <input type="text" name="mobile_no" id="mobile_no" value="<?php echo e(old('mobile_no', $user->mobile ?? '')); ?>"
                    placeholder="Enter Mobile No." class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    <?php if($isView): ?> disabled <?php endif; ?>>
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
                <label for="back_date" class="md:text-lg font-medium block mb-4">Back Date Entry Days <span class="text-red-500">*</span></label>
                <input type="text" name="back_date" id="back_date"
                    placeholder="Enter Days" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    value="<?php echo e(old('back_date', $user->back_edate_days ?? '0')); ?>

                " <?php if($isView): ?> disabled <?php endif; ?>>
                <?php $__errorArgs = ['back_date'];
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
                <label for="permission_role" class="md:text-lg font-medium block mb-4">Permissions / Roles <span class="text-red-500">*</span></label>
                <select name="permission_role" id="roleDropdown" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" <?php if($isView): ?> disabled <?php endif; ?>>
                    <option value="">Select Role</option>
                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($role->id); ?>" <?php echo e(old('permission_role', isset($user) && $user->role_id == $role->id? 'selected' : '' )); ?>><?php echo e($role->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['permission_role'];
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
                <label for="branch" class="md:text-lg font-medium block mb-4">Branch<span class="text-red-500">*</span></label>
                <select name="branch" id="branchDropdown" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" <?php if($isView): ?> disabled <?php endif; ?>>
                    <option value="">Select Branch</option>
                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($branch->id); ?>" <?php echo e(old('branch', isset($user) && $user->branch_id == $branch->id? 'selected' : '' )); ?>><?php echo e($branch->branch_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['branch'];
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
                <label for="branch" class="md:text-lg font-medium block mb-4">Login on Holidays<span class="text-red-500">*</span></label>
                <select name="login_on_holidays" id="login_on_holidays" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" <?php if($isView): ?> disabled <?php endif; ?>>
                    <option value="">Select Login on Holidays</option>
                    <option value="1" <?php echo e(old('login_on_holidays', $user->login_on_holidays ?? '') == '1' ? 'selected' : ''); ?>> YES</option>
                    <option value="0" <?php echo e(old('login_on_holidays', $user->login_on_holidays ?? '') == '0' ? 'selected' : ''); ?>> NO </option>

                </select>
                <?php $__errorArgs = ['login_on_holidays'];
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
                <label for="user_active" class="md:text-lg font-medium block mb-4">User Active<span class="text-red-500">*</span></label>
                <select name="user_active" id="user_active" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" <?php if($isView): ?> disabled <?php endif; ?>>
                    <option value="">Select User Active</option>
                    <option value="1" <?php echo e(old('user_active', $user->user_active ?? '') == '1' ? 'selected' : ''); ?>> YES</option>
                    <option value="0" <?php echo e(old('user_active', $user->user_active ?? '') == '0' ? 'selected' : ''); ?>> NO </option>
                </select>
                <?php $__errorArgs = ['branch'];
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
                <label for="searchable_account" class="md:text-lg font-medium block mb-4">Searchable Accounts<span class="text-red-500">*</span></label>
                <label><input type="radio" name="searchable_account" value="1" <?php echo e(old('searchable_account', '0') == '1' ? 'checked' : ''); ?> <?php if($isView): ?> disabled <?php endif; ?>> Yes - All</label>
                <label><input type="radio" name="searchable_account" value="0" <?php echo e(old('searchable_account', '0') == '0' ? 'checked' : ''); ?> <?php if($isView): ?> disabled <?php endif; ?>> No - Only Assigned</label>
                <?php $__errorArgs = ['searchable_account'];
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

            <!-- <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                <button class="btn-primary" type="submit">Save</button>
                <button class="btn-outline" type="reset" onclick="document.getElementById('companyForm').reset();">Reset</button>
            </div> -->
            <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                
                <?php if(empty($isView)): ?>
                <button class="btn-primary" type="submit">
                    <?php echo e(isset($user) ? 'Update User' : 'Save User'); ?>

                </button>
                <?php endif; ?>

                
                <?php if(!isset($user) && empty($isView)): ?>
                <button class="btn-outline" type="reset">
                    Reset
                </button>
                <?php endif; ?>

                
                <?php if(!empty($isAdd) || isset($user) || !empty($isView)): ?>
                <button class="btn-outline" type="button" onclick="window.location.href='<?php echo e(route('manage.user')); ?>'">
                    Back
                </button>
                <?php endif; ?>
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
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views\users\add-user.blade.php ENDPATH**/ ?>