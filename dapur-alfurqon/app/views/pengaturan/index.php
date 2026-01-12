<?php require_once 'app/views/templates/header.php'; ?>

<div class="page-header">
    <h1><?= $data['title']; ?></h1>
    <div style="display: flex; gap: 1rem;">
        <a href="<?= BASEURL; ?>/profile" target="_blank" class="btn-secondary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                <polyline points="15 3 21 3 21 9"></polyline>
                <line x1="10" y1="14" x2="21" y2="3"></line>
            </svg>
            Preview Halaman
        </a>
    </div>
</div>

<?php Flasher::flash(); ?>

<div class="form-container" style="max-width: 800px;">
    <form action="<?= BASEURL; ?>/dashboard/pengaturan/update" method="post">
        
        <!-- Sejarah Section -->
        <div style="margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid var(--border-light);">
            <h3 style="display: flex; align-items: center; gap: 12px; margin-bottom: 1.5rem; color: var(--secondary);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                Sejarah Perusahaan
            </h3>
            <div class="form-group">
                <label for="sejarah">Sejarah</label>
                <textarea id="sejarah" name="sejarah" rows="8" required 
                          style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem; resize: vertical; line-height: 1.6;"><?= htmlspecialchars($data['pengaturan']['sejarah']); ?></textarea>
            </div>
        </div>

        <!-- Visi Misi Section -->
        <div style="margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid var(--border-light);">
            <h3 style="display: flex; align-items: center; gap: 12px; margin-bottom: 1.5rem; color: var(--secondary);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                Visi & Misi
            </h3>
            <div class="form-group">
                <label for="visi">Visi</label>
                <textarea id="visi" name="visi" rows="4" required 
                          style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem; resize: vertical; line-height: 1.6;"><?= htmlspecialchars($data['pengaturan']['visi']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="misi">Misi</label>
                <textarea id="misi" name="misi" rows="6" required 
                          placeholder="Pisahkan setiap poin misi dengan enter/baris baru"
                          style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem; resize: vertical; line-height: 1.6;"><?= htmlspecialchars($data['pengaturan']['misi']); ?></textarea>
                <small style="font-size: 0.875rem; color: var(--text-muted); margin-top: 0.5rem; display: block;">
                    Pisahkan setiap poin misi dengan enter/baris baru
                </small>
            </div>
        </div>

        <!-- Jam Operasional Section -->
        <div style="margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid var(--border-light);">
            <h3 style="display: flex; align-items: center; gap: 12px; margin-bottom: 1.5rem; color: var(--secondary);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                Jam Operasional
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <div class="form-group">
                    <label for="jam_senin_jumat">Senin - Jumat</label>
                    <input type="text" id="jam_senin_jumat" name="jam_senin_jumat" value="<?= htmlspecialchars($data['pengaturan']['jam_senin_jumat']); ?>" required 
                           placeholder="08:00 - 21:00"
                           style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem;">
                </div>
                <div class="form-group">
                    <label for="jam_sabtu">Sabtu</label>
                    <input type="text" id="jam_sabtu" name="jam_sabtu" value="<?= htmlspecialchars($data['pengaturan']['jam_sabtu']); ?>" required 
                           placeholder="09:00 - 22:00"
                           style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem;">
                </div>
                <div class="form-group">
                    <label for="jam_minggu">Minggu</label>
                    <input type="text" id="jam_minggu" name="jam_minggu" value="<?= htmlspecialchars($data['pengaturan']['jam_minggu']); ?>" required 
                           placeholder="10:00 - 20:00"
                           style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem;">
                </div>
            </div>
        </div>

        <!-- Kontak Section -->
        <div style="margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid var(--border-light);">
            <h3 style="display: flex; align-items: center; gap: 12px; margin-bottom: 1.5rem; color: var(--secondary);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
                Kontak & Lokasi
            </h3>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3" required 
                          placeholder="Jl. Contoh Alamat No. 123&#10;Kota, Provinsi 12345"
                          style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem; resize: vertical; line-height: 1.6;"><?= htmlspecialchars($data['pengaturan']['alamat']); ?></textarea>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <div class="form-group">
                    <label for="telepon">Telepon</label>
                    <input type="text" id="telepon" name="telepon" value="<?= htmlspecialchars($data['pengaturan']['telepon']); ?>" required 
                           placeholder="+62 812-3456-7890"
                           style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem;">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($data['pengaturan']['email']); ?>" required 
                           placeholder="info@dapuralfurqon.com"
                           style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem;">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <div class="form-group">
                    <label for="whatsapp">WhatsApp (Format Link)</label>
                    <input type="text" id="whatsapp" name="whatsapp" value="<?= htmlspecialchars($data['pengaturan']['whatsapp']); ?>" required 
                           placeholder="6281234567890"
                           style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem;">
                    <small style="font-size: 0.875rem; color: var(--text-muted); margin-top: 0.5rem; display: block;">
                        Format internasional tanpa tanda + (contoh: 6281234567890)
                    </small>
                </div>
                <div class="form-group">
                    <label for="whatsapp_display">WhatsApp (Tampilan)</label>
                    <input type="text" id="whatsapp_display" name="whatsapp_display" value="<?= htmlspecialchars($data['pengaturan']['whatsapp_display']); ?>" required 
                           placeholder="+62 812-3456-7890"
                           style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem;">
                    <small style="font-size: 0.875rem; color: var(--text-muted); margin-top: 0.5rem; display: block;">
                        Format untuk ditampilkan di halaman (contoh: +62 812-3456-7890)
                    </small>
                </div>
            </div>
        </div>

        <!-- Payment Gateway Section -->
        <div style="margin-bottom: 2rem;">
            <h3 style="display: flex; align-items: center; gap: 12px; margin-bottom: 1.5rem; color: var(--secondary);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                    <line x1="1" y1="10" x2="23" y2="10"></line>
                </svg>
                Payment Gateway (Pakasir)
            </h3>
            
            <!-- Webhook Info -->
            <div style="background: linear-gradient(135deg, #e0f2fe, #dbeafe); border: 1px solid #7dd3fc; border-radius: var(--radius-md); padding: 1.25rem; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2" style="flex-shrink: 0; margin-top: 2px;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <div>
                        <strong style="color: #0369a1; display: block; margin-bottom: 0.5rem;">Webhook URL</strong>
                        <p style="color: #0c4a6e; margin: 0 0 0.75rem 0; font-size: 0.9rem;">
                            Masukkan URL berikut di pengaturan Webhook pada dashboard Pakasir Anda:
                        </p>
                        <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                            <code id="webhookUrl" style="background: white; padding: 0.5rem 1rem; border-radius: var(--radius-sm); font-size: 0.85rem; color: #0369a1; border: 1px solid #bae6fd; word-break: break-all;"><?= BASEURL; ?>/checkout/webhook</code>
                            <button type="button" onclick="copyWebhookUrl()" class="btn-copy" title="Salin URL">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                                Salin
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <div class="form-group">
                    <label for="pakasir_project">Nama Project</label>
                    <input type="text" id="pakasir_project" name="pakasir_project" 
                           value="<?= htmlspecialchars($data['pengaturan']['pakasir_project'] ?? ''); ?>" 
                           placeholder="nama-project-anda"
                           style="width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem;">
                    <small style="font-size: 0.875rem; color: var(--text-muted); margin-top: 0.5rem; display: block;">
                        Nama project yang terdaftar di Pakasir
                    </small>
                </div>
                <div class="form-group">
                    <label for="pakasir_api_key">API Key</label>
                    <div style="position: relative;">
                        <input type="password" id="pakasir_api_key" name="pakasir_api_key" 
                               value="<?= htmlspecialchars($data['pengaturan']['pakasir_api_key'] ?? ''); ?>" 
                               placeholder="••••••••••••••••"
                               style="width: 100%; padding: 14px; padding-right: 50px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 1rem;">
                        <button type="button" onclick="toggleApiKey()" class="btn-toggle-password" title="Tampilkan/Sembunyikan">
                            <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    <small style="font-size: 0.875rem; color: var(--text-muted); margin-top: 0.5rem; display: block;">
                        API Key dari halaman detail project Pakasir
                    </small>
                </div>
            </div>
            
            <!-- Status Info -->
            <div style="background: var(--bg-secondary); border-radius: var(--radius-md); padding: 1rem; margin-top: 1rem;">
                <div style="display: flex; align-items: center; gap: 8px; color: var(--text-secondary); font-size: 0.9rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                    <span>API Key disimpan dengan aman dan tidak akan ditampilkan setelah disimpan</span>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-light);">
            <button type="submit" class="btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                Simpan Pengaturan
            </button>
            <a href="<?= BASEURL; ?>/dashboard" class="btn-secondary">Kembali ke Dashboard</a>
        </div>
    </form>
</div>

<style>
.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.75rem;
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.95rem;
}

input:focus, select:focus, textarea:focus {
    outline: none !important;
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 3px rgba(170, 25, 66, 0.1) !important;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
}

h3 svg {
    color: var(--primary);
}

.btn-copy {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0.5rem 1rem;
    background: #0284c7;
    color: white;
    border: none;
    border-radius: var(--radius-sm);
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-copy:hover {
    background: #0369a1;
}

.btn-copy.copied {
    background: var(--success);
}

.btn-toggle-password {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: var(--text-muted);
    padding: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-toggle-password:hover {
    color: var(--text-primary);
}
</style>

<script>
function copyWebhookUrl() {
    const webhookUrl = document.getElementById('webhookUrl').textContent;
    navigator.clipboard.writeText(webhookUrl).then(() => {
        const btn = document.querySelector('.btn-copy');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Tersalin!';
        btn.classList.add('copied');
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('copied');
        }, 2000);
    });
}

function toggleApiKey() {
    const input = document.getElementById('pakasir_api_key');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
    } else {
        input.type = 'password';
        eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
    }
}
</script>

<?php require_once 'app/views/templates/footer.php'; ?>