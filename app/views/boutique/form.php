<?php
require_once 'app/views/template/header.php';
?>
<link rel="stylesheet" href="/assets/css/boutique.css">
<link rel="stylesheet" href="/assets/css/boutiqueAdmin.css">
<link rel="stylesheet" href="/assets/css/commandes.css">
<main id="app">
	<div class="container">

		<section class="form-section">
			<h2>Ajouter un produit</h2>
			<form action="/boutiqueAdmin.php?action=create" method="POST" class="product-form" enctype="multipart/form-data">
				<div class="form-group">
					<label for="nom">Nom</label>
					<input type="text" id="nom" name="nom" class="form-control" required>
				</div>
				
				<div class="form-group">
					<label for="description">Description</label>
					<textarea id="description" name="description" class="form-control" rows="4" required></textarea>
				</div>

				<div class="form-group">
					<label for="prix">Prix (€)</label>
					<input type="number" id="prix" name="prix" class="form-control" min="0" step="0.01" required>
				</div>

				<div class="form-group">
					<label for="stock">Stock</label>
					<input type="number" id="stock" name="stock" class="form-control" min="0" required>
				</div>

				<div class="form-group">
					<label for="tailles">Tailles disponibles</label>
					<div class="checkbox-group">
						<label><input type="checkbox" name="tailles[]" value="XS"> XS</label>
						<label><input type="checkbox" name="tailles[]" value="S"> S</label>
						<label><input type="checkbox" name="tailles[]" value="M"> M</label>
						<label><input type="checkbox" name="tailles[]" value="L"> L</label>
						<label><input type="checkbox" name="tailles[]" value="XL"> XL</label>
					</div>
				</div>

				<div class="form-group">
					<label for="couleurs">Couleurs disponibles</label>
					<div class="checkbox-group">
						<label><input type="checkbox" name="couleurs[]" value="Noir"> Noir</label>
						<label><input type="checkbox" name="couleurs[]" value="Blanc"> Blanc</label>
						<label><input type="checkbox" name="couleurs[]" value="Gris"> Gris</label>
						<label><input type="checkbox" name="couleurs[]" value="Bleu"> Bleu</label>
						<label><input type="checkbox" name="couleurs[]" value="Rouge"> Rouge</label>
					</div>
				</div>

				<div class="form-group">
					<label for="image">Image</label>
					<input type="file" id="image" name="image" class="form-control" accept="image/*">
				</div>

				<button type="submit" class="btn btn-success">Ajouter le produit</button>
			</form>
		</section>


		<section class="form-section">
			<h2>Modifier un produit</h2>
			<form action="/boutiqueAdmin.php?action=update" method="POST" class="product-form" enctype="multipart/form-data">
				<div class="form-group">
					<label for="product_id_update">Sélectionner le produit</label>
					<select id="product_id_update" name="product_id" class="form-control" required>
						<option value="">Choisir un produit</option>
						<?php foreach ($produits as $produit): ?>
							<option value="<?= $produit['id'] ?>">
								<?= htmlspecialchars($produit['nom']) ?> 
								(<?= number_format($produit['prix'], 2) ?> €)
							</option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label for="nom_update">Nouveau nom</label>
					<input type="text" id="nom_update" name="nom" class="form-control" required>
				</div>
				
				<div class="form-group">
					<label for="description_update">Nouvelle description</label>
					<textarea id="description_update" name="description" class="form-control" rows="4" required></textarea>
				</div>

				<div class="form-group">
					<label for="prix_update">Nouveau prix (€)</label>
					<input type="number" id="prix_update" name="prix" class="form-control" min="0" step="0.01" required>
				</div>

				<div class="form-group">
					<label for="stock_update">Nouveau stock</label>
					<input type="number" id="stock_update" name="stock" class="form-control" min="0" required>
				</div>

				<div class="form-group">
					<label for="tailles_update">Nouvelles tailles disponibles</label>
					<div class="checkbox-group">
						<label><input type="checkbox" name="tailles[]" value="XS"> XS</label>
						<label><input type="checkbox" name="tailles[]" value="S"> S</label>
						<label><input type="checkbox" name="tailles[]" value="M"> M</label>
						<label><input type="checkbox" name="tailles[]" value="L"> L</label>
						<label><input type="checkbox" name="tailles[]" value="XL"> XL</label>
					</div>
				</div>

				<div class="form-group">
					<label for="couleurs_update">Nouvelles couleurs disponibles</label>
					<div class="checkbox-group">
						<label><input type="checkbox" name="couleurs[]" value="Noir"> Noir</label>
						<label><input type="checkbox" name="couleurs[]" value="Blanc"> Blanc</label>
						<label><input type="checkbox" name="couleurs[]" value="Gris"> Gris</label>
						<label><input type="checkbox" name="couleurs[]" value="Bleu"> Bleu</label>
						<label><input type="checkbox" name="couleurs[]" value="Rouge"> Rouge</label>
					</div>
				</div>

				<div class="form-group">
					<label for="image_update">Nouvelle image</label>
					<input type="file" id="image_update" name="image" class="form-control" accept="image/*">
				</div>

				<button type="submit" class="btn btn-warning">Modifier le produit</button>
			</form>
		</section>

		<!-- Formulaire pour supprimer un produit -->

		<section class="form-section">
			<h2>Supprimer un produit</h2>
			<form action="/boutiqueAdmin.php?action=delete" method="POST" class="product-form" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
				<div class="form-group">
					<label for="product_id_delete">Produit à supprimer</label>
					<select id="product_id_delete" name="product_id" class="form-control" required>
						<option value="">Sélectionner...</option>
						<?php foreach ($produits as $produit): ?>
							<option value="<?= $produit['id'] ?>">
								<?= htmlspecialchars($produit['nom']) ?>
								(<?= number_format($produit['prix'], 2) ?> €)
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<button type="submit" class="btn btn-danger">Supprimer</button>
			</form>
		</section>

		<!-- Nouvelle section pour les commandes -->
		<section class="form-section commandes-section">
			<h2>Gestion des commandes</h2>
			<?php if (empty($commandes)): ?>
				<p class="text-muted">Aucune commande en attente.</p>
			<?php else: ?>
				<div class="commandes-list">
					<?php foreach ($commandes as $commande): ?>
						<div class="commande-item" data-commande-id="<?= $commande['id'] ?>">
							<div class="commande-header">
								<span>Commande #<?= $commande['id'] ?></span>
								<span class="date">
									<?= date('d/m/Y H:i', strtotime($commande['date_commande'])) ?>
								</span>
								<span class="status <?= $commande['statut'] ?>">
									<?= ucfirst($commande['statut']) ?>
								</span>
							</div>
							<div class="commande-content">
								<div class="commande-details">
									<p><strong>Client:</strong> <?= htmlspecialchars($commande['prenom'] . ' ' . $commande['nom']) ?></p>
									<div class="produits-list">
										<h4>Produits commandés</h4>
										<?php foreach ($commande['produits'] as $produit): ?>
											<div class="produit-item">
												<p><?= htmlspecialchars($produit['nom']) ?> - 
												   Taille: <?= $produit['taille'] ?>, 
												   Couleur: <?= $produit['couleur'] ?>, 
												   Quantité: <?= $produit['quantite'] ?>, 
												   Prix: <?= number_format($produit['prix_unitaire'], 2) ?>€</p>
											</div>
										<?php endforeach; ?>
										<div class="commande-total">
											<strong>Total de la commande: <?= number_format($commande['total_commande'], 2) ?>€</strong>
										</div>
									</div>
								</div>
								<div class="commande-actions">
									<?php if ($commande['statut'] !== 'reglee'): ?>
										<button class="btn btn-success regler-commande">
											<i class="fas fa-check"></i> Marquer comme réglée
										</button>
									<?php endif; ?>
									<button class="btn btn-danger supprimer-commande">
										<i class="fas fa-trash"></i> Supprimer
									</button>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</section>
	</div>
</main>
<script src="/assets/js/boutiqueAdmin.js"></script>
<script>
// Script pour charger les données du produit sélectionné dans le formulaire de modification
document.getElementById('product_id_update').addEventListener('change', function() {
	const selectedProduct = this.options[this.selectedIndex].value;
	if (selectedProduct) {
		fetch(`/boutiqueAdmin.php?action=get&id=${selectedProduct}`)
			.then(response => response.json())
			.then(produit => {
				document.getElementById('nom_update').value = produit.nom;
				document.getElementById('description_update').value = produit.description;
				document.getElementById('prix_update').value = produit.prix;
				document.getElementById('stock_update').value = produit.stock;

				// Mise à jour des checkboxes pour les tailles
				const tailles = Array.isArray(produit.taille) ? produit.taille : JSON.parse(produit.taille);
				document.querySelectorAll('input[name="tailles[]"]').forEach(checkbox => {
					checkbox.checked = tailles.includes(checkbox.value);
				});

				// Mise à jour des checkboxes pour les couleurs
				const couleurs = Array.isArray(produit.couleurs) ? produit.couleurs : JSON.parse(produit.couleurs);
				document.querySelectorAll('input[name="couleurs[]"]').forEach(checkbox => {
					checkbox.checked = couleurs.includes(checkbox.value);
				});
			})
			.catch(error => console.error('Erreur:', error));
	}
});
</script>

<?php require_once 'app/views/template/footer.php'; ?>