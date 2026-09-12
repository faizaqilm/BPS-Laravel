<?php if($paginator->hasPages()): ?>
    <div style="display: flex; justify-content: center; gap: 8px; margin-top: 30px; flex-wrap: wrap;">
        
        
        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            
            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                        <span style="padding: 8px 14px; border-radius: 4px; border: 1px solid #008be5; background-color: #008be5; color: white; font-weight: bold;"><?php echo e($page); ?></span>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>" style="padding: 8px 14px; border-radius: 4px; text-decoration: none; border: 1px solid #008be5; color: #008be5; background-color: white; transition: 0.2s;"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
    </div>
<?php endif; ?><?php /**PATH E:\XAMPP\Installer\htdocs\PBW\Pertemuan 12\web-bps-api\resources\views/vendor/pagination/custom.blade.php ENDPATH**/ ?>