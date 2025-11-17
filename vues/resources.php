<?php
$latestResources = getLatestResources();
?>

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

