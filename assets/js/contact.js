const API_URL = 'http://localhost:8000';

document.addEventListener('DOMContentLoaded', () => {
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            try {
                const formData = new FormData(contactForm);
                const response = await fetch(`${API_URL}/contact`, {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    alert('Message envoyé avec succès !');
                    contactForm.reset();
                } else {
                    alert(result.message || 'Une erreur est survenue');
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de l\'envoi du message');
            }
        });
    }
});
