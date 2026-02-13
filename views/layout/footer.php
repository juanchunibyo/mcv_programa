    </main><!-- /.main-content -->
</div><!-- /.app-layout -->

<script>
    // Forzar modo claro y limpiar localStorage
    localStorage.removeItem('theme');
    document.documentElement.removeAttribute('data-theme');
    
    // Initialize Lucide icons
    lucide.createIcons();

    // Sidebar toggle (mobile)
    (function() {
        var toggle = document.getElementById('sidebarToggle');
        var sidebar = document.getElementById('sidebar');
        var overlay = document.getElementById('sidebarOverlay');

        if (toggle && sidebar && overlay) {
            toggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('active');
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            });
        }
    })();
</script>
        });
    }
</script>

</body>
</html>
