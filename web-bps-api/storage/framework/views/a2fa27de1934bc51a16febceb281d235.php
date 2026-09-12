
<?php $__env->startSection('title', 'GALERI BPS KALTARA'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* ─── STYLING HALAMAN GALERI (DIKEMBALIKAN KE VERSI ASLI) ─── */
    main.galeri {
        margin-top: 20px !important;
        text-align: center;
        padding: 20px;
        width: 50%;
        margin-left: auto;
        margin-right: auto;
    }

    .galeri-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
        border: 1px solid #ccc;
        padding: 15px;
        background-color: #f9f9f9;
        border-radius: 5px;
    }

    .preview img {
        width: 100%;
        height: 350px;
        object-fit: cover;
        border: 2px solid #ccc;
        border-radius: 4px;
    }

    .galeri h1 {
        font-size: 26px;
        color: #1a1a1a;
        margin-bottom: 20px;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<main class="galeri">
    <h1>Galeri Kegiatan BPS Kalimantan Utara</h1>

    <?php if(session('success')): ?>
        <div style="color: green; margin-bottom:15px; font-weight:bold;"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(auth()->guard()->check()): ?>
        <div style="margin-bottom: 20px; text-align: left;">
            <a href="<?php echo e(route('galeri.create')); ?>" class="btn-tampilkan" style="text-decoration: none; padding: 10px 20px; font-weight: bold; background-color: var(--biru); color: white; border-radius: 4px;">+ Tambah Foto</a>
        </div>
    <?php endif; ?>

    <div class="galeri-container">
        <div class="preview">
            <?php if($galeriList->count() > 0): ?>
                <img id="imgPreview" src="<?php echo e(asset('storage/' . $galeriList->first()->foto)); ?>" alt="<?php echo e($galeriList->first()->judul); ?>">
            <?php else: ?>
                <div style="padding: 100px; color: #777; background-color: #eee; border-radius: 4px;">Belum ada foto galeri yang diunggah.</div>
            <?php endif; ?>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-top: 15px;">
            <?php $__currentLoopData = $galeriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="text-align: center; border: 1px solid #ddd; padding: 10px; border-radius: 4px; background-color: white;">
                    <img src="<?php echo e(asset('storage/' . $row->foto)); ?>" 
                         alt="<?php echo e($row->judul); ?>" 
                         title="<?php echo e($row->judul); ?>"
                         onclick="gantiPreview(this)" 
                         style="width: 100%; height: 100px; object-fit: cover; cursor: pointer; border-radius: 4px; transition: 0.2s;">
                    
                    <div style="font-size: 13px; margin-top: 10px; color: #333; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <?php echo e($row->judul); ?>

                    </div>

                    <?php if(auth()->guard()->check()): ?>
                        <div style="margin-top: 12px; font-size: 12px; display: flex; justify-content: center; gap: 8px;">
                            <a href="<?php echo e(route('galeri.edit', $row->id)); ?>" style="color: #034f84; text-decoration: none; border: 1px solid #034f84; padding: 4px 10px; border-radius: 4px;">Edit</a>
                            
                            <form action="<?php echo e(route('galeri.destroy', $row->id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus foto ini secara permanen?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" style="color: #d9534f; background: none; border: 1px solid #d9534f; padding: 4px 10px; border-radius: 4px; cursor: pointer;">Hapus</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</main>

<?php $__env->startPush('scripts'); ?>
<script>
    function gantiPreview(el) {
        document.getElementById('imgPreview').src = el.src;
        document.getElementById('imgPreview').alt = el.alt;
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\XAMPP\Installer\htdocs\PBW\Pertemuan 12\web-bps-api\resources\views/galeri/index.blade.php ENDPATH**/ ?>