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
    <link rel="stylesheet" href="css/reservation_css.css?v=1">
    <link rel="stylesheet" href="css/navigation_bar_css.css?v=1">

    <title>Foglalás</title>
</head>
<body>

<div class="header">
    <!--                Navbar-->
    <?php include 'navigation_bar.php'; ?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-center text-lg-start">
                <h1>Találja meg a tökéletes orvost kedvenceinek</h1>
                <p class="my-4">
                    Better high-touch digital model for maternity and improve digital engagement facility care is designed for convenient services.
                </p>
                <button class="btn btn-primary me-3">Make Appointment</button>
                <button class="btn btn-outline-dark">Watch Video</button>
            </div>
            <div class="col-lg-6 text-center">
                <img src="images/doctor5.jpg" alt="Doctor">
            </div>
        </div>
    </div>
</section>

<!-- Specialities -->
<form class="specialities text-center" action="#" method="post">
    <div class="container">
        <h2>Milyen gondokkal küzd kedvence</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-6 col-md-2">
                <label class="speciality-card">
                    <input type="radio" name="service" value="Oltások és megelőzés" hidden>
                    <img src="https://img.icons8.com/ios/100/000000/bone.png" alt=""><br>
                    Oltások és megelőzés
                </label>
            </div>
            <div class="col-6 col-md-2">
                <label class="speciality-card">
                    <input type="radio" name="service" value="Emésztési gondok" hidden>
                    <img src="https://img.icons8.com/ios/100/000000/back-view.png" alt=""><br>
                    Emésztési gondok
                </label>
            </div>
            <div class="col-6 col-md-2">
                <label class="speciality-card">
                    <input type="radio" name="service" value="Bőr- és szőrproblémák" hidden>
                    <img src="https://img.icons8.com/ios/100/000000/brain.png" alt=""><br>
                    Bőr- és szőrproblémák
                </label>
            </div>
            <div class="col-6 col-md-2">
                <label class="speciality-card">
                    <input type="radio" name="service" value="Sérülések és balesetek" hidden>
                    <img src="https://img.icons8.com/ios/100/000000/shoulder.png" alt=""><br>
                    Sérülések és balesetek
                </label>
            </div>
            <div class="col-6 col-md-2">
                <label class="speciality-card">
                    <input type="radio" name="service" value="Mozgásszervi gondok" hidden>
                    <img src="https://img.icons8.com/ios/100/000000/scale.png" alt=""><br>
                    Mozgásszervi gondok
                </label>
            </div>
            <div class="col-6 col-md-2">
                <label class="speciality-card">
                    <input type="radio" name="service" value="Fog- és szájüregi problémák" hidden>
                    <img src="https://img.icons8.com/ios/100/000000/headache.png" alt=""><br>
                    Fog- és szájüregi problémák
                </label>
            </div>
        </div>
    </div>
<div class="bg-body py-4 my-4"></div>

<!-- Booking Section -->
<div class="booking text-center">
    <div class="container">
        <h2>Foglalás</h2>
        <div class="row g-3 justify-content-center">
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Patient Name">
            </div>
            <div class="col-md-3">
                <select name="cars" id="cars" class="form-control">
                    <option disabled="disabled" selected="selected">Válassza ki kedvencét</option>
                    <option value="volvo">Volvo</option>
                    <option value="saab">Saab</option>
                    <option value="opel">Opel</option>
                    <option value="audi">Audi</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" id="birth_date" name="birth_date" class="form-control" required>
            </div>
            <div class="col-md-2">
                <select class="form-select">
                    <option selected>Choose Specialist</option>
                    <option>Orthopedist</option>
                    <option>Neurologist</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Időpontok keresése</button>
            </div>
        </div>
    </div>
</div>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
