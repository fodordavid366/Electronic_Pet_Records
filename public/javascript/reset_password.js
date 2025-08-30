document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("setNewPasswordForm");
    const alertBox = document.getElementById("alertBox");

    // Kivesszük a token-t a query stringből
    const params = new URLSearchParams(window.location.search);
    const token = params.get("token");

    if (!token) {
        alertBox.textContent = "Hiányzó vagy érvénytelen token!";
        alertBox.className = "alert alert-danger mt-3";
        alertBox.classList.remove("d-none");
        form.querySelector("button").disabled = true;
        return;
    }

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const new_password = document.getElementById("new_password").value;
        const new_password_verify = document.getElementById("new_password_verify").value;

        try {
            const response = await fetch("../api/reset_password_request.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ token, new_password, new_password_verify })
            });

            const result = await response.json();

            alertBox.textContent = result.message;
            alertBox.className = `alert alert-${result.success ? "success" : "danger"} mt-3`;
            alertBox.classList.remove("d-none");

            if (result.success) {
                setTimeout(() => window.location.href = "login.php", 2000);
            }

        } catch (err) {
            console.error(err);
            alertBox.textContent = "Hiba történt, próbáld újra!";
            alertBox.className = "alert alert-danger mt-3";
            alertBox.classList.remove("d-none");
        }
    });
});
