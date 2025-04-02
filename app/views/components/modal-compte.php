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
                            <p><strong>Nom :</strong> <?php echo htmlspecialchars($_SESSION['user_nom']); ?></p>
                            <p><strong>Prénom :</strong> <?php echo htmlspecialchars($_SESSION['user_prenom']); ?></p>
                            <p><strong>Email :</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                            <p><strong>Rôle :</strong> <?php echo htmlspecialchars($_SESSION['user_role']); ?></p>
                            
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
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Produit</th>
                                            <th>Taille</th>
                                            <th>Couleur</th>
                                            <th>Quantité</th>
                                            <th>Prix unitaire</th>
                                            <th>Total</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($historique as $commande): ?>
                                            <tr>
                                                <td><?php echo date('d/m/Y H:i', strtotime($commande['date_commande'])); ?></td>
                                                <td><?php echo htmlspecialchars($commande['produit_nom']); ?></td>
                                                <td><?php echo htmlspecialchars($commande['taille'] ?? '-'); ?></td>
                                                <td><?php echo htmlspecialchars($commande['couleur'] ?? '-'); ?></td>
                                                <td><?php echo $commande['quantite']; ?></td>
                                                <td><?php echo number_format($commande['prix_unitaire'], 2); ?> €</td>
                                                <td><?php echo number_format($commande['prix_total'], 2); ?> €</td>
                                                <td>
                                                    <span class="badge bg-<?php 
                                                        echo match($commande['statut']) {
                                                            'en_attente' => 'warning',
                                                            'validée' => 'success',
                                                            'annulée' => 'danger',
                                                            default => 'secondary'
                                                        };
                                                    ?>">
                                                        <?php echo htmlspecialchars($commande['statut']); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
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
