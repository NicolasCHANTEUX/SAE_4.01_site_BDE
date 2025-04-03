<?php
require_once 'app/views/template/header.php';
require_once 'app/middlewares/AuthMiddleware.php';

// Redirection si non connecté
AuthMiddleware::requireAuth();

// Inclure les modals
require_once 'app/views/components/modal-compte.php';
require_once 'app/views/components/modal-password.php';
require_once 'app/views/components/modal-delete-account.php';
?>

<script src="/assets/js/compte.js"></script>

<?php
require_once 'app/views/template/footer.php';
