<?php require_once 'app/views/templates/public_header.php'; ?>

<div class="container">
    <section class="cart-section">
        <h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle; margin-right: 12px; color: var(--primary);"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            Keranjang Belanja
        </h1>
        
        <?php if(empty($data['cart'])): ?>
            <div class="empty-cart">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                <h3>Keranjang Anda Kosong</h3>
                <p>Silakan pilih menu favorit Anda untuk ditambahkan ke keranjang</p>
                <a href="<?= BASEURL; ?>" class="btn-order" style="padding: 14px 32px; font-size: 1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Lihat Menu
                </a>
            </div>
        <?php else: ?>
            <div class="cart-container">
                <div class="cart-items">
                    <?php foreach($data['cart'] as $item): ?>
                    <div class="cart-item">
                        <img src="<?= BASEURL; ?>/public/img/<?= $item['gambar']; ?>" alt="<?= htmlspecialchars($item['nama_menu']); ?>" class="cart-item-image">
                        <div class="cart-item-info">
                            <h3><?= htmlspecialchars($item['nama_menu']); ?></h3>
                            <p class="cart-item-price">Rp <?= number_format($item['harga'], 0, ',', '.'); ?> / item</p>
                            <div class="cart-item-actions">
                                <form action="<?= BASEURL; ?>/cart/update" method="POST" class="quantity-form">
                                    <input type="hidden" name="id_menu" value="<?= $item['id_menu']; ?>">
                                    <button type="button" class="qty-btn" onclick="decreaseQty(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    </button>
                                    <input type="number" name="jumlah" value="<?= $item['jumlah']; ?>" min="1" class="qty-input" onchange="this.form.submit()">
                                    <button type="button" class="qty-btn" onclick="increaseQty(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    </button>
                                </form>
                                <p class="cart-item-subtotal">Rp <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.'); ?></p>
                                <a href="<?= BASEURL; ?>/cart/remove/<?= $item['id_menu']; ?>" class="btn-remove" onclick="return confirm('Hapus item ini dari keranjang?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="cart-summary">
                    <h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        Ringkasan Belanja
                    </h3>
                    <div class="summary-row">
                        <span>Total (<?= count($data['cart']); ?> item)</span>
                        <span class="summary-total">Rp <?= number_format($data['total'], 0, ',', '.'); ?></span>
                    </div>
                    <a href="<?= BASEURL; ?>/checkout" class="btn-checkout">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle; margin-right: 8px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        Lanjut ke Checkout
                    </a>
                    <a href="<?= BASEURL; ?>" class="btn-continue">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle; margin-right: 8px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </section>
</div>

<script>
function increaseQty(btn) {
    const input = btn.previousElementSibling;
    input.value = parseInt(input.value) + 1;
    input.form.submit();
}

function decreaseQty(btn) {
    const input = btn.nextElementSibling;
    if(parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        input.form.submit();
    }
}
</script>

<?php require_once 'app/views/templates/public_footer.php'; ?>
