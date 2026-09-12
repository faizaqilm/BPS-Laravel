
<?php $__env->startSection('title', 'Tambah Foto Galeri'); ?>

<?php $__env->startSection('content'); ?>
<main class="kotak" style="margin-top: 120px;">
    <h1>Tambah Foto Kegiatan</h1>

    <?php if($errors->any()): ?>
        <div style="color:red; margin-bottom:15px; border: 1px solid red; padding:10px; background-color:#fdd;">
            <ul style="margin:0;"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('galeri.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <label for="judul">Keterangan:</label>
        <input type="text" id="judul" name="judul" required style="width: 75%; padding: 10px; margin-bottom: 15px;" value="<?php echo e(old('judul')); ?>">
        <br>
        <label for="foto">Pilih Foto:</label>
        <input type="file" id="foto" name="foto" required style="width: 75%; padding: 10px; margin-bottom: 15px;">
        <br><br>
        <input type="submit" value="Simpan Foto" class="btn-tampilkan">
        <a href="<?php echo e(route('galeri.index')); ?>" style="margin-left: 15px; color: #d9534f; text-decoration: none;">Batal</a>
    </form>
</main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\XAMPP\Installer\htdocs\PBW\Pertemuan 12\web-bps-api\resources\views/galeri/create.blade.php ENDPATH**/ ?>