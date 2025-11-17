<?php
$latestResources = getLatestResources();
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Ressources</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<h1>Ressources actuelles</h1>
	<?php if ($latestResources): ?>
		<div class="resources">
			<ul>
				<li><strong>Oxygène :</strong> <?= htmlspecialchars($latestResources['oxygene'] ?? '') ?></li>
				<li><strong>Nourriture :</strong> <?= htmlspecialchars($latestResources['nourriture'] ?? '') ?></li>
				<li><strong>Eau :</strong> <?= htmlspecialchars($latestResources['eau'] ?? '') ?></li>
				<li><strong>Énergie :</strong> <?= htmlspecialchars($latestResources['energie'] ?? '') ?></li>
				<li><strong>Dernière mise à jour :</strong> <?= htmlspecialchars($latestResources['date_heure'] ?? '') ?></li>
			</ul>
		</div>
	<?php else: ?>
        <p>Aucune ressource enregistrée pour le moment.</p>
	<?php endif; ?>
</body>
</html>
