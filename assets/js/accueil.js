document.addEventListener("DOMContentLoaded", () => {
    const carousel = document.querySelector(".carousel");
    const items = document.querySelectorAll(".carousel-item");
    const prevBtn = document.querySelector(".prev-btn");
    const nextBtn = document.querySelector(".next-btn");

    if (!carousel || !items.length || !prevBtn || !nextBtn) {
        console.error("Carousel elements not found!");
        return;
    }

    let currentIndex = 0;

    // Fonction pour mettre à jour la position des articles
    const updateCarousel = () => {
        items.forEach((item, index) => {
            const offset = (index - currentIndex + items.length) % items.length;

            // Ajouter ou retirer la classe "active"
            item.classList.remove("active");
            if (offset === 0) {
                item.classList.add("active");
            }

            // Positionner les articles
            if (offset === 0) {
                item.style.transform = `translateX(0) scale(1)`; // Article central
                item.style.opacity = "1";
            } else if (offset === 1 || offset === -items.length + 1) {
                item.style.transform = `translateX(100%) scale(0.8)`; // Article à droite
                item.style.opacity = "0.6";
            } else if (offset === items.length - 1 || offset === -1) {
                item.style.transform = `translateX(-100%) scale(0.8)`; // Article à gauche
                item.style.opacity = "0.6";
            } else {
                item.style.transform = `translateX(${offset * 100}%)`; // Articles hors de vue
                item.style.opacity = "0";
            }
        });
    };

    // Gestion du bouton "Précédent"
    prevBtn.addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + items.length) % items.length; // Boucle circulaire
        updateCarousel();
        resetTimer(); // Réinitialiser le timer
    });

    // Gestion du bouton "Suivant"
    nextBtn.addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % items.length; // Boucle circulaire
        updateCarousel();
        resetTimer(); // Réinitialiser le timer
    });

    // Timer automatique toutes les 5 secondes
    let timer = setInterval(() => {
        currentIndex = (currentIndex + 1) % items.length; // Passer au suivant
        updateCarousel();
    }, 5000);

    // Réinitialiser le timer lorsqu'une flèche est cliquée
    const resetTimer = () => {
        clearInterval(timer); // Arrêter le timer actuel
        timer = setInterval(() => {
            currentIndex = (currentIndex + 1) % items.length; // Passer au suivant
            updateCarousel();
        }, 5000); // Relancer le timer
    };

    // Initialisation
    updateCarousel();
});
