<?php
require_once 'app/views/template/header.php';
?>
<link rel="stylesheet" href="/assets/css/evenement.css">
    <main id="app">
    <div class="container">
        <div id="evenement-app" class="evenement-container">
            <h2>Les événements du BDE</h2>
            <?php foreach ($evenements as $evenement): ?>
                <div class="evenement-card">
                    <?php if ($evenement['chemin_image']): ?>
                        <div class="evenement-image">
                            <img src="/<?= $evenement['chemin_image'] ?>" 
                                alt="<?= htmlspecialchars($evenement['titre']) ?>"
                                loading="lazy"
                                onerror="this.src='/assets/images/product-default.jpg'">
                        </div>
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($evenement['titre']) ?></h3>
                    <p><?= htmlspecialchars($evenement['description']) ?></p>
                    <div class="evenement-details">
                        <span class="date">Date: <?= date('d/m/Y H:i', strtotime($evenement['date_evenement'])) ?></span>
                        <span class="prix">Prix: <?= $evenement['prix'] == 0 ? 'Gratuit' : number_format($evenement['prix'], 2) . ' €' ?></span>
                        <span class="places">Places: <?= $evenement['nb_inscrits'] ?>/<?= $evenement['max_participants'] ?: '∞' ?></span>
                    </div>
                    <button class="btn-participer" data-id="<?= $evenement['id'] ?>">Participer</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<script src="/assets/js/evenement.js"></script>
<?php require_once 'app/views/template/footer.php'; ?>