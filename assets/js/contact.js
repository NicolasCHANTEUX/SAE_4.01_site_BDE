document.addEventListener('DOMContentLoaded', () => {
    const contactForm = document.getElementById('contactForm');
    const messageResult = document.getElementById('messageResult');
    
    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            try {
                const formData = new FormData(contactForm);
                const response = await fetch('/contact/envoyer', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                });

                const result = await response.json();

                if (result.success) {
                    messageResult.innerHTML = `
                        <div class="alert alert-success">
                            ${result.message}
                        </div>
                    `;
                    contactForm.reset();
                } else {
                    messageResult.innerHTML = `
                        <div class="alert alert-danger">
                            ${result.message}
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Erreur:', error);
                messageResult.innerHTML = `
                    <div class="alert alert-danger">
                        Une erreur est survenue lors de l'envoi du message
                    </div>
                `;
            }
        });
    }
});
