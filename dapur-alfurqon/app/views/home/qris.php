<?php require_once 'app/views/templates/public_header.php'; ?>

<div class="container">
    <section class="qris-section">
        <?php if($data['expired']): ?>
            <!-- Expired State -->
            <div class="qris-expired">
                <div class="expired-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
                <h1>Pembayaran QRIS Expired</h1>
                <p>Waktu pembayaran QRIS telah habis. Silakan lakukan pemesanan ulang atau bayar tunai di tempat.</p>
                
                <div class="order-info">
                    <h3>Informasi Pesanan</h3>
                    <div class="info-row">
                        <span>Nomor Pesanan:</span>
                        <strong><?= $data['order']['nomor_pesanan']; ?></strong>
                    </div>
                    <div class="info-row">
                        <span>Total Pembayaran:</span>
                        <strong>Rp <?= number_format($data['order']['total_harga'], 0, ',', '.'); ?></strong>
                    </div>
                </div>
                
                <div class="action-buttons">
                    <a href="<?= BASEURL; ?>" class="btn-primary">Pesan Lagi</a>
                    <a href="tel:<?= $data['contact_phone'] ?? '081234567890'; ?>" class="btn-secondary">Hubungi Kami</a>
                </div>
            </div>
        <?php else: ?>
            <!-- Active QRIS Payment -->
            <div class="qris-payment">
                <div class="payment-header">
                    <div class="qris-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <rect x="7" y="7" width="3" height="3"></rect>
                            <rect x="14" y="7" width="3" height="3"></rect>
                            <rect x="7" y="14" width="3" height="3"></rect>
                            <rect x="14" y="14" width="3" height="3"></rect>
                        </svg>
                    </div>
                    <h1>Pembayaran QRIS</h1>
                    <p>Scan QR Code di bawah ini dengan aplikasi pembayaran Anda</p>
                </div>

                <div class="qris-container">
                    <div class="qr-section">
                        <div class="qr-code">
                            <img src="<?= $data['qr_image']; ?>" alt="QR Code Pembayaran" id="qrImage" onerror="handleQRError(this)">
                            <div class="qr-overlay" id="qrOverlay" style="display: none;">
                                <div class="loading-spinner"></div>
                                <p>Memproses pembayaran...</p>
                            </div>
                            <div class="qr-error" id="qrError" style="display: none;">
                                <p style="color: var(--danger); margin-bottom: 1rem;">QR Code gagal dimuat</p>
                                <button onclick="retryQRCode()" class="btn-primary btn-sm">Coba Lagi</button>
                                <p style="margin-top: 1rem; font-size: 0.9rem; color: var(--text-muted);">
                                    Atau gunakan kode pembayaran manual di bawah
                                </p>
                            </div>
                        </div>
                        
                        <!-- Manual QRIS Code (fallback) -->
                        <div class="manual-qris" id="manualQris" style="display: none;">
                            <h4>Kode Pembayaran Manual</h4>
                            <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1rem;">
                                Jika QR Code tidak dapat dimuat, gunakan kode di bawah ini di aplikasi pembayaran Anda:
                            </p>
                            <div class="qris-code-text">
                                <textarea readonly onclick="this.select()" style="width: 100%; height: 80px; font-family: monospace; font-size: 0.8rem; padding: 0.5rem; border: 1px solid var(--border); border-radius: var(--radius-md); resize: none;"><?= $data['payment']['qris_string']; ?></textarea>
                                <button onclick="copyQRISCode()" class="btn-secondary btn-sm" style="margin-top: 0.5rem;">Salin Kode</button>
                            </div>
                            
                            <!-- Debug info (can be removed in production) -->
                            <details style="margin-top: 1rem; font-size: 0.8rem; color: var(--text-muted);">
                                <summary>Debug Info</summary>
                                <p><strong>QRIS String Info:</strong></p>
                                <ul style="margin: 0.5rem 0; padding-left: 1.5rem;">
                                    <li>Length: <?= strlen($data['payment']['qris_string']); ?> characters</li>
                                    <li>Starts with 000201: <?= (strpos($data['payment']['qris_string'], '000201') === 0) ? '✓ Yes' : '✗ No'; ?></li>
                                    <li>Contains QRIS ID: <?= (strpos($data['payment']['qris_string'], 'ID.CO.QRIS.WWW') !== false) ? '✓ Yes' : '✗ No'; ?></li>
                                    <li>Has CRC: <?= (preg_match('/6304[A-F0-9]{4}$/', $data['payment']['qris_string'])) ? '✓ Yes' : '✗ No'; ?></li>
                                </ul>
                                <p><strong>Timezone Info:</strong></p>
                                <ul style="margin: 0.5rem 0; padding-left: 1.5rem;">
                                    <li>Server Time: <?= date('Y-m-d H:i:s T'); ?></li>
                                    <li>Expired Time: <?= $data['payment']['qris_expired']; ?></li>
                                    <li>Remaining: <?= $data['remaining_time']; ?></li>
                                    <li>PHP Timezone: <?= date_default_timezone_get(); ?></li>
                                </ul>
                                <p><strong>QR Services:</strong></p>
                                <ul style="margin: 0.5rem 0; padding-left: 1.5rem;">
                                    <?php if(isset($data['qr_services'])): ?>
                                        <?php foreach($data['qr_services'] as $service => $url): ?>
                                            <li><strong><?= ucfirst($service); ?>:</strong> <a href="<?= $url; ?>" target="_blank" style="font-size: 0.7rem; word-break: break-all;"><?= $url; ?></a></li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                                <p style="margin-top: 1rem; padding: 0.5rem; background: #fff3cd; border-radius: 4px;">
                                    <strong>⚠️ Catatan:</strong> Jika project Pakasir masih dalam mode <strong>Sandbox</strong>, 
                                    QRIS tidak bisa dibayar dengan uang sungguhan. Hubungi Pakasir untuk mengaktifkan mode Production.
                                </p>
                            </details>
                        </div>
                    </div>
                    
                    <div class="payment-info">
                        <div class="info-card">
                            <h3>Detail Pembayaran</h3>
                            <div class="info-row">
                                <span>Nomor Pesanan:</span>
                                <strong><?= $data['order']['nomor_pesanan']; ?></strong>
                            </div>
                            <div class="info-row">
                                <span>Total Pesanan:</span>
                                <span>Rp <?= number_format($data['order']['total_harga'], 0, ',', '.'); ?></span>
                            </div>
                            <div class="info-row">
                                <span>Biaya Admin:</span>
                                <span>Rp <?= number_format($data['payment']['pakasir_fee'], 0, ',', '.'); ?></span>
                            </div>
                            <div class="info-row total-row">
                                <span>Total Pembayaran:</span>
                                <strong>Rp <?= number_format($data['payment']['pakasir_total'], 0, ',', '.'); ?></strong>
                            </div>
                        </div>
                        
                        <div class="timer-card">
                            <div class="timer-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12,6 12,12 16,14"></polyline>
                                </svg>
                            </div>
                            <div class="timer-text">
                                <span>Sisa Waktu:</span>
                                <strong id="countdown"><?= $data['remaining_time']; ?></strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="payment-instructions">
                    <h3>Cara Pembayaran:</h3>
                    <ol>
                        <li>Buka aplikasi pembayaran digital Anda (GoPay, OVO, DANA, ShopeePay, dll)</li>
                        <li>Pilih menu "Scan QR" atau "Bayar"</li>
                        <li>Arahkan kamera ke QR Code di atas</li>
                        <li>Konfirmasi pembayaran di aplikasi Anda</li>
                        <li>Tunggu konfirmasi pembayaran berhasil</li>
                    </ol>
                </div>

                <div class="payment-status" id="paymentStatus">
                    <div class="status-waiting">
                        <div class="pulse-dot"></div>
                        <span>Menunggu pembayaran...</span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
</div>

<style>
.qris-section {
    max-width: 600px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.qris-expired {
    text-align: center;
    padding: 2rem;
    background: var(--card-bg);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
}

.expired-icon {
    color: var(--danger);
    margin-bottom: 1rem;
}

.qris-payment {
    background: var(--card-bg);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    overflow: hidden;
}

.payment-header {
    text-align: center;
    padding: 2rem 1.5rem 1rem;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
}

.qris-icon {
    margin-bottom: 1rem;
}

.payment-header h1 {
    margin: 0 0 0.5rem;
    font-size: 1.5rem;
}

.payment-header p {
    margin: 0;
    opacity: 0.9;
}

.qris-container {
    padding: 2rem 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 2rem;
    align-items: center;
}

.qr-section {
    width: 100%;
    max-width: 400px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.payment-info {
    width: 100%;
    max-width: 500px;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.qr-code {
    position: relative;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    margin-bottom: 1rem;
}

.qr-code img {
    max-width: 320px;
    width: 100%;
    height: auto;
    border: 8px solid var(--bg-secondary);
    border-radius: var(--radius-md);
    display: block;
    margin: 0 auto;
    box-shadow: var(--shadow-md);
    background: white;
    padding: 12px;
    /* Pastikan gambar tidak blur */
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
}

.qr-overlay {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: calc(100% - 20px);
    height: calc(100% - 20px);
    background: rgba(255, 255, 255, 0.95);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-md);
    margin: 10px;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid var(--bg-secondary);
    border-top: 4px solid var(--primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-bottom: 1rem;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.info-card, .timer-card {
    background: var(--bg-secondary);
    padding: 1.5rem;
    border-radius: var(--radius-md);
    margin-bottom: 1rem;
}

.info-card h3 {
    margin: 0 0 1rem;
    color: var(--text-primary);
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
}

.info-row:last-child {
    margin-bottom: 0;
}

.total-row {
    border-top: 1px solid var(--border);
    padding-top: 0.75rem;
    margin-top: 0.75rem;
    font-size: 1.1rem;
}

.timer-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    border: 1px solid var(--warning);
}

.timer-icon {
    color: var(--warning);
}

.timer-text {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.payment-instructions {
    padding: 0 1.5rem 1.5rem;
}

.payment-instructions h3 {
    margin: 0 0 1rem;
    color: var(--text-primary);
}

.payment-instructions ol {
    margin: 0;
    padding-left: 1.5rem;
    color: var(--text-secondary);
}

.payment-instructions li {
    margin-bottom: 0.5rem;
}

.payment-status {
    padding: 1.5rem;
    background: var(--bg-secondary);
    text-align: center;
}

.qr-error {
    text-align: center;
    padding: 2rem;
    background: rgba(220, 38, 38, 0.1);
    border: 1px solid var(--danger);
    border-radius: var(--radius-md);
    margin-top: 1rem;
}

.manual-qris {
    background: var(--bg-secondary);
    padding: 1.5rem;
    border-radius: var(--radius-md);
    margin-top: 1rem;
    border: 1px solid var(--border);
    width: 100%;
    text-align: center;
}

.manual-qris h4 {
    margin: 0 0 1rem;
    color: var(--text-primary);
}

.qris-code-text {
    text-align: center;
    max-width: 100%;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    border-radius: var(--radius-md);
    border: none;
    cursor: pointer;
    transition: var(--transition-fast);
}

.status-waiting {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    color: var(--text-secondary);
}

.pulse-dot {
    width: 12px;
    height: 12px;
    background: var(--warning);
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.2); }
    100% { opacity: 1; transform: scale(1); }
}

.order-info {
    background: var(--bg-secondary);
    padding: 1.5rem;
    border-radius: var(--radius-md);
    margin: 2rem 0;
}

.order-info h3 {
    margin: 0 0 1rem;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
}

.btn-primary, .btn-secondary {
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius-md);
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition-fast);
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-dark);
}

.btn-secondary {
    background: var(--text-secondary);
    color: white;
}

.btn-secondary:hover {
    background: var(--secondary);
}

@media (max-width: 768px) {
    .qris-container {
        padding: 1.5rem 1rem;
    }
    
    .qr-section {
        max-width: 100%;
    }
    
    .payment-info {
        max-width: 100%;
    }
    
    .qr-code img {
        max-width: 280px;
        border: 6px solid var(--bg-secondary);
        padding: 10px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .manual-qris {
        padding: 1rem;
    }
    
    .qris-code-text textarea {
        font-size: 0.7rem;
        height: 60px;
    }
}
</style>

<script>
// QR Code error handling
function handleQRError(img) {
    console.log('QR Code failed to load:', img.src);
    document.getElementById('qrError').style.display = 'block';
    document.getElementById('manualQris').style.display = 'block';
    img.style.display = 'none';
}

function retryQRCode() {
    const img = document.getElementById('qrImage');
    const error = document.getElementById('qrError');
    
    error.style.display = 'none';
    img.style.display = 'block';
    
    // Try alternative QR services dengan parameter optimal untuk QRIS
    const qrString = '<?= $data['payment']['qris_string']; ?>';
    const encodedQrString = encodeURIComponent(qrString);
    
    // Services dengan ukuran lebih besar dan error correction yang tepat
    const services = [
        `https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=${encodedQrString}&ecc=M&margin=2&format=png`,
        `https://quickchart.io/qr?text=${encodedQrString}&size=400&ecLevel=M&margin=2&format=png`,
        `https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl=${encodedQrString}&chld=M|2`
    ];
    
    // Get current service index
    let currentIndex = parseInt(img.dataset.serviceIndex || '0');
    currentIndex = (currentIndex + 1) % services.length;
    
    // Add cache buster
    const cacheBuster = '&_t=' + Date.now();
    img.src = services[currentIndex] + cacheBuster;
    img.dataset.serviceIndex = currentIndex;
    
    const serviceNames = ['QR Server', 'QuickChart', 'Google Charts'];
    console.log('Trying QR service:', serviceNames[currentIndex], '-', services[currentIndex]);
}

function copyQRISCode() {
    const textarea = document.querySelector('.qris-code-text textarea');
    textarea.select();
    textarea.setSelectionRange(0, 99999); // For mobile devices
    
    try {
        document.execCommand('copy');
        const button = document.querySelector('.qris-code-text button');
        const originalText = button.textContent;
        button.textContent = 'Tersalin!';
        button.style.background = 'var(--success)';
        
        setTimeout(() => {
            button.textContent = originalText;
            button.style.background = '';
        }, 2000);
    } catch (err) {
        console.error('Failed to copy text: ', err);
    }
}

// Auto-refresh payment status
let checkInterval;
let countdownInterval;

function startPaymentCheck() {
    checkInterval = setInterval(function() {
        fetch('<?= BASEURL; ?>/checkout/check_payment/<?= $data['order']['id_order']; ?>')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'lunas') {
                    clearInterval(checkInterval);
                    clearInterval(countdownInterval);
                    showPaymentSuccess();
                } else if (data.expired) {
                    clearInterval(checkInterval);
                    clearInterval(countdownInterval);
                    showPaymentExpired();
                }
            })
            .catch(error => {
                console.error('Error checking payment:', error);
            });
    }, 5000); // Check every 5 seconds
}

function showPaymentSuccess() {
    document.getElementById('qrOverlay').style.display = 'flex';
    document.getElementById('qrOverlay').innerHTML = `
        <div style="text-align: center; color: var(--success);">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            <h3 style="margin: 1rem 0 0.5rem; color: var(--success);">Pembayaran Berhasil!</h3>
            <p style="margin: 0;">Redirecting...</p>
        </div>
    `;
    
    setTimeout(function() {
        window.location.href = '<?= BASEURL; ?>/checkout/success';
    }, 2000);
}

function showPaymentExpired() {
    location.reload();
}

// Start checking when page loads
<?php if (!$data['expired']): ?>
document.addEventListener('DOMContentLoaded', function() {
    startPaymentCheck();
    
    // Countdown timer
    // Convert MySQL datetime to JavaScript Date (assume local timezone)
    const expiredAtString = '<?= $data['payment']['qris_expired']; ?>';
    const expiredAt = new Date(expiredAtString.replace(' ', 'T'));
    
    // Debug: Log timezone info
    console.log('Expired time string:', expiredAtString);
    console.log('Expired Date object:', expiredAt);
    console.log('Current time:', new Date());
    console.log('Time difference (ms):', expiredAt - new Date());
    
    countdownInterval = setInterval(function() {
        const now = new Date();
        const diff = expiredAt - now;
        
        if (diff <= 0) {
            clearInterval(countdownInterval);
            document.getElementById('countdown').textContent = 'Expired';
            return;
        }
        
        const minutes = Math.floor(diff / 60000);
        const seconds = Math.floor((diff % 60000) / 1000);
        
        document.getElementById('countdown').textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }, 1000);
});
<?php endif; ?>
</script>

<?php require_once 'app/views/templates/public_footer.php'; ?>