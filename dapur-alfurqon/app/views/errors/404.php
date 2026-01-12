<?php require_once 'app/views/templates/public_header.php'; ?>

<div class="container" style="padding: 4rem 0; text-align: center;">
    <div class="error-404" style="max-width: 600px; margin: 0 auto;">
        <h1 style="font-size: 6rem; font-weight: bold; color: #e5e7eb; margin-bottom: 1rem;">404</h1>
        <h2 style="font-size: 2rem; color: #1f2937; margin-bottom: 1rem;">Halaman Tidak Ditemukan</h2>
        <p style="font-size: 1.125rem; color: #6b7280; margin-bottom: 2rem;">
            Maaf, halaman yang Anda cari tidak dapat ditemukan atau mungkin telah dipindahkan.
        </p>
        
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="<?= BASEURL; ?>" class="btn-primary">Kembali ke Beranda</a>
            <a href="<?= BASEURL; ?>/artikel" class="btn-secondary">Lihat Artikel</a>
        </div>
    </div>
</div>

<style>
.btn-primary, .btn-secondary {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
}

.btn-secondary:hover {
    background: #e5e7eb;
}
</style>

<?php require_once 'app/views/templates/public_footer.php'; ?>