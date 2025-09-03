document.addEventListener("DOMContentLoaded", () => {
    const table = $("#bookingsTable").DataTable();
    const form = document.getElementById("registerForm");
    const vetIdInput = form.vet_id;

    let editingId = null;

    // Fetch all vets from backend
    async function loadVets() {
        const res = await fetch('../api/admin_vets.php', { credentials: 'same-origin' });
        const data = await res.json();
        if (!data.success) return;

        table.clear();
        data.vets.forEach(vet => {
            table.row.add([
                vet.vet_id,
                vet.last_name,
                vet.first_name,
                vet.email,
                "******",
                vet.birth_date,
                vet.phone_number,
                vet.specialization,
                `<button class="btn btn-sm btn-warning edit-btn" data-id="${vet.vet_id}"><i class="bi bi-pencil"></i> Módosítás</button>`,
                `<button class="btn btn-sm btn-danger delete-btn" data-id="${vet.vet_id}"><i class="bi bi-trash"></i> Törlés</button>`
            ]);
        });
        table.draw();
        attachRowButtons();
    }

    function attachRowButtons() {
        document.querySelectorAll(".edit-btn").forEach(btn => {
            btn.onclick = async () => {
                const id = parseInt(btn.dataset.id);
                const res = await fetch(`../api/admin_vets.php?id=${id}`, { credentials: 'same-origin' });
                const data = await res.json();
                if (!data.success) return;

                const vet = data.vets[0];
                editingId = vet.vet_id;

                // Fill form except password
                vetIdInput.value = vet.vet_id;
                form.lastname.value = vet.last_name;
                form.firstname.value = vet.first_name;
                form.email.value = vet.email;
                form.phone.value = vet.phone_number;
                form.birth_date.value = vet.birth_date;
                form.specialization.value = vet.specialization;
                form.password.value = "";
            };
        });

        document.querySelectorAll(".delete-btn").forEach(btn => {
            btn.onclick = async () => {
                const id = parseInt(btn.dataset.id);
                if (!confirm("Biztosan törölni szeretné az orvost?")) return;

                await fetch('../api/admin_vets.php', {
                    method: 'DELETE',
                    credentials: 'same-origin',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id })
                });

                loadVets();
            };
        });
    }

    form.addEventListener("submit", async e => {
        e.preventDefault();

        const vetData = {
            id: vetIdInput.value ? parseInt(vetIdInput.value) : null,
            last_name: form.lastname.value.trim(),
            first_name: form.firstname.value.trim(),
            email: form.email.value.trim(),
            phone_number: form.phone.value.trim(),
            birth_date: form.birth_date.value,
            specialization: form.specialization.value.trim(),
            password: form.password.value
        };
        console.log(vetData)
        if (!vetData.id && (!vetData.last_name || !vetData.first_name || !vetData.email || !vetData.phone_number || !vetData.birth_date || !vetData.specialization || !vetData.password)) {
            alert("Kérlek töltsd ki az összes mezőt új orvos létrehozásához!");
            return;
        }

        const method = vetData.id ? 'PUT' : 'POST';
        await fetch('../api/admin_vets.php', {
            method,
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(vetData)
        });

        form.reset();
        vetIdInput.value = "";
        editingId = null;
        loadVets();
    });

    loadVets();
});
