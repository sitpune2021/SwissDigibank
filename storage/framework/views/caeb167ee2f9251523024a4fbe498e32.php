<?php
    use App\Models\Menu;
    $menuItems = Menu::with('submenus')->orderBy('id')->get();
?>
  
<aside id="sidebar" class="sidebar bg-n0 dark:!bg-bg4">
    <div class="sidebar-inner relative">
        <div class="logo-column">
            <div class="logo-container">
                <div class="logo-inner">
                    <a href="<?php echo e(route('index1')); ?>" class="logo-wrapper">
                        <img src="<?php echo e(asset('assets/images/SBC_Logo.png')); ?>" width="174" height="38"
                            class="logo-full" alt="logo" />
                        <img src="<?php echo e(asset('assets/images/SBC_Logo.png')); ?>" width="37" height="36"
                            class="logo-icon hidden" alt="logo" />
                    </a>
                    <img width="141" height="38" class="logo-text hidden"
                        src="<?php echo e(asset('assets/images/SBC_Logo.png')); ?>" alt="logo text" />
                    <button class="sidebar-close-btn xl:hidden" id="sidebar-close-btn">
                        <i class="las la-times"></i>
                    </button>
                </div>
            </div>
            <div class="menu-container pb-28">
                <div class="menu-wrapper">
                    <ul class="menu-ul">
                        <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $isActive = request()->routeIs($item?->route ?? '');
                                $submenuActive = $item->submenus->contains(function ($sub) {
                                    return request()->routeIs($sub->route);
                                });
                            ?>

                            <li class="menu-li <?php echo e($isActive || $submenuActive ? 'active' : ''); ?>">
                                <?php if($item->submenus->isNotEmpty()): ?>
                                    <button
                                        class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4 <?php echo e($isActive || $submenuActive ? 'active' : ''); ?>"
                                        type="button"
                                        onclick="this.nextElementSibling.classList.toggle('submenu-show'); this.classList.toggle('active'); 
                                            this.querySelector('.plus-minus .la-plus').classList.toggle('hidden'); 
                                            this.querySelector('.plus-minus .la-minus').classList.toggle('hidden');">
                                        <span class="flex items-center justify-center gap-2">
                                            <span class="menu-icon">
                                                <i class="<?php echo e($item->icon); ?>"></i>
                                            </span>
                                            <span class="menu-title font-medium"><?php echo e($item->title); ?></span>
                                        </span>
                                        <span class="plus-minus">
                                            <i class="las la-plus text-xl <?php echo e($submenuActive ? 'hidden' : ''); ?>"></i>
                                            <i class="las la-minus text-xl <?php echo e($submenuActive ? '' : 'hidden'); ?>"></i>
                                        </span>
                                    </button>
                                    <ul class="submenu <?php echo e($submenuActive ? 'submenu-show' : 'submenu-hide'); ?>">
                                        <?php $__currentLoopData = $item->submenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <a href="<?php echo e(route($sub->route)); ?>"
                                                    class="submenu-link <?php echo e(request()->routeIs($sub->route) ? 'text-primary' : ''); ?>">
                                                    <i class="las la-minus text-xl"></i>
                                                    <span><?php echo e($sub->title); ?></span>
                                                </a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php else: ?>
                                    <a href="<?php echo e(route($item?->route)); ?>"
                                        class="menu-btn border-n30 bg-n0 dark:!border-n500 dark:bg-bg4 flex items-center justify-center gap-2 <?php echo e($isActive ? 'active' : ''); ?>">
                                        <span class="flex items-center justify-center gap-2">
                                            <span class="menu-icon">
                                                <i class="<?php echo e($item->icon); ?>"></i>
                                            </span>
                                            <span class="menu-title font-medium"><?php echo e($item->title); ?></span>
                                        </span>
                                    </a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</aside>
<?php /**PATH C:\xampp\htdocs\swiss bank live code\resources\views/layout/sidebar.blade.php ENDPATH**/ ?>