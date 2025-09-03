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
    <link rel="stylesheet" href="css/reservation_css.css?v=1">
    <link rel="stylesheet" href="css/navigation_bar_css.css?v=1">

    <title>Kezdőoldal</title>
</head>
<body>


    <div class="header">
<!--                Navbar-->
        <?php include 'navigation_bar.php'; ?>

<!--        Content before waves-->
        <div class="inner-header flex">
            <div class="container mt-5">
                <div class="row">

<!--                                        Paws-->
                    <div class="paw-container">
                        <span class="paw paw-a"></span>
                        <span class="paw paw-b"></span>
                        <span class="paw paw-c"></span>
                        <span class="paw paw-d"></span>
                    </div>

                    <div class="col-lg-6 col-12 mb-5 mb-lg-0 mt-5">
                        <h1 class="cd-headline rotate-1 text-white mb-4 pb-2">
                            <span>A kedvenc</span>
                            <span class="cd-words-wrapper">
                                    <b class="is-visible">Boldog</b>
                                    <b>Egészséges</b>
                                    <b>Szeretett</b>
                                </span>
                        </h1>

                        <h2 class="text-white">Találja meg a tökéletes gondoskodást kisállatának</h2>
                    </div>

                    <div class="col-lg-6 col-12 mt-5">
                        <div class="ratio" style="--bs-aspect-ratio: 60%;">
                            <img src="images/doctor.png" class="d-block w-25 h-80 ms-5" alt="doctor">
                        </div>
                    </div>

                </div>
            </div>
        </div>

<!--        Waves Container-->
        <div>


<!--            Section 1-->
                <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">

                    <div class="section-overlay"></div>



            <svg class="waves" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-35z"></path>
                </defs>

                <g class="parallax">
<!--                    #1-->
                    <use
                            xlink:href="#gentle-wave"
                            x="48"
                            y="0"
                            fill="rgba(255, 255, 255, 0.7)"
                        ></use>
<!--                    #2-->
                    <use
                            xlink:href="#gentle-wave"
                            x="48"
                            y="3"
                            fill="rgba(255, 255, 255, 0.5)"
                    ></use>
<!--                    #3-->
                    <use
                            xlink:href="#gentle-wave"
                            x="48"
                            y="5"
                            fill="rgba(255, 255, 255, 0.3)"
                    ></use>
<!--                    #4-->
                    <use
                            xlink:href="#gentle-wave"
                            x="48"
                            y="7"
                            fill="#fff"
                    ></use>
                </g>
            </svg>
        </div>



<!--        Content-->
        <div class="content flex">

        </div>

    <section id="section2" class="position-relative d-flex flex-column justify-content-center align-items-center" style="height: 75vh; background-color: #f0f0f0;">

        <div class="col-lg-12 col-12 mt-5 d-flex align-items-center justify-content-center">
            <h2 class="mb-lg-5">Kiegészítőink</h2>
        </div>

        <!-- Desktop félkör gombok -->
        <div class="side-buttons left-buttons d-none d-lg-block">
            <button class="btn btn-outline-primary mb-2">
                <img src="images/acc4.png" alt="" style="width:80px; height:80px; margin-right:5px;">
            </button>
            <button class="btn btn-outline-primary mb-2">
                <img src="images/acc5.png" alt="" style="width:80px; height:80px; margin-left:-5px;">
            </button>
            <button class="btn btn-outline-primary mb-2">
                <img src="images/acc6.png" alt="" style="width:80px; height:80px; margin-right:5px;">
            </button>
        </div>

        <div class="side-buttons right-buttons d-none d-lg-block">
            <button class="btn btn-outline-primary mb-2">
                <img src="images/acc1.png" alt="" style="width:80px; height:80px; margin-right:5px;">
            </button>
            <button class="btn btn-outline-primary mb-2">
                <img src="images/acc2.png" alt="" style="width:80px; height:80px; margin-left:-7px;">
            </button>
            <button class="btn btn-outline-primary mb-2">
                <img src="images/acc3.png" alt="" style="width:80px; height:50px; margin-left:-5px;">
            </button>
        </div>

        <!-- MIDDLE PICTURE -->
        <img src="images/index3.png" alt="middle_pic" class="img-fluid" style="max-height: 400px;">

        <!-- Mobilra szánt gombok középen, egymás alatt -->
        <div class="d-block d-lg-none mt-4 text-center">
            <div class="mb-2">
                <button class="btn btn-primary mb-1">Bal 1</button>
                <button class="btn btn-primary mb-1">Bal 2</button>
                <button class="btn btn-primary mb-1">Bal 3</button>
            </div>
            <div>
                <button class="btn btn-primary mb-1">Jobb 1</button>
                <button class="btn btn-primary mb-1">Jobb 2</button>
                <button class="btn btn-primary mb-1">Jobb 3</button>
            </div>
        </div>
    </section>

<!--    About us-->
    <section class="events-section section-bg section-padding" id="section_4">

            <div class="row">

                <div class="col-lg-12 col-12 mt-5">
                    <h2 class="mb-lg-5">Ismerje meg szakorvosainkat</h2>
                </div>

            <div class="hero">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1>Találja meg a tökéletes orvost kedvenceinek</h1>
                            <p class="my-4">
                                Minden kisállat megérdemli a legjobb orvost – mi segítünk megtalálni
                            </p>
                            <button class="btn btn-primary me-3"><a style="text-decoration: none" href="reservation.php">Bővebben</a></button>
                        </div>
                        <div class="col-lg-6 text-center">
                            <img src="images/doctor5.jpg" alt="Doctor">
                            <img src="images/asd.png" alt="Doctor">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!--    Footer-->
    <footer class="site-footer">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-12 me-auto mb-5 mb-lg-0">
                    <a class="navbar-brand d-flex align-items-center" href="index.php">
                        <img src="images/logo.png" class="navbar-brand-image img-fluid" alt="logo">
                        <span class="navbar-brand-text">
                               Mancs
                                <small>Tár</small>
                            </span>
                    </a>
                </div>

                <div class="col-lg-3 col-12">
                    <h5 class="site-footer-title mb-4 mt-3">Munkaidő</h5>

                    <p class="d-flex border-bottom pb-3 mb-3 me-lg-3">
                        <span>Hétfő-Péntek 6:00 - 20:00</span>
                    </p>

                    <p class="d-flex me-lg-3">
                        <span>Szombat-Vasárnap  7:00 - 17:00</span>
                    </p>
                    <br>
                    <p class="copyright-text">Copyright ©</p>
                </div>

                <div class="col-lg-2 col-12 ms-auto">
                    <ul class="social-icons d-flex justify-content-center justify-content-lg-start mt-lg-5 mt-3 mb-4 p-0">
                        <li class="me-3">
                            <a href="https://www.linkedin.com" target="_blank" class="social-icon-link bi bi-linkedin"></a>
                        </li>
                        <li class="me-3">
                            <a href="https://www.facebook.com" target="_blank" class="social-icon-link bi bi-facebook"></a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com" target="_blank" class="social-icon-link bi bi-instagram"></a>
                        </li>
                    </ul>
                </div>


            </div>
        </div>

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#62adc8" fill-opacity="1" d="M0,224L34.3,192C68.6,160,137,96,206,90.7C274.3,85,343,139,411,144C480,149,549,107,617,122.7C685.7,139,754,213,823,240C891.4,267,960,245,1029,224C1097.1,203,1166,181,1234,160C1302.9,139,1371,117,1406,106.7L1440,96L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path></svg>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="javascript/js.js"></script>
</body>
</html>
<?php
