<?php require_once 'app/views/templates/public_header.php'; ?>

<div class="container">
    <section class="success-section">
        <div class="success-card">
            <div style="width: 80px; height: 80px; background: var(--success-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
            <h1>Pesanan Berhasil!</h1>
            <p>Terima kasih telah memesan di Dapur Al-Furqon. Pesanan Anda sedang diproses.</p>
            
            <div class="order-info">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <span style="color: var(--text-secondary);">Nomor Pesanan</span>
                    <span style="font-family: 'Fraunces', serif; font-size: 1.25rem; font-weight: 700; color: var(--primary);">
                        <?= isset($data['order']['nomor_pesanan']) ? $data['order']['nomor_pesanan'] : '#' . str_pad($data['id_order'], 5, '0', STR_PAD_LEFT); ?>
                    </span>
                </div>
                <p style="font-size: 0.9rem; color: var(--text-muted); margin: 0; text-align: center;">Silakan datang ke rumah makan untuk mengambil pesanan Anda. Kami akan menghubungi Anda jika pesanan sudah siap.</p>
            </div>
            
            <a href="<?= BASEURL; ?>" class="btn-order" style="padding: 16px 40px; font-size: 1rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle; margin-right: 8px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Kembali ke Menu
            </a>
        </div>
    </section>
</div>

<?php require_once 'app/views/templates/public_footer.php'; ?>
