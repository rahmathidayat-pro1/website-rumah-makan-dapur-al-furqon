<?php require_once 'app/views/templates/header.php'; ?>

<div class="page-header">
    <h1><?= $data['title']; ?></h1>
    <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
        <a href="<?= BASEURL; ?>/dashboard/laporan/harian" class="btn-<?= $data['periode'] == 'harian' ? 'primary' : 'secondary'; ?> btn-sm">Harian</a>
        <a href="<?= BASEURL; ?>/dashboard/laporan/mingguan" class="btn-<?= $data['periode'] == 'mingguan' ? 'primary' : 'secondary'; ?> btn-sm">Mingguan</a>
        <a href="<?= BASEURL; ?>/dashboard/laporan/bulanan" class="btn-<?= $data['periode'] == 'bulanan' ? 'primary' : 'secondary'; ?> btn-sm">Bulanan</a>
        <span style="border-left: 1px solid var(--border); height: 24px; margin: 0 0.5rem;"></span>
        <?php
        // Build export URL dengan parameter yang sama
        $exportParams = [];
        if ($data['periode'] == 'harian') {
            $exportParams['tanggal'] = $data['tanggal'];
        } elseif ($data['periode'] == 'mingguan') {
            $exportParams['minggu'] = $data['minggu'];
            $exportParams['tahun'] = $data['tahun'];
        } elseif ($data['periode'] == 'bulanan') {
            $exportParams['bulan'] = $data['bulan'];
            $exportParams['tahun'] = $data['tahun'];
        }
        $queryString = http_build_query($exportParams);
        ?>
        <a href="<?= BASEURL; ?>/dashboard/export_laporan/excel/<?= $data['periode']; ?>?<?= $queryString; ?>" class="btn-export btn-sm" title="Export ke Excel">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
            Excel
        </a>
        <a href="<?= BASEURL; ?>/dashboard/export_laporan/pdf/<?= $data['periode']; ?>?<?= $queryString; ?>" class="btn-export btn-sm" target="_blank" title="Export ke PDF">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
            PDF
        </a>
    </div>
</div>

<?php if (isset($data['error'])): ?>
<div style="background: #fee2e2; border: 1px solid var(--danger); color: var(--danger); padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
    <strong>Error:</strong> <?= htmlspecialchars($data['error']); ?>
</div>
<?php elseif (!isset($data['laporan']) || empty($data['laporan'])): ?>
<div style="background: #fee2e2; border: 1px solid var(--danger); color: var(--danger); padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
    <strong>Peringatan:</strong> Data laporan tidak dapat dimuat. Silakan cek:
    <ul style="margin: 0.5rem 0 0 1.5rem;">
        <li>Koneksi database</li>
        <li>Struktur tabel orders dan payment</li>
        <li>Data pesanan untuk periode yang dipilih</li>
    </ul>
</div>
<?php endif; ?>

<!-- Filter Periode -->
<div class="card" style="margin-bottom: 1.5rem; padding: 1.5rem;">
    <form method="GET" action="<?= BASEURL; ?>/dashboard/laporan/<?= $data['periode']; ?>" style="display: flex; gap: 1rem; align-items: end; flex-wrap: wrap;">
        <?php if($data['periode'] == 'harian'): ?>
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem; color: var(--text-primary);">Tanggal</label>
                <input type="date" name="tanggal" value="<?= $data['tanggal']; ?>" 
                       style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); background: var(--card-bg);">
            </div>
        <?php elseif($data['periode'] == 'mingguan'): ?>
            <div style="flex: 1; min-width: 150px;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem; color: var(--text-primary);">Minggu Ke</label>
                <input type="number" name="minggu" value="<?= $data['minggu']; ?>" min="1" max="53"
                       style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); background: var(--card-bg);">
            </div>
            <div style="flex: 1; min-width: 150px;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem; color: var(--text-primary);">Tahun</label>
                <input type="number" name="tahun" value="<?= $data['tahun']; ?>" min="2020" max="2099"
                       style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); background: var(--card-bg);">
            </div>
        <?php elseif($data['periode'] == 'bulanan'): ?>
            <div style="flex: 1; min-width: 150px;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem; color: var(--text-primary);">Bulan</label>
                <select name="bulan" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); background: var(--card-bg);">
                    <?php for($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT); ?>" <?= ($data['bulan'] ?? date('m')) == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : ''; ?>>
                            <?= $this->model('Laporan_model')->getNamaBulan($i); ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div style="flex: 1; min-width: 150px;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem; color: var(--text-primary);">Tahun</label>
                <input type="number" name="tahun" value="<?= $data['tahun']; ?>" min="2020" max="2099"
                       style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); background: var(--card-bg);">
            </div>
        <?php endif; ?>
        <button type="submit" class="btn-primary btn-sm">Tampilkan</button>
    </form>
</div>

<!-- Periode Info -->
<div style="background: var(--bg-secondary); padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1.5rem; text-align: center; border: 1px solid var(--border-light);">
    <strong style="color: var(--text-primary); font-size: 1.1rem;">
        <?php if($data['periode'] == 'harian'): ?>
            <?= date('d F Y', strtotime($data['tanggal'])); ?>
        <?php elseif($data['periode'] == 'mingguan'): ?>
            Minggu ke-<?= $data['minggu']; ?> Tahun <?= $data['tahun']; ?> (<?= $data['periode_text'] ?? ''; ?>)
        <?php elseif($data['periode'] == 'bulanan'): ?>
            <?= $data['nama_bulan'] ?? ''; ?> <?= $data['tahun']; ?>
        <?php endif; ?>
    </strong>
</div>

<!-- Summary Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card" style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; padding: 1.5rem;">
        <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 0.5rem;">Total Pendapatan</div>
        <div style="font-size: 1.75rem; font-weight: 700;">Rp <?= number_format($data['laporan']['total_pendapatan'] ?? 0, 0, ',', '.'); ?></div>
    </div>
    <div class="card" style="background: linear-gradient(135deg, var(--success), #047857); color: white; padding: 1.5rem;">
        <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 0.5rem;">Total Pesanan</div>
        <div style="font-size: 1.75rem; font-weight: 700;"><?= $data['laporan']['total_pesanan'] ?? 0; ?></div>
    </div>
    <div class="card" style="background: linear-gradient(135deg, var(--secondary), #0f0f1a); color: white; padding: 1.5rem;">
        <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 0.5rem;">Rata-rata Pesanan</div>
        <div style="font-size: 1.75rem; font-weight: 700;">Rp <?= number_format($data['laporan']['rata_rata_pesanan'] ?? 0, 0, ',', '.'); ?></div>
    </div>
    <div class="card" style="background: linear-gradient(135deg, var(--warning), #b45309); color: white; padding: 1.5rem;">
        <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 0.5rem;">Status Pesanan</div>
        <div style="font-size: 1.1rem; font-weight: 600;">
            Selesai: <?= $data['laporan']['pesanan_selesai'] ?? 0; ?> | Proses: <?= $data['laporan']['pesanan_diproses'] ?? 0; ?>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Menu Terlaris -->
    <div class="card">
        <h3 style="margin-bottom: 1rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-light);">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                <path d="M3 3h18v18H3zM21 9H3M21 15H3M12 3v18"/>
            </svg>
            Menu Terlaris
        </h3>
        <?php if(!empty($data['menu_terlaris'])): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Terjual</th>
                        <th>Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['menu_terlaris'] as $menu): ?>
                    <tr>
                        <td><?= htmlspecialchars($menu['nama_menu']); ?></td>
                        <td><strong><?= $menu['total_terjual']; ?></strong></td>
                        <td style="color: var(--primary); font-weight: 600;">Rp <?= number_format($menu['total_pendapatan'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; color: var(--text-muted); padding: 2rem;">Belum ada data</p>
        <?php endif; ?>
    </div>

    <!-- Metode Pembayaran -->
    <div class="card">
        <h3 style="margin-bottom: 1rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-light);">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                <line x1="1" y1="10" x2="23" y2="10"></line>
            </svg>
            Metode Pembayaran
        </h3>
        <?php if(!empty($data['metode_bayar'])): ?>
            <div style="padding: 1rem 0;">
                <?php foreach($data['metode_bayar'] as $metode): ?>
                    <div style="margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="font-weight: 600; text-transform: uppercase;"><?= htmlspecialchars($metode['metode']); ?></span>
                            <span style="color: var(--text-muted);"><?= $metode['jumlah_transaksi']; ?> transaksi</span>
                        </div>
                        <div style="background: var(--bg-secondary); height: 8px; border-radius: var(--radius-full); overflow: hidden;">
                            <?php 
                            $total_transaksi = array_sum(array_column($data['metode_bayar'], 'jumlah_transaksi'));
                            $percentage = $total_transaksi > 0 ? ($metode['jumlah_transaksi'] / $total_transaksi) * 100 : 0;
                            ?>
                            <div style="background: var(--primary); height: 100%; width: <?= $percentage; ?>%; transition: var(--transition-fast);"></div>
                        </div>
                        <div style="margin-top: 0.25rem; font-size: 0.9rem; color: var(--primary); font-weight: 600;">
                            Rp <?= number_format($metode['total_nilai'], 0, ',', '.'); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="text-align: center; color: var(--text-muted); padding: 2rem;">Belum ada data</p>
        <?php endif; ?>
    </div>
</div>

<!-- Detail Transaksi -->
<div class="card">
    <h3 style="margin-bottom: 1rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-light);">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
        </svg>
        Detail Transaksi
    </h3>
    <?php if(!empty($data['detail'])): ?>
        <!-- Desktop Table -->
        <div class="table-container desktop-transaksi">
            <table class="data-table">
                <thead>
                    <tr>
                        <?php if($data['periode'] == 'harian'): ?>
                            <th>No. Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Jam</th>
                            <th>Total</th>
                            <th>Metode</th>
                            <th>Status</th>
                        <?php else: ?>
                            <th>Tanggal</th>
                            <th>Total Pesanan</th>
                            <th>Pesanan Selesai</th>
                            <th>Total Pendapatan</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['detail'] as $item): ?>
                    <tr>
                        <?php if($data['periode'] == 'harian'): ?>
                            <td><strong style="color: var(--primary);"><?= $item['nomor_pesanan']; ?></strong></td>
                            <td><?= htmlspecialchars($item['nama_pelanggan']); ?></td>
                            <td><?= date('H:i', strtotime($item['jam_order'])); ?></td>
                            <td style="font-weight: 600;">Rp <?= number_format($item['total_harga'], 0, ',', '.'); ?></td>
                            <td><span class="badge badge-info"><?= strtoupper($item['metode_bayar']); ?></span></td>
                            <td>
                                <span class="badge badge-<?= $item['status_order'] == 'selesai' ? 'success' : 'warning'; ?>">
                                    <?= ucfirst($item['status_order']); ?>
                                </span>
                            </td>
                        <?php else: ?>
                            <td><?= date('d M Y', strtotime($item['tanggal'])); ?></td>
                            <td><strong><?= $item['total_pesanan']; ?></strong></td>
                            <td><?= $item['pesanan_selesai']; ?></td>
                            <td style="color: var(--primary); font-weight: 600;">Rp <?= number_format($item['total_pendapatan'], 0, ',', '.'); ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Mobile Cards -->
        <div class="mobile-transaksi">
            <?php foreach($data['detail'] as $item): ?>
            <div class="transaksi-card">
                <?php if($data['periode'] == 'harian'): ?>
                    <div class="transaksi-card-header">
                        <span class="transaksi-number"><?= $item['nomor_pesanan']; ?></span>
                        <span style="font-size: 0.8rem; color: var(--text-muted);"><?= date('H:i', strtotime($item['jam_order'])); ?></span>
                    </div>
                    <div class="transaksi-card-body">
                        <div class="transaksi-info-row">
                            <span class="transaksi-label">Pelanggan</span>
                            <span class="transaksi-value"><?= htmlspecialchars($item['nama_pelanggan']); ?></span>
                        </div>
                        <div class="transaksi-info-row">
                            <span class="transaksi-label">Total</span>
                            <span class="transaksi-value transaksi-total">Rp <?= number_format($item['total_harga'], 0, ',', '.'); ?></span>
                        </div>
                        <div class="transaksi-info-row">
                            <span class="transaksi-label">Status</span>
                            <div style="display: flex; gap: 6px;">
                                <span class="badge badge-info"><?= strtoupper($item['metode_bayar']); ?></span>
                                <span class="badge badge-<?= $item['status_order'] == 'selesai' ? 'success' : 'warning'; ?>">
                                    <?= ucfirst($item['status_order']); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="transaksi-card-header">
                        <span class="transaksi-number"><?= date('d M Y', strtotime($item['tanggal'])); ?></span>
                    </div>
                    <div class="transaksi-card-body">
                        <div class="transaksi-info-row">
                            <span class="transaksi-label">Total Pesanan</span>
                            <span class="transaksi-value"><?= $item['total_pesanan']; ?></span>
                        </div>
                        <div class="transaksi-info-row">
                            <span class="transaksi-label">Selesai</span>
                            <span class="transaksi-value"><?= $item['pesanan_selesai']; ?></span>
                        </div>
                        <div class="transaksi-info-row">
                            <span class="transaksi-label">Pendapatan</span>
                            <span class="transaksi-value transaksi-total">Rp <?= number_format($item['total_pendapatan'], 0, ',', '.'); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p style="text-align: center; color: var(--text-muted); padding: 3rem;">Belum ada transaksi pada periode ini</p>
    <?php endif; ?>
</div>

<style>
:root {
    --primary: #aa1942;
    --primary-light: #cc2050;
    --primary-dark: #881535;
    --secondary: #1A1A2E;
    --accent: #E8D5B7;
    --bg-primary: #FDFAF5;
    --bg-secondary: #F5EFE6;
    --card-bg: #FFFFFF;
    --text-primary: #1A1A2E;
    --text-secondary: #5A5A6E;
    --text-muted: #8E8E9E;
    --border: #E8E4DD;
    --border-light: #F0EBE3;
    --success: #059669;
    --warning: #D97706;
    --danger: #DC2626;
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --radius-full: 9999px;
    --shadow-sm: 0 2px 8px rgba(26, 26, 46, 0.06);
    --shadow-md: 0 4px 16px rgba(26, 26, 46, 0.08);
    --transition-fast: 150ms ease;
}

.btn-primary {
    background: var(--primary);
    color: white;
    border: none;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
    transition: var(--transition-fast);
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
}

.btn-secondary {
    background: var(--text-secondary);
    color: white;
    border: none;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
    transition: var(--transition-fast);
}

.btn-secondary:hover {
    background: var(--secondary);
    transform: translateY(-1px);
}

.btn-export {
    background: #047857;
    color: white;
    border: none;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    cursor: pointer;
    transition: var(--transition-fast);
}

.btn-export:hover {
    background: #065f46;
    transform: translateY(-1px);
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    border-radius: var(--radius-md);
    font-weight: 600;
    transition: all var(--transition-fast);
}

.card {
    background: var(--card-bg);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
    padding: 1.5rem;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.data-table th,
.data-table td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid var(--border-light);
}

.data-table th {
    background: var(--bg-secondary);
    font-weight: 600;
    color: var(--text-primary);
}

.table-container {
    overflow-x: auto;
}

.badge {
    padding: 0.25rem 0.5rem;
    border-radius: var(--radius-md);
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.badge-success {
    background: #d1fae5;
    color: var(--success);
}

.badge-warning {
    background: #fef3c7;
    color: var(--warning);
}

.badge-info {
    background: var(--bg-secondary);
    color: var(--primary);
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-light);
    flex-wrap: wrap;
    gap: 1rem;
}

.page-header h1 {
    margin: 0;
    color: var(--text-primary);
}

/* Mobile Cards for Detail Transaksi */
.mobile-transaksi { display: none; }

.transaksi-card {
    background: white;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
    margin-bottom: 12px;
    overflow: hidden;
}

.transaksi-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px;
    background: var(--bg-secondary);
    border-bottom: 1px solid var(--border-light);
}

.transaksi-number {
    font-weight: 700;
    color: var(--primary);
    font-size: 0.95rem;
}

.transaksi-card-body { padding: 12px; }

.transaksi-info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 6px 0;
    border-bottom: 1px solid var(--border-light);
}

.transaksi-info-row:last-child { border-bottom: none; }

.transaksi-label {
    font-size: 0.8rem;
    color: var(--text-muted);
}

.transaksi-value {
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--text-primary);
}

.transaksi-total {
    font-weight: 700;
    color: var(--primary);
}

/* Responsive Styles */
@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .page-header > div {
        width: 100%;
        overflow-x: auto;
        white-space: nowrap;
        padding-bottom: 8px;
    }
    
    .page-header .btn-sm {
        padding: 0.4rem 0.75rem;
        font-size: 0.8rem;
    }
    
    /* Summary Cards */
    div[style*="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr))"] {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 0.75rem !important;
    }
    
    div[style*="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr))"] .card {
        padding: 1rem !important;
    }
    
    div[style*="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr))"] .card div[style*="font-size: 1.75rem"] {
        font-size: 1.25rem !important;
    }
    
    div[style*="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr))"] .card div[style*="font-size: 1.1rem"] {
        font-size: 0.85rem !important;
    }
    
    /* Charts Row - Stack on mobile */
    div[style*="grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
    
    .card {
        padding: 1rem;
    }
    
    .card h3 {
        font-size: 1rem;
    }
    
    /* Detail Transaksi - Show cards on mobile */
    .desktop-transaksi { display: none; }
    .mobile-transaksi { display: block; }
    
    /* Filter form */
    .card form {
        flex-direction: column !important;
    }
    
    .card form > div {
        min-width: 100% !important;
    }
}
</style>

<?php require_once 'app/views/templates/footer.php'; ?>