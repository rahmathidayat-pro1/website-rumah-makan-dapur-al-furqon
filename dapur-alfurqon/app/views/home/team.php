<?php require_once 'app/views/templates/public_header.php'; ?>

<!-- Team Hero -->
<section class="team-hero">
    <div class="container">
        <h1>Tim <span>Kami</span></h1>
        <p>Orang-orang hebat di balik kelezatan Dapur Al-Furqon</p>
    </div>
</section>

<div class="container">
    <section class="team-section">
        <?php if(empty($data['karyawan'])): ?>
            <div class="empty-team">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <h3>Belum Ada Data Karyawan</h3>
                <p>Informasi tim akan segera hadir!</p>
            </div>
        <?php else: ?>
            <div class="team-grid">
                <?php foreach($data['karyawan'] as $k): ?>
                    <div class="team-card">
                        <div class="team-photo">
                            <img src="<?= BASEURL; ?>/public/img/<?= $k['foto']; ?>" alt="<?= htmlspecialchars($k['nama']); ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($k['nama']); ?>&size=300&background=aa1942&color=fff'">
                        </div>
                        <div class="team-info">
                            <h3><?= htmlspecialchars($k['nama']); ?></h3>
                            <span class="team-position"><?= htmlspecialchars($k['jabatan']); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php require_once 'app/views/templates/public_footer.php'; ?>
