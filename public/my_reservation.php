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
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css?v=1">
    <link rel="stylesheet" href="css/navigation_bar_css.css?v=1">

    <title>Foglalásaim</title>

</head>
<body class="bg-light">
<div class="header">
    <!--                Navbar-->
    <?php include 'navigation_bar.php'; ?>
<div class="container-fluid py-5">
    <div class="row g-4">

        <div>

            <!--                PROFILE -->
                            <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Bejelentkezés</h5>

                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>

                                <div class="offcanvas-body d-flex flex-column">
                                    <form class="custom-form member-login-form" action="#" method="post" role="form">

                                        <div class="member-login-form-body">
                                            <div class="mb-4">
                                                <label class="form-label mb-2" for="member-login-number">Email</label>

                                                <input type="text" name="member-login-number" id="member-login-number" class="form-control" placeholder="Email" required>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label mb-2" for="member-login-password">Jelszó</label>

                                                <input type="password" name="member-login-password" id="member-login-password" pattern="[0-9a-zA-Z]{4,10}" class="form-control" placeholder="Jelszó" required="">
                                            </div>

                                            <div class="form-check mb-4">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">

                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Emlékezz rám
                                                </label>
                                            </div>

                                            <div class="col-lg-5 col-md-7 col-8 mx-auto">
                                                <button type="submit" class="form-control">Bejelentkezés</button>
                                            </div>

                                            <div class="text-center my-4">
                                                <a href="#">Elfelejtetted a jelszavad?</a>
                                            </div>

                                            <div class="col-lg-5 col-md-7 col-8 mx-auto mt-5">
                                                <button type="submit" class="form-control">Regisztráció</button>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="mt-auto mb-5">
                                        <p>
                                            <strong class="text-black me-3">Kérdése van felénk?</strong>

                                            <a href="tel: 010-020-0340" class="contact-link">
                                                010-020-0340
                                            </a>
                                        </p>
                                    </div>
                                </div>

<!--                                WAVES-->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#3D405B" fill-opacity="1" d="M0,224L34.3,192C68.6,160,137,96,206,90.7C274.3,85,343,139,411,144C480,149,549,107,617,122.7C685.7,139,754,213,823,240C891.4,267,960,245,1029,224C1097.1,203,1166,181,1234,160C1302.9,139,1371,117,1406,106.7L1440,96L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path></svg>
                            </div>



        <!-- DataTables -->
            <div class="row justify-content-center">
        <div class="col-lg-8 col-12">
            <div class="card shadow-sm p-3 mt-5">
                <h4 class="mb-3">Foglalásaim</h4>
                <div class="table-responsive">
                    <table id="bookingsTable" class="table table-striped table-bordered align-middle">
                        <thead class="table-dark">
                        <tr>
                            <th>Orvos</th>
                            <th>Dátum</th>
                            <th>Időpont</th>
                            <th>Vizsgálat típusa</th>
                            <th>Állapot</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Dr. Nagy Emese</td>
                            <td>2025-09-10</td>
                            <td>14:00</td>
                            <td>Egzotikus állatok vizsgálata</td>
                            <td>Várólista</td>
                        </tr>
                        <tr>
                            <td>Dr. Kiss Péter</td>
                            <td>2025-09-12</td>
                            <td>10:30</td>
                            <td>Általános állatorvosi vizsgálat</td>
                            <td>Megerősítve</td>
                        </tr>
                        <tr>
                            <td>Dr. Nagy Emese</td>
                            <td>2025-09-15</td>
                            <td>16:00</td>
                            <td>Egzotikus állatok oltása</td>
                            <td>Várólista</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery (DataTables szükséges) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#bookingsTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/Hungarian.json"
            },
            "pageLength": 5,
            "lengthChange": false
        });
    });
</script>




<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="javascript/js.js"></script>
</body>
</html>