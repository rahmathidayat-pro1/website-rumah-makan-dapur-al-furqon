<?php require_once 'app/views/templates/public_header.php'; ?>

<div class="container">
    <section class="order-section" style="padding: 4rem 0;">
        <h1 style="text-align: center; margin-bottom: 1rem; font-size: 2.5rem;">Form Pemesanan</h1>
        <p style="text-align: center; color: var(--text-light); margin-bottom: 3rem;">Silakan isi form di bawah ini untuk melakukan pemesanan.</p>

        <?php if(isset($data['selected_menu']) && $data['selected_menu']): ?>
        <div class="selected-menu-info" style="max-width: 800px; margin: 0 auto 2rem;">
            <h3 style="margin-bottom: 1rem; color: var(--secondary-color);">Menu yang Dipilih:</h3>
            <div class="selected-menu-card" style="display: flex; gap: 1.5rem; background: white; padding: 1.5rem; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
                <img src="<?= BASEURL; ?>/public/img/<?= $data['selected_menu']['gambar']; ?>" alt="<?= $data['selected_menu']['nama_menu']; ?>" style="width: 120px; height: 120px; object-fit: cover; border-radius: var(--radius-sm);">
                <div class="selected-menu-details" style="flex: 1;">
                    <h4 style="font-size: 1.25rem; margin-bottom: 0.5rem;"><?= $data['selected_menu']['nama_menu']; ?></h4>
                    <p style="color: var(--text-light); margin-bottom: 1rem;"><?= $data['selected_menu']['deskripsi']; ?></p>
                    <span class="price" style="font-size: 1.25rem; font-weight: 700; color: var(--primary-color);">Rp <?= number_format($data['selected_menu']['harga'], 0, ',', '.'); ?></span>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="order-form-container" style="max-width: 800px; margin: 0 auto; background: white; padding: 2.5rem; border-radius: var(--radius-md); box-shadow: var(--shadow-sm);">
            <form id="orderForm" class="order-form">
                <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label for="nama_pelanggan" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nama Lengkap <span class="required" style="color: var(--danger-color);">*</span></label>
                        <input type="text" id="nama_pelanggan" name="nama_pelanggan" required placeholder="Masukkan nama lengkap" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--radius-sm);">
                    </div>
                    <div class="form-group">
                        <label for="no_telepon" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">No. Telepon <span class="required" style="color: var(--danger-color);">*</span></label>
                        <input type="tel" id="no_telepon" name="no_telepon" required placeholder="08xxxxxxxxxx" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--radius-sm);">
                    </div>
                </div>



                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="menu" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Pilih Menu <span class="required" style="color: var(--danger-color);">*</span></label>
                    <select id="menu" name="menu" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--radius-sm); background: white;">
                        <option value="">-- Pilih Menu --</option>
                        <?php foreach($data['menu'] as $m) : ?>
                            <?php if($m['status'] == 'tersedia') : ?>
                                <option value="<?= $m['id_menu']; ?>" data-harga="<?= $m['harga']; ?>" 
                                    <?= (isset($data['selected_menu']) && $data['selected_menu'] && $data['selected_menu']['id_menu'] == $m['id_menu']) ? 'selected' : ''; ?>>
                                    <?= $m['nama_menu']; ?> - Rp <?= number_format($m['harga'], 0, ',', '.'); ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label for="jumlah" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Jumlah <span class="required" style="color: var(--danger-color);">*</span></label>
                        <input type="number" id="jumlah" name="jumlah" min="1" value="1" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--radius-sm);">
                    </div>
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Total Harga</label>
                        <div class="total-display" id="totalHarga" style="padding: 0.75rem; background: var(--bg-color); border-radius: var(--radius-sm); font-weight: 700; color: var(--primary-color);">Rp 0</div>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="catatan" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Catatan Pesanan</label>
                    <textarea id="catatan" name="catatan" rows="3" placeholder="Catatan khusus untuk pesanan Anda (tidak pedas, tanpa bawang, dll.)" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--radius-sm);"></textarea>
                </div>

                <button type="submit" class="btn-submit-order" style="width: 100%; padding: 1rem; background: var(--primary-color); color: white; border: none; border-radius: var(--radius-sm); font-weight: 600; font-size: 1.1rem; cursor: pointer; transition: background 0.2s;">Kirim Pesanan</button>
            </form>
        </div>
    </section>
</div>

<script>
    // Calculate total price
    const menuSelect = document.getElementById('menu');
    const jumlahInput = document.getElementById('jumlah');
    const totalDisplay = document.getElementById('totalHarga');

    function updateTotal() {
        const selectedOption = menuSelect.options[menuSelect.selectedIndex];
        const harga = selectedOption.getAttribute('data-harga') || 0;
        const jumlah = jumlahInput.value || 0;
        const total = harga * jumlah;
        totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    menuSelect.addEventListener('change', updateTotal);
    jumlahInput.addEventListener('input', updateTotal);

    // Initial calculation if menu is pre-selected
    updateTotal();

    // Form submission (placeholder for now)
    document.getElementById('orderForm').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Fitur Belum Tersedia',
            text: 'Fungsi pemesanan akan segera ditambahkan.',
            icon: 'info',
            confirmButtonColor: '#4f46e5'
        });
    });
</script>

<?php require_once 'app/views/templates/public_footer.php'; ?>
