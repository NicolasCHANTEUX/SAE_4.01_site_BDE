const API_URL = 'http://localhost:8000';

// Fonction pour charger le contenu dynamiquement
async function loadContent(path) {
    try {
        console.log(`Tentative de chargement: ${API_URL}${path}`);
        const response = await fetch(`${API_URL}${path}`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        console.log('Données reçues:', data);
        return data;
    } catch (error) {
        console.error('Erreur détaillée:', error);
        document.getElementById('app').innerHTML = `
            <div class="error-message">
                Erreur de chargement: ${error.message}
            </div>`;
        return null;
    }
}

// Gestionnaire de routes simple
function handleRoute() {
    const hash = window.location.hash || '#accueil';
    console.log('Route actuelle:', hash);
    const app = document.getElementById('app');
    const forms = document.getElementById('forms');
    
    // Ne cache le formulaire que s'il existe
    if (forms) {
        forms.style.display = 'none';
    }
    
    // Attendre que le contenu soit chargé avant de continuer
    return new Promise(async (resolve) => {
        switch(hash) {
            case '#accueil':
                app.innerHTML = '<h2>Bienvenue sur le site du BDE</h2>';
                break;
                
            case '#evenements':
                const events = await loadContent('/api/events');
                if (!events || events.length === 0) {
                    app.innerHTML = `
                        <div class="evenements-container">
                            <h2>Événements à venir</h2>
                            <div class="evenements-empty">
                                <img src="assets/images/empty-calendar.svg" alt="Aucun événement" />
                                <p>Aucun événement n'est programmé pour le moment</p>
                                <p class="subtitle">Revenez bientôt pour découvrir nos prochains événements !</p>
                            </div>
                        </div>
                    `;
                } else {
                    app.innerHTML = `
                        <div class="evenements-container">
                            <h2>Événements à venir</h2>
                            <div class="events-grid">
                                ${events.map(event => `
                                    <div class="event-card">
                                        <h3>${event.titre}</h3>
                                        <p>${event.description}</p>
                                        <p>Date: ${new Date(event.dateEvenement).toLocaleDateString()}</p>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    `;
                }
                break;
                
            case '#boutique':
                const products = await loadContent('/api/products');
                if (!products || products.length === 0) {
                    app.innerHTML = `
                        <div class="boutique-container">
                            <h2>Notre boutique</h2>
                            <div class="boutique-empty">
                                <img src="assets/images/empty-shop.svg" alt="Boutique vide" />
                                <p>Notre boutique est temporairement vide</p>
                                <p class="subtitle">Revenez bientôt pour découvrir nos nouveaux produits !</p>
                            </div>
                        </div>
                    `;
                } else {
                    app.innerHTML = `
                        <div class="boutique-container">
                            <h2>Notre boutique</h2>
                            <div class="products-grid">
                                ${products.map(product => `
                                    <div class="product-card">
                                        <div class="product-image">
                                            <img src="${product.image || 'assets/images/product-default.jpg'}" alt="${product.nom}">
                                        </div>
                                        <h3 class="product-title">${product.nom}</h3>
                                        <div class="product-footer">
                                            <span class="product-price">${product.prix}€</span>
                                            <button onclick="showOrderForm(${product.id})" class="add-to-cart">
                                                <i class="fas fa-shopping-cart"></i>
                                                Ajouter
                                            </button>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    `;
                }
                break;
                
            case '#contact':
                app.innerHTML = `
                    <div class="contact-container">
                        <h2>Nous contacter</h2>
                        <div class="contact-wrapper">
                            <form id="contactForm" class="contact-form">
                                <div class="form-group">
                                    <label for="nom">Nom</label>
                                    <input type="text" id="nom" name="nom" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" id="prenom" name="prenom" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="demande">Parlez nous de votre demande</label>
                                    <textarea id="demande" name="demande" rows="5" required></textarea>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn-primary">Envoyer</button>
                                </div>
                            </form>
                        </div>

                        <div class="social-connect-wrapper">
                            <h3>Rejoignez-nous</h3>
                            <div class="social-buttons">
                                <a href="mailto:contact@bde-iut.fr" class="btn-social">
                                    <i class="fas fa-envelope"></i> Email
                                </a>
                                <a href="https://discord.gg/" target="_blank" class="btn-social">
                                    <i class="fab fa-discord"></i> Discord
                                </a>
                                <a href="https://instagram.com/" target="_blank" class="btn-social">
                                    <i class="fab fa-instagram"></i> Instagram
                                </a>
                            </div>
                            <a href="#faq" class="btn-faq">Questions fréquemment posées</a>
                        </div>
                    </div>
                `;
                document.getElementById('contactForm').addEventListener('submit', handleContactSubmit);
                break;

            case '#faq':
                const faqs = await loadContent('/api/faq');
                if (!faqs || faqs.length === 0) {
                    app.innerHTML = `
                        <div class="faq-container">
                            <h2>Questions fréquentes</h2>
                            <div class="faq-empty">
                                <img src="assets/images/empty-faq.svg" alt="Aucune question" />
                                <p>Aucune question fréquente n'est disponible pour le moment</p>
                                <p class="subtitle">N'hésitez pas à nous contacter directement !</p>
                            </div>
                        </div>
                    `;
                } else {
                    app.innerHTML = `
                        <div class="faq-container">
                            <h2>Questions fréquentes</h2>
                            <div class="faq-list">
                                ${faqs.map(faq => `
                                    <div class="faq-item">
                                        <div class="faq-question" onclick="toggleFAQ(this)">
                                            <h3>${faq.question}</h3>
                                            <i class="fas fa-chevron-left"></i>
                                        </div>
                                        <div class="faq-answer">
                                            <p>${faq.reponse}</p>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    `;
                }
                break;
        }
        resolve();
    });
}

// Fonction utilitaire pour afficher le formulaire de commande
function showOrderForm(productId) {
    const forms = document.getElementById('forms');
    forms.style.display = 'block';
    const orderForm = document.getElementById('orderForm');
    orderForm.style.display = 'block';
    orderForm.querySelector('select[name="produit"]').value = productId;
}

// Ajouter cette fonction après les autres déclarations de fonctions
function setupNavigation() {
    document.querySelectorAll('nav a').forEach(link => {
        link.addEventListener('click', async (e) => {
            e.preventDefault();
            const hash = link.getAttribute('href');
            window.location.hash = hash;
            await handleRoute(); // Attendre que la route soit traitée
        });
    });
}

// Modifier l'écouteur d'événements
window.addEventListener('hashchange', async (e) => {
    e.preventDefault(); // Empêcher le comportement par défaut
    await handleRoute();
});

window.addEventListener('load', async () => {
    await handleRoute();
    setupNavigation();
});

// Fonction pour envoyer une requête sécurisée
async function sendSecureRequest(url, formData) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    formData.append('csrf_token', csrfToken);
    
    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
            credentials: 'include'
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return await response.json();
    } catch (error) {
        console.error('Erreur:', error);
        throw error;
    }
}

// Gestionnaire de formulaires
function handleForms() {
    document.getElementById('loginForm')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        console.log('Tentative de connexion...');
        try {
            const formData = new FormData(e.target);
            const data = await sendSecureRequest(`${API_URL}/api/login`, formData);
            
            if (data.success) {
                localStorage.setItem('user', JSON.stringify(data.user));
                handleRoute();
            } else {
                alert(data.error || 'Erreur de connexion');
            }
        } catch (error) {
            alert('Erreur lors de la connexion');
        }
    });

    document.getElementById('orderForm')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        console.log('Tentative de commande...');
        const formData = new FormData(e.target);
        try {
            const data = await sendSecureRequest(`${API_URL}/api/commande`, formData);
            alert(data.success ? 'Commande effectuée!' : 'Erreur');
        } catch (error) {
            alert('Erreur lors de la commande');
        }
    });
}

handleForms();

// Ajouter ces nouvelles fonctions à la fin du fichier
async function handleContactSubmit(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    try {
        const response = await sendSecureRequest(`${API_URL}/api/contact`, formData);
        if (response.success) {
            alert('Message envoyé avec succès !');
            e.target.reset();
        } else {
            alert(response.error || 'Erreur lors de l\'envoi du message');
        }
    } catch (error) {
        alert('Erreur lors de l\'envoi du message');
    }
}

// Ajouter cette fonction pour gérer l'expansion des questions
function toggleFAQ(element) {
    const answer = element.nextElementSibling;
    const arrow = element.querySelector('i');
    
    // Toggle les classes active
    arrow.classList.toggle('active');
    answer.classList.toggle('active');
    
    // Gestion de la hauteur
    if (answer.style.maxHeight) {
        answer.style.maxHeight = null;
    } else {
        answer.style.maxHeight = answer.scrollHeight + "px";
    }
}
