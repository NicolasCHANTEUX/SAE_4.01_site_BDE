<?php
require_once 'app/views/template/header.php';
?>
    <main id="app">
    <link rel="stylesheet" href="/assets/css/contact.css">

        <div class="container">
            <div class="contact-container">
                <div class="contact-form-section">
                    <h1>Contactez-nous</h1>
                    <div id="messageResult"></div>
                    <form id="contactForm" method="POST" action="/contact" class="contact-form">
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
                            <textarea class="form-control" id="demande" name="demande" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>

                <section class="social-section">
                    <div class="faq-text-container">
                        <p class="faq-text">Si vous avez des questions, nous pouvons peut-être déjà y répondre !</p>
                    </div>

                    <div class="faq-button-container">
                        <a href="/questionsFrequentes.php" class="btn-primary">Questions fréquentes</a>
                    </div>

                    <h2>Rejoignez-nous</h2>
                    <div class="social-grid">
                        <div class="social-card">
                            <i class="fas fa-envelope social-icon"></i>
                            <h3>Email</h3>
                            <a href="mailto:<?= htmlspecialchars($socialLinks['email']) ?>" class="social-link">
                                <?= htmlspecialchars($socialLinks['email']) ?>
                            </a>
                        </div>
                        
                        <div class="social-card">
                            <i class="fab fa-discord social-icon"></i>
                            <h3>Discord</h3>
                            <a href="<?= htmlspecialchars($socialLinks['discord']) ?>" target="_blank" class="social-link btn-discord">
                                Rejoindre le serveur
                            </a>
                        </div>
                        
                        <div class="social-card">
                            <i class="fab fa-instagram social-icon"></i>
                            <h3>Instagram</h3>
                            <a href="<?= htmlspecialchars($socialLinks['instagram']) ?>" target="_blank" class="social-link btn-instagram">
                                Nous suivre
                            </a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
    <script src="/assets/js/contact.js"></script>
<?php require_once 'app/views/template/footer.php'; ?>