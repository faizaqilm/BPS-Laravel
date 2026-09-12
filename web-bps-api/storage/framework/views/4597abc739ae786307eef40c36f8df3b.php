
<?php $__env->startSection('title', 'Edit Foto Galeri'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* ─── STYLING FORM EDIT GALERI (PROFESIONAL & CLEAN) ─── */
    .form-page-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
        min-height: calc(100vh - 180px);
    }

    .form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(2, 54, 91, 0.08);
        width: 100%;
        max-width: 600px;
        padding: 40px 40px;
        box-sizing: border-box;
    }

    .form-header {
        margin-bottom: 28px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 16px;
    }

    .form-header h1 {
        font-size: 22px;
        font-weight: 700;
        color: var(--biru-tua, #02365b);
        margin: 0;
    }

    .form-group-modern {
        margin-bottom: 20px;
    }

    .form-group-modern label {
        display: block;
        font-size: 13.5px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
        width: auto !important;
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

    .current-image-box {
        display: flex;
        align-items: center;
        gap: 16px;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .current-image-box img {
        width: 100px;
        height: 70px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #cbd5e1;
    }

    .current-image-info {
        font-size: 13px;
        color: #64748b;
    }

    .form-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }

    .btn-submit-modern {
        background-color: var(--biru, #034f84);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 6px;
        font-size: 14.5px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: background-color 0.15s;
    }

    .btn-submit-modern:hover {
        background-color: var(--biru-tua, #02365b);
    }

    .btn-cancel-modern {
        color: #64748b;
        background-color: transparent;
        border: 1px solid #cbd5e1;
        padding: 12px 20px;
        border-radius: 6px;
        font-size: 14.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.15s;
    }

    .btn-cancel-modern:hover {
        background-color: #f1f5f9;
        color: #1e293b;
        border-color: #94a3b8;
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

<div class="form-page-wrapper">
    <div class="form-card">
        <div class="form-header">
            <h1>Edit Data Galeri</h1>
        </div>

        <?php if($errors->any()): ?>
            <div class="alert-error-modern">
                <ul style="margin:0; padding-left: 18px;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($e); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('galeri.update', $galeri->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-group-modern">
                <label for="judul">Keterangan Kegiatan</label>
                <input type="text" id="judul" name="judul" class="form-control-modern" value="<?php echo e(old('judul', $galeri->judul)); ?>" required>
            </div>

            <div class="form-group-modern">
                <label>Foto Saat Ini</label>
                <div class="current-image-box">
                    <img src="<?php echo e(asset('storage/' . $galeri->foto)); ?>" alt="Foto Galeri">
                    <div class="current-image-info">
                        <span>Foto aktif terpasang. Unggah foto baru di bawah jika ingin menggantinya.</span>
                    </div>
                </div>
            </div>

            <div class="form-group-modern">
                <label for="foto">Ganti Foto Baru (Opsional)</label>
                <input type="file" id="foto" name="foto" class="form-control-modern" style="padding: 10px; background: white;">
                <small style="color: #64748b; font-size: 12px; margin-top: 4px; display: block;">(Kosongkan jika tidak ingin mengganti foto)</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit-modern">Simpan Perubahan</button>
                <a href="<?php echo e(route('galeri.index')); ?>" class="btn-cancel-modern">Batal</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\XAMPP\Installer\htdocs\PBW\Pertemuan 12\web-bps-api\resources\views/galeri/edit.blade.php ENDPATH**/ ?>