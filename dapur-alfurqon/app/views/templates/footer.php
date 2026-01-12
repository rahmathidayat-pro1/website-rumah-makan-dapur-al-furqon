        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarClose = document.getElementById('sidebarClose');

        if(sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.add('active');
            });
        }

        if(sidebarClose) {
            sidebarClose.addEventListener('click', () => {
                sidebar.classList.remove('active');
            });
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                if (sidebar && !sidebar.contains(e.target) && sidebarToggle && !sidebarToggle.contains(e.target) && sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                }
            }
        });

        // SweetAlert Delete Confirmation
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.location.href = href;
                    }
                });
            });
        });
    </script>
    <?php Flasher::flash(); ?>
    <?php Flasher::loginFlash(); ?>
</body>
</html>
