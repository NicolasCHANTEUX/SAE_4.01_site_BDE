const API_URL = 'http://localhost:8000';

async function handleContactSubmit(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    try {
        const response = await fetch(`${API_URL}/contact`, {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        
        if (data.success) {
            alert('Message envoyé avec succès !');
            e.target.reset();
        } else {
            alert(data.error || 'Erreur lors de l\'envoi du message');
        }
    } catch (error) {
        alert('Erreur lors de l\'envoi du message');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', handleContactSubmit);
    }
});
