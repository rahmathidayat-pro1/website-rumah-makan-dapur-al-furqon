<?php require_once 'app/views/templates/public_header.php'; ?>

<div class="container" style="padding: 2rem 24px;">
    <div class="artikel-detail">
        <!-- Breadcrumb -->
        <nav class="breadcrumb" style="margin-bottom: 2rem;">
            <a href="<?= BASEURL; ?>">Home</a> / 
            <a href="<?= BASEURL; ?>/artikel">Artikel</a> / 
            <span><?= $data['artikel']['judul']; ?></span>
        </nav>

        <!-- Artikel Header -->
        <header class="artikel-header" style="margin-bottom: 2rem;">
            <div class="artikel-meta" style="margin-bottom: 1rem;">
                <span class="kategori kategori-<?= $data['artikel']['kategori']; ?>">
                    <?= ucfirst($data['artikel']['kategori']); ?>
                </span>
                <span class="tanggal">
                    <?= date('d F Y', strtotime($data['artikel']['tanggal'])); ?>
                </span>
            </div>
            
            <h1 class="artikel-title" style="font-size: 2.5rem; line-height: 1.2; margin-bottom: 1rem; color: #1f2937;">
                <?= $data['artikel']['judul']; ?>
            </h1>
        </header>

        <!-- Artikel Image -->
        <?php if($data['artikel']['gambar']) : ?>
            <div class="artikel-featured-image" style="margin-bottom: 2rem;">
                <img src="<?= BASEURL; ?>/public/img/<?= $data['artikel']['gambar']; ?>" 
                     alt="<?= $data['artikel']['judul']; ?>"
                     style="width: 100%; height: 400px; object-fit: cover; border-radius: 0.75rem;">
            </div>
        <?php endif; ?>

        <!-- Artikel Content -->
        <div class="artikel-content" style="max-width: 800px; margin: 0 auto;">
            <div class="content-body" style="font-size: 1.125rem; line-height: 1.8; color: #374151;">
                <?= nl2br(htmlspecialchars($data['artikel']['konten'])); ?>
            </div>
        </div>

        <!-- Share Buttons -->
        <div class="share-section" style="margin: 3rem 0; padding: 2rem; background: #f9fafb; border-radius: 0.75rem; text-align: center;">
            <h3 style="margin-bottom: 1rem; color: #1f2937;">Bagikan Artikel Ini</h3>
            <div class="share-buttons">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(BASEURL . '/artikel/detail/' . $data['artikel']['slug']); ?>" 
                   target="_blank" class="share-btn facebook">Facebook</a>
                <a href="https://twitter.com/intent/tweet?url=<?= urlencode(BASEURL . '/artikel/detail/' . $data['artikel']['slug']); ?>&text=<?= urlencode($data['artikel']['judul']); ?>" 
                   target="_blank" class="share-btn twitter">Twitter</a>
                <a href="https://wa.me/?text=<?= urlencode($data['artikel']['judul'] . ' - ' . BASEURL . '/artikel/detail/' . $data['artikel']['slug']); ?>" 
                   target="_blank" class="share-btn whatsapp">WhatsApp</a>
            </div>
        </div>

        <!-- Artikel Lainnya -->
        <?php if (!empty($data['artikel_lainnya'])) : ?>
            <section class="artikel-lainnya" style="margin-top: 4rem;">
                <h3 style="font-size: 1.875rem; margin-bottom: 2rem; text-align: center; color: #1f2937;">
                    Artikel Lainnya
                </h3>
                
                <div class="artikel-grid">
                    <?php foreach($data['artikel_lainnya'] as $artikel) : ?>
                        <?php if($artikel['id_artikel'] != $data['artikel']['id_artikel']) : ?>
                            <article class="artikel-card">
                                <?php if($artikel['gambar']) : ?>
                                    <div class="artikel-image">
                                        <img src="<?= BASEURL; ?>/public/img/<?= $artikel['gambar']; ?>" 
                                             alt="<?= $artikel['judul']; ?>">
                                    </div>
                                <?php endif; ?>
                                
                                <div class="artikel-content">
                                    <div class="artikel-meta">
                                        <span class="kategori kategori-<?= $artikel['kategori']; ?>">
                                            <?= ucfirst($artikel['kategori']); ?>
                                        </span>
                                        <span class="tanggal">
                                            <?= date('d M Y', strtotime($artikel['created_at'])); ?>
                                        </span>
                                    </div>
                                    
                                    <h4 class="artikel-title">
                                        <a href="<?= BASEURL; ?>/artikel/detail/<?= $artikel['slug']; ?>">
                                            <?= $artikel['judul']; ?>
                                        </a>
                                    </h4>
                                    
                                    <p class="artikel-excerpt">
                                        <?= substr(strip_tags($artikel['konten']), 0, 100); ?>...
                                    </p>
                                </div>
                            </article>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </div>
</div>

<style>
.breadcrumb {
    font-size: 0.875rem;
    color: #6b7280;
}

.breadcrumb a {
    color: #3b82f6;
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.artikel-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.kategori {
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 500;
    color: white;
}

.kategori-berita { background: #3b82f6; }
.kategori-tips { background: #06b6d4; }
.kategori-resep { background: #f59e0b; }
.kategori-promo { background: #10b981; }

.tanggal {
    font-size: 0.875rem;
    color: #6b7280;
}

.content-body p {
    margin-bottom: 1.5rem;
}

.share-buttons {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.share-btn {
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    text-decoration: none;
    font-weight: 500;
    color: white;
    transition: transform 0.2s;
}

.share-btn:hover {
    transform: translateY(-1px);
}

.share-btn.facebook { background: #1877f2; }
.share-btn.twitter { background: #1da1f2; }
.share-btn.whatsapp { background: #25d366; }

.artikel-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.artikel-card {
    background: white;
    border-radius: 0.75rem;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s, box-shadow 0.2s;
}

.artikel-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.artikel-image {
    height: 150px;
    overflow: hidden;
}

.artikel-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.artikel-content {
    padding: 1.5rem;
}

.artikel-title a {
    color: #1f2937;
    text-decoration: none;
    font-size: 1.125rem;
    font-weight: 600;
    line-height: 1.4;
}

.artikel-title a:hover {
    color: #3b82f6;
}

.artikel-excerpt {
    color: #6b7280;
    line-height: 1.6;
    margin-top: 0.5rem;
}

@media (max-width: 768px) {
    .container {
        padding-left: 16px !important;
        padding-right: 16px !important;
    }
    
    .artikel-title {
        font-size: 1.5rem !important;
    }
    
    .artikel-featured-image img {
        height: 200px !important;
        border-radius: 0.5rem !important;
    }
    
    .content-body {
        font-size: 0.95rem !important;
        line-height: 1.7 !important;
    }
    
    .share-section {
        padding: 1.5rem !important;
        margin: 2rem 0 !important;
    }
    
    .share-section h3 {
        font-size: 1rem;
    }
    
    .share-buttons {
        flex-direction: row;
        gap: 0.5rem;
    }
    
    .share-btn {
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
    }
    
    .artikel-lainnya h3 {
        font-size: 1.25rem !important;
        margin-bottom: 1.5rem !important;
    }
    
    .artikel-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    
    .artikel-card {
        border-radius: 0.5rem;
    }
    
    .artikel-image {
        height: 100px;
    }
    
    .artikel-content {
        padding: 10px;
    }
    
    .artikel-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
        margin-bottom: 6px;
    }
    
    .kategori {
        padding: 2px 6px;
        font-size: 0.6rem;
    }
    
    .tanggal {
        font-size: 0.65rem;
    }
    
    .artikel-title a {
        font-size: 0.8rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .artikel-excerpt {
        font-size: 0.7rem;
        -webkit-line-clamp: 2;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
}

@media (max-width: 480px) {
    .artikel-title {
        font-size: 1.25rem !important;
    }
    
    .artikel-featured-image img {
        height: 180px !important;
    }
    
    .content-body {
        font-size: 0.9rem !important;
    }
    
    .artikel-grid {
        gap: 8px;
    }
    
    .artikel-image {
        height: 80px;
    }
    
    .artikel-content {
        padding: 8px;
    }
    
    .artikel-title a {
        font-size: 0.75rem;
    }
    
    .artikel-excerpt {
        font-size: 0.65rem;
    }
}
</style>

<?php require_once 'app/views/templates/public_footer.php'; ?>