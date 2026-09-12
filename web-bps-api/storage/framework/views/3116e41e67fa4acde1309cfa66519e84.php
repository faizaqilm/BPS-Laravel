
<?php $__env->startSection('title', 'Ubah Publikasi'); ?>

<?php $__env->startSection('content'); ?>
<main class="kotak" style="margin-top: 100px;">
    <h1>Formulir Ubah Data Publikasi</h1>

    <?php if($errors->any()): ?>
        <div style="color:red; background-color:#fdd; padding:10px; border:1px solid red; margin-bottom:15px;">
            <ul style="margin:0;"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('publikasi.update', $publikasi)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <label for="judul">Judul:</label>
        <input type="text" id="judul" name="judul" value="<?php echo e(old('judul', $publikasi->judul)); ?>" style="width: 75%; padding: 10px; margin-bottom: 15px;" required>
        <br>

        <label for="kategori">Kategori:</label>
        <input type="text" id="kategori" name="kategori" value="<?php echo e(old('kategori', $publikasi->kategori)); ?>" style="width: 75%; padding: 10px; margin-bottom: 15px;">
        <br>

        <label for="tanggal_rilis">Tanggal Rilis:</label>
        <input type="date" id="tanggal_rilis" name="tanggal_rilis" value="<?php echo e(old('tanggal_rilis', $publikasi->tanggal_rilis)); ?>" style="width: 75%; padding: 10px; margin-bottom: 15px;" required>
        <br>

        <label for="abstract" style="vertical-align: top;">Deskripsi:</label>
        <textarea id="abstract" name="abstract" rows="5" style="width: 75%; padding: 10px; margin-bottom: 15px; font-family: inherit;"><?php echo e(old('abstract', $publikasi->abstract)); ?></textarea>
        <br>

        <?php if($publikasi->sampul): ?>
            <label>Sampul Lama:</label>
            <img src="<?php echo e(asset('storage/' . $publikasi->sampul)); ?>" width="100" style="display:inline-block; margin-bottom: 15px; border-radius: 4px; border: 1px solid #ccc;">
            <br>
        <?php endif; ?>

        <label for="sampul">Sampul Baru:</label>
        <input type="file" id="sampul" name="sampul" style="width: 75%; padding: 10px; margin-bottom: 15px;">
        <span style="font-size: 12px; color: #666; margin-left: 135px; display:block;">(Kosongkan jika tidak ingin mengganti sampul)</span>
        <br><br>

        <input type="submit" value="Simpan Perubahan" class="btn-tampilkan">
        <a href="<?php echo e(route('publikasi.index')); ?>" style="margin-left: 15px; color: #d9534f; text-decoration: none;">Batal</a>
    </form>
</main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\XAMPP\Installer\htdocs\PBW\Pertemuan 12\web-bps-api\resources\views/publikasi/edit.blade.php ENDPATH**/ ?>