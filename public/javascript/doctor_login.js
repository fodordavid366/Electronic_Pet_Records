document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const email = document.getElementById('member-login-number').value;
    const password = document.getElementById('member-login-password').value;

    try {
        const res = await fetch('../api/vet_login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password }),
            credentials: "include" // cookie fogadása
        });

        const data = await res.json();

        if (data.success) {
            window.location.href = 'doctor_reservation.php';
        } else {
            const alertEl = document.getElementById('loginAlert');
            alertEl.textContent = data.message;
            alertEl.classList.remove('d-none');
        }

    } catch (err) {
        console.error(err);
        alert("Hiba történt a bejelentkezés során!");
    }
});
