<?php require_once 'app/views/templates/header.php'; ?>

<div class="page-header">
    <h1>Daftar Menu</h1>
    <a href="<?= BASEURL; ?>/dashboard/menu/tambah" class="btn-primary">Tambah Menu</a>
</div>

<!-- Desktop Table -->
<div class="table-container desktop-table">
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Menu</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Terjual</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($data['menu'] as $m) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><img src="<?= BASEURL; ?>/public/img/<?= $m['gambar']; ?>" alt="<?= $m['nama_menu']; ?>" width="50" style="border-radius: 4px;"></td>
                <td><?= $m['nama_menu']; ?></td>
                <td><span class="badge badge-info"><?= ucfirst($m['kategori']); ?></span></td>
                <td>Rp <?= number_format($m['harga'], 0, ',', '.'); ?></td>
                <td><?= $m['jumlah_terjual']; ?></td>
                <td>
                    <span class="badge <?= $m['status'] == 'tersedia' ? 'badge-success' : 'badge-danger'; ?>">
                        <?= $m['status']; ?>
                    </span>
                </td>
                <td>
                    <a href="<?= BASEURL; ?>/dashboard/menu/edit/<?= $m['id_menu']; ?>" class="btn-sm btn-warning">Edit</a>
                    <a href="<?= BASEURL; ?>/dashboard/menu/hapus/<?= $m['id_menu']; ?>" class="btn-sm btn-danger btn-delete">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Mobile Cards -->
<div class="mobile-cards">
    <?php foreach($data['menu'] as $m) : ?>
    <div class="item-card">
        <div class="item-card-header">
            <img src="<?= BASEURL; ?>/public/img/<?= $m['gambar']; ?>" alt="<?= $m['nama_menu']; ?>" class="item-thumb">
            <div class="item-header-info">
                <h4><?= $m['nama_menu']; ?></h4>
                <span class="badge badge-info"><?= ucfirst($m['kategori']); ?></span>
            </div>
        </div>
        <div class="item-card-body">
            <div class="item-info-row">
                <span class="item-label">Harga</span>
                <span class="item-value item-price">Rp <?= number_format($m['harga'], 0, ',', '.'); ?></span>
            </div>
            <div class="item-info-row">
                <span class="item-label">Terjual</span>
                <span class="item-value"><?= $m['jumlah_terjual']; ?> pcs</span>
            </div>
            <div class="item-info-row">
                <span class="item-label">Status</span>
                <span class="badge <?= $m['status'] == 'tersedia' ? 'badge-success' : 'badge-danger'; ?>">
                    <?= $m['status']; ?>
                </span>
            </div>
        </div>
        <div class="item-card-footer">
            <a href="<?= BASEURL; ?>/dashboard/menu/edit/<?= $m['id_menu']; ?>" class="btn-sm btn-warning">Edit</a>
            <a href="<?= BASEURL; ?>/dashboard/menu/hapus/<?= $m['id_menu']; ?>" class="btn-sm btn-danger btn-delete">Hapus</a>
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
    margin: 0 0 6px 0;
    font-size: 1rem;
    color: var(--text-primary);
}

.item-card-body { padding: 12px; }

.item-info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid var(--border-light);
}

.item-info-row:last-child { border-bottom: none; }

.item-label {
    font-size: 0.85rem;
    color: var(--text-muted);
}

.item-value {
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--text-primary);
}

.item-price {
    font-weight: 700;
    color: var(--primary);
    font-size: 1rem;
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
