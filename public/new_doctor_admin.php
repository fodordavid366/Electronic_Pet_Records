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

    <title>Új orvos létrehozása</title>

</head>
<body class="pt-5">
<!--                Navbar-->
<?php include 'navigation_bar_admin.php'; ?>

<div class="container-fluid register-container mt-5">
    <div class="row g-4">

        <!-- REGISTRATION -->
        <div class="col-lg-4 col-md-5 col-12 d-flex align-items-start justify-content-center">
            <div class="w-100" style="max-width: 400px;">
                <div class="card shadow-sm p-4">
                    <h2 class="mb-4 text-center mb-5">Új orvos létrehozása</h2>

                <form id="registerForm" action="#" method="post">


                    <!-- Last Name -->
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Vezetéknév</label>
                        <input type="text" id="lastname" name="lastname" class="form-control" required>
                    </div>

                    <!-- First Name -->
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Keresztnév</label>
                        <input type="text" id="firstname" name="firstname" class="form-control" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Jelszó</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <!-- Phone number -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefonszám</label>
                        <input type="text" id="phone" name="phone" class="form-control" required>
                    </div>

                    <!-- Birthday -->
                    <div class="mb-3">
                        <label for="birth_date" class="form-label">Születési dátum</label>
                        <input type="date" id="birth_date" name="birth_date" class="form-control" required>
                    </div>

                    <!-- First Name -->
                    <div class="mb-3">
                        <label for="specialization" class="form-label">Specializáció</label>
                        <input type="text" id="specialization" name="specialization" class="form-control" required>
                    </div>

                    <!-- Buttons -->
                    <button type="submit" class="btn btn-primary w-100 mb-2">Hozzáad</button>
                    <button type="reset" class="btn btn-secondary w-100">Törlés</button>

                </form>
            </div>
        </div>
    </div>


<!-- DOCTORS TABLE -->
    <div class="col-lg-8 col-md-7 col-12">
    <div class="card shadow-sm p-4">
        <h4 class="mb-3 text-center">Orvosok</h4>
        <div class="table-responsive">
            <table id="bookingsTable" class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Vezetéknév</th>
                    <th>Keresztnév</th>
                    <th>E-mail</th>
                    <th>Jelszó</th>
                    <th>Születési dátum</th>
                    <th>Elérhetőség</th>
                    <th>Specializáció</th>
                    <th>Művelet</th>
                    <th>Művelet</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>Nagy</td>
                    <td>Emese</td>
                    <td>emese@nagy.hu</td>
                    <td>asdasd</td>
                    <td>1985-05-12</td>
                    <td>+36 30 123 4567</td>
                    <td>Egzotikus állatok</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Módosítás</button>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Törlés</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    </div>
</div>


<script src="javascript/register.js"></script>
</body>
</html><?php

