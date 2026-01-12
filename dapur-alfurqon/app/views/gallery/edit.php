<?php require_once 'app/views/templates/header.php'; ?>

<div class="page-header">
    <h1>Edit Foto Gallery</h1>
    <a href="<?= BASEURL; ?>/dashboard/gallery" class="btn-secondary">Kembali</a>
</div>

<div class="form-container">
    <form action="<?= BASEURL; ?>/dashboard/gallery/update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_gallery" value="<?= $data['gallery']['id_gallery']; ?>">
        <input type="hidden" name="gambarLama" value="<?= $data['gallery']['gambar']; ?>">
        
        <div class="form-group">
            <label for="judul">Judul Foto</label>
            <input type="text" name="judul" id="judul" required value="<?= htmlspecialchars($data['gallery']['judul']); ?>">
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4"><?= htmlspecialchars($data['gallery']['deskripsi']); ?></textarea>
        </div>
        <div class="form-group">
            <label>Gambar Saat Ini</label>
            <div style="margin-bottom: 12px;">
                <img src="<?= BASEURL; ?>/public/img/<?= $data['gallery']['gambar']; ?>" alt="Current" style="max-width: 200px; border-radius: 8px;">
            </div>
            <label for="gambar">Upload Gambar Baru (Opsional)</label>
            <input type="file" name="gambar" id="gambar" accept="image/*">
            <small class="form-text">Kosongkan jika tidak ingin mengubah gambar</small>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" required>
                <option value="aktif" <?= $data['gallery']['status'] == 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                <option value="nonaktif" <?= $data['gallery']['status'] == 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
            </select>
        </div>
        <button type="submit" class="btn-primary">Update</button>
    </form>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
