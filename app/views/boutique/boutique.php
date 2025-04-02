<?php
require_once 'app/views/template/header.php';
?>
	<link rel="stylesheet" href="/assets/css/boutique.css">
	<main id="app">
			<div class="container">
				<div id="boutique-app" class="boutique-container">
					<h2>Notre boutique</h2>
					<script>
						const BOUTIQUE_DATA = <?php echo json_encode($produits); ?>;
					</script>
				</div>
			</div>
	</main>
	<script src="/assets/js/boutique.js"></script>
<?php require_once 'app/views/template/footer.php'; ?>