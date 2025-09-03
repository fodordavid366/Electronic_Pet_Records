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

    <title>Profil módosítása</title>

</head>
<body class="pt-5">
<!--                Navbar-->
<?php include 'navigation_bar_admin.php'; ?>

<div class="container-fluid register-container mt-5">
    <div class="row g-4">


        <!-- PROFILES TABLE -->
        <div class="row justify-content-center">
            <div class="col-lg-8 col-12">
            <div class="card shadow-sm p-4">
                <h4 class="mb-3 text-center">Felhasználók</h4>
                <div class="table-responsive">
                    <table id="bookingsTable" class="table table-striped table-bordered align-middle">
                        <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Vezetéknév</th>
                            <th>Keresztnév</th>
                            <th>E-mail</th>
                            <th>Születési dátum</th>
                            <th>Elérhetőség</th>
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
                            <td>1985-05-12</td>
                            <td>+36 30 123 4567</td>
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


