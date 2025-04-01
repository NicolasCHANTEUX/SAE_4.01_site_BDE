// Fonction de validation de formulaire
function validerFormulaire(form) {
    const email = form.email.value;
    const password = form.password.value;
    let isValid = true;

    if (!email.includes('@')) {
        alert("L'adresse email n'est pas valide.");
        isValid = false;
    }

    if (password.length < 6) {
        alert("Le mot de passe doit contenir au moins 6 caractères.");
        isValid = false;
    }

    

    return isValid;
}

// JavaScript pour le formulaire de connexion
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('.login-container form');

    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault();

            if (validerFormulaire(loginForm)) {
                alert('Connexion réussie!');
            } else {
                console.log('Formulaire de connexion invalide.');
            }
        });
    }

    // JavaScript pour le formulaire d'inscription
    const signupForm = document.querySelector('.signup-container form');

    if (signupForm) {
        signupForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const confirmPassword = signupForm['confirm-password'].value;
            const password = signupForm.password.value;

            if (password !== confirmPassword) {
                alert('Les mots de passe ne correspondent pas.');
                return;
            }

            if (validerFormulaire(signupForm)) {
                alert('Inscription réussie!');
            } else {
                console.log('Formulaire d\'inscription invalide.');
            }
        });
    }
    
});
