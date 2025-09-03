document.addEventListener("DOMContentLoaded", async () => {
    const form = document.getElementById("loginForm");
    const alertBox = document.getElementById("loginAlert");

    try {
        const res = await fetch('../api/vet_schedule.php', { credentials: 'include' });
        if (res.ok) {
            const schedules = await res.json();
            const weekdays = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
            schedules.forEach(s => {
                const dayName = weekdays[s.weekday - 1];
                document.querySelector(`[name="${dayName}_start"]`).value = s.start_time;
                document.querySelector(`[name="${dayName}_end"]`).value = s.end_time;
                document.querySelector(`[name="${dayName}_number"]`).value = s.slot_minutes;
            });
        }
    } catch (err) {
        console.error('Hiba a munkarend betöltésénél', err);
    }

    form.addEventListener('submit', async e => {
        e.preventDefault();
        const formData = new FormData(form);

        try {
            const res = await fetch('../api/vet_schedule.php', {
                method: 'POST',
                credentials: 'include',
                body: formData
            });

            const result = await res.json();
            alertBox.classList.remove('d-none', 'alert-success', 'alert-danger');

            if (res.ok) {
                alertBox.classList.add('alert-success');
                alertBox.textContent = result.message;
            } else {
                alertBox.classList.add('alert-danger');
                alertBox.textContent = result.message;
            }

        } catch (err) {
            alertBox.classList.remove('d-none', 'alert-success');
            alertBox.classList.add('alert-danger');
            alertBox.textContent = 'Hiba a mentés során: ' + err.message;
        }
    });
});
