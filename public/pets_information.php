<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/pets_information_css.css?v=1">
    <link rel="stylesheet" href="css/navigation_bar_css.css?v=1">

    <title>Kedvencek adatai</title>
</head>
<body>

<!--                Navbar-->
<?php include 'navigation_bar_doctor.php'; ?>


        <div class="animal-container">
            <div class="text-center mb-3">
                <h2 class="text-center mb-4">Jelentés</h2>
                <img class="mb-4" src="images/reg2.png" alt="Animals" style="max-width: 160px;">
                <h2>Név</h2>
            </div>

            <div class="row g-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="stat-card text-center p-2">🚻<br><b>Nem</b><br>test</div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="stat-card text-center p-2">🐾<br><b>Faj</b><br>test</div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="stat-card text-center p-2">🐾<br><b>Faja</b><br>test</div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="stat-card text-center p-2">🗓️<br><b>Születési dátum</b><br>test</div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="stat-card text-center p-2">👦<br><b>Gazda neve</b><br>test</div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="stat-card text-center p-2">🗓️<br><b>Születési dátum (gazda)</b><br>test</div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="stat-card text-center p-2">📞<br><b>Elérhetőség</b><br>test</div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="stat-card text-center p-2">📧<br><b>E-mail</b><br>test</div>
                </div>
            </div>


            <div class="notes-box mt-3">
                <h3>📝 Megjegyzések</h3>
                <textarea class="form-control mb-2" placeholder="Írd ide a megjegyzésed..."></textarea>
                <div class="text-center text-md-start">
                    <button type="button" class="btn btn-primary">Frissítés</button>
                </div>
            </div>
        </div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
