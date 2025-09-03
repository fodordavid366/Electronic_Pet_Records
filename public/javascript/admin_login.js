document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("loginForm");
    const alertBox = document.getElementById("loginAlert");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        alertBox.classList.add("d-none");
        const email = document.getElementById("member-login-number").value;
        const password = document.getElementById("member-login-password").value;

        try {
            const res = await fetch('../api/admin_login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    'email':email,
                    'password':password
                }),
                credentials: 'same-origin'
            });

            const data = await res.json();

            if (data.success) {
                // Redirect to admin dashboard
                window.location.href = "new_doctor_admin.php";
            } else {
                alertBox.textContent = data.message;
                alertBox.classList.remove("d-none");
            }
        } catch (err) {
            console.error(err);
            alertBox.textContent = "Hiba történt a bejelentkezés sorána.";
            alertBox.classList.remove("d-none");
        }
    });
});
