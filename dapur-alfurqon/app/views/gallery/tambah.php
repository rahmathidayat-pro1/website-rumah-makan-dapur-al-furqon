<?php require_once 'app/views/templates/header.php'; ?>

<div class="page-header">
    <h1>Tambah Foto Gallery</h1>
    <a href="<?= BASEURL; ?>/dashboard/gallery" class="btn-secondary">Kembali</a>
</div>

<div class="form-container">
    <form action="<?= BASEURL; ?>/dashboard/gallery/simpan" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="judul">Judul Foto</label>
            <input type="text" name="judul" id="judul" required placeholder="Masukkan judul foto">
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" placeholder="Masukkan deskripsi foto (opsional)"></textarea>
        </div>
        <div class="form-group">
            <label for="gambar">Upload Gambar</label>
            <input type="file" name="gambar" id="gambar" accept="image/*" required>
            <small class="form-text">Format: JPG, JPEG, PNG, GIF, WEBP. Maksimal 5MB</small>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" required>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
        </div>
        <button type="submit" class="btn-primary">Simpan</button>
    </form>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
