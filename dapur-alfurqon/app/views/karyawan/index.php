<?php require_once 'app/views/templates/header.php'; ?>

<div class="page-header">
    <h1>Daftar Karyawan</h1>
    <a href="<?= BASEURL; ?>/dashboard/karyawan/tambah" class="btn-primary">Tambah Karyawan</a>
</div>

<!-- Desktop Table -->
<div class="table-container desktop-table">
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($data['karyawan'] as $k) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><img src="<?= BASEURL; ?>/public/img/<?= $k['foto']; ?>" alt="<?= $k['nama']; ?>" width="50" style="border-radius: 4px;"></td>
                <td><?= $k['nama']; ?></td>
                <td><?= $k['jabatan']; ?></td>
                <td>
                    <span class="badge <?= $k['status'] == 'aktif' ? 'badge-success' : 'badge-danger'; ?>">
                        <?= $k['status']; ?>
                    </span>
                </td>
                <td>
                    <a href="<?= BASEURL; ?>/dashboard/karyawan/edit/<?= $k['id_karyawan']; ?>" class="btn-sm btn-warning">Edit</a>
                    <a href="<?= BASEURL; ?>/dashboard/karyawan/hapus/<?= $k['id_karyawan']; ?>" class="btn-sm btn-danger btn-delete">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Mobile Cards -->
<div class="mobile-cards">
    <?php foreach($data['karyawan'] as $k) : ?>
    <div class="item-card">
        <div class="item-card-header">
            <img src="<?= BASEURL; ?>/public/img/<?= $k['foto']; ?>" alt="<?= $k['nama']; ?>" class="item-thumb">
            <div class="item-header-info">
                <h4><?= $k['nama']; ?></h4>
                <span style="color: var(--text-muted); font-size: 0.9rem;"><?= $k['jabatan']; ?></span>
            </div>
        </div>
        <div class="item-card-body">
            <div class="item-info-row">
                <span class="item-label">Status</span>
                <span class="badge <?= $k['status'] == 'aktif' ? 'badge-success' : 'badge-danger'; ?>">
                    <?= $k['status']; ?>
                </span>
            </div>
        </div>
        <div class="item-card-footer">
            <a href="<?= BASEURL; ?>/dashboard/karyawan/edit/<?= $k['id_karyawan']; ?>" class="btn-sm btn-warning">Edit</a>
            <a href="<?= BASEURL; ?>/dashboard/karyawan/hapus/<?= $k['id_karyawan']; ?>" class="btn-sm btn-danger btn-delete">Hapus</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<style>
.mobile-cards { display: none; }

.item-card {
    background: white;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
    margin-bottom: 12px;
    overflow: hidden;
}

.item-card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: var(--bg-secondary);
    border-bottom: 1px solid var(--border-light);
}

.item-thumb {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: var(--radius-sm);
}

.item-header-info h4 {
    margin: 0 0 4px 0;
    font-size: 1rem;
    color: var(--text-primary);
}

.item-card-body { padding: 12px; }

.item-info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
}

.item-label {
    font-size: 0.85rem;
    color: var(--text-muted);
}

.item-card-footer {
    display: flex;
    gap: 8px;
    padding: 12px;
    background: var(--bg-secondary);
    border-top: 1px solid var(--border-light);
}

.item-card-footer .btn-sm {
    flex: 1;
    text-align: center;
    padding: 10px 12px;
}

@media (max-width: 768px) {
    .desktop-table { display: none; }
    .mobile-cards { display: block; }
}
</style>

<?php require_once 'app/views/templates/footer.php'; ?>
