<?php require_once 'app/views/templates/header.php'; ?>

<div class="page-header">
    <h1>Dashboard</h1>
</div>

<div class="card" style="background: white; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <h2>Selamat Datang, <?= $_SESSION['nama_lengkap']; ?>!</h2>
    <p style="color: #6b7280; margin-top: 0.5rem;">Anda login sebagai <strong><?= $_SESSION['role']; ?></strong>.</p>
    
    <div style="margin-top: 2rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <div style="background: #f3f4f6; padding: 1.5rem; border-radius: 0.5rem;">
            <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">Menu</h3>
            <p>Kelola daftar menu makanan dan minuman.</p>
            <a href="<?= BASEURL; ?>/dashboard/menu" class="btn-primary" style="display: inline-block; margin-top: 1rem;">Lihat Menu</a>
        </div>
        
        <div style="background: #f3f4f6; padding: 1.5rem; border-radius: 0.5rem;">
            <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">Artikel</h3>
            <p>Kelola artikel, berita, tips, dan konten lainnya.</p>
            <a href="<?= BASEURL; ?>/dashboard/artikel" class="btn-primary" style="display: inline-block; margin-top: 1rem;">Kelola Artikel</a>
        </div>
        
        <div style="background: #f3f4f6; padding: 1.5rem; border-radius: 0.5rem;">
            <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">Gallery</h3>
            <p>Kelola galeri foto dan gambar.</p>
            <a href="<?= BASEURL; ?>/dashboard/gallery" class="btn-primary" style="display: inline-block; margin-top: 1rem;">Kelola Gallery</a>
        </div>
        
        <div style="background: #f3f4f6; padding: 1.5rem; border-radius: 0.5rem;">
            <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">Pesanan</h3>
            <p>Kelola pesanan dan status pembayaran.</p>
            <a href="<?= BASEURL; ?>/dashboard/order" class="btn-primary" style="display: inline-block; margin-top: 1rem;">Lihat Pesanan</a>
        </div>
        
        <div style="background: #f3f4f6; padding: 1.5rem; border-radius: 0.5rem;">
            <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">Laporan</h3>
            <p>Lihat laporan keuangan harian, mingguan, dan bulanan.</p>
            <a href="<?= BASEURL; ?>/dashboard/laporan" class="btn-primary" style="display: inline-block; margin-top: 1rem;">Lihat Laporan</a>
        </div>
        
        <div style="background: #f3f4f6; padding: 1.5rem; border-radius: 0.5rem;">
            <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">Pengaturan</h3>
            <p>Kelola profil, kontak, dan informasi perusahaan.</p>
            <a href="<?= BASEURL; ?>/dashboard/pengaturan" class="btn-primary" style="display: inline-block; margin-top: 1rem;">Pengaturan</a>
        </div>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
