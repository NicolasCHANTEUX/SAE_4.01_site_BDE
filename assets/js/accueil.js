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
            const offset = index - currentIndex;

            // Ajouter ou retirer la classe "active"
            item.classList.remove("active");
            if (offset === 0) {
                item.classList.add("active");
            }

            // Positionner les articles
            item.style.transform = `translateX(${offset * 300}%)`;
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
