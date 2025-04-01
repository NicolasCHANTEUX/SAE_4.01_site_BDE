document.addEventListener('DOMContentLoaded', () => {
    // Gestion du carousel
    const carousel = document.querySelector('.carousel');
    const items = document.querySelectorAll('.carousel-item');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    let currentIndex = 0;

    function showItem(index) {
        items.forEach((item, i) => {
            item.classList.remove('active');
            item.style.transform = `translateX(${(i - index) * 100}%)`;
        });

        items[index].classList.add('active');
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % items.length;
        showItem(currentIndex);
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + items.length) % items.length;
        showItem(currentIndex);
    }

    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);

    // Timer pour le défilement automatique
    let slideInterval = setInterval(nextSlide, 5000);

    // Pause le défilement au survol du carousel
    carousel.addEventListener('mouseenter', () => {
        clearInterval(slideInterval);
    });

    // Reprend le défilement quand la souris quitte le carousel
    carousel.addEventListener('mouseleave', () => {
        slideInterval = setInterval(nextSlide, 5000);
    });

    // Afficher le premier élément au chargement
    showItem(0);

    // Gestion des événements
    const evenementItems = document.querySelectorAll('.evenement-item');
    const voirPlusItem = document.querySelector('.voir-plus-item');

    // Ajouter un effet de survol pour rendre les vignettes plus interactives
    evenementItems.forEach((item) => {
        item.addEventListener('mouseover', () => {
            item.style.transform = 'scale(1.05)';
            item.style.transition = 'transform 0.3s ease';
        });

        item.addEventListener('mouseout', () => {
            item.style.transform = 'scale(1)';
        });

        // Redirection vers evenement.php au clic
        item.addEventListener('click', () => {
            window.location.href = 'evenement.php';
        });
    });

    // Ajouter une redirection au clic sur "Voir plus d'événements"
    voirPlusItem.addEventListener('click', () => {
        window.location.href = 'evenement.php';
    });
});
