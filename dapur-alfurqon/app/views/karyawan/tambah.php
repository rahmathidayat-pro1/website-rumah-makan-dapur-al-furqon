<?php require_once 'app/views/templates/header.php'; ?>

<div class="page-header">
    <h1>Tambah Karyawan</h1>
    <a href="<?= BASEURL; ?>/dashboard/karyawan" class="btn-secondary">Kembali</a>
</div>

<div class="form-container">
    <form action="<?= BASEURL; ?>/dashboard/karyawan/simpan" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" required>
        </div>
        <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <input type="text" id="jabatan" name="jabatan" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Non-Aktif</option>
            </select>
        </div>
        <div class="form-group">
            <label for="foto">Foto</label>
            <input type="file" id="foto" name="foto">
        </div>
        <button type="submit" class="btn-primary">Simpan</button>
    </form>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
