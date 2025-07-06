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
    <link rel="stylesheet" href="css/style.css">

    <title>Kezdőoldal</title>
</head>
<body>
    <div class="header">
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
                            <span>Page is</span>
                            <span class="cd-words-wrapper">
                                    <b class="is-visible">Modern</b>
                                    <b>Test</b>
                                    <b>Test</b>
                                </span>
                        </h1>

                        <h2 class="text-white">Welcome to the page</h2>


                        <div class="custom-btn-group">
                            <a href="#section_2" class="btn custom-btn smoothscroll me-3">Our Story</a>

                            <a href="#section_3" class="link smoothscroll">Become a member</a>
                        </div>
                    </div>

                    <div class="col-lg-6 col-12">
                        <div class="ratio" style="--bs-aspect-ratio: 60%;">
                            <img src="images/doctor.png" class="d-block w-25 h-80 ms-5" alt="doctor">
                            <img src="images/cat.png" class="d-block w-25 h-50" alt="doctor">
                        </div>
                    </div>

                </div>
            </div>
        </div>

<!--        Waves Container-->
        <div>
                <nav class="navbar navbar-expand-lg fixed-top">
                    <div class="container">
                        <a class="navbar-brand d-flex align-items-center" href="index.php">
                            <img src="images" class="navbar-brand-image img-fluid" alt="">
                            <span class="navbar-brand-text">
                            The name
                            <small>of the page</small>
                        </span>
                        </a>

                        <div class="d-lg-none ms-auto me-3">
                            <a class="btn custom-btn custom-border-btn" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">Bejelentkezés</a>
                        </div>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav ms-lg-auto">
                                <li class="nav-item">
                                    <a class="nav-link click-scroll" href="index.php">Kezdőoldal</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link click-scroll" href="#section_2">Rólunk</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link click-scroll" href="#section_3">Időpontfoglalásaim</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link click-scroll" href="#section_4">Kiegészítők</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link click-scroll" href="#section_5">Contact Us</a>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Pages</a>

                                    <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                                        <li><a class="dropdown-item" href="event-listing.html">Event Listing</a></li>

                                        <li><a class="dropdown-item" href="event-detail.html">Event Detail</a></li>
                                    </ul>
                                </li>
                            </ul>

                            <div class="d-none d-lg-block ms-lg-3">
                                <a class="btn custom-btn custom-border-btn btn rounded-pill" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">Bejelentkezés</a>
                            </div>
                        </div>
                    </div>
                </nav>

<!--                LOGIN-->
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

<!--                    WAVES-->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#3D405B" fill-opacity="1" d="M0,224L34.3,192C68.6,160,137,96,206,90.7C274.3,85,343,139,411,144C480,149,549,107,617,122.7C685.7,139,754,213,823,240C891.4,267,960,245,1029,224C1097.1,203,1166,181,1234,160C1302.9,139,1371,117,1406,106.7L1440,96L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path></svg>
                </div>


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

    </div>

<!--        Content-->
        <div class="content flex">

        </div>

    <section id="section2" class="position-relative d-flex justify-content-center align-items-center" style="height: 100vh; background-color: #f0f0f0;">
        <!-- Bal oldali gombok -->
        <div class="position-absolute d-flex flex-column align-items-center justify-content-center" style="left: 0; top: 50%; transform: translateY(-50%); height: 300px;">
            <a href="page1.html" class="btn btn-primary rounded-circle mb-2" style="width: 60px; height: 60px;">1</a>
            <a href="page2.html" class="btn btn-primary rounded-circle mb-2" style="width: 60px; height: 60px;">2</a>
            <a href="page3.html" class="btn btn-primary rounded-circle" style="width: 60px; height: 60px;">3</a>
        </div>

        <!-- Középső kép -->
        <img src="images/index3.png" alt="middle_pic" class="img-fluid" style="max-height: 400px;">

        <!-- Jobb oldali gombok -->
        <div class="position-absolute d-flex flex-column align-items-center justify-content-center" style="right: 0; top: 50%; transform: translateY(-50%); height: 300px;">
            <a href="page4.html" class="btn btn-primary rounded-circle mb-2" style="width: 60px; height: 60px;">4</a>
            <a href="page5.html" class="btn btn-primary rounded-circle mb-2" style="width: 60px; height: 60px;">5</a>
            <a href="page6.html" class="btn btn-primary rounded-circle" style="width: 60px; height: 60px;">6</a>
        </div>
    </section>

<!--    About us-->
    <section class="events-section section-bg section-padding" id="section_4">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-12 mt-3">
                    <h2 class="mb-lg-3">Ismerje meg szakorvosainkat</h2>
                </div>

<!--                                        Doctor 1-->
                <div class="row custom-block mb-3">
                    <div class="col-lg-4 col-md-8 col-12 order-1 order-lg-0">
                        <div class="custom-block-image-wrap">
                                <img src="images/doctor1.jpg" class="custom-block-image img-fluid w-50" alt="doctor1_woman">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-12 order-2 order-md-0 order-lg-0">
                        <div class="custom-block-date-wrap d-flex d-lg-block d-md-block align-items-center mt-3 mt-lg-0 mt-md-0">
                            <div class="d-flex flex-wrap align-items-center">
                                <span class="custom-block-span">Munkaidő:</span>
                                <p class="mb-0 mt-3">
                                    H-P: 6:00–20:00<br>
                                    Sz-V: 7:00–17:00
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-12 order-3 order-lg-0">
                        <div class="custom-block-info mt-2 mt-lg-0  mb-5">
                            <h2 class="events-title mb-3">Dr. Kovács Ágnes</h2>

                            <p class="mb-0">Kisállatgyógyászat szakértő</p>

                            <div class="d-flex flex-wrap border-top mt-4 pt-3">

                                <p class="mb-0"><i>Több mint 15 éves tapasztalattal
                                        rendelkezik kutyák és macskák belgyógyászati,
                                        valamint megelőző ellátásában. Kedvessége és t
                                        ürelme miatt a gazdik és kisállataik is hamar bizalommal fordulnak hozzá.
                                        Kiemelten foglalkozik oltásokkal, táplálkozási tanácsadással és idősödő állatok gondozásával.
                                    </i></p>

                                <div class="mb-4 mb-lg-0">
                                    <div class="d-flex flex-wrap align-items-center mt-3 mb-1">
                                        <span class="custom-block-span">Email:</span>

                                        <p class="mb-0">kovacs.agnes@allatorvos.hu</p>
                                    </div>

                                    <div class="d-flex flex-wrap align-items-center mt-3">
                                        <span class="custom-block-span">Telefon:</span>

                                        <p class="mb-0">+36 30 123 4567</p>
                                    </div>


                        </div>
                        <div class="d-flex align-items-center ms-lg-auto">
                                    <a href="event-detail.html" class="btn custom-btn custom-border-btn btn rounded-pill">Foglalás</a>
                                </div>
                        </div>
                        </div>
                    </div>
                </div>


                <!--                Doctor 2-->
                <div class="row custom-block custom-block-bg mb-3">
                    <div class="col-lg-4 col-md-8 col-12 order-1 order-lg-0">
                        <div class="custom-block-image-wrap">
                            <img src="images/doctor2.jpg" class="custom-block-image img-fluid w-50" alt="">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-12 order-2 order-md-0 order-lg-0">

                        <div class="custom-block-date-wrap d-flex d-lg-block d-md-block align-items-center mt-3 mt-lg-0 mt-md-0">
                            <div class="d-flex flex-wrap align-items-center">
                                <span class="custom-block-span">Munkaidő:</span>
                                <p class="mb-0 mt-3">
                                    Hétfő, Szerda, Péntek: 12:00–20:00
                                </p>
                            </div>
                        </div>
                    </div>



                    <div class="col-lg-6 col-12 order-3 order-lg-0">
                        <div class="custom-block-info mt-2 mt-lg-0">
                            <h2 class="events-title mb-3">Dr. Nagy Emese</h2>

                            <p class="mb-0"> Egzotikus állatok szakértője</p>

                            <div class="d-flex flex-wrap border-top mt-4 pt-3">

                                <p class="mb-0"><i>Papagájok, hüllők, nyulak és rágcsálók
                                        egészségügyi ellátásában jártas. Szenvedélyesen
                                        kutatja az egzotikus fajok igényeit, így a
                                        legkülönlegesebb állatokkal is magabiztosan bánik.
                                        Az egzotikus páciensek gazdijai gyakran keresik fel
                                        országos szinten is.</i></p>

                                <div class="mb-4 mb-lg-0">
                                    <div class="d-flex flex-wrap align-items-center mt-3 mb-1">
                                        <span class="custom-block-span">Email:</span>

                                        <p class="mb-0">nagy.emese@allatorvos.hu</p>
                                    </div>

                                    <div class="d-flex flex-wrap align-items-center mt-3">
                                        <span class="custom-block-span">Telefon:</span>

                                        <p class="mb-0">+36 70 987 6543</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center ms-lg-auto">
                                    <a href="event-detail.html" class="btn custom-btn custom-border-btn btn rounded-pill">Foglalás</a>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>



            <!--                                        Doctor 3-->
            <div class="row custom-block mb-3">
                <div class="col-lg-4 col-md-8 col-12 order-1 order-lg-0">
                    <div class="custom-block-image-wrap">
                        <img src="images/doctor3.jpg" class="custom-block-image img-fluid w-50" alt="doctor1_woman">
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-12 order-2 order-md-0 order-lg-0">
                    <div class="custom-block-date-wrap d-flex d-lg-block d-md-block align-items-center mt-3 mt-lg-0 mt-md-0">
                        <div class="d-flex flex-wrap align-items-center">
                            <span class="custom-block-span">Munkaidő:</span>
                            <p class="mb-0 mt-3">
                                Kedd–Csütörtök: 10:00–18:00<br>
                                Szombat: 08:00–12:00
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-12 order-3 order-lg-0">
                    <div class="custom-block-info mt-2 mt-lg-0  mb-5">
                        <h2 class="events-title mb-3">Dr. Tóth Georgina</h2>

                        <p class="mb-0">Fogászat és belgyógyászat</p>

                        <div class="d-flex flex-wrap border-top mt-4 pt-3">

                            <p class="mb-0"><i>Kiemelkedő szakértelemmel rendelkezik
                                    kisállat-fogászati beavatkozásokban,
                                    beleértve a fogkő-eltávolítást,
                                    gyökérkezelést és szájhigiéniai tanácsadást is.
                                    Emellett belgyógyászati vizsgálatokkal segíti a
                                    diagnosztikát és kezelést.</i></p>

                            <div class="mb-4 mb-lg-0">
                                <div class="d-flex flex-wrap align-items-center mt-3 mb-1">
                                    <span class="custom-block-span">Email:</span>

                                    <p class="mb-0">toth.gina@allatorvos.hu</p>
                                </div>

                                <div class="d-flex flex-wrap align-items-center mt-3">
                                    <span class="custom-block-span">Telefon:</span>

                                    <p class="mb-0">+36 30 112 3344</p>
                                </div>


                            </div>
                            <div class="d-flex align-items-center ms-lg-auto">
                                <a href="event-detail.html" class="btn custom-btn custom-border-btn btn rounded-pill">Foglalás</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--                Doctor 2-->
            <div class="row custom-block custom-block-bg mb-3">
                <div class="col-lg-4 col-md-8 col-12 order-1 order-lg-0">
                    <div class="custom-block-image-wrap">
                        <img src="images/doctor2.jpg" class="custom-block-image img-fluid w-50" alt="">
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-12 order-2 order-md-0 order-lg-0">

                    <div class="custom-block-date-wrap d-flex d-lg-block d-md-block align-items-center mt-3 mt-lg-0 mt-md-0">
                        <div class="d-flex flex-wrap align-items-center">
                            <span class="custom-block-span">Munkaidő:</span>
                            <p class="mb-0 mt-3">
                                Hétfő, Szerda, Péntek: 12:00–20:00
                            </p>
                        </div>
                    </div>
                </div>



                <div class="col-lg-6 col-12 order-3 order-lg-0">
                    <div class="custom-block-info mt-2 mt-lg-0">
                        <h2 class="events-title mb-3">Dr. Nagy Emese</h2>

                        <p class="mb-0"> Egzotikus állatok szakértője</p>

                        <div class="d-flex flex-wrap border-top mt-4 pt-3">

                            <p class="mb-0"><i>Papagájok, hüllők, nyulak és rágcsálók
                                    egészségügyi ellátásában jártas. Szenvedélyesen
                                    kutatja az egzotikus fajok igényeit, így a
                                    legkülönlegesebb állatokkal is magabiztosan bánik.
                                    Az egzotikus páciensek gazdijai gyakran keresik fel
                                    országos szinten is.</i></p>

                            <div class="mb-4 mb-lg-0">
                                <div class="d-flex flex-wrap align-items-center mt-3 mb-1">
                                    <span class="custom-block-span">Email:</span>

                                    <p class="mb-0">nagy.emese@allatorvos.hu</p>
                                </div>

                                <div class="d-flex flex-wrap align-items-center mt-3">
                                    <span class="custom-block-span">Telefon:</span>

                                    <p class="mb-0">+36 70 987 6543</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-center ms-lg-auto">
                                <a href="event-detail.html" class="btn custom-btn custom-border-btn btn rounded-pill">Foglalás</a>
                            </div>
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
                    <a class="navbar-brand d-flex align-items-center" href="index.html">
                        <img src="images/logo.png" class="navbar-brand-image img-fluid" alt="">
                        <span class="navbar-brand-text">
                                name of the
                                <small>Page</small>
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
