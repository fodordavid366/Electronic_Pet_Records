<form id="setNewPasswordForm">
    <div class="mb-3">
        <label for="new_password" class="form-label">Új jelszó</label>
        <input type="password" id="new_password" class="form-control" placeholder="Új jelszó" required>
    </div>
    <div class="mb-3">
        <label for="new_password_verify" class="form-label">Új jelszó ismét</label>
        <input type="password" id="new_password_verify" class="form-control" placeholder="Új jelszó ismét" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Jelszó módosítása</button>
    <div id="alertBox" class="d-none mt-3"></div>
</form>

<script src="javascript/reset_password.js"></script>
