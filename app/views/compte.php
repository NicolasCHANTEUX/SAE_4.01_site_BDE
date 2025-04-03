<?php require_once 'app/views/template/header.php'; ?>

// Redirection si non connecté
AuthMiddleware::requireAuth();

// Inclure les modals
require_once 'app/views/components/modal-compte.php';
require_once 'app/views/components/modal-password.php';
require_once 'app/views/components/modal-delete-account.php';

// Ajouter les scripts nécessaires
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/compte.js"></script>

<?php require_once 'app/views/template/footer.php'; ?>
