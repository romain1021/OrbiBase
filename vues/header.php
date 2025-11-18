<?php
// Header fragment: affiche une navbar si l'utilisateur est connecté.
// Do not output full HTML document here; index.php gère the wrapper.
if (session_status() !== PHP_SESSION_ACTIVE) {
    @session_start();
}

if (isset($_SESSION['user_id'])) {
    ?>
    <nav class="navbar" role="navigation" aria-label="Main navigation">
        <button class="btn nav-btn" data-page="home" aria-label="Accueil">Accueil</button>
        <button class="btn nav-btn" data-page="resources" aria-label="Ressources">Ressources</button>
        <button class="btn nav-btn" data-page="affectation" aria-label="Affectation">Affectation</button>
        <button class="btn nav-btn" id="btn-logout" data-href="controller/logout.php" aria-label="Déconnexion">Déconnexion</button>
    </nav>

    <script>
        // Gère la navigation par les boutons du header
        (function(){
            function getPageParam() {
                try {
                    const params = new URLSearchParams(window.location.search);
                    return params.get('page');
                } catch(e) { return null; }
            }

            const current = getPageParam() || null;
            document.querySelectorAll('.nav-btn').forEach(btn => {
                // active state
                const page = btn.dataset.page || null;
                if (page && page === current) btn.classList.add('active');

                // click handler
                btn.addEventListener('click', function(){
                    if (btn.id === 'btn-logout' && btn.dataset.href) {
                        window.location.href = btn.dataset.href;
                        return;
                    }
                    const p = btn.dataset.page;
                    if (p) {
                        window.location.href = 'index.php?page=' + encodeURIComponent(p);
                    }
                });

                // keyboard: Enter/Space
                btn.addEventListener('keydown', function(e){
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        btn.click();
                    }
                });
            });
        })();
    </script>

    <?php
}

