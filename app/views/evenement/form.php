<?php
require_once 'app/views/template/header.php';
?>
<link rel="stylesheet" href="/assets/css/evenement.css">
<main id="app">
    <div class="container">
        <!-- Formulaire pour ajouter un événement -->
        <section class="form-section">
            <h2>Ajouter un événement</h2>
            <form action="/evenementAdmin.php?action=create" method="POST" class="event-form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" id="titre" name="titre" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="date_evenement">Date de l'événement</label>
                    <input type="datetime-local" id="date_evenement" name="date_evenement" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="prix">Prix (€)</label>
                    <input type="number" id="prix" name="prix" class="form-control" min="0" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="max_participants">Nombre maximum de participants (0 pour illimité)</label>
                    <input type="number" id="max_participants" name="max_participants" class="form-control" min="0">
                </div>

                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-success">Ajouter l'événement</button>
            </form>
        </section>

        <!-- Formulaire pour modifier un événement -->
        <section class="form-section">
            <h2>Modifier un événement</h2>
            <form action="/evenementAdmin.php?action=update" method="POST" class="event-form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="event_id_update">Sélectionner l'événement</label>
                    <select id="event_id_update" name="event_id" class="form-control" required>
                        <option value="">Choisir un événement</option>
                        <?php foreach ($evenements as $event): ?>
                            <option value="<?= $event['id'] ?>">
                                <?= htmlspecialchars($event['titre']) ?> 
                                (<?= date('d/m/Y H:i', strtotime($event['date_evenement'])) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="titre_update">Nouveau titre</label>
                    <input type="text" id="titre_update" name="titre" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="description_update">Nouvelle description</label>
                    <textarea id="description_update" name="description" class="form-control" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="date_evenement_update">Nouvelle date</label>
                    <input type="datetime-local" id="date_evenement_update" name="date_evenement" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="prix_update">Nouveau prix (€)</label>
                    <input type="number" id="prix_update" name="prix" class="form-control" min="0" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="max_participants_update">Nouveau nombre maximum de participants</label>
                    <input type="number" id="max_participants_update" name="max_participants" class="form-control" min="0">
                </div>

                <div class="form-group">
                    <label for="image_update">Nouvelle image</label>
                    <input type="file" id="image_update" name="image" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-warning">Modifier l'événement</button>
            </form>
        </section>

        <!-- Formulaire pour supprimer un événement -->
        <section class="form-section">
            <h2>Supprimer un événement</h2>
            <form action="/evenementAdmin.php?action=delete" method="POST" class="event-form" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
                <div class="form-group">
                    <label for="event_id_delete">Sélectionner l'événement à supprimer</label>
                    <select id="event_id_delete" name="event_id" class="form-control" required>
                        <option value="">Choisir un événement</option>
                        <?php foreach ($evenements as $event): ?>
                            <option value="<?= $event['id'] ?>">
                                <?= htmlspecialchars($event['titre']) ?> 
                                (<?= date('d/m/Y H:i', strtotime($event['date_evenement'])) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-danger">Supprimer l'événement</button>
            </form>
        </section>
    </div>
</main>

<script>
// Script pour charger les données de l'événement sélectionné dans le formulaire de modification
document.getElementById('event_id_update').addEventListener('change', function() {
    const selectedEvent = this.options[this.selectedIndex].value;
    if (selectedEvent) {
        fetch(`/evenementAdmin.php?action=get&id=${selectedEvent}`)
            .then(response => response.json())
            .then(event => {
                document.getElementById('titre_update').value = event.titre;
                document.getElementById('description_update').value = event.description;
                document.getElementById('date_evenement_update').value = event.date_evenement.slice(0, 16);
                document.getElementById('prix_update').value = event.prix;
                document.getElementById('max_participants_update').value = event.max_participants;
            })
            .catch(error => console.error('Erreur:', error));
    }
});
</script>

<?php require_once 'app/views/template/footer.php'; ?>