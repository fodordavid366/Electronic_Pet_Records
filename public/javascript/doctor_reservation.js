document.addEventListener("DOMContentLoaded", async function () {
    try {
        const res = await fetch('../api/vet_appointments.php', {
            credentials: "include" // fontos! küldje a cookie-t
        });

        if (!res.ok) {
            window.location.href = 'doctor_login.php';
            return;
        }

        const data = await res.json();
        const tbody = document.querySelector('#bookingsTable tbody');
        tbody.innerHTML = '';
        data.forEach(app => {
            const tr = document.createElement('tr');
            tr.dataset.description = app.description || '';
            tr.innerHTML = `
                <td class="name">${app.pet_name}</td>
                <td>${app.starts_at.split(' ')[0]}</td>
                <td>${app.starts_at.split(' ')[1]}</td>
                <td>${app.treatment_name}</td>
                <td>${app.status}</td>
                <td>
                    <button class="btn btn-info btn-sm">
                        <a class="btn btn-info btn-sm" style="text-decoration: none"
                           href="pets_information.php?appointment_id=${app.appointment_id}">
                           Megnyitás
                        </a>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        const table = new DataTable("#bookingsTable", {
            pageLength: 5,
            lengthChange: false
        });

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

    } catch (err) {
        console.error(err);
        alert("Hiba történt a foglalások betöltése során!");
    }
});
