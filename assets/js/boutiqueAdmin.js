document.addEventListener('DOMContentLoaded', function() {
    // Gestionnaire pour voir les détails d'une commande
    document.querySelectorAll('.view-commande').forEach(button => {
        button.addEventListener('click', async function() {
            const commandeId = this.dataset.commandeId;
            try {
                const response = await fetch(`/boutiqueAdmin.php?action=getCommande&id=${commandeId}`);
                const data = await response.json();
                
                showCommandeDetails(data);
            } catch (error) {
                console.error('Erreur:', error);
                alert('Erreur lors du chargement des détails de la commande');
            }
        });
    });

    // Gestionnaire pour valider une commande
    document.querySelectorAll('.validate-commande').forEach(button => {
        button.addEventListener('click', async function() {
            const commandeId = this.dataset.commandeId;
            if (confirm('Êtes-vous sûr de vouloir valider cette commande ?')) {
                try {
                    const response = await fetch('/boutiqueAdmin.php?action=validateCommande', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: commandeId })
                    });
                    const result = await response.json();
                    
                    if (result.success) {
                        alert('Commande validée avec succès');
                        window.location.reload();
                    } else {
                        alert(result.message || 'Erreur lors de la validation');
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la validation de la commande');
                }
            }
        });
    });

    function showCommandeDetails(commande) {
        const modal = document.createElement('div');
        modal.className = 'modal-commande';
        modal.innerHTML = `
            <div class="modal-commande-content">
                <h3>Détails de la commande #${commande.id}</h3>
                <div class="commande-info">
                    <p><strong>Client:</strong> ${commande.prenom} ${commande.nom}</p>
                    <p><strong>Date:</strong> ${new Date(commande.date_commande).toLocaleString()}</p>
                    <p><strong>Statut:</strong> ${commande.statut}</p>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Taille</th>
                            <th>Couleur</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${commande.produits.map(p => `
                            <tr>
                                <td>${p.nom}</td>
                                <td>${p.taille}</td>
                                <td>${p.couleur}</td>
                                <td>${p.quantite}</td>
                                <td>${p.prix_unitaire}€</td>
                                <td>${(p.prix_unitaire * p.quantite).toFixed(2)}€</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
                <button class="btn btn-secondary" onclick="this.closest('.modal-commande').remove()">Fermer</button>
            </div>
        `;
        document.body.appendChild(modal);
    }
});