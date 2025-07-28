<?php $__env->startSection('content'); ?>
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3 lg:mb-5">
            <h4 class="h2">Members</h4>
            <a class="btn-primary" href="<?php echo e(route('member.create')); ?>">
                <i class=" text-base md:text-lg"></i>
                Add
            </a>
        </div>
        <div class="box col-span-12 lg:col-span-12">
            <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                </div>
            </div>
            <?php if (isset($component)) { $__componentOriginalf6865684c380894921313aa584cf2694 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf6865684c380894921313aa584cf2694 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.searchbox','data' => ['action' => route('member.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('searchbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('member.index'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf6865684c380894921313aa584cf2694)): ?>
<?php $attributes = $__attributesOriginalf6865684c380894921313aa584cf2694; ?>
<?php unset($__attributesOriginalf6865684c380894921313aa584cf2694); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf6865684c380894921313aa584cf2694)): ?>
<?php $component = $__componentOriginalf6865684c380894921313aa584cf2694; ?>
<?php unset($__componentOriginalf6865684c380894921313aa584cf2694); ?>
<?php endif; ?>
            <div class="overflow-x-auto pb-4 lg:pb-6">
                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Sr No
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Group
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Member no
                                </div>
                            </th>
                            <th class="text-start !py-5 min-w-[100px]" data-sortable="false">Gender</th>
                            <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Branch
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Name
                                </div>
                            </th>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    F/h name
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Senior ctz
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Enroll date
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Aadhar no
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Pan no
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Kyc status
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Mobile no
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Status
                                </div>
                            </th>
                            <th class="text-center !py-5" data-sortable="false">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b dark:border-bg3">
                                <td class="py-3 px-6"><?php echo e($index + 1); ?></td>

                                <td class="py-3 px-6"><?php echo e($item->general_group); ?></td>

                                
                                <td class="py-3 px-6">
                                    <a href="<?php echo e(route('member.show', base64_encode($item->id))); ?>"
                                        class="text-blue-600 hover:underline">
                                        <?php echo e($item->member_info_old_member_no ?? 'DEMO'); ?>

                                    </a>
                                </td>

                                <td class="py-3 px-6"><?php echo e(ucfirst($item->member_info_gender)); ?></td>

                                <td class="py-3 px-6"><?php echo e($item->branch->branch_name); ?></td>

                                <td class="py-3 px-6">
                                    <?php echo e($item->member_info_first_name); ?>

                                    <?php echo e($item->member_info_middle_name); ?>

                                    <?php echo e($item->member_info_last_name); ?>

                                </td>

                                <td class="py-3 px-6">
                                    <?php echo e($item->member_info_father_name ?? ($item->member_info_spouse_name ?? 'N/A')); ?> </td>

                                <td class="py-3 px-6">
                                    <?php
                                        $age = \Carbon\Carbon::parse($item->member_info_dob)->age;
                                    ?>
                                    <?php echo e($age >= 60 ? 'Yes' : 'No'); ?>

                                </td>

                                <td class="py-3 px-6">
                                    <?php echo e(\Carbon\Carbon::parse($item->general_enrollment_date)->format('d M Y')); ?>

                                </td>

                                <td class="py-3 px-6">
                                    <?php echo e($item->kyc?->member_kyc_aadhaar_no ?? 'N/A'); ?>

                                </td>

                                <td class="py-3 px-6">
                                    <?php echo e($item->kyc?->member_kyc_pan_no ?? 'N/A'); ?>

                                </td>

                                <td class="py-3 px-6">
                                    <?php
                                        $hasKYC = $item->kyc?->member_kyc_aadhaar_no || $item->kyc?->member_kyc_pan_no;
                                    ?>
                                    <span class="text-sm <?php echo e($hasKYC ? 'text-green-600' : 'text-red-600'); ?>">
                                        <?php echo e($hasKYC ? 'Completed' : 'Pending'); ?>

                                    </span>
                                </td>

                                <td class="py-3 px-6">
                                    <?php echo e($item->member_info_mobile_no); ?>

                                </td>

                                <td class="py-3 px-6">
                                    <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-700">
                                        Active
                                    </span>
                                </td>

                                <td class="py-2 px-6">
                                    <div class="flex justify-center">
                                        <?php echo $__env->make('partials._vertical-options', [
                                            'id' => $item->id,
                                            'id' => base64_encode($item->id),
                                            'viewRoute' => 'member.show',
                                            'editRoute' => 'member.edit',
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\swiss bank live code\resources\views/member/index.blade.php ENDPATH**/ ?>