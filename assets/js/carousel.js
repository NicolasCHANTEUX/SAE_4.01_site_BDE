document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.querySelector('.carousel');
    const items = document.querySelectorAll('.carousel-item');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    let currentIndex = 0;

    function showItem(index) {
        items.forEach(item => {
            item.classList.remove('active');
            item.style.transform = 'translateX(100%)';
        });

        items[index].classList.add('active');
        items[index].style.transform = 'translateX(0)';
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

    // Afficher le premier élément
    showItem(0);
});
