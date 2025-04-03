const DEFAULT_IMAGE = './assets/images/product-default.jpg';

// Fonction pour charger les événements
async function loadEvents() {
    try {
		const response = await fetch('/evenement.php?action=list');
        
        if (!response.ok) {
            throw new Error('Erreur lors du chargement des événements');
        }

        const events = await response.json();

        if (!events || events.length === 0) {
            displayEmptyEvents();
            return;
        }

        displayEvents(events);

    } catch (error) {
        console.error('Erreur:', error);
        displayError("Impossible de charger les événements pour le moment.");
    }
}

function displayEvents(events) {
    const evenementApp = document.getElementById('evenement-app');
    
    if (!events || events.length === 0) {
        displayEmptyShop(evenementApp);
        return;
    }

    try {
        evenementApp.innerHTML = `
            <div class="evenement-container">
                <div class="events-grid">
                    ${events.map(event => createEventCard(event)).join('')}
                </div>
                <div class="event-details" id="event-details">
                    <!-- Details will be inserted here -->
                </div>
            </div>
        `;

        // Show first event details by default
        showEventDetails(events[0]);

        // Add click handlers to all cards
        document.querySelectorAll('.evenement-card').forEach(card => {
            card.addEventListener('click', () => {
                const eventId = card.dataset.eventId;
                const event = events.find(e => e.id === parseInt(eventId));
                if (event) {
                    showEventDetails(event);
                }
            });
        });
    } catch (error) {
        console.error('Erreur lors de l\'affichage des événements:', error);
        displayError("Une erreur est survenue lors de l'affichage des événements.");
    }
}

function createEventCard(event) {
    const titre = event.titre || 'Événement sans nom';
    const prix = event.prix || 0;
    const image = event.chemin_image || DEFAULT_IMAGE;
    const date = new Date(event.date_evenement);
    const priceDisplay = event.prix == 0 ? 'Gratuit' : event.prix + '€';

    return `
        <div class="evenement-card" data-event-id="${event.id}">
            <div class="evenement-image">
                <img src="/${image}" alt="${titre}" 
                     onerror="this.onerror=null; this.src='${DEFAULT_IMAGE}';">
            </div>
            <h3 class="evenement-title">${titre}</h3>
            <p class="evenement-date">${date.toLocaleDateString('fr-FR')}</p>
            <p class="evenement-price">${priceDisplay}</p>
        </div>
    `;
}

async function registerForEvent(eventId) {
    try {
        const response = await fetch('/evenement.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ 
                evenement_id: eventId 
            })
        });

        const result = await response.json();

        if (result.success) {
            showNotification(
                'Super !',
                'Votre inscription a été enregistrée',
                'success'
            );
            await loadEvents(); // Recharger après la notification
        } else {
            showNotification(
                'Attention',
                result.message || 'Une erreur est survenue',
                'warning'
            );
        }
    } catch (error) {
        showNotification(
            'Erreur',
            'Une erreur lors de l\'inscription',
            'error'
        );
    }
}

// Modifier la fonction showEventDetails pour gérer le bouton désactivé
function showEventDetails(event) {
    const detailsContainer = document.getElementById('event-details');
    detailsContainer.classList.remove('hidden');
    
    const date = new Date(event.date_evenement);
    const formattedDate = date.toLocaleDateString('fr-FR', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
    
    // Vérifier si l'événement est complet
    const isEventFull = event.max_participants && event.nb_inscrits >= event.max_participants;
    
    detailsContainer.innerHTML = `
        <h2>${event.titre}</h2>
        <div class="event-details-content">
            <div class="event-details-item">
                <span class="event-details-label">Date:</span>
                <span>${formattedDate}</span>
            </div>
            <div class="event-details-item">
                <span class="event-details-label">Places:</span>
                <span>${event.nb_inscrits}/${event.max_participants || '∞'}</span>
            </div>
            <div class="event-details-item">
                <span class="event-details-label">Prix:</span>
                <span>${event.prix == 0 ? 'Gratuit' : event.prix + '€'}</span>
            </div>
            <div class="event-details-item">
                <span class="event-details-label">Description:</span>
                <p>${event.description}</p>
            </div>
            <button class="btn-secondary ${isEventFull ? 'disabled' : ''}" 
                    onclick="registerForEvent(${event.id})"
                    ${isEventFull ? 'disabled' : ''}>
                ${isEventFull ? 'Complet' : 'Je participe'}
            </button>
        </div>
    `;
}

function showNotification(title, message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} notification-icon"></i>
        <div class="notification-content">
            <p class="notification-title">${title}</p>
            <p class="notification-message">${message}</p>
        </div>
        <button class="notification-close">
            <i class="fas fa-times"></i>
        </button>
    `;

    document.body.appendChild(notification);
    notification.offsetHeight;
    setTimeout(() => notification.classList.add('show'), 10);

    const closeBtn = notification.querySelector('.notification-close');
    closeBtn.addEventListener('click', () => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    });

    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

function displayEmptyShop(container) {
    container.innerHTML = `
        <div class="boutique-empty">
            <img src="./assets/images/calendrier-empty.jpg" alt="Boutique vide"
                 onerror="this.onerror=null; this.src='${DEFAULT_IMAGE}';">
            <p>Aucun événement n'est prévu pour l'instant.</p>
            <p class="subtitle">Revenez bientôt, nous faisons en sorte de réaliser des activités régulièrement !</p>
        </div>
    `;
}

function displayError(message) {
    const evenementApp = document.getElementById('evenement-app');
    evenementApp.innerHTML = `
        <div class="error-container">
            <i class="fas fa-exclamation-triangle"></i>
            <p>${message}</p>
            <button onclick="loadEvents()" class="btn-retry">
                Réessayer
            </button>
        </div>
    `;
}

function displayEmptyEvents() {
    const evenementApp = document.getElementById('evenement-app');
    evenementApp.innerHTML = `
        <div class="empty-events">
            <img src="/assets/images/calendrier-empty.jpg" 
                 alt="Aucun événement" 
                 onerror="this.src='${DEFAULT_IMAGE}'">
            <h2>Aucun événement prévu pour le moment</h2>
            <p>Notre équipe travaille à l'organisation de nouveaux événements.</p>
            <p class="subtitle">Revenez bientôt pour découvrir nos prochaines activités !</p>
        </div>
    `;
}

document.addEventListener('DOMContentLoaded', function() {
    // Charger les événements initiaux
    loadEvents();

    // Gestion des clics sur les cartes d'événements
    document.addEventListener('click', function(e) {
        const card = e.target.closest('.evenement-card');
        if (card) {
            const eventId = card.dataset.eventId;
            // Mettre à jour les détails de l'événement
            const event = EVENTS_DATA.find(event => event.id === parseInt(eventId));
            if (event) {
                showEventDetails(event);
            }
        }
    });

    // Gestion des boutons "Participer"
    document.addEventListener('click', async function(e) {
        const button = e.target.closest('.btn-participer');
        if (button && !button.disabled) {
            e.stopPropagation();
            
            const evenementId = button.dataset.id;
            try {
                const response = await fetch('/evenement.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        evenement_id: evenementId,
                        action: 'participer'
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    showNotification(
                        'Super !',
                        'Votre participation a bien été enregistrée',
                        'success'
                    );
                    button.disabled = true;
                    button.textContent = 'Inscrit';
                } else {
                    showNotification(
                        'Attention',
                        result.message || 'Une erreur est survenue',
                        'warning'
                    );
                }
            } catch (error) {
                showNotification(
                    'Erreur',
                    'Une erreur est survenue lors de l\'inscription',
                    'error'
                );
            }
        }
    });
});

function updateEventSummary(eventId) {
    const evenement = document.querySelector(`.evenement-card[data-event-id="${eventId}"]`);
    const details = document.getElementById('event-details');
    
    if (evenement && details) {
        const titre = evenement.querySelector('.evenement-title').textContent;
        const date = evenement.querySelector('.date').textContent;
        const description = evenement.querySelector('p').textContent;
        const places = evenement.querySelector('.places').textContent;
        const prix = evenement.querySelector('.prix').textContent;

        details.innerHTML = `
            <h2>${titre}</h2>
            <div class="event-details-content">
                <div class="event-info">
                    <p><strong>Date:</strong> ${date}</p>
                    <p><strong>Places:</strong> ${places}</p>
                    <p><strong>Prix:</strong> ${prix}</p>
                </div>
                <div class="event-description">
                    <h3>Description</h3>
                    <p>${description}</p>
                </div>
            </div>
        `;
        
        // Afficher le conteneur de détails
        details.classList.remove('hidden');
    }
}
