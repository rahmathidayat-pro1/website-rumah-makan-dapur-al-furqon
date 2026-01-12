<?php require_once 'app/views/templates/header.php'; ?>

<div class="page-header">
    <h1><?= $data['title']; ?></h1>
    <a href="<?= BASEURL; ?>/dashboard/artikel" class="btn-secondary">Kembali</a>
</div>

<div class="form-container">
    <form action="<?= BASEURL; ?>/dashboard/artikel/update" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_artikel" value="<?= $data['artikel']['id_artikel']; ?>">
        <input type="hidden" name="gambarLama" value="<?= $data['artikel']['gambar']; ?>">
        
        <div class="form-group">
            <label for="judul">Judul Artikel <span style="color: var(--danger);">*</span></label>
            <input type="text" id="judul" name="judul" value="<?= htmlspecialchars($data['artikel']['judul']); ?>" required 
                   style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem; transition: all var(--transition-fast);"
                   placeholder="Masukkan judul artikel">
        </div>

        <div class="form-group">
            <label for="kategori">Kategori <span style="color: var(--danger);">*</span></label>
            <select id="kategori" name="kategori" required 
                    style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem; background: white;">
                <option value="">Pilih Kategori</option>
                <option value="berita" <?= $data['artikel']['kategori'] == 'berita' ? 'selected' : ''; ?>>Berita</option>
                <option value="tips" <?= $data['artikel']['kategori'] == 'tips' ? 'selected' : ''; ?>>Tips</option>
                <option value="resep" <?= $data['artikel']['kategori'] == 'resep' ? 'selected' : ''; ?>>Resep</option>
                <option value="promo" <?= $data['artikel']['kategori'] == 'promo' ? 'selected' : ''; ?>>Promo</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal Publikasi <span style="color: var(--danger);">*</span></label>
            <input type="date" id="tanggal" name="tanggal" required 
                   value="<?= isset($data['artikel']['tanggal']) ? date('Y-m-d', strtotime($data['artikel']['tanggal'])) : date('Y-m-d'); ?>"
                   style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem;">
            <small style="font-size: 0.875rem; color: var(--text-muted); margin-top: 0.5rem; display: block;">
                Tanggal artikel akan ditampilkan
            </small>
        </div>

        <div class="form-group">
            <label for="gambar">Gambar Artikel</label>
            <?php if($data['artikel']['gambar']) : ?>
                <div style="margin-bottom: 1rem; padding: 1rem; background: var(--bg-secondary); border-radius: var(--radius-md);">
                    <p style="font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 0.75rem; font-weight: 500;">Gambar Saat Ini:</p>
                    <img src="<?= BASEURL; ?>/public/img/<?= $data['artikel']['gambar']; ?>" 
                         alt="<?= htmlspecialchars($data['artikel']['judul']); ?>" 
                         style="max-width: 200px; height: auto; border-radius: var(--radius-md); border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
                </div>
            <?php endif; ?>
            <input type="file" id="gambar" name="gambar" accept="image/*"
                   style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem; background: white;">
            <small style="font-size: 0.875rem; color: var(--text-muted); margin-top: 0.5rem; display: block;">
                Format: JPG, JPEG, PNG, GIF. Maksimal 5MB. Kosongkan jika tidak ingin mengubah gambar.
            </small>
        </div>

        <div class="form-group">
            <label for="konten">Konten Artikel <span style="color: var(--danger);">*</span></label>
            <textarea id="konten" name="konten" rows="15" required 
                      placeholder="Tulis konten artikel di sini..."
                      style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem; resize: vertical; min-height: 300px; line-height: 1.6;"><?= htmlspecialchars($data['artikel']['konten']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="status">Status Publikasi <span style="color: var(--danger);">*</span></label>
            <select id="status" name="status" required 
                    style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem; background: white;">
                <option value="draft" <?= $data['artikel']['status'] == 'draft' ? 'selected' : ''; ?>>Draft (Belum Dipublikasi)</option>
                <option value="published" <?= $data['artikel']['status'] == 'published' ? 'selected' : ''; ?>>Published (Dipublikasi)</option>
            </select>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-light);">
            <button type="submit" class="btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                Update Artikel
            </button>
            <a href="<?= BASEURL; ?>/dashboard/artikel" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>

<style>
.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.75rem;
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.95rem;
}

input:focus, select:focus, textarea:focus {
    outline: none !important;
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 3px rgba(170, 25, 66, 0.1) !important;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
}
</style>

<?php require_once 'app/views/templates/footer.php'; ?>