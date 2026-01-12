<?php require_once 'app/views/templates/header.php'; ?>

<div class="page-header">
    <h1>Daftar Pesanan</h1>
</div>

<!-- Desktop Table -->
<div class="table-container desktop-table">
    <table class="data-table">
        <thead>
            <tr>
                <th>No. Pesanan</th>
                <th>Nama Pelanggan</th>
                <th>No. Telepon</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status</th>
                <th>Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['orders'] as $order) : ?>
            <tr>
                <td>
                    <strong style="color: var(--primary);"><?= isset($order['nomor_pesanan']) ? $order['nomor_pesanan'] : '#' . str_pad($order['id_order'], 5, '0', STR_PAD_LEFT); ?></strong>
                </td>
                <td><?= htmlspecialchars($order['nama_pelanggan']); ?></td>
                <td><?= htmlspecialchars($order['no_telepon']); ?></td>
                <td style="font-size: 0.9rem;">
                    <?= date('d/m/Y', strtotime($order['tanggal_order'])); ?>
                    <br>
                    <small style="color: var(--text-muted);"><?= date('H:i', strtotime($order['tanggal_order'])); ?></small>
                </td>
                <td style="font-weight: 600; color: var(--primary);">
                    Rp <?= number_format($order['total_harga'], 0, ',', '.'); ?>
                </td>
                <td>
                    <span class="badge <?= $order['status_order'] == 'selesai' ? 'badge-success' : 'badge-warning'; ?>">
                        <?= ucfirst($order['status_order']); ?>
                    </span>
                </td>
                <td>
                    <span class="badge <?= isset($order['status_bayar']) && $order['status_bayar'] == 'lunas' ? 'badge-success' : 'badge-danger'; ?>">
                        <?= isset($order['status_bayar']) ? ucfirst($order['status_bayar']) : 'Belum'; ?>
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <button type="button" class="btn-sm btn-warning" onclick="openUpdateModal(<?= $order['id_order']; ?>, '<?= $order['status_order']; ?>', '<?= isset($order['status_bayar']) ? $order['status_bayar'] : 'belum'; ?>', '<?= isset($order['id_payment']) ? $order['id_payment'] : ''; ?>')">
                            Update
                        </button>
                        <a href="<?= BASEURL; ?>/dashboard/order/detail/<?= $order['id_order']; ?>" class="btn-sm btn-primary">Detail</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Mobile Cards -->
<div class="mobile-cards">
    <?php foreach($data['orders'] as $order) : ?>
    <div class="order-card">
        <div class="order-card-header">
            <span class="order-number"><?= isset($order['nomor_pesanan']) ? $order['nomor_pesanan'] : '#' . str_pad($order['id_order'], 5, '0', STR_PAD_LEFT); ?></span>
            <span class="order-date"><?= date('d/m/Y H:i', strtotime($order['tanggal_order'])); ?></span>
        </div>
        <div class="order-card-body">
            <div class="order-info-row">
                <span class="order-label">Pelanggan</span>
                <span class="order-value"><?= htmlspecialchars($order['nama_pelanggan']); ?></span>
            </div>
            <div class="order-info-row">
                <span class="order-label">Telepon</span>
                <span class="order-value"><?= htmlspecialchars($order['no_telepon']); ?></span>
            </div>
            <div class="order-info-row">
                <span class="order-label">Total</span>
                <span class="order-value order-total">Rp <?= number_format($order['total_harga'], 0, ',', '.'); ?></span>
            </div>
            <div class="order-info-row">
                <span class="order-label">Status</span>
                <div class="order-badges">
                    <span class="badge <?= $order['status_order'] == 'selesai' ? 'badge-success' : 'badge-warning'; ?>">
                        <?= ucfirst($order['status_order']); ?>
                    </span>
                    <span class="badge <?= isset($order['status_bayar']) && $order['status_bayar'] == 'lunas' ? 'badge-success' : 'badge-danger'; ?>">
                        <?= isset($order['status_bayar']) ? ucfirst($order['status_bayar']) : 'Belum'; ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="order-card-footer">
            <button type="button" class="btn-sm btn-warning" onclick="openUpdateModal(<?= $order['id_order']; ?>, '<?= $order['status_order']; ?>', '<?= isset($order['status_bayar']) ? $order['status_bayar'] : 'belum'; ?>', '<?= isset($order['id_payment']) ? $order['id_payment'] : ''; ?>')">
                Update Status
            </button>
            <a href="<?= BASEURL; ?>/dashboard/order/detail/<?= $order['id_order']; ?>" class="btn-sm btn-primary">Lihat Detail</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Modal Update Status -->
<div id="updateModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Update Status Pesanan</h3>
            <button type="button" class="modal-close" onclick="closeUpdateModal()">&times;</button>
        </div>
        <form action="<?= BASEURL; ?>/dashboard/order/updateStatusBoth" method="POST">
            <input type="hidden" name="id_order" id="modal_id_order">
            <input type="hidden" name="id_payment" id="modal_id_payment">
            
            <div class="modal-body">
                <div class="form-group">
                    <label for="modal_status_order">Status Pesanan</label>
                    <select name="status_order" id="modal_status_order" class="form-control">
                        <option value="diproses">Diproses</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="modal_status_bayar">Status Pembayaran</label>
                    <select name="status_bayar" id="modal_status_bayar" class="form-control">
                        <option value="belum">Belum Lunas</option>
                        <option value="lunas">Lunas</option>
                    </select>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeUpdateModal()">Batal</button>
                <button type="submit" class="btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Mobile Cards - Hidden on Desktop */
.mobile-cards {
    display: none;
}

.order-card {
    background: white;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
    margin-bottom: 12px;
    overflow: hidden;
}

.order-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    background: var(--bg-secondary);
    border-bottom: 1px solid var(--border-light);
}

.order-number {
    font-weight: 700;
    color: var(--primary);
    font-size: 0.95rem;
}

.order-date {
    font-size: 0.8rem;
    color: var(--text-muted);
}

.order-card-body {
    padding: 12px 16px;
}

.order-info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid var(--border-light);
}

.order-info-row:last-child {
    border-bottom: none;
}

.order-label {
    font-size: 0.85rem;
    color: var(--text-muted);
}

.order-value {
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--text-primary);
    text-align: right;
}

.order-total {
    font-weight: 700;
    color: var(--primary);
    font-size: 1rem;
}

.order-badges {
    display: flex;
    gap: 6px;
}

.order-badges .badge {
    font-size: 0.7rem;
    padding: 4px 8px;
}

.order-card-footer {
    display: flex;
    gap: 8px;
    padding: 12px 16px;
    background: var(--bg-secondary);
    border-top: 1px solid var(--border-light);
}

.order-card-footer .btn-sm {
    flex: 1;
    text-align: center;
    padding: 10px 12px;
    font-size: 0.85rem;
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 16px;
}

.modal-content {
    background: white;
    border-radius: var(--radius-lg);
    width: 100%;
    max-width: 450px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: var(--shadow-lg);
    animation: modalSlideIn 0.3s ease;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--border);
    position: sticky;
    top: 0;
    background: white;
    z-index: 1;
}

.modal-header h3 {
    margin: 0;
    font-size: 1.1rem;
    color: var(--text-primary);
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: var(--text-muted);
    line-height: 1;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-sm);
}

.modal-close:hover {
    color: var(--danger);
    background: var(--danger-light);
}

.modal-body {
    padding: 1.5rem;
}

.modal-body .form-group {
    margin-bottom: 1.25rem;
}

.modal-body .form-group:last-child {
    margin-bottom: 0;
}

.modal-body label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.9rem;
}

.modal-body .form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 1rem;
    background: white;
}

.modal-body .form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(170, 25, 66, 0.1);
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--border);
    background: var(--bg-secondary);
    border-radius: 0 0 var(--radius-lg) var(--radius-lg);
    position: sticky;
    bottom: 0;
}

.btn-sm.btn-warning {
    background: var(--warning);
    color: #000;
    padding: 0.4rem 0.75rem;
    border-radius: var(--radius-sm);
    font-size: 0.85rem;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-weight: 500;
}

.btn-sm.btn-warning:hover {
    background: #e0a800;
}

.badge-danger {
    background: var(--danger-light);
    color: var(--danger);
}

/* Responsive - Show cards on mobile, hide table */
@media (max-width: 768px) {
    .desktop-table {
        display: none;
    }
    
    .mobile-cards {
        display: block;
    }
    
    .modal-content {
        margin: 0;
        max-width: 100%;
        border-radius: var(--radius-md);
    }
    
    .modal-header {
        padding: 1rem;
    }
    
    .modal-header h3 {
        font-size: 1rem;
    }
    
    .modal-body {
        padding: 1rem;
    }
    
    .modal-footer {
        padding: 1rem;
        flex-direction: column;
    }
    
    .modal-footer .btn-secondary,
    .modal-footer .btn-primary {
        width: 100%;
        padding: 12px;
        text-align: center;
    }
}
</style>

<script>
function openUpdateModal(idOrder, statusOrder, statusBayar, idPayment) {
    document.getElementById('modal_id_order').value = idOrder;
    document.getElementById('modal_id_payment').value = idPayment;
    document.getElementById('modal_status_order').value = statusOrder;
    document.getElementById('modal_status_bayar').value = statusBayar;
    document.getElementById('updateModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeUpdateModal() {
    document.getElementById('updateModal').style.display = 'none';
    document.body.style.overflow = '';
}

// Close modal when clicking outside
document.getElementById('updateModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeUpdateModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeUpdateModal();
    }
});
</script>

<?php require_once 'app/views/templates/footer.php'; ?>
