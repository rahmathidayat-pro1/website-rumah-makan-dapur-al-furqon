<?php require_once 'app/views/templates/public_header.php'; ?>

<!-- Hero Section - Full Width -->
<section class="hero-section">
        <h1>Nikmati <span>Kelezatan</span> Otentik</h1>
        <p>Dapur Al-Furqon menyajikan hidangan terbaik dengan bahan pilihan dan resep istimewa untuk momen berharga Anda.</p>
        <a href="#menu-section" class="hero-cta">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
            Pesan Sekarang
        </a>
</section>

<div class="container">
    <!-- Search Section -->
    <div class="search-container">
        <form action="<?= BASEURL; ?>" method="GET" class="search-form">
            <input type="text" name="keyword" class="search-input" placeholder="Cari menu favorit Anda..." value="<?= isset($data['keyword']) ? htmlspecialchars($data['keyword']) : ''; ?>" autocomplete="off">
            <button type="submit" class="search-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                Cari
            </button>
        </form>
    </div>

    <!-- Menu Section -->
    <section class="menu-section" id="menu-section">
        <h2>Menu Kami</h2>
        <div class="section-divider"></div>
        
        <!-- Menu Tabs -->
        <div class="menu-tabs">
            <button class="menu-tab active" data-category="semua">Semua</button>
            <button class="menu-tab" data-category="terlaris">🔥 Paling Laris</button>
            <button class="menu-tab" data-category="makanan">Makanan</button>
            <button class="menu-tab" data-category="minuman">Minuman</button>
            <button class="menu-tab" data-category="aneka jajanan">Aneka Jajanan</button>
        </div>

        <!-- Menu Grid - Semua Menu -->
        <div class="menu-grid" id="menu-semua">
            <?php foreach($data['menu'] as $m) : ?>
                <?php if($m['status'] == 'tersedia') : ?>
                <div class="menu-card" data-kategori="<?= $m['kategori']; ?>">
                    <div class="menu-image">
                        <img src="<?= BASEURL; ?>/public/img/<?= $m['gambar']; ?>" alt="<?= htmlspecialchars($m['nama_menu']); ?>" loading="lazy">
                        <span class="menu-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline; vertical-align: middle; margin-right: 4px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Tersedia
                        </span>
                    </div>
                    <div class="menu-info">
                        <h3><?= htmlspecialchars($m['nama_menu']); ?></h3>
                        <p class="menu-description"><?= htmlspecialchars($m['deskripsi']); ?></p>
                        <div class="menu-footer">
                            <span class="menu-price">Rp <?= number_format($m['harga'], 0, ',', '.'); ?></span>
                            <form action="<?= BASEURL; ?>/home/addToCart" method="POST" style="display: inline;">
                                <input type="hidden" name="id_menu" value="<?= $m['id_menu']; ?>">
                                <input type="hidden" name="jumlah" value="1">
                                <button type="submit" class="btn-order">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                    Pesan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Menu Grid - Paling Laris -->
        <div class="menu-grid" id="menu-terlaris" style="display: none;">
            <?php if(!empty($data['menu_terlaris'])) : ?>
                <?php foreach($data['menu_terlaris'] as $m) : ?>
                    <?php if($m['status'] == 'tersedia' && $m['jumlah_terjual'] > 0) : ?>
                    <div class="menu-card">
                        <div class="menu-image">
                            <img src="<?= BASEURL; ?>/public/img/<?= $m['gambar']; ?>" alt="<?= htmlspecialchars($m['nama_menu']); ?>" loading="lazy">
                            <span class="menu-badge badge-hot">🔥 <?= $m['jumlah_terjual']; ?> Terjual</span>
                        </div>
                        <div class="menu-info">
                            <h3><?= htmlspecialchars($m['nama_menu']); ?></h3>
                            <p class="menu-description"><?= htmlspecialchars($m['deskripsi']); ?></p>
                            <div class="menu-footer">
                                <span class="menu-price">Rp <?= number_format($m['harga'], 0, ',', '.'); ?></span>
                                <form action="<?= BASEURL; ?>/home/addToCart" method="POST" style="display: inline;">
                                    <input type="hidden" name="id_menu" value="<?= $m['id_menu']; ?>">
                                    <input type="hidden" name="jumlah" value="1">
                                    <button type="submit" class="btn-order">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                        Pesan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="empty-message">Belum ada data menu terlaris.</p>
            <?php endif; ?>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.menu-tab');
    const menuSemua = document.getElementById('menu-semua');
    const menuTerlaris = document.getElementById('menu-terlaris');
    const allCards = menuSemua.querySelectorAll('.menu-card');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const category = this.dataset.category;

            if (category === 'terlaris') {
                menuSemua.style.display = 'none';
                menuTerlaris.style.display = 'grid';
            } else {
                menuSemua.style.display = 'grid';
                menuTerlaris.style.display = 'none';

                allCards.forEach(card => {
                    if (category === 'semua') {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = card.dataset.kategori === category ? 'flex' : 'none';
                    }
                });
            }
        });
    });
});
</script>

<?php require_once 'app/views/templates/public_footer.php'; ?>
