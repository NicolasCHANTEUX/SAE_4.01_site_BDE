<?php require_once 'app/views/template/header.php'; ?>

// Redirection si non connecté
AuthMiddleware::requireAuth();

// Inclure la modal
require_once 'app/views/components/modal-compte.php';

require_once 'app/views/template/footer.php';
