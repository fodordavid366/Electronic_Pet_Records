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

    <title>Orvos foglalásai</title>

</head>
<body class="bg-light">
<div class="header">
    <!--                Navbar-->
    <?php include 'navigation_bar_doctor.php'; ?>
    <div class="container-fluid py-5">
        <div class="row g-4">

            <div>
                <!-- DataTables -->
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-12">
                        <div class="card shadow-sm p-3 mt-5">
                            <h4 class="mb-3">Pácienseim</h4>
                            <div class="table-responsive">
                                <table id="bookingsTable" class="table table-striped table-bordered align-middle">
                                    <thead class="table-dark">
                                    <tr>
                                        <th>Kedvenc</th>
                                        <th>Dátum</th>
                                        <th>Időpont</th>
                                        <th>Vizsgálat típusa</th>
                                        <th>Állapot</th>
                                        <td>Művelet</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr data-description="Ez egy kedves, három éves macska, aki imádja a játékokat és az alvást.">
                                        <td class="name">Dr. Nagy Emese</td>
                                        <td>2025-09-10</td>
                                        <td>14:00</td>
                                        <td>Egzotikus állatok vizsgálata</td>
                                        <td>Várólista</td>
                                        <td>
                                            <button class="btn btn-info btn-sm"><a  class="btn btn-info btn-sm" style="text-decoration: none" href="pets_information.php">Megnyitás</a></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dr. Kiss Péter</td>
                                        <td>2025-09-12</td>
                                        <td>10:30</td>
                                        <td>Általános állatorvosi vizsgálat</td>
                                        <td>Megerősítve</td>
                                        <td>
                                            <button class="btn btn-info btn-sm"><a class="btn btn-info btn-sm" style="text-decoration: none" href="pets_information.php">Megnyitás</a></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dr. Nagy Emese</td>
                                        <td>2025-09-15</td>
                                        <td>16:00</td>
                                        <td>Egzotikus állatok oltása</td>
                                        <td>Várólista</td>
                                        <td>
                                            <button class="btn btn-info btn-sm"><a class="btn btn-info btn-sm" style="text-decoration: none" href="pets_information.php">Megnyitás</a></button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--MODAL-->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Állat részletei</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Bezárás"></button>
                    </div>
                    <div class="modal-body" id="modalBody"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezárás</button>
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
            document.addEventListener("DOMContentLoaded", function () {

                // DataTable inicializálás Bootstrap stílusban
                const table = new DataTable("#bookingsTable", {
                    pageLength: 5,
                    lengthChange: false
                });

                // Modal kezelés: kattintás az állat nevére
                document.querySelectorAll('#bookingsTable td.name').forEach(td => {
                    td.addEventListener('click', () => {
                        const tr = td.closest('tr');
                        const name = td.textContent;
                        const description = tr.dataset.description;

                        document.getElementById('detailModalLabel').textContent = name;
                        document.getElementById('modalBody').innerHTML = `<p>${description}</p>`;

                        const myModal = new bootstrap.Modal(document.getElementById('detailModal'));
                        myModal.show();
                    });
                });

            });
        </script>


        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="javascript/js.js"></script>





</body>
</html>
