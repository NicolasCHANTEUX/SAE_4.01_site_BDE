<?php
require_once 'app/views/template/header.php';
?>
    <link rel="stylesheet" href="/assets/css/accueil.css">
    <main id="app">
        <div class="container">
            <section id="presentation" class="hero-section">
                <h1>Bienvenue sur le site du BDE</h1>
                <p>Découvrez nos événements, nos produits et bien plus encore !</p>
            </section>

            <!-- Section Carousel -->
            <section id="carousel" class="carousel-container">
                <div class="carousel">
                    <?php if (isset($articles) && is_array($articles) && !empty($articles)): ?>
                        <?php foreach ($articles as $key => $article): ?>
                            <div class="carousel-item <?= $key === 0 ? 'active' : '' ?>">
                                <h2><?= htmlspecialchars($article['titre']) ?></h2>
                                <p><?= htmlspecialchars($article['description']) ?></p>
                                <small>Créé le : <?= htmlspecialchars($article['date_creation']) ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucun article à afficher pour le moment.</p>
                    <?php endif; ?>
                    </div>
                    <div class="carousel-controls">
                        <button class="prev-btn" aria-label="Article précédent">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="next-btn" aria-label="Article suivant">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
            </section>

            <!-- Section Événements -->
            <section id="evenements" class="evenements-container">
                <h2>Événements à venir</h2>

                <div class="evenements-grid">
                    <?php if (isset($evenements) && !empty($evenements)): ?>
                        <?php for ($i = 0; $i < min(2, count($evenements)); $i++): ?>
                            <?php $event = $evenements[$i]; ?>
                            <div class="evenement-item">
                                <img src="<?= htmlspecialchars($event['chemin_image']) ?>" alt="Événement <?= htmlspecialchars($event['titre']) ?>" />
                                <h3><?= htmlspecialchars($event['titre']) ?></h3>
                                <p>Le <?= (new DateTime($event['date_evenement']))->format('d M Y H:i') ?> - 
                                <?= htmlspecialchars($event['max_participants'] - $event['nb_inscrits']) ?> places disponibles</p>
                            </div>
                        <?php endfor; ?>
                    <?php else: ?>
                        <p>Aucun événement à venir pour le moment.</p>
                    <?php endif; ?>

                    <div class="voir-plus-item">
                        <span>+</span>
                        <p>Voir plus d'événements</p>
                    </div>
                </div>
            </section>

        </div>
    </main>
    <script src="/assets/js/accueil.js"></script>
<?php require_once 'app/views/template/footer.php'; ?>
