<?php require_once 'app/views/templates/header.php'; ?>

<div class="page-header">
    <h1><?= $data['title']; ?></h1>
    <a href="<?= BASEURL; ?>/dashboard/artikel/tambah" class="btn-primary">Tambah Artikel</a>
</div>

<?php Flasher::flash(); ?>

<!-- Desktop Table -->
<div class="table-container desktop-table">
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach($data['artikel'] as $artikel) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td>
                    <?php if($artikel['gambar']) : ?>
                        <img src="<?= BASEURL; ?>/public/img/<?= $artikel['gambar']; ?>" 
                             alt="<?= $artikel['judul']; ?>" 
                             style="width: 60px; height: 40px; object-fit: cover; border-radius: var(--radius-sm); box-shadow: var(--shadow-xs);">
                    <?php else : ?>
                        <div style="width: 60px; height: 40px; background: var(--bg-secondary); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 12px; color: var(--text-muted);">
                            No Image
                        </div>
                    <?php endif; ?>
                </td>
                <td>
                    <div style="max-width: 300px;">
                        <strong style="color: var(--text-primary); font-size: 0.95rem;"><?= $artikel['judul']; ?></strong>
                        <br>
                        <small style="color: var(--text-muted); line-height: 1.4;"><?= substr(strip_tags($artikel['konten']), 0, 80); ?>...</small>
                    </div>
                </td>
                <td>
                    <span class="badge badge-info">
                        <?= ucfirst($artikel['kategori']); ?>
                    </span>
                </td>
                <td>
                    <span class="badge badge-<?= $artikel['status'] == 'published' ? 'success' : 'warning'; ?>">
                        <?= $artikel['status'] == 'published' ? 'Published' : 'Draft'; ?>
                    </span>
                </td>
                <td style="font-size: 0.9rem; color: var(--text-secondary);">
                    <?= date('d/m/Y', strtotime($artikel['tanggal'])); ?>
                </td>
                <td>
                    <div style="display: flex; gap: 4px;">
                        <a href="<?= BASEURL; ?>/dashboard/artikel/edit/<?= $artikel['id_artikel']; ?>" 
                           class="btn-warning btn-sm">Edit</a>
                        <a href="<?= BASEURL; ?>/dashboard/artikel/hapus/<?= $artikel['id_artikel']; ?>" 
                           class="btn-danger btn-sm" 
                           onclick="return confirm('Yakin ingin menghapus artikel ini?')">Hapus</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            
            <?php if(empty($data['artikel'])) : ?>
            <tr>
                <td colspan="7" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                        </svg>
                        <div>
                            <h3 style="margin-bottom: 0.5rem; color: var(--text-secondary);">Belum Ada Artikel</h3>
                            <p style="margin: 0;">Mulai dengan menambahkan artikel pertama Anda.</p>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Mobile Cards -->
<div class="mobile-cards">
    <?php if(empty($data['artikel'])) : ?>
        <div style="text-align: center; padding: 3rem; color: var(--text-muted); background: white; border-radius: var(--radius-md);">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 1rem;">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
            </svg>
            <h3 style="margin-bottom: 0.5rem; color: var(--text-secondary);">Belum Ada Artikel</h3>
            <p style="margin: 0;">Mulai dengan menambahkan artikel pertama Anda.</p>
        </div>
    <?php else: ?>
        <?php foreach($data['artikel'] as $artikel) : ?>
        <div class="item-card">
            <div class="item-card-header">
                <?php if($artikel['gambar']) : ?>
                    <img src="<?= BASEURL; ?>/public/img/<?= $artikel['gambar']; ?>" alt="<?= $artikel['judul']; ?>" class="item-thumb">
                <?php else : ?>
                    <div class="item-thumb" style="background: var(--bg-secondary); display: flex; align-items: center; justify-content: center; font-size: 10px; color: var(--text-muted);">No Img</div>
                <?php endif; ?>
                <div class="item-header-info">
                    <h4><?= $artikel['judul']; ?></h4>
                    <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                        <span class="badge badge-info"><?= ucfirst($artikel['kategori']); ?></span>
                        <span class="badge badge-<?= $artikel['status'] == 'published' ? 'success' : 'warning'; ?>">
                            <?= $artikel['status'] == 'published' ? 'Published' : 'Draft'; ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="item-card-body">
                <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0 0 8px 0; line-height: 1.5;">
                    <?= substr(strip_tags($artikel['konten']), 0, 100); ?>...
                </p>
                <div class="item-info-row">
                    <span class="item-label">Tanggal</span>
                    <span class="item-value"><?= date('d/m/Y', strtotime($artikel['tanggal'])); ?></span>
                </div>
            </div>
            <div class="item-card-footer">
                <a href="<?= BASEURL; ?>/dashboard/artikel/edit/<?= $artikel['id_artikel']; ?>" class="btn-sm btn-warning">Edit</a>
                <a href="<?= BASEURL; ?>/dashboard/artikel/hapus/<?= $artikel['id_artikel']; ?>" class="btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus artikel ini?')">Hapus</a>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
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
    flex-shrink: 0;
}

.item-header-info {
    flex: 1;
    min-width: 0;
}

.item-header-info h4 {
    margin: 0 0 6px 0;
    font-size: 0.95rem;
    color: var(--text-primary);
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
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

.item-value {
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--text-primary);
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