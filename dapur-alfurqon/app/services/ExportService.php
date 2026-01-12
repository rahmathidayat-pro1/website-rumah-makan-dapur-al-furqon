<?php

class ExportService {
    
    /**
     * Export laporan ke Excel (CSV format - kompatibel dengan Excel)
     */
    public function exportExcel($data, $filename = 'laporan')
    {
        // Set headers untuk download Excel
        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        header('Pragma: public');
        
        // BOM untuk UTF-8
        echo "\xEF\xBB\xBF";
        
        // Start HTML table (Excel bisa membaca HTML table)
        echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
        echo '<head><meta charset="UTF-8"></head>';
        echo '<body>';
        
        // Judul Laporan
        echo '<table border="1">';
        echo '<tr><td colspan="6" style="font-size:18px;font-weight:bold;text-align:center;background:#aa1942;color:white;">';
        echo htmlspecialchars($data['title']);
        echo '</td></tr>';
        echo '<tr><td colspan="6" style="text-align:center;background:#f5f5f5;">';
        echo htmlspecialchars($data['periode_text']);
        echo '</td></tr>';
        echo '<tr><td colspan="6"></td></tr>';
        
        // Summary
        echo '<tr style="background:#e8f5e9;">';
        echo '<td colspan="2"><strong>Total Pendapatan</strong></td>';
        echo '<td colspan="4">Rp ' . number_format($data['laporan']['total_pendapatan'] ?? 0, 0, ',', '.') . '</td>';
        echo '</tr>';
        echo '<tr style="background:#e3f2fd;">';
        echo '<td colspan="2"><strong>Total Pesanan</strong></td>';
        echo '<td colspan="4">' . ($data['laporan']['total_pesanan'] ?? 0) . '</td>';
        echo '</tr>';
        echo '<tr style="background:#fff3e0;">';
        echo '<td colspan="2"><strong>Rata-rata Pesanan</strong></td>';
        echo '<td colspan="4">Rp ' . number_format($data['laporan']['rata_rata_pesanan'] ?? 0, 0, ',', '.') . '</td>';
        echo '</tr>';
        echo '<tr style="background:#fce4ec;">';
        echo '<td colspan="2"><strong>Pesanan Selesai</strong></td>';
        echo '<td colspan="4">' . ($data['laporan']['pesanan_selesai'] ?? 0) . '</td>';
        echo '</tr>';
        echo '<tr><td colspan="6"></td></tr>';
        
        // Menu Terlaris
        if (!empty($data['menu_terlaris'])) {
            echo '<tr><td colspan="6" style="font-weight:bold;background:#aa1942;color:white;">Menu Terlaris</td></tr>';
            echo '<tr style="background:#f5f5f5;font-weight:bold;">';
            echo '<td colspan="2">Nama Menu</td><td colspan="2">Terjual</td><td colspan="2">Pendapatan</td>';
            echo '</tr>';
            foreach ($data['menu_terlaris'] as $menu) {
                echo '<tr>';
                echo '<td colspan="2">' . htmlspecialchars($menu['nama_menu']) . '</td>';
                echo '<td colspan="2">' . $menu['total_terjual'] . '</td>';
                echo '<td colspan="2">Rp ' . number_format($menu['total_pendapatan'], 0, ',', '.') . '</td>';
                echo '</tr>';
            }
            echo '<tr><td colspan="6"></td></tr>';
        }
        
        // Metode Pembayaran
        if (!empty($data['metode_bayar'])) {
            echo '<tr><td colspan="6" style="font-weight:bold;background:#aa1942;color:white;">Metode Pembayaran</td></tr>';
            echo '<tr style="background:#f5f5f5;font-weight:bold;">';
            echo '<td colspan="2">Metode</td><td colspan="2">Jumlah Transaksi</td><td colspan="2">Total Nilai</td>';
            echo '</tr>';
            foreach ($data['metode_bayar'] as $metode) {
                echo '<tr>';
                echo '<td colspan="2">' . strtoupper(htmlspecialchars($metode['metode'])) . '</td>';
                echo '<td colspan="2">' . $metode['jumlah_transaksi'] . '</td>';
                echo '<td colspan="2">Rp ' . number_format($metode['total_nilai'], 0, ',', '.') . '</td>';
                echo '</tr>';
            }
            echo '<tr><td colspan="6"></td></tr>';
        }
        
        // Detail Transaksi
        if (!empty($data['detail'])) {
            echo '<tr><td colspan="6" style="font-weight:bold;background:#aa1942;color:white;">Detail Transaksi</td></tr>';
            
            if ($data['periode'] == 'harian') {
                echo '<tr style="background:#f5f5f5;font-weight:bold;">';
                echo '<td>No. Pesanan</td><td>Pelanggan</td><td>Jam</td><td>Total</td><td>Metode</td><td>Status</td>';
                echo '</tr>';
                foreach ($data['detail'] as $item) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($item['nomor_pesanan']) . '</td>';
                    echo '<td>' . htmlspecialchars($item['nama_pelanggan']) . '</td>';
                    echo '<td>' . date('H:i', strtotime($item['jam_order'])) . '</td>';
                    echo '<td>Rp ' . number_format($item['total_harga'], 0, ',', '.') . '</td>';
                    echo '<td>' . strtoupper($item['metode_bayar']) . '</td>';
                    echo '<td>' . ucfirst($item['status_order']) . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr style="background:#f5f5f5;font-weight:bold;">';
                echo '<td colspan="2">Tanggal</td><td>Total Pesanan</td><td>Pesanan Selesai</td><td colspan="2">Total Pendapatan</td>';
                echo '</tr>';
                foreach ($data['detail'] as $item) {
                    echo '<tr>';
                    echo '<td colspan="2">' . date('d M Y', strtotime($item['tanggal'])) . '</td>';
                    echo '<td>' . $item['total_pesanan'] . '</td>';
                    echo '<td>' . $item['pesanan_selesai'] . '</td>';
                    echo '<td colspan="2">Rp ' . number_format($item['total_pendapatan'], 0, ',', '.') . '</td>';
                    echo '</tr>';
                }
            }
        }
        
        echo '</table>';
        echo '<br><p style="font-size:10px;color:#666;">Diekspor pada: ' . date('d/m/Y H:i:s') . '</p>';
        echo '</body></html>';
        
        exit;
    }
    
    /**
     * Export laporan ke PDF (HTML to PDF)
     */
    public function exportPDF($data, $filename = 'laporan')
    {
        // Set headers untuk download PDF
        header('Content-Type: text/html; charset=utf-8');
        
        // Generate HTML untuk PDF
        $html = $this->generatePDFHTML($data);
        
        // Output HTML dengan JavaScript untuk print/save as PDF
        echo $html;
        exit;
    }
    
    private function generatePDFHTML($data)
    {
        $html = '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($data['title']) . '</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            background: #fff;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #aa1942;
        }
        .header h1 {
            color: #aa1942;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header .subtitle {
            color: #666;
            font-size: 14px;
        }
        .header .periode {
            background: #f5f5f5;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
            font-weight: bold;
        }
        .summary {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
        }
        .summary-card {
            flex: 1;
            min-width: 150px;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }
        .summary-card.primary { background: linear-gradient(135deg, #aa1942, #881535); color: white; }
        .summary-card.success { background: linear-gradient(135deg, #059669, #047857); color: white; }
        .summary-card.secondary { background: linear-gradient(135deg, #1A1A2E, #0f0f1a); color: white; }
        .summary-card.warning { background: linear-gradient(135deg, #D97706, #b45309); color: white; }
        .summary-card .label { font-size: 11px; opacity: 0.9; margin-bottom: 5px; }
        .summary-card .value { font-size: 18px; font-weight: bold; }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            background: #aa1942;
            color: white;
            padding: 10px 15px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #f5f5f5;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background: #fafafa;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-primary { color: #aa1942; }
        .text-success { color: #059669; }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-success { background: #d1fae5; color: #059669; }
        .badge-warning { background: #fef3c7; color: #D97706; }
        .badge-info { background: #e0e7ff; color: #4f46e5; }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        .no-print {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-left: 10px;
        }
        .btn-primary { background: #aa1942; color: white; }
        .btn-secondary { background: #666; color: white; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
            .summary-card { break-inside: avoid; }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button class="btn btn-primary" onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
        <button class="btn btn-secondary" onclick="window.close()">✕ Tutup</button>
    </div>

    <div class="header">
        <h1>DAPUR AL-FURQON</h1>
        <div class="subtitle">' . htmlspecialchars($data['title']) . '</div>
        <div class="periode">' . htmlspecialchars($data['periode_text']) . '</div>
    </div>

    <div class="summary">
        <div class="summary-card primary">
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp ' . number_format($data['laporan']['total_pendapatan'] ?? 0, 0, ',', '.') . '</div>
        </div>
        <div class="summary-card success">
            <div class="label">Total Pesanan</div>
            <div class="value">' . ($data['laporan']['total_pesanan'] ?? 0) . '</div>
        </div>
        <div class="summary-card secondary">
            <div class="label">Rata-rata Pesanan</div>
            <div class="value">Rp ' . number_format($data['laporan']['rata_rata_pesanan'] ?? 0, 0, ',', '.') . '</div>
        </div>
        <div class="summary-card warning">
            <div class="label">Pesanan Selesai</div>
            <div class="value">' . ($data['laporan']['pesanan_selesai'] ?? 0) . '</div>
        </div>
    </div>';

        // Menu Terlaris
        if (!empty($data['menu_terlaris'])) {
            $html .= '
    <div class="section">
        <div class="section-title">📊 Menu Terlaris</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th class="text-center">Terjual</th>
                    <th class="text-right">Pendapatan</th>
                </tr>
            </thead>
            <tbody>';
            $no = 1;
            foreach ($data['menu_terlaris'] as $menu) {
                $html .= '
                <tr>
                    <td>' . $no++ . '</td>
                    <td>' . htmlspecialchars($menu['nama_menu']) . '</td>
                    <td class="text-center"><strong>' . $menu['total_terjual'] . '</strong></td>
                    <td class="text-right text-primary">Rp ' . number_format($menu['total_pendapatan'], 0, ',', '.') . '</td>
                </tr>';
            }
            $html .= '
            </tbody>
        </table>
    </div>';
        }

        // Metode Pembayaran
        if (!empty($data['metode_bayar'])) {
            $html .= '
    <div class="section">
        <div class="section-title">💳 Metode Pembayaran</div>
        <table>
            <thead>
                <tr>
                    <th>Metode</th>
                    <th class="text-center">Jumlah Transaksi</th>
                    <th class="text-right">Total Nilai</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($data['metode_bayar'] as $metode) {
                $html .= '
                <tr>
                    <td><span class="badge badge-info">' . strtoupper(htmlspecialchars($metode['metode'])) . '</span></td>
                    <td class="text-center">' . $metode['jumlah_transaksi'] . '</td>
                    <td class="text-right text-primary">Rp ' . number_format($metode['total_nilai'], 0, ',', '.') . '</td>
                </tr>';
            }
            $html .= '
            </tbody>
        </table>
    </div>';
        }

        // Detail Transaksi
        if (!empty($data['detail'])) {
            $html .= '
    <div class="section">
        <div class="section-title">📋 Detail Transaksi</div>
        <table>
            <thead>
                <tr>';
            
            if ($data['periode'] == 'harian') {
                $html .= '
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th class="text-center">Jam</th>
                    <th class="text-right">Total</th>
                    <th class="text-center">Metode</th>
                    <th class="text-center">Status</th>';
            } else {
                $html .= '
                    <th>Tanggal</th>
                    <th class="text-center">Total Pesanan</th>
                    <th class="text-center">Pesanan Selesai</th>
                    <th class="text-right">Total Pendapatan</th>';
            }
            
            $html .= '
                </tr>
            </thead>
            <tbody>';
            
            foreach ($data['detail'] as $item) {
                if ($data['periode'] == 'harian') {
                    $statusClass = $item['status_order'] == 'selesai' ? 'success' : 'warning';
                    $html .= '
                <tr>
                    <td><strong class="text-primary">' . htmlspecialchars($item['nomor_pesanan']) . '</strong></td>
                    <td>' . htmlspecialchars($item['nama_pelanggan']) . '</td>
                    <td class="text-center">' . date('H:i', strtotime($item['jam_order'])) . '</td>
                    <td class="text-right">Rp ' . number_format($item['total_harga'], 0, ',', '.') . '</td>
                    <td class="text-center"><span class="badge badge-info">' . strtoupper($item['metode_bayar']) . '</span></td>
                    <td class="text-center"><span class="badge badge-' . $statusClass . '">' . ucfirst($item['status_order']) . '</span></td>
                </tr>';
                } else {
                    $html .= '
                <tr>
                    <td>' . date('d M Y', strtotime($item['tanggal'])) . '</td>
                    <td class="text-center"><strong>' . $item['total_pesanan'] . '</strong></td>
                    <td class="text-center">' . $item['pesanan_selesai'] . '</td>
                    <td class="text-right text-primary">Rp ' . number_format($item['total_pendapatan'], 0, ',', '.') . '</td>
                </tr>';
                }
            }
            
            $html .= '
            </tbody>
        </table>
    </div>';
        }

        $html .= '
    <div class="footer">
        <p>Laporan ini digenerate secara otomatis oleh sistem Dapur Al-Furqon</p>
        <p>Diekspor pada: ' . date('d/m/Y H:i:s') . '</p>
    </div>
</body>
</html>';

        return $html;
    }
}
