document.getElementById('passwordForm').addEventListener('submit', async function (e) {
	e.preventDefault();

	try {
		const formData = new FormData(this);
		const response = await fetch('/compte/updatePassword', {
			method: 'POST',
			body: formData
		});

		const result = await response.json();

		if (result.success) {
			// Fermer le modal
			bootstrap.Modal.getInstance(document.getElementById('passwordModal')).hide();
			// Afficher un message de succès
			alert(result.message);
		} else {
			alert(result.message);
		}
	} catch (error) {
		alert('Une erreur est survenue');
	}
});