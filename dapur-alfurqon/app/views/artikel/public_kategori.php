<?php require_once 'app/views/templates/public_header.php'; ?>

<div class="container" style="padding: 2rem 24px;">
    <div class="page-header" style="text-align: center; margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; margin-bottom: 1rem; color: #1f2937;">
            Artikel <?= ucfirst($data['kategori']); ?>
        </h1>
        <p style="font-size: 1.125rem; color: #6b7280; max-width: 600px; margin: 0 auto;">
            Temukan artikel menarik seputar <?= $data['kategori']; ?>
        </p>
    </div>

    <!-- Filter Kategori -->
    <div class="kategori-filter" style="margin-bottom: 2rem; text-align: center;">
        <a href="<?= BASEURL; ?>/artikel" class="filter-btn">Semua</a>
        <a href="<?= BASEURL; ?>/artikel/kategori/berita" class="filter-btn <?= $data['kategori'] == 'berita' ? 'active' : ''; ?>">Berita</a>
        <a href="<?= BASEURL; ?>/artikel/kategori/tips" class="filter-btn <?= $data['kategori'] == 'tips' ? 'active' : ''; ?>">Tips</a>
        <a href="<?= BASEURL; ?>/artikel/kategori/resep" class="filter-btn <?= $data['kategori'] == 'resep' ? 'active' : ''; ?>">Resep</a>
        <a href="<?= BASEURL; ?>/artikel/kategori/promo" class="filter-btn <?= $data['kategori'] == 'promo' ? 'active' : ''; ?>">Promo</a>
    </div>

    <!-- Artikel Grid -->
    <div class="artikel-grid">
        <?php if (!empty($data['artikel'])) : ?>
            <?php foreach($data['artikel'] as $artikel) : ?>
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
                                <?= date('d M Y', strtotime($artikel['tanggal'])); ?>
                            </span>
                        </div>
                        
                        <h3 class="artikel-title">
                            <a href="<?= BASEURL; ?>/artikel/detail/<?= $artikel['slug']; ?>">
                                <?= $artikel['judul']; ?>
                            </a>
                        </h3>
                        
                        <p class="artikel-excerpt">
                            <?= substr(strip_tags($artikel['konten']), 0, 150); ?>...
                        </p>
                        
                        <a href="<?= BASEURL; ?>/artikel/detail/<?= $artikel['slug']; ?>" class="read-more">
                            Baca Selengkapnya →
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="no-artikel" style="text-align: center; padding: 3rem; grid-column: 1 / -1;">
                <h3 style="color: #6b7280; margin-bottom: 1rem;">Belum Ada Artikel</h3>
                <p style="color: #9ca3af;">Artikel kategori <?= $data['kategori']; ?> belum tersedia. Silakan cek kategori lainnya.</p>
                <a href="<?= BASEURL; ?>/artikel" class="btn-primary" style="display: inline-block; margin-top: 1rem;">
                    Lihat Semua Artikel
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.filter-btn {
    display: inline-block;
    padding: 0.5rem 1rem;
    margin: 0 0.25rem;
    background: #f3f4f6;
    color: #6b7280;
    text-decoration: none;
    border-radius: 0.5rem;
    transition: all 0.2s;
}

.filter-btn:hover,
.filter-btn.active {
    background: #3b82f6;
    color: white;
}

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
    height: 200px;
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

.artikel-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
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

.artikel-title {
    margin-bottom: 1rem;
}

.artikel-title a {
    color: #1f2937;
    text-decoration: none;
    font-size: 1.25rem;
    font-weight: 600;
    line-height: 1.4;
}

.artikel-title a:hover {
    color: #3b82f6;
}

.artikel-excerpt {
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.read-more {
    color: #3b82f6;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.875rem;
}

.read-more:hover {
    color: #2563eb;
}

@media (max-width: 768px) {
    .container {
        padding-left: 16px !important;
        padding-right: 16px !important;
    }
    
    .page-header h1 {
        font-size: 1.75rem !important;
    }
    
    .page-header p {
        font-size: 0.95rem !important;
    }
    
    .artikel-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    
    .artikel-card {
        border-radius: 0.5rem;
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
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
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
    
    .kategori-filter {
        overflow-x: auto;
        white-space: nowrap;
        padding-bottom: 0.5rem;
    }
    
    .filter-btn {
        padding: 0.4rem 0.75rem;
        font-size: 0.8rem;
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
    }
    
    .read-more {
        font-size: 0.7rem;
    }
}
</style>

<?php require_once 'app/views/templates/public_footer.php'; ?>