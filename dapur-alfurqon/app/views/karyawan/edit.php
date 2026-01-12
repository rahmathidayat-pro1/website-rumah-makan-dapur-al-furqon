<?php require_once 'app/views/templates/header.php'; ?>

<div class="page-header">
    <h1>Edit Karyawan</h1>
    <a href="<?= BASEURL; ?>/dashboard/karyawan" class="btn-secondary">Kembali</a>
</div>

<div class="form-container">
    <form action="<?= BASEURL; ?>/dashboard/karyawan/update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_karyawan" value="<?= $data['karyawan']['id_karyawan']; ?>">
        <input type="hidden" name="fotoLama" value="<?= $data['karyawan']['foto']; ?>">
        
        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" value="<?= $data['karyawan']['nama']; ?>" required>
        </div>
        <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <input type="text" id="jabatan" name="jabatan" value="<?= $data['karyawan']['jabatan']; ?>" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="aktif" <?= $data['karyawan']['status'] == 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                <option value="nonaktif" <?= $data['karyawan']['status'] == 'nonaktif' ? 'selected' : ''; ?>>Non-Aktif</option>
            </select>
        </div>
        <div class="form-group">
            <label for="foto">Foto</label>
            <img src="<?= BASEURL; ?>/public/img/<?= $data['karyawan']['foto']; ?>" width="100" style="margin-bottom: 10px; display: block; border-radius: 4px;">
            <input type="file" id="foto" name="foto">
        </div>
        <button type="submit" class="btn-primary">Update</button>
    </form>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
