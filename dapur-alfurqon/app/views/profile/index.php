<?php require_once 'app/views/templates/public_header.php'; ?>

<!-- Profile Hero -->
<section class="profile-hero">
    <div class="container">
        <h1>Tentang <span>Dapur Al-Furqon</span></h1>
        <p>Mengenal lebih dekat perjalanan dan nilai-nilai yang kami pegang teguh</p>
    </div>
</section>

<div class="container">
    <!-- Sejarah Section -->
    <section class="profile-section">
        <div class="profile-content">
            <div class="profile-text">
                <h2>
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    Sejarah Kami
                </h2>
                <?php 
                $sejarah_paragraphs = explode("\n\n", $data['pengaturan']['sejarah']);
                foreach($sejarah_paragraphs as $paragraph) : 
                    if(trim($paragraph)) :
                ?>
                    <p><?= nl2br(htmlspecialchars(trim($paragraph))); ?></p>
                <?php 
                    endif;
                endforeach; 
                ?>
            </div>
            <div class="profile-image">
                <img src="<?= BASEURL; ?>/public/img/hero.jpeg" alt="Interior Dapur Al-Furqon" onerror="this.src='https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=600&h=400&fit=crop'">
            </div>
        </div>
    </section>

    <!-- Artikel Section -->
    <?php if (!empty($data['artikel'])) : ?>
    <section class="profile-section artikel-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
            <h2 class="section-title" style="margin-bottom: 0;">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                Artikel & Berita Terbaru
            </h2>
            <a href="<?= BASEURL; ?>/artikel" class="btn-primary" style="padding: 10px 20px; font-size: 0.9rem;">
                Lihat Semua Artikel
            </a>
        </div>
        
        <div class="artikel-grid">
            <?php foreach($data['artikel'] as $artikel) : ?>
                <article class="artikel-card">
                    <?php if($artikel['gambar']) : ?>
                        <div class="artikel-image">
                            <img src="<?= BASEURL; ?>/public/img/<?= $artikel['gambar']; ?>" 
                                 alt="<?= htmlspecialchars($artikel['judul']); ?>">
                        </div>
                    <?php endif; ?>
                    
                    <div class="artikel-content">
                        <div class="artikel-meta">
                            <span class="kategori kategori-<?= $artikel['kategori']; ?>">
                                <?= ucfirst($artikel['kategori']); ?>
                            </span>
                            <span class="tanggal">
                                <?= date('d M Y', strtotime($artikel['tanggal'])); ?>
                            </span>
                        </div>
                        
                        <h3 class="artikel-title">
                            <a href="<?= BASEURL; ?>/artikel/detail/<?= $artikel['slug']; ?>">
                                <?= htmlspecialchars($artikel['judul']); ?>
                            </a>
                        </h3>
                        
                        <p class="artikel-excerpt">
                            <?= substr(strip_tags($artikel['konten']), 0, 120); ?>...
                        </p>
                        
                        <a href="<?= BASEURL; ?>/artikel/detail/<?= $artikel['slug']; ?>" class="read-more">
                            Baca Selengkapnya →
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- Visi Misi Section -->
    <section class="profile-section visi-misi-section">
        <h2 class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            Visi & Misi
        </h2>
        <div class="visi-misi-grid">
            <div class="visi-card">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                </div>
                <h3>Visi</h3>
                <p><?= nl2br(htmlspecialchars($data['pengaturan']['visi'])); ?></p>
            </div>
            <div class="misi-card">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
                <h3>Misi</h3>
                <ul>
                    <?php foreach($data['misi_list'] as $misi) : ?>
                        <?php if(trim($misi)) : ?>
                            <li><?= htmlspecialchars(trim($misi)); ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <!-- Jam Operasional Section -->
    <section class="profile-section">
        <h2 class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            Jam Operasional
        </h2>
        <div class="hours-grid">
            <div class="hours-card">
                <div class="day-name">Senin - Jumat</div>
                <div class="hours-time"><?= htmlspecialchars($data['pengaturan']['jam_senin_jumat']); ?></div>
            </div>
            <div class="hours-card">
                <div class="day-name">Sabtu</div>
                <div class="hours-time"><?= htmlspecialchars($data['pengaturan']['jam_sabtu']); ?></div>
            </div>
            <div class="hours-card">
                <div class="day-name">Minggu</div>
                <div class="hours-time"><?= htmlspecialchars($data['pengaturan']['jam_minggu']); ?></div>
            </div>
        </div>
    </section>

    <!-- Kontak Section -->
    <section class="profile-section contact-section">
        <h2 class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            Kontak & Lokasi
        </h2>
        <div class="contact-grid">
            <div class="contact-info">
                <div class="contact-item">
                    <div class="contact-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    </div>
                    <div class="contact-detail">
                        <h4>Alamat</h4>
                        <p><?= nl2br(htmlspecialchars($data['pengaturan']['alamat'])); ?></p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    </div>
                    <div class="contact-detail">
                        <h4>Telepon</h4>
                        <p><?= htmlspecialchars($data['pengaturan']['telepon']); ?></p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    </div>
                    <div class="contact-detail">
                        <h4>Email</h4>
                        <p><?= htmlspecialchars($data['pengaturan']['email']); ?></p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon whatsapp">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </div>
                    <div class="contact-detail">
                        <h4>WhatsApp</h4>
                        <p><a href="https://wa.me/<?= htmlspecialchars($data['pengaturan']['whatsapp']); ?>" target="_blank"><?= htmlspecialchars($data['pengaturan']['whatsapp_display']); ?></a></p>
                    </div>
                </div>
            </div>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.8195613!3d-6.1944491!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d2e764b12d%3A0x3d2ad6e1e0e9bcc8!2sMonumen%20Nasional!5e0!3m2!1sid!2sid!4v1702000000000!5m2!1sid!2sid" 
                    width="100%" 
                    height="400" 
                    style="border:0; border-radius: 16px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>
</div>

<style>
/* Artikel Section Styling */
.artikel-section {
    padding: 64px 0 !important;
}

.artikel-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
}

.artikel-card {
    background: white;
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-light);
    transition: all var(--transition-base);
    display: flex;
    flex-direction: column;
    height: 100%;
}

.artikel-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
    border-color: transparent;
}

.artikel-image {
    height: 180px;
    overflow: hidden;
}

.artikel-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-slow);
}

.artikel-card:hover .artikel-image img {
    transform: scale(1.05);
}

.artikel-content {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.artikel-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.kategori {
    padding: 4px 12px;
    border-radius: var(--radius-full);
    font-size: 0.75rem;
    font-weight: 600;
    color: white;
}

.kategori-berita { background: var(--primary); }
.kategori-tips { background: #06b6d4; }
.kategori-resep { background: #f59e0b; }
.kategori-promo { background: #10b981; }

.tanggal {
    font-size: 0.8rem;
    color: var(--text-muted);
}

.artikel-title {
    margin-bottom: 12px;
    flex-shrink: 0;
}

.artikel-title a {
    color: var(--secondary);
    text-decoration: none;
    font-size: 1.1rem;
    font-weight: 600;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.artikel-title a:hover {
    color: var(--primary);
}

.artikel-excerpt {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 16px;
    flex: 1;
    font-size: 0.9rem;
}

.read-more {
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
    font-size: 0.85rem;
    align-self: flex-start;
    transition: color var(--transition-fast);
}

.read-more:hover {
    color: var(--primary-dark);
}

/* Responsive */
@media (max-width: 1200px) {
    .artikel-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
}

@media (max-width: 992px) {
    .artikel-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
}

@media (max-width: 768px) {
    .artikel-section {
        padding: 48px 0 !important;
    }
    
    .artikel-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    
    .artikel-card {
        border-radius: var(--radius-md);
    }
    
    .artikel-image {
        height: 120px;
    }
    
    .artikel-content {
        padding: 12px;
    }
    
    .artikel-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
        margin-bottom: 8px;
    }
    
    .kategori {
        padding: 2px 8px;
        font-size: 0.65rem;
    }
    
    .tanggal {
        font-size: 0.7rem;
    }
    
    .artikel-title a {
        font-size: 0.85rem;
        -webkit-line-clamp: 2;
    }
    
    .artikel-excerpt {
        font-size: 0.75rem;
        -webkit-line-clamp: 2;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 8px;
    }
    
    .read-more {
        font-size: 0.75rem;
    }
    
    .artikel-section .section-title {
        font-size: 1.5rem;
    }
    
    .artikel-section > div:first-child {
        flex-direction: column;
        gap: 16px;
        align-items: flex-start !important;
    }
}

@media (max-width: 480px) {
    .artikel-grid {
        gap: 8px;
    }
    
    .artikel-image {
        height: 100px;
    }
    
    .artikel-content {
        padding: 10px;
    }
    
    .artikel-title a {
        font-size: 0.8rem;
    }
    
    .artikel-excerpt {
        font-size: 0.7rem;
        margin-bottom: 6px;
    }
    
    .read-more {
        font-size: 0.7rem;
    }
}
</style>

<?php require_once 'app/views/templates/public_footer.php'; ?>
