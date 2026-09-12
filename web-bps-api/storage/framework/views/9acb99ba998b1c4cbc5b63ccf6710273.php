
<?php $__env->startSection('title', 'Daftar Publikasi'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .filter-sidebar-modern {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        flex: 0 0 260px;
        box-sizing: border-box;
        border: 1px solid #e2e2e2;
    }
    
    .filter-sidebar-modern label {
        display: block;
        font-size: 14px;
        color: #333;
        margin-top: 10px;
        margin-bottom: 6px;
        font-weight: bold;
    }

    .filter-sidebar-modern input[type="text"],
    .filter-sidebar-modern select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
        margin-bottom: 5px;
        box-sizing: border-box;
    }

    .filter-sidebar-modern .hint-box {
        font-size: 12px;
        color: #666;
        margin-top: 2px;
        margin-bottom: 15px;
        min-height: 16px;
    }

    .btn-modern-submit {
        width: 100%;
        background-color: #008be5;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 15px;
    }

    .btn-modern-submit:hover {
        background-color: #0073bf;
    }

    .publikasi-card {
        display: flex;
        gap: 20px;
        background-color: white;
        border: 1px solid #e2e2e2;
        border-radius: 8px;
        padding: 16px;
    }

    .publikasi-card img {
        width: 130px;
        height: 170px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #eee;
    }

    .meta-text {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #666;
        margin-bottom: 6px;
    }

    .publikasi-judul-link {
        font-size: 18px;
        color: #034f84;
        text-decoration: none;
        margin-bottom: 10px;
        font-weight: bold;
        line-height: 1.3;
    }

    .publikasi-abstrak {
        font-size: 13px;
        color: #555;
        line-height: 1.5;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .publikasi-aksi-admin {
        margin-top: 10px;
        display: flex;
        gap: 15px;
        padding-top: 10px;
        border-top: 1px dashed #ddd;
    }

    .publikasi-aksi-admin a, .publikasi-aksi-admin button {
        font-size: 13px;
        color: #333;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 4px;
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        font-family: inherit;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="publikasi-wrapper">
    <aside class="filter-sidebar-modern">
        <form method="GET" action="<?php echo e(route('publikasi.index')); ?>">
            <label for="keyword">Kata Kunci</label>
            <!-- Event onkeyup memanggil fungsi JS AJAX di bawah -->
            <input type="text" id="keyword" name="keyword" value="<?php echo e(request('keyword')); ?>" placeholder="Masukkan kata kunci..." autocomplete="off" onkeyup="showHint(this.value)">
            <p class="hint-box">Saran: <span id="txtHint"></span></p>

            <label for="tahun">Tahun</label>
            <select id="tahun" name="tahun">
                <option value="">Pilih Tahun</option>
                <?php for($y = now()->year; $y >= 2010; $y--): ?>
                    <option value="<?php echo e($y); ?>" <?php echo e((string) request('tahun') === (string) $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                <?php endfor; ?>
            </select>

            <label for="urutkan">Urutkan Berdasarkan</label>
            <select id="urutkan" name="urutkan">
                <option value="terbaru" <?php echo e(request('urutkan', 'terbaru') === 'terbaru' ? 'selected' : ''); ?>>Terbaru</option>
                <option value="terlama" <?php echo e(request('urutkan') === 'terlama' ? 'selected' : ''); ?>>Terlama</option>
            </select>

            <button type="submit" class="btn-modern-submit">Tampilkan</button>

            <?php if(request('keyword') || request('tahun') || request('urutkan')): ?>
                <a href="<?php echo e(route('publikasi.index')); ?>" class="reset-filter" style="margin-top: 15px; display: block; text-align: center; color: #008be5; text-decoration: none; font-size: 13px;">Reset Filter</a>
            <?php endif; ?>
        </form>
    </aside>

    <section class="publikasi-hasil">
        <div class="publikasi-header">
            <?php if(auth()->guard()->check()): ?>
                <form action="<?php echo e(route('publikasi.sync')); ?>" method="POST" style="display:inline; float: right;" onsubmit="return confirm('Tarik data publikasi terbaru dari BPS Kaltara?');">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-sync" style="background-color: #28a745; color: white; padding: 8px 16px; border-radius: 4px; border: none; cursor: pointer; font-size: 14px; font-weight: bold;">
                        &#x21bb; Sinkronkan Data BPS
                    </button>
                </form>
            <?php endif; ?>
            
            <h1>Daftar Publikasi BPS Kaltara</h1>
            <p class="info-jumlah">Menampilkan hasil dari total <?php echo e($publikasi->total()); ?> publikasi (Database Lokal)</p>
        </div>

        <?php if(session('success')): ?>
            <p style="color:green; font-weight:bold; margin-bottom: 15px;"><?php echo e(session('success')); ?></p>
        <?php endif; ?>
        
        <?php if($errors->any()): ?>
            <div style="color:red; background-color:#fdd; padding:10px; border:1px solid red; margin-bottom:15px; border-radius: 4px;">
                <ul style="margin:0;"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
            </div>
        <?php endif; ?>

        <div class="publikasi-list">
            <?php $__empty_1 = true; $__currentLoopData = $publikasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="publikasi-card">
                    <?php
                        $sampulSrc = str_starts_with($item->sampul, 'http') ? $item->sampul : asset('storage/' . $item->sampul);
                        if(empty($item->sampul)) $sampulSrc = asset('images/Lambang_Badan_Pusat_Statistik_(BPS)_Indonesia.svg');
                    ?>
                    
                    <img src="<?php echo e($sampulSrc); ?>" alt="<?php echo e($item->judul); ?>">
                    
                    <div class="publikasi-info">
                        <div class="meta-text">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            <?php echo e(\Carbon\Carbon::parse($item->tanggal_rilis)->translatedFormat('j F Y')); ?>

                        </div>
                        
                        <a href="<?php echo e($item->pdf_link ?? '#'); ?>" target="_blank" class="publikasi-judul-link">
                            <?php echo e($item->judul); ?>

                        </a>

                        <div class="publikasi-abstrak">
                            <?php echo e($item->abstract ?? 'Tidak ada deskripsi yang tersedia untuk publikasi ini.'); ?>

                        </div>

                        <div class="meta-text" style="margin-top: auto;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                            <?php echo e($item->kategori ?? 'Umum'); ?>

                        </div>

                        <?php if(auth()->guard()->check()): ?>
                            <div class="publikasi-aksi-admin">
                                <a href="<?php echo e(route('publikasi.edit', $item)); ?>">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg> Ubah
                                </a>
                                
                                <form action="<?php echo e(route('publikasi.destroy', $item)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus publikasi ini secara permanen?');" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" style="color:#d9534f;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="empty-state" style="text-align: center; color: #777; padding: 40px 0;">Tidak ada publikasi yang cocok dengan filter pencarian ini.</p>
            <?php endif; ?>
        </div>

        <!-- Pemanggilan Paginasi Kustom -->
        <div style="margin-top:30px;">
            <?php echo e($publikasi->links('vendor.pagination.custom')); ?>

        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    let debounceTimer;

    function showHint(str) {
        clearTimeout(debounceTimer);
        const hintBox = document.getElementById("txtHint");

        if (str.trim().length === 0) {
            hintBox.innerHTML = "";
            return;
        }

        // Tunda 300ms agar tidak membebani server saat mengetik cepat
        debounceTimer = setTimeout(() => {
            fetch(`/publikasi/hint?keyword=${encodeURIComponent(str)}`)
                .then(response => {
                    if (!response.ok) throw new Error("Gagal mengambil data");
                    return response.json();
                })
                .then(data => {
                    let hasil = "";
                    for (let i = 0; i < data.length; i++) {
                        if (data[i].judul === "no suggestion") {
                            hasil = "Tidak ada saran";
                            break;
                        }
                        hasil += (hasil === "" ? "" : ", ") + data[i].judul;
                    }
                    hintBox.innerHTML = hasil;
                })
                .catch(error => {
                    console.error("Error:", error);
                    hintBox.innerHTML = "Gagal memuat saran";
                });
        }, 300);
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\XAMPP\Installer\htdocs\PBW\Pertemuan 12\web-bps-api\resources\views/publikasi/index.blade.php ENDPATH**/ ?>