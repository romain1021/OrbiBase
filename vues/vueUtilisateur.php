<?php
require_once __DIR__ . '/../controller/user.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$viewerId = $_SESSION['user_id'] ?? null;

$profileId = isset($_GET['id']) && $_GET['id'] !== '' ? (int) $_GET['id'] : $viewerId;

if ($profileId === null) {
    header('Location: index.php?page=connexion');
    exit;
}

$user = getUserById($profileId);
if (!$user) {
    echo "<p style='color:red;'>Utilisateur non trouvé.</p>";
    exit;
}
?>

<section class="profile-card">
    <h2 class="profile-title">Profil Utilisateur</h2>

    <div class="profile-main">
        <div class="profile-photo">
            <?php if (!empty($user['lienPDP'])): ?>
                <img src="<?php echo htmlspecialchars($user['lienPDP']); ?>" alt="Photo de <?php echo htmlspecialchars($user['identifiant']); ?>" />
            <?php else: ?>
                <div class="profile-photo--placeholder">Aucune photo</div>
            <?php endif; ?>
        </div>

        <div class="profile-info">
            <p><strong>Identifiant :</strong> <?php echo htmlspecialchars($user['identifiant']); ?></p>
            <p><strong>Nom :</strong> <?php echo htmlspecialchars($user['nom']); ?></p>
            <p><strong>Prénom :</strong> <?php echo htmlspecialchars($user['prenom']); ?></p>
            <p><strong>Spécialité :</strong> <?php echo htmlspecialchars($user['specialite'] ?? 'N/A'); ?></p>
            <p><strong>Secteur :</strong> <?php echo htmlspecialchars($user['secteur'] ?? 'N/A'); ?></p>
            <p><strong>Statut :</strong> <?php echo htmlspecialchars($user['statut']); ?></p>

            <?php if ($viewerId !== null && $viewerId === $profileId): ?>
                <div class="profile-actions">
                    <button class="btn" id="toggle-edit">Modifier mon profil</button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($viewerId !== null && $viewerId === $profileId): ?>
        <div id="edit-section" style="display:none;margin-top:16px;">
            <?php include __DIR__ . '/modif.php'; ?>
        </div>
    <?php endif; ?>
</section>

<script>
    // Toggle pour le formulaire de modification
    (function(){
        const btn = document.getElementById('toggle-edit');
        const edit = document.getElementById('edit-section');
        if (!btn || !edit) return;
        btn.addEventListener('click', function(){
            if (edit.style.display === 'none' || edit.style.display === '') {
                edit.style.display = 'block';
                btn.textContent = 'Masquer le formulaire';
                btn.classList.add('active');
                edit.scrollIntoView({behavior:'smooth'});
            } else {
                edit.style.display = 'none';
                btn.textContent = 'Modifier mon profil';
                btn.classList.remove('active');
            }
        });
    })();
</script>

