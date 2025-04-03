<?php
require_once 'app/views/template/header.php';
?>
<link rel="stylesheet" href="/assets/css/evenement.css">
<main id="app">
    <div class="container">


        <!-- Formulaire pour ajouter un article -->
        <section class="form-section">
            <h2>Ajouter un article</h2>
            <form action="/articleAdmin.php?action=create" method="POST" class="event-form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" id="titre" name="titre" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="date_evenement">Date de création</label>
                    <input type="datetime-local" id="date_creation" name="date_creation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Ajouter l'article</button>
            </form>
        </section>

        <!-- Formulaire pour modifier un article -->
        <section class="form-section">
            <h2>Modifier un article</h2>
            <form action="/articleAdmin.php?action=update" method="POST" class="event-form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="article_id_update">Sélectionner l'article</label>
                    <select id="article_id_update" name="article_id" class="form-control" required>
                        <option value="">Choisir un article</option>
                        <?php foreach ($articles as $article): ?>
                            <option value="<?= $article['id'] ?>">
                                <?= htmlspecialchars($article['titre']) ?> 
                                (<?= date('d/m/Y H:i', strtotime($article['date_creation'])) ?>)
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
                    <label for="date_creation_update">Nouvelle date</label>
                    <input type="datetime-local" id="date_creation_update" name="date_creation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-warning">Modifier l'article</button>
            </form>
        </section>

        <!-- Formulaire pour supprimer un événement -->
        <section class="form-section">
            <h2>Supprimer un événement</h2>
            <form action="/evenementAdmin.php?action=delete" method="POST" class="event-form" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
                <div class="form-group">
                    <label for="article_id_delete">Sélectionner l'événement à supprimer</label>
                    <select id="article_id_delete" name="event_id" class="form-control" required>
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
document.getElementById('article_id_update').addEventListener('change', function() {
    const selectedEvent = this.options[this.selectedIndex].value;
    if (selectedEvent) {
        fetch(`/articleAdmin.php?action=get&id=${selectedEvent}`)
            .then(response => response.json())
            .then(event => {
                document.getElementById('titre_update').value = event.titre;
                document.getElementById('description_update').value = event.description;
                document.getElementById('date_creation_update').value = event.date_evenement.slice(0, 16);
            })
            .catch(error => console.error('Erreur:', error));
    }
});
</script>

<?php require_once 'app/views/template/footer.php'; ?>