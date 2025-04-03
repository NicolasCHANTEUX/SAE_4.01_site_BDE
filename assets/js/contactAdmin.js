document.addEventListener('DOMContentLoaded', function() {
    const contactsList = document.querySelector('.list-group');
    const contactDetails = document.getElementById('contactDetails');

    contactsList?.addEventListener('click', async function(e) {
        const contactItem = e.target.closest('.list-group-item');
        if (!contactItem) return;

        // Mettre à jour le statut visuel
        document.querySelectorAll('.list-group-item').forEach(item => {
            item.classList.remove('active');
        });
        contactItem.classList.add('active');
        contactItem.classList.remove('unread');

        const contactId = contactItem.dataset.contactId;
        const contact = await getContactDetails(contactId);

        // Afficher les détails du contact
        displayContactDetails(contact);
    });
});

async function getContactDetails(contactId) {
    try {
        const response = await fetch(`/contactAdmin.php?action=get&id=${contactId}`);
        if (!response.ok) throw new Error('Erreur lors de la récupération des détails');
        return await response.json();
    } catch (error) {
        console.error('Erreur:', error);
        return null;
    }
}

function displayContactDetails(result) {
    if (!result.success || !result.data) {
        contactDetails.innerHTML = '<div class="error">Erreur lors du chargement des détails</div>';
        return;
    }

    const contact = result.data;
    const date = new Date(contact.date_envoi).toLocaleString('fr-FR');

    contactDetails.innerHTML = `
        <div class="contact-info">
            <h3>Détails de la demande</h3>
            <p><strong>De :</strong> ${contact.prenom} ${contact.nom}</p>
            <p><strong>Email :</strong> ${contact.email}</p>
            <p><strong>Date :</strong> ${date}</p>
            <p><strong>Message :</strong></p>
            <div class="message-content">
                ${contact.message}
            </div>
        </div>
        <form class="reply-form" data-contact-id="${contact.id}">
            <div class="form-group">
                <label for="reponse">Réponse</label>
                <textarea class="form-control" id="reponse" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Envoyer la réponse</button>
        </form>
    `;
}

// Gérer la soumission du formulaire de réponse
document.addEventListener('submit', async function(e) {
    if (!e.target.matches('.reply-form')) return;
    
    e.preventDefault();
    const form = e.target;
    const contactId = form.dataset.contactId;
    const reponse = form.querySelector('#reponse').value;
    
    try {
        const response = await fetch('/contactAdmin.php?action=repondre', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                contactId: contactId,
                reponse: reponse
            })
        });

        const result = await response.json();
        
        if (result.success) {
            alert('Réponse envoyée avec succès');
            form.reset();
            // Mettre à jour le statut dans la liste
            const contactItem = document.querySelector(`[data-contact-id="${contactId}"]`);
            const statusBadge = contactItem.querySelector('.badge');
            statusBadge.className = 'badge bg-success';
            statusBadge.textContent = 'Répondu';
        } else {
            alert(result.message || 'Erreur lors de l\'envoi de la réponse');
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Une erreur est survenue lors de l\'envoi de la réponse');
    }
});