document.addEventListener("DOMContentLoaded", () => {
    const menuToggle = document.getElementById("menu-toggle");
    const mobileMenu = document.getElementById("mobile-menu");

	// Ouvrir/fermer le menu déroulant
	menuToggle.addEventListener("click", () => {
		mobileMenu.classList.toggle("open");
	});

	// Mettre à jour le titre de la page actuelle
	const currentPageTitle = document.getElementById("current-page-title");
	const currentPath = window.location.pathname;

	switch (currentPath) {
		case "/":
			currentPageTitle.textContent = "Accueil";
			break;
		case "/evenement.php":
			currentPageTitle.textContent = "Événements";
			break;
		case "/boutique.php":
			currentPageTitle.textContent = "Boutique";
			break;
		case "/contact.php":
			currentPageTitle.textContent = "Contact";
			break;
		case "/connexion.php":
			currentPageTitle.textContent = "Connexion";
			break;
		default:
			currentPageTitle.textContent = "Page";
			break;
	}
});