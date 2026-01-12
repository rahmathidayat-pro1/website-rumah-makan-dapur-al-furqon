<?php require_once 'app/views/templates/header.php'; ?>

<div class="page-header">
    <h1>Tambah Menu</h1>
    <a href="<?= BASEURL; ?>/dashboard/menu" class="btn-secondary">Kembali</a>
</div>

<div class="form-container">
    <form action="<?= BASEURL; ?>/dashboard/menu/simpan" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nama_menu">Nama Menu</label>
            <input type="text" id="nama_menu" name="nama_menu" required>
        </div>
        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori" required>
                <option value="makanan">Makanan</option>
                <option value="minuman">Minuman</option>
                <option value="aneka jajanan">Aneka Jajanan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" id="harga" name="harga" required>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="tersedia">Tersedia</option>
                <option value="habis">Habis</option>
            </select>
        </div>
        <div class="form-group">
            <label for="gambar">Gambar</label>
            <input type="file" id="gambar" name="gambar">
        </div>
        <button type="submit" class="btn-primary">Simpan</button>
    </form>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
