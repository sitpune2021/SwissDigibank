<?php $__env->startSection('content'); ?>
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <h3 class="h2"><?php echo e(isset($account) ? 'Edit' : 'Add'); ?> Account</h3>
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
        <form id="accountForm" action="<?php echo e($route); ?>" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
            <?php echo csrf_field(); ?>
            <?php if($method === 'PUT'): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            
            <div class="col-span-2 md:col-span-1">
                <label class="font-medium block mb-4">Account Type <span class="text-red-500">*</span></label>
                <div class="flex gap-5">
                    <label>
                        <input type="radio" name="account_type" value="saving"
                            <?php echo e(old('account_type', $account->account_type ?? 'saving') === 'saving' ? 'checked' : ''); ?>>
                        Saving
                    </label>
                    <label>
                        <input type="radio" name="account_type" value="current"
                            <?php echo e(old('account_type', $account->account_type ?? '') === 'current' ? 'checked' : ''); ?>>
                        Current
                    </label>
                </div>
            </div>

            
            <div class="col-span-2 md:col-span-1 firm-field-wrapper">
                <div id="firmNameDiv" class="hidden">
                    <label for="firm_d" class="font-medium block mb-4">Firm Name <span class="text-red-500">*</span></label>
                    <input type="text" name="firm_d" id="firm_d"
                        value="<?php echo e(old('firm_d', $account->firm_d ?? '')); ?>"
                        class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3"
                        placeholder="Enter firm name">
                    <?php $__errorArgs = ['firm_d'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs block mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            
            <div class="col-span-2 md:col-span-1">
                <label for="member_id_main" class="font-medium block mb-4">Member <span class="text-red-500">*</span></label>
                <select name="member_id" id="member_id_main" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >
                    <option value="">-- Select Member --</option>
                    <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($member->id); ?>" <?php echo e(old('member_id', $account->member_id ?? '') == $member->id ? 'selected' : ''); ?>>
                                <?php echo e("MEM -". $member->id . ' - ' . $member->member_info_first_name . ' ' . $member->member_info_last_name); ?>

                        </option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['member_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs block mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="col-span-2 md:col-span-1">
                <label for="member_name" class="font-medium block mb-4">Member Name</label>
                <input type="text" readonly name="member_name" id="member_name"
                    value="<?php echo e(old('member_name', $account->member_name ?? '')); ?>"
                    class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" placeholder="Member name">
            </div>

            
            <div class="col-span-2 md:col-span-1">
                <label for="member_address" class="font-medium block mb-4">Member Address</label>
                <input type="text" readonly name="member_address" id="member_address"
                    value="<?php echo e(old('member_address', $account->member_address ?? '')); ?>"
                    class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" placeholder="Member address">
            </div>

            
            <div class="col-span-2 md:col-span-1">
                <label for="member_mobile" class="font-medium block mb-4">Member Mobile No.</label>
                <input type="text" name="member_mobile" readonly id="member_mobile"
                    value="<?php echo e(old('member_mobile', $account->member_mobile ?? '')); ?>"
                    class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" placeholder="Mobile number">
            </div>

            
            <div class="col-span-2 md:col-span-1">
                <label for="minor_id" class="font-medium block mb-4">Minor</label>
                <select name="minor_id" id="minor_id" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3">
                   <option>-- Select Minor --</option>
                </select>
            </div>

            
            <div class="col-span-2 md:col-span-1">
                <label for="branch_id" class="font-medium block mb-4">Branch <span class="text-red-500">*</span></label>
                    <select name="branch_id" id="branch_id" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >
                        <option value="">-- Select Branch --</option>
                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $branchName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e(old('branch_id', $account->branch_id ?? '') == $id ? 'selected' : ''); ?>>
                                    <?php echo e(ucfirst($branchName)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
            </div>

            
            <div class="col-span-2 md:col-span-1">
                <label for="advisor_id" class="font-medium block mb-4">Advisor/Staff</label>
                <select name="advisor_id" id="advisor_id" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >
                        <option value="">-- Select Branch --</option>
                            <?php $__currentLoopData = $advisors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $advisors): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e(old('advisor_id', $account->advisor_id ?? '') == $id ? 'selected' : ''); ?>>
                                    <?php echo e($advisors); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
            </div>

            
            <div class="col-span-2 md:col-span-1">
                <label for="scheme_id" class="font-medium block mb-4">Scheme <span class="text-red-500">*</span></label>
                <select name="scheme_id" id="scheme_id" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >
                    <option value="">-- Select Scheme --</option>
                    <option value="1">-- Test Scheme --</option>
                    
                </select>
            </div>

            
            <div class="col-span-2 md:col-span-1">
                <label for="open_date" class="font-medium block mb-4">Open Date <span class="text-red-500">*</span></label>
                <input type="text" readonly name="open_date" id="open_date"
                    value="<?php echo e(date('d-m-Y h:i:s A')); ?>"
                    class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >


            </div>

            
            <div class="col-span-2 md:col-span-1">
                <label for="amount" class="font-medium block mb-4">Amount Deposit <span class="text-red-500">*</span></label>
                <input type="number" name="amount" id="amount"
                    value="<?php echo e(old('amount', $account->amount ?? '')); ?>"
                    class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >
            </div>

            
            <div class="col-span-2">
                <hr class="my-4">
            </div>

            
            <div class="col-span-2 md:col-span-1">
                <label class="font-medium block mb-4">Account Holder Type <span class="text-red-500">*</span></label>
                <div class="flex gap-5">
                    <label>
                        <input type="radio" name="account_holder_type" value="single"
                            <?php echo e(old('account_holder_type', $account->account_holder_type ?? '') === 'single' ? 'checked' : ''); ?>>
                        Single
                    </label>
                    <label>
                        <input type="radio" name="account_holder_type" value="joint"
                            <?php echo e(old('account_holder_type', $account->account_holder_type ?? '') === 'joint' ? 'checked' : ''); ?>>
                        Joint A/C
                    </label>
                </div>
            </div>
               
            <div class="col-span-2 md:col-span-1"></div>

            
            <div class="col-span-2 md:col-span-1">
                <label for="member_id_one_one" class="font-medium block mb-4">Joint A/c Member 1 <span class="text-red-500">*</span></label>
                <select name="member_id_one" id="member_id_one_main" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >
                    <option value="">-- Select Member --</option>
                    <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($member->id); ?>" <?php echo e(old('member_id', $account->member_id ?? '') == $member->id ? 'selected' : ''); ?>>
                                <?php echo e("MEM -". $member->id . ' - ' . $member->member_info_first_name . ' ' . $member->member_info_last_name); ?>

                        </option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['member_id_one'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs block mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            

            
            <div class="col-span-2 md:col-span-1">
                <label for="member_id_two" class="font-medium block mb-4">Joint A/c Member 2 <span class="text-red-500">*</span></label>
                 <select name="member_id_two" id="member_id_two_main" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >
                    <option value="">-- Select Member --</option>
                    <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($member->id); ?>" <?php echo e(old('member_id', $account->member_id ?? '') == $member->id ? 'selected' : ''); ?>>
                                <?php echo e("MEM -". $member->id . ' - ' . $member->member_info_first_name . ' ' . $member->member_info_last_name); ?>

                        </option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['member_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs block mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="col-span-2 md:col-span-1" id="mode-operation">
                <label class="font-medium block mb-4">Mode of Operation <span class="text-red-500">*</span></label>
                <div class="flex gap-5">
                    <label>
                        <input type="radio" name="mode_of_operation" value="single"
                            <?php echo e(old('mode_of_operation', $account->mode_of_operation ?? '') === 'single' ? 'checked' : ''); ?>>
                        Single
                    </label>
                    <label>
                        <input type="radio" name="mode_of_operation" value="jointly"
                            <?php echo e(old('mode_of_operation', $account->mode_of_operation ?? '') === 'jointly' ? 'checked' : ''); ?>>
                        Jointly
                    </label>
                    <label>
                        <input type="radio" name="mode_of_operation" value="either_or_survivor"
                            <?php echo e(old('mode_of_operation', $account->mode_of_operation ?? '') === 'either_or_survivor' ? 'checked' : ''); ?>>
                        Either or Survivor
                    </label>
                </div>
            </div>

            
            <div class="col-span-2">
                <hr class="my-4">
                <h4 class="text-lg font-semibold mb-2">Nominee Info</h4>
            </div>

            
            <div class="col-span-2 md:col-span-1">
                <label class="font-medium block mb-4">Nominee <span class="text-red-500">*</span></label>
                <div class="flex gap-5">
                    <label>
                        <input type="radio" name="nominee" value="yes"
                            <?php echo e(old('nominee', $account->nominee ?? '') === 'yes' ? 'checked' : ''); ?>>
                        Yes
                    </label>
                    <label>
                        <input type="radio" name="nominee" value="no"
                            <?php echo e(old('nominee', $account->nominee ?? '') === 'no' ? 'checked' : ''); ?>>
                        No
                    </label>
                </div>
            </div>

            
            <div class="col-span-2">
                <hr class="my-4">
                <h4 class="text-lg font-semibold mb-2">Payment Info</h4>
            </div>

            
            <div class="col-span-2 md:col-span-1">
                <label class="font-medium block mb-4">Payment Mode <span class="text-red-500">*</span></label>
                <div class="flex gap-5">
                    <label>
                        <input type="radio" name="payment_mode" value="cash"
                            <?php echo e(old('payment_mode', $account->payment_mode ?? '') === 'cash' ? 'checked' : ''); ?>>
                        Cash
                    </label>
                    <label>
                        <input type="radio" name="payment_mode" value="online"
                            <?php echo e(old('payment_mode', $account->payment_mode ?? '') === 'online' ? 'checked' : ''); ?>>
                        Online Tr.
                    </label>
                    <label>
                        <input type="radio" name="payment_mode" value="cheque"
                            <?php echo e(old('payment_mode', $account->payment_mode ?? '') === 'cheque' ? 'checked' : ''); ?>>
                        Cheque
                    </label>
                </div>
            </div>

            
            <div class="col-span-2 md:col-span-1">
                <label for="transaction_date" class="font-medium block mb-4">Transaction Date</label>
                <input type="text" name="transaction_date" id="date2"
                    value="<?php echo e(old('transaction_date', $account->transaction_date ?? '')); ?>"
                    class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3">
            </div>

            
            <div class="col-span-2 flex gap-4 mt-4">
                <button class="btn-primary" type="submit"><?php echo e($method === 'PUT' ? 'Update' : 'Open'); ?> Account</button>
                <button class="btn-outline" type="reset">Reset</button>
                <button class="btn-outline" type="button" onclick="">Back</button>
            </div>
        </form>
    </div>
</div>
<?php
    $membersData = $members->mapWithKeys(function($member) 
    {
        return [
            $member->id => [
                'first_name' => $member->member_info_first_name,
                'last_name' => $member->member_info_last_name,
                'mobile' => $member->member_info_mobile_no ?? '',
                'branch_id' => $member->general_branch,
                'address' => $member->address
            ],
        ];
    })->toArray();
?>
<?php $__env->stopSection(); ?>

<style>
    .firm-field-wrapper {
        position: relative;
        min-height: 100px;
        transition: all 0.3s ease;
    }
    .firm-field-wrapper.hidden {
        visibility: hidden;
        position: absolute;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        const membersData = <?php echo json_encode($membersData, 15, 512) ?>;
        $(document).ready(function () 
    {
         // Autofill when member is selected
        $('#member_id_main').on('change', function () {
            const memberId = $(this).val();
            const member = membersData[memberId];

console.log(member);

            if (member) {
                $('#member_name').val(member.first_name + ' ' + member.last_name);
                $('#member_mobile').val(member.mobile);
                 $('#branch_id').val(member.branch_id); // auto-select branch
                $('#member_address').val(member.address);

                
            } else {
                $('#member_name').val('');
                $('#member_address').val('');
                $('#member_mobile').val('');
                 $('#branch_id').val('');
            }
        });

        // Trigger on page load to auto-fill if editing
        $('#member_id_main').trigger('change');

        function toggleFirmName() {
            var selectedType = $('input[name="account_type"]:checked').val();
            if (selectedType === 'saving') 
            {
                    $('#firmNameDiv').hide();
            } else if (selectedType === 'current') 
            {
                $('#firmNameDiv').show();
                    
                    $("#firm_d").val("");
                    $("#member_id_main").val("");
                    $("#member_name").val("");
                    $("#member_address").val("");
                    $("#member_mobile").val("");
            }
        }

        // Initial toggle on page load
        toggleFirmName();

        // Toggle on change
        $('input[name="account_type"]').on('change', toggleFirmName);

        // Fade out alerts after 5 seconds
        setTimeout(function () {
            $('#success-alert').fadeOut();
            $('#error-alert').fadeOut();
        }, 5000);
    });
</script>



<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views/saving-current-ac/accounts/add-account.blade.php ENDPATH**/ ?>