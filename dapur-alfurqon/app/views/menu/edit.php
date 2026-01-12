<?php require_once 'app/views/templates/header.php'; ?>

<div class="page-header">
    <h1>Edit Menu</h1>
    <a href="<?= BASEURL; ?>/dashboard/menu" class="btn-secondary">Kembali</a>
</div>

<div class="form-container">
    <form action="<?= BASEURL; ?>/dashboard/menu/update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_menu" value="<?= $data['menu']['id_menu']; ?>">
        <input type="hidden" name="gambarLama" value="<?= $data['menu']['gambar']; ?>">
        
        <div class="form-group">
            <label for="nama_menu">Nama Menu</label>
            <input type="text" id="nama_menu" name="nama_menu" value="<?= $data['menu']['nama_menu']; ?>" required>
        </div>
        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori" required>
                <option value="makanan" <?= $data['menu']['kategori'] == 'makanan' ? 'selected' : ''; ?>>Makanan</option>
                <option value="minuman" <?= $data['menu']['kategori'] == 'minuman' ? 'selected' : ''; ?>>Minuman</option>
                <option value="aneka jajanan" <?= $data['menu']['kategori'] == 'aneka jajanan' ? 'selected' : ''; ?>>Aneka Jajanan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" id="harga" name="harga" value="<?= $data['menu']['harga']; ?>" required>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="3"><?= $data['menu']['deskripsi']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="tersedia" <?= $data['menu']['status'] == 'tersedia' ? 'selected' : ''; ?>>Tersedia</option>
                <option value="habis" <?= $data['menu']['status'] == 'habis' ? 'selected' : ''; ?>>Habis</option>
            </select>
        </div>
        <div class="form-group">
            <label for="gambar">Gambar</label>
            <img src="<?= BASEURL; ?>/public/img/<?= $data['menu']['gambar']; ?>" width="100" style="margin-bottom: 10px; display: block; border-radius: 4px;">
            <input type="file" id="gambar" name="gambar">
        </div>
        <button type="submit" class="btn-primary">Update</button>
    </form>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
