<?php
require_once 'app/entities/User.php';

if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
}
?>

<div class="modal fade" id="compteModal" tabindex="-1" aria-labelledby="compteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="compteModalLabel">Mon Compte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="compteTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="infos-tab" data-bs-toggle="tab" data-bs-target="#infos" type="button">
                            Mes informations
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="historique-tab" data-bs-toggle="tab" data-bs-target="#historique" type="button">
                            Historique de demandes
                        </button>
                    </li>
                </ul>
                <div class="tab-content mt-3">
                    <div class="tab-pane fade show active" id="infos" role="tabpanel">
                        <div class="user-info">
                            <p><strong>Nom :</strong> <?php echo htmlspecialchars($user->getNom()); ?></p>
                            <p><strong>Prénom :</strong> <?php echo htmlspecialchars($user->getPrenom()); ?></p>
                            <p><strong>Email :</strong> <?php echo htmlspecialchars($user->getEmail()); ?></p>
                            <p><strong>Rôle :</strong> <?php echo htmlspecialchars($user->getRole()); ?></p>
                            
                            <div class="account-actions mt-4">
                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#passwordModal">
                                    <i class="fas fa-key me-2"></i>Modifier mon mot de passe
                                </button>
                                <button class="btn btn-danger mt-2" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                    <i class="fas fa-user-times me-2"></i>Supprimer mon compte
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="historique" role="tabpanel">
                        <?php if (empty($historique)): ?>
                            <p class="text-muted">Aucun historique de commande disponible.</p>
                        <?php else: ?>
                            <div class="commandes-list">
                                <?php foreach ($historique as $commande): ?>
                                    <div class="commande-item">
                                        <div class="commande-header">
                                            <span>Commande du <?= date('d/m/Y H:i', strtotime($commande['date_commande'])) ?></span>
                                            <span class="status <?= $commande['statut'] ?>"><?= ucfirst($commande['statut']) ?></span>
                                        </div>
                                        <div class="commande-content">
                                            <div class="commande-details">
                                                <div class="produit-details">
                                                    <h4>Détails de la commande</h4>
                                                    <p><strong>Produit:</strong> <?= htmlspecialchars($commande['produit_nom']) ?></p>
                                                    <p><strong>Taille:</strong> <?= $commande['taille'] ?></p>
                                                    <p><strong>Couleur:</strong> <?= $commande['couleur'] ?></p>
                                                    <p><strong>Quantité:</strong> <?= $commande['quantite'] ?></p>
                                                    <p><strong>Prix unitaire:</strong> <?= number_format($commande['prix_unitaire'], 2) ?> €</p>
                                                    <p><strong>Total:</strong> <?= number_format($commande['prix_total'], 2) ?> €</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
