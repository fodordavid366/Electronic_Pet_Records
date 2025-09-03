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

    <title>Navigációs bár</title>
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"></a>

        <button class="navbar-toggler navbar-toogle-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <img src="images/logo.png" class="navbar-brand-image img-fluid" alt="logo">
            <span class="navbar-brand-text">
                            The name
                            <small>of the page</small>
                        </span>
            <ul class="navbar-nav ms-auto d-flex align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="#section2"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link click-scroll" href="new_doctor_admin.php">Orvosok</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link click-scroll" href="user_edit_admin.php">Jelentés</a>
                </li>

                <li class="nav-item">
                    <a class="btn custom-btn custom-border-btn rounded-pill ms-lg-3 mt-2 mt-lg-0"
                       href="admin_logout.php">
                        Kijelentkezés
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
</body>
</html>

