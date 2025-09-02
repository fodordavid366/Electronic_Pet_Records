document.addEventListener("DOMContentLoaded", async () => {
    const select = document.getElementById("pets");
    const form = document.getElementById("registerForm");
    const deleteButton = document.getElementById("deletePet");

    const nameInput = document.getElementById("name");
    const genderInput = document.getElementById("gender");
    const birthInput = document.getElementById("birth_date");
    const speciesInput = document.getElementById("species");
    const breedInput = document.getElementById("breed");
    const doctorSelect = document.getElementById("doctor");

    let pets = [];
    let currentPetId = null;

    function getToken() {
        return localStorage.getItem("jwt_token") || sessionStorage.getItem("jwt_token");
    }

    async function loadPets() {
        const token = getToken();
        if (!token) {
            alert("Nincs bejelentkezve!");
            return;
        }

        const res = await fetch("../api/pets.php", {
            method: "GET",
            headers: {
                "Authorization": `Bearer ${token}`
            }
        });

        if (!res.ok) {
            const err = await res.json().catch(() => ({}));
            alert("Hiba: " + (err.message || res.status));
            return;
        }

        pets = await res.json();

        select.innerHTML = `<option value="new">Új kisállat hozzáadása</option>`;
        pets.forEach(p => {
            const opt = document.createElement("option");
            opt.value = p.pet_id;
            opt.textContent = p.name;
            select.appendChild(opt);
        });

        updateDeleteButton();
    }

    async function loadVets(selectedVetId = 0) {
        try {
            const res = await fetch("../api/vets.php");
            if (!res.ok) throw new Error("Hiba az orvosok lekérésekor");

            const vets = await res.json();
            doctorSelect.innerHTML = '';

            const defaultOption = document.createElement("option");
            defaultOption.value = 0;
            defaultOption.textContent = "Válasszon doktort";
            doctorSelect.appendChild(defaultOption);

            vets.forEach(vet => {
                const opt = document.createElement("option");
                opt.value = vet.vet_id;
                opt.textContent = vet.first_name + " " + vet.last_name;
                if (vet.vet_id === selectedVetId) opt.selected = true;
                doctorSelect.appendChild(opt);
            });
        } catch (err) {
            console.error(err);
            alert("Hiba az orvosok betöltésekor");
        }
    }

    function updateDeleteButton() {
        deleteButton.style.display = currentPetId ? "block" : "none";
    }

    select.addEventListener("change", async () => {
        if (select.value === "new") {
            currentPetId = null;
            form.reset();
            await loadVets();
        } else {
            const pet = pets.find(p => String(p.pet_id) === select.value);
            if (pet) {
                currentPetId = pet.pet_id;
                nameInput.value = pet.name || "";
                genderInput.value = pet.gender || "";
                birthInput.value = pet.birth_date || "";
                speciesInput.value = pet.species || "";
                breedInput.value = pet.breed || "";
                await loadVets(pet.vet_id);
            }
        }
        updateDeleteButton();
        if (select.value !== "new") {
            const qrImg = document.getElementById("petQR");
            const downloadLink = document.getElementById("downloadQR");
            qrImg.src = `../api/generate_qr.php?pet_id=${select.value}`;
            qrImg.style.display = "block";

            downloadLink.href = qrImg.src;
            downloadLink.style.display = "inline-block";
            console.log(qrImg);
        } else {
            document.getElementById("petQR").style.display = "none";
            document.getElementById("downloadQR").style.display = "none";
        }
    });

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const token = getToken();
        if (!token) {
            alert("Nincs bejelentkezve!");
            return;
        }

        // Validáció
        if (!nameInput.value.trim() || !genderInput.value || !birthInput.value ||
            !speciesInput.value.trim() || !breedInput.value.trim() || doctorSelect.value === "0") {
            alert("Minden mező kitöltése kötelező, és válasszon doktort!");
            return;
        }

        const payload = {
            pet_id: currentPetId,
            name: nameInput.value.trim(),
            gender: genderInput.value,
            birth_date: birthInput.value,
            species: speciesInput.value.trim(),
            breed: breedInput.value.trim(),
            vet_id: doctorSelect.value
        };

        const url = "../api/pets.php";
        const method = currentPetId ? "PUT" : "POST";

        const res = await fetch(url, {
            method,
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${token}`
            },
            body: JSON.stringify(payload)
        });

        const data = await res.json().catch(() => ({}));
        alert(data.message || "Ismeretlen hiba");

        if (res.ok) {
            await loadPets();
            if (method === "POST" && data.pet_id) {
                // új pet → állítsuk be currentPetId-t és maradjon a formban az adat
                currentPetId = data.pet_id;
                select.value = data.pet_id;
            } else {
                select.value = currentPetId;
            }
            updateDeleteButton();
        }
    });

    deleteButton.addEventListener("click", async () => {
        if (!currentPetId) return;
        if (!confirm("Biztosan törölni szeretnéd ezt a kisállatot?")) return;

        const token = getToken();
        const res = await fetch(`../api/pets.php?pet_id=${currentPetId}`, {
            method: "DELETE",
            headers: {
                "Authorization": `Bearer ${token}`
            }
        });

        const data = await res.json().catch(() => ({}));
        alert(data.message || "Ismeretlen hiba");

        if (res.ok) {
            await loadPets();
            select.value = "new";
            form.reset();
            currentPetId = null;
            updateDeleteButton();
        }
    });

    await loadPets();
    await loadVets();
});
