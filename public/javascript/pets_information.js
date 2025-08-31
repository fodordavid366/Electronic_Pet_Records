document.addEventListener('DOMContentLoaded', () => {
    // URL-ből lekérjük a pet_id-t
    const urlParams = new URLSearchParams(window.location.search);
    const petId = urlParams.get('pet_id');
    if (!petId) {
        alert('Hiányzó pet_id');
        return;
    }

    fetch(`../api/pet_info.php?pet_id=${petId}`, {
        headers: { 'Authorization': 'Bearer ' + sessionStorage.getItem('jwt_token') }
    })
        .then(res => res.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
                return;
            }

            // Állat adatok
            document.getElementById('petName').textContent = data.name;
            document.getElementById('petGender').textContent = data.gender || 'N/A';
            document.getElementById('petSpecies').textContent = data.species || 'N/A';
            document.getElementById('petBreed').textContent = data.breed || 'N/A';
            document.getElementById('petBirth').textContent = data.birth_date || 'N/A';

            // Gazda adatok
            document.getElementById('ownerName').textContent = data.owner_first + ' ' + data.owner_last;
            document.getElementById('ownerBirth').textContent = data.owner_birth || 'N/A';
            document.getElementById('ownerEmail').textContent = data.owner_email || 'N/A';
            document.getElementById('ownerPhone').textContent = data.owner_phone || 'N/A';
        })
        .catch(err => {
            console.error(err);
            alert('Hiba történt az adatok lekérése közben.');
        });
});