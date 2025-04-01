<?php require_once 'template/header.php'; ?>

<div class="container">
	<h1>Contactez-nous</h1>
	
	<form id="contactForm" method="POST" action="/contact">
		<div class="form-group">
			<label for="nom">Nom</label>
			<input type="text" class="form-control" id="nom" name="nom" required>
		</div>
		
		<div class="form-group">
			<label for="prenom">Prénom</label>
			<input type="text" class="form-control" id="prenom" name="prenom" required>
		</div>
		
		<div class="form-group">
			<label for="email">Email</label>
			<input type="email" class="form-control" id="email" name="email" required>
		</div>
		
		<div class="form-group">
			<label for="demande">Votre message</label>
			<textarea class="form-control" id="demande" name="demande" rows="5" required></textarea>
		</div>
		
		<button type="submit" class="btn btn-primary">Envoyer</button>
	</form>

	<div class="social-links mt-4">
		<h3>Nos réseaux sociaux</h3>
		<ul>
			<li>Email : <a href="mailto:<?= htmlspecialchars($socialLinks['email']) ?>"><?= htmlspecialchars($socialLinks['email']) ?></a></li>
			<li>Discord : <a href="<?= htmlspecialchars($socialLinks['discord']) ?>" target="_blank">Rejoignez-nous sur Discord</a></li>
			<li>Instagram : <a href="<?= htmlspecialchars($socialLinks['instagram']) ?>" target="_blank">Suivez-nous sur Instagram</a></li>
		</ul>
	</div>
</div>

<?php require_once 'template/footer.php'; ?>