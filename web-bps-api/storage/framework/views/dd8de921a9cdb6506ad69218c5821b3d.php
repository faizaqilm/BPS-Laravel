<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'BPS Provinsi Kalimantan Utara'); ?></title>
    <link rel="icon" href="<?php echo e(asset('images/Lambang_Badan_Pusat_Statistik_(BPS)_Indonesia.svg')); ?>" type="image/svg+xml">
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/js/app.js']); ?>
    
    <?php echo $__env->yieldPushContent('styles'); ?> 
    
    <style>
        header {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            z-index: 999 !important;
            margin: 0 !important;
        }

        body {
            padding-top: 76px !important;
            background-color: var(--abu-bg, #f7f8fa) !important;
            margin: 0 !important;
        }

        main.home-main, .hero-section {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
        
        .hero-section {
            padding: 64px 20px 110px 20px !important; 
        }

        .hero-section h1 {
            font-size: 26px !important;
            font-weight: 700 !important;
            line-height: 1.5 !important;
        }

        .indikator-container {
            display: flex !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
            gap: 20px !important;
        }
        
        .indikator-card {
            flex: 0 0 200px !important; 
            width: 200px !important;
        }
        
        .indikator-title { font-weight: 600 !important; }
        .indikator-value { font-weight: 700 !important; }

        nav a.active {
            border-bottom: 3px solid var(--aksen, #17a2b8) !important;
        }
    </style>
</head>
<body>

    <header>
        <div class="header-kiri">
            <img src="<?php echo e(asset('images/Lambang_Badan_Pusat_Statistik_(BPS)_Indonesia.svg')); ?>" alt="Logo BPS">
            <div class="judulweb">
                <span class="judul-atas">BADAN PUSAT STATISTIK</span>
                <span class="judul-bawah">PROVINSI KALIMANTAN UTARA</span>
            </div>
        </div>

        <nav>
            <a class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">Beranda</a>
            
            
            <a class="<?php echo e(request()->routeIs('publikasi.index') ? 'active' : ''); ?>" href="<?php echo e(route('publikasi.index')); ?>">Daftar Publikasi</a>

            <?php if(auth()->guard()->check()): ?>
                
                <a class="<?php echo e(request()->routeIs('publikasi.create', 'publikasi.edit') ? 'active' : ''); ?>" href="<?php echo e(route('publikasi.create')); ?>">Tambah Publikasi</a>
            <?php endif; ?>

            <a href="https://pst.bps.go.id/" target="_blank" rel="noopener">Layanan</a>
            <a class="<?php echo e(request()->routeIs('galeri.*') ? 'active' : ''); ?>" href="<?php echo e(route('galeri.index')); ?>">Galeri Kegiatan</a>

            <div class="dropdown">
                <button class="dropbtn" type="button">Informasi Publik <span class="chevron">&#9662;</span></button>
                <div class="dropdown-content">
                    <a href="https://ppid.bps.go.id/app/konten/6500/Profil-BPS.html" target="_blank">Tentang Kami</a>
                    <a href="https://ppid.bps.go.id/?mfd=6500" target="_blank">PPID</a>
                    <a href="https://ppid.bps.go.id/app/konten/0000/Layanan-BPS.html#pills-3" target="_blank">Kebijakan Diseminasi</a>
                    <a href="https://ppid.bps.go.id/app/konten/6500/Layanan-BPS.html" target="_blank">Informasi Layanan</a>
                    <a href="https://ppid.bps.go.id/app/keberatan_informasi" target="_blank">Pengaduan</a>
                </div>
            </div>

            <?php if(auth()->guard()->check()): ?>
                <form method="POST" action="<?php echo e(route('logout')); ?>" style="display:contents;">
                    <?php echo csrf_field(); ?>
                    <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="<?php echo e(request()->routeIs('home') ? 'home-main' : ''); ?>">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="footer-bps">
        <div class="footer-content">
            <div class="footer-col brand-col">
                <div class="footer-logo">
                    <img src="<?php echo e(asset('images/Lambang_Badan_Pusat_Statistik_(BPS)_Indonesia.svg')); ?>" alt="logo BPS">
                    <span>BADAN PUSAT STATISTIK</span>
                </div>
                <p>Badan Pusat Statistik Provinsi Kalimantan Utara (BPS-Statistics Kalimantan Utara Province)</p>
                <p>Jl. Jelarai Raya RT 75 RW 28 Tanjung Selor Hilir 77212</p>
                <p>Telp. (0552) 2033254; Whatsapp: 0822-5442-6005; Mailbox: bps6500@bps.go.id / pst6500@bps.go.id</p>
            </div>
            <div class="footer-col link-col">
                <h3>Tentang Kami</h3>
                <a href="https://ppid.bps.go.id/app/konten/6500/Profil-BPS.html" target="_blank">Profil BPS</a>
                <a href="https://ppid.bps.go.id/?mfd=6500" target="_blank">PPID</a>
                <a href="https://ppid.bps.go.id/app/konten/0000/Layanan-BPS.html#pills-3" target="_blank">Kebijakan Diseminasi</a>
            </div>
            <div class="footer-col link-col">
                <h3>Tautan Lainnya</h3>
                <a href="https://www.aseanstats.org/" target="_blank">ASEAN Stats</a>
                <a href="https://rb.bps.go.id/" target="_blank">Reformasi Birokrasi</a>
                <a href="https://lpse.bps.go.id" target="_blank">Layanan Pengadaan Secara Elektronik</a>
                <a href="https://stis.ac.id" target="_blank">Politeknik Statistika STIS</a>
                <a href="https://pusdiklat.bps.go.id/" target="_blank">Pusdiklat BPS</a>
                <a href="https://jdih.bps.go.id/" target="_blank">JDIH BPS</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Copyright © 2026 Politeknik Statistika STIS | Created by Faiz Aqil Majid (faizaqil.m@gmail.com)</p>
        </div>
    </footer>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH E:\XAMPP\Installer\htdocs\PBW\Pertemuan 12\web-bps-api\resources\views/layouts/app.blade.php ENDPATH**/ ?>