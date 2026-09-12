
<?php $__env->startSection('title', 'Login Administrator'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* ─── STYLING FORM LOGIN PROFESIONAL (CLEAN & NON-AI LOOK) ─── */
    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 280px);
        padding: 40px 20px;
    }

    .login-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(2, 54, 91, 0.08);
        width: 100%;
        max-width: 420px;
        padding: 40px 36px;
        box-sizing: border-box;
    }

    .login-header {
        margin-bottom: 28px;
        text-align: left;
    }

    .login-header h1 {
        font-size: 22px;
        font-weight: 700;
        color: var(--biru-tua, #02365b);
        margin: 0 0 6px 0;
    }

    .login-header p {
        font-size: 14px;
        color: #64748b;
        margin: 0;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 13.5px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
        width: auto !important; /* Membatalkan lebar tetap dari myCSS.css */
    }

    .form-control-modern {
        width: 100% !important;
        padding: 12px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 14px;
        font-family: inherit;
        color: #1e293b;
        background-color: #f8fafc;
        box-sizing: border-box;
        transition: border-color 0.15s, background-color 0.15s;
    }

    .form-control-modern:focus {
        outline: none;
        border-color: var(--biru, #034f84);
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(3, 79, 132, 0.1);
    }

    .btn-login-submit {
        width: 100%;
        background-color: var(--biru, #034f84);
        color: white;
        border: none;
        padding: 12px;
        border-radius: 6px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: background-color 0.15s;
        margin-top: 10px;
    }

    .btn-login-submit:hover {
        background-color: var(--biru-tua, #02365b);
    }

    .alert-error-modern {
        background-color: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 12px 14px;
        border-radius: 6px;
        font-size: 13.5px;
        margin-bottom: 20px;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="login-wrapper">
    <div class="login-card">
        <div class="login-header">
            <h1>Masuk Sistem</h1>
            <p>Silakan masukkan kredensial administrator Anda</p>
        </div>

        <?php if($errors->any()): ?>
            <div class="alert-error-modern">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login.post')); ?>">
            <?php echo csrf_field(); ?>
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control-modern" value="<?php echo e(old('username')); ?>" required autofocus autocomplete="username">
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control-modern" required autocomplete="current-password">
            </div>

            <button type="submit" class="btn-login-submit">Masuk</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\XAMPP\Installer\htdocs\PBW\Pertemuan 12\web-bps-api\resources\views/auth/login.blade.php ENDPATH**/ ?>