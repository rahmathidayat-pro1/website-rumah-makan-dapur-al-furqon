<?php require_once 'app/views/templates/header.php'; ?>

<div class="page-header">
    <h1><?= $data['title']; ?></h1>
    <a href="<?= BASEURL; ?>/dashboard/artikel" class="btn-secondary">Kembali</a>
</div>

<div class="form-container">
    <form action="<?= BASEURL; ?>/dashboard/artikel/simpan" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="judul">Judul Artikel <span style="color: var(--danger);">*</span></label>
            <input type="text" id="judul" name="judul" required 
                   style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem; transition: all var(--transition-fast);"
                   placeholder="Masukkan judul artikel">
        </div>

        <div class="form-group">
            <label for="kategori">Kategori <span style="color: var(--danger);">*</span></label>
            <select id="kategori" name="kategori" required 
                    style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem; background: white;">
                <option value="">Pilih Kategori</option>
                <option value="berita">Berita</option>
                <option value="tips">Tips</option>
                <option value="resep">Resep</option>
                <option value="promo">Promo</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal Publikasi <span style="color: var(--danger);">*</span></label>
            <input type="date" id="tanggal" name="tanggal" required 
                   value="<?= date('Y-m-d'); ?>"
                   style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem;">
            <small style="font-size: 0.875rem; color: var(--text-muted); margin-top: 0.5rem; display: block;">
                Tanggal artikel akan ditampilkan
            </small>
        </div>

        <div class="form-group">
            <label for="gambar">Gambar Artikel</label>
            <input type="file" id="gambar" name="gambar" accept="image/*"
                   style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem; background: white;">
            <small style="font-size: 0.875rem; color: var(--text-muted); margin-top: 0.5rem; display: block;">
                Format: JPG, JPEG, PNG, GIF. Maksimal 5MB. (Opsional)
            </small>
        </div>

        <div class="form-group">
            <label for="konten">Konten Artikel <span style="color: var(--danger);">*</span></label>
            <textarea id="konten" name="konten" rows="15" required 
                      placeholder="Tulis konten artikel di sini..."
                      style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem; resize: vertical; min-height: 300px; line-height: 1.6;"></textarea>
        </div>

        <div class="form-group">
            <label for="status">Status Publikasi <span style="color: var(--danger);">*</span></label>
            <select id="status" name="status" required 
                    style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem; background: white;">
                <option value="draft">Draft (Belum Dipublikasi)</option>
                <option value="published">Published (Dipublikasi)</option>
            </select>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-light);">
            <button type="submit" class="btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                Simpan Artikel
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