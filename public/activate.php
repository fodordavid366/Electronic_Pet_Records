<?php
// activate.php
$token = $_GET['token'] ?? null;
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Fiók aktiválása</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .message { padding: 15px; border-radius: 8px; margin-top: 20px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
<h1>Fiók aktiválása</h1>
<div id="message">Folyamatban...</div>

<script>
    const token = "<?= htmlspecialchars($token, ENT_QUOTES) ?>";

    if (!token) {
        document.getElementById("message").innerHTML =
            "<div class='message error'>Hiányzik a token.</div>";
    } else {
        fetch("../api/activate.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ token: token })
        })
            .then(res => res.json().then(data => ({ status: res.status, body: data })))
            .then(({ status, body }) => {
                if (status === 200) {
                    document.getElementById("message").innerHTML =
                        "<div class='message success'>" + body.message + "</div>";
                } else {
                    document.getElementById("message").innerHTML =
                        "<div class='message error'>" + body.message + "</div>";
                }
            })
            .catch(err => {
                document.getElementById("message").innerHTML =
                    "<div class='message error'>Hiba történt a szerverrel való kommunikáció során.</div>";
                console.error(err);
            });
    }
</script>
</body>
</html>
