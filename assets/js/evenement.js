const DEFAULT_IMAGE = './assets/images/product-default.jpg';

// Données de test pour les événements
const TEST_EVENTS = [
    {
        id: 1,
        nom: "Bowling",
        prix: 10.00,
        image: "./assets/images/product-default.jpg",
        description: "Partie de bowling avec le BDE",
		addresse: "10 rue de la Paix, Paris",
		duree: "2 heures",
		date: "2023-09-01"
    },
    {
        id: 2,
        nom: "Poker",
        prix: 0,
		image: "./assets/images/product-default.jpg",
        description: "Sweat chaud et confortable avec logo du BDE",
		addresse: "10 rue de la Paix, Paris",
		duree: "3 heures",
		date: "2025-05-01"
    },
    {
        id: 3,
        nom: "Minigolf",
        prix: 8.99,
		image: "./assets/images/product-default.jpg",
        description: "Mug en céramique avec logo du BDE",
		addresse: "10 rue de la Paix, Paris",
		duree: "2 heures",
		date: "2025-04-03"
    },
    {
        id: 4,
        nom: "Karting",
        prix: 4.99,
		image: "./assets/images/product-default.jpg",
        description: "Lot de 5 stickers BDE",
		addresse: "10 rue de la Paix, Paris",
		duree: "1 heure",
		date: "2025-04-01"
    },
	{
        id: 5,
        nom: "Laser Game",
        prix: 9.99,
		image: "./assets/images/product-default.jpg",
        description: "Lot de 5 stickers BDE",
		addresse: "10 rue de la Paix, Paris",
		duree: "1 heure 30 minutes",
		date: "2025-09-01"
    }
];

// Fonction pour charger les événements
async function loadEvents() {
    try {
        // Simuler un délai de chargement
        await new Promise(resolve => setTimeout(resolve, 500));
        
        // Utiliser les données de test au lieu de l'API
        displayEvents(TEST_EVENTS);
        
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
    const name = event.nom || 'Produit sans nom';
    const price = event.prix || 0;
    const image = event.image || DEFAULT_IMAGE;
    const eventDate = event.date ? new Date(event.date).toLocaleDateString('fr-FR') : 'Date non définie';
    const priceDisplay = price === 0 ? 'Gratuit' : price + '€';

    return `
        <div class="evenement-card" data-event-id="${event.id}">
            <div class="evenement-image">
                <img src="${image}" alt="${name}" 
                     onerror="this.onerror=null; this.src='${DEFAULT_IMAGE}';">
            </div>
            <h3 class="evenement-title">${name}</h3>
            <p class="evenement-date">${eventDate}</p>
            <p class="evenement-price">${priceDisplay}</p>
        </div>
    `;
}

function showEventDetails(event) {
    const detailsContainer = document.getElementById('event-details');
    detailsContainer.classList.remove('hidden');
    
    const eventDate = new Date(event.date);
    const formattedDate = eventDate.toLocaleDateString('fr-FR', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
    
    detailsContainer.innerHTML = `
        <h2>${event.nom}</h2>
        <div class="event-details-content">
            <div class="event-details-item">
                <span class="event-details-label">Date:</span>
                <span>${formattedDate}</span>
            </div>
            <div class="event-details-item">
                <span class="event-details-label">Durée:</span>
                <span>${event.duree}</span>
            </div>
            <div class="event-details-item">
                <span class="event-details-label">Adresse:</span>
                <span>${event.addresse}</span>
            </div>
            <div class="event-details-item">
                <span class="event-details-label">Prix:</span>
                <span>${event.prix > 0 ? event.prix + '€' : 'Gratuit'}</span>
            </div>
            <div class="event-details-item">
                <span class="event-details-label">Description:</span>
                <p>${event.description}</p>
            </div>
            <button class="btn-secondary" onclick="registerForEvent(${event.id})">
                Je participe
            </button>
        </div>
    `;
}

function registerForEvent(eventId) {
    // TODO: Implement event registration
    alert('Inscription à l\'événement en cours de développement');
}

function displayEmptyShop(container) {
    container.innerHTML = `
        <div class="boutique-empty">
            <img src="./images/empty-shop.svg" alt="Boutique vide" 
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

document.addEventListener('DOMContentLoaded', loadEvents);
