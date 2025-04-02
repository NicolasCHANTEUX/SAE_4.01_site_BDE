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

            <!-- Grille des événements -->
            <div class="evenements-grid">
                <!-- Événement 1 -->
                <div class="evenement-item">
                    <img src="/assets/images/events/bowling.png" alt="Événement Bowling" />
                    <h3>Soirée Bowling</h3>
                    <p>Le 2 avril 2025 - 10 places disponibles</p>
                </div>

                <!-- Événement 2 -->
                <div class="evenement-item">
                    <img src="/assets/images/events/poker.png" alt="Événement Poker" />
                    <h3>Tournoi de Poker</h3>
                    <p>Le 5 avril 2025 - 6 places disponibles</p>
                </div>

                <!-- Voir plus d'événements -->
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