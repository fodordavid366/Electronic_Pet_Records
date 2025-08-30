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
    <link rel="stylesheet" href="css/style.css?v=1">
    <link rel="stylesheet" href="css/navigation_bar_css.css?v=1">

    <title>Regisztráció</title>

</head>
<body>
<!--                Navbar-->
<?php include 'navigation_bar.php'; ?>

<div class="container-fluid register-container">
    <div class="row g-0">
        <!-- Bal oldali kép -->
<!--        <div class="col-md-6 d-none d-md-block">-->
<!--            <img src="images/pet_reg.jpg" alt="Állatos kép" class="register-image">-->
<!--        </div>-->

        <!-- Jobb oldali regisztráció -->
        <div class="col-md-6 d-flex align-items-center justify-content-center p-5">
            <div class="w-100" style="max-width: 400px;">
                <h2 class="mb-4 text-center p-5">Regisztráció</h2>

<form id="" action="" method="">

<!--        Last Name-->
    <div class="mb-3">
    <label for="" class="form-label">Vezetéknév</label>
    <input type="text" id="" name="" class="form-control" required>
    </div>

<!--    First Name-->
    <div class="mb-3">
    <label for="" class="form-label">Keresztnév</label>
    <input type="text" id="" name="" class="form-control">
    </div>

<!--    Email-->
    <div class="mb-3">
    <label for="" class="form-label">Email</label>
    <input type="email" id="" name="" class="form-control">
    </div>

<!--    Password-->
    <div class="mb-3">
    <label for="" class="form-label">Jelszó</label>
    <input type="password" id="" name="" class="form-control">
    </div>

<!--    Password Confirm-->
    <div class="mb-3">
    <label for="" class="form-label">Jelszó megerősítés</label>
    <input type="password" id="" name="" class="form-control">
    </div>

<!--    Phone number-->
    <div class="mb-3">
    <label for="" class="form-label">Telefonszám</label>
    <input type="text" id="" name="" class="form-control">
    </div>

<!--    Birthday-->
    <div class="mb-3">
    <label for="">Születési dátum</label>
    <input type="date" id="" name="">
    </div>


<!--    Button-->
    <button type="submit" class="btn btn-primary w-100">Regisztráció</button>
    <button type="reset" class="btn btn-primary w-100">Törlés</button>
</form>
            </div>
        </div>
    </div>
</div>
</body>
</html><?php
