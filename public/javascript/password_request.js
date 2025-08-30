
    document.addEventListener("DOMContentLoaded", () => {
    const emailInput = document.getElementById("member-login-number");
    const btn = document.getElementById("requestNewPasswordBtn");
    const alertBox = document.getElementById("alertBox");

    btn.addEventListener("click", async () => {
    const email = emailInput.value.trim();
    if (!email) return showAlert("Adj meg egy email címet!", "danger");

    try {
    const response = await fetch("../api/forgot_password_request.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ email })
});

    const result = await response.json();
    if (response.ok) {
    showAlert(result.message, "success");
} else {
    showAlert(result.message, "danger");
}
} catch (err) {
    console.error(err);
    showAlert("Hiba történt, próbáld újra!", "danger");
}
});

    function showAlert(msg, type="info") {
    alertBox.textContent = msg;
    alertBox.className = `alert alert-${type} mt-3`;
    alertBox.classList.remove("d-none");
}
});