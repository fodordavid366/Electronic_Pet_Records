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

    <title>QR kód</title>
</head>
<body>

<!-- LOGIN -->
<div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="d-flex justify-content-center align-items-center card shadow-lg p-4" style="max-width: 400px; width: 100%; z-index: 1">
        <h5 class="text-center mb-4">QR kód</h5>
        <img class="text-center" src="images/admin_log.png" alt="Logo" style="max-width: 150px;">


            <div class="mb-4">
                <div class="card shadow-sm mt-4" style="max-width: 400px;">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Beolvasott adatok</h5>
                        <p><strong>Név:</strong> <span id="qrName">-</span></p>
                        <p><strong>Rendelő:</strong> <span id="qrClinic">-</span></p>
                    </div>
                </div>
            </div>


    </div>
    <!--                    WAVES-->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"
         style="position:absolute; bottom:0; left:0; width:100%; height:auto; z-index: 0">
        <path fill="#3D405B" fill-opacity="1"
              d="M0,224L34.3,192C68.6,160,137,96,206,90.7C274.3,85,343,139,411,144C480,149,549,107,617,122.7C685.7,139,754,213,823,240C891.4,267,960,245,1029,224C1097.1,203,1166,181,1234,160C1302.9,139,1371,117,1406,106.7L1440,96L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z">
        </path>
    </svg>
</div>

<script>
    function showQRData(name, clinic) {
        document.getElementById('qrName').innerText = name;
        document.getElementById('qrClinic').innerText = clinic;
    }
</script>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="javascript/js.js"></script>
<script src="javascript/login.js"></script>

</body>
</html>
