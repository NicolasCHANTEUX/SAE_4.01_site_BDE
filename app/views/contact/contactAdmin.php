<?php require_once 'app/views/template/header.php'; ?>
<link rel="stylesheet" href="/assets/css/contactAdmin.css">

<main id="app">
    <div class="container">
        <div class="contacts-container">
            <!-- Liste des contacts -->
            <section class="contacts-list">
                <h2>Demandes de contact</h2>
                <?php if (empty($contacts)): ?>
                    <p class="text-muted">Aucune demande de contact.</p>
                <?php else: ?>
                    <div class="list-group">
                        <?php foreach ($contacts as $contact): ?>
                            <div class="list-group-item <?= $contact['statut'] === 'non_lu' ? 'unread' : '' ?>" 
                                    data-contact-id="<?= $contact['id'] ?>">
                                <div class="contact-preview">
                                    <strong><?= htmlspecialchars($contact['nom']) ?> <?= htmlspecialchars($contact['prenom']) ?></strong>
                                    <span class="date"><?= date('d/m/Y H:i', strtotime($contact['date_envoi'])) ?></span>
                                </div>
                                <div class="contact-actions">
                                    <div class="contact-status">
                                        <span class="badge <?= $contact['statut'] === 'non_lu' ? 'bg-primary' : 'bg-success' ?>">
                                            <?= $contact['statut'] === 'non_lu' ? 'Non lu' : 'Lu' ?>
                                        </span>
                                    </div>
                                    <button class="delete-btn" data-contact-id="<?= $contact['id'] ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Détails du contact sélectionné -->
            <section class="contact-details" id="contactDetails">
                <div class="empty-state">
                    <p>Sélectionnez une demande de contact pour voir les détails</p>
                </div>
            </section>
        </div>
    </div>
</main>

<script src="/assets/js/contactAdmin.js"></script>
<?php require_once 'app/views/template/footer.php'; ?>