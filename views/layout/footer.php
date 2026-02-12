    </main><!-- /.main-content -->
</div><!-- /.app-layout -->

<script>
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

    // Theme Toggle - Modo Oscuro/Claro
    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;
    
    // Cargar tema guardado
    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-theme', savedTheme);
    
    // Toggle theme
    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            // Actualizar título del botón
            themeToggle.setAttribute('title', 
                newTheme === 'dark' ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro'
            );
            
            // Reinicializar iconos
            lucide.createIcons();
        });
    }
</script>

</body>
</html>
