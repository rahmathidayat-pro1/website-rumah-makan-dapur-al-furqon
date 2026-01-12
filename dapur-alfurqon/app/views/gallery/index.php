<?php require_once 'app/views/templates/header.php'; ?>

<div class="page-header">
    <h1>Kelola Gallery</h1>
    <a href="<?= BASEURL; ?>/dashboard/gallery/tambah" class="btn-primary">Tambah Foto</a>
</div>

<!-- Desktop Table -->
<div class="table-container desktop-table">
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($data['gallery'] as $g) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><img src="<?= BASEURL; ?>/public/img/<?= $g['gambar']; ?>" alt="<?= $g['judul']; ?>" width="80" style="border-radius: 8px; object-fit: cover; height: 60px;"></td>
                <td><?= htmlspecialchars($g['judul']); ?></td>
                <td><?= htmlspecialchars(substr($g['deskripsi'], 0, 50)); ?>...</td>
                <td>
                    <span class="badge <?= $g['status'] == 'aktif' ? 'badge-success' : 'badge-danger'; ?>">
                        <?= $g['status']; ?>
                    </span>
                </td>
                <td>
                    <a href="<?= BASEURL; ?>/dashboard/gallery/edit/<?= $g['id_gallery']; ?>" class="btn-sm btn-warning">Edit</a>
                    <a href="<?= BASEURL; ?>/dashboard/gallery/hapus/<?= $g['id_gallery']; ?>" class="btn-sm btn-danger btn-delete">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Mobile Cards -->
<div class="mobile-cards">
    <?php foreach($data['gallery'] as $g) : ?>
    <div class="item-card">
        <div class="item-card-header">
            <img src="<?= BASEURL; ?>/public/img/<?= $g['gambar']; ?>" alt="<?= $g['judul']; ?>" class="item-thumb-lg">
            <div class="item-header-info">
                <h4><?= htmlspecialchars($g['judul']); ?></h4>
                <span class="badge <?= $g['status'] == 'aktif' ? 'badge-success' : 'badge-danger'; ?>">
                    <?= $g['status']; ?>
                </span>
            </div>
        </div>
        <div class="item-card-body">
            <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0; line-height: 1.5;">
                <?= htmlspecialchars(substr($g['deskripsi'], 0, 80)); ?>...
            </p>
        </div>
        <div class="item-card-footer">
            <a href="<?= BASEURL; ?>/dashboard/gallery/edit/<?= $g['id_gallery']; ?>" class="btn-sm btn-warning">Edit</a>
            <a href="<?= BASEURL; ?>/dashboard/gallery/hapus/<?= $g['id_gallery']; ?>" class="btn-sm btn-danger btn-delete">Hapus</a>
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

.item-thumb-lg {
    width: 80px;
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
