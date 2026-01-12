<?php require_once 'app/views/templates/public_header.php'; ?>

<div class="container">
    <section class="checkout-section">
        <h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle; margin-right: 12px; color: var(--primary);"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
            Checkout Pesanan
        </h1>

        <div class="checkout-container">
            <!-- Form Section -->
            <div class="checkout-form">
                <h3>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    Informasi Pelanggan
                </h3>
                <form action="<?= BASEURL; ?>/checkout/process" method="POST">
                    <div class="form-group">
                        <label for="nama_pelanggan">Nama Lengkap <span class="required">*</span></label>
                        <input type="text" id="nama_pelanggan" name="nama_pelanggan" placeholder="Masukkan nama lengkap Anda" required>
                    </div>
                    <div class="form-group">
                        <label for="no_telepon">No. Telepon <span class="required">*</span></label>
                        <input type="tel" id="no_telepon" name="no_telepon" placeholder="Contoh: 08123456789" required>
                    </div>
                    <div class="form-group">
                        <label for="catatan">Catatan Pesanan</label>
                        <textarea id="catatan" name="catatan" rows="3" placeholder="Catatan khusus untuk pesanan Anda (opsional)"></textarea>
                        <small style="color: var(--text-muted); font-size: 0.875rem; margin-top: 0.5rem; display: block;">
                            Contoh: Tidak pedas, tanpa bawang, dll.
                        </small>
                    </div>
                    <div class="form-group">
                        <label>Metode Pembayaran <span class="required">*</span></label>
                        <div class="payment-methods">
                            <label class="payment-option">
                                <input type="radio" name="metode_bayar" value="qris" checked>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><rect x="7" y="7" width="3" height="3"></rect><rect x="14" y="7" width="3" height="3"></rect><rect x="7" y="14" width="3" height="3"></rect><rect x="14" y="14" width="3" height="3"></rect></svg>
                                <span>Bayar Sekarang (QRIS)</span>
                                <small style="display: block; color: var(--text-muted); font-size: 0.8rem; margin-top: 0.25rem;">
                                    Bayar langsung dengan GoPay, OVO, DANA, ShopeePay, dll
                                </small>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="metode_bayar" value="tunai">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                <span>Bayar di Tempat (Tunai)</span>
                                <small style="display: block; color: var(--text-muted); font-size: 0.8rem; margin-top: 0.25rem;">
                                    Bayar saat mengambil pesanan di rumah makan
                                </small>
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit-order">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle; margin-right: 8px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        Buat Pesanan
                    </button>
                </form>
            </div>

            <!-- Order Summary Section -->
            <div class="order-summary">
                <h3>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    Ringkasan Pesanan
                </h3>
                <div class="summary-items">
                    <?php foreach($data['cart'] as $item): ?>
                    <div class="summary-item">
                        <span><?= htmlspecialchars($item['nama_menu']); ?> × <?= $item['jumlah']; ?></span>
                        <span>Rp <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.'); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="summary-total-row">
                    <span>Total Pembayaran</span>
                    <span>Rp <?= number_format($data['total'], 0, ',', '.'); ?></span>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once 'app/views/templates/public_footer.php'; ?>
