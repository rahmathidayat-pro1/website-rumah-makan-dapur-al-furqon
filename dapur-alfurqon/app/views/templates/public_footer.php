    </main>

    <!-- Floating Cart Button (Mobile Only) -->
    <?php 
    $cartCount = 0;
    $cartTotal = 0;
    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach($_SESSION['cart'] as $item) {
            $cartCount += $item['jumlah'];
            $cartTotal += $item['harga'] * $item['jumlah'];
        }
    }
    ?>
    <?php if($cartCount > 0): ?>
    <a href="<?= BASEURL; ?>/home/cart" class="floating-cart-btn" id="floatingCartBtn">
        <div class="floating-cart-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <span class="floating-cart-badge"><?= $cartCount; ?></span>
        </div>
        <div class="floating-cart-info">
            <span class="floating-cart-text"><?= $cartCount; ?> item</span>
            <span class="floating-cart-total">Rp <?= number_format($cartTotal, 0, ',', '.'); ?></span>
        </div>
        <div class="floating-cart-arrow">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>
    <?php endif; ?>

    <!-- Footer -->
    <footer class="public-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <img src="<?= BASEURL; ?>/public/img/logo-dapur-al-furqon.png" alt="Dapur Al-Furqon" class="footer-logo">
                    <p>Menyajikan hidangan lezat dengan cita rasa otentik dan bahan berkualitas terbaik untuk keluarga Indonesia.</p>
                </div>
                <div class="footer-links">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="<?= BASEURL; ?>">Menu</a></li>
                        <li><a href="<?= BASEURL; ?>/home/cart">Keranjang</a></li>
                        <li><a href="https://wa.me/6281234567890" target="_blank">Hubungi Kami</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h4>Hubungi Kami</h4>
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        Jl. Contoh No. 123, Kota
                    </p>
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        (021) 1234-5678
                    </p>
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        info@dapuralfurqon.com
                    </p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?= date('Y'); ?> Dapur Al-Furqon. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        if(mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', () => {
                mobileMenu.classList.toggle('active');
                // Toggle icon between hamburger and X
                const icon = mobileMenuToggle.querySelector('svg');
                if(mobileMenu.classList.contains('active')) {
                    icon.innerHTML = '<line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>';
                } else {
                    icon.innerHTML = '<line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line>';
                }
            });
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (mobileMenu && !mobileMenu.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                mobileMenu.classList.remove('active');
                const icon = mobileMenuToggle.querySelector('svg');
                icon.innerHTML = '<line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line>';
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if(target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
