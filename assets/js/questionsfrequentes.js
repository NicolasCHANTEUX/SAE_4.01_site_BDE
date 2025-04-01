// Données des questions fréquentes
const FAQ_DATA = [
    {
        question: "Quelle est la politique de retour ?",
        reponse: "Vous pouvez retourner un produit dans les 30 jours suivant l'achat."
    },
    {
        question: "Comment puis-je suivre ma commande ?",
        reponse: "Vous pouvez suivre votre commande via le lien envoyé par email après l'achat."
    },
    {
        question: "Quels sont les moyens de paiement acceptés ?",
        reponse: "Nous acceptons les paiements par carte bancaire, PayPal et virement bancaire."
    },
    {
        question: "Comment contacter le support client ?",
        reponse: "Vous pouvez nous contacter via le formulaire de contact ou par email à support@bde.com."
    }
];

// Fonction pour afficher les questions fréquentes
function loadFAQ() {
    const faqContainer = document.querySelector('.faq-container');

    if (!faqContainer) {
        console.error("Impossible de trouver l'élément .faq-container");
        return;
    }

    faqContainer.innerHTML = FAQ_DATA.map(faq => createFAQItem(faq)).join('');

    // Ajouter les gestionnaires d'événements pour les questions
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        const arrow = item.querySelector('.faq-arrow');

        question.addEventListener('click', () => {
            const isActive = answer.classList.toggle('active');
            arrow.classList.toggle('rotated', isActive);

            // Ajuster la hauteur pour une animation fluide
            if (isActive) {
                answer.style.maxHeight = answer.scrollHeight + 'px';
            } else {
                answer.style.maxHeight = null;
            }
        });
    });
}

// Fonction pour créer un élément HTML pour une question fréquente
function createFAQItem(faq) {
    return `
        <div class="faq-item">
            <div class="faq-question">
                <span>${faq.question}</span>
                <i class="fas fa-chevron-right faq-arrow"></i>
            </div>
            <div class="faq-answer">
                <p>${faq.reponse}</p>
            </div>
        </div>
    `;
}

// Charger les questions fréquentes au chargement de la page
document.addEventListener('DOMContentLoaded', loadFAQ);