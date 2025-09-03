document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registerForm");
    const tableBody = document.querySelector("#bookingsTable tbody");

    async function loadOwners() {
        const res = await fetch("../api/admin_owners.php?action=list");
        const owners = await res.json();

        tableBody.innerHTML = "";
        owners.forEach(o => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${o.owner_id}</td>
                <td>${o.last_name}</td>
                <td>${o.first_name}</td>
                <td>${o.email}</td>
                <td>${o.birth_date}</td>
                <td>${o.phone_number}</td>
                <td>${o.is_banned === 1 ? 1 : 0}</td>
                <td class="text-center"><button class="btn btn-sm btn-warning edit-btn" data-id="${o.owner_id}"><i class="bi bi-pencil"></i></button></td>
                <td class="text-center"><button class="btn btn-sm btn-danger delete-btn" data-id="${o.owner_id}"><i class="bi bi-trash"></i></button></td>
            `;
            tableBody.appendChild(tr);
        });
    }

    // Handle edit → load into form
    tableBody.addEventListener("click", (e) => {
        if (e.target.closest(".edit-btn")) {
            const tr = e.target.closest("tr");
            document.getElementById("vet_id").value = tr.children[0].innerText; // ID
            document.getElementById("lastname").value = tr.children[1].innerText;
            document.getElementById("firstname").value = tr.children[2].innerText;
            document.getElementById("email").value = tr.children[3].innerText;
            document.getElementById("birth_date").value = tr.children[4].innerText;
            document.getElementById("phone").value = tr.children[5].innerText;
            document.getElementById("banned").checked = tr.children[6].innerText === 1;
        }
    });

    // Handle update (form submit)
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const owner = {
            id: document.getElementById("vet_id").value,
            last_name: document.getElementById("lastname").value,
            first_name: document.getElementById("firstname").value,
            email: document.getElementById("email").value,
            phone: document.getElementById("phone").value,
            birth_date: document.getElementById("birth_date").value,
            banned: document.getElementById("banned").checked ? 1 : 0
        };

        const res = await fetch("../api/admin_owners.php?action=update", {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(owner)
        });

        const data = await res.json();
        if (data.success) {
            alert("Sikeresen frissítve");
            form.reset();
            loadOwners();
        } else {
            alert(data.message || "Hiba történt");
        }
    });

    // Handle delete
    tableBody.addEventListener("click", async (e) => {
        if (e.target.closest(".delete-btn")) {
            const id = e.target.closest(".delete-btn").dataset.id;
            if (confirm("Biztos törölni szeretnéd?")) {
                const res = await fetch(`../api/admin_owners.php?action=delete&id=${id}`, { method: "DELETE" });
                const data = await res.json();
                if (data.success) {
                    loadOwners();
                } else {
                    alert(data.message || "Hiba történt");
                }
            }
        }
    });

    // Load owners on page load
    loadOwners();
});
