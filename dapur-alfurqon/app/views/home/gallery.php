<?php require_once 'app/views/templates/public_header.php'; ?>

<!-- Gallery Hero -->
<section class="gallery-hero">
    <div class="container">
        <h1>Gallery <span>Foto</span></h1>
        <p>Momen-momen terbaik di Dapur Al-Furqon</p>
    </div>
</section>

<div class="container">
    <section class="gallery-section">
        <?php if(empty($data['gallery'])): ?>
            <div class="empty-gallery">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                <h3>Belum Ada Foto</h3>
                <p>Gallery foto akan segera hadir!</p>
            </div>
        <?php else: ?>
            <div class="gallery-grid">
                <?php foreach($data['gallery'] as $index => $g): ?>
                    <div class="gallery-item" onclick="openLightbox(<?= $index; ?>)">
                        <img src="<?= BASEURL; ?>/public/img/<?= $g['gambar']; ?>" alt="<?= htmlspecialchars($g['judul']); ?>" loading="lazy">
                        <div class="gallery-overlay">
                            <h4><?= htmlspecialchars($g['judul']); ?></h4>
                            <?php if($g['deskripsi']): ?>
                                <p><?= htmlspecialchars(substr($g['deskripsi'], 0, 60)); ?>...</p>
                            <?php endif; ?>
                            <span class="view-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</div>

<!-- Lightbox Modal -->
<div class="lightbox" id="lightbox">
    <button class="lightbox-close" onclick="closeLightbox()">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
    <button class="lightbox-nav lightbox-prev" onclick="changeLightbox(-1)">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
    </button>
    <button class="lightbox-nav lightbox-next" onclick="changeLightbox(1)">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
    </button>
    <div class="lightbox-content">
        <img id="lightbox-img" src="" alt="">
        <div class="lightbox-caption">
            <h3 id="lightbox-title"></h3>
            <p id="lightbox-desc"></p>
        </div>
    </div>
</div>

<script>
    // Gallery data for lightbox
    const galleryData = [
        <?php foreach($data['gallery'] as $g): ?>
        {
            src: "<?= BASEURL; ?>/public/img/<?= $g['gambar']; ?>",
            title: "<?= addslashes(htmlspecialchars($g['judul'])); ?>",
            desc: "<?= addslashes(htmlspecialchars($g['deskripsi'])); ?>"
        },
        <?php endforeach; ?>
    ];

    let currentIndex = 0;

    function openLightbox(index) {
        currentIndex = index;
        updateLightbox();
        document.getElementById('lightbox').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('active');
        document.body.style.overflow = '';
    }

    function changeLightbox(direction) {
        currentIndex += direction;
        if (currentIndex < 0) currentIndex = galleryData.length - 1;
        if (currentIndex >= galleryData.length) currentIndex = 0;
        updateLightbox();
    }

    function updateLightbox() {
        const item = galleryData[currentIndex];
        document.getElementById('lightbox-img').src = item.src;
        document.getElementById('lightbox-title').textContent = item.title;
        document.getElementById('lightbox-desc').textContent = item.desc;
    }

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') changeLightbox(-1);
        if (e.key === 'ArrowRight') changeLightbox(1);
    });

    // Close on background click
    document.getElementById('lightbox').addEventListener('click', function(e) {
        if (e.target === this) closeLightbox();
    });
</script>

<?php require_once 'app/views/templates/public_footer.php'; ?>
