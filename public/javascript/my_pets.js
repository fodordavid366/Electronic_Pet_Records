document.addEventListener("DOMContentLoaded", async () => {
    const select = document.getElementById("pets");
    const form = document.getElementById("registerForm");

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

        // Select feltöltése
        select.innerHTML = `<option value="new">Új kisállat hozzáadása</option>`;
        pets.forEach(p => {
            const opt = document.createElement("option");
            opt.value = p.pet_id; // itt a fontos változtatás
            opt.textContent = p.name;
            select.appendChild(opt);
        });
    }

    async function loadVets(selectedVetId = 0) {
        try {
            const res = await fetch("../api/vets.php");
            if (!res.ok) throw new Error("Hiba az orvosok lekérésekor");

            const vets = await res.json();
            doctorSelect.innerHTML = ''; // előző törlése

            // Alap opció
            const defaultOption = document.createElement("option");
            defaultOption.value = 0;
            defaultOption.textContent = "Válasszon doktort";
            doctorSelect.appendChild(defaultOption);

            // Orvosok feltöltése
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


    // Állat kiválasztás → form kitöltése
    select.addEventListener("change", async () => {
        if (select.value === "new") {
            currentPetId = null;
            form.reset();
            await loadVets(); // új kisállat → alap opció
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
    });


    // Mentés
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const token = getToken();
        if (!token) {
            alert("Nincs bejelentkezve!");
            return;
        }

        const payload = {
            pet_id: currentPetId,
            name: nameInput.value,
            gender: genderInput.value,
            birth_date: birthInput.value,
            species: speciesInput.value,
            breed: breedInput.value,
            vet_id: doctorSelect.value // vet_id
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
            if (method === "POST") select.value = "new";
            else select.value = currentPetId;
        }
    });

    await loadPets();
    await loadVets();
});
