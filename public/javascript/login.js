document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("loginForm");
    const alertBox = document.getElementById("loginAlert");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        // inputok
        const email = document.getElementById("member-login-number").value.trim();
        const password = document.getElementById("member-login-password").value.trim();
        const rememberMe = document.getElementById("flexCheckDefault").checked;

        // kliens oldali validáció
        if (email === "" || password === "") {
            showError("Az email és a jelszó megadása kötelező!");
            return;
        }
        if (email.length > 60) {
            showError("Az email túl hosszú (max 60 karakter).");
            return;
        }

        try {
            const response = await fetch("../api/login.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ email, password })
            });

            const result = await response.json();

            if (response.ok) {
                // sikeres login → token tárolása
                const storage = rememberMe ? localStorage : sessionStorage;
                storage.setItem("jwt_token", result.token);

                // átirányítás
                window.location.href = "index.php";
            } else {
                showError(result.message || "Hibás bejelentkezés");
            }
        } catch (err) {
            console.error("Login error:", err);
            showError("Szerverhiba történt, próbáld újra.");
        }
    });

    function showError(message) {
        alertBox.textContent = message;
        alertBox.classList.remove("d-none");
    }
});
