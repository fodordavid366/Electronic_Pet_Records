document.addEventListener("DOMContentLoaded", () => {
    const navbarLinks = document.getElementById("navbarLinks");

    // check both storages
    const token = localStorage.getItem("jwt_token") || sessionStorage.getItem("jwt_token");

    if (token) {
        // logged in → show owner menu + logout
        navbarLinks.innerHTML = `
            <li class="nav-item">
                <a class="nav-link click-scroll" href="index.php">Kezdőoldal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link click-scroll" href="my_reservation.php">Időpontfoglalásaim</a>
            </li>
            <li class="nav-item">
                <a class="nav-link click-scroll" href="my_pets.php">Házi Kedvenceim</a>
            </li>
            <li class="nav-item">
                <a class="nav-link click-scroll" href="profile_modification.php">Időpontfoglalásaim</a>
            </li>
            <li class="nav-item">
                <a class="nav-link click-scroll" href="reservation.php">Időpontfoglalásaim</a>
            </li>
            <li class="nav-item">
                <a id="logoutBtn" href="logout.php" class="btn custom-btn custom-border-btn rounded-pill ms-lg-3 mt-2 mt-lg-0">
                    Kijelentkezés
                </a>
            </li>
            
        `;

    } else {
        // not logged in → show only guest menu
        navbarLinks.innerHTML = `
            <li class="nav-item">
                <a class="nav-link click-scroll" href="index.php">Kezdőoldal</a>
            </li>
            <li class="nav-item">
                <a class="btn custom-btn custom-border-btn rounded-pill ms-lg-3 mt-2 mt-lg-0" href="login.php">
                    Bejelentkezés
                </a>
            </li>
        `;
    }
});
