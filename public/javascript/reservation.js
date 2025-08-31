document.addEventListener("DOMContentLoaded", async () => {
    const petSelect = document.getElementById("petSelect");
    const treatmentSelect = document.getElementById("treatmentSelect");
    const dateInput = document.getElementById("dateInput");
    const slotsContainer = document.getElementById("slotsContainer");
    const generateBtn = document.getElementById("generateSlotsBtn");
    const bookBtn = document.getElementById("bookSlotBtn");

    let pets = [];
    let currentVetId = null;
    let selectedSlot = null;

    // Alapértelmezett rejtés a foglalás gombnak
    bookBtn.style.display = "none";

    function getToken() {
        return localStorage.getItem("jwt_token") || sessionStorage.getItem("jwt_token");
    }

    async function loadPets() {
        const res = await fetch("../api/pets.php", { headers: { Authorization: `Bearer ${getToken()}` } });
        if (!res.ok) return alert("Nem sikerült betölteni a kisállatokat");
        pets = await res.json();
        pets.forEach(p => {
            const opt = document.createElement("option");
            opt.value = p.pet_id;
            opt.textContent = p.name;
            petSelect.appendChild(opt);
        });
    }

    async function loadTreatments() {
        const res = await fetch("../api/treatments.php");
        if (!res.ok) return alert("Nem sikerült betölteni a kezeléseket");
        const treatments = await res.json();
        treatments.forEach(t => {
            const opt = document.createElement("option");
            opt.value = t.treatment_id;
            opt.textContent = `${t.name} (${t.duration_min} perc) (${t.cost} din)`;
            treatmentSelect.appendChild(opt);
        });
    }

    async function generateSlots() {
        const pet = pets.find(p => p.pet_id == petSelect.value);
        if (!pet) return alert("Válasszon egy kedvencet!");
        currentVetId = pet.vet_id;

        const date = dateInput.value;
        const treatmentId = treatmentSelect.value ;
        if (!date || !treatmentId || treatmentId === "0") return alert("Válasszon dátumot és kezelést!");

        slotsContainer.innerHTML = "Betöltés...";
        bookBtn.style.display = "none"; // gomb elrejtése, amíg betölt

        const res = await fetch(`../api/appointments.php?action=slots&vet_id=${currentVetId}&date=${date}&treatment_id=${treatmentId}`, {
            headers: { Authorization: `Bearer ${getToken()}` }
        });

        if (!res.ok) {
            slotsContainer.innerHTML = "Nincs elérhető időpont ezen a napon";
            return;
        }

        const data = await res.json();
        slotsContainer.innerHTML = "";

        if (data.available_slots.length === 0) {
            slotsContainer.innerHTML = "Nincs elérhető időpont";
            return;
        }

        data.available_slots.forEach((slot) => {
            const label = document.createElement("label");
            label.style.display = "block";
            const radio = document.createElement("input");
            radio.type = "radio";
            radio.name = "slot";
            radio.value = slot;
            radio.addEventListener("change", () => {
                selectedSlot = slot;
            });
            label.appendChild(radio);
            label.appendChild(document.createTextNode(" " + slot));
            slotsContainer.appendChild(label);
        });

        bookBtn.style.display = "inline-block"; // csak ha van időpont
    }

    async function bookSlot() {
        if (!currentVetId || !selectedSlot || !petSelect.value || !treatmentSelect.value || !dateInput.value) {
            return alert("Töltsön ki minden mezőt és válasszon időpontot!");
        }

        const payload = {
            pet_id: petSelect.value,
            vet_id: currentVetId,
            treatment_id: treatmentSelect.value,
            starts_at: `${dateInput.value} ${selectedSlot}:00`,
            description: ""
        };

        const res = await fetch("../api/appointments.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${getToken()}`
            },
            body: JSON.stringify(payload)
        });

        const data = await res.json().catch(() => ({}));
        alert(data.message || "Hiba történt");

        if (res.ok) {
            // Minden mező alaphelyzetbe
            petSelect.value = 0;
            treatmentSelect.value = 0;
            dateInput.value = "";
            slotsContainer.innerHTML = "";
            selectedSlot = null;
            currentVetId = null;
            bookBtn.style.display = "none"; // gomb elrejtése
        }
    }

    generateBtn.addEventListener("click", generateSlots);
    bookBtn.addEventListener("click", bookSlot);

    await loadPets();
    await loadTreatments();
});
