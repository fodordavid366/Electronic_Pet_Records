document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('registerForm');
    const resetBtn = document.getElementById('resetBtn');
    const lastName = document.getElementById('lastname');
    const firstName = document.getElementById('firstname');
    const phone = document.getElementById('phone');
    const birthDate = document.getElementById('birth_date');
    const emailNotify = document.getElementById('emailNotify');

    let originalData = {};

    // Betöltjük a profiladatokat
    fetch('../api/profile_update.php', {
        method: 'GET',
        headers: { 'Authorization': 'Bearer ' + sessionStorage.getItem('jwt_token') }
    })
        .then(res => res.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
                return;
            }

            lastName.value = data.last_name || '';
            firstName.value = data.first_name || '';
            phone.value = data.phone_number || '';
            birthDate.value = data.birth_date || '';
            emailNotify.checked = data.email_notify === 1; // feltételezzük, hogy az API visszaadja

            originalData = data;
        })
        .catch(err => {
            console.error(err);
            alert('Hiba történt az adatok lekérésekor.');
        });

    // Reset gomb
    resetBtn.addEventListener('click', (e) => {
        lastName.value = originalData.last_name || '';
        firstName.value = originalData.first_name || '';
        phone.value = originalData.phone_number || '';
        birthDate.value = originalData.birth_date || '';
        emailNotify.checked = originalData.email_notify === 1;
    });

    // Form elküldése (frissítés)
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const payload = {
            last_name: lastName.value.trim(),
            first_name: firstName.value.trim(),
            phone_number: phone.value.trim(),
            birth_date: birthDate.value,
            email_notify: emailNotify.checked ? 1 : 0
        };
        // **Kliens oldali validáció**
        if (payload.first_name.length > 40) { alert('Keresztnév túl hosszú.'); return; }
        if (payload.last_name.length > 40) { alert('Vezetéknév túl hosszú.'); return; }
        if (!/^[0-9+\-\s]+$/.test(payload.phone_number) || payload.phone_number.length > 13) { alert('Érvénytelen telefonszám.'); return; }
        const d = new Date(payload.birth_date);
        if (isNaN(d.getTime()) || payload.birth_date !== d.toISOString().split('T')[0]) { alert('Érvénytelen születési dátum.'); return; }

        try {
            const response = await fetch('../api/profile_update.php', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + sessionStorage.getItem('jwt_token')
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            if (response.ok) {
                alert('Profil sikeresen frissítve!');
            } else {
                alert(result.message || 'Hiba történt a frissítés során.');
            }
        } catch (err) {
            console.error(err);
            alert('Hálózati hiba történt.');
        }
    });
});
