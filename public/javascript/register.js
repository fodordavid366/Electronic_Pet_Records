document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");

    // Alert doboz
    const alertBox = document.createElement("div");
    form.prepend(alertBox);

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const firstname = form.querySelector('input[name="firstname"]').value.trim();
        const lastname = form.querySelector('input[name="lastname"]').value.trim();
        const email = form.querySelector('input[name="email"]').value.trim();
        const password = form.querySelector('input[name="password"]').value;
        const password_verify = form.querySelector('input[name="password_verify"]').value;
        const phone = form.querySelector('input[name="phone"]').value.trim();
        const birth_date = form.querySelector('input[name="birth_date"]').value;

        // Client-side validációk
        if (!firstname || !lastname || !email || !password || !password_verify || !phone || !birth_date) {
            return showAlert("Minden mező kitöltése kötelező!", "danger");
        }

        if (!validateEmail(email)) {
            return showAlert("Érvénytelen e-mail cím!", "danger");
        }

        if (password !== password_verify) {
            return showAlert("A jelszavak nem egyeznek!", "danger");
        }

        if (!validatePassword(password)) {
            return showAlert("A jelszónak minimum 8 karakter hosszúnak kell lennie, tartalmaznia kell nagybetűt, kisbetűt, számot és speciális karaktert.", "danger");
        }

        if (firstname.length > 40) {
            return showAlert("A keresztnév nem lehet több, mint 40 karakter.", "danger");
        }

        if (lastname.length > 40) {
            return showAlert("A vezetéknév nem lehet több, mint 40 karakter.", "danger");
        }

        if (phone.length > 13 || !/^[0-9+\-\s]+$/.test(phone)) {
            return showAlert("A telefonszám csak számokat, plusz jelet, kötőjelet és szóközt tartalmazhat, max. 13 karakter.", "danger");
        }

        if (!validateDate(birth_date)) {
            return showAlert("Érvénytelen születési dátum!", "danger");
        }

        try {
            const response = await fetch("../api/register.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    firstname,
                    lastname,
                    email,
                    password,
                    password_verify,
                    phone,
                    birth_date
                })
            });

            const result = await response.json();

            if (response.ok) {
                showAlert(result.message, "success");
                form.reset();
            } else {
                showAlert(result.message, "danger");
            }

        } catch (err) {
            console.error(err);
            showAlert("Hiba történt, próbáld újra!", "danger");
        }
    });

    function showAlert(msg, type = "info") {
        alertBox.textContent = msg;
        alertBox.className = `alert alert-${type} mt-3`;
        alertBox.classList.remove("d-none");
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function validatePassword(password) {
        return password.length >= 8 &&
            /[A-Z]/.test(password) &&
            /[a-z]/.test(password) &&
            /[0-9]/.test(password) &&
            /[!@#$%^&*()_\-+=\[\]{};:'",.<>?\\|]/.test(password);
    }

    function validateDate(dateStr) {
        const date = new Date(dateStr);
        return !isNaN(date.getTime()) && dateStr === date.toISOString().split("T")[0];
    }
});
