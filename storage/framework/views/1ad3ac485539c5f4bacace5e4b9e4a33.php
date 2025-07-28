<!-- Vertical -->
<?php
    use App\Models\Menu;
    $menus = Menu::distinctMenus();
	//print_r($menus);die;
?>
<aside id="sidebar" class="sidebar bg-n0 dark:!bg-bg4">
    <div class="sidebar-inner relative">
        <div class="logo-column">
            <div class="logo-container">
                <div class="logo-inner">
                    <a href="<?php echo e(route('index1')); ?>" class="logo-wrapper">
                        <img src="<?php echo e(asset('assets/images/SBC_Logo.png')); ?>"
                            class="logo-full" alt="logo" />
                        <img src="<?php echo e(asset('assets/images/logo.png')); ?>" width="37" height="36"
                            class="logo-icon hidden" alt="logo" />
                    </a>
                    <img width="141" height="38" class="logo-text hidden"
                        src="<?php echo e(asset('assets/images/logo-text.png')); ?>" alt="logo text" />
                    <button class="sidebar-close-btn xl:hidden" id="sidebar-close-btn">
                        <i class="las la-times"></i>
                    </button>
                </div>
            </div>
            <div class="menu-container pb-28">
                <div class="menu-wrapper">
                    <!-- <p class="menu-heading">Navigation</p> -->
                    <ul class="menu-ul">
					<?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php
							$submenus = Menu::subMenus($menu->menu);
						?>
						<li class="menu-li">
							<button class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4">
								<span class="flex items-center justify-center gap-2">
									<span class="menu-icon">
									    <?php
									    if($menu->menu=='Dashboard'){
									    ?>
										<i class="las las la-home"></i>
										<?php
									    }else if($menu->menu=='Company'){
									    ?>
									    <i class="las la-piggy-bank"></i>
									    <?php
									    }
									    ?>
									</span>
									<span class="menu-title font-medium"><?php echo e($menu->menu); ?></span>
								</span>
								<?php if($submenus->isNotEmpty()): ?>
								<span class="plus-minus">
									<i class="las la-plus text-xl"></i>
									<i class="las la-minus text-xl"></i>
								</span>
								<span class="chevron-down hidden">
									<i class="las la-angle-down text-base"></i>
								</span>
								<?php endif; ?>
							</button>

							<?php if($submenus->isNotEmpty()): ?>
								<ul class="submenu-hide submenu">
									<?php $__currentLoopData = $submenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if(!empty($submenu->submenu)): ?>
											<li>
												<a href="<?php echo e(route($submenu->link)); ?>" class="submenu-link">
													<i class="las la-minus text-xl"></i>
													<span><?php echo e($submenu->submenu); ?></span>
												</a>
											</li>
										<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</ul>
							<?php endif; ?>
						</li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ul>


                </div>
                <!-- <div class="px-4 xxl:px-6 xxxl:px-8">
                    <div class="balance-part">
                        <p class="border-t-2 border-dashed border-primary/20 py-4 text-xs font-semibold lg:py-6">
                            Balance
                        </p>
                        <ul>
                            <li>
                                <button
                                    class="group flex w-full items-center justify-between rounded-xl px-4 py-2.5 lg:py-3 xxxl:px-6">
                                    <span class="flex items-center gap-2">
                                        <span class="-mb-1 self-center text-primary">
                                            <i class="las la-dollar-sign"></i>
                                        </span>
                                        <span class="font-medium">33,215.00 USD</span>
                                    </span>
                                </button>
                                <button
                                    class="group flex w-full items-center justify-between rounded-xl px-4 py-2.5 lg:py-3 xxxl:px-6">
                                    <span class="flex items-center gap-2">
                                        <span class="-mb-1 self-center text-primary">
                                            <i class="las la-euro-sign"></i>
                                        </span>
                                        <span class="font-medium">15,254.32 EUR</span>
                                    </span>
                                </button>
                                <button
                                    class="group flex w-full items-center justify-between rounded-xl px-4 py-2.5 lg:py-3 xxxl:px-6">
                                    <span class="flex items-center gap-2">
                                        <span class="-mb-1 self-center text-primary">
                                            <i class="las la-pound-sign"></i>
                                        </span>
                                        <span class="font-medium">7,029.14 GBP</span>
                                    </span>
                                </button>
                                <button
                                    class="group flex w-full items-center justify-between rounded-xl px-4 py-2.5 lg:py-3 xxxl:px-6">
                                    <span class="flex items-center gap-2">
                                        <span class="-mb-1 self-center text-primary">
                                            <i class="las la-plus-circle"></i>
                                        </span>
                                        <span class="font-medium">Add More Balance</span>
                                    </span>
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="upgrade-part">
                        <img src="<?php echo e(asset('assets/images/upgrade.png')); ?>" width="272" height="173"
                            alt="upgrade" />
                        <p class="mb-8 mt-6 text-sm">
                            Upgrade your account to
                            <span class="font-semibold text-primary">PRO</span> for even
                            more examples.
                        </p>
                        <a href="#" class="btn-primary flex w-full justify-center">
                            Upgrade Now
                        </a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</aside><?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views\layout\sidebar13july.blade.php ENDPATH**/ ?>