document.addEventListener("DOMContentLoaded", async () => {
    const tableElement = document.getElementById("bookingsTable").getElementsByTagName('tbody')[0];
    let bookingsTable = null;

    function getToken() {
        return localStorage.getItem("jwt_token") || sessionStorage.getItem("jwt_token");
    }

    async function loadAppointments() {
        const res = await fetch("../api/appointments.php", {
            headers: { Authorization: `Bearer ${getToken()}` }
        });

        if (!res.ok) {
            alert("Nem sikerült betölteni a foglalásokat");
            return;
        }

        const appointments = await res.json();

        if (bookingsTable) {
            bookingsTable.destroy();
            bookingsTable = null;
        }

        tableElement.innerHTML = ""; // tbody törlése
        const now = new Date();

        appointments.forEach(app => {
            const tr = document.createElement("tr");
            tr.dataset.description = app.description || "";

            // Állat
            const tdPet = document.createElement("td");
            tdPet.textContent = app.pet_name || "";
            tdPet.classList.add("name");
            tr.appendChild(tdPet);

            // Orvos
            const tdVet = document.createElement("td");
            tdVet.textContent = app.vet_name || "";
            tr.appendChild(tdVet);

            // Dátum
            const tdDate = document.createElement("td");
            tdDate.textContent = app.starts_at.split(" ")[0];
            tr.appendChild(tdDate);

            // Időpont
            const tdTime = document.createElement("td");
            tdTime.textContent = app.starts_at.split(" ")[1].slice(0,5);
            tr.appendChild(tdTime);

            // Vizsgálat típusa
            const tdTreatment = document.createElement("td");
            tdTreatment.textContent = app.treatment_name || "";
            tr.appendChild(tdTreatment);

            // Állapot
            const tdStatus = document.createElement("td");
            tdStatus.textContent = app.status;
            tr.appendChild(tdStatus);

            // Művelet - Lemondás
            const tdAction = document.createElement("td");
            if (app.status === "booked") {
                const appointmentDate = new Date(app.starts_at);
                const diffHours = (appointmentDate - now) / (1000*60*60);
                if (diffHours > 1) {
                    const btn = document.createElement("button");
                    btn.textContent = "Lemondás";
                    btn.className = "btn btn-danger btn-sm cancel-btn";
                    btn.addEventListener("click", (e) => {
                        e.stopPropagation(); // ne nyíljon a modal
                        cancelAppointment(app.appointment_id);
                    });
                    tdAction.appendChild(btn);
                }
            }
            tr.appendChild(tdAction);

            // Jegyzet ikon
            const tdNote = document.createElement("td");
            const icon = document.createElement("i");
            icon.className = "bi bi-journal-text"; // Bootstrap Icons
            icon.style.cursor = "pointer";
            tdNote.appendChild(icon);
            tr.appendChild(tdNote);

            // Modal event az ikonra
            icon.addEventListener('click', (e) => {
                e.stopPropagation(); // a sor click ne fusson le
                const name = tr.querySelector('td.name').textContent;
                const description = tr.dataset.description || "Nincs jegyzet";

                document.getElementById('detailModalLabel').textContent = "Állatorvos jegyzete";
                document.getElementById('modalBody').innerHTML = `<p>${description}</p>`;

                const myModal = new bootstrap.Modal(document.getElementById('detailModal'));
                myModal.show();
            });

            tableElement.appendChild(tr);
        });

        bookingsTable = $("#bookingsTable").DataTable({
            pageLength: 5,
            lengthChange: false
        });
    }

    async function cancelAppointment(appointmentId) {
        if (!confirm("Biztosan le akarja mondani az időpontot?")) return;
        const res = await fetch("../api/appointments.php", {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${getToken()}`
            },
            body: JSON.stringify({ appointment_id: appointmentId })
        });

        const data = await res.json().catch(() => ({}));
        alert(data.message || "Hiba történt");

        loadAppointments();
    }

    loadAppointments();
});
