<?php require_once 'app/views/templates/header.php'; ?>

<div class="page-header">
    <h1>Detail Pesanan <?= isset($data['order']['nomor_pesanan']) ? $data['order']['nomor_pesanan'] : '#' . str_pad($data['order']['id_order'], 5, '0', STR_PAD_LEFT); ?></h1>
    <a href="<?= BASEURL; ?>/dashboard/order" class="btn-secondary">Kembali</a>
</div>

<div class="order-detail-container">
    <div class="order-info-card">
        <h3>Informasi Pelanggan</h3>
        <table class="info-table">
            <tr>
                <td><strong>No. Pesanan</strong></td>
                <td><strong style="color: var(--primary); font-size: 1.1rem;"><?= isset($data['order']['nomor_pesanan']) ? $data['order']['nomor_pesanan'] : '#' . str_pad($data['order']['id_order'], 5, '0', STR_PAD_LEFT); ?></strong></td>
            </tr>
            <tr>
                <td><strong>Nama</strong></td>
                <td><?= htmlspecialchars($data['order']['nama_pelanggan']); ?></td>
            </tr>
            <tr>
                <td><strong>No. Telepon</strong></td>
                <td><?= $data['order']['no_telepon']; ?></td>
            </tr>
            <tr>
                <td><strong>Catatan</strong></td>
                <td>
                    <?php if(!empty($data['order']['catatan'])): ?>
                        <?= nl2br(htmlspecialchars($data['order']['catatan'])); ?>
                    <?php else: ?>
                        <em style="color: var(--text-muted);">Tidak ada catatan</em>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td><strong>Tanggal Pesanan</strong></td>
                <td><?= date('d F Y, H:i', strtotime($data['order']['tanggal_order'])); ?></td>
            </tr>
        </table>
    </div>

    <div class="order-items-card">
        <h3>Item Pesanan</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['order_details'] as $detail): ?>
                <tr>
                    <td data-label="Menu"><?= $detail['nama_menu']; ?></td>
                    <td data-label="Harga">Rp <?= number_format($detail['subtotal'] / $detail['jumlah'], 0, ',', '.'); ?></td>
                    <td data-label="Jumlah"><?= $detail['jumlah']; ?></td>
                    <td data-label="Subtotal">Rp <?= number_format($detail['subtotal'], 0, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Total</strong></td>
                    <td data-label="Total"><strong>Rp <?= number_format($data['order']['total_harga'], 0, ',', '.'); ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="payment-card">
        <h3>Informasi Pembayaran</h3>
        <table class="info-table">
            <tr>
                <td><strong>Metode</strong></td>
                <td><?= strtoupper($data['payment']['metode']); ?></td>
            </tr>
            <tr>
                <td><strong>Status Pembayaran</strong></td>
                <td>
                    <span class="badge <?= $data['payment']['status_bayar'] == 'lunas' ? 'badge-success' : 'badge-danger'; ?>">
                        <?= ucfirst($data['payment']['status_bayar']); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td><strong>Status Pesanan</strong></td>
                <td>
                    <span class="badge <?= $data['order']['status_order'] == 'selesai' ? 'badge-success' : 'badge-warning'; ?>">
                        <?= ucfirst($data['order']['status_order']); ?>
                    </span>
                </td>
            </tr>
            <?php if($data['payment']['waktu_bayar']): ?>
            <tr>
                <td><strong>Waktu Bayar</strong></td>
                <td><?= date('d F Y, H:i', strtotime($data['payment']['waktu_bayar'])); ?></td>
            </tr>
            <?php endif; ?>
        </table>
    </div>

    <div class="order-status-card">
        <h3>Update Status</h3>
        <form action="<?= BASEURL; ?>/dashboard/order/updateStatusBothDetail" method="POST">
            <input type="hidden" name="id_order" value="<?= $data['order']['id_order']; ?>">
            <input type="hidden" name="id_payment" value="<?= $data['payment']['id_payment']; ?>">
            
            <div class="form-group">
                <label for="status_order" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Status Pesanan</label>
                <select name="status_order" id="status_order" class="status-select">
                    <option value="diproses" <?= $data['order']['status_order'] == 'diproses' ? 'selected' : ''; ?>>Diproses</option>
                    <option value="selesai" <?= $data['order']['status_order'] == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="status_bayar" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Status Pembayaran</label>
                <select name="status_bayar" id="status_bayar" class="status-select">
                    <option value="belum" <?= $data['payment']['status_bayar'] == 'belum' ? 'selected' : ''; ?>>Belum Lunas</option>
                    <option value="lunas" <?= $data['payment']['status_bayar'] == 'lunas' ? 'selected' : ''; ?>>Lunas</option>
                </select>
            </div>
            
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
