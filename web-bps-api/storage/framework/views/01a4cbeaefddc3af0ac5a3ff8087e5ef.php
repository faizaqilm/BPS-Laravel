
<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<main class="kotak">
    <h1 class="login-title">Form Login</h1>

    <?php if($errors->any()): ?>
        <p style="color:red;"><?php echo e($errors->first()); ?></p>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login.post')); ?>">
        <?php echo csrf_field(); ?>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>

        <input type="submit" value="Login">
    </form>
</main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\XAMPP\Installer\htdocs\PBW\Pertemuan 12\web-bps-api\resources\views/auth/login.blade.php ENDPATH**/ ?>