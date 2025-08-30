<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kijelentkezés</title>
</head>
<body>
<script>
    // Token törlése
    localStorage.removeItem("jwt_token");
    sessionStorage.removeItem("jwt_token");

    // Átirányítás login oldalra
    window.location.href = "index.php";
</script>
</body>
</html>

