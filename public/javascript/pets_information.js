document.addEventListener('DOMContentLoaded', async () => {
    try {
        // Ellenőrizzük, hogy a doki be van-e jelentkezve
        const authCheck = await fetch('../api/vet_appointments.php', {
            credentials: 'include'
        });

        if (!authCheck.ok) {
            window.location.href = 'doctor_login.php';
            return;
        }

        const authData = await authCheck.json();
        // authData visszaadja a doki adatait, ha kell
        console.log('Bejelentkezett doki:', authData);

        const textarea = document.getElementById('CommentTextArea');
        const btn = document.getElementById('CommentBtn');

        // URL-ből lekérjük az appointment_id-t
        const urlParams = new URLSearchParams(window.location.search);
        const appointmentId = urlParams.get('appointment_id');
        const statusSelect = document.getElementById('appointmentStatus');
        const cancelContainer = document.getElementById('cancelReasonContainer');
        const cancelTextarea = document.getElementById('cancelReason');
        const statusBtn = document.getElementById('statusBtn');

        if (!appointmentId) {
            alert('Hiányzó időpont azonosító');
            return;
        }

        // Lekérjük az állat és gazda adatait az appointment_id alapján
        const res = await fetch(`../api/pet_info.php?appointment_id=${appointmentId}`, {
            credentials: 'include'
        });

        const data = await res.json();

        if (!res.ok) {
            alert(data.message || 'Nincs jogosultság vagy hiba történt.');
            if (res.status === 401) window.location.href = 'doctor_login.php';
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
        statusSelect.value = data.status;
        textarea.value = data.description || '';

        // Megjegyzés frissítése
        btn.addEventListener('click', async () => {
            const note = textarea.value.trim();
            try {
                const response = await fetch(`../api/update_appointment_description.php`, {
                    method: 'POST',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ appointment_id: appointmentId, description: note })
                });

                const result = await response.json();

                if (response.ok) {
                    alert('Megjegyzés frissítve!');
                } else {
                    alert(result.message || 'Hiba történt');
                }
            } catch (error) {
                console.error(error);
                alert('Hálózati hiba');
            }
        });

        // Státuszhoz tartozó cancel mező mutatása
        statusSelect.addEventListener('change', () => {
            cancelContainer.style.display = statusSelect.value === 'canceled' ? 'block' : 'none';
        });

        // Státusz frissítés
        statusBtn.addEventListener('click', async () => {
            const status = statusSelect.value;
            const message = cancelTextarea.value.trim();

            try {
                const response = await fetch('../api/update_appointment_status.php', {
                    method: 'POST',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        appointment_id: appointmentId,
                        status: status,
                        cancel_message: status === 'canceled' ? message : ''
                    })
                });

                const result = await response.json();

                if (response.ok) {
                    alert('Státusz frissítve!');
                } else {
                    alert(result.message || 'Hiba történt');
                }
            } catch (error) {
                console.error(error);
                alert('Hálózati hiba');
            }
        });

    } catch (err) {
        console.error(err);
        alert('Hiba történt a foglalások betöltése során!');
    }
});
